<?php

// app/Http/Controllers/StudentAuthController.php

namespace App\Http\Controllers;
use App\Models\NewAnswer;
use App\Models\NewDocuments;
use App\Models\SoruKategori;
use Illuminate\Support\Str;

use App\Models\OtpCode;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aday;
use App\Models\Scholar;
use App\Models\ResetLink;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MessageController;
use App\Models\OtpSetting;
class StudentAuthController extends Controller
{
    protected $mailController;
    protected $messageController;

    public function __construct()
    {
        $this->mailController = new MailController();
        $this->messageController = new MessageController();
    }

    public function newLogin(Request $request){
    }
    public function newLoginForm(){
        return view('auth.student.active.student-login');
    }

    public function loginChechAfterNew(Request $request){
        $email = trim((string) $request->email);
        $password = md5($request->password);
        $user = Scholar::where('email', $email)->where('password', $password)->first();
        if ($user){
            Auth::guard('bursiyer')->login($user);
            session(['user_type' => 'bursiyer']);
            return $this->otpGonder($user);
        }
        if (! $user) {
        $aday = NewAnswer::where('email', $email)
            ->where('password', $password)
            ->first();
        if($aday){
            $user = NewAnswer::find($aday->id);
            Auth::guard('aday')->login($user);
            session(['user_type' => 'aday']);
            return $this->otpGonder($aday);
            return redirect()->route('findmy_relations_forms');
        }}

            session()->flash('error', 'Bilgiler Yanlis');
            return redirect()->route('student.active.login');

    }
    public function otpGonder($bursiyer){
        $aday = $bursiyer;
        $otp = rand(1000, 9999);
        session(['otp' => $otp, 'user_id' => $aday->id, 'email' => $aday->email]);

        $this->mailController->sendMailOtp(
            $aday->email,
            'Otp Kodunuzu Giriniz',
            'mailtemplates.sendotp',
            [
                'email' => $aday->email,
                'name' => $aday->name,
                'surname' => $aday->surname,
                'code' => $otp,
            ]
        );

        OtpCode::create([
            'code' => $otp,
            'session' => $aday->id
        ]);

        return redirect()->route('aday.otp2.verify')->with('success', 'OTP gönderildi. Lütfen kontrol edin.');
    }

    public function logoutall(){
                Auth::guard('aday')->logout();
                Auth::guard('bursiyer')->logout();
        return view('auth.student.active.student-login');
    }
    public function otptekrargonder(){
        $otp = rand(1000, 9999);
        session(['otp' => $otp]);
        $email = session('email');
        $name = session('name');
        $surname = session('surname');
        $user_id = session('user_id');

        $this->mailController->sendMail(
            $email,
            'SACDD Burs - OTP',
            'mailtemplates.sendotp',
            [
                'name' => $name,
                'surname' => $surname,
                'code' => $otp,
                'email' => $email
            ]
        );

        OtpCode::create([
            'code' => $otp,
            'session' => $user_id
        ]);

        return redirect()->back();
    }
    public function verifyOtp(Request $request)
        {
            $otp = $request->otp1.$request->otp2.$request->otp3.$request->otp4;
            $sessionOtp = session('otp');
            $userId = session('user_id');

            if ($otp == $sessionOtp) {
                // OTP doğruysa kullanıcıyı giriş yap
                $user = NewAnswer::find($userId);
                Auth::guard('aday')->login($user);
                // dd() kaldırıldı
                $this->otpKoduSil($otp);
                return redirect()->route('student_select_type');
            }
                        session()->flash('error', 'OTP kodu geçersiz');

           return $this->adayOtpFormuAc();
        }
        public function adayLogin(Request $request)
        {
            $donem = Period::where('status',1)->where('type',0)->first();
            if(!$donem){
                session()->flash('error', 'Başvuru Dönemi Aktif Değildir');

                return redirect()->route('aday.login.view');

            }

            $tc_no = $request->tc_no;
            $email = $request->email;

            // Kullanıcının sistemde mevcut olup olmadığını kontrol et
            $user = NewAnswer::where('tc_no', $tc_no)->
            where('period_id',$donem->id)
                ->first();
$scholar = Scholar::where('tc_no',$tc_no)->first();
            $email_check = NewAnswer::where('email', $email)->where('period_id',$donem->id)->first();
            if ($user || $email_check || $scholar) {
            session()->flash('error', 'Kaydiniz mevcut. Lutfen Giris yapiniz');

                return redirect()->route('student.active.login');
            }
            else {

                    $password = Str::random(8);
                    $hashpassword= md5($password);
                    // Kullanıcı mevcut değilse yeni kullanıcı oluştur
                    $user = NewAnswer::create([
                        'name' => $request->name,
                        'surname' => $request->surname,
                        'email' => $email,
                        'tc_no' => $tc_no,
                        'tel_no' => $request->tel_no,
                        'period_id' => $this->basvuruAktifDonemGetir(),
                        'status' => 0,
                        'password' => $hashpassword
                    ]);
                    $otp_settings = OtpSetting::first();
                    if(!$otp_settings->otp_status){
                        $user =  $user;
                        session(['user_type' => 'aday']);
                        Auth::guard('aday')->login($user);
                        return redirect()->route('student_select_type');
                    }
                        $aday =  $user;
                    // OTP Kodu oluştur
                    $otp = rand(1000, 9999);
                    session(['otp' => $otp, 'user_id' => $user->id,'email'=>$user->email,'name'=>$user->name,'surname'=>$user->surname]);
                    OtpCode::create([
                        'code'=> $otp,
                        'session' => $user->id
                    ]);

                    $mailCheck = $this->mailController->sendMail(
                        $aday->email,
                        'SACDD Burs - OTP',
                        'mailtemplates.sendotp',
                        [
                            'name' => $aday->name,
                            'surname' => $aday->surname,
                            'code' => $otp,
                            'email' => $aday->email
                        ]
                    );
                    if($mailCheck){
                        OtpCode::create([
                            'code'=> $otp,
                            'session' => $user->id
                        ]);
                    }
                    Auth::guard('aday')->login($user);
                    return $this->adayOtpFormuAc();
                }

        }

    public function adayOtpFormuAc(){

        $email = session('email');
        $email = $this->obfuscateEmail($email);

        return view('auth.student.new.otp-authentication', compact('email'));
    }
    public function adayTekrarGirisOtpFormuAc(){
        $email = session('email');
        $email = $this->obfuscateEmail($email);

        return view('auth.student.new.otp-authentication2', compact('email'));
    }

    public function otpKoduKontrol($code){
        $otp = OtpCode::where('code',$code)->first();
        $currentTimestamp = Carbon::now();
        $kodGecerliligi = $otp->created_at;
        if(!$kodGecerliligi->lessThan($currentTimestamp->subMinutes(5))){
            $this->otpKoduSil($code);
        }
    }
    public function sifremiUnuttum(){
        return view('auth.student.send-password-reset');
    }
    public function sifirlamaMailiGonder(Request $request){
        $email = $request->email;
        $aday = NewAnswer::where('email', $email)->first();
        $check = false;
        if ($aday) {
            $password = Str::random(8);
            $hashpassword = md5($password);
            $result = NewAnswer::where('email', $email)->update(['password' => $hashpassword]);
            if ($result) {
                $check = true;
                $this->mailController->sendTemplateEmail(
                    'sifre-yenileme-mesaji',
                    $aday->email,
                    'Şifreniz Sıfırlanmıştır',
                    [
                        'name' => $aday->name,
                        'surname' => $aday->surname,
                        'password' => $password,
                        'email' => $aday->email
                    ]
                );
            }
        }
        $ky = Scholar::where('email',$email)->first();
        if($ky){
            $check = true;
            $password = Str::random(8);
            $hashpassword = md5($password);
            $result = Scholar::where('email', $email)->update(['password' => $hashpassword]);
            if($result){
                $this->mailController->sendTemplateEmail(
                    'sifre-yenileme-mesaji',
                    $ky->email,
                    'Şifre Sıfırlamanız Gerçekleştirilmiştir.',
                    [
                        'name' => $ky->name,
                        'surname' => $ky->surname,
                        'password' => $password,
                        'email' => $ky->email
                    ]
                );
            }
        }
        if($check){
            session()->flash('success', 'Şifre Sıfırlandı');
        }
        else{
            session()->flash('error', 'Eposta Sistemde Kayitli Degil');
        }
        return redirect()->route('student.active.login');
    }

    public function otpKoduSil($code){
        OtpCode::where('code', $code)->delete();

    }
    public function verifyOtp2(Request $request)
    {
        $otp = $request->otp1.$request->otp2.$request->otp3.$request->otp4;
        // Session'da saklanan OTP'yi al
        $sessionOtp = session('otp');
        $userId = session('user_id');
        $usertype = session('user_type');

        if ($otp == $sessionOtp) {
            switch ($usertype) {
                case 'bursiyer':
                    $user = Scholar::find($userId);
                    Auth::guard('bursiyer')->login($user);
                    break;
                case 'aday':
                    $user = NewAnswer::find($userId);
                    Auth::guard('aday')->login($user);
                    break;
            }
            // OTP doğruysa kullanıcıyı giriş yap


            $this->otpKoduSil($otp);
            return redirect()->route('findmy_relations_forms');
        }
        else {
            $this->otpKoduSil($otp);
            return redirect()->route('aday.login.view');
        }
    }
    public function aktifLogin(Request $request)
    {
        $credentials = $request->only('email', 'tc_no');

        if (Auth::guard('aktif')->attempt($credentials)) {
            // Giriş başarılı
            return redirect()->intended('/aktif-dashboard');
        }

        // Giriş başarısız
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function mezunLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('mezun')->attempt($credentials)) {
            // Giriş başarılı
            return redirect()->intended('/mezun-dashboard');
        }

        // Giriş başarısız
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function adayLoginForm()
    {
        $kategoriler = SoruKategori::where('siralama',1)  // 'form_type' içinde $tip değeri varsa
        ->with([
            'soru' => function($query) {
                $query->where('on_register_form',1)  // 'form_type' içinde $tip değeri varsa
                ->where('status', 'Aktif')
                    ->orderBy('siralama', 'asc');},
        ])
            ->where('status','Aktif')
            ->orderBy('siralama','asc')
            ->first();

        Auth::guard('aday')->logout();
        Auth::guard('bursiyer')->logout();
        return view('auth.student.new.student-login',compact('kategoriler'));
    }
    public function showLoginForm()
    {
        Auth::guard('aday')->logout();
        return view('auth.student.active.student-login');
    }
    public function newStudentForgotPassword()
    {
        return view('auth.student.active.forgot-password');

    }
    public function login(Request $request)
    {
        $password = md5($request->password);

        $aday = NewAnswer::where('email', $request->email)
            ->where('password',$password)
            ->first();
        if ($aday){
            $otp = rand(1000, 9999);
            session(['otp' => $otp, 'user_id' => $aday->id,'email'=>$aday->email]);
                session(['aday_name' => $aday->name]);
                session(['aday_surname' => $aday->surname]);
                session(['aday_name' => $aday->id]);

            $this->mailController->sendMail(
                $aday->email,
                'SACDD Burs - OTP',
                'mailtemplates.sendotp',
                [
                    'name' => $aday->name,
                    'surname' => $aday->surname,
                    'code' => $otp,
                    'email' => $aday->email
                ]
            );

            OtpCode::create([
                'code' => $otp,
                'session' => $aday->id
            ]);

            return redirect()->route('aday.otp2.verify')->with('success', 'OTP gönderildi. Lütfen kontrol edin.');
            }
            return redirect()->route('student.active.login');


    }

    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect('/student/login');
    }
    function obfuscateEmail($email) {
        $atPosition = strpos($email, '@');
        $firstPart = substr($email, 0, 5);
        $starLength = $atPosition - 5;
        $stars = str_repeat('*', $starLength);
        $domain = substr($email, $atPosition);
        return $firstPart . $stars . $domain;
    }
    public function aktifDonemGetir()
    {
        $donem = Period::where('status',1)->first();
        return  $donem->id;
    }
    public function basvuruAktifDonemGetir()
    {
        $donem = Period::where('status',1)->where('type',0)->first();
        if(!$donem){
            return redirect()->route('aday.login.view');
            session()->flash('error', 'Bilgiler Yanlis');

        }
        return $donem->id;
    }
}
