<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserCoupon;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RazorpayPaymentController extends Controller
{
    public $secret_key;
    public $public_key;
    public $is_enabled;
    protected $invoiceData;

    public function paymentConfig()
    {
        if (\Auth::check()) {
            $payment_setting = Utility::getAdminPaymentSetting();
        } else {
            if (!$this->invoiceData) {
                throw new \RuntimeException('Invoice context is required for payment configuration.');
            }
            $payment_setting = Utility::getCompanyPaymentSetting($this->invoiceData->created_by);
        }

        $this->secret_key = isset($payment_setting['razorpay_secret_key']) ? $payment_setting['razorpay_secret_key'] : '';
        $this->public_key = isset($payment_setting['razorpay_public_key']) ? $payment_setting['razorpay_public_key'] : '';
        $this->is_enabled = isset($payment_setting['is_razorpay_enabled']) ? $payment_setting['is_razorpay_enabled'] : 'off';

        return $this;
    }

    private function getExpectedPlanPrice(Plan $plan, $couponId = null)
    {
        $price = (float) $plan->price;
        $coupon = null;

        if (!empty($couponId)) {
            $coupon = Coupon::where('id', $couponId)->where('is_active', '1')->first();
            if (!$coupon) {
                return [null, null];
            }

            $usedCoupon = $coupon->used_coupon();
            if ($coupon->limit > 0 && $usedCoupon >= $coupon->limit) {
                return [null, null];
            }

            $discountValue = ($price / 100) * $coupon->discount;
            $price = max(0, $price - $discountValue);
        }

        return [round($price, 2), $coupon];
    }

    private function fetchPayment($payId)
    {
        if (empty($this->public_key) || empty($this->secret_key)) {
            return null;
        }

        $ch = curl_init('https://api.razorpay.com/v1/payments/' . rawurlencode($payId));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_USERPWD, $this->public_key . ':' . $this->secret_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $body = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$body || $httpCode < 200 || $httpCode >= 300) {
            return null;
        }

        $payment = json_decode($body);
        return is_object($payment) ? $payment : null;
    }

    private function isVerifiedCapturedPayment($payment, $expectedAmount, $expectedCurrency)
    {
        if (!$payment || ($payment->status ?? '') !== 'captured') {
            return false;
        }

        $actualAmount = (int) ($payment->amount ?? -1);
        $expectedMinorAmount = (int) round(((float) $expectedAmount) * 100);
        if ($actualAmount !== $expectedMinorAmount) {
            return false;
        }

        return strtoupper((string) ($payment->currency ?? '')) === strtoupper((string) $expectedCurrency);
    }

    public function planPayWithRazorpay(Request $request)
    {
        $planID = Crypt::decrypt($request->plan_id);
        $plan = Plan::find($planID);
        $authuser = \Auth::user();
        $coupon_id = '';

        if (!$plan) {
            return Utility::error_res(__('Plan is deleted.'));
        }

        $price = $plan->price;
        if (isset($request->coupon) && !empty($request->coupon)) {
            $request->coupon = trim($request->coupon);
            $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
            if (!empty($coupons)) {
                $usedCoupon = $coupons->used_coupon();
                $discount_value = ($price / 100) * $coupons->discount;
                $plan->discounted_price = $price - $discount_value;

                if ($coupons->limit > 0 && $usedCoupon >= $coupons->limit) {
                    return redirect()->back()->with('error', __('This coupon code has expired.'));
                }
                $price = max(0, $price - $discount_value);
                $coupon_id = $coupons->id;
            } else {
                return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
            }
        }

        if ($price <= 0) {
            $assignPlan = $authuser->assignPlan($plan->id);
            if ($assignPlan['is_success'] == true) {
                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                Order::create([
                    'order_id' => $orderID,
                    'name' => null,
                    'email' => null,
                    'card_number' => null,
                    'card_exp_month' => null,
                    'card_exp_year' => null,
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id,
                    'price' => 0,
                    'price_currency' => !empty(env('CURRENCY')) ? env('CURRENCY') : 'USD',
                    'txn_id' => '',
                    'payment_type' => 'Razorpay',
                    'payment_status' => 'succeeded',
                    'receipt' => null,
                    'user_id' => $authuser->id,
                ]);

                if ($coupon_id) {
                    $userCoupon = new UserCoupon();
                    $userCoupon->user = $authuser->id;
                    $userCoupon->coupon = $coupon_id;
                    $userCoupon->order = $orderID;
                    $userCoupon->save();
                }

                return ['msg' => __('Plan successfully upgraded.'), 'flag' => 2];
            }

            return Utility::error_res(__('Plan fail to upgrade.'));
        }

        return [
            'email' => Auth::user()->email,
            'total_price' => round((float) $price, 2),
            'currency' => env('CURRENCY', 'USD'),
            'flag' => 1,
            'coupon' => $coupon_id,
        ];
    }

    public function getPaymentStatus(Request $request, $pay_id, $plan)
    {
        $user = \Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', __('Please login to complete the payment.'));
        }

        try {
            $this->paymentConfig();
            $planID = Crypt::decrypt($plan);
        } catch (\Exception $e) {
            return redirect()->route('plans.index')->with('error', __('Invalid payment request.'));
        }

        $planModel = Plan::find($planID);
        if (!$planModel) {
            return redirect()->route('plans.index')->with('error', __('Plan not found.'));
        }

        list($expectedPrice, $coupon) = $this->getExpectedPlanPrice($planModel, $request->coupon_id);
        if ($expectedPrice === null) {
            return redirect()->route('plans.index')->with('error', __('Coupon is invalid or has expired.'));
        }

        if (Order::where('txn_id', $pay_id)->exists()) {
            return redirect()->route('plans.index')->with('error', __('This transaction has already been processed.'));
        }

        try {
            $payment = $this->fetchPayment($pay_id);
            $currency = env('CURRENCY', 'USD');
            if (!$this->isVerifiedCapturedPayment($payment, $expectedPrice, $currency)) {
                return redirect()->route('plans.index')->with('error', __('Payment verification failed. Amount, currency or capture status did not match.'));
            }

            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

            DB::transaction(function () use ($pay_id, $planModel, $user, $coupon, $payment, $orderID, $expectedPrice, $currency) {
                if (Order::where('txn_id', $pay_id)->lockForUpdate()->exists()) {
                    throw new \RuntimeException('Transaction already processed.');
                }

                if ($coupon) {
                    $userCoupon = new UserCoupon();
                    $userCoupon->user = $user->id;
                    $userCoupon->coupon = $coupon->id;
                    $userCoupon->order = $orderID;
                    $userCoupon->save();

                    $usedCoupon = $coupon->used_coupon();
                    if ($coupon->limit > 0 && $coupon->limit <= $usedCoupon) {
                        $coupon->is_active = 0;
                        $coupon->save();
                    }
                }

                Order::create([
                    'order_id' => $orderID,
                    'name' => $user->name,
                    'card_number' => '',
                    'card_exp_month' => '',
                    'card_exp_year' => '',
                    'plan_name' => $planModel->name,
                    'plan_id' => $planModel->id,
                    'price' => $expectedPrice,
                    'price_currency' => strtoupper($currency),
                    'txn_id' => $payment->id ?? $pay_id,
                    'payment_type' => __('Razorpay'),
                    'payment_status' => 'captured',
                    'receipt' => '',
                    'user_id' => $user->id,
                ]);
            });

            $assignPlan = $user->assignPlan($planModel->id, $request->payment_frequency);
            if ($assignPlan['is_success']) {
                return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
            }

            return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
        } catch (\Exception $e) {
            return redirect()->route('plans.index')->with('error', __('Transaction has been failed.'));
        }
    }

    public function customerPayWithRazorpay(Request $request)
    {
        try {
            $invoiceID = Crypt::decrypt($request->invoice_id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Invalid invoice.'));
        }

        $invoice = Invoice::find($invoiceID);
        if (!$invoice) {
            return redirect()->back()->with('error', __('Invoice is deleted.'));
        }

        $user = User::find($invoice->created_by);
        $price = round((float) $request->amount, 2);
        $due = round((float) $invoice->getDue(), 2);

        if ($price <= 0 || $price > $due) {
            return ['msg' => __('Enter valid amount.'), 'flag' => 2];
        }

        return [
            'email' => $user ? $user->email : '',
            'total_price' => $price,
            'currency' => Utility::getValByName('site_currency'),
            'flag' => 1,
        ];
    }

    public function getInvoicePaymentStatus(Request $request, $pay_id, $invoice_id)
    {
        try {
            $invoiceID = Crypt::decrypt($invoice_id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Invalid invoice.'));
        }

        $invoice = Invoice::find($invoiceID);
        if (!$invoice) {
            return redirect()->back()->with('error', __('Invoice is deleted.'));
        }

        $this->invoiceData = $invoice;
        $settings = DB::table('settings')->where('created_by', '=', $invoice->created_by)->get()->pluck('value', 'name');

        try {
            $this->paymentConfig();

            if (InvoicePayment::where('txn_id', $pay_id)->exists()) {
                return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('This transaction has already been processed.'));
            }

            $payment = $this->fetchPayment($pay_id);
            if (!$payment || ($payment->status ?? '') !== 'captured') {
                return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('Payment is not captured.'));
            }

            $currency = Utility::getValByName('site_currency');
            if (strtoupper((string) ($payment->currency ?? '')) !== strtoupper((string) $currency)) {
                return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('Payment currency mismatch.'));
            }

            $verifiedAmount = round(((int) ($payment->amount ?? 0)) / 100, 2);
            $due = round((float) $invoice->getDue(), 2);
            if ($verifiedAmount <= 0 || $verifiedAmount > $due) {
                return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('Invalid verified payment amount.'));
            }

            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

            $payments = DB::transaction(function () use ($invoice, $verifiedAmount, $currency, $pay_id, $orderID, $settings) {
                if (InvoicePayment::where('txn_id', $pay_id)->lockForUpdate()->exists()) {
                    throw new \RuntimeException('Transaction already processed.');
                }

                return InvoicePayment::create([
                    'invoice_id' => $invoice->id,
                    'date' => date('Y-m-d'),
                    'amount' => $verifiedAmount,
                    'payment_method' => 1,
                    'order_id' => $orderID,
                    'currency' => strtoupper($currency),
                    'txn_id' => $pay_id,
                    'payment_type' => __('Razorpay'),
                    'receipt' => '',
                    'description' => __('Invoice') . ' ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                ]);
            });

            $invoice = Invoice::find($invoice->id);
            if ($invoice->getDue() <= 0) {
                Invoice::change_status($invoice->id, 4);
            } else {
                Invoice::change_status($invoice->id, 3);
            }

            $setting = Utility::settings($invoice->created_by);
            $customer = Customer::find($invoice->customer_id);
            if ($customer) {
                if (isset($setting['payment_notification']) && $setting['payment_notification'] == 1) {
                    $msg = __('New payment of') . ' ' . $verifiedAmount . __('created for') . ' ' . $customer->name . __('by') . ' ' . __('Razorpay') . '.';
                    Utility::send_slack_msg($msg);
                }

                if (isset($setting['telegram_payment_notification']) && $setting['telegram_payment_notification'] == 1) {
                    $msg = __('New payment of') . ' ' . $verifiedAmount . __('created for') . ' ' . $customer->name . __('by') . ' ' . __('Razorpay') . '.';
                    Utility::send_telegram_msg($msg);
                }

                if (isset($setting['twilio_payment_notification']) && $setting['twilio_payment_notification'] == 1) {
                    $msg = __('New payment of') . ' ' . $verifiedAmount . __('created for') . ' ' . $customer->name . __('by') . ' ' . $payments['payment_type'] . '.';
                    Utility::send_twilio_msg($customer->contact, $msg);
                }
            }

            return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('success', __('Payment successfully added.'));
        } catch (\Exception $e) {
            return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('Transaction has been failed.'));
        }
    }
}
