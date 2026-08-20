<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOtpController extends Controller
{
    public function show(Request $request)
    {
        if (! $request->session()->get('admin_otp_pending')) {
            return redirect()->route('login');
        }

        $email = (string) $request->session()->get('admin_otp_email', '');

        return view('auth.admin.otp', [
            'email' => $this->obfuscateEmail($email),
        ]);
    }

    public function verify(Request $request)
    {
        if (! $request->session()->get('admin_otp_pending')) {
            return redirect()->route('login');
        }

        $request->validate([
            'otp1' => ['required', 'digits:1'],
            'otp2' => ['required', 'digits:1'],
            'otp3' => ['required', 'digits:1'],
            'otp4' => ['required', 'digits:1'],
        ]);

        $otp = $request->otp1.$request->otp2.$request->otp3.$request->otp4;
        $expected = (string) $request->session()->get('admin_otp_code', '');
        $expiresAt = (int) $request->session()->get('admin_otp_expires_at', 0);

        if ($expected === '' || $expiresAt === 0 || time() > $expiresAt) {
            $this->clearOtpSession($request);
            return redirect()->route('login')->withErrors(['otp' => 'OTP süresi doldu. Lütfen tekrar giriş yapın.']);
        }

        if (! hash_equals($expected, (string) $otp)) {
            return back()->with('error', 'OTP kodu geçersiz');
        }

        $userId = (int) $request->session()->get('admin_otp_user_id', 0);
        if ($userId <= 0) {
            $this->clearOtpSession($request);
            return redirect()->route('login')->withErrors(['otp' => 'Oturum doğrulanamadı. Lütfen tekrar giriş yapın.']);
        }

        $this->clearOtpSession($request);
        Auth::loginUsingId($userId);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function resend(Request $request)
    {
        if (! $request->session()->get('admin_otp_pending')) {
            return redirect()->route('login');
        }

        $email = (string) $request->session()->get('admin_otp_email', '');
        $userId = (int) $request->session()->get('admin_otp_user_id', 0);

        if ($email === '' || $userId <= 0) {
            $this->clearOtpSession($request);
            return redirect()->route('login')->withErrors(['otp' => 'Oturum doğrulanamadı. Lütfen tekrar giriş yapın.']);
        }

        $otp = rand(1000, 9999);

        $request->session()->put([
            'admin_otp_code' => (string) $otp,
            'admin_otp_expires_at' => now()->addMinutes(5)->timestamp,
        ]);

        $user = \App\Models\User::find($userId);

        (new MailController())->sendMailOtp(
            $email,
            'Girişinizi Onaylayınız',
            'mailtemplates.sendotp',
            [
                'name' => (string) ($user?->name ?? ''),
                'surname' => (string) ($user?->surname ?? ''),
                'code' => (string) $otp,
            ]
        );

        return back()->with('success', 'OTP tekrar gönderildi. Lütfen e-postanızı kontrol edin.');
    }

    private function clearOtpSession(Request $request): void
    {
        $request->session()->forget([
            'admin_otp_pending',
            'admin_otp_user_id',
            'admin_otp_email',
            'admin_otp_code',
            'admin_otp_expires_at',
        ]);
    }

    private function obfuscateEmail(string $email): string
    {
        if ($email === '' || ! str_contains($email, '@')) {
            return $email;
        }

        $atPosition = strpos($email, '@');
        $visible = min(5, max(1, $atPosition));
        $firstPart = substr($email, 0, $visible);
        $starLength = max(0, $atPosition - $visible);
        $stars = str_repeat('*', $starLength);
        $domain = substr($email, $atPosition);

        return $firstPart.$stars.$domain;
    }
}

