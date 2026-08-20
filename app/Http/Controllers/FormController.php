<?php

namespace App\Http\Controllers;

use App\Models\Aday;

use App\Models\Il;
use App\Models\Ilce;
use App\Models\TanimDepartmant;
use App\Models\TanimFaculty;
use App\Models\TanimUnivercity;
use App\Models\Univercity;
use App\Models\NewBankInfos;
use App\Models\NewDocuments;
use App\Models\NewEducationalInfo;
use App\Models\NewFamilyInfos;
use App\Models\NewHousingInformation;
use App\Models\NewIncomeInfos;
use App\Models\NewJobInfos;
use App\Models\NewObstacledInfos;
use App\Models\NewOtherScholarshipDetails;
use App\Models\NewOtherScholarshipInfos;
use App\Models\NewParentInfo;
use App\Models\NewPersonalnfo;
use App\Models\NewSiblingDetails;
use App\Models\NewSiblingInfos;
use App\Models\NewSocialInfos;
use App\Models\RenewBankInfos;
use App\Models\RenewDocuments;
use App\Models\RenewEducationalInfo;
use App\Models\RenewFamilyInfos;
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
use App\Models\UnivercitysYukseklisans;
use App\Models\RenewSocialInfos;
use App\Models\NewAnswer;
use App\Models\RenewAnswer;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint; // Doğru olan Blueprint'i burada kullanıyoruz

class FormController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
    }

    private function formTimelineActor(): string
    {
        $u = Auth::guard('aday')->user() ?? Auth::guard('bursiyer')->user();

        return $u ? trim($u->name.' '.$u->surname) : 'Kullanıcı';
    }

    private function formTimelineMetin(string $aciklama): string
    {
        return sprintf('%s — İşlem yapan: %s', $aciklama, $this->formTimelineActor());
    }
    public function tabloKayitKontrol($tabloadi,$tc_no){
        $record = DB::table($tabloadi)->where('tc_no', $tc_no)->first();
        if (!$record){
            return false;
        }
        else{
            return true;
        }
    }
    public function renewtabloKayitKontrol($tabloadi,$form_id){
        $record = DB::table($tabloadi)->where('form_id', $form_id)->first();
        if (!$record){
            return false;
        }
        else{
            return true;
        }
    }
    public function formBilgileriGetir()
    {
        $aday = Aday::with(['family','housing','bank','job','disabled','social','income','scholar','scholars','educinfo','parent','personal','sibling','kardesler'])->where('tc_no',Auth::guard('aday')->user()->tc_no)->first();
    }
    public function basvurusorularikaydetdeneme($data)
    {
        // Kullanıcının tc_no bilgisini al
        $data['tc_no'] = Auth::guard('aday')->user()->tc_no;

        // Sabit tablo adı
        $table = 'new_answers';

        // Tablo var mı kontrol et
        if (Schema::hasTable($table)) {
            // Tablodaki mevcut sütunları al
            $columns = Schema::getColumnListing($table);

            // Sadece mevcut sütunlar için veriyi filtrele
            $filteredData = [];
            foreach ($data as $key => $value) {
                if (in_array($key, $columns)) {
                    $filteredData[$key] = $value;
                }
            }

            // Eğer verilecek veri varsa tabloya kaydet
            if (!empty($filteredData)) {
                // `tc_no`'ya göre mevcut kaydı kontrol et
                $existingRecord = DB::table($table)->where('tc_no', $data['tc_no'])->first();

                if ($existingRecord) {
                    // Kayıt varsa güncelle
                    DB::table($table)->where('tc_no', $data['tc_no'])->update($filteredData);
                    return response()->json(['success' => true, 'message' => 'Bilgiler Güncellendi!']);
                } else {
                    // Kayıt yoksa, yeni kayıt oluştur
                    DB::table($table)->insert($filteredData);
                    return response()->json(['success' => true, 'message' => 'Bilgiler Kaydedildi!']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Kaydedilecek bilgi bulunamadı!']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Tablo bulunamadı!']);
        }
    }
    public function BasvuruSorulariIsle($data,$step){
        $this->basvurusorularikaydetdeneme($data);
       /*
        switch ($step) {
            case 1:
                $this->genelBilgileriKaydet($data);
                break;
            case 2:
                $this->kisiselSorularKaydet($data);
                break;
            case 3:
                $this->egitimBilgileriKaydet($data);
                break;
            case 4:
                $this->kalinanYerBilgileriKaydet($data);
                break;
            case 5:
                $this->aileBilgileriniKaydet($data);
                break;
            case 6:
                $this->ebeveynBilgileriKaydet($data);
                break;
            case 7:
                $this->kardesBilgileriKaydet($data);
                break;
            case 8:
                $this->gelirBilgileriKaydet($data);
                break;
            case 9:
                $this->digerBursBilgileriKaydet($data);
                break;
            case 10:
                $this->engelBilgileriKaydet($data);
                break;
            case 11:
                $this->sosyalBilgilerKaydet($data);
                break;
            case 12:
                $this->bankaBilgileriniKaydet($data);
                break;
            case 13:
                $this->isBilgileriKaydet($data);
                break;
        }
        */
       }
    public function onEvetDonustur($data){
        if($data == 'on'){
            return 'Evet';
        }
        else {
            return null;
        }
    }
    public function sosyalBilgilerKaydet($data){
        if (!$this->tabloKayitKontrol('new_social_infos', Auth::guard('aday')->user()->tc_no )){
            return NewSocialInfos::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'platform' => $data['haberKaynak'] ?? null,
                'skills' => $data['gucluYanlar'] ?? null,
                'social_projects' => $data['sosyalProjeler'] ?? null,
                'hobbies' => $data['hobiler'] ?? null,
                'sports' => $data['sporDali'] ?? null,
                'last_books' => $data['kitaplar'] ?? null,
                'message' => $data['mesaj'] ?? null,
            ]);
        }
        else{
            NewSocialInfos::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'platform' => $data['haberKaynak'] ?? null,
                'skills' => $data['gucluYanlar'] ?? null,
                'social_projects' => $data['sosyalProjeler'] ?? null,
                'hobbies' => $data['hobiler'] ?? null,
                'sports' => $data['sporDali'] ?? null,
                'last_books' => $data['kitaplar'] ?? null,
                'message' => $data['mesaj'] ?? null,

            ]);
        }
    }
    public function gelirBilgileriKaydet($data){
        if (!$this->tabloKayitKontrol('new_income_infos', Auth::guard('aday')->user()->tc_no )){
            return NewIncomeInfos::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'income_person' => $data['gecimiSaglayanKisiler'] ?? null,
                'total_person' => $data['saglayanKisilerToplam'] ?? null,
                'father_salary' => $data['babaninGeliri'] ?? null,
                'mother_salary' => $data['anneninGeliri'] ?? null,
                'other_salary' => $data['digerKisilerinGeliri'] ?? null,
                'other_income' => $data['baskaGelir'] ?? null,
                'housing_type' => $data['evTuru'] ?? null,
                'rent_count' => $data['kira'] ?? null,
                'other_detail' => $data['digerAciklama'] ?? null,
                'cc_payment' => $data['krediborcu'] ?? null,
                'job_details' => $data['calısılanIs'] ?? null,

            ]);
        }
        else{
            NewIncomeInfos::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'income_person' => $data['gecimiSaglayanKisiler'] ?? null,
                'total_person' => $data['saglayanKisilerToplam'] ?? null,
                'father_salary' => $data['babaninGeliri'] ?? null,
                'mother_salary' => $data['anneninGeliri'] ?? null,
                'other_salary' => $data['digerKisilerinGeliri'] ?? null,
                'other_income' => $data['baskaGelir'] ?? null,
                'housing_type' => $data['evTuru'] ?? null,
                'rent_count' => $data['kira'] ?? null,
                'other_detail' => $data['digerAciklama'] ?? null,
                'cc_payment' => $data['krediborcu'] ?? null,
                'job_details' => $data['calısılanIs'] ?? null,
            ]);
        }
    }
    public function kardesBilgileriKaydet($data){
        if (!$this->tabloKayitKontrol('new_sibling_infos', Auth::guard('aday')->user()->tc_no )){
            return NewSiblingInfos::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'count' => $data['kardesSayi'] ?? null,
                'educ_count' => $data['okuyanKardes'] ?? null,

            ]);
        }
        else{
            NewSiblingInfos::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'count' => $data['kardesSayi'] ?? null,
                'educ_count' => $data['okuyanKardes'] ?? null,
            ]);
        }
    }
    public function isBilgileriKaydet($data){
        if (!$this->tabloKayitKontrol('new_job_infos', Auth::guard('aday')->user()->tc_no )){
            return NewJobInfos::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'is_working' => $data['employment-status'] ?? null,
                'job_rank' => $data['gorev'] ?? null,
                'sgk' => $data['social-security'] ?? null,
                'salary' => $data['aylikKazanc'] ?? null,
                'company' => $data['kurumAdi'] ?? null,

            ]);
        }
        else{
            NewJobInfos::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'is_working' => $data['employment-status'] ?? null,
                'job_rank' => $data['gorev'] ?? null,
                'sgk' => $data['social-security'] ?? null,
                'salary' => $data['aylikKazanc'] ?? null,
                'company' => $data['kurumAdi'] ?? null,
            ]);
        }
    }
    public function bankaBilgileriniKaydet($data){
        if (!$this->tabloKayitKontrol('new_bank_infos', Auth::guard('aday')->user()->tc_no )){
            return NewBankInfos::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'bank_name' => $data['employment-status'] ?? null,
                'account_number' => $data['hesapNumarasi'] ?? null,
                'iban' => $data['iban'] ?? null,

            ]);
        }
        else{
            NewBankInfos::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'bank_name' => $data['employment-status'] ?? null,
                'account_number' => $data['hesapNumarasi'] ?? null,
                'iban' => $data['iban'] ?? null,
            ]);
        }
    }

    public function engelBilgileriKaydet($data){
        if (!$this->tabloKayitKontrol('new_obstacled_infos', Auth::guard('aday')->user()->tc_no )){
            return NewObstacledInfos::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'detail' => $data['engelAciklama'] ?? null,
                'status' => $data['engelDurumu'] ?? null,

            ]);
        }
        else{
            NewObstacledInfos::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'detail' => $data['engelAciklama'] ?? null,
                'status' => $data['engelDurumu'] ?? null,
            ]);
        }
    }
    public function digerBursBilgileriKaydet($data){
        if (!$this->tabloKayitKontrol('new_other_scholarships_infos', Auth::guard('aday')->user()->tc_no )){
            return NewOtherScholarshipInfos::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'government' => $data['devletBurs'] ?? null,
                'special' => $data['ozelBurs'] ?? null,

            ]);
        }
        else{
            NewOtherScholarshipInfos::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'government' => $data['devletBurs'] ?? null,
                'special' => $data['ozelBurs'] ?? null,
            ]);
        }
    }
    public function bursEkle(Request $request){
        $data = $request->all();

        $kurum = NewOtherScholarshipDetails::where([['company_name',$data['company_name']],['tc_no',Auth::guard('aday')->user()->tc_no]])->first();
        if (!$kurum){
            $burs = NewOtherScholarshipDetails::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'company_name' => $data['company_name'],
                'company_type' => $data['company_type'],
                'count' => $data['count'],
            ]);

            return response()->json($burs); // JSON olarak döndür
        }
        return response()->json(['success'=>false]); // JSON olarak döndür
    }
    public function kyBursEkle(Request $request){
        $data = $request->all();

        $kurum = NewOtherScholarshipDetails::where([['company_name',$data['company_name']],['tc_no',$data['tc_no']]])->first();
        if (!$kurum){
            $burs = NewOtherScholarshipDetails::create([
                'tc_no' => $data['tc_no'],
                'company_name' => $data['company_name'],
                'company_type' => $data['company_type'],
                'count' => $data['count'],
            ]);

            return response()->json($burs); // JSON olarak döndür
        }
        return response()->json(['success'=>false]); // JSON olarak döndür
    }
    public function kardesEkle(Request $request) {
        $data = $request->all();
        $kardes = newSiblingDetails::where([['name',$data['kardesAdi']],['surname',$data['kardesSoyadi']],['tc_no',Auth::guard('aday')->user()->tc_no]])->first();

        if (!$kardes) {
            $kardes = newSiblingDetails::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'name' => $data['kardesAdi'] ?? null,
                'surname' => $data['kardesSoyadi'] ?? null,
                'age' => $data['kardesYasi'] ?? null,
                'educ_status' => $data['kardesEgitimDurumu'] ?? null,
                'maritality' => $data['kardesEvlilik'] ?? null,
                'job' => $data['kardesMeslek'] ?? null,
            ]);
        }

        return response()->json($kardes); // JSON olarak döndür
    }

    public function  kyKardesEkle(Request $request){
        $data = $request->all();
        $kardes = NewSiblingDetails::where([['name',$data['kardesAdi']],['surname',$data['kardesSoyadi']],['tc_no',$data['tc_no']]])->first();

        if (!$kardes) {
            $kardes = NewSiblingDetails::create([
                'tc_no' => $data['tc_no'],
                'name' => $data['kardesAdi'] ?? null,
                'surname' => $data['kardesSoyadi'] ?? null,
                'age' => $data['kardesYasi'] ?? null,
                'educ_status' => $data['kardesEgitimDurumu'] ?? null,
                'maritality' => $data['kardesEvlilik'] ?? null,
                'job' => $data['kardesMeslek'] ?? null,
            ]);
        }

        return response()->json($kardes); // JSON olarak döndür
    }
    public function ebeveynBilgileriKaydet($data){
        if (!$this->tabloKayitKontrol('new_parent_infos', Auth::guard('aday')->user()->tc_no )){
            return NewParentInfo::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'mother_name' => $data['anneAdSoyad'] ?? null,
                'father_name' => $data['babaAdSoyad'] ?? null,
                'parent_together' => $data['anneBabaBirlikte'] ?? null,
                'C9l7SUqOxSvZ' => $data['anneBabaSag'] ?? null,
                'mother_alive' => $data['anneBabaSag'] ?? null,
                'mother_company' => $data['anneninSosyalGuvenlik'] ?? null,
                'father_company' => $data['babaninSosyalGuvenlik'] ?? null,
                'mother_job' => $data['anneninMeslegi'] ?? null,
                'father_job' => $data['babaninMeslegi'] ?? null,
                'father_educ' => $data['babaninTahsilDurumu'] ?? null,
                'mother_educ' => $data['anneninTahsilDurumu'] ?? null,
            ]);
        }
        else{
            NewParentInfo::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'mother_name' => $data['anneAdSoyad'] ?? null,
                'father_name' => $data['babaAdSoyad'] ?? null,
                'parent_together' => $data['anneBabaBirlikte'] ?? null,
                'C9l7SUqOxSvZ' => $data['anneBabaSag'] ?? null,
                'mother_alive' => $data['anneBabaSag'] ?? null,
                'mother_company' => $data['anneninSosyalGuvenlik'] ?? null,
                'father_company' => $data['babaninSosyalGuvenlik'] ?? null,
                'mother_job' => $data['anneninMeslegi'] ?? null,
                'father_job' => $data['babaninMeslegi'] ?? null,
                'father_educ' => $data['babaninTahsilDurumu'] ?? null,
                'mother_educ' => $data['anneninTahsilDurumu'] ?? null,
            ]);
        }
    }
    public function aileBilgileriniKaydet($data){
        if (!$this->tabloKayitKontrol('new_family_infos', Auth::guard('aday')->user()->tc_no )){
            return newFamilyInfos::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'father_city' => $data['fatherCity'] ?? null,
                'father_district' => $data['fatherDistrict'] ?? null,
                'mother_city' => $data['motherCity'] ?? null,
                'mother_district' => $data['motherDistrict'] ?? null,
                'parent_address' => $data['address'] ?? null,
                'parent_email' => $data['parentEmail'] ?? null,
                'parent_phone' => $data['parentHomePhone'] ?? null,
                'parent_mobile' => $data['parentMobile'] ?? null,
                'emergency_closeness' => $data['yakınlıkDerecesi'] ?? null,
                'emergency_mobile' => $data['telefon'] ?? null,
                'emergency_person' => $data['adSoyad'] ?? null,

            ]);
        }
        else{

            newFamilyInfos::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'father_city' => $data['fatherCity'] ?? null,
                'father_district' => $data['fatherDistrict'] ?? null,
                'mother_city' => $data['motherCity'] ?? null,
                'mother_district' => $data['motherDistrict'] ?? null,
                'parent_address' => $data['address'] ?? null,
                'parent_email' => $data['parentEmail'] ?? null,
                'parent_phone' => $data['parentHomePhone'] ?? null,
                'parent_mobile' => $data['parentMobile'] ?? null,
                'emergency_closeness' => $data['yakınlıkDerecesi'] ?? null,
                'emergency_mobile' => $data['telefon'] ?? null,
                'emergency_person' => $data['adSoyad'] ?? null,
            ]);
        }
    }
    public function kalinanYerBilgileriKaydet($data){
        if (!$this->tabloKayitKontrol('new_housing_informations', Auth::guard('aday')->user()->tc_no )){
            return NewHousingInformation::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'address_detail' => $data['addressDetail'] ?? null,
                'housing_fee' => $data['housingFee'] ?? null,
                'housing_type' => $data['housingType'] ?? null,
                'living_with_count' => $data['livingWithCount'] ?? null,
                'residing_city' => $data['residingCity'] ?? null,
                'residing_district' => $data['residingDistrict'] ?? null,

            ]);
        }
        else{
            NewHousingInformation::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'address_detail' => $data['addressDetail'] ?? null,
                'housing_fee' => $data['housingFee'] ?? null,
                'housing_type' => $data['housingType'] ?? null,
                'living_with_count' => $data['livingWithCount'] ?? null,
                'residing_city' => $data['residingCity'] ?? null,
                'residing_district' => $data['residingDistrict'] ?? null,
            ]);
        }
    }


    public function genelBilgileriKaydet($data){
            Aday::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'confirmInfos' => $this->onEvetDonustur($data['confirmation1']) ?? null,
                'confirmKvkk' => $this->onEvetDonustur($data['confirmation2']) ?? null,
            ]);
    }
    public function egitimBilgileriKaydet($data){
        $type = Auth::guard('aday')->user()->educationType;

        if (!$this->tabloKayitKontrol('new_educational_infos', Auth::guard('aday')->user()->tc_no )){
            return NewEducationalInfo::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'primary_educ_type' => $data['schoolType'] ?? null,
                'middle_educ_type' => $data['schoolType'] ?? null,
                'high_educ_type' => $data['schoolType'] ?? null,
                'educationType' => $type,
                'p_school_name' => $data['p_school_name'] ?? null,
                'p_school_city' => $data['p_school_city'] ?? null,
                'p_school_district' => $data['p_school_district'] ?? null,
                'class' => $data['grade'] ?? null,
                'm_school_name' => $data['m_school_name'] ?? null,
                'm_school_city' => $data['m_school_city'] ?? null,
                'm_school_district' => $data['m_school_district'] ?? null,
                'h_school_name' => $data['hschoolName'] ?? null,
                'h_school_city' => $data['h_school_city'] ?? null,
                'h_school_turu' => $data['h_school_turu'] ?? null,
                'h_school_type' => $data['h_school_type'] ?? null,
                'h_school_district' => $data['h_school_district'] ?? null,
                'is_transfered' => $data['transferred'] ?? null,
                'grade_avg' => $data['averageGrade'] ?? null,
                'grade_high_school' => $data['reportedHighSchool'] ?? null,
                'grade_university' => $data['reportedUniversity'] ?? null,
                'entry_grade_university' => $data['universityEntranceScore'] ?? null,
                'current_university' => $data['current_university'] ?? null,
                'university_type' => $data['universityStatus'] ?? null,
                'university_educ_time' => $data['departmentYear'] ?? null,
                'agno_type' => $data['agnoSystem'] ?? null,
                'agno' => $data['agno'] ?? null,
                'university_transfer' => $data['university_transfer'] ?? null,
                'university_transfer_desc' => $data['university_transfer_desc'] ?? null,
                'languages' => $data['languages'] ?? null,
                'grade_associate_university' => $data['grade_associate_university'] ?? null,
                'grade_departmant' => $data['departmant'] ?? null,
                'master_university' => $data['masterUniversity'] ?? null,
                'master_departmant' => $data['masterDepartment'] ?? null,
                'master_field' => $data['masterBranch'] ?? null,
                'grade_agno' => $data['graduateAgno'] ?? null,
                'student_number' => $data['studentNumber'] ?? null,
                'university_city' => $data['university_city'] ?? null,
                 'faculty' => $data['faculty'] ?? null,

            ]);
        }
        else{
            NewEducationalInfo::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'primary_educ_type' => $data['schoolType'] ?? null,
                'middle_educ_type' => $data['schoolType'] ?? null,
                'high_educ_type' => $data['schoolType'] ?? null,
                'p_school_name' => $data['schoolName'] ?? null,
                'p_school_city' => $data['schoolCity'] ?? null,
                'p_school_district' => $data['schoolDistrict'] ?? null,
                'class' => $data['class'] ?? null,
                'h_school_name' => $data['hschoolName'] ?? null,
                'h_school_city' => $data['h_school_city'] ?? null,
                'h_school_turu' => $data['h_school_turu'] ?? null,
                'h_school_type' => $data['h_school_type'] ?? null,
                'h_school_district' => $data['h_school_district'] ?? null,
                'm_school_name' => $data['mschoolName'] ?? null,
                'm_school_city' => $data['m_school_city'] ?? null,
                'm_school_district' => $data['schoolDistrict'] ?? null,
                'is_transfered' => $data['transferred'] ?? null,
                'grade_avg' => $data['averageGrade'] ?? null,
                'grade_high_school' => $data['reportedHighSchool'] ?? null,
                'grade_university' => $data['reportedUniversity'] ?? null,
                'entry_grade_university' => $data['universityEntranceScore'] ?? null,
                'current_university' => $data['current_university'] ?? null,
                'university_type' => $data['universityStatus'] ?? null,
                'university_educ_time' => $data['departmentYear'] ?? null,
                'agno_type' => $data['agnoSystem'] ?? null,
                'agno' => $data['agno'] ?? null,
                'university_transfer' => $data['university_transfer'] ?? null,
                'university_transfer_desc' => $data['university_transfer_desc'] ?? null,
                'languages' => $data['languages'] ?? null,
                'grade_associate_university' => $data['birthDistrict'] ?? null,
                'grade_departmant' => $data['departmant'] ?? null,
                'master_university' => $data['masterUniversity'] ?? null,
                'master_departmant' => $data['masterDepartment'] ?? null,
                'master_field' => $data['masterBranch'] ?? null,
                'grade_agno' => $data['graduateAgno'] ?? null,
                'student_number' => $data['studentNumber'] ?? null,
                'university_city' => $data['university_city'] ?? null,
                'university_class' => $data['educationYear'] ?? null,
                'educationType' => $type,
                'faculty' => $data['faculty'] ?? null,

            ]);
        }
    }

    public function kisiselSorularKaydet($data){
        if (!$this->tabloKayitKontrol('new_personal_infos',Auth::guard('aday')->user()->tc_no)){
            NewPersonalnfo::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'birthdate' => $data['year'].'-'.$data['month'].'-'.$data['day'],
                'born_city' => $data['birthCity'],
                'born_district' => $data['birthDistrict'],
                'registered_city' => $data['registeredCity'],
                'registered_district' => $data['registeredDistrict'],
                'gender' => $data['gender'],
                'maritality' => $data['maritalStatus'],
                'nationality' => $data['nationality'],
            ]);
        }
        else{
            NewPersonalnfo::where('tc_no',Auth::guard('aday')->user()->tc_no)->update([
                'birthdate' => $data['year'].'-'.$data['month'].'-'.$data['day'],
                'born_city' => $data['birthCity'],
                'born_district' => $data['birthDistrict'],
                'registered_city' => $data['registeredCity'],
                'registered_district' => $data['registeredDistrict'],
                'gender' => $data['gender'],
                'maritality' => $data['maritalStatus'],
                'nationality' => $data['nationality'],
            ]);
        }

    }
    public function upload(Request $request)
    {
        // Dosyanın var olup olmadığını kontrol et
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileType = $request->input('fileType'); // Dosya türünü al (isteğe bağlı)
            $name = $request->input('id'); // Dosya türünü al (isteğe bağlı)
            $extension = $file->getClientOriginalExtension();

            // Dosya adı oluştur
            $fileName = uniqid() . '.' . $extension;
            $path = 'uploads/basvurular/' .Auth::guard('aday')->user()->id;

            $filePath = $file->storeAs($path, $fileName, 'public');
            // Dosyayı storage/app/public/uploads dizinine kaydet ve new_answersa kaydet
            $belge = NewAnswer::where([['tc_no',Auth::guard('aday')->user()->tc_no]])->first();
                $belge->$name = '/storage/' . $filePath;
                $belge->save();
            $belgedoc = NewDocuments::firstOrCreate(
            // Koşul: tc_no sütunu Auth kullanıcısının tc_no'su ile eşleşmeli
                ['tc_no' => Auth::guard('aday')->user()->tc_no],
                // Eğer bu tc_no ile bir kayıt yoksa yeni kayıt oluşturmak için eklenmesi gereken varsayılan değerler
                ['tc_no' => Auth::guard('aday')->user()->tc_no]
            );
            $belgedoc->$name = '/storage/' . $filePath;
            $belgedoc->save();

            aday_timeline_dosya_yukleme(Auth::guard('aday')->user()->tc_no, (string) $name);

            return response()->json(['success' => true, 'filePath' => $filePath]);
        }

        return response()->json(['success' => false, 'message' => 'Dosya yüklenemedi.'], 400);
    }

    // Dosya silme işlemi
    public function delete($id, Request $request)
    {
        $tc_no = Auth::guard('aday')->user()->tc_no;

        // Veritabanından dosyayı tc_no ile bul
        $uploadedFile = NewDocuments::where('tc_no', $tc_no)->first();

        if ($uploadedFile && isset($uploadedFile->{$id})) {
            // Sütun adı dinamik olarak alınıyor, dosya yolunu alıyoruz
            $filePath = $uploadedFile->{$id};

            if ($filePath) {
                // Dosyayı storage'dan sil
                $cleanPath = preg_replace('/^\/storage\//', '', $filePath);
                $result = Storage::disk('public')->delete($cleanPath);
                if($result){
                    // İlgili sütunu null yaparak veritabanında güncelle
                    $uploadedFile->{$id} = null;
                    $uploadedFile->save();
                    $item = NewAnswer::where('tc_no',$tc_no)->first();
                    $item->{$id} = null;
                    $item->save();
                    aday_timeline_belge_silme($tc_no, (string) $id);

                    return response()->json(['success' => true, 'message' => 'Dosya başarıyla silindi.']);
                }
                else{
                    return response()->json(['success' => false, 'message' => 'Dosya kaldirilamadi.']);

                }

            }
            else {
                return response()->json(['success' => false, 'message' => 'Dosya bulunamadı.']);
            }
        }
        else {
            return response()->json(['success' => false, 'message' => 'Geçersiz sütun veya dosya bulunamadı.']);
        }



return response()->json(['success' => false, 'message' => 'Dosya bulunamadı.'], 404);
    }


    public function saveStepData(Request $request)
    {
        $type = $request->type;
        $step = $request->input('step');
        $data = $request->input('data');
        $totalScore = $request->input('total_score', 0);

        // Toplam puanı data'ya ekle
        $data['totalPoints'] = $totalScore;

        $result = $this->BasvuruSorulariIsle($data,$step);
        if (Auth::guard('aday')->check()) {
            aday_timeline_log(
                Auth::guard('aday')->user()->tc_no,
                'Başvuru Formu',
                'Bilgi güncelleme',
                $this->formTimelineMetin('Adım '.(string) $step.' form bilgileri kaydedildi.')
            );
        }
        return response()->json([
            'message' => 'adim   ' . $step .' sonuc   ' . $result . ' ' . $type,
            'total_score' => $totalScore,
            'step' => $step,
            'Bilgileri getirildi. Bilgiler : ' => $data
        ]);
    }
    public function KYSorulariIsle($data,$step){
        $form_id = $data['form_id'];
        unset($data['db_table']);
        unset($data['form_id']);

        // Sayısal anahtarları temizle (örn: data[] şeklinde gelen veriler '0' anahtarına neden olur)
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                unset($data[$key]);
            }
        }

        RenewAnswer::where('form_id', $form_id)->update($data);
        return true;
    }
  
    private function renewBilgiKaydet($data){
        $form = RenewAnswer::where('form_id',$data['form_id'])->first();
        if(isset($data['check_taahhutname'])) $form->check_taahhutname = $data['check_taahhutname'];
    if(isset($data['check_acikriza'])) $form->check_acikriza = $data['check_acikriza'];
    if(isset($data['check_aydinlatma'])) $form->check_aydinlatma = $data['check_aydinlatma'];
    if(isset($data['check_ailebireyleri'])) $form->check_ailebireyleri = $data['check_ailebireyleri'];
    if(isset($data['check_bilgidogrulama'])) $form->check_bilgidogrulama = $data['check_bilgidogrulama'];
    if(isset($data['check_ailerizaformu'])) $form->check_ailerizaformu = $data['check_ailerizaformu'];
        $form->save();
    }
    public function renewsaveStepData(Request $request)
    {
        $type = $request->type;
        $step = $request->input('step');
        $data = $request->input('data');
        $result = $this->KYSorulariIsle($data,$step);
        $formId = $data['form_id'] ?? null;
        if ($formId) {
            $renewRow = RenewAnswer::where('form_id', $formId)->first();
            if ($renewRow && $renewRow->tc_no) {
                aday_timeline_log(
                    $renewRow->tc_no,
                    'Kayıt Yenileme',
                    'Bilgi güncelleme',
                    $this->formTimelineMetin('Adım '.(string) $step.' KY form bilgileri kaydedildi.')
                );
            }
        }
        return response()->json(['message' => 'adim   ' . $step .' sonuc   ' . $result . ' ' . $type , 'Bilgileri getirildi. Bilgiler : ' => $data]);
    }

    public function renewsosyalBilgilerKaydet($data){

            RenewSocialInfos::where('form_id',$data['form_id'])->update([
                'platform' => $data['haberKaynak'] ?? null,
                'skills' => $data['gucluYanlar'] ?? null,
                'social_projects' => $data['sosyalProjeler'] ?? null,
                'hobbies' => $data['hobiler'] ?? null,
                'sports' => $data['sporDali'] ?? null,
                'last_books' => $data['kitaplar'] ?? null,
                'message' => $data['mesaj'] ?? null,

            ]);

    }
    public function renewgelirBilgileriKaydet($data){

            RenewIncomeInfos::where('form_id',$data['form_id'])->update([
                'income_person' => $data['gecimiSaglayanKisiler'] ?? null,
                'total_person' => $data['saglayanKisilerToplam'] ?? null,
                'father_salary' => $data['babaninGeliri'] ?? null,
                'mother_salary' => $data['anneninGeliri'] ?? null,
                'other_salary' => $data['digerKisilerinGeliri'] ?? null,
                'other_income' => $data['baskaGelir'] ?? null,
                'housing_type' => $data['evTuru'] ?? null,
                'rent_count' => $data['kira'] ?? null,
                'other_detail' => $data['digerAciklama'] ?? null,
                'cc_payment' => $data['krediborcu'] ?? null,
                'job_details' => $data['calısılanIs'] ?? null,
            ]);

    }
    public function renewkardesBilgileriKaydet($data){

            RenewSiblingInfos::where('form_id',$data['form_id'])->update([
                'count' => $data['kardesSayi'] ?? null,
                'educ_count' => $data['okuyanKardes'] ?? null,
            ]);

    }
    public function renewisBilgileriKaydet($data){

            RenewJobInfos::where('form_id',$data['form_id'])->update([
                'is_working' => $data['employment-status'] ?? null,
                'job_rank' => $data['gorev'] ?? null,
                'sgk' => $data['social-security'] ?? null,
                'salary' => $data['aylikKazanc'] ?? null,
                'company' => $data['kurumAdi'] ?? null,
            ]);
    }
    public function renewbankaBilgileriniKaydet($data){

            RenewBankInfos::where('form_id',$data['form_id'])->update([
                'bank_name' => $data['employment-status'] ?? null,
                'account_number' => $data['hesapNumarasi'] ?? null,
                'iban' => $data['iban'] ?? null,
            ]);

    }

    public function renewengelBilgileriKaydet($data){

            RenewObstacledInfos::where('form_id',$data['form_id'])->update([
                'detail' => $data['engelAciklama'] ?? null,
                'status' => $data['engelDurumu'] ?? null,
            ]);

    }
    public function renewdigerBursBilgileriKaydet($data){

            RenewOtherScholarshipInfos::where('form_id',$data['form_id'])->update([
                'government' => $data['devletBurs'] ?? null,
                'special' => $data['ozelBurs'] ?? null,
            ]);

    }
    public function renewbursEkle(Request $request){
        $data = $request->all();

        $kurum = RenewOtherScholarshipDetails::where([['company_name',$data['company_name']],['form_id',$data['form_id']]])->first();
        if (!$kurum){
            $burs = RenewOtherScholarshipDetails::create([
                'tc_no' => Auth::guard('aday')->user()->tc_no,
                'company_name' => $data['company_name'],
                'company_type' => $data['company_type'],
                'count' => $data['count'],
            ]);

            return response()->json($burs); // JSON olarak döndür
        }

    }
    public function renewkardesEkle(Request $request) {
        $data = $request->all();
        $kardes = RenewSiblingDetails::where([['name',$data['kardesAdi']],['surname',$data['kardesSoyadi']],['form_id',$data['form_id']]])->first();

        if (!$kardes) {
            $kardes = RenewSiblingDetails::create([
                'form_id' => $data['form_id'],
                'name' => $data['kardesAdi'] ?? null,
                'surname' => $data['kardesSoyadi'] ?? null,
                'age' => $data['kardesYasi'] ?? null,
                'educ_status' => $data['kardesEgitimDurumu'] ?? null,
                'maritality' => $data['kardesEvlilik'] ?? null,
                'job' => $data['kardesMeslek'] ?? null,
            ]);
        }

        return response()->json($kardes); // JSON olarak döndür
    }

    public function renewebeveynBilgileriKaydet($data){
        if (!$this->tabloKayitKontrol('new_parent_infos',$data['form_id'])){
            return RenewParentInfo::create([
                'form_id' => $data['form_id'] ?? null,
                'mother_name' => $data['anneAdSoyad'] ?? null,
                'father_name' => $data['babaAdSoyad'] ?? null,
                'parent_together' => $data['anneBabaBirlikte'] ?? null,
                'C9l7SUqOxSvZ' => $data['anneBabaSag'] ?? null,
                'mother_alive' => $data['anneBabaSag'] ?? null,
                'mother_company' => $data['anneninSosyalGuvenlik'] ?? null,
                'father_company' => $data['babaninSosyalGuvenlik'] ?? null,
                'mother_job' => $data['anneninMeslegi'] ?? null,
                'father_job' => $data['babaninMeslegi'] ?? null,
                'father_educ' => $data['babaninTahsilDurumu'] ?? null,
                'mother_educ' => $data['anneninTahsilDurumu'] ?? null,
            ]);
        }
            RenewParentInfo::where('form_id',$data['form_id'])->update([
                'mother_name' => $data['anneAdSoyad'] ?? null,
                'father_name' => $data['babaAdSoyad'] ?? null,
                'parent_together' => $data['anneBabaBirlikte'] ?? null,
                'C9l7SUqOxSvZ' => $data['anneBabaSag'] ?? null,
                'mother_alive' => $data['anneBabaSag'] ?? null,
                'mother_company' => $data['anneninSosyalGuvenlik'] ?? null,
                'father_company' => $data['babaninSosyalGuvenlik'] ?? null,
                'mother_job' => $data['anneninMeslegi'] ?? null,
                'father_job' => $data['babaninMeslegi'] ?? null,
                'father_educ' => $data['babaninTahsilDurumu'] ?? null,
                'mother_educ' => $data['anneninTahsilDurumu'] ?? null,
            ]);

    }
    public function renewaileBilgileriniKaydet($data){

            RenewFamilyInfos::where('form_id',$data['form_id'])->update([
                'father_city' => $data['fatherCity'] ?? null,
                'father_district' => $data['fatherDistrict'] ?? null,
                'mother_city' => $data['motherCity'] ?? null,
                'mother_district' => $data['motherDistrict'] ?? null,
                'parent_address' => $data['address'] ?? null,
                'parent_email' => $data['parentEmail'] ?? null,
                'parent_phone' => $data['parentHomePhone'] ?? null,
                'parent_mobile' => $data['parentMobile'] ?? null,
                'emergency_closeness' => $data['yakınlıkDerecesi'] ?? null,
                'emergency_mobile' => $data['telefon'] ?? null,
                'emergency_person' => $data['adSoyad'] ?? null,
            ]);

    }
    public function renewkalinanYerBilgileriKaydet($data){

            RenewHousingInformation::where('form_id',$data['form_id'])->update([
                'address_detail' => $data['addressDetail'] ?? null,
                'housing_fee' => $data['housingFee'] ?? null,
                'housing_type' => $data['housingType'] ?? null,
                'living_with_count' => $data['livingWithCount'] ?? null,
                'residing_city' => $data['residingCity'] ?? null,
                'residing_district' => $data['residingDistrict'] ?? null,
            ]);

    }

    public function renewgenelBilgileriKaydet($data){

    }
    public function renewegitimBilgileriKaydet($data){
        $aday = Auth::guard('aday')->user();
        if(!$aday){
            $aday= Auth::guard('bursiyer')->user();
        }
        if (!$this->renewtabloKayitKontrol('renew_educational_infos', $data['form_id'] )){
            return RenewEducationalInfo::create([
                'tc_no' => $aday->tc_no,
                'primary_educ_type' => $data['schoolType'] ?? null,
                'middle_educ_type' => $data['schoolType'] ?? null,
                'high_educ_type' => $data['schoolType'] ?? null,
                'p_school_name' => $data['schoolName'] ?? null,
                'p_school_city' => $data['schoolCity'] ?? null,
                'p_school_district' => $data['schoolDistrict'] ?? null,
                'class' => $data['class'] ?? null,
                'm_school_name' => $data['schoolName'] ?? null,
                'm_school_city' => $data['schoolCity'] ?? null,
                'm_school_district' => $data['schoolDistrict'] ?? null,
                'h_school_name' => $data['hschoolName'] ?? null,
                'h_school_city' => $data['hschoolCity'] ?? null,
                'h_school_turu' => $data['h_school_turu'] ?? null,
                'h_school_type' => $data['h_school_type'] ?? null,
                'h_school_district' => $data['hschoolDistrict'] ?? null,
                'is_transfered' => $data['transferred'] ?? null,
                'grade_avg' => $data['averageGrade'] ?? null,
                'grade_high_school' => $data['reportedHighSchool'] ?? null,
                'grade_university' => $data['reportedUniversity'] ?? null,
                'entry_grade_university' => $data['universityEntranceScore'] ?? null,
                'current_university' => $data['continuingUniversity'] ?? null,
                'university_type' => $data['universityStatus'] ?? null,
                'university_educ_time' => $data['departmentYear'] ?? null,
                'agno_type' => $data['agnoSystem'] ?? null,
                'agno' => $data['agno'] ?? null,
                'university_transfer' => $data['university_transfer'] ?? null,
                'university_transfer_desc' => $data['university_transfer_desc'] ?? null,
                'languages' => $data['languages'] ?? null,
                'grade_associate_university' => $data['birthDistrict'] ?? null,
                'grade_departmant' => $data['departmant'] ?? null,
                'master_university' => $data['masterUniversity'] ?? null,
                'master_departmant' => $data['masterDepartment'] ?? null,
                'master_field' => $data['masterBranch'] ?? null,
                'grade_agno' => $data['graduateAgno'] ?? null,
                'student_number' => $data['studentNumber'] ?? null,
                'university_city' => $data['universityCity'] ?? null,
                                'faculty' => $data['faculty'] ?? null,

            ]);
        }
        else{
            RenewEducationalInfo::where('form_id',$data['form_id'])->update([
                'primary_educ_type' => $data['schoolType'] ?? null,
                'middle_educ_type' => $data['schoolType'] ?? null,
                'high_educ_type' => $data['schoolType'] ?? null,
                'p_school_name' => $data['schoolName'] ?? null,
                'p_school_city' => $data['schoolCity'] ?? null,
                'p_school_district' => $data['schoolDistrict'] ?? null,
                'class' => $data['class'] ?? null,
                'm_school_name' => $data['schoolName'] ?? null,
                'm_school_city' => $data['schoolCity'] ?? null,
                'm_school_district' => $data['schoolDistrict'] ?? null,
                'h_school_name' => $data['hschoolName'] ?? null,
                'h_school_city' => $data['hschoolCity'] ?? null,
                'h_school_turu' => $data['h_school_turu'] ?? null,
                'h_school_type' => $data['h_school_type'] ?? null,
                'h_school_district' => $data['hschoolDistrict'] ?? null,
                'is_transfered' => $data['transferred'] ?? null,
                'grade_avg' => $data['averageGrade'] ?? null,
                'grade_high_school' => $data['reportedHighSchool'] ?? null,
                'grade_university' => $data['reportedUniversity'] ?? null,
                'entry_grade_university' => $data['universityEntranceScore'] ?? null,
                'current_university' => $data['continuingUniversity'] ?? null,
                'university_type' => $data['universityStatus'] ?? null,
                'university_educ_time' => $data['departmentYear'] ?? null,
                'agno_type' => $data['agnoSystem'] ?? null,
                'agno' => $data['agno'] ?? null,
                'university_transfer' => $data['university_transfer'] ?? null,
                'university_transfer_desc' => $data['university_transfer_desc'] ?? null,
                'languages' => $data['languages'] ?? null,
                'grade_associate_university' => $data['birthDistrict'] ?? null,
                'grade_departmant' => $data['departmant'] ?? null,
                'master_university' => $data['masterUniversity'] ?? null,
                'master_departmant' => $data['masterDepartment'] ?? null,
                'master_field' => $data['masterBranch'] ?? null,
                'grade_agno' => $data['graduateAgno'] ?? null,
                'student_number' => $data['studentNumber'] ?? null,
                'university_city' => $data['universityCity'] ?? null,
                                'faculty' => $data['faculty'] ?? null,

            ]);
        }
    }

    public function renewkisiselSorularKaydet($data){
            RenewPersonalnfo::where('form_id',$data['form_id'])->update([
                'birthdate' => $data['year'].'-'.$data['month'].'-'.$data['day'],
                'born_city' => $data['birthCity'],
                'born_district' => $data['birthDistrict'],
                'registered_city' => $data['registeredCity'],
                'registered_district' => $data['registeredDistrict'],
                'gender' => $data['gender'],
                'maritality' => $data['maritalStatus'],
                'nationality' => $data['nationality'],
            ]);
    }

    public function getFaculty($uni){
        $faculties = TanimFaculty::select(['name', 'id'])
            ->where('univercity_id', $uni)
            ->get()
            ->toArray();

        $uniqueFaculties = [];
        $seenNames = [];

        foreach ($faculties as $faculty) {
            if (!in_array($faculty['name'], $seenNames)) {
                $uniqueFaculties[] = $faculty;
                $seenNames[] = $faculty['name'];
            }
        }

        $faculties = $uniqueFaculties;

        return response()->json(['success' => true, 'data' => $faculties ]);

    }
    public function getunivercity($city){
        $il = Il::find($city);
        $sehiradi = $il->name;
        $deps = TanimUnivercity::select(['name','id','type'])->where('city', $sehiradi)->get();

        return response()->json(['success' => true, 'data' => $deps ]);

    }

    public function getyluni($city){
        $deps = UnivercitysYukseklisans::select('universite_adi_yuk')->where('univ_sehir_yuk', $city)->distinct()->get();

        return response()->json(['success' => true, 'data' => $deps ]);

    }
    public function getdepartmant($faculty){
$deps = TanimDepartmant::where('faculty_id', $faculty)
                  ->get();

        return response()->json(['success' => true, 'data' => $deps ]);

    }
    public function getcities(){
        $data = Il::orderBy('name','asc')->get();

        return response()->json(['success' => true, 'data' => $data ]);
    }
    public function getCitiesByEducationType($educType){
        $tpye = 'bv_'.$educType;
        $data = Il::where($tpye,1)->orderBy('name','asc')->get();
        return response()->json(['success' => true, 'data' => $data ]);
    }
    public function getcitiesnew(){
        $data = Il::orderBy('name','asc')->get();
        return response()->json($data);
    }
    public function getunivercities(){
        $data = TanimUnivercity::selectRaw('MIN(id) as id, name')
            ->groupBy('name')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json(['success'=>true, 'data'=>$data]);
    }
    public function kyKardesSil($id){
        $kardes = NewSiblingDetails::find($id);
        if ($kardes) {
            if ($kardes->tc_no) {
                aday_timeline_log(
                    $kardes->tc_no,
                    'Kayıt Yenileme',
                    'Kardeş kaydı silindi',
                    $this->formTimelineMetin('Kardeş bilgisi kaldırıldı.')
                );
            }
            $kardes->delete();
        }
        return response()->json(['success'=>true]);
    }
    public function kyBursSil($id){
        $burs = NewOtherScholarshipDetails::find($id);
        if ($burs) {
            if ($burs->tc_no) {
                aday_timeline_log(
                    $burs->tc_no,
                    'Kayıt Yenileme',
                    'Burs kaydı silindi',
                    $this->formTimelineMetin('Diğer burs bilgisi kaldırıldı.')
                );
            }
            $burs->delete();
        }
        return response()->json(['success'=>true]);
    }
    public function renewupload(Request $request)
    {

        // Dosyanın var olup olmadığını kontrol et
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileType = $request->input('fileType'); // Dosya türünü al (isteğe bağlı)
            $name = $request->input('id'); // Dosya türünü al (isteğe bağlı)
            $form_id = $request->input('form_id'); // Dosya türünü al (isteğe bağlı)
            $extension = $file->getClientOriginalExtension();

            // Dosya adı oluştur
            $fileName = uniqid() . '.' . $extension;
            $path = 'uploads/kayitYenilemeler/' .$form_id;
            // Dosyayı storage/app/public/uploads dizinine kaydet

            $filePath = $file->storeAs($path, $fileName, 'public');
            if(RenewAnswer::where('form_id',$form_id)->first()){
                $item = RenewAnswer::where('form_id',$form_id)->first();
                $item->$name = '/storage/' . $filePath;
                $item->save();
                if ($item->tc_no) {
                    aday_timeline_dosya_yukleme($item->tc_no, (string) $name);
                }

                return response()->json(['success' => true, 'message' => $name . ' belgeniz yuklendi!' ]);

            }


        }

        return response()->json(['success' => false, 'message' => 'Dosya yüklenemedi.'], 400);
    }

    // Dosya silme işlemi
    public function renewdelete($id, Request $request)
    {
        $tc_no = $request->input('tc_no'); // AJAX'tan gelen tc_no değerini al

        // Veritabanından dosyayı bul
        $uploadedFile = RenewDocuments::where([
            ['name', $id],
            ['tc_no', Auth::guard('aday')->user()->tc_no]
        ])->first();
        if ($uploadedFile) {
            // Dosyayı storage'dan sil
            $cleanPath = preg_replace('/^\/storage\//', '', $uploadedFile->path);
            Storage::disk('public')->delete($cleanPath);

            // Veritabanından kaydı sil
            $uploadedFile->delete();

            $tcTimeline = Auth::guard('aday')->user()->tc_no;
            aday_timeline_belge_silme($tcTimeline, (string) $id);

            return response()->json(['success' => true, 'message' => 'Dosya başarıyla silindi.']);
        }

        return response()->json(['success' => false, 'message' => 'Dosya bulunamadı.'], 404);
    }

    public function burskontrolsehir($sehir,$tip)
    {

        $check = Il::where('id',$sehir)
            ->where('bv_'.$tip,1)
            ->first();
        if($check){
            return response()->json(['success' => true]);
        }
        else{
            return response()->json(['success' => false]);
        }
    }

    public function burskontrolilce($uni,$tip)
    {
        $check = Ilce::where('id',$uni)
            ->where('bv_'.$tip,1)
            ->first();
        if($check){
            return response()->json(['success' => true]);
        }
    }
    public function burskontroluni ($uni,$tip)
    {

        $check = TanimUnivercity::where('name',$uni)
            ->where('bv_'.$tip,1)
            ->first();
        if($check){
            return response()->json(['success' => true]);
        }
    }
    public function burskontrolfak($uni,$tip)
    {
        $check = TanimFaculty::where('id',$uni)
            ->where('bv_'.$tip,1)
            ->first();
        if($check){
            return 1;
        }
        else{
            return '0';
        }
    }
    public function burskontrolbolum($bolum,$tip){
        $check = TanimDepartmant::where('name',$bolum)
            ->where('bv_'.$tip,1)
            ->first();
        if($check){
            return 1;
        }
        else{
            return '0';
        }
    }
}
