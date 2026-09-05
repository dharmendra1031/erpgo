<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Models\Utility;
use App\Models\Vender;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function __construct()
    {
        // Installer/guest behavior is retained for compatibility with the legacy app.
    }

    public function create()
    {
        // Intentionally unused by this application.
    }

    public function store(LoginRequest $request)
    {
        $validation = [];
        if (env('RECAPTCHA_MODULE') === 'yes') {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }
        $this->validate($request, $validation);

        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        if ((isset($user->delete_status) && (int) $user->delete_status === 0)
            || (isset($user->is_active) && (int) $user->is_active === 0)) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => [__('Your account is inactive.')],
            ]);
        }

        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
        ]);

        if ($user->type === 'employee') {
            return redirect()->intended(RouteServiceProvider::EMPHOME);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showCustomerLoginForm($lang = '')
    {
        $lang = $this->resolveLanguage($lang);
        \App::setLocale($lang);

        return view('auth.customer_login', compact('lang'));
    }

    public function customerLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('customer')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();

            if ((int) Auth::guard('customer')->user()->is_active === 0) {
                Auth::guard('customer')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['email' => __('Your account is inactive.')])
                    ->withInput($request->only('email'));
            }

            $user = Auth::guard('customer')->user();
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
            ]);

            return redirect()->route('customer.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => [__('These credentials do not match our records.')],
        ]);
    }

    public function showVenderLoginForm($lang = '')
    {
        $lang = $this->resolveLanguage($lang);
        \App::setLocale($lang);

        return view('auth.vender_login', compact('lang'));
    }

    public function venderLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('vender')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();

            if ((int) Auth::guard('vender')->user()->is_active === 0) {
                Auth::guard('vender')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['email' => __('Your account is inactive.')])
                    ->withInput($request->only('email'));
            }

            $user = Auth::guard('vender')->user();
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
            ]);

            return redirect()->route('vender.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => [__('These credentials do not match our records.')],
        ]);
    }

    public function showLoginForm($lang = '')
    {
        $lang = $this->resolveLanguage($lang);
        \App::setLocale($lang);
        $settings = Utility::settings();

        return view('auth.login', compact('lang', 'settings'));
    }

    public function showLinkRequestForm($lang = '')
    {
        $lang = $this->resolveLanguage($lang);
        \App::setLocale($lang);

        return view('auth.forgot-password', compact('lang'));
    }

    public function showCustomerLoginLang($lang = '')
    {
        return $this->showCustomerLoginForm($lang);
    }

    public function showVenderLoginLang($lang = '')
    {
        return $this->showVenderLoginForm($lang);
    }

    public function showCustomerLinkRequestForm($lang = '')
    {
        $lang = $this->resolveLanguage($lang);
        \App::setLocale($lang);

        return view('auth.passwords.customerEmail', compact('lang'));
    }

    public function postCustomerEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ]);

        $token = Str::random(64);
        $this->storeResetToken($request->email, $token);

        Mail::send('auth.customerVerify', ['token' => $token], function ($message) use ($request) {
            $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('status', 'We have e-mailed your password reset link!');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $defaultLanguage = DB::table('settings')
            ->select('value')
            ->where('name', 'default_language')
            ->first();
        $lang = !empty($defaultLanguage) ? $defaultLanguage->value : 'en';

        \App::setLocale($lang);

        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
            'lang' => $lang,
        ]);
    }

    public function getCustomerPassword($token)
    {
        return view('auth.passwords.customerReset', ['token' => $token]);
    }

    public function updateCustomerPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        if (!$this->validResetToken($request->email, $request->token)) {
            return back()->withInput($request->only('email'))->with('error', 'Invalid or expired token!');
        }

        Customer::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        $this->deleteResetToken($request->email, $request->token);

        return redirect()->route('customer.login')
            ->with('message', 'Your password has been changed.');
    }

    public function showVendorLinkRequestForm($lang = '')
    {
        $lang = $this->resolveLanguage($lang);
        \App::setLocale($lang);

        return view('auth.passwords.vendorEmail', compact('lang'));
    }

    public function postVendorEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:venders,email',
        ]);

        $token = Str::random(64);
        $this->storeResetToken($request->email, $token);

        Mail::send('auth.vendorVerify', ['token' => $token], function ($message) use ($request) {
            $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('status', 'We have e-mailed your password reset link!');
    }

    public function getVendorPassword($token)
    {
        return view('auth.passwords.vendorReset', ['token' => $token]);
    }

    public function updateVendorPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:venders,email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        if (!$this->validResetToken($request->email, $request->token)) {
            return back()->withInput($request->only('email'))->with('error', 'Invalid or expired token!');
        }

        Vender::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        $this->deleteResetToken($request->email, $request->token);

        return redirect()->route('vender.login')
            ->with('message', 'Your password has been changed.');
    }

    private function resolveLanguage($lang)
    {
        return $lang === '' ? Utility::getValByName('default_language') : $lang;
    }

    private function storeResetToken($email, $token)
    {
        DB::table('password_resets')->where('email', $email)->delete();
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => hash('sha256', $token),
            'created_at' => Carbon::now(),
        ]);
    }

    private function validResetToken($email, $token)
    {
        return DB::table('password_resets')
            ->where('email', $email)
            ->where('token', hash('sha256', $token))
            ->where('created_at', '>=', Carbon::now()->subMinutes(60))
            ->exists();
    }

    private function deleteResetToken($email, $token)
    {
        DB::table('password_resets')
            ->where('email', $email)
            ->where('token', hash('sha256', $token))
            ->delete();
    }
}
