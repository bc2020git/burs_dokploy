<?php

namespace App\Http\Controllers;

use App\Models\ActiveAnswer;
use App\Models\ActiveInterview;
use App\Models\ActiveOtherScholarshipDetails;
use App\Models\ActiveSiblingDetails;
use App\Models\Aday;
use App\Models\Bank;
use App\Models\Il;
use App\Models\Ilce;
use App\Models\InterviewGroup;
use App\Models\MulakatAta;
use App\Models\NewAnswer;
use App\Models\NewBankInfos;
use App\Models\NewDocuments;
use App\Models\NewEducationalInfo;
use App\Models\NewFamilyInfos;
use App\Models\NewHousingInformation;
use App\Models\NewIncomeInfos;
use App\Models\NewInterview;
use App\Models\NewJobInfos;
use App\Models\NewObstacledInfos;
use App\Models\NewOtherScholarshipDetails;
use App\Models\NewOtherScholarshipInfos;
use App\Models\NewParentInfo;
use App\Models\NewPersonalnfo;
use App\Models\NewSiblingDetails;
use App\Models\NewSiblingInfos;
use App\Models\NewTimeline;
use App\Models\OtpCode;
use App\Models\Period;
use App\Models\RenewAnswer;
use App\Models\RenewBankInfos;
use App\Models\RenewDocuments;
use App\Models\RenewEducationalInfo;
use App\Models\RenewFamilyInfos;
use App\Models\RenewForm;
use App\Models\RenewHousingInformation;
use App\Models\RenewIncomeInfos;
use App\Models\RenewJobInfos;
use App\Models\RenewObstacledInfos;
use App\Models\RenewOtherScholarshipDetails;
use App\Models\RenewOtherScholarshipInfos;
use App\Models\RenewParentInfo;
use App\Models\RenewPersonalnfo;
use App\Models\RenewSiblingDetails;
use App\Models\RenewSiblingInfos;
use App\Models\RenewSocialInfos;
use App\Models\Scholar;
use App\Models\ScholarForm;
use App\Models\ScholarNote;
use App\Models\Sebep;
use App\Models\SmsSetting;
use App\Models\Soru;
use App\Models\SoruKategori;
use App\Models\TanimDepartmant;
use App\Models\TanimFaculty;
use App\Models\TanimForm;
use App\Models\TanimUnivercity;
use App\Models\TanimBursTipi;
use App\Models\Univercity;
use App\Models\User;
use App\Models\VerifyDocument;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PanelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private function bursTipleriForEducationType(?string $educationType)
    {
        if (!$educationType) {
            return collect();
        }

        return TanimBursTipi::query()
            ->whereIn('ogrenim_tipi', [$educationType, 'tumu'])
            ->orderBy('burs_tipi')
            ->get(['id', 'burs_tipi', 'ogrenim_tipi']);
    }

    public function __construct()
    {
        $this->mailController = new MailController;
        $this->adayLog = new NewTimeline;
        $this->ortakcontroller = new OrtakController;
        $this->messageControler = new MessageController;
        $this->rewRelationController = new NewRelationController;
        $this->istatistikController = new IstatistikController;
        $this->studentController = new StudentController;

    }

    private function getActiveDocumentLabel(string $dbKey): string
    {
        $title = Soru::where('type', 'file')->where('db_key', $dbKey)->value('title');

        return $title ?: $dbKey;
    }

    /**
     * Formda kullanılan bir alanın (db_key) kullanıcıya gösterilecek Türkçe başlığını döndürür.
     * Önce Scholar/ScholarForm temel bilgileri için sabit eşleşmelere, ardından Soru tablosundaki
     * 'title' değerine bakar. Hiçbiri yoksa alan adını okunabilir hale getirip döner.
     */
    private function getFieldLabel(string $key): string
    {
        static $temelBilgilerLabels = [
            'name' => 'Ad',
            'surname' => 'Soyad',
            'tc_no' => 'T.C. Kimlik No',
            'email' => 'E-posta',
            'tel_no' => 'Telefon No',
            'sube' => 'Şube',
            'aday_turu' => 'Bursiyer Tipi',
        ];

        if (isset($temelBilgilerLabels[$key])) {
            return $temelBilgilerLabels[$key];
        }

        $title = Soru::where('db_key', $key)->value('title');
        if ($title) {
            return $title;
        }

        return ucfirst(str_replace('_', ' ', $key));
    }

    private function normalizeDateString($date)
    {
        if (is_string($date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            [$year, $month, $day] = explode('-', $date);

            return $day . '-' . $month . '-' . $year;
        }

        return $date;
    }

    private function normalizeInterviewDateForStorage($date)
    {
        if ($date === null || $date === '') {
            return $date;
        }

        if ($date instanceof \DateTimeInterface) {
            return Carbon::instance($date)->format('Y-m-d');
        }

        $date = trim((string) $date);
        $formats = ['Y-m-d', 'd-m-Y', 'Y/m/d', 'd/m/Y', 'd.m.Y'];

        foreach ($formats as $format) {
            try {
                $parsed = Carbon::createFromFormat($format, $date);

                if ($parsed && $parsed->format($format) === $date) {
                    return $parsed->format('Y-m-d');
                }
            } catch (\Throwable $e) {
                //
            }
        }

        try {
            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Throwable $e) {
            return $date;
        }
    }

    public function index()
    {
        session(['sidebar' => 1]);
        $newstatics = $this->istatistikController->newStatics();
        $renewstatics = $this->istatistikController->renewStatics();
        $activestatics = $this->istatistikController->activeStatics();
        $topCities = $this->istatistikController->cityStatics();
        $allCities = $this->istatistikController->getAllCities();
        $educTypes = $this->istatistikController->educTypes();
        $result = [
            'new' => $newstatics,
            'renew' => $renewstatics,
            'active' => $activestatics,
            'topCities' => $topCities,
            'allCities' => $allCities,
            'educTypes' => $educTypes,
        ];

        return view('panel.index', $result);
    }

    public function myAccount()
    {
        session(['sidebar' => 24]);
        $user = User::find(Auth::user()->id);

        return view('panel.settings.account.edit', compact('user'));
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('login');
    }

    public function addManuelNewSiblings($dizi, $tc_no)
    {
        // JSON string'i array'e çevir
        $kardesler = json_decode($dizi, true);

        try {
            foreach ($kardesler as $kardes) {
                NewSiblingDetails::create([
                    'tc_no' => $tc_no,
                    'name' => $kardes['ad'],
                    'surname' => $kardes['soyad'],
                    'age' => $kardes['yas'],
                    'educ_status' => $kardes['ogrenimDurumu'],
                    'maritality' => $kardes['medeniDurum'],
                    'job' => $kardes['meslek'],
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Kardeşler başarıyla kaydedildi',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kardeşler kaydedilirken bir hata oluştu: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function addNewOtherScholarship($dizi, $tc_no)
    {
        $burslar = json_decode($dizi, true);
        try {
            foreach ($burslar as $burs) {
                $result = NewOtherScholarshipDetails::create([
                    'tc_no' => $tc_no,
                    'company_name' => $burs['kurumAdi'],
                    'company_type' => $burs['kurumTuru'],
                    'count' => $burs['bursTutari'],
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Kardeşler başarıyla kaydedildi',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kardeşler kaydedilirken bir hata oluştu: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function addManuelNewScholar(Request $request)
    {
        // Gelen formData verilerini alalım
        $data = $request->except('_token'); // Token hariç tüm verileri al
        // Modelin tüm veritabanı sütunlarını alalım
        $fillableFields = \Schema::getColumnListing((new NewAnswer)->getTable());

        // Yalnızca modelin veritabanı sütunlarına sahip olan verileri filtreleyelim
        $filteredData = array_filter(
            $data,
            function ($key) use ($fillableFields) {
                return in_array($key, $fillableFields);
            },
            ARRAY_FILTER_USE_KEY
        );

        // Dosyaları işle ve formData'ya ekle
        foreach ($request->file() as $fileKey => $file) {
            // Dosya isminin 'doc_' ile başladığından emin olalım
            if (strpos($fileKey, 'doc_') === 0 && $file instanceof \Illuminate\Http\UploadedFile) {
                // Dosyayı 'storage/manueleklemeler' dizinine kaydediyoruz
                $filePath = $file->store('manueleklemeler', 'public');
                $filteredData[$fileKey] = '/storage/' . $filePath; // Dosya yolunu güncelle
            }
        }

        // tc_no ve email ile kayıt kontrolü yapalım
        $existingRecord = NewAnswer::where('tc_no', $filteredData['tc_no'] ?? null)
            ->orWhere('email', $filteredData['email'] ?? null)
            ->first();

        // Eğer tc_no veya email varsa, yeni kayıt oluşturulmayacak
        if ($existingRecord) {
            // İlgili kayıt bulundu, güncelleme yapılabilir
            $existingRecord->update($filteredData);
        } else {
            // Eğer kayıt bulunmazsa yeni bir kayıt oluştur
            NewAnswer::create($filteredData);
            $this->addManuelNewSiblings($data['kardesler'], $data['tc_no']);
            $this->addNewOtherScholarship($data['burslar'], $data['tc_no']);
        }

        return response()->json(['success' => true, 'message' => 'Kayıt başarıyla eklendi veya güncellendi.']);
    }

    public function addManuelActiveSiblings($dizi, $form_id)
    {
        $kardesler = json_decode($dizi, true);
        foreach ($kardesler as $kardes) {
            ActiveSiblingDetails::create([
                'form_id' => $form_id,
                'name' => $kardes['ad'],
                'surname' => $kardes['soyad'],
                'age' => $kardes['yas'],
                'educ_status' => $kardes['ogrenimDurumu'],
                'maritality' => $kardes['medeniDurum'],
                'job' => $kardes['meslek'],
            ]);
        }
    }

    public function addActiveOtherScholarship($dizi, $form_id)
    {
        $burslar = json_decode($dizi, true);
        foreach ($burslar as $burs) {
            ActiveOtherScholarshipDetails::create([
                'form_id' => $form_id,
                'company_name' => $burs['kurumAdi'],
                'company_type' => $burs['kurumTuru'],
                'count' => $burs['bursTutari'],
            ]);
        }
    }

    public function addManuelScholar(Request $request)
    {
        // Gelen verileri formData ile alalım
        $data = $request->except('_token'); // Token hariç tüm verileri al
        // Modelin tüm veritabanı sütunlarını alalım
        $fillableFields = \Schema::getColumnListing((new ActiveAnswer)->getTable());

        // Ortak alanları belirleyin
        $commonFields = array_intersect(array_keys($data), $fillableFields);

        // Ortak alanları içeren verileri filtreleyin
        $filteredData = array_filter(
            $data,
            function ($key) use ($commonFields) {
                return in_array($key, $commonFields);
            },
            ARRAY_FILTER_USE_KEY
        );

        // Dosyaları işle ve formData'ya ekle
        foreach ($request->file() as $fileKey => $file) {
            if (strpos($fileKey, 'doc_') === 0 && $file instanceof \Illuminate\Http\UploadedFile) {
                $filePath = $file->store('manueleklemeler', 'public');
                $filteredData[$fileKey] = '/storage/' . $filePath; // Dosya yolunu güncelle
            }
        }

        // Boş değerleri kontrol et ve varsayılan değerler atayın
        $filteredData = array_merge([
            'name' => null,
            'surname' => null,
            'email' => null,
            'tc_no' => null,
            'tel_no' => null,
        ], $filteredData);

        // tc_no ve email ile kayıt kontrolü yapalım
        $existingRecord = ActiveAnswer::where('tc_no', $filteredData['tc_no'])
            ->orWhere('email', $filteredData['email'])
            ->first();

        // Eğer tc_no veya email varsa, yeni kayıt oluşturulmayacak
        if ($existingRecord) {
            $existingRecord->update($filteredData);
        } else {
            $item = new Scholar;
            $item->status = 1;
            $item->name = $filteredData['name'];
            $item->surname = $filteredData['surname'];
            $item->email = $filteredData['email'];
            $password = Str::random(8);
            $hashpassword = md5($password);
            $item->password = hash('sha256', $hashpassword);
            $item->tc_no = $filteredData['tc_no'];
            $item->tel_no = $filteredData['tel_no'];
            $item->save();

            $form = new ScholarForm;
            $period = Period::where('type', 0)->latest()->first();
            $form->period_id = $period->id;
            $form->scholar_id = $item->id;
            $form->status = 3;
            $form->save();
            $this->addManuelActiveSiblings($data['kardesler'], $form->id);
            $this->addActiveOtherScholarship($data['burslar'], $form->id);
            $formId = $form->id;

            $filteredData['form_id'] = $formId;
            ActiveAnswer::create($filteredData);
        }

        return response()->json(['success' => true, 'message' => 'Kayıt başarıyla eklendi veya güncellendi.']);
    }

    public function addRenewScholar(Request $request)
    {
        $data = $request->except('_token'); // Token hariç tüm verileri al
        $data['b_dob'] = Carbon::parse($data['b_dob'])->format('d.m.Y');
        // Modelin tüm veritabanı sütunlarını alalım
        $fillableFields = \Schema::getColumnListing((new ActiveAnswer)->getTable());

        // Ortak alanları belirleyin
        $commonFields = array_intersect(array_keys($data), $fillableFields);

        // Ortak alanları içeren verileri filtreleyin
        $filteredData = array_filter(
            $data,
            function ($key) use ($commonFields) {
                return in_array($key, $commonFields);
            },
            ARRAY_FILTER_USE_KEY
        );

        // Dosyaları işle ve formData'ya ekle
        foreach ($request->file() as $fileKey => $file) {
            if (strpos($fileKey, 'doc_') === 0 && $file instanceof \Illuminate\Http\UploadedFile) {
                $filePath = $file->store('manueleklemeler', 'public');
                $filteredData[$fileKey] = '/storage/' . $filePath; // Dosya yolunu güncelle
            }
        }

        // tc_no ve email ile kayıt kontrolü yapalım
        $existingRecord = RenewAnswer::where('tc_no', $filteredData['tc_no'] ?? null)
            ->orWhere('email', $filteredData['email'] ?? null)
            ->first();

        // Eğer tc_no veya email varsa, yeni kayıt oluşturulmayacak
        if ($existingRecord) {
            // İlgili kayıt bulundu, güncelleme yapılabilir
            $existingRecord->update($filteredData);
        } else {
            $item = new Scholar;
            $item->status = 1;
            $item->name = $filteredData['name'] ?? null;
            $item->surname = $filteredData['surname'] ?? null;
            $item->email = $filteredData['email'] ?? null;
            $password = Str::random(8);
            $hashpassword = md5($password);
            $item->password = hash('sha256', $hashpassword);
            $item->tc_no = $filteredData['tc_no'] ?? null;
            $item->tel_no = $filteredData['tel_no'] ?? null;
            $item->save();
            $form = new RenewForm;
            $period = Period::where('type', 1)->where('status', 1)->first();
            $form->period_id = $period->id;
            $form->scholar_id = $item->id;
            $form->status = 0;
            $form->save();
            $this->addManuelKySiblings($data['kardesler'], $form->id);
            $this->addManuelKyBurslar($data['burslar'], $form->id);
            $formId = $form->id;  // Burada $form->id şeklinde erişim sağlıyoruz

            $filteredData['form_id'] = $formId;
            $result = RenewAnswer::create($filteredData);

            return response()->json(['success' => true, 'message' => $result]);
        }

    }

    public function addmanuelrenew()
    {
        session(['sidebar' => 4]);
        $belgeler = Soru::where('type', 'file')
            ->get();
        $unis = TanimUnivercity::all();
        $result = [
            'bankNames' => Soru::getBankNames(),
            'belgeler' => $belgeler,
            'formType' => 'aday',
            'title' => 'Yeni Kayit Yenileme Bursiyer Ekle',
            'period' => Period::where('type', 1)->latest()->first(),
            'cities' => Il::all(),
            'documents' => $this->studentController->belgeadlarigetir(),
            'unis' => $unis,
            'bursTipleriAll' => TanimBursTipi::orderBy('burs_tipi')->get(['id', 'burs_tipi', 'ogrenim_tipi']),
        ];

        return view('panel.add-renewscholarship-manuel', $result);
    }

    public function addManuelKySiblings($dizi, $form_id)
    {
        $kardesler = json_decode($dizi, true);
        foreach ($kardesler as $kardes) {
            RenewSiblingDetails::create([
                'form_id' => $form_id,
                'name' => $kardes['ad'],
                'surname' => $kardes['soyad'],
                'age' => $kardes['yas'],
                'educ_status' => $kardes['ogrenimDurumu'],
                'maritality' => $kardes['medeniDurum'],
                'job' => $kardes['meslek'],
            ]);
        }
    }

    public function addManuelKyBurslar($dizi, $form_id)
    {
        $burslar = json_decode($dizi, true);
        foreach ($burslar as $burs) {
            RenewOtherScholarshipDetails::create([
                'form_id' => $form_id,
                'company_name' => $burs['kurumAdi'],
                'company_type' => $burs['kurumTuru'],
                'count' => $burs['bursTutari'],
            ]);
        }
    }

    public function showInterview($id)
    {
        $interview = NewInterview::findOrFail($id);

        return response()->json($interview);
    }

    public function saveNewRelationInfos(Request $request)
    {
        $data = $request->all();
        $this->updateInfos(NewAnswer::class, $data);
        /*
         $this->updateInfos(Aday::class,$data);
         $this->updateInfos(NewEducationalInfo::class,$data);
        $this->updateInfos(NewOtherScholarshipInfos::class,$data);
        $this->updateInfos(NewObstacledInfos::class,$data);
        $this->updateInfos(NewJobInfos::class,$data);
        $this->updateInfos(NewIncomeInfos::class,$data);
        $this->updateInfos(NewHousingInformation::class,$data);
        $this->updateInfos(NewFamilyInfos::class,$data);
        $this->updateInfos(NewBankInfos::class,$data);
        $this->updateInfos(NewSocialInfos::class,$data);
        $this->updateInfos(NewParentInfo::class,$data);
        $this->updateInfos(NewPersonalnfo::class,$data);
        $this->updateInfos(NewSiblingInfos::class,$data);
         */

    }

    public function saveRenewRelationInfos(Request $request)
    {
        $data = $request->all();
        $this->updateRenewInfos(RenewAnswer::class, $data);
        /*$this->updateRenewInfos(RenewEducationalInfo::class,$data);
        $this->updateRenewInfos(RenewBankInfos::class,$data);
        $this->updateRenewInfos(RenewFamilyInfos::class,$data);
        $this->updateRenewInfos(RenewHousingInformation::class,$data);
        $this->updateRenewInfos(RenewIncomeInfos::class,$data);
        $this->updateRenewInfos(RenewJobInfos::class,$data);
        $this->updateRenewInfos(RenewObstacledInfos::class,$data);
        $this->updateRenewInfos(RenewOtherScholarshipInfos::class,$data);
        $this->updateRenewInfos(RenewOtherScholarshipDetails::class,$data);
        $this->updateRenewInfos(RenewParentInfo::class,$data);
        $this->updateRenewInfos(RenewPersonalnfo::class,$data);
        $this->updateRenewInfos(RenewSiblingDetails::class,$data);
        $this->updateRenewInfos(RenewSiblingInfos::class,$data);
        $this->updateRenewInfos(RenewSocialInfos::class,$data);*/

    }

    public function saveActiveRelationInfos(Request $request)
    {
        $data = $request->all();
        $data2 = $request->formData;
        $temelBilgilerKeys = ['name', 'surname', 'tc_no', 'email', 'tel_no', 'sube', 'aday_turu'];
        $temelBilgiler = [];
        foreach ($temelBilgilerKeys as $key) {
            if (array_key_exists($key, $data2)) {
                $temelBilgiler[$key] = $data2[$key];
            }
        }
        $scholarform = ScholarForm::where('id', $data2['form_id'])->first();
        $scholar = Scholar::where('id', $scholarform->scholar_id)->first();

        $scholarChanges = [];
        foreach ($temelBilgiler as $key => $value) {
            if ($scholar->$key != $value) {
                $scholarChanges[] = [
                    'field' => $key,
                    'old' => $scholar->$key,
                    'new' => $value,
                ];
            }
        }
        $scholar->update($temelBilgiler);

        $activeAnswerResult = $this->updateActiveInfos(ActiveAnswer::class, $data);
        if (!is_array($activeAnswerResult)) {
            return $activeAnswerResult;
        }
        $activeAnswerChanges = $activeAnswerResult['changes'] ?? [];

        $allChanges = array_merge($scholarChanges, $activeAnswerChanges);
        if (!empty($allChanges)) {
            $changeText = '';
            foreach ($allChanges as $change) {
                $oldValue = ($change['old'] === null || $change['old'] === '') ? 'Boş' : $change['old'];
                $newValue = ($change['new'] === null || $change['new'] === '') ? 'Boş' : $change['new'];
                $fieldLabel = $this->getFieldLabel($change['field']);
                $changeText .= '<p><strong>' . $fieldLabel . ':</strong> ' . $oldValue . ' → ' . $newValue . '</p>';
            }
            $actor = Auth::check() ? Auth::user()->name . ' ' . Auth::user()->surname : 'Sistem';
            aday_timeline_log(
                $scholar->tc_no,
                'Aktif Bursiyer Bilgi Güncelleme',
                'Bilgiler Güncellendi',
                $changeText . '<p>İşlem yapan: ' . $actor . '</p>'
            );
        }

        return redirect()->back()->with('success', 'Bilgiler başarıyla güncellendi.');
    }

    public function saveMezunRelationInfos(Request $request)
    {
        $data = $request->all();
        $data2 = $request->formData;
        $temelBilgiler = [
            'name' => $data2['name'],
            'surname' => $data2['surname'],
            'tc_no' => $data2['tc_no'],
            'email' => $data2['email'],
            'tel_no' => $data2['tel_no'],
            'sube' => $data2['sube'],
            'aday_turu' => $data2['aday_turu'],
        ];
        $scholarform = ScholarForm::where('id', $data2['form_id'])->first();
        $scholar = Scholar::where('id', $scholarform->scholar_id)->first();
        $scholar->update($temelBilgiler);
        $this->updateActiveInfos(ActiveAnswer::class, $data);

        return response()->json(['success' => true, 'message' => 'Bilgiler başarıyla güncellendi.']);
    }

    public function addNewRelationInfos(Request $request)
    {
        $data = $request->all();

        return response()->json(['success' => $data]);

    }

    public function listemulakatolustur(Request $request)
    {
        $date = $request->date;
        $time = $request->time;
        $platform = $request->type;
        $person = $request->person;
        $address = $request->address;
        $detail = $request->detail;
        $aday = NewAnswer::find($request->mulakatadayid);
        $interview = NewInterview::create([
            'uuid' => (string) Str::uuid(),
            'tc_no' => $aday->tc_no,
            'interview_time' => $time,
            'interview_platform' => $platform,
            'interview_address' => $address,
            'interview_date' => $date,
            'interview_person' => $person,
            'interview_detail' => $detail,
        ]);
        if ($interview) {
            $aday->mulakat_durumu = 'Planlandı';
            $aday->save();
            $icerik = 'Platform: ' . $platform . ' Tarih: ' . $date . ' Saat:' . $time . ' Adres: ' . $address;
            $group = \App\Models\InterviewGroup::find($person);
            $personName = $group ? $group->name : 'Atanmamış';
            $logText = "Yeni mülakat planlandı.\nTarih: {$date}\nSaat: {$time}\nTip: {$platform}\nPersonel/Grup: {$personName}\nAdres: {$address}";

            \App\Models\InterviewTimeline::create([
                'interview_id' => $interview->id,
                'title' => 'Mülakat Oluşturuldu',
                'text' => $logText,
                'topTitle' => 'Mülakat Süreci'
            ]);

            // Yeni template sistemi ile mail gönder
            try {
                $parameters = [
                    'name' => $aday->name,
                    'surname' => $aday->surname,
                    'interview_date' => $date,
                    'interview_time' => $time,
                    'interview_type' => $platform,
                    'interview_address' => $address,
                    'interview_response_url' => route('interview.response.show', ['uuid' => $interview->uuid]),
                ];

                $mailController = new MailController;
                $mailSent = $mailController->sendTemplateEmail(
                    'mulakat-olusturuldu-mesaji',
                    $aday->email,
                    'Burs Başvurunuz İçin Mülakat Oluşturulmuştur',
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Mülakat oluşturulma mail gönderim hatası: ' . $e->getMessage());
            }
            if ($mailSent) {
                session()->flash('success', 'Mülakat oluşturuldu ve e-posta gönderildi');
            } else {
                session()->flash('error', 'Mülakat oluşturuldu fakat e-posta gönderilemedi');
            }
        }

        return redirect()->back();
    }

    public function mulakatgrupbul($id)
    {
        $mulakatgrup = InterviewGroup::find($id);

        return $mulakatgrup;
    }

    public function mulakatOlustur(Request $request)
    {
        $date = $this->normalizeDateString($request->date);
        $mulakatform = $request->mulakatform;
        $mulakatgrup = ($request->person);
        if ($mulakatform == '1') {
            $tc_no = $request->tc_no;
            $time = $request->time;
            $platform = $request->type;
            $person = $mulakatgrup;
            $address = $request->address;
            $detail = $request->detail;
            $interview = NewInterview::create([
                'uuid' => (string) Str::uuid(),
                'tc_no' => $tc_no,
                'interview_time' => $request->time,
                'interview_platform' => $request->type,
                'interview_address' => $request->address,
                'interview_date' => $date,
                'interview_person' => $request->person,
                'interview_detail' => $request->$detail,
            ]);
        } else {
            $platform = $request->platform;
            $time = $request->time;
            $person = $mulakatgrup;
            $address = $request->address;
            $detail = $request->detail;
            $tc_no = $request->tc_no;
            $interview = NewInterview::create([
                'uuid' => (string) Str::uuid(),
                'tc_no' => $tc_no,
                'interview_time' => $time,
                'interview_platform' => $platform,
                'interview_address' => $address,
                'interview_date' => $date,
                'interview_person' => $person,
                'interview_detail' => $detail,
            ]);
        }
        $user = NewAnswer::where('tc_no', $tc_no)->first();
        $user->mulakat_durumu = 'Planlandı';
        $user->save();
        $mailController = new MailController;
        // Yeni template sistemi ile mail gönder
        try {
            $parameters = [
                'name' => $user->name,
                'surname' => $user->surname,
                'interview_date' => $date,
                'interview_time' => $time,
                'interview_type' => $platform,
                'interview_address' => $address,
                'interview_response_url' => route('interview.response.show', ['uuid' => $interview->uuid]),
            ];

            $mailSent = $mailController->sendTemplateEmail(
                'mulakat-olusturuldu-mesaji',
                $user->email,
                'Burs Başvurunuz İçin Mülakat Oluşturulmuştur',
                $parameters
            );
        } catch (\Exception $e) {
            // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
            \Log::error('Mülakat oluşturulma mail gönderim hatası: ' . $e->getMessage());
            $mailSent = false;
        }
        $icerik = 'Platform: ' . $platform . ' Tarih: ' . $date . ' Saat:' . $time . ' Adres: ' . $address;
        $this->ortakcontroller->addNewTimeline($tc_no, 'Bursiyer Mulakati Olusturuldu', 'Mulakati Olusturuldu', $icerik);

        return redirect()->back();
    }

    public function aktifmulakatolustur(Request $request)
    {
        $form_id = $request->form_id;
        $formData = $request->input('formData');

        // Gelen veriyi kontrol et
        if ($request->form == '1') {
            $interview = ActiveInterview::create([
                'form_id' => $form_id,
                'interview_time' => $request->time,
                'interview_platform' => $request->platform,
                'interview_address' => $request->address,
                'interview_date' => $request->date,
                'interview_person' => $this->mulakatgrupbul($request->person),
            ]);

            return redirect()->back();

        }
        $date = $request->year . '-' . $request->month . '-' . $request->day;
        $time = $request->hour . '-' . $request->minute;
        $platform = $request->type;
        $person = $request->person;
        $address = $request->address;
        $detail = $request->detail;
        $interview = ActiveInterview::create([
            'form_id' => $form_id,
            'interview_time' => $time,
            'interview_platform' => $platform,
            'interview_address' => $address,
            'interview_date' => $date,
            'interview_person' => $person,
            'interview_detail' => $detail,
        ]);

        return redirect()->back();
    }

    public function adaymulakatOlustur(Request $request)
    {
        $tc_no = $request->tc_no;
        $formData = $request->input('formData');

        // Gelen veriyi kontrol et
        if ($request->form == '1') {
            $interview = NewInterview::create([
                'uuid' => (string) Str::uuid(),
                'tc_no' => $tc_no,
                'interview_time' => $request->time,
                'interview_platform' => $request->platform,
                'interview_address' => $request->address,
                'interview_date' => $request->date,
                'interview_person' => $request->person,
            ]);

            return redirect()->back();

        }
        $date = $request->year . '-' . $request->month . '-' . $request->day;
        $time = $request->hour . '-' . $request->minute;
        $platform = $request->type;
        $person = $request->person;
        $address = $request->address;
        $detail = $request->detail;
        $interview = NewInterview::create([
            'uuid' => (string) Str::uuid(),
            'tc_no' => $tc_no,
            'interview_time' => $time,
            'interview_platform' => $platform,
            'interview_address' => $address,
            'interview_date' => $date,
            'interview_person' => $person,
            'interview_detail' => $detail,
        ]);
        $user = NewAnswer::where('tc_no', $tc_no)->first();
        $user->mulakat_durumu = 'Planlandı';
        $user->save();

        return redirect()->back();
    }

    public function saveInfos(string $modelClass, array $data)
    {
        // Model sınıfının bir örneğini oluşturun
        $modelInstance = new $modelClass;
        $formData = $data['formData'];
        // Veritabanında `tc_no` ile eşleşen kaydı bul
        $record = new $modelClass;

        if ($record) {
            foreach ($formData as $key => $value) {
                if (Schema::hasColumn($modelInstance->getTable(), $key) && $value != $record->$key) {
                    $record->$key = $value;
                }
            }
            $record->save();

            return $record;
        } else {
            return response()->json(['error' => 'Kayıt bulunamadı!'], 404);
        }
    }

    public function updateInfos(string $modelClass, array $data)
    {
        // Model sınıfının bir örneğini oluşturun
        $modelInstance = new $modelClass;

        if (!isset($data['formData'])) {
            return response()->json(['error' => 'formData eksik!'], 400);
        }

        $formData = $data['formData'];

        if (!isset($formData['tc_no'])) {
            return response()->json(['error' => 'tc_no değeri eksik!'], 400);
        }

        // TC Kimlik Numarası algoritma kontrolü
        $tc = $formData['tc_no'];
        if (!preg_match('/^[1-9]\d{10}$/', $tc)) {
            return response()->json(['error' => 'Geçersiz TC Kimlik Numarası!'], 400);
        }
        $sumOdd = (int)$tc[0] + (int)$tc[2] + (int)$tc[4] + (int)$tc[6] + (int)$tc[8];
        $sumEven = (int)$tc[1] + (int)$tc[3] + (int)$tc[5] + (int)$tc[7];
        if (($sumOdd * 7 - $sumEven) % 10 != (int)$tc[9]) {
            return response()->json(['error' => 'Geçersiz TC Kimlik Numarası!'], 400);
        }
        $sumAll = 0;
        for ($i = 0; $i < 10; $i++) {
            $sumAll += (int)$tc[$i];
        }
        if ($sumAll % 10 != (int)$tc[10]) {
            return response()->json(['error' => 'Geçersiz TC Kimlik Numarası!'], 400);
        }

        // Veritabanında kaydı bul
        if ($modelClass === NewAnswer::class) {
            $adayId = $formData['adayid'] ?? $formData['adayId'] ?? null;
            $record = $modelClass::find($adayId);
        } else {
            $record = $modelClass::where('tc_no', $formData['tc_no'])->first();
        }

        if ($record) {
            foreach ($formData as $key => $value) {
                if (Schema::hasColumn($modelInstance->getTable(), $key) && $value != $record->$key) {
                    $record->$key = $value;
                }
            }
            $record->save();

            return $record;
        } else {
            return response()->json(['error' => 'Kayıt bulunamadı!'], 404);
        }
    }

    public function updateRenewInfos(string $modelClass, array $data)
    {
        // Model sınıfının bir örneğini oluşturun
        $modelInstance = new $modelClass;

        if (!isset($data['formData'])) {
            return response()->json(['error' => 'formData eksik!'], 400);
        }

        $formData = $data['formData'];

        if (!isset($formData['tc_no'])) {
            return response()->json(['error' => 'tc_no değeri eksik!'], 400);
        }

        // Veritabanında `tc_no` ile eşleşen kaydı bul
        $record = $modelClass::where('form_id', $formData['adayid'])->first();

        if ($record) {
            foreach ($formData as $key => $value) {
                if (Schema::hasColumn($modelInstance->getTable(), $key) && $value != $record->$key) {
                    $record->$key = $value;
                }
            }
            if (isset($data['files'])) {
                foreach ($data['files'] as $fileKey => $file) {
                    if ($file->isValid()) {
                        // Dosyayı kaydet (örnek: storage/app/public/uploads/)
                        $filePath = $file->store('manuelekleme', 'public');

                        // Dosya yolunu veritabanında uygun bir sütuna kaydet
                        if (Schema::hasColumn($modelInstance->getTable(), $fileKey)) {
                            $record->$fileKey = $filePath;
                        }
                    }
                }
            }
            $result = $record->save();
            if ($result) {
                $kyId = $formData['adayId'];
                $scholar = Scholar::where('id', $kyId)->first();
                $scholar->update([
                    'email' => $formData['email'],
                ]);

                return $result;
            }

            return $result;
        } else {
            return response()->json(['error' => 'Kayıt bulunamadı!'], 404);
        }
    }

    public function updateActiveInfos(string $modelClass, array $data)
    {
        // Model sınıfının bir örneğini oluşturun
        $modelInstance = new $modelClass;

        if (!isset($data['formData'])) {
            return response()->json(['error' => 'formData eksik!'], 400);
        }

        $formData = $data['formData'];

        if (!isset($formData['form_id'])) {
            return response()->json(['error' => 'tc_no değeri eksik!'], 400);
        }

        // Veritabanında `form_id` ile eşleşen kaydı bul
        $record = $modelInstance::where('form_id', $formData['form_id'])->first();
        if ($record) {
            $changes = [];
            foreach ($formData as $key => $value) {
                if (Schema::hasColumn($modelInstance->getTable(), $key) && $value != $record->$key) {
                    $changes[] = [
                        'field' => $key,
                        'old' => $record->$key,
                        'new' => $value,
                    ];
                    $record->$key = $value;
                }
            }
            $record->save();

            return ['record' => $record, 'changes' => $changes];
        } else {
            return response()->json(['error' => 'Kayıt bulunamadı!'], 404);
        }
    }

    public function newScholarDetils($id)
    {
        $sebepler = Sebep::orderBy('text', 'asc')->get();
        $userId = Auth::id(); // Giriş yapmış kullanıcının ID'si

        $aday = NewAnswer::where('id', $id)->with([
            'documents',
            'kardesler',
            'interviews' => function ($query) use ($userId) {
                if (!auth()->user()->hasPermission('tum-mulakatlar')) {
                    $query->whereExists(function ($subQuery) use ($userId) {
                        $subQuery->from('interview_groups')
                            ->whereRaw('interview_groups.id = new_interviews.interview_person')
                            ->whereRaw('JSON_CONTAINS(interview_groups.members, ?)', ['"' . $userId . '"']);
                    });
                }
            },
            'interviews.group',
            'docverify',
            'scholars',
            'logs',
            'notes',
            'points',
        ])->first();
        $mulakatGruplar = InterviewGroup::all();
        $period = Period::where('id', $aday->period_id)->first();
        if (!$period) {
            $period = Period::where('status', 1)->first();
        }
        if (!$period) {
            $period = Period::where('type', 0)->orderBy('id', 'desc')->first();
        }
        $belgeler = Soru::where('type', 'file')
            ->get();
        $periodlar = Period::orderBy('title', 'desc')->get()->unique('title')->values();
        $unis = TanimUnivercity::all();
        if ($aday) {
            $result['bursTipleri'] = $this->bursTipleriForEducationType($aday->educationType ?? null);
            $result['period'] = $period;
            $result['aday'] = $aday;
            $result['belgeler'] = $belgeler;
            $result['unis'] = $unis;
            $result['periods'] = Period::where('id', $period->id)->get();
            $result['cities'] = $this->getAllCities();
            $result['mulakatGruplar'] = $mulakatGruplar;
            $result['sebepler'] = $sebepler;
            $result['bankNames'] = Soru::getBankNames();
            $result['periodlar'] = $periodlar;

            return view('panel.candidate-update-details.index', $result);
        }

        return redirect()->route('adaybursiyerler');
    }

    public function mulakatAta(Request $request)
    {
        $item = new MulakatAta;
        $item->user_id = $request->mulakatAta;
        $item->aday_id = $request->mulakat_aday_id;
        $result = $item->save();
        $this->checkResult($result);

        // Zaman çizelgesine ekle
        $aday = NewAnswer::find($request->mulakat_aday_id);
        if ($aday) {
            \Log::info('Mülakat Ata - Aday Bulundu:', ['id' => $aday->id, 'tc' => $aday->tc_no]);
            $interview = $aday->interviews()->latest()->first();

            if ($interview) {
                \Log::info('Mülakat Ata - Mülakat Bulundu:', ['id' => $interview->id]);
                $group = \App\Models\InterviewGroup::find($request->mulakatAta);
                $groupName = $group ? $group->name : 'Bilinmeyen Grup';

                \App\Models\InterviewTimeline::create([
                    'interview_id' => $interview->id,
                    'title' => 'Mülakat Ataması Yapıldı',
                    'text' => "Adaya '{$groupName}' mülakat personeli/grubu olarak atandı.",
                    'topTitle' => 'Mülakat Süreci'
                ]);
            } else {
                \Log::warning('Mülakat Ata - Mülakat BULUNAMADI! TC: ' . $aday->tc_no);
            }
        }

        return redirect()->back();
    }

    public function topluMulakatAta(Request $request)
    {

        $item = new MulakatAta;
        $item->user_id = $request->mulakatAta;
        $item->aday_id = $request->mulakat_aday_id;
        $result = $item->save();
        $this->checkResult($result);

        // Zaman çizelgesine ekle
        $aday = NewAnswer::find($request->mulakat_aday_id);
        if ($aday) {
            \Log::info('Toplu Mülakat Ata - Aday Bulundu:', ['id' => $aday->id, 'tc' => $aday->tc_no]);
            $interview = $aday->interviews()->latest()->first();

            if ($interview) {
                \Log::info('Toplu Mülakat Ata - Mülakat Bulundu:', ['id' => $interview->id]);
                $group = \App\Models\InterviewGroup::find($request->mulakatAta);
                $groupName = $group ? $group->name : 'Bilinmeyen Grup';

                \App\Models\InterviewTimeline::create([
                    'interview_id' => $interview->id,
                    'title' => 'Toplu Mülakat Ataması Yapıldı',
                    'text' => "Adaya '{$groupName}' mülakat personeli/grubu toplu işlem ile atandı.",
                    'topTitle' => 'Mülakat Süreci'
                ]);
            } else {
                \Log::warning('Toplu Mülakat Ata - Mülakat BULUNAMADI! TC: ' . $aday->tc_no);
            }
        }

        return redirect()->back();
    }

    public function crmActiveOtherScholarship(Request $request)
    {
        $data = $request->all();
        $formId = $data['form_id'];
        $form = ScholarForm::where('id', $formId)->with('scholar')->first();
        $scholar = $form->scholar;
        $data['tc_no'] = $scholar->tc_no;
        unset($data['form_id']);
        $result = NewOtherScholarshipDetails::create($data);
        if ($result) {
            return redirect()->back()->with('success', 'Burs bilgileri başarıyla kaydedildi.');
        }

        return redirect()->back()->with('error', 'Burs bilgileri kaydedilirken bir hata oluştu.');
    }

    public function crmActiveOtherScholarshipUpdate(Request $request)
    {
        $data = $request->all();
        $result = NewOtherScholarshipDetails::where('id', $data['id'])->update($data);
        if ($result) {
            return redirect()->back()->with('success', 'Burs bilgileri başarıyla güncellendi.');
        }
    }

    public function activeScholarDetils($id)
    {

        $this->aktifBursiyerBursTekrarDuzenle($id);
        session(['sidebar' => 5]);
        $aday = ScholarForm::with(['scholar.docverify', 'scholar.logs', 'scholars', 'digerBursInfo', 'period', 'job', 'documents', 'scholar', 'kardesler', 'scholar.interviews', 'infos', 'infos.otherScholarships'])->where('id', $id)->first();
        $period = ScholarForm::where('id', $id)->first();
        $scholar_id = ScholarForm::where('id', $id)->first()->scholar_id;
        $allForms = ScholarForm::with('period')->where('scholar_id', $scholar_id)->get();
        $latestPhoto = $aday->scholar->latestPhoto();
        $periods = [];
        foreach ($allForms as $form) {
            if ($form->period) {
                $periods[] = (object) [
                    'id' => $form->period->id,
                    'title' => $form->period->title,
                ];
            }
        }

        if (empty($periods)) {
            $latestType1 = Period::where('type', 1)->latest()->first();
            $latestType0 = Period::where('type', 0)->latest()->first();
            if ($latestType1) {
                $periods[] = (object) [
                    'id' => $latestType1->id,
                    'title' => $latestType1->title,
                ];
            }
            if ($latestType0) {
                $periods[] = (object) [
                    'id' => $latestType0->id,
                    'title' => $latestType0->title,
                ];
            }
        }

        $belgeler = Soru::where('type', 'file')->get();
        $unis = TanimUnivercity::orderBy('name')->get();
        if ($aday) {
            $result['bursTipleri'] = $this->bursTipleriForEducationType($aday->infos->educationType ?? null);
            $result['manualPaymentDonemOptions'] = BursOdemeController::manualDonemOptionsForView();
            $result['unis'] = $unis;
            $result['belgeler'] = $belgeler;
            $result['period'] = $period;
            $result['aday'] = $aday;
            $result['periods'] = $periods;
            $result['cities'] = Il::all();
            $result['bankNames'] = Soru::getBankNames();
            $result['latestPhoto'] = $latestPhoto;

            return view('panel.active-scholarship-details.index', $result);
        }

        return redirect()->route('adaybursiyerler');
    }

    public function getPeriodDocuments(Request $request)
    {
        $scholar_id = $request->scholar_id;

        $targetPeriodId = $request->period_id;

        $aday = ScholarForm::with(['scholar.docverify', 'scholar.logs', 'scholars', 'digerBursInfo', 'period', 'job', 'documents', 'scholar', 'kardesler', 'scholar.interviews', 'infos', 'infos.otherScholarships'])
            ->where('scholar_id', $scholar_id)
            ->whereHas('period', function ($q) use ($targetPeriodId) {
                $q->where('id', $targetPeriodId);
            })
            ->first();

        if (!$aday) {
            $aday = ScholarForm::with(['scholar.docverify', 'scholar.logs', 'scholars', 'digerBursInfo', 'period', 'job', 'documents', 'scholar', 'kardesler', 'scholar.interviews', 'infos', 'infos.otherScholarships'])
                ->where('scholar_id', $scholar_id)
                ->where('period_id', $targetPeriodId)
                ->first();
        }

        if (!$aday) {
            return response()->json(['status' => 'error', 'message' => 'Bu dönem için kayıt bulunamadı.'], 404);
        }

        $belgeler = Soru::where('type', 'file')->get();

        $cardsHtml = view('panel.active-forms.partials.document-cards', compact('aday', 'belgeler'))->render();
        $tableHtml = view('panel.active-forms.partials.document-control-rows', compact('aday', 'belgeler'))->render();

        return response()->json([
            'status' => 'success',
            'cardsHtml' => $cardsHtml,
            'tableHtml' => $tableHtml,
        ]);
    }

    public function aktifBursiyerBursTekrarDuzenle($id)
    {
        $scholarForm = ScholarForm::where('id', $id)->first();
        $formId = $scholarForm->id;

        // Tüm diğer bursları al
        $digerBurslar = ActiveOtherScholarshipDetails::where('form_id', $formId)->get();

        // Aynı company_name, company_type ve count değerlerine sahip kayıtları grupla
        $gruplar = [];
        $silinecekIdler = [];

        foreach ($digerBurslar as $burs) {
            $key = $burs->company_name . '|' . $burs->company_type . '|' . $burs->count;

            if (!isset($gruplar[$key])) {
                // Bu grup için ilk kayıt, bunu sakla
                $gruplar[$key] = $burs->id;
            } else {
                // Bu grup için zaten bir kayıt var, bu kayıt silinecek
                $silinecekIdler[] = $burs->id;
            }
        }

        // Tekrarlanan kayıtları sil
        if (count($silinecekIdler) > 0) {
            ActiveOtherScholarshipDetails::whereIn('id', $silinecekIdler)->delete();
        }

        // Temizlenmiş listeyi al
        $temizBurslar = ActiveOtherScholarshipDetails::where('form_id', $formId)->get();

        return redirect()->route('panel-aktif-bursiyer-incele', $id);
    }

    public function activeScholarDetilsList($id)
    {
        $activeAnswer = ActiveAnswer::where('id', $id)->first();

        return redirect()->route('panel-aktif-bursiyer-incele', ['id' => $activeAnswer->form_id]);
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'tc_no' => 'required|string',
            'email' => 'required|email',
        ]);

        $tc_no = $request->tc_no;
        $email = $request->email;

        // Kullanıcının sistemde mevcut olup olmadığını kontrol et
        $user = Aday::where('tc_no', $tc_no)
            ->where('email', $email)
            ->first();

        if ($user) {
            // OTP Kodu oluştur
            $otp = rand(1000, 9999);
            session(['otp' => $otp, 'user_id' => $user->id, 'email' => $user->email]);
            $mesaj = 'Giris Kodunuz ' . $otp;

            $mailCheck = $this->messageController->sendMail('Girişinizi Onaylayınız', $user->email, $mesaj);
            if ($mailCheck) {
                OtpCode::create([
                    'code' => $otp,
                    'session' => $user->id,
                ]);
            }

            // Auth::guard('aday')->login($user);
            // return redirect()->route('student_select_type');
            return redirect()->route('aday.otp.verify')->with('success', 'OTP gönderildi. Lütfen kontrol edin.');

        } else {
            // Kullanıcı mevcut değilse, e-posta ve TC kimlik numarasını kontrol et
            $existingUser = Aday::where('email', $email)
                ->orWhere('tc_no', $tc_no)
                ->first();

            if ($existingUser) {
                // Eğer e-posta veya TC kimlik numarası mevcutsa ancak şifre yanlışsa
                session()->flash('error', 'Şifre Yanlış');

                return back()->withErrors(['password' => 'Şifre Yanlış']);

            } else {
                // Kullanıcı mevcut değilse yeni kullanıcı oluştur
                $user = Aday::create([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $email,
                    'tc_no' => $tc_no,
                    'periodId' => $this->aktifDonemGetir(),
                ]);
                // OTP Kodu oluştur
                $otp = rand(1000, 9999);
                session(['otp' => $otp, 'user_id' => $user->id, 'email' => $user->email]);
                $mesaj = 'Giris Kodunuz ' . $otp;

                $mailCheck = $this->messageController->sendMail('Girişinizi Onaylayınız', $user->email, $mesaj);
                if ($mailCheck) {
                    OtpCode::create([
                        'code' => $otp,
                        'session' => $user->id,
                    ]);
                }
                // Auth::guard('aday')->login($user);
                // return redirect()->route('student_select_type');
                session()->flash('error', 'OTP icin mailinizi kontrol edin');

                return redirect()->route('aday.otp.verify')->with('success', 'OTP gönderildi. Lütfen kontrol edin.');
            }
        }
    }

    public function adayTopluIslem(Request $request)
    {
        $userIds = $request->input('userIds'); // Kullanıcı ID'leri
        $islemId = $request->input('islemId'); // İşlem ID'si

        // İsteğin başarılı olduğunu döndürüyoruz
        return response()->json([
            'data' => $userIds,
            'islemId' => $islemId,
        ]);
    }

    public function adayOtpFormuAc()
    {
        $email = session('email');
        $email = $this->obfuscateEmail($email);

        return view('auth.student.new.otp-authentication', compact('email'));
    }

    public function otpKoduSil($code)
    {
        OtpCode::where('code', $code)->delete();

    }

    public function otpKoduKontrol($code)
    {
        $otp = OtpCode::where('code', $code)->first();
        $currentTimestamp = Carbon::now();
        $kodGecerliligi = $otp->created_at;
        if (!$kodGecerliligi->lessThan($currentTimestamp->subMinutes(5))) {
            $this->otpKoduSil($code);
        }
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;
        // Session'da saklanan OTP'yi al
        $sessionOtp = session('otp');
        $userId = session('user_id');

        if ($otp == $sessionOtp) {
            // OTP doğruysa kullanıcıyı giriş yap
            $user = Aday::find($userId);
            Auth::guard('aday')->login($user);

            $this->otpKoduSil($otp);

            return redirect()->route('student_select_type');
        } else {
            $this->otpKoduSil($otp);
            session()->flash('error', 'OTP Yanlış');

            return redirect()->route('aday.login.view');
        }
    }

    public function uploadNewScholarDocs(Request $request)
    {

        // Dosyanın var olup olmadığını kontrol et
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $tc = $request->input('tc_no');
            $adayId = $request->input('adayId');
            $name = $request->input('id');
            $extension = $file->getClientOriginalExtension();

            // Dosya adı oluştur
            $fileName = uniqid() . '.' . $extension;

            $path = 'uploads/basvurular/' . $adayId;

            $filePath = $file->storeAs($path, $fileName, 'public');
            $item = NewAnswer::where('tc_no', $tc)->first();
            $item->{$name} = '/storage/' . $filePath;
            $item->save();

        }
    }

    public function uploadScholarDocs(Request $request)
    {
        // Dosyanın var olup olmadığını kontrol et
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $tc = $request->input('tc_no');
            $period = $request->input('period');
            $name = $request->input('id');
            $extension = $file->getClientOriginalExtension();

            $scholar = Scholar::where('tc_no', $tc)->first();
            if (!$scholar) {
                return response()->json(['success' => false, 'message' => 'Bursiyer bulunamadı.'], 404);
            }

            $scholarForm = ScholarForm::where('scholar_id', $scholar->id)
                ->where('period_id', $period)
                ->first();

            if (!$scholarForm) {
                return response()->json(['success' => false, 'message' => 'İlgili döneme ait form bulunamadı.'], 404);
            }

            $fileName = uniqid() . '.' . $extension;

            $path = 'bursiyerler/' . $scholar->id;

            $filePath = $file->storeAs($path, $fileName, 'public');
            $item = ActiveAnswer::where('form_id', $scholarForm->id)->first();

            $item->{$name} = '/storage/' . $filePath;
            $item->save();

            $periodTitle = Period::find($period)->title ?? $period;
            aday_timeline_dosya_yukleme($tc, $this->getActiveDocumentLabel($name), $periodTitle);

            return response()->json(['success' => true, 'path' => '/storage/' . $filePath]);
        }

        return response()->json(['success' => false, 'message' => 'Dosya yüklenemedi.'], 400);
    }

    public function uploadRenewScholarDocs(Request $request)
    {
        $period_id = $request->input('period_id');
        $periods = RenewForm::find($request->input('adayId'));
        $period = Period::find($period_id);

        $period_path = $period->path;

        // Dosyanın var olup olmadığını kontrol et
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $tc = $request->input('tc_no');
            $adayId = $request->input('adayId');
            $name = $request->input('id');
            $rnid = $request->input('rnid');
            $extension = $file->getClientOriginalExtension();

            // Dosya adı oluştur
            $fileName = uniqid() . '.' . $extension;

            $path = 'uploads/kayitYenilemeler/' . $rnid . '/' . $period_path;

            // Dosyayı  kaydet
            $renewformid =
                $filePath = $file->storeAs($path, $fileName, 'public');
            $uploadedFile = RenewAnswer::where([['form_id', $rnid]])->first();
            $uploadedFile->{$name} = '/storage/' . $filePath;
            $uploadedFile->save();
        }
    }

    // Dosya silme işlemi
    public function deleteNewScholarDocs($id, $tc)
    {
        $doc = NewAnswer::where('tc_no', $tc)->first();

        if ($doc) {
            // Dosyayı storage'dan sil
            $filePath = preg_replace('/^\/storage\//', '', $doc->{$id});
            Storage::disk('public')->delete($filePath);
            $doc->{$id} = null;
            $doc->save();
            // Veritabanından kaydı sil
            $item = NewDocuments::where('tc_no', $tc)->first();
            $item->{$id} = null;
            $item->save();

            return response()->json(['success' => true, 'message' => 'Dosya başarıyla silindi.']);
        }

        return response()->json(['success' => false, 'message' => 'Dosya bulunamadı.'], 404);
    }

    public function deleteScholarDocs($id, $tc, $period)
    {
        $scholar = Scholar::where('tc_no', $tc)->first();
        $scholarForm = ScholarForm::where('period_id', $period)->where('scholar_id', $scholar->id)->first();
        $doc = ActiveAnswer::where('form_id', $scholarForm->id)->first();

        if ($doc) {
            // Dosyayı storage'dan sil
            $filePath = preg_replace('/^\/storage\//', '', $doc->{$id});
            Storage::disk('public')->delete($filePath);
            $doc->{$id} = null;
            $doc->save();

            $periodTitle = Period::find($period)->title ?? $period;
            aday_timeline_belge_silme($tc, $this->getActiveDocumentLabel($id), $periodTitle);

            return response()->json(['success' => true, 'message' => 'Dosya başarıyla silindi.']);
        }

        return response()->json(['success' => false, 'message' => 'Dosya bulunamadı.'], 404);
    }

    public function deleteReNewScholarDocs($dosya, $form_id)
    {
        // Veritabanından dosyayı bul
        $ky = RenewAnswer::where('form_id', $form_id)->first();

        if ($ky) {

            // Dosyayı storage'dan sil
            $filePath = preg_replace('/^\/storage\//', '', $ky->{$dosya});
            Storage::disk('public')->delete($filePath);

            // Veritabanından kaydı sil
            $ky->{$dosya} = null;
            $ky->save();

            return response()->json(['success' => true, 'message' => 'Dosya başarıyla silindi.']);
        }

        return response()->json(['success' => false, 'message' => 'Dosya bulunamadı.'], 404);
    }

    public function changeStatusNewScholarships(Request $request)
    {
        $docIds = $request->input('docsId');
        $status = $request->input('status');

        // Gelen ID'lere sahip olan belgeleri güncelle
        if (!empty($docIds) && is_array($docIds)) {
            NewDocuments::whereIn('id', $docIds)
                ->whereNotNull('path')
                ->where('path', '!=', '')
                ->update(['status' => $status]);
        }

        // Başarılı yanıt döndür
        return response()->json(['message' => 'Durum güncellendi', 'status' => $status]);
    }

    public function changeStatusRenewScholarships(Request $request)
    {
        $docIds = $request->input('docsId');
        $status = $request->input('status');

        // Gelen ID'lere sahip olan belgeleri güncelle
        if (!empty($docIds) && is_array($docIds)) {
            RenewDocuments::whereIn('id', $docIds)
                ->whereNotNull('path')
                ->where('path', '!=', '')
                ->update(['status' => $status]);
        }

        // Başarılı yanıt döndür
        return response()->json(['message' => 'Durum güncellendi', 'status' => $status]);
    }

    public function adayBursiyerSonuclandir($tc_no, $sonuc)
    {
        Aday::where('tc_no', $tc_no)->update(['status' => $sonuc]);
    }

    public function add_scholarship_application_manuel()
    {
        $periods = Period::orderBy('title', 'desc')->get()->unique('title')->values();
        $currentPeriod = Period::where('status', 1)->first() ?? Period::orderBy('id', 'desc')->first();

        $result['periods'] = $periods;
        $result['period'] = $currentPeriod;
        $result['cities'] = Il::all();
        $result['belgeler'] = Soru::where('type', 'file')->get();
        $result['bankNames'] = Soru::getBankNames();
        $result['unis'] = TanimUnivercity::all();
        $result['formType'] = 'aday';
        $result['title'] = 'Yeni Aday Bursiyer Ekle';

        return view('panel.add-scholarship-application-manuel', $result);
    }

    public function checkTCNo(Request $request)
    {
        $type = $request->type;
        if ($type == 'new') {
            $exists = NewAnswer::where('tc_no', $request->tc_no)->exists();
        }

        return response()->json(['exists' => $exists]);
    }

    public function active_scholarship_details()
    {
        return view('panel.active-scholarship-details');
    }

    public function period_management()
    {
        return view('panel.period-management');

    }

    public function updateInterview(Request $request)
    {
        $id = $request->input('id');
        // Güncellenmek istenen kaydı bul
        $interview = NewInterview::find($id);
        $interview->interview_date = $this->normalizeInterviewDateForStorage($request->editinterviewDate);
        $interview->interview_time = $request->editinterviewTime;
        $interview->interview_platform = $request->editinterviewType;
        $interview->interview_person = $request->editinterviewer;
        $interview->interview_address = $request->editinterviewadress;

        $fieldLabels = [
            'interview_date' => 'Tarih',
            'interview_time' => 'Saat',
            'interview_platform' => 'Tip',
            'interview_person' => 'Personel/Grup',
            'interview_address' => 'Adres/Link',
        ];

        $changes = [];
        foreach ($interview->getDirty() as $field => $newValue) {
            if (!isset($fieldLabels[$field])) {
                continue;
            }

            $oldValue = $interview->getOriginal($field);
            $printableOld = $oldValue ?: 'Belirtilmedi';
            $printableNew = $newValue ?: 'Belirtilmedi';

            if ($field === 'interview_person') {
                $oldGroup = InterviewGroup::find($oldValue);
                $newGroup = InterviewGroup::find($newValue);
                $printableOld = $oldGroup ? $oldGroup->name : 'Atanmamış';
                $printableNew = $newGroup ? $newGroup->name : 'Atanmamış';
            }

            $changes[] = "{$fieldLabels[$field]}: {$printableOld} -> {$printableNew}";
        }

        $shouldSendEmail = $interview->isDirty([
            'interview_date',
            'interview_time',
            'interview_platform',
            'interview_person',
            'interview_address',
        ]);

        $result = $interview->save();
        $this->checkResult($result);

        if ($result) {
            \App\Models\InterviewTimeline::create([
                'interview_id' => $interview->id,
                'title' => 'Mülakat Bilgileri Güncellendi',
                'text' => count($changes) > 0
                    ? 'Mülakat bilgileri güncellendi. Değişen alanlar: ' . implode(', ', $changes)
                    : 'Mülakat bilgileri güncellendi (Herhangi bir alan değişmedi).',
                'topTitle' => 'Mülakat Süreci',
            ]);
        }

        // Mülakat güncellendiğinde template email gönder
        if ($result && $shouldSendEmail) {
            try {
                // TC no ile kullanıcı bilgilerini bul
                $user = NewAnswer::where('tc_no', $interview->tc_no)->first();

                if ($user && $user->email) {
                    // Template parametrelerini hazırla
                    $parameters = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'interview_date' => date('d.m.Y', strtotime($interview->interview_date)),
                        'interview_time' => $interview->interview_time,
                        'interview_type' => $interview->interview_platform,
                        'interview_address' => $interview->interview_address,
                    ];

                    // Template email gönder
                    $this->mailController->sendTemplateEmail(
                        'mulakat-guncellendi-mesaji',
                        $user->email,
                        'Mülakatiniz Güncellendi',
                        $parameters
                    );
                }
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Mülakat güncelleme mail gönderim hatası: ' . $e->getMessage());
            }
        }

        return redirect()->back();
    }

    public function endInterviewSpecial(Request $request)
    {

        $id = $request->input('id');
        $item = NewInterview::find($id);

        $user = NewAnswer::where('tc_no', $item->tc_no)->first();
        $interview = NewInterview::where('id', $id)->update([
            'interview_score' => $request->editinterviewScore,
            'interview_result' => $request->editinterviewResult,
        ]);
        $item = NewInterview::find($id);

        $this->checkResult($interview);
        if ($interview) {
            $user->mulakat_durumu = $request->editinterviewResult;
            $user->save();

            // Yeni template sistemi ile mail gönder
            try {
                if ($request->editinterviewResult == 'Olumlu') {
                    // Olumlu sonuç için template parametrelerini hazırla
                    $parameters = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'interview_date' => $item->interview_date,
                        'interview_time' => $item->interview_time,
                        'interview_type' => $item->interview_platform,
                    ];

                    // Olumlu sonuç template'ini gönder
                    $this->mailController->sendTemplateEmail(
                        'mulakat-onaylandi-mesaji',
                        $user->email,
                        'Mülakat Sonuçlandırılmıştır',
                        $parameters
                    );
                } else {
                    // Olumsuz sonuç için yeni template sistemi
                    $parameters = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'interview_date' => $item->interview_date,
                        'interview_time' => $item->interview_time,
                        'interview_type' => $item->interview_platform,
                    ];

                    // Olumsuz sonuç template'ini gönder
                    $this->mailController->sendTemplateEmail(
                        'mulakat-reddedildi-mesaji',
                        $user->email,
                        'Burs Başvurunuz İçin Mülakat Sonuçlandırılmıştır',
                        $parameters
                    );
                }
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Mülakat sonuçlandırma mail gönderim hatası: ' . $e->getMessage());
            }

            $timeline = [
                'tc_no' => $user->tc_no,
                'anabaslik' => 'Mülakatı sonuçlandırıldı',
                'baslik' => 'Mülakat sonucu ' . $request->editinterviewResult,
                'text' => $item->interview_score . ' mülakat puanı ile mülakat sonucu ' . $request->editinterviewResult . ' olarak belirlendi.',
            ];
            $this->ortakcontroller->addNewTimeline($timeline['tc_no'], $timeline['anabaslik'], $timeline['baslik'], $timeline['text']);
        }

        return redirect()->back();
    }

    public function endInterview(Request $request)
    {

        $id = $request->input('id');
        $item = NewInterview::find($id);

        $user = NewAnswer::where('tc_no', $item->tc_no)->first();
        $interview = NewInterview::where('id', $id)->update([
            'interview_score' => $request->editinterviewScore,
            'interview_result' => $request->editinterviewResult,
        ]);
        $item = NewInterview::find($id);

        $this->checkResult($interview);
        if ($interview) {
            $user->mulakat_durumu = $request->editinterviewResult;
            $user->save();
            // Mülakat sonucuna göre template email gönder
            try {
                if ($request->editinterviewResult == 'Olumlu') {
                    // Olumlu sonuç için template parametrelerini hazırla
                    $parameters = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'interview_date' => $item->interview_date,
                        'interview_time' => $item->interview_time,
                        'interview_type' => $item->interview_type,
                    ];

                    // Olumlu sonuç template'ini gönder
                    $this->mailController->sendTemplateEmail(
                        'mulakat-onaylandi-mesaji',
                        $user->email,
                        'Mülakat Sonuçlandırılmıştır',
                        $parameters
                    );
                } else {
                    // Olumsuz sonuç için yeni template sistemi
                    $parameters = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'interview_date' => $item->interview_date,
                        'interview_time' => $item->interview_time,
                        'interview_type' => $item->interview_type,
                    ];

                    // Olumsuz sonuç template'ini gönder
                    $this->mailController->sendTemplateEmail(
                        'mulakat-reddedildi-mesaji',
                        $user->email,
                        'Burs Başvurunuz İçin Mülakat Sonuçlandırılmıştır',
                        $parameters
                    );
                }
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Mülakat sonuçlandırma mail gönderim hatası: ' . $e->getMessage());
            }

            \App\Models\InterviewTimeline::create([
                'interview_id' => $item->id,
                'title' => 'Mülakat Sonuçlandırıldı',
                'text' => "Mülakat başarıyla sonuçlandırıldı.\nSonuç: {$request->editinterviewResult}\nMülakat Puanı: {$item->interview_score}",
                'topTitle' => 'Mülakat Süreci'
            ]);
        }

        return redirect()->back();
    }

    public function registration_renewal_details()
    {
        return view('panel.registration-renewal-details');

    }

    public function mezunlar()
    {
        session(['sidebar' => 7]);

        $scholars = ScholarForm::with(['documents', 'educinfo', 'scholar', 'infos'])->where('status', '2')->get();

        $result = [
            'scholars' => $scholars,
        ];

        return view('panel.graduate-scholar.index', $result);

    }

    public function bursiyerdetay()
    {
        return view('panel.candidate-update-details');

    }

    public function bursiyerler()
    {
        session(['sidebar' => 5]);

        $scholars = ScholarForm::with(['documents', 'educinfo', 'scholar', 'infos'])
            ->whereHas('scholar', function ($query) {
                $query->whereNotNull('email');
            })->whereIn('status', ['3', '4'])
            ->get();
        $result = [
            'scholars' => $scholars,
        ];

        return view('panel.scholarship-recipient-list.index', $result);

    }

    public function kayityenileme()
    {
        session(['sidebar' => 4]);

        $renews = RenewForm::with([
            'scholar.form' => function ($query) {
                $query->latest(); // En son veriyi getir
            },
            'infos'
        ])
            ->whereHas('infos')
            ->get();
        $filteredRenews = $renews->filter(function ($renew) {
            return !is_null($renew->scholar); // scholar ilişkisi null olmayanları al
        });
        $result = ['renews' => $filteredRenews];

        return view('panel.registration-renewal.index', $result);

    }

    public function deleteRenewScholarDocsPortal($id, $file)
    {
        $doc = RenewAnswer::where('form_id', $id)->first();

        if ($doc) {
            // Dosya yolunu al
            $filePath = $doc->{$file}; // $file, dosya yolunu içermeli
            $cleanPath = preg_replace('/^\/storage\//', '', $filePath);

            // Dosyayı storage'dan sil
            if (Storage::disk('public')->exists($cleanPath)) {
                Storage::disk('public')->delete($cleanPath);
            }

            // Veritabanındaki dosya bilgisini temizle
            $doc->{$file} = null;
            $doc->save();

            return response()->json(['success' => true, 'message' => 'Dosya başarıyla silindi.']);
        }

        return response()->json(['success' => false, 'message' => 'Dosya bulunamadı.'], 404);
    }

    private function tekrarlayanBursTemizle($id)
    {
        $burslar = RenewOtherScholarshipDetails::where('form_id', $id)->get();
        $grupluBurslar = $burslar->groupBy('company_name');

        foreach ($grupluBurslar as $companyName => $bursGroup) {
            if ($bursGroup->count() > 1) {
                // İlk kaydı koru, diğerlerini sil
                $ilkKayit = $bursGroup->first();
                $bursGroup->slice(1)->each(function ($burs) {
                    $burs->delete();
                });
            }
        }
    }

    public function kayitYenilemeDetay($id)
    {
        $this->tekrarlayanBursTemizle($id);
        $sebepler = Sebep::orderBy('text', 'asc')->get();
        $unis = TanimUnivercity::all();
        $aday = RenewForm::with(['scholar.docverify', 'infos', 'infos.notes', 'period', 'documents', 'scholar', 'scholars', 'kardesler', 'infos.otherScholarships'])->where('id', $id)->first();
        $period = Period::where('id', $aday->period_id)->first();

        $belgeler = Soru::where('type', 'file')->get();
        if ($aday) {
            $result['bursTipleri'] = $this->bursTipleriForEducationType($aday->infos->educationType ?? null);
            $result['belgeler'] = $belgeler;
            $result['period'] = $period;
            $result['aday'] = $aday;
            $result['unis'] = $unis;
            $result['documents'] = $this->belgeadlarigetir();
            $result['periods'] = Period::where('id', $period->id)->get();
            $result['cities'] = Il::all();
            $result['sebepler'] = $sebepler;
            $result['bankNames'] = Soru::getBankNames();
            $result['latestPhoto'] = $aday->scholar->latestPhoto();

            return view('panel.renew-update-details.index', $result);
        } else {
            return redirect()->route('kayityenileme');
        }
    }

    public function kayitYenilemeDetayYonlendir($id)
    {
        $scholar = RenewAnswer::where('id', $id)->first();

        return redirect()->route('kayitYenilemeDetay', ['id' => $scholar->form_id]);
    }

    public function getNewScholarSibling($id)
    {
        $sibling = NewSiblingDetails::find($id);

        return response()->json(['sibling' => $sibling]);
    }

    public function addNewScholarSibling(Request $request)
    {
        $data = $request->all();
        $result = NewSiblingDetails::create($data);

        return redirect()->back();

    }

    public function crmAddNewScholarSibling(Request $request)
    {
        $data = $request->all();
        /*$formid = $data['form_id'];
        $form = ScholarForm::where('id',$formid)->first();
        $scholar = Scholar::where('id',$form->scholar_id)->first();
        unset($data['form_id']);
        $data['tc_no'] = $scholar->tc_no; */
        $result = NewSiblingDetails::create($data);

        return redirect()->back();
    }

    public function addReNewScholarSibling(Request $request)
    {
        $data = $request->all();
        $result = NewSiblingDetails::create($data);

        return redirect()->back();

    }

    public function deleteNewScholarSibling($id)
    {
        $result = NewSiblingDetails::find($id);
        $check = $result->delete();
        $this->checkResult($check);

        return redirect()->back();

    }

    public function deleteRenewScholarSibling($id)
    {
        $result = NewSiblingDetails::find($id);
        $check = $result->delete();
        $this->checkResult($check);

        return redirect()->back();
    }

    public function editNewSiblingDetail(Request $request)
    {
        $item = NewSiblingDetails::find($request->id);
        $item->update($request->all());

        return redirect()->back();

    }

    public function editRenewSiblingDetail(Request $request)
    {
        $item = NewSiblingDetails::find($request->id);
        $item->update($request->all());

        return redirect()->back();
    }

    public function addNewScholarScholarShip(Request $request)
    {
        $data = $request->all();
        NewOtherScholarshipDetails::create($data);

        return redirect()->back();
    }

    public function addRenewScholarScholarShip(Request $request)
    {
        $data = $request->all();
        NewOtherScholarshipDetails::create($data);

        return redirect()->back();
    }

    public function deleteNewScholarScholarShip($id)
    {
        $result = NewOtherScholarshipDetails::find($id);
        $result->delete();

        return redirect()->back();

    }

    public function deleteRenewScholarScholarShip($id)
    {
        $result = NewOtherScholarshipDetails::find($id);
        $result->delete();

        return redirect()->back();
    }

    public function deletenewinterview(Request $request)
    {
        $result = NewInterview::find($request->mulakatid);
        if ($result) {
            $result->delete();
        }

        return redirect()->back();

    }

    public function editNewScholarsDetail(Request $request)
    {
        $item = NewOtherScholarshipDetails::find($request->id);
        $item->update($request->only(['company_name', 'company_type', 'count']));

        return redirect()->back();

    }

    public function editRenewScholarScholarShip(Request $request)
    {
        $item = NewOtherScholarshipDetails::find($request->id);
        $item->update($request->only(['company_name', 'company_type', 'count']));

        return redirect()->back();

    }

    public function send_mail(Request $request)
    {
        $topic = $request->topic;
        $message = $request->emailBody; // Quill.js'den gelen HTML içerik
        $alicilar = $request->alicilar ?? [];

        // Dosya kontrolü ve işleme
        $files = null;
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            // Tek dosya gelirse dizi yap
            if (!is_array($files)) {
                $files = [$files];
            }

            // Her dosyayı kontrol et
            foreach ($files as $file) {
                if (!$file->isValid()) {
                    \Log::error('Dosya yükleme hatası', [
                        'error' => $file->getErrorMessage(),
                        'name' => $file->getClientOriginalName(),
                    ]);

                    return redirect()->back()->with('error', 'Dosya yüklenirken hata oluştu: ' . $file->getClientOriginalName());
                }

                // Dosya boyutu kontrolü (25MB)
                if ($file->getSize() > 25 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Dosya boyutu 25MB\'dan büyük olamaz');
                }

                // Dosya tipi kontrolü
                $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    return redirect()->back()->with('error', 'Sadece JPG, PNG ve PDF dosyaları yüklenebilir');
                }

                \Log::info('send_mail: Ek dosya alındı', [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                ]);
            }
        } else {
            \Log::info('send_mail: Ek dosya yok');
        }

        try {
            // Quill.js'den gelen HTML içeriği logla
            \Log::info('Quill.js HTML içeriği alındı', [
                'topic' => $topic,
                'message_length' => strlen($message),
                'message_preview' => substr($message, 0, 200) . '...',
                'alici_count' => count($alicilar),
            ]);

            foreach ($alicilar as $alici) {
                $this->mailController->sendMail($topic, $alici, $message, $files);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Mail gönderme hatası', ['error' => $e->getMessage()]);

            return response()->json(['success' => false, 'error' => 'Mail gönderilirken hata oluştu: ' . $e->getMessage()]);
        }
    }

    public function deleteNewScholars(Request $request)
    {
        $alicilar = $request->alicilar;

        return $alicilar;
    }

    public function sendMail($eposta)
    {
        $alici = NewAnswer::where('email', $eposta)->get();
        if ($alici->isEmpty()) {
            $alici = Scholar::where('email', $eposta)->get();
        }

        $result = [
            'alici' => $alici,
            'bursiyerler' => Scholar::all(),
            'adaylar' => NewAnswer::all(),
            'aliciSayisi' => $alici->count()
        ];

        return view('panel.send-mail', $result);
    }

    public function multipleSendMailPage()
    {
        // Session'dan veriyi al
        $scholars = session()->get('scholars', collect([]));

        $result = [
            'alici' => $scholars,
            'aliciSayisi' => $scholars->count(),
            'bursiyerler' => Scholar::all(),
            'adaylar' => NewAnswer::all(),
        ];

        // View'a veriyi gönder
        return view('panel.send-mail', $result);
    }

    public function deleteinterviewsingle($id)
    {
        $result = NewInterview::where('id', $id)->delete();
        if ($result) {
            session()->flash('success', 'İşlem Başarılı!');
        } else {
            session()->flash('error', 'İşlem Başarısız!');
        }

    }

    public function deleteInterviews(Request $request)
    {
        $ids = $request->input('ids'); // Kullanıcı ID'leri
        $islemId = $request->input('islemId'); // İşlem ID'si
        switch ($islemId) {

            case 1:
                foreach ($ids as $id) {
                    $result = $this->deleteinterviewsingle($id);
                }
                break;
        }

        // İsteğin başarılı olduğunu döndürüyoruz
        return response()->json([
            'result' => $result,
        ]);
    }

    public function multipleSendMail(Request $request)
    {
        // Gelen e-posta adreslerini al
        $emails = $request->input('emails');

        // E-posta adreslerini kontrol et
        if (!is_array($emails)) {
            return response()->json(['error' => 'Geçersiz e-posta listesi.'], 400);
        }

        // İlgili kişileri bul
        $scholars = NewAnswer::whereIn('email', $emails)->get();

        // Kişiler bulunamazsa, diğer tablodan kontrol et
        if ($scholars->isEmpty()) {
            $scholars = Scholar::whereIn('email', $emails)->get();
        }

        // Veriyi session'a kaydet
        session()->put('scholars', $scholars);

        // Yönlendirme URL'si
        $redirectUrl = route('redirectmultiplemail');

        // JSON formatında yönlendirme URL'sini döndür
        return response()->json(['redirectUrl' => $redirectUrl]);
    }

    public function multipleSendSms(Request $request)
    {
        // Gelen telefon numaralarını al
        $phones = $request->input('tel');

        // Telefon numaralarını kontrol et
        if (!is_array($phones)) {
            return response()->json(['error' => 'Geçersiz telefon listesi.'], 400);
        }

        // İlgili kişileri bul
        $scholars = NewAnswer::whereIn('tel_no', $phones)->get();

        // Kişiler bulunamazsa, diğer tablodan kontrol et
        if ($scholars->isEmpty()) {
            $scholars = Scholar::whereIn('tel_no', $phones)->get();
        }

        // Veriyi session'a kaydet
        session()->put('scholars', $scholars);

        // Yönlendirme URL'si
        $redirectUrl = route('Coklu-Sms');

        // JSON formatında yönlendirme URL'sini döndür
        return response()->json(['redirectUrl' => $redirectUrl]);
    }

    public function multipleSendSmsPage()
    {
        // Session'dan veriyi al
        $scholars = session()->get('scholars', collect([]));

        // Eğer scholars bir array ise collection'a çevir (pluck kullanabilmek için)
        if (is_array($scholars)) {
            $scholars = collect($scholars);
        }

        $selectedIds = $scholars->pluck('id')->toArray();

        // View'a gönderilecek veriyi hazırla
        $result = [
            'alici' => $scholars,  // Seçili kişiler
            'aliciSayisi' => $scholars->count(),
            'bursiyerler' => Scholar::whereNotIn('id', $selectedIds)->get(), // Seçili olmayanlar
            'adaylar' => NewAnswer::whereNotIn('id', $selectedIds)->get(),    // Seçili olmayanlar
        ];

        // View'a veriyi gönder
        return view('panel.send-sms', $result);
    }

    public function send_sms()
    {
        $result = [
            'alici' => [],
            'aliciSayisi' => 0,
            'bursiyerler' => Scholar::all(),
            'adaylar' => NewAnswer::all(),
        ];

        return view('panel.send-sms', $result);
    }

    public function graduateScholarDetails($id)
    {
        session(['sidebar' => 7]);
        $folder = 'panel.';
        $subfolder = 'graduate-scholar-details.';
        $viewfile = 'index';
        $belgeler = Soru::where('type', 'file')->get();
        $aday = ScholarForm::with(['scholar.logs', 'digerBursInfo', 'scholar.docverify', 'period', 'job', 'documents', 'scholar', 'scholars', 'scholar.kardesler', 'scholar.interviews', 'infos', 'infos.otherScholarships'])->where('id', $id)->first();
        $period = ScholarForm::where('id', $id)->first();
        $scholar_id = ScholarForm::where('id', $id)->first()->scholar_id;
        $allForms = ScholarForm::with('period')->where('scholar_id', $scholar_id)->get();
        $unis = TanimUnivercity::orderBy('name')->get();

        if ($aday) {
            $latestPhoto = $aday->scholar->latestPhoto();
            $periods = [];
            foreach ($allForms as $form) {
                if ($form->period) {
                    $periods[] = (object) [
                        'id' => $form->period->id,
                        'title' => $form->period->title,
                    ];
                }
            }

            $result['period'] = $period;
            $result['aday'] = $aday;
            $result['belgeler'] = $belgeler;
            $result['periods'] = $periods;
            $result['cities'] = Il::all();
            $result['bankNames'] = Soru::getBankNames();
            $result['unis'] = $unis;
            $result['latestPhoto'] = $latestPhoto;

            return view($folder . $subfolder . $viewfile, $result);
        }

        return redirect()->route('mezunlar');
    }

    public function belgeadlarigetir()
    {
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

    // Form Sorulari
    public function formSoruKategorileriGetir()
    {
        session(['sidebar' => 16]);

        $vFolder = 'panel.';
        $subFolder = 'tanimlar.';
        $lastFolder = 'questionCategories.';
        $data = SoruKategori::orderBy('siralama', 'asc')->get();
        $result = ['kategoriler' => $data];

        return view($vFolder . $subFolder . $lastFolder . 'index', $result);
    }

    public function formSoruKategoriDetay($id)
    {
        $vFolder = 'panel.';
        $subFolder = 'tanimlar.';
        $lastFolder = 'questionCategories.';
        $data = SoruKategori::where('id', $id)
            ->with([
                'soru' => function ($query) {
                    $query->orderBy('siralama', 'asc');
                },
                'forms',
            ])
            ->first();
        $result = ['category' => $data];

        return view($vFolder . $subFolder . $lastFolder . 'edit', $result);
    }

    public function storeFormSoruKategori(Request $request)
    {
        if (SoruKategori::where('title', $request->title)->first()) {
            session()->flash('error', 'İşlem Başarısız! Aynı isimde bir kategori mevcut');

            return redirect()->back();
        }

        $item = new SoruKategori;
        $item->title = $request->title;
        $item->status = 'Aktif';
        $item->forms = json_encode($request->input('forms'));

        $item->siralama = SoruKategori::count() + 1;
        $result = $item->save();
        $this->checkResult($result);

        return redirect()->route('form-sorulari-kategoriler');
    }

    public function createTableForQuestionCategory($title)
    {
        $this->createTableForNew($title);
        $this->createTableForActive($title);
        $this->createTableForRenew($title);
    }

    public function createTableForNew($title)
    {
        $title = 'new_' . $title . '_infos';
        if (!Schema::hasTable($title)) {
            Schema::create($title, function (Blueprint $table) {
                $table->id(); // Auto increment ID sütunu
                $table->string('tc_no'); // Title sütunu
                $table->timestamps(); // Oluşturma ve güncelleme tarihleri için timestamps sütunları
            });
        } else {
            session()->flash('error', 'İşlem Başarısız! Aynı tablo adini kullanan bir kategori mevcut');
        }
    }

    public function createTableForRenew($title)
    {
        $title = 'renew_' . $title . '_infos';
        if (!Schema::hasTable($title)) {
            Schema::create($title, function (Blueprint $table) {
                $table->id(); // Auto increment ID sütunu
                $table->string('form_id'); // Title sütunu
                $table->timestamps(); // Oluşturma ve güncelleme tarihleri için timestamps sütunları
            });
        }
    }

    public function createTableForActive($title)
    {
        $title = 'active_' . $title . '_infos';
        if (!Schema::hasTable($title)) {
            Schema::create($title, function (Blueprint $table) {
                $table->id(); // Auto increment ID sütunu
                $table->string('form_id'); // Title sütunu
                $table->timestamps(); // Oluşturma ve güncelleme tarihleri için timestamps sütunları
            });
        }
    }

    public function updateFormSoruKategori(Request $request)
    {
        $titlecategory = SoruKategori::where('title', $request->title)->first();
        if (!is_null($titlecategory) && $titlecategory->id != $request->id) {
            session()->flash('error', 'İşlem Başarısız! Aynı isimde bir kategori mevcut');

            return redirect()->back();
        }

        $item = SoruKategori::find($request->id);
        $item->title = $request->title;
        $item->status = $request->status;
        $item->forms = json_encode($request->input('forms'));
        $result = $item->save();

        $this->checkResult($result);

        return redirect()->back();
    }

    public function generateformsorudbkey()
    {
        // Harfler ve rakamlar içeren bir karakter kümesi oluşturuyoruz
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $dbkey = '';

        // İlk karakter harf olmalı
        $dbkey .= $characters[rand(0, 51)]; // Sadece harflerden (ilk 52 karakter) alıyor

        // Geriye kalan karakterleri rastgele seçiyoruz
        for ($i = 1; $i < 12; $i++) {
            $dbkey .= $characters[rand(0, $charactersLength - 1)];
        }

        $dbcheck = Soru::where('db_key', $dbkey)->first();
        if ($dbcheck) {
            $dbkey = $this->generateformsorudbkey();
        }

        return $dbkey;
    }

    public function storeFormSoru(Request $request)
    {
        if ($request->type == 'select') {
            $options = $request->options;

            // Son 4 elemanı diziden çıkarmak için
            if (count($options) > 4) {
                $options = array_slice($options, 0, -4);
            }

            // Sonuç: $options dizisinde son 4 eleman hariç tüm veriler kalır
            $request->merge(['options' => $options]); // Güncellenmiş options dizisini tekrar request'e ekliyoruz
        }

        $options = json_encode(array_filter($request->input('options'), function ($value) {
            return !is_null($value);
        }));
        $forms = json_encode($request->input('forms'));

        // Koşul işlemleri
        $hasConditions = $request->has('has_conditions') && $request->has_conditions == 'on';
        $conditions = [];
        if ($hasConditions && $request->type == 'number') {
            $conditionOperators = $request->input('condition_operator', []);
            $conditionValues = $request->input('condition_value', []);

            foreach ($conditionOperators as $key => $operator) {
                if (!empty($operator) && !empty($conditionValues[$key])) {
                    $conditions[] = [
                        'operator' => $operator,
                        'value' => $conditionValues[$key],
                    ];
                }
            }
        }

        $db_key = $this->generateformsorudbkey();
        $item = new Soru;
        if ($request->type == 'file') {
            $db_key = 'doc_' . $db_key;
        }
        $item->category_id = $request->category_id;
        if ($request->category_title) {
            $c_title = $request->category_title;
        } else {
            $cat = SoruKategori::find($request->category_id);
            $c_title = $cat->title;
        }
        $item->category_title = $c_title;
        $item->name = $request->name;
        $item->title = $request->title;
        $item->required = $request->required;
        $item->db_key = $db_key;
        $item->form_type = $forms;
        $item->type = $request->type;
        $item->dataset = $request->dataset;
        $item->siralama = Soru::where('category_id', $request->category_id)->count() + 1;
        $item->options = $options;
        $item->has_conditions = $hasConditions;
        $item->conditions = !empty($conditions) ? json_encode($conditions) : null;
        $result = $item->save();
        if (!Schema::hasColumn('new_answers', $db_key)) {
            // Eğer sütun yoksa ekle
            Schema::table('new_answers', function (Blueprint $table) use ($db_key) {
                $table->text($db_key)->nullable();
            });
            Schema::table('renew_answers', function (Blueprint $table) use ($db_key) {
                $table->text($db_key)->nullable();
            });
            Schema::table('active_answers', function (Blueprint $table) use ($db_key) {
                $table->text($db_key)->nullable();
            });
        }
        if ($item->type == 'file') {
            $this->belgeAlanlariOlustur($db_key);
        }

        $this->checkResult($result);

        return redirect()->back();
    }

    public function belgeAlanlariOlustur($db_key)
    {
        $new_dbkey = 'doc_' . $db_key;

        Schema::table('new_documents', function (Blueprint $table) use ($new_dbkey) {
            $table->text($new_dbkey)->nullable();
        });
        Schema::table('renew_documents', function (Blueprint $table) use ($new_dbkey) {
            $table->text($new_dbkey)->nullable();
        });
        Schema::table('active_documents', function (Blueprint $table) use ($new_dbkey) {
            $table->text($new_dbkey)->nullable();
        });
    }

    public function formSorulariGetir()
    {
        session(['sidebar' => 15]);

        $vFolder = 'panel.';
        $subFolder = 'tanimlar.';
        $lastFolder = 'questions.';
        $data = Soru::with('category')->get();
        $result = [
            'items' => $data,
            'categories' => SoruKategori::where('status', 'Aktif')->orderBy('siralama', 'asc')->get(),
        ];

        return view($vFolder . $subFolder . $lastFolder . 'index', $result);
    }

    // todo
    public function updateFormSoru(Request $request)
    {
        $category = SoruKategori::find($request->category_id);
        $options = $request->input('option', []);
        $points = $request->input('point', []);
        $contradictory = $request->input('is_contradictory', []);

        // Puanlama aralıkları
        $rangeMin = $request->input('range_min', []);
        $rangeMax = $request->input('range_max', []);
        $rangePoints = $request->input('range_points', []);

        // Eski yapıda boş olan seçenekleri temizle
        foreach ($options as $key => $option) {
            if (empty($option)) {
                unset($options[$key]);
                unset($points[$key]); // İlgili puanları da temizle
                unset($contradictory[$key]); // İlgili aykırı verilerini de temizle
            }
        }

        // Puanların JSON formatında olmasını sağla
        $formattedPoints = [];
        foreach ($points as $key => $point) {
            if (is_numeric($point)) {
                $formattedPoints[$key] = $point;
            } else {
                $formattedPoints[$key] = 0; // Varsayılan değer
            }
        }

        // Puanlama aralıkları işlemleri
        $scoringRanges = [];
        if ($request->type == 'number' && !empty($rangeMin)) {
            foreach ($rangeMin as $key => $min) {
                if (!empty($rangePoints[$key]) || $rangePoints[$key] === '0') {
                    $scoringRanges[$key] = [
                        'min' => !empty($min) ? floatval($min) : null,
                        'max' => !empty($rangeMax[$key]) ? floatval($rangeMax[$key]) : null,
                        'points' => intval($rangePoints[$key]),
                    ];
                }
            }
        }

        // Koşul işlemleri
        $hasConditions = $request->has('has_conditions') && $request->has_conditions == 'on';
        $conditions = [];
        if ($hasConditions && $request->type == 'number') {
            $conditionOperators = $request->input('condition_operator', []);
            $conditionValues = $request->input('condition_value', []);

            foreach ($conditionOperators as $key => $operator) {
                if (!empty($operator) && !empty($conditionValues[$key])) {
                    $conditions[] = [
                        'operator' => $operator,
                        'value' => $conditionValues[$key],
                    ];
                }
            }
        }

        // Seçenekleri ve puanları JSON olarak kaydet
        $item = Soru::find($request->id);
        $item->title = $request->title;
        $item->category_id = $request->category_id;
        $item->category_title = $category->title;
        $item->status = $request->status;
        $item->required = $request->required;
        $item->disabled = $request->disabled;
        $item->type = $request->type;
        $item->dataset = $request->dataset;
        $item->form_type = json_encode($request->input('forms'));
        $item->modal_title = $request->modal_title;
        $item->modal_content = $request->modal_content;
        $item->redirect_url = $request->redirect_url;
        // Seçenekleri ve puanları JSON olarak kaydet
        $item->options = json_encode($options);
        $item->points = json_encode($formattedPoints);
        $item->is_contradictory = json_encode($contradictory);
        $item->scoring_ranges = !empty($scoringRanges) ? json_encode($scoringRanges) : null;
        $item->has_conditions = $hasConditions;
        $item->conditions = !empty($conditions) ? json_encode($conditions) : null;
        $item->name = $request->name;
        $result = $item->save();

        $this->checkResult($result);

        return redirect()->back();
    }

    public function formSoruDetay($id)
    {
        $vFolder = 'panel.';
        $subFolder = 'tanimlar.';
        $lastFolder = 'questions.';
        $data = Soru::where('id', $id)->with(['category'])->first();
        $result = [
            'soru' => $data,
            'categories' => SoruKategori::where('status', 'Aktif')->orderBy('siralama', 'asc')->get(),
        ];

        return view($vFolder . $subFolder . $lastFolder . 'edit', $result);
    }

    public function formSoruSil($id)
    {

        $result = Soru::where('id', $id)->delete();
        $this->checkResult($result);

        return redirect()->back();

    }

    public function basvuruFormlariGetir()
    {
        session(['sidebar' => 17]);

        $datas = TanimForm::all();

        return view('panel.tanimlar.forms.index', compact('datas'));
    }

    public function basvuruFormDetay($id)
    {
        $data = TanimForm::find($id);
        $sorular = Soru::whereJsonContains('form_type', $data->type)
            ->with('category')
            ->orderBy('name', 'asc')
            ->get();
        $olmayansorular = Soru::whereJsonDoesntContain('form_type', $data->type)
            ->orderBy('name', 'asc')
            ->get();

        $result = [
            'data' => $data,
            'sorular' => $sorular,
            'olmayansorular' => $olmayansorular,
        ];

        return view('panel.tanimlar.forms.edit', $result);

    }

    public function updateBasvuruForm(Request $request)
    {
        $form = TanimForm::find($request->id);
        $form->title = $request->name;
        $form->save();
        $this->checkResult($form);

        return redirect()->route('basvuru-formlari');
    }

    public function basvuruFormSoruCikart($soruid, $formtype)
    {
        $soru = Soru::find($soruid);

        // form_type alanını JSON dizisi olarak al
        $formTypes = json_decode($soru->form_type, true); // true ile diziye çeviriyoruz

        // $formtype değerini diziden çıkar
        if (($key = array_search($formtype, $formTypes)) !== false) {
            unset($formTypes[$key]); // $formtype'ı diziden çıkar
        }

        // Diziyi tekrar JSON formatına çevir ve güncelle
        $soru->form_type = json_encode(array_values($formTypes)); // array_values ile yeniden indeksleme yapıyoruz
        $result = $soru->save(); // Güncellenmiş soruyu kaydet
        $this->checkResult($result);

        return redirect()->back();

    }

    public function basvuruFormSoruEkle(Request $request)
    {
        $type = $request->type;
        $soru = $request->soru;
        foreach ($soru as $s) {
            $item = Soru::find($s);
            $formTypes = json_decode($item->form_type, true);
            if (!in_array($type, $formTypes)) {
                $formTypes[] = $type;
            }
            $item->form_type = json_encode($formTypes);
            $result = $item->save();
            $this->checkResult($result);
        }

        return redirect()->back();
    }

    public function siraGuncelle(Request $request)
    {
        $sira = $request->input('sira');
        $tabloadi = $request->input('tabloadi');
        foreach ($sira as $index => $id) {
            DB::table($tabloadi)->where('id', $id)->update(['siralama' => $index + 1]);
        }

        return response()->json(['success' => 'Sıralama Düzenleme İşlemi Başarılı!']);

    }

    // Iller
    public function illerIncele()
    {
        session(['sidebar' => 9]);

        $provinces = Il::all();

        return view('panel.tanimlar.provinces.index', compact('provinces'));
    }

    public function ilIncele($id)
    {
        $province = Il::find($id);

        return view('panel.tanimlar.provinces-details.index', compact('province'));

    }

    public function ilekle()
    {
        return view('panel.tanimlar.province-add.index');
    }

    public function ilUpdate(Request $request)
    {
        $data = $request->formData; // Verileri al
        // Doğrudan dizi üzerinden erişim
        $il = Il::find($data['id']);

        // Güncellemeyi gerçekleştir
        $result = $il->update($data);

        return $result;

        return response()->json(['success' => $data]);

        // Başarı mesajı döndürebilirsiniz
    }

    public function ilStore(Request $request)
    {
        $data = $request->formData; // Verileri al

        // Doğrudan dizi üzerinden erişim
        $name = $data['name'];
        $il_no = $data['il_no'];
        if (!Il::where('name', $name)->first() && !Il::where('il_no', $il_no)->first()) {
            Il::create($data);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

        // Başarı mesajı döndürebilirsiniz
    }

    public function ilSil($id)
    {
        Il::where('id', $id)->delete();

        return redirect()->route('get-provinces');
    }

    public function ilcelerGetir()
    {
        session(['sidebar' => 10]);

        $datas = Ilce::with('il')->orderBy('il_no')->get();
        $iller = Il::orderBy('il_no')->get();

        return view('panel.tanimlar.districts.index', compact('datas', 'iller'));

    }

    public function ilceEkle()
    {
        $result = ['provinces' => Il::orderBy('il_no')->get()];

        return view('panel.tanimlar.districts.add', $result);
    }

    public function ilceStore(Request $request)
    {
        $data = $request->formData; // Verileri al
        // Doğrudan dizi üzerinden erişim
        $name = $data['isim'];
        $il_no = $data['il_no_select'];
        $ilkokul = $data['bv_ilkokul'];
        $ortaokul = $data['bv_ortaokul'];
        $lise = $data['bv_lise'];
        if (!Ilce::where('isim', $name)->first()) {
            $ilce = new Ilce;
            $ilce->il_no = $il_no;
            $ilce->isim = $name;
            $ilce->bv_ilkokul = $ilkokul;
            $ilce->bv_ortaokul = $ortaokul;
            $ilce->bv_lise = $lise;
            $ilce->save();
            $ilce->ilce_no = $ilce->id;
            $ilce->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

        // Başarı mesajı döndürebilirsiniz
    }

    public function ilceIncele($id)
    {
        $data = Ilce::where('id', $id)->with('il')->first();
        $result = [
            'data' => $data,
            'provinces' => Il::orderBy('il_no')->get(),
        ];

        return view('panel.tanimlar.district-details.index', $result);
    }

    public function ilceUpdate(Request $request)
    {
        $data = $request->formData; // Verileri al

        // Doğrudan dizi üzerinden erişim
        $il = Ilce::find($data['id']);
        unset($data['il_name_select']);

        // Güncellemeyi gerçekleştir
        $il->update($data);

        return response()->json(['success' => $data]);

        // Başarı mesajı döndürebilirsiniz
    }

    public function ilceSil($id)
    {
        Ilce::where('id', $id)->delete();

        return redirect()->route('get-districts');
    }

    public function ilceTopluSil(Request $request)
    {
        $bursDurum = $request->bursDurum;

        $islemid = $request->islemId;
        $bv_ilkokul = $request->bv_ilkokul;
        $bv_ortaokul = $request->bv_ortaokul;
        $bv_lise = $request->bv_lise;
        $datas = $request->ids;
        if ($islemid == '2') {
            foreach ($datas as $data) {
                $item = Ilce::find($data);
                if ($bv_ilkokul == 1) {
                    $item->bv_ilkokul = $bursDurum;
                }
                if ($bv_ortaokul == 1) {
                    $item->bv_ortaokul = $bursDurum;
                }
                if ($bv_lise == 1) {
                    $item->bv_lise = $bursDurum;
                }
                $item->save();
            }
        }
        if ($islemid == '1') {
            $result = Ilce::whereIn('id', $datas)->delete();
            $this->checkResult($result);
        }

    }

    public function bankalarGetir()
    {
        session(['sidebar' => 11]);

        $data = Bank::all();

        return view('panel.tanimlar.banks.index', compact('data'));

    }

    public function bankaekle()
    {
        return view('panel.tanimlar.banks.add');
    }

    public function bankaIncele($id)
    {
        $bank = Bank::where('id', $id)->first();

        return view('panel.tanimlar.banks.edit', compact('bank'));
    }

    public function bankaSil($id)
    {
        $result = Bank::where('id', $id)->delete();
        $this->checkResult($result);

        return redirect()->route('get-banks');
    }

    public function bankastore(Request $request)
    {
        $bankaAdi = $request->input('formData.bankaAdi');
        $bankaKodu = $request->input('formData.bankaKodu');

        // Banka adını veya kodunu kontrol et
        $existingBank = Bank::where('bank_name', $bankaAdi)
            ->orWhere('bank_code', $bankaKodu)
            ->first();

        if ($existingBank) {
            // Eğer banka zaten varsa hata mesajı döndür
            return response()->json([
                'success' => false,
                'message' => 'Bu banka adı veya kodu zaten mevcut.',
            ], 400);
        }

        // Bankayı ekleme işlemi
        $bank = new Bank;
        $bank->bank_name = $bankaAdi;
        $bank->bank_code = $bankaKodu;
        $bank->save();

        return response()->json([
            'success' => true,
            'message' => 'Banka başarıyla eklendi.',
        ]);

    }

    public function bankaupdate(Request $request)
    {
        $bankaid = $request->input('formData.id');
        $bankaAdi = $request->input('formData.bankaAdi');
        $bankaKodu = $request->input('formData.bankaKodu');

        // Mevcut bankayı bul
        $bank = Bank::find($bankaid);

        if (!$bank) {
            return response()->json([
                'success' => false,
                'message' => 'Banka bulunamadı.',
            ], 404);
        }

        // Eğer isim aynıysa ama kod değiştiyse ve yeni kod başka bir bankada varsa hata ver
        $existingBankWithCode = Bank::where('bank_code', $bankaKodu)
            ->where('id', '!=', $bankaid) // Kendi kaydını hariç tut
            ->first();

        // Eğer kod aynıysa ama isim değiştiyse ve yeni isim başka bir bankada varsa hata ver
        $existingBankWithName = Bank::where('bank_name', $bankaAdi)
            ->where('id', '!=', $bankaid) // Kendi kaydını hariç tut
            ->first();

        // Eğer kod veya isim zaten başka bir bankaya aitse hata döndür
        if ($existingBankWithCode) {
            return response()->json([
                'success' => false,
                'message' => 'Bu banka kodu zaten başka bir bankaya ait.',
            ], 400);
        }

        if ($existingBankWithName) {
            return response()->json([
                'success' => false,
                'message' => 'Bu banka adı zaten başka bir bankaya ait.',
            ], 400);
        }

        // Herhangi bir çakışma yoksa bankayı güncelle
        $bank->bank_name = $bankaAdi;
        $bank->bank_code = $bankaKodu;
        $bank->save();

        return response()->json([
            'success' => true,
            'message' => 'Banka başarıyla güncellendi.',
        ]);
    }

    public function getUnivercities()
    {
        session(['sidebar' => 12]);

        $data = TanimUnivercity::all();

        return view('panel.tanimlar.univercities.index', compact('data'));

    }

    public function addUnivercity()
    {
        $cities = Il::orderBy('name')->get();

        return view('panel.tanimlar.univercities.add', compact('cities'));

    }

    public function editUnivercity($id)
    {
        $cities = Il::orderBy('name')->get();
        $data = TanimUnivercity::find($id);
        $result = [
            'data' => $data,
            'cities' => $cities,
        ];

        return view('panel.tanimlar.univercities.edit', $result);
    }

    public function getFaculties()
    {
        session(['sidebar' => 13]);

        $data = TanimFaculty::with('univercity')->get();
        $univercities = TanimUnivercity::all();
        $result = ['data' => $data, 'univercities' => $univercities];

        return view('panel.tanimlar.faculties.index', $result);

    }

    public function storeFaculty(Request $request)
    {
        $count = TanimFaculty::count() + 1;
        $code = 'FAKU0' . $count;
        $data = $request->input('formData');

        // Banka adını veya kodunu kontrol et
        $existing = TanimFaculty::where('name', $data['name'])
            ->first();

        if ($existing) {
            // Eğer banka zaten varsa hata mesajı döndür
            return response()->json([
                'success' => false,
                'message' => 'Bu Universite adı veya kodu zaten mevcut.',
            ], 400);
        }

        // Bankayı ekleme işlemi
        $bank = new TanimFaculty;
        $bank->name = $data['name'];
        $bank->code = $code;
        $bank->univercity_id = $data['univercity_id'];
        $bank->bv_onlisans = $data['bv_onlisans'];
        $bank->bv_lisans = $data['bv_lisans'];
        $bank->bv_yukseklisans = $data['bv_yukseklisans'];
        $bank->bv_doktora = $data['bv_doktora'];
        $bank->save();

        return response()->json([
            'success' => true,
            'message' => 'Fakulte başarıyla eklendi.',
        ]);

    }

    public function storeUnivercity(Request $request)
    {
        $data = $request->input('formData');
        $bank = new TanimUnivercity;
        $bank->name = $data['name'];
        $bank->code = $data['code'];
        $bank->type = $data['universiteTuru'];
        $bank->city = $data['sehir'];
        $bank->bv_onlisans = $data['bv_onlisans'];
        $bank->bv_lisans = $data['bv_lisans'];
        $bank->bv_yukseklisans = $data['bv_yukseklisans'];
        $bank->bv_doktora = $data['bv_doktora'];
        $result = $bank->save();
        $this->checkResult($result);

        return response()->json([
            'success' => true,
            'message' => 'Üniversite başarıyla eklendi.',
        ]);
    }

    public function UniversiteSil($id)
    {
        $result = TanimUnivercity::where('id', $id)->delete();
        $this->checkResult($result);

        return redirect()->route('get-univercities');
    }

    public function Universiteupdate(Request $request)
    {
        $data = $request->input('formData');

        // Mevcut bankayı bul
        $bank = TanimUnivercity::find($data['id']);

        if (!$bank) {
            return response()->json([
                'success' => false,
                'message' => 'Kayit bulunamadı.',
            ], 404);
        }

        // Eğer isim aynıysa ama kod değiştiyse ve yeni kod başka bir bankada varsa hata ver
        $existingBankWithCode = null;
        if ($data['code'] !== 'Belirtilmedi') {
            $existingBankWithCode = TanimUnivercity::where('code', $data['code'])
                ->where('id', '!=', $data['id']) // Kendi kaydını hariç tut
                ->first();
        }

        // Eğer kod aynıysa ama isim değiştiyse ve yeni isim başka bir bankada varsa hata ver
        $existingBankWithName = TanimUnivercity::where('name', $data['name'])
            ->where('id', '!=', $data['id']) // Kendi kaydını hariç tut
            ->first();

        // Eğer kod veya isim zaten başka bir bankaya aitse hata döndür
        if ($existingBankWithCode) {
            return response()->json([
                'success' => false,
                'message' => 'Bu üniversite kodu zaten başka bir üniversiteye ait.',
            ], 400);
        }

        if ($existingBankWithName) {
            return response()->json([
                'success' => false,
                'message' => 'Bu üniversite adı zaten başka bir üniversiteye ait.',
            ], 400);
        }

        // Herhangi bir çakışma yoksa bankayı güncelle
        $bank->name = $data['name'];
        $bank->code = $data['code'];
        $bank->type = $data['universiteTuru'];
        $bank->city = $data['sehir'];
        $bank->bv_onlisans = $data['bv_onlisans'];
        $bank->bv_lisans = $data['bv_lisans'];
        $bank->bv_yukseklisans = $data['bv_yukseklisans'];
        $bank->bv_doktora = $data['bv_doktora'];
        $bank->save();

        return response()->json([
            'success' => true,
            'message' => 'Banka başarıyla güncellendi.',
        ]);
    }

    public function addFaculty()
    {
        $unis = TanimUnivercity::orderBy('name')->get();
        $cities = Il::orderBy('name')->get();

        $result = [
            'unis' => $unis,
            'cities' => $cities,
        ];

        return view('panel.tanimlar.faculties.add', $result);

    }

    public function editFaculty($id)
    {
        $data = TanimFaculty::with('univercity')->find($id);
        $unis = TanimUnivercity::orderBy('name')->get();
        $cities = Il::orderBy('name')->get();
        $result = [
            'cities' => $cities,
            'data' => $data,
            'unis' => $unis,
        ];

        return view('panel.tanimlar.faculties.edit', $result);
    }

    public function Facultyupdate(Request $request)
    {
        $data = $request->input('formData');
        // Mevcut bankayı bul
        $bank = TanimFaculty::find($data['id']);

        if (!$bank) {
            return response()->json([
                'success' => false,
                'message' => 'Kayit bulunamadı.',
            ], 404);
        }

        // Eğer isim aynıysa ama kod değiştiyse ve yeni kod başka bir bankada varsa hata ver
        $existingBankWithCode = null;
        if ($data['code'] !== 'Belirtilmedi') {
            $existingBankWithCode = TanimFaculty::where('code', $data['code'])
                ->where('id', '!=', $data['id']) // Kendi kaydını hariç tut
                ->first();
        }

        // Eğer kod veya isim zaten başka bir bankaya aitse hata döndür
        if ($existingBankWithCode) {
            return response()->json([
                'success' => false,
                'message' => 'Bu Fakülte kodu zaten başka bir Fakülteye ait.',
            ], 400);
        }

        // Herhangi bir çakışma yoksa bankayı güncelle
        $bank->name = $data['name'];
        $bank->univercity_id = $data['univercity_id'];
        $bank->bv_onlisans = $data['bv_onlisans'];
        $bank->bv_lisans = $data['bv_lisans'];
        $bank->bv_yukseklisans = $data['bv_yukseklisans'];
        $bank->bv_doktora = $data['bv_doktora'];
        $bank->save();

        return response()->json([
            'success' => true,
            'message' => 'Banka başarıyla güncellendi.',
        ]);
    }

    public function FacultyTopluSil(Request $request)
    {

        $bursDurum = $request->bursDurum;

        $islemid = $request->islemId;
        $bv_onlisans = $request->bv_onlisans;
        $bv_lisans = $request->bv_lisans;
        $bv_yukseklisans = $request->bv_yukseklisans;
        $bv_doktora = $request->bv_doktora;
        $datas = $request->ids;
        if ($islemid == '2') {
            foreach ($datas as $data) {
                $item = TanimFaculty::find($data);
                if ($bv_onlisans == 1) {
                    $item->bv_onlisans = $bursDurum;
                }
                if ($bv_lisans == 1) {
                    $item->bv_lisans = $bursDurum;
                }
                if ($bv_yukseklisans == 1) {
                    $item->bv_yukseklisans = $bursDurum;
                }
                if ($bv_doktora == 1) {
                    $item->bv_doktora = $bursDurum;
                }
                $result = $item->save();
            }
        }
        if ($islemid == '1') {
            $result = TanimFaculty::whereIn('id', $datas)->delete();

        }
        $this->checkResult($result);
    }

    public function FaculteSil($id)
    {
        $result = TanimFaculty::where('id', $id)->delete();
        $this->checkResult($result);

        return redirect()->route('get-faculties');
    }

    public function getDepartmants()
    {
        session(['sidebar' => 14]);

        $data = TanimDepartmant::with(['faculty.univercity'])->get();
        $unis = TanimUnivercity::orderBy('name')->get();
        $faculties = TanimFaculty::orderBy('name')->get();
        $result = [
            'data' => $data,
            'unis' => $unis,
            'faculties' => $faculties,
        ];

        return view('panel.tanimlar.departmants.index', $result);

    }

    public function addDepartmant()
    {
        $unis = TanimUnivercity::orderBy('name')->get();

        $result = ['unis' => $unis];

        return view('panel.tanimlar.departmants.add', $result);

    }

    public function editDepartmant($id)
    {
        $unis = TanimUnivercity::orderBy('name')->get();
        $data = TanimDepartmant::with('faculty.univercity')->find($id);
        $result = ['unis' => $unis, 'data' => $data];

        return view('panel.tanimlar.departmants.edit', $result);
    }

    public function storeDepartmant(Request $request)
    {
        $count = TanimDepartmant::count() + 1;
        $code = 'BOL0000' . $count;
        $data = $request->input('formData');

        // Bankayı ekleme işlemi
        $bank = new TanimDepartmant;
        $bank->name = $data['programAdi'];
        $bank->code = $code;
        $bank->faculty_id = $data['fakulteKodu'];
        $bank->education_time = $data['ogretimSuresi'];
        $bank->education_type = $data['ogretimTuru'];
        $bank->grade_type = $data['puanTuru'];
        $bank->bv_onlisans = $data['bv_onlisans'];
        $bank->bv_lisans = $data['bv_lisans'];
        $bank->bv_yukseklisans = $data['bv_yukseklisans'];
        $bank->bv_doktora = $data['bv_doktora'];
        $bank->save();

        return response()->json([
            'success' => true,
            'message' => 'Fakulte başarıyla eklendi.',
        ]);

    }

    public function DepartmantTopluSil(Request $request)
    {

        $bursDurum = $request->bursDurum;

        $islemid = $request->islemId;
        $bv_onlisans = $request->bv_onlisans;
        $bv_lisans = $request->bv_lisans;
        $bv_yukseklisans = $request->bv_yukseklisans;
        $bv_doktora = $request->bv_doktora;
        $datas = $request->ids;
        if ($islemid == '2') {
            foreach ($datas as $data) {
                $item = TanimDepartmant::find($data);
                if ($bv_onlisans == 1) {
                    $item->bv_onlisans = $bursDurum;
                }
                if ($bv_lisans == 1) {
                    $item->bv_lisans = $bursDurum;
                }
                if ($bv_yukseklisans == 1) {
                    $item->bv_yukseklisans = $bursDurum;
                }
                if ($bv_doktora == 1) {
                    $item->bv_doktora = $bursDurum;
                }
                $result = $item->save();
            }
        }
        if ($islemid == '1') {
            $result = TanimDepartmant::whereIn('id', $datas)->delete();

        }
        $this->checkResult($result);
    }

    public function Departmantupdate(Request $request)
    {
        $data = $request->input('formData');

        // Mevcut bankayı bul
        $bank = TanimDepartmant::find($data['id']);

        if (!$bank) {
            return response()->json([
                'success' => false,
                'message' => 'Kayit bulunamadı.',
            ], 404);
        }

        $bank->name = $data['programAdi'];
        $bank->faculty_id = $data['fakulteKodu'];
        $bank->education_time = $data['ogretimSuresi'];
        $bank->education_type = $data['ogretimTuru'];
        $bank->grade_type = $data['puanTuru'];
        $bank->bv_onlisans = $data['bv_onlisans'];
        $bank->bv_lisans = $data['bv_lisans'];
        $bank->bv_yukseklisans = $data['bv_yukseklisans'];
        $bank->bv_doktora = $data['bv_doktora'];
        $bank->save();

        return response()->json([
            'success' => true,
            'message' => 'Banka başarıyla güncellendi.',
        ]);
    }

    public function DepartmantSil($id)
    {
        $result = TanimDepartmant::where('id', $id)->delete();
        $this->checkResult($result);

        return redirect()->route('get-faculties');
    }

    public function bankaTopluSil(Request $request)
    {
        $datas = $request->ids;
        $result = Bank::whereIn('id', $datas)->delete();
        $this->checkResult($result);
    }

    // Ortak fonksiyonlar
    public function getUniDetails(Request $request)
    {
        // Gelen univercity_id'yi al
        $univercityId = $request->input('univercity_id');

        // Univercity bilgilerini veri tabanından çek
        $uni = TanimUnivercity::where('id', $univercityId)->first();
        $faculties = TanimFaculty::where('univercity_id', $univercityId)->get();

        // Eğer üniversite bulunursa, verileri döndür
        if ($uni) {
            return response()->json([
                'type' => $uni->type,
                'city' => $uni->city,
                'faculties' => $faculties, // Fakülteleri JSON formatında döndür
            ]);
        }

        // Eğer üniversite bulunamazsa hata döndür
        return response()->json([
            'error' => 'University not found!',
        ], 404);
    }

    public function mulakatdetail(Request $request)
    {
        return response()->json(['data' => NewInterview::find($request->id)]);
    }

    public function belgedurumdegis($name, $tc, $period, $durum)
    {
        $periodid = Period::where('title', $period)->value('id');
        if ($periodid == null) {
            $periodid = $period;
        }
        // Period ID'yi integer'a çevirelim ya da doğru period ID'yi bulalım
        $result = $document = VerifyDocument::where('doc_name', $name)
            ->where('tc_no', $tc)
            ->where('period_id', $periodid)
            ->first();
        if ($document) {
            $document->status = $durum;
            $document->save();
        } else {
            $result = VerifyDocument::create([
                'doc_name' => $name,
                'tc_no' => $tc,
                'period_id' => $periodid,
                'status' => $durum,
            ]);
        }

        $statusText = $durum == 1 ? 'onaylandı' : 'reddedildi';
        $periodTitle = Period::find($periodid)->title ?? $periodid;
        aday_timeline_log(
            $tc,
            'Belge',
            'Belge durumu güncellendi',
            sprintf(
                '%s belgesi %s (%s). İşlem yapan: %s',
                $this->getActiveDocumentLabel($name),
                $statusText,
                $periodTitle,
                timeline_islem_yapan_for_request()
            )
        );

        $this->checkResult($result);
    }

    public function topluBelgeYonet(Request $request)
    {
        $userIds = $request->input('userIds');
        $tc = $request->input('tc');
        $period = $request->input('period');
        $islemId = $request->input('islemId');

        switch ($islemId) {
            case 1:
                foreach ($userIds as $id) {
                    $result = $this->belgedurumdegis($id, $tc, $period, 1);
                }
                break;
            case 2:
                foreach ($userIds as $id) {
                    $result = $this->belgedurumdegis($id, $tc, $period, 2);
                }
                break;
            case 3:
                try {
                    if (!file_exists(storage_path('app/public/temp'))) {
                        mkdir(storage_path('app/public/temp'), 0777, true);
                    }

                    $zip = new \ZipArchive;
                    $fileName = 'belgeler_' . time() . '.zip';
                    $zipPath = storage_path('app/public/temp/' . $fileName);

                    if ($zip->open($zipPath, \ZipArchive::CREATE) === true) {
                        $dosyaEklendi = false;

                        foreach ($userIds as $docName) {
                            $searchKey = $docName;

                            $document = NewAnswer::where('tc_no', $tc)
                                ->where($searchKey, '!=', '')
                                ->whereNotNull($searchKey)
                                ->first();

                            if ($document && $document->$searchKey) {
                                // Dosya yolunu düzelt
                                $relativePath = trim($document->$searchKey, '/');
                                $relativePath = str_replace('storage/', '', $relativePath);

                                // Doğru dosya yolu
                                $filePath = base_path('storage/' . $relativePath);

                                \Log::info('Dosya Yolu Kontrolü:', [
                                    'original_path' => $document->$searchKey,
                                    'relative_path' => $relativePath,
                                    'file_path' => $filePath,
                                    'exists' => file_exists($filePath),
                                ]);

                                if (file_exists($filePath)) {
                                    try {
                                        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                        $newFileName = $docName . '.' . $fileExtension;

                                        $addResult = $zip->addFile($filePath, $newFileName);
                                        $dosyaEklendi = $addResult;

                                        \Log::info('Dosya Zipe Eklendi:', [
                                            'path' => $filePath,
                                            'newFileName' => $newFileName,
                                            'result' => $addResult,
                                        ]);
                                    } catch (\Exception $e) {
                                        \Log::error('Zip Ekleme Hatası:', [
                                            'error' => $e->getMessage(),
                                            'file' => $filePath,
                                        ]);
                                    }
                                } else {
                                    \Log::error('Dosya Bulunamadı:', [
                                        'original_path' => $document->$searchKey,
                                        'checked_path' => $filePath,
                                    ]);
                                }
                            }
                        }

                        $zip->close();

                        if ($dosyaEklendi) {
                            return response()->download($zipPath)->deleteFileAfterSend(true);
                        } else {
                            if (file_exists($zipPath)) {
                                unlink($zipPath);
                            }

                            return response()->json(['error' => 'İndirilecek dosya bulunamadı'], 404);
                        }
                    }

                    return response()->json(['error' => 'Zip dosyası oluşturulamadı'], 500);

                } catch (\Exception $e) {
                    \Log::error('Genel Hata:', [
                        'error' => $e->getMessage(),
                    ]);

                    return response()->json(['error' => 'Dosya işleme hatası: ' . $e->getMessage()], 500);
                }
                break;
        }

        return response()->json([
            'data' => $userIds,
            'islemId' => $islemId,
            'result' => $result ?? null,
        ]);
    }

    public function activeScholarDocs(Request $request)
    {
        $userIds = $request->input('userIds');
        $period = $request->input('period');
        $islemId = $request->input('islemId');
        $form_id = $request->input('form_id');
        $scholar_id = ScholarForm::where('id', $form_id)->first()->scholar_id;
        $form_id = ScholarForm::where(['scholar_id' => $scholar_id, 'period_id' => $period])->first()->id;
        switch ($islemId) {
            // Toplu indirme
            case 3:
                try {
                    if (!file_exists(storage_path('app/public/temp'))) {
                        mkdir(storage_path('app/public/temp'), 0777, true);
                    }

                    $zip = new \ZipArchive;
                    $fileName = 'belgeler_' . time() . '.zip';
                    $zipPath = storage_path('app/public/temp/' . $fileName);

                    if ($zip->open($zipPath, \ZipArchive::CREATE) === true) {
                        $dosyaEklendi = false;

                        foreach ($userIds as $docName) {
                            $searchKey = $docName;

                            $document = ActiveAnswer::where('form_id', $form_id)
                                ->where($searchKey, '!=', '')
                                ->whereNotNull($searchKey)
                                ->first();
                            if ($document && $document->$searchKey) {
                                // Dosya yolunu düzelt
                                $relativePath = trim($document->$searchKey, '/');
                                $relativePath = str_replace('storage/', '', $relativePath);
                                // Doğru dosya yolu
                                $filePath = base_path('storage/' . $relativePath);
                                \Log::info('Dosya Yolu Kontrolü:', [
                                    'original_path' => $document->$searchKey,
                                    'relative_path' => $relativePath,
                                    'file_path' => $filePath,
                                    'exists' => file_exists($filePath),
                                ]);

                                if (file_exists($filePath)) {
                                    try {
                                        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                        $newFileName = $document->name . '_' . $document->surname . '_' . $docName . '.' . $fileExtension;

                                        $addResult = $zip->addFile($filePath, $newFileName);
                                        $dosyaEklendi = $addResult;

                                        \Log::info('Dosya Zipe Eklendi:', [
                                            'path' => $filePath,
                                            'newFileName' => $newFileName,
                                            'result' => $addResult,
                                        ]);
                                    } catch (\Exception $e) {
                                        \Log::error('Zip Ekleme Hatası:', [
                                            'error' => $e->getMessage(),
                                            'file' => $filePath,
                                        ]);
                                    }
                                } else {
                                    \Log::error('Dosya Bulunamadı:', [
                                        'original_path' => $document->$searchKey,
                                        'checked_path' => $filePath,
                                    ]);
                                }
                            }
                        }

                        $zip->close();

                        if ($dosyaEklendi) {
                            return response()->download($zipPath)->deleteFileAfterSend(true);
                        } else {
                            if (file_exists($zipPath)) {
                                unlink($zipPath);
                            }

                            return response()->json(['error' => 'İndirilecek dosya bulunamadı'], 404);
                        }
                    }

                    return response()->json(['error' => 'Zip dosyası oluşturulamadı'], 500);

                } catch (\Exception $e) {
                    \Log::error('Genel Hata:', [
                        'error' => $e->getMessage(),
                    ]);

                    return response()->json(['error' => 'Dosya işleme hatası: ' . $e->getMessage()], 500);
                }
                break;
        }
    }

    public function kyScholarDocs(Request $request)
    {
        $userIds = $request->input('userIds');
        $form_id = $request->input('form_id');
        $period = $request->input('period');
        $islemId = $request->input('islemId');
        $aday = RenewAnswer::where('tc_no', $request->input('tc'))->first();
        switch ($islemId) {
            // Toplu indirme
            case 3:
                try {
                    if (!file_exists(storage_path('app/public/temp'))) {
                        mkdir(storage_path('app/public/temp'), 0777, true);
                    }

                    $zip = new \ZipArchive;
                    $fileName = $aday->name . '_' . $aday->surname . '_belgeler_' . time() . '.zip';
                    $zipPath = storage_path('app/public/temp/' . $fileName);

                    if ($zip->open($zipPath, \ZipArchive::CREATE) === true) {
                        $dosyaEklendi = false;

                        foreach ($userIds as $docName) {
                            $searchKey = $docName;

                            $document = RenewAnswer::where('tc_no', $aday->tc_no)
                                ->where($searchKey, '!=', '')
                                ->whereNotNull($searchKey)
                                ->first();

                            if ($document && $document->$searchKey) {
                                // Dosya yolunu düzelt
                                $relativePath = trim($document->$searchKey, '/');
                                $relativePath = str_replace('storage/', '', $relativePath);

                                // Doğru dosya yolu
                                $filePath = base_path('storage/' . $relativePath);

                                \Log::info('Dosya Yolu Kontrol��:', [
                                    'original_path' => $document->$searchKey,
                                    'relative_path' => $relativePath,
                                    'file_path' => $filePath,
                                    'exists' => file_exists($filePath), // Dosya var mı kontrolü
                                ]);

                                if (file_exists($filePath)) {
                                    try {
                                        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                        $newFileName = $document->name . '_' . $document->surname . '_' . $docName . '.' . $fileExtension;

                                        $addResult = $zip->addFile($filePath, $newFileName);
                                        $dosyaEklendi = $addResult;

                                        \Log::info('Dosya Zipe Eklendi:', [
                                            'path' => $filePath,
                                            'newFileName' => $newFileName,
                                            'result' => $addResult,
                                        ]);
                                    } catch (\Exception $e) {
                                        \Log::error('Zip Ekleme Hatası:', [
                                            'error' => $e->getMessage(),
                                            'file' => $filePath,
                                        ]);
                                    }
                                } else {
                                    \Log::error('Dosya Bulunamadı:', [
                                        'original_path' => $document->$searchKey,
                                        'checked_path' => $filePath,
                                    ]);

                                    // Hata mesajı ekleyin
                                    return response()->json(['error' => 'Dosya bulunamadı: ' . $filePath], 404);
                                }
                            }
                        }

                        $zip->close();

                        if ($dosyaEklendi) {
                            return response()->download($zipPath)->deleteFileAfterSend(true);
                        } else {
                            if (file_exists($zipPath)) {
                                unlink($zipPath);
                            }

                            return response()->json(['error' => 'İndirilecek dosya bulunamadı'], 404);
                        }
                    }

                    return response()->json(['error' => 'Zip dosyası oluşturulamadı'], 500);

                } catch (\Exception $e) {
                    \Log::error('Genel Hata:', [
                        'error' => $e->getMessage(),
                    ]);

                    return response()->json(['error' => 'Dosya işleme hatası: ' . $e->getMessage()], 500);
                }
                break;
        }
    }

    public function addScholarNote(Request $request)
    {
        $note = ScholarNote::create([
            'title' => $request->title,
            'text' => $request->text,
            'tc_no' => $request->tc_no,
        ]);
        $user = User::find(Auth::user()->id);
        $this->ortakcontroller->addNewTimeline($request->tc_no, $user->name . ' ' . $user->surname . ' tarafından Not Eklendi', $request->title, $request->text);

        return response()->json([
            'success' => true,
            'note' => $note,
        ]);
    }

    public function deleteNote($id)
    {
        $note = ScholarNote::find($id);
        $note->delete();

        return redirect()->back()->with('success', 'Not Silindi');
    }

    public function getScholarNotes(Request $request)
    {
        $notes = ScholarNote::where('tc_no', $request->tc_no)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'notes' => $notes,
        ]);
    }

    public function getAllCities()
    {
        return Il::orderBy('name')->get();
    }

    public function getSmsSettings()
    {
        $items = SmsSetting::all();

        return view('panel.settings.sms.index', compact('items'));

    }

    public function addSmsSetting()
    {
        return view('panel.settings.sms.add');
    }

    public function smsSettingStore(Request $request)
    {
        $settings = $request->input('settings', []);

        // Ayarları JSON formatına dönüştür
        $options = json_encode($settings);

        // Yeni bir SmsSetting kaydı oluştur
        $smsSetting = new SmsSetting;
        $smsSetting->options = $options;

        // Diğer gerekli alanları da doldur (örneğin)
        $smsSetting->title = $request->input('title');

        // Kaydı veritabanına kaydet
        $result = $smsSetting->save();

        // İşlem sonucunu kontrol et
        $this->checkResult($result);

        // Yönlendirme yap (örneğin SMS ayarları listesine)
        return redirect()->route('sms-settings');
    }

    public function checkResult($result)
    {
        if ($result) {
            session()->flash('success', 'İşlem Başarılı!');
        } else {
            session()->flash('error', 'İşlem Başarısız!');
        }
    }

    public function prepareSmsSession(Request $request)
    {

        $recipients = collect($request->alici)->map(function ($recipient) {
            return (object) [
                'tel_no' => $recipient['tel'],
                'name' => $recipient['name'],
                'surname' => $recipient['surname'],
            ];
        });
        // Session'a kaydet
        session()->put('scholars', $recipients);

        return response()->json([
            'success' => true,
            'message' => 'Alıcılar kaydedildi',
        ]);

    }

    public function smsPage()
    {
        // Session'dan alıcıları al
        $recipients = session()->get('sms_recipients', collect([]));

        return view('panel.screate-message.send-sms', [
            'alici' => $recipients,
            'smsBalance' => SmsSetting::where('is_active', true)->first()?->balance ?? 0,
        ]);
    }

    /**
     * Örnek verileri eklemek için kullanılan fonksiyon
     */
    public function ornekVeriEkle()
    {

        try {
            // ScholarSeeder'ı çalıştır
            $seeder = new \Database\Seeders\ScholarSeeder;
            $seeder->run();

            // İstatistikleri al
            $stats = [
                'scholars' => \App\Models\Scholar::count(),
                'forms' => \App\Models\ScholarForm::count(),
                'answers' => \App\Models\ActiveAnswer::count(),
            ];

            return response()->json([
                'message' => 'Örnek veriler başarıyla eklendi!',
                'stats' => $stats,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Örnek veriler eklenirken bir hata oluştu!',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkDbColumns()
    {
        $belgeTablolari = ['new_documents', 'renew_documents', 'active_documents'];
        $belgeler = ['ighQjUalaMaC', 'GwE6ihPjXCa0', 'NHax7LHeC7is', 'qPATCAf9VzUI'];
        foreach ($belgeTablolari as $belgeTablosu) {
            foreach ($belgeler as $belge) {
                $belge = 'doc_' . $belge;
                if (!Schema::hasColumn($belgeTablosu, $belge)) {
                    Schema::table($belgeTablosu, function (Blueprint $table) use ($belge) {
                        $table->text($belge)->nullable();
                    });
                }
            }
        }
        if (!Schema::hasColumn('sorus', 'has_conditions')) {
            // Rename the column
            \DB::statement('ALTER TABLE sorus ADD has_conditions BOOLEAN DEFAULT FALSE');
            \DB::statement('ALTER TABLE sorus ADD conditions JSON DEFAULT NULL');
        }
        if (!Schema::hasColumn('sorus', 'scoring_ranges')) {
            \DB::statement('ALTER TABLE sorus ADD scoring_ranges JSON DEFAULT NULL');
        }
        if (!Schema::hasColumn('sorus', 'is_contradictory')) {
            \DB::statement('ALTER TABLE sorus ADD is_contradictory LONGTEXT NULL');
        }
        $cevapFormlari = ['new_answers', 'renew_answers', 'active_answers'];
        $yenialanlar = ['check_ailerizaformu', 'check_bilgidogrulama', 'check_ailebireyleri', 'check_aydinlatma', 'check_acikriza', 'check_taahhutname'];
        foreach ($cevapFormlari as $cevapFormu) {
            foreach ($yenialanlar as $yenialan) {
                if (!Schema::hasColumn($cevapFormu, $yenialan)) {
                    Schema::table($cevapFormu, function (Blueprint $table) use ($yenialan) {
                        $table->text($yenialan)->nullable()->default('on');
                    });
                } else {
                    try {
                        $columnType = \Schema::getColumnType($cevapFormu, $yenialan);
                    } catch (\Throwable $e) {
                        $columnType = null;
                    }

                    if ($columnType !== 'text') {
                        \DB::statement('ALTER TABLE `' . $cevapFormu . '` MODIFY `' . $yenialan . '` LONGTEXT NULL');
                    }

                    $columnInfo = null;
                    try {
                        $columnInfo = \DB::selectOne('SHOW COLUMNS FROM `' . $cevapFormu . '` LIKE ?', [$yenialan]);
                    } catch (\Throwable $e) {
                        $columnInfo = null;
                    }

                    $defaultValue = null;
                    if ($columnInfo) {
                        // MySQL SHOW COLUMNS returns an object with property name 'Default'
                        $defaultValue = is_array($columnInfo) ? ($columnInfo['Default'] ?? null) : ($columnInfo->Default ?? null);
                    }

                    if ($defaultValue !== 'on') {
                        // Set default to 'on'
                        // Note: For some DB engines, setting default on LONGTEXT/TEXT may not be supported.
                        // We still apply per requirement; adjust if your DB restricts this.
                        try {
                            \DB::statement('ALTER TABLE `' . $cevapFormu . '` ALTER `' . $yenialan . '` SET DEFAULT \"on\"');
                        } catch (\Throwable $e) {
                            // Fallback via MODIFY with explicit default
                            try {
                                \DB::statement('ALTER TABLE `' . $cevapFormu . '` MODIFY `' . $yenialan . '` LONGTEXT NULL DEFAULT \"on\"');
                            } catch (\Throwable $e2) {
                                // swallow - some engines do not allow defaults on TEXT
                            }
                        }
                    }
                }
            }
        }

    }
}
