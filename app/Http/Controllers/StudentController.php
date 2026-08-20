<?php

namespace App\Http\Controllers;
use App\Models\NewAnswer;
use App\Models\RenewAnswer;
use App\Models\Soru;
use App\Models\SoruKategori;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\Aday;
use App\Models\Il;
use App\Models\Period;
use App\Models\RenewForm;
use App\Models\Scholar;
use App\Models\Univercity;
use App\Models\ScholarForm;
use App\Models\UnivercitysYukseklisans;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\MailController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Schema;
use App\Models\PeriodEducationTypes;
class StudentController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $mailController;

    public function __construct()
    {
        $this->formController = new FormController();
        $this->ortakController = new OrtakController();
        $this->messageController = new MessageController();
        $this->mailController = new MailController();
    }
        public function hashpass($a){
        $hashedString = Hash::make($a);
        echo $hashedString;
    }
     public function kayitYenilemeFormuGonder($id){
        $forms = RenewForm::where('id',$id)->first();
        if (!$forms) {
            session()->flash('error', 'Form bulunamadı.');
            return redirect()->route('findmy_relations_forms');
        }

        $activePeriod = Period::where('id', $forms->period_id)->where('type', 1)->where('is_started', 1)->where('status', 1)->first();
        if (!$activePeriod) {
            $scholar = Scholar::find($forms->scholar_id);
            $educationType = $scholar->form->infos->educationType ?? null;
            if ($educationType) {
                $activePeriod = Period::where('type', 1)->where('is_started', 1)->where('status', 1)
                    ->whereHas('types', function ($q) use ($educationType) {
                        $q->where('educationType', $educationType);
                    })->first();
            }
        }

        if (!$activePeriod) {
            session()->flash('error', 'Kayıt yenileme dönemi aktif değildir.');
            return redirect()->route('findmy_relations_forms');
        }

        $forms->status = 4;
        $forms->save();
        $answers = RenewAnswer::where('form_id',$id)->first();
        if($answers && $answers->status != 2){
            RenewAnswer::where('form_id',$id)->update(['status'=>1]);
        }
        elseif($answers){
            RenewAnswer::where('form_id',$id)->update(['status'=>5]);
        }
        return redirect()->route('findmy_relations_forms');
     }
    public function application_form_associate()
    {
        return view('student/application-form-associate');
    }

    public function sendNotificationNotCompleteds(){
        $forms = NewAnswer::where('status',0)->get();

        $currentTimestamp = Carbon::now();
        foreach($forms as $form){
            $formtime = Carbon::parse($form->created_at);
            if(!$formtime->lessThan($currentTimestamp->subMinutes(30))  && $form->passsent == 0){
               $password = Str::random(8);
               $hashpassword= md5($password);
               $form->password = $hashpassword;
               $form->passsent = 1;
               $form->save();

            }
        }

    }
    public function basvuruTamamla(){

        $user= NewAnswer::where('tc_no',Auth::guard('aday')->user()->tc_no)->first();
        if($user->passsent == 0){
            //$this->puanhesapla($user->tc_no);
            $password = Str::random(8);
                $hashpassword= md5($password);
                $user->password = $hashpassword;
                $user->passsent = 1;
                $user->status = 1;
                $result = $user->save();
                // Yeni template sistemi ile mail gönder
                try {
                    $parameters = [
                        'ad' => $user->name,
                        'soyad' => $user->surname,
                        'password' => $password,
                        'email' => $user->email
                    ];

                    $this->mailController->sendTemplateEmail(
                        'burs-basvuru-alindi',
                        $user->email,
                        'Burs Başvurunuz Alınmıştır',
                        $parameters
                    );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Burs başvuru alındı mail gönderim hatası: ' . $e->getMessage());
                }
        }
        else{
            $user->iadeden_dondu = 1;
            $user->status = 5;
            $result = $user->save();
            $this->ortakController->addNewTimeline(Auth::guard('aday')->user()->tc_no,'Aday Bursiyer İade Döndü','Adayın başvurusu tekrar alındı.','Adayın başvurusu tekrar alındı. Aday iadeden döndü.');

        }
        if ($result){
            $this->ortakController->addNewTimeline(Auth::guard('aday')->user()->tc_no,'Aday Bursiyer Başvuru yaptı','Adayın başvurusu alındı.','Adayın başvurusu alındı.');

            session()->flash('success', 'Burs Başvurunuz Alınmıştır!');
        }
        else{
            session()->flash('error', 'İşlem Başarısız!');
        }
        Auth::guard('aday')->logout();
        Auth::guard('student')->logout();
        session()->flush();
        session()->regenerate();
        session()->save();
        return redirect()->route('student.active.login');
    }


    public function puanHesaplaAgno($form_id,$puan){
        $form = NewAnswer::where('id',$form_id)->first();
        $agnoType = $form->agno_type;
        if($agnoType  &&  $agnoType == "4'lük"){
            $agno = intval($form->agno) * 25;
            $ekPuan = $agno * 0.2;
            $puan = $puan + $ekPuan;
        }
        if($agnoType  &&  $agnoType == "100'lük"){
            $ekPuan = $form->agno * 0.2;
            $puan = $puan + $ekPuan;
        }
        return $puan;
    }
    public function puanHesaplaKardes($form_id,$puan){
        $form = NewAnswer::where('id',$form_id)->first();
        $kardesSayisi = $form->total_person;
        if($kardesSayisi == 0){
            return $puan;
        }
        elseif($kardesSayisi == 1){
            $puan = $puan + 2;
        }
        elseif($kardesSayisi == 2){
            $puan = $puan + 4;
        }
        elseif($kardesSayisi == 3){
            $puan = $puan + 6;
        }
        elseif($kardesSayisi == 4){
            $puan = $puan + 10;
        }
        elseif($kardesSayisi > 4){
            $puan = $puan + 15;
        }
        return $puan;
    }
    public function puanHesaplaKalinanYer($form_id,$puan){
        $form = NewAnswer::where('id',$form_id)->first();
        $kalinanYer = $form->housing_fee;
        if($kalinanYer < 5001){
            $puan = $puan + 5;
        }
        if($form->housing_type == "Kira"){
            $puan = $puan + 5;
        }
        return $puan;

    }
    public function  puanHesaplaGelir($form_id,$puan){
        $form = NewAnswer::where('id',$form_id)->first();
        $anneGelir = $form->mother_salary;
        $babaGelir = $form->father_salary;
        $digerGelir = $form->other_salary;
        $toplamGelir = $anneGelir + $babaGelir + $digerGelir;

        if($toplamGelir <= 25000){
            $puan = $puan + 30;
        }
        elseif($toplamGelir > 25000 && $toplamGelir <= 35000){
            $puan = $puan + 25;
        }
        elseif($toplamGelir > 35000 && $toplamGelir <= 45000){
            $puan = $puan + 20;
        }
        elseif($toplamGelir > 45000 && $toplamGelir <= 55000){
            $puan = $puan + 15;
        }
        elseif($toplamGelir > 55000 && $toplamGelir <= 60000){
            $puan = $puan + 10;
        }
        elseif($toplamGelir > 60000 && $toplamGelir <= 65000){
            $puan = $puan + 5;
        }
        return $puan;
    }
    /*public function puanhesapla($tc_no)
    {

        $answer = NewAnswer::where('tc_no', $tc_no)->first();

            $totalPoints = 0;
            $answerArray = $answer->toArray();
            unset($answerArray['tc_no']);

            foreach ($answerArray as $key => $value) {


                $soru = Soru::where('db_key', $key)->first();

                if ($soru && $soru->options && $soru->points) {

                    // Options ve points JSON verilerini çöz
                    $options = json_decode($soru->options, true);
                    $points = json_decode($soru->points, true);
                    // Cevap value'sini options içinde bul
                    $optionKey = array_search($value, $options);
                    // Eğer options ve points içinde değerler mevcutsa, puanı ekle
                    if ($optionKey !== false && isset($points[$optionKey])) {
                        $totalPoints += $points[$optionKey];
                    }
                }
            }
            $totalPoints = $this->puanHesaplaAgno($answer->id,$totalPoints);
            $totalPoints = $this->puanHesaplaKardes($answer->id,$totalPoints);
            $totalPoints = $this->puanHesaplaKalinanYer($answer->id,$totalPoints);
            $totalPoints = $this->puanHesaplaGelir($answer->id,$totalPoints);
            $aday = NewAnswer::where('tc_no', $tc_no)->first();
            $aday->totalPoints = $totalPoints;
            $aday->save();
    }
    */
    public function adayBasvurularim(){

        if(Auth::guard('aday')->user() && Auth::guard('aday')->user()->tc_no){
            session()->put('type','aday');
            $tc_no = Auth::guard('aday')->user()->tc_no;
        }
        else{
            session()->put('type','bursiyer');
            $tc_no = Auth::guard('bursiyer')->user()->tc_no;
        }
        $aday = NewAnswer::where('tc_no', $tc_no)->with('period')->get();
        $renewForms = Scholar::with(['renewform.infos','renewform.period'])->where('tc_no', $tc_no)->first();

        if($renewForms && count($renewForms->renewform)>0){
            $result['donem'] = $renewForms->renewform[0]->period->title;
            $result['title'] = 'Kayıt Yenileme Formu';
            $result['form'] = $renewForms ;
        return view('student/student-renew-application-list',$result);
        }
        else {
            $result['donem'] = isset($aday[0]->period->title) ? $aday[0]->period->title : '-';
            $result['forms'] = $aday ;
            $result['title'] = 'Başvuru Formu';
            return view('student/student-application-list',$result);
        }
        $result = [
            'aday' => $aday,
            'renewForms' => $renewForms,
            'title' => 'Başvuru Formu'
        ];

        return view('student/student-application-list',$result);
    }

    public function formTipiSec(){
            return view('student.select-type');
    }
    public function ogretimListesiGetir($tip)
    {
        switch ($tip){
            case 'Ortaogretim':
                return view('student.type-middle');
            case 'YuksekOgretim':
                return view('student.type-high');
            default:
                return redirect()->route('student_select_type');
        }
    }

    public function formBilgileriGetir()
    {
        return  NewAnswer::where('tc_no',Auth::guard('aday')->user()->tc_no)->with(['kardesler','scholars'])->first();
    }
    public function formTipiGetir($tip){

        if(intval($tip)>0){
            $item =  RenewForm::where('scholar_id',(intval($tip)))->with('reneweducinfo')->first();
            $tip = $item->reneweducinfo[0]->educationType;
        }
        if($tip !='ws'){
            $scholarid = Auth::guard('aday')->user()->id;
            $aday= NewAnswer::where('id',$scholarid)->first();
            $aday->educationType = $tip;
            $result =$aday->save();
        }
        return redirect()->route('get_scholarship_form_dynamic');

    }
    public function activeEducationTypeCheck($type){
        $period = Period::where('status',1)->where('type',0)->with('types')->first();
        if(!$period){
            return false;
        }
        $status = false;
        $scholarid = Auth::guard('aday')->user()->id;
        if($scholarid){
            $aday= NewAnswer::where('id',$scholarid)->first();
            $aday->educationType = $type;
            $aday->save();
        }

        $typeCheck  = PeriodEducationTypes::where('period_id',$period->id)->where('educationType',$type)->first();
        if($typeCheck){
            $status = true;
        }
        return $status;
    }
public function formTipiGetirdinamik(){
        $scholarid = Auth::guard('aday')->user()->id;
        $typeform= NewAnswer::select('educationType','status')->where('id',$scholarid)->first();
        $scholareduc = $typeform->educationType;
        $educTypeCheck = $this->activeEducationTypeCheck($scholareduc);
        $period = Period::where('status',1)->where('type',0)->with('types','documents')->first();
        $aday = NewAnswer::where('id',$scholarid)->first();
        $adayIadeCheck = $aday->status == 2;
        if(!$period){
            if(!$adayIadeCheck){
                return redirect()->route('findmy_relations_forms')->with('error', 'Seçtiğiniz Öğretim Tipi İçin Başvurular Kapalıdır.');
            }
        }
        if($adayIadeCheck){
            $period = Period::where('id',$aday->period_id)->first();
        }
        switch ($typeform->status){
            case 4:
                return redirect()->route('findmy_relations_forms')->with('error', 'Başvurunuz Reddedildiği İçin Erişime Kapalıdır.');
            case 3:
                return redirect()->route('findmy_relations_forms')->with('error', 'Başvurunuz Onaylandıktan Sonra Erişime Kapalıdır.');
        }
        if (!$educTypeCheck && !$adayIadeCheck){
            $adaylogin = Auth::guard('aday')->user();
            $aday = NewAnswer::find($adaylogin->id);
            $aday->status = -1;
            $aday->save();
            return redirect()->route('student_select_type')
                ->with('error', 'Seçtiğiniz Öğretim Tipi İçin Başvurular Kapalıdır.');
        }
        else{
            $adaylogin = Auth::guard('aday')->user();
            $aday = NewAnswer::find($adaylogin->id);
            $aday->status = 0;
            $aday->save();
        }
        $kategoriler = SoruKategori::whereJsonContains('forms', $scholareduc)  // 'form_type' içinde $tip değeri varsa
        ->with([
            'soru' => function($query) use ($scholareduc) {
                $query->whereJsonContains('form_type', $scholareduc)  // 'form_type' içinde $tip değeri varsa
                ->where('status', 'Aktif')
                ->orderBy('siralama', 'asc');},
            ])
        ->where('status','Aktif')
            ->orderBy('siralama','asc')
            ->get();
        $result['kategoriler'] = $kategoriler;
        $result['aday'] = $this->formBilgileriGetir();
        $result['title'] = 'Burs Başvuru Formu';
        $result['documents'] = $this->belgeadlarigetir();
        $result['cities'] = $this->ortakController->getCities();
        $result['univercities'] = $this->ortakController->getUnivercities();
        $result['sorular'] = Soru::where('status','Aktif')->get();
        $result['period'] = $period;
        foreach($result['period']->documents as $document){
            if($document->school_type == $scholareduc){
                $result['documents'] = json_decode($document->documents);
            }
        }
        $result['aday_id']= $aday->id;
        $this->adayBasvuruTipGuncelle($scholareduc);

        if(intval($scholareduc)>0){
            $item =  RenewForm::where('scholar_id',(intval($scholareduc)))->with('reneweducinfo')->first();
            $scholareduc = $item->reneweducinfo[0]->educationType;
        }
        return view('student.application-form-high',$result);

        switch ($scholareduc){
            case 'ilkokul':
                return view('student.application-form-primary',$result);
                break;
            case 'ortaokul':
                return view('student.application-form-middle',$result);
                break;
            case 'lise':
                return view('student.application-form-high',$result);
                break;
            case 'onlisans':
                $unicity = Univercity::select('sehir')->distinct()->get();
                $result['unicities'] = $unicity;
                return view('student.application-form-associate',$result);
                $result['unicities'] = $unicity;
                break;
            case 'lisans':
                $unicity = Univercity::select('sehir')->distinct()->get();
                $result['unicities'] = $unicity;
                return view('student.application-form-degree',$result);
                break;
            case 'yukseklisans':
                $result['ylcities'] = UnivercitysYukseklisans::select('univ_sehir_yuk')->distinct()->get();
                $result['ylisansunis'] = UnivercitysYukseklisans::all();
                return view('student.application-form-master',$result);
                break;
            default:

        }}

    public function belgeadlarigetir(){
        $documents = [
            ['id' => 'ogrenciBelgesi', 'title' => 'Öğrenci Belgesi'],
            ['id' => 'adlisicilkaydi', 'title' => 'Adli Sicil Kaydı'],
            ['id' => 'nufuskayitornegi', 'title' => 'Vukuatlı Nüfus Kayıt Örneği'],
            ['id' => 'annegelirbelgesi', 'title' => 'Anne Gelir Belgesi'],
            ['id' => 'babagelirbelgesi', 'title' => 'Baba Gelir Belgesi'],
            ['id' => 'taahhutname', 'title' => 'Aydınlatma Metni / Açık Rıza Formu ve Taahhütname'],
            ['id' => 'kimlik', 'title' => 'Kimlik Belgesi (Ön-Arka)'],
            ['id' => 'bankahesap', 'title' => 'Banka Hesap Bilgisi'],
            ['id' => 'fotograf', 'title' => 'Fotoğraf'],
            ['id' => 'transkript', 'title' => 'Transkript'],
            ['id' => 'ikametgah', 'title' => 'Aile İkamet Adresi ve Diğer Adres Belgesi'],
            ['id' => 'Karne', 'title' => 'Karne'],
            ['id' => 'Diger', 'title' => 'Diğer'],
        ];
        return $documents;
    }
    public function kayitYenilemeFormuGetir($id){
        $item = RenewForm::where('id',$id)->with(['family','housing','bank','job','disabled','social','income','scholar','scholars','educinfo','parent','personal','sibling','kardesler'])->first();
        if (!$item) {
            session()->flash('error', 'Form bulunamadı!');
            return redirect()->route('findmy_relations_forms');
        }

        $period = Period::where('id', $item->period_id)->where('type', 1)->where('is_started', 1)->where('status', 1)->first();
        if (!$period) {
            $tip = $item->reneweducinfo->educationType ?? $item->infos->educationType ?? null;
            if ($tip) {
                $period = Period::where('type', 1)->where('is_started', 1)->where('status', 1)
                    ->whereHas('types', function ($q) use ($tip) {
                        $q->where('educationType', $tip);
                    })->first();
            }
        }

        if (!$period) {
            session()->flash('error', 'Kayıt yenileme dönemi aktif değildir.');
            return redirect()->route('findmy_relations_forms');
        }

        $tip = $item->reneweducinfo->educationType ?? null;
        $result = [
            'title' => 'Kayıt Yenileme Formu',
            'documents' => $this->belgeadlarigetir(),
            'aday' => $item,
            'cities' => $this->ortakController->getCities(),

        ];
        switch ($tip){
            case 'ilkokul':
                        return view('student.kayityenileme.application-form-primary',$result);
                        break;
                    case 'ortaokul':
                        return view('student.kayityenileme.application-form-middle',$result);
                        break;
                    case 'lise':
                        return view('student.kayityenileme.application-form-high',$result);
                        break;
                    case 'onlisans':
                        return view('student.kayityenileme.application-form-associate',$result);
                        break;
                    case 'lisans':
                        return view('student.kayityenileme.application-form-degree',$result);
                        break;
                    case 'yukseklisans':
                        return view('student.kayityenileme.application-form-master',$result);
                        break;
                    default:
                        return redirect()->route('findmy_relations_forms');
                }
    }
    public function kayitYenilemeFormuGetirdinamik(){
        $scholarid = Auth::guard('bursiyer')->user()->id ?? null;
        if (!$scholarid) {
            return redirect()->route('findmy_relations_forms');
        }
        $item = RenewForm::where('scholar_id',$scholarid)->with(['infos','infos.otherScholarships','scholar.kardesler'])->first();
        if (!$item) {
            session()->flash('error', 'Form bulunamadı!');
            return redirect()->route('findmy_relations_forms');
        }
        $tip = $item->infos->educationType ?? null;

        $period = null;
        if ($item->period_id) {
            $period = Period::where('id', $item->period_id)->where('status', 1)->where('type', 1)->where('is_started', 1)->with('types','documents')->first();
        }
        if (!$period && $tip) {
            $period = Period::where('status', 1)->where('type', 1)->where('is_started', 1)
                ->whereHas('types', function ($q) use ($tip) {
                    $q->where('educationType', $tip);
                })->with('types', 'documents')->first();
        }
        if (!$period) {
            $period = Period::where('status', 1)->where('type', 1)->where('is_started', 1)->with('types','documents')->first();
        }

        if (!$period) {
            session()->flash('error', 'Kayıt yenileme dönemi aktif değildir.');
            return redirect()->route('findmy_relations_forms');
        }

        $kategoriler = SoruKategori::whereJsonContains('forms', $tip)  // 'form_type' içinde $tip değeri varsa
        ->with([
            'soru' => function($query) use ($tip) {
                $query->whereJsonContains('form_type', $tip)  // 'form_type' içinde $tip değeri varsa
                ->where('status', 'Aktif')
                    ->orderBy('siralama', 'asc');},
        ])
            ->where('status','Aktif')
            ->orderBy('siralama','asc')
            ->get();

        $result = [
            'documents' => ($period->documents),
            'period' => $period,
            'title' => 'Kayıt Yenileme Formu',
            'aday' => $item,
            'sorular' => Soru::where('status','Aktif')->get(),
            'cities' => $this->ortakController->getCities(),
            'kategoriler' => $kategoriler,
            'scholarid' => $scholarid,
        ];
        $scholareduc = $item->infos->educationType ?? null;
        if ($result['period']->documents) {
            foreach($result['period']->documents as $document){
                if($document->school_type == $scholareduc){
                    $result['documents'] = json_decode($document->documents);
                }
            }
        }
        return view('student.kayityenileme.application-form-high',$result);
    }
    public function updateRenewForm(Request $request)
    {

        try {
            $formData = $request->formData;
            $form_id = $formData['form_id'];

            // form_id'yi array'den çıkar
            unset($formData['form_id']);

            // Formu güncelle
            $form = RenewAnswer::where('form_id', $form_id)->first();
            if (!$form) {
                return response()->json([
                    'success' => false,
                    'message' => 'Form bulunamadı'
                ]);
            }

            // Her bir field için güncelleme yap
            foreach ($formData as $key => $value) {
                if (Schema::hasColumn($form->getTable(), $key)) {
                    $form->$key = $value;
                }
            }
            $form->save();

            return response()->json([
                'success' => true,
                'message' => 'Form başarıyla güncellendi'
            ]);

        } catch (\Exception $e) {
            \Log::error('Form güncelleme hatası: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }
    public function adayBasvuruTipGuncelle($tip){
        $userid = session('user_id');
        NewAnswer::where('id',$userid)->update(['educationType'=>$tip]);
    }
    public function studentProfile(){
        $title = 'Hesabım';
        return view('student.profile',compact('title'));
    }
    public function changePassword(Request $request){
        $user_id = $request->user_id;
        $new_password = $request->new_password;
        $new_password_confirmation = $request->new_password_confirmation;
        $type = $request->type;
        if($type == 'aday'){
            $user = NewAnswer::find($user_id);
        }
        else{
            $user = Scholar::find($user_id);
        }
        if($new_password == $new_password_confirmation){
            $user->password = md5($new_password);
            $user->save();
            session()->flash('success', 'İşlem Başarılı!');
            return redirect()->back()->with('success','Şifre başarıyla değiştirildi');
        }
        else{
            session()->flash('error', 'İşlem Başarısız!');
            return redirect()->back()->with('error','Şifreler eşleşmiyor');
        }
    }
}
