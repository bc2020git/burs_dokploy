<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\OtpSetting;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['status'] = 'Aktif';
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $settings = OtpSetting::first();
            if ($settings?->admin_otp_status) {
                $user = Auth::user();
                if ($user) {
                    $otp = rand(1000, 9999);

                    // Preserve intended url then require OTP before completing login
                    $intendedUrl = $request->session()->get('url.intended');

                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    $request->session()->put([
                        'admin_otp_pending' => true,
                        'admin_otp_user_id' => $user->id,
                        'admin_otp_email' => $user->email,
                        'admin_otp_code' => (string) $otp,
                        'admin_otp_expires_at' => now()->addMinutes(5)->timestamp,
                    ]);

                    if (is_string($intendedUrl) && $intendedUrl !== '') {
                        $request->session()->put('url.intended', $intendedUrl);
                    }

                    (new MailController())->sendMailOtp(
                        (string) $user->email,
                        'Girişinizi Onaylayınız',
                        'mailtemplates.sendotp',
                        [
                            'name' => (string) ($user->name ?? ''),
                            'surname' => (string) ($user->surname ?? ''),
                            'code' => (string) $otp,
                        ]
                    );

                    return redirect()->route('admin.otp.show')->with('success', 'OTP gönderildi. Lütfen e-postanızı kontrol edin.');
                }
            }

            return redirect()->intended($this->redirectTo);
        }

        $user = Auth::getProvider()->retrieveByCredentials([
            'email' => $request->email
        ]);

        if ($user && $user->status === 'Pasif') {
            throw ValidationException::withMessages([
                'email' => ['Hesabınız pasif durumdadır. Lütfen yönetici ile iletişime geçin.'],
            ]);
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
