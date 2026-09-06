<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Transaction as LedgerTransaction;
use App\Models\UserCoupon;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction as PayPalTransaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalController extends Controller
{
    private $_api_context;
    protected $invoiceData;

    public function setApiContext()
    {
        if (Auth::check()) {
            $payment_setting = Utility::getAdminPaymentSetting();
        } else {
            if (!$this->invoiceData) {
                throw new \RuntimeException('Invoice context is required for PayPal configuration.');
            }

            $payment_setting = Utility::getCompanyPaymentSetting($this->invoiceData->created_by);
        }

        $clientId = isset($payment_setting['paypal_client_id']) ? $payment_setting['paypal_client_id'] : '';
        $secretKey = isset($payment_setting['paypal_secret_key']) ? $payment_setting['paypal_secret_key'] : '';
        $mode = isset($payment_setting['paypal_mode']) ? $payment_setting['paypal_mode'] : 'sandbox';

        if (empty($clientId) || empty($secretKey)) {
            throw new \RuntimeException('PayPal is not configured.');
        }

        $this->_api_context = new ApiContext(new OAuthTokenCredential($clientId, $secretKey));
        $this->_api_context->setConfig(['mode' => $mode]);

        return $this;
    }

    private function expectedPlanPrice(Plan $plan, $couponId = null)
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

    private function amountsMatch($expected, $actual)
    {
        return abs(round((float) $expected, 2) - round((float) $actual, 2)) < 0.01;
    }

    private function invoiceRedirect(Invoice $invoice, $type, $message)
    {
        return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with($type, $message);
    }

    public function planPayWithPaypal(Request $request)
    {
        try {
            $planID = Crypt::decrypt($request->plan_id);
        } catch (\Exception $e) {
            return redirect()->route('plans.index')->with('error', __('Invalid plan.'));
        }

        $plan = Plan::find($planID);
        $user = Auth::user();
        if (!$plan || !$user) {
            return redirect()->route('plans.index')->with('error', __('Plan is deleted.'));
        }

        $coupon = null;
        $price = (float) $plan->price;
        if (!empty($request->coupon)) {
            $coupon = Coupon::where('code', strtoupper(trim($request->coupon)))->where('is_active', '1')->first();
            if (!$coupon) {
                return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
            }

            list($price, $coupon) = $this->expectedPlanPrice($plan, $coupon->id);
            if ($price === null) {
                return redirect()->back()->with('error', __('This coupon code has expired.'));
            }
        }

        if ($price <= 0) {
            $assignPlan = $user->assignPlan($plan->id);
            if (!$assignPlan['is_success']) {
                return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
            }

            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            Order::create([
                'order_id' => $orderID,
                'name' => $user->name,
                'card_number' => '',
                'card_exp_month' => '',
                'card_exp_year' => '',
                'plan_name' => $plan->name,
                'plan_id' => $plan->id,
                'price' => 0,
                'price_currency' => env('CURRENCY', 'USD'),
                'txn_id' => '',
                'payment_type' => __('PAYPAL'),
                'payment_status' => 'succeeded',
                'receipt' => 'free coupon',
                'user_id' => $user->id,
            ]);

            if ($coupon) {
                $userCoupon = new UserCoupon();
                $userCoupon->user = $user->id;
                $userCoupon->coupon = $coupon->id;
                $userCoupon->order = $orderID;
                $userCoupon->save();
            }

            return redirect()->route('plans.index')->with('success', __('Plan activated Successfully.'));
        }

        try {
            $this->setApiContext();
            $currency = strtoupper((string) env('CURRENCY', 'USD'));
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item = new Item();
            $item->setName($plan->name)->setCurrency($currency)->setQuantity(1)->setPrice($price);

            $itemList = new ItemList();
            $itemList->setItems([$item]);

            $amount = new Amount();
            $amount->setCurrency($currency)->setTotal($price);

            $transaction = new PayPalTransaction();
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription($plan->name)
                ->setInvoiceNumber($orderID);

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('plan.get.payment.status', $plan->id))
                ->setCancelUrl(route('plan.get.payment.status', $plan->id));

            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);
            $payment->create($this->_api_context);

            Session::put('paypal_plan_payment_context', [
                'payment_id' => $payment->getId(),
                'plan_id' => $plan->id,
                'amount' => round((float) $price, 2),
                'currency' => $currency,
                'coupon_id' => $coupon ? $coupon->id : null,
                'order_id' => $orderID,
                'user_id' => $user->id,
            ]);

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() === 'approval_url') {
                    return Redirect::away($link->getHref());
                }
            }

            return redirect()->route('plans.index')->with('error', __('Unknown error occurred'));
        } catch (\Exception $e) {
            return redirect()->route('plans.index')->with('error', __('Unable to start PayPal payment.'));
        }
    }

    public function planGetPaymentStatus(Request $request, $plan_id)
    {
        $user = Auth::user();
        $plan = Plan::find($plan_id);
        $context = Session::pull('paypal_plan_payment_context');

        if (!$user || !$plan || !is_array($context)) {
            return redirect()->route('plans.index')->with('error', __('Invalid or expired payment session.'));
        }

        if ((int) ($context['plan_id'] ?? 0) !== (int) $plan->id ||
            (int) ($context['user_id'] ?? 0) !== (int) $user->id ||
            empty($context['payment_id'])) {
            return redirect()->route('plans.index')->with('error', __('Invalid payment session.'));
        }

        if (empty($request->PayerID) || empty($request->token)) {
            return redirect()->route('plans.index')->with('error', __('Payment cancelled or failed.'));
        }

        try {
            $this->setApiContext();
            $paymentId = $context['payment_id'];

            if (Order::where('txn_id', $paymentId)->exists()) {
                return redirect()->route('plans.index')->with('error', __('This transaction has already been processed.'));
            }

            $payment = Payment::get($paymentId, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($request->PayerID);
            $result = $payment->execute($execution, $this->_api_context)->toArray();

            if (($result['state'] ?? '') !== 'approved') {
                return redirect()->route('plans.index')->with('error', __('Payment was not approved.'));
            }

            $gatewayAmount = $result['transactions'][0]['amount']['total'] ?? null;
            $gatewayCurrency = strtoupper((string) ($result['transactions'][0]['amount']['currency'] ?? ''));
            $expectedAmount = round((float) ($context['amount'] ?? -1), 2);
            $expectedCurrency = strtoupper((string) ($context['currency'] ?? ''));

            if ($gatewayAmount === null ||
                !$this->amountsMatch($expectedAmount, $gatewayAmount) ||
                $gatewayCurrency !== $expectedCurrency) {
                return redirect()->route('plans.index')->with('error', __('Payment verification failed. Amount or currency did not match.'));
            }

            list($serverPrice, $coupon) = $this->expectedPlanPrice($plan, $context['coupon_id'] ?? null);
            if ($serverPrice === null || !$this->amountsMatch($serverPrice, $gatewayAmount)) {
                return redirect()->route('plans.index')->with('error', __('Payment no longer matches the selected plan.'));
            }

            DB::transaction(function () use ($paymentId, $plan, $user, $coupon, $gatewayAmount, $gatewayCurrency, $context) {
                if (Order::where('txn_id', $paymentId)->lockForUpdate()->exists()) {
                    throw new \RuntimeException('Transaction already processed.');
                }

                $orderID = !empty($context['order_id']) ? $context['order_id'] : strtoupper(str_replace('.', '', uniqid('', true)));

                Order::create([
                    'order_id' => $orderID,
                    'name' => $user->name,
                    'card_number' => '',
                    'card_exp_month' => '',
                    'card_exp_year' => '',
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id,
                    'price' => round((float) $gatewayAmount, 2),
                    'price_currency' => $gatewayCurrency,
                    'txn_id' => $paymentId,
                    'payment_type' => __('PAYPAL'),
                    'payment_status' => 'approved',
                    'receipt' => '',
                    'user_id' => $user->id,
                ]);

                if ($coupon) {
                    $userCoupon = new UserCoupon();
                    $userCoupon->user = $user->id;
                    $userCoupon->coupon = $coupon->id;
                    $userCoupon->order = $orderID;
                    $userCoupon->save();

                    $usedCoupon = $coupon->used_coupon();
                    if ($coupon->limit > 0 && $usedCoupon >= $coupon->limit) {
                        $coupon->is_active = 0;
                        $coupon->save();
                    }
                }
            });

            $assignPlan = $user->assignPlan($plan->id);
            if ($assignPlan['is_success']) {
                return redirect()->route('plans.index')->with('success', __('Plan activated Successfully.'));
            }

            return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
        } catch (\Exception $e) {
            return redirect()->route('plans.index')->with('error', __('Transaction has been failed.'));
        }
    }

    public function customerPayWithPaypal(Request $request, $invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        if (!$invoice) {
            return redirect()->back()->with('error', __('Invoice is deleted.'));
        }

        $request->validate(['amount' => 'required|numeric|gt:0']);
        $requestedAmount = round((float) $request->amount, 2);
        $due = round((float) $invoice->getDue(), 2);
        if ($requestedAmount > $due) {
            return redirect()->back()->with('error', __('Invalid amount.'));
        }

        $this->invoiceData = $invoice;
        $settings = DB::table('settings')->where('created_by', '=', $invoice->created_by)->get()->pluck('value', 'name');

        try {
            $this->setApiContext();
            $currency = strtoupper((string) Utility::getValByName('site_currency'));
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            $name = Utility::invoiceNumberFormat($settings, $invoice->invoice_id);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item = new Item();
            $item->setName($name)->setCurrency($currency)->setQuantity(1)->setPrice($requestedAmount);

            $itemList = new ItemList();
            $itemList->setItems([$item]);

            $amount = new Amount();
            $amount->setCurrency($currency)->setTotal($requestedAmount);

            $transaction = new PayPalTransaction();
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription($name)
                ->setInvoiceNumber($orderID);

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('customer.get.payment.status', $invoice->id))
                ->setCancelUrl(route('customer.get.payment.status', $invoice->id));

            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);
            $payment->create($this->_api_context);

            Session::put('paypal_invoice_payment_context', [
                'payment_id' => $payment->getId(),
                'invoice_id' => $invoice->id,
                'amount' => $requestedAmount,
                'currency' => $currency,
                'order_id' => $orderID,
            ]);

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() === 'approval_url') {
                    return Redirect::away($link->getHref());
                }
            }

            return redirect()->back()->with('error', __('Unknown error occurred'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Unable to start PayPal payment.'));
        }
    }

    public function customerGetPaymentStatus(Request $request, $invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        if (!$invoice) {
            return redirect()->back()->with('error', __('Invoice is deleted.'));
        }

        $context = Session::pull('paypal_invoice_payment_context');
        if (!is_array($context) ||
            (int) ($context['invoice_id'] ?? 0) !== (int) $invoice->id ||
            empty($context['payment_id'])) {
            return $this->invoiceRedirect($invoice, 'error', __('Invalid or expired payment session.'));
        }

        if (empty($request->PayerID) || empty($request->token)) {
            return $this->invoiceRedirect($invoice, 'error', __('Payment cancelled or failed.'));
        }

        $this->invoiceData = $invoice;
        $settings = DB::table('settings')->where('created_by', '=', $invoice->created_by)->get()->pluck('value', 'name');

        try {
            $this->setApiContext();
            $paymentId = $context['payment_id'];

            if (InvoicePayment::where('txn_id', $paymentId)->exists()) {
                return $this->invoiceRedirect($invoice, 'error', __('This transaction has already been processed.'));
            }

            $payment = Payment::get($paymentId, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($request->PayerID);
            $result = $payment->execute($execution, $this->_api_context)->toArray();

            if (($result['state'] ?? '') !== 'approved') {
                return $this->invoiceRedirect($invoice, 'error', __('Payment was not approved.'));
            }

            $gatewayAmount = $result['transactions'][0]['amount']['total'] ?? null;
            $gatewayCurrency = strtoupper((string) ($result['transactions'][0]['amount']['currency'] ?? ''));
            $expectedAmount = round((float) ($context['amount'] ?? -1), 2);
            $expectedCurrency = strtoupper((string) ($context['currency'] ?? ''));
            $due = round((float) $invoice->getDue(), 2);

            if ($gatewayAmount === null ||
                !$this->amountsMatch($expectedAmount, $gatewayAmount) ||
                $gatewayCurrency !== $expectedCurrency ||
                (float) $gatewayAmount <= 0 ||
                (float) $gatewayAmount > $due) {
                return $this->invoiceRedirect($invoice, 'error', __('Payment verification failed. Amount or currency did not match.'));
            }

            $verifiedAmount = round((float) $gatewayAmount, 2);
            $orderID = !empty($context['order_id']) ? $context['order_id'] : strtoupper(str_replace('.', '', uniqid('', true)));

            $payments = DB::transaction(function () use ($invoice, $verifiedAmount, $gatewayCurrency, $paymentId, $orderID, $settings) {
                if (InvoicePayment::where('txn_id', $paymentId)->lockForUpdate()->exists()) {
                    throw new \RuntimeException('Transaction already processed.');
                }

                return InvoicePayment::create([
                    'invoice_id' => $invoice->id,
                    'date' => date('Y-m-d'),
                    'amount' => $verifiedAmount,
                    'account_id' => 0,
                    'payment_method' => 0,
                    'order_id' => $orderID,
                    'currency' => $gatewayCurrency,
                    'txn_id' => $paymentId,
                    'payment_type' => __('PAYPAL'),
                    'receipt' => '',
                    'reference' => '',
                    'description' => 'Invoice ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                ]);
            });

            $invoice = Invoice::find($invoice->id);
            if ($invoice->getDue() <= 0) {
                $invoice->status = 4;
            } else {
                $invoice->status = 3;
            }
            $invoice->save();

            $invoicePayment = new LedgerTransaction();
            $invoicePayment->user_id = $invoice->customer_id;
            $invoicePayment->user_type = 'Customer';
            $invoicePayment->type = 'PAYPAL';
            $invoicePayment->created_by = $invoice->created_by;
            $invoicePayment->category = 'Invoice';
            $invoicePayment->amount = $verifiedAmount;
            $invoicePayment->date = date('Y-m-d');
            $invoicePayment->payment_id = $payments->id;
            $invoicePayment->description = 'Invoice ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id);
            $invoicePayment->account = 0;
            LedgerTransaction::addTransaction($invoicePayment);

            Utility::userBalance('customer', $invoice->customer_id, $verifiedAmount, 'debit');

            $setting = Utility::settings($invoice->created_by);
            $customer = Customer::find($invoice->customer_id);
            if ($customer) {
                if (isset($setting['payment_notification']) && $setting['payment_notification'] == 1) {
                    $msg = __('New payment of') . ' ' . $verifiedAmount . __('created for') . ' ' . $customer->name . __('by') . ' ' . $invoicePayment->type . '.';
                    Utility::send_slack_msg($msg);
                }

                if (isset($setting['telegram_payment_notification']) && $setting['telegram_payment_notification'] == 1) {
                    $msg = __('New payment of') . ' ' . $verifiedAmount . __('created for') . ' ' . $customer->name . __('by') . ' ' . $invoicePayment->type . '.';
                    Utility::send_telegram_msg($msg);
                }

                if (isset($setting['twilio_payment_notification']) && $setting['twilio_payment_notification'] == 1) {
                    $msg = __('New payment of') . ' ' . $verifiedAmount . __('created for') . ' ' . $customer->name . __('by') . ' ' . $invoicePayment->type . '.';
                    Utility::send_twilio_msg($customer->contact, $msg);
                }
            }

            return $this->invoiceRedirect($invoice, 'success', __('Payment successfully added'));
        } catch (\Exception $e) {
            return $this->invoiceRedirect($invoice, 'error', __('Transaction has been failed.'));
        }
    }
}
