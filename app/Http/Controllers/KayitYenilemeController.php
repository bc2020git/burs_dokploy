<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RenewAnswer;
use App\Models\InterviewGroup;
use App\Models\MulakatAta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\FilterController;
use App\Models\Sebep;
use App\Models\Soru;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KayitYenilemeController extends Controller
{
    public function __construct(FilterController $filterController)
    {
        if (!Schema::hasColumn('renew_answers', 'islemi_yapan')) {
            Schema::table('renew_answers', function (Blueprint $table) {
                $table->string('islemi_yapan')->nullable();
            });
        }
        $this->filterController = $filterController;
    }
    private  function getColumnList(){
        $list = [
            'id',
            'doc_fotograf',
            //'scholar.id',
            'name',
            'surname',
            'tel_no',
            'email',
            'tc_no',
            'educationType',
            'aday_turu',
            'scholars.created_at',
            'form_id',
            'status',
            'p_school_name',
            'class',
            'grade_departmant',
            'islemi_yapan',
            'doc_ogrenciBelgesi',
            'doc_adlisicilkaydi',
            'doc_nufuskayitornegi',
            'doc_annegelirbelgesi',
            'doc_babagelirbelgesi',
            'doc_taahhutname',
            'doc_kimlik',
            'doc_bankahesap',
            'doc_transkript',
            'doc_ikametgah',
            'doc_Karne',
            'doc_Diger',
            'created_at'
        ];
        return $list;
    }
    public function setOrderColumns($item){

        switch($item){
            case 'doc_fotograf':
                return 0;
            case 'id':
                return 2;
            case 'created_at':
                return 3;
            case 'tel_no':
                return 4;
            case 'email':
                return 5;


            default:
                return 99;
        }
    }
    public function   setColumnDetails($columns){
        $columns['id']['visible'] = false;
        $columns['doc_fotograf']['filterable'] = true;
        $columns['doc_fotograf']['orderable'] = false;
        $columns['doc_fotograf']['title'] = 'Fotoğraf';
        $columns['doc_fotograf']['order'] = 0;
        $columns['name']['title'] = 'Ad';
        $columns['surname']['title'] = 'Soyad';
        $columns['name']['order'] = 3;
        $columns['surname']['order'] = 4;
        $columns['tel_no']['order'] = 5;
        $columns['email']['order'] = 6;
        $columns['tc_no']['order'] = 7;
        $columns['educationType']['order'] = 9;
        $columns['created_at']['title'] = 'Burs Başlangıç Tarihi';
        $columns['created_at']['order'] = 13;
        $columns['created_at']['filterType'] = 'date';
        $columns['created_at']['filterOptions'] = ['=' => 'Eşittir', '>' => 'Sonra', '<' => 'Önce'];
        $columns['educationType']['title'] = 'Öğrenim Türü';
        $columns['aday_turu']['title'] = 'Bursiyer Tipi';
        $columns['aday_turu']['order'] = 7;
        $columns['status']['title'] = 'Kayıt Yenileme';
        $columns['status']['order'] = 9;
        $columns['p_school_name']['title'] = 'Okul Adı';
        $columns['p_school_name']['order'] = 10;
        $columns['class']['title'] = 'Sınıf';
        $columns['class']['order'] = 11;
        $columns['grade_departmant']['title'] = 'Bölüm';
        $columns['grade_departmant']['order'] = 12;
        $columns['tc_no']['title'] = 'T.C Kimlik No..';
        $columns['tc_no']['order'] = 6;
        $columns['tel_no']['title'] = 'Telefon No ';
        $columns['tel_no']['order'] = 4;
        $columns['email']['title'] = 'E-Posta';
        $columns['email']['order'] = 5;
        $columns['doc_ogrenciBelgesi']['title'] = 'Öğrenci Belgesi';
        $columns['doc_adlisicilkaydi']['title'] = 'Adli Sicil Kaydı';
        $columns['doc_nufuskayitornegi']['title'] = 'Nüfus Kaydı';
        $columns['doc_annegelirbelgesi']['title'] = 'Anne Gelir Belgesi';
        $columns['doc_babagelirbelgesi']['title'] = 'Baba Gelir Belgesi';
        $columns['doc_taahhutname']['title'] = 'Taahhütname';
        $columns['doc_kimlik']['title'] = 'Kimlik';
        $columns['doc_bankahesap']['title'] = 'Banka Hesabı';
        $columns['doc_transkript']['title'] = 'Transkript';
        $columns['doc_ikametgah']['title'] = 'İkametgah';
        $columns['doc_Karne']['title'] = 'Karne';
        $columns['doc_Diger']['title'] = 'Diğer';
        $columns['islemi_yapan']['title'] = 'İşlemi Yapan';
        $columns['id']['is_visible'] = false;
        $columns['id']['order'] = 1;
        $columns['bursiyer_id']['order'] = 2;
        $columns['tc_no']['type'] ='number';
        $columns['tc_no']['filterType'] = $this->getFilterType('number');
        $columns['tc_no']['filterOptions'] = $this->getFilterOptions('tc_no', 'number');
        $columns['tc_no']['filterValue'] = $this->getFilterValue('tc_no', 'number');
        return $columns;
    }
    public function index()
    {
        $sebepler = Sebep::orderBy('text','asc')->get();
        session(['sidebar' => 4]);


        $columns = $this->getColumnDefinitions();
        $allColumns = $this->getColumnList();
        $docColumns = [];

        foreach ($allColumns as $column) {
            if (str_starts_with($column, 'doc_')) {
                $docColumns[] = $column;
            }
        }

        $checkboxColumns =
         [
            'aday_turu',
            'status',
            'educationType',
            'aidat_odeme',
            'mulakat_durumu',
            'doc_ogrenciBelgesi',
            'doc_adlisicilkaydi',
            'doc_nufuskayitornegi',
            'doc_annegelirbelgesi',
            'doc_babagelirbelgesi',
            'doc_taahhutname',
            'doc_kimlik',
            'doc_bankahesap',
            'doc_transkript',
            'doc_ikametgah',
            'doc_Karne',
            'doc_Diger',
            'doc_fotograf'
        ];
        $columns = $this->setColumnDetails($columns);
        $columns = collect($columns)->sortBy('order')->toArray();
        $query = RenewAnswer::with(['form','form.scholar']);
        $adaylar = $query->get();
        $result = [
            'columns' => $columns,
            'adaylar' => $adaylar,
            'sebepler' => $sebepler,
            'checkboxColumns'  => $checkboxColumns,
            // Dinamik sütun checkbox'ları için tüm sorular (Okulun Bulunduğu Şehir tekil olarak birleştirildi)
            'allQuestions' => $this->getColvisQuestions(),
        ];

        return view('panel.registration-renewal.index',$result);
    }

    private function getColvisQuestions()
    {
        $excludedKeys = [
            'p_school_city', 'm_school_city', 'h_school_city',
            'p_school_district', 'm_school_district', 'h_school_district',
            'p_school_name', 'm_school_name', 'h_school_name',
            'primary_educ_type', 'middle_educ_type', 'high_educ_type'
        ];

        $questions = Soru::select('title', 'db_key')
            ->whereNotIn('db_key', $excludedKeys)
            ->orderBy('title', 'asc')
            ->get();

        $virtualQuestions = [
            (object)['title' => 'Okulun Bulunduğu Şehir', 'db_key' => 'school_city'],
            (object)['title' => 'Okulun Bulunduğu İlçe', 'db_key' => 'school_district'],
            (object)['title' => 'Okul Adı', 'db_key' => 'school_name'],
            (object)['title' => 'Okul Tipi', 'db_key' => 'school_type'],
        ];

        foreach ($virtualQuestions as $vq) {
            $questions->push($vq);
        }

        return $questions->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE)->values();
    }
    private $searchableColumns = [
        'educationType' => 'renew_answers.educationType',
        'aday_id' => 'renew_answers.aday_id'
        // İhtiyaca göre buraya daha fazla sütun eklenebilir
    ];

    public function getData(Request $request)
    {
        $query = RenewAnswer::query();

        $query->join('renew_forms', 'renew_answers.form_id', '=', 'renew_forms.id')
              ->join('scholars', 'renew_forms.scholar_id', '=', 'scholars.id')
              ->select([
                  'renew_answers.*',
                  'scholars.id as bursiyer_id',
                  'scholars.created_at as scholar_created_at',
                  'renew_forms.scholar_id as scholar_id',
                  'renew_forms.created_at as form_created_at',
                  'renew_forms.updated_at as form_updated_at',
                  'scholars.aday_id as aday_id',
              ]);

        // Dinamik sütunları doğrula. Taban sorgu zaten 'renew_answers.*' seçtiği için
        // veriyi ayrıca select etmeye gerek yok; sadece otomatik aramayı kapatacağız.
        $validDynamicColumns = [];
        if ($request->has('dynamic_columns') && !empty($request->dynamic_columns)) {
            $dynamicColumns = is_array($request->dynamic_columns) ? $request->dynamic_columns : explode(',', $request->dynamic_columns);
            $existingColumns = Schema::getColumnListing('renew_answers');
            $validDynamicColumns = array_values(array_intersect($dynamicColumns, $existingColumns));
            $virtualKeys = ['school_city', 'school_district', 'school_name', 'school_type'];
            foreach ($virtualKeys as $vKey) {
                if (in_array($vKey, $dynamicColumns) && !in_array($vKey, $validDynamicColumns)) {
                    $validDynamicColumns[] = $vKey;
                }
            }
        }

        $datatables = DataTables::of($query)
        ->addColumn('checkbox', function($row){
            return '<input type="checkbox" name="userCheckbox" class="form-check-input ss" value="'.$row->form_id.'" data-id="'.$row->form_id.'">';
        })
        ->editColumn('doc_fotograf', function($row){
            if($row->doc_fotograf == null){
                 $scholar = \App\Models\Scholar::find($row->bursiyer_id);
                 return $scholar ? $scholar->latestPhoto() : null;
            }
            return $row->doc_fotograf;
        })
        ->editColumn('created_at', function($row){
          return Carbon::parse($row->form_created_at)->format('d.m.Y');
        })
        ->editColumn('p_school_name', function($row){
            switch($row->educationType){
              case 'ilkokul':
                  return $row->p_school_name;
              case 'ortaokul':
                  return $row->m_school_name;
              case 'lise':
                  return $row->h_school_name;
              case 'onlisans':
              case 'lisans':
              case 'yukseklisans':
              case 'doktora':
                  return $row->current_university;
            }
        })
        ->editColumn('educationType', function($row){
          return $row->educationType;
        })
        ->orderColumn('p_school_name', function ($query, $order) {
            $query->orderByRaw("CASE
                WHEN renew_answers.educationType = 'ilkokul' THEN renew_answers.p_school_name
                WHEN renew_answers.educationType = 'ortaokul' THEN renew_answers.m_school_name
                WHEN renew_answers.educationType = 'lise' THEN renew_answers.h_school_name
                ELSE renew_answers.current_university
            END " . $order);
        })
        ->editColumn('class', function($row){
          switch($row->educationType){
          case 'ilkokul':
          case 'ortaokul':
          case 'lise':
              return $row->class;
          case 'onlisans':
                return $row->oKN3UeDifPTo;
          case 'lisans':
          case 'yukseklisans':
          case 'doktora':
              return $row->university_class;
          }
        })
        ->addColumn('action', function($row){
            $url =  route('kayitYenilemeDetay', ['id' => $row->form_id]) ;
            $smsUrl = "{{ route('send-sms', ['id' => $row->id]) }}";
            $mailUrl = "{{ route('getScholarMailForm', ['eposta' => $row->email]) }}";
            $btn = '<button class="btn btn-sm me-1 send-sms" onclick="sendSmsByButon(this)" data-id="'.$row->id.'" data-phone="'.$row->tel_no.'" data-name="'.$row->name.'" data-surname="'.$row->surname.'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#FFA800"/>

                            </svg>
                    </button>
                    <button class="btn btn-sm me-1 send-mail" onclick="location.href='.$mailUrl.'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#8353E2"/>
                        </svg>
                    </button>
                    <a href="'.$url.'" class="btn btn-sm edit-member">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                        </svg>
                    </a>';

            return $btn;
        })
        ->editColumn('status', function($row){

            switch($row->status){
                case 0: return '<span class="status-box-warning">Devam Ediyor</span>'; break;
                case 1: return '<span class="status-box-warning">Onay Bekliyor</span>'; break;
                case 2: return '<span class="status-box-secondary">İade Edildi</span>'; break;
                case 3: return '<span class="status-box-success">Onaylandı</span>'; break;
                case 4: return '<span class="status-box-danger">Reddedildi</span>'; break;
                case 5: return '<span class="status-box-secondary">İadeden Döndü</span>'; break;
            }
        })
        ->filterColumn('aday_id', function($query, $keyword) {
          $query->where('scholars.aday_id', 'like', "%{$keyword}%");
      })
      ->filterColumn('educationType', function($query, $keyword) {
          $query->where('renew_answers.educationType', 'like', "%{$keyword}%");
      })
        ->filter(function ($query) use ($request) {
            if ($request->has('filters')) {
                $filters = json_decode($request->filters, true);
                foreach ($filters as $column => $filter) {
                  switch($column){
                    case 'aday_id':
                      $column = 'scholar.aday_id';
                      $this->applyColumnFilter($query, $column, $filter);
                      break;
                    case 'bursiyer_id':
                      $column = 'scholar.id';
                      $this->applyColumnFilter($query, $column, $filter);
                      break;
                    default:
                      $this->applyColumnFilter($query, $column, $filter);
                      break;
                  }
                }
            }
            if ($request->has('search') && $request->search['value'] != '') {
                $searchValue = $request->search['value'];
                $query->where(function($query) use ($searchValue) {
                    $query->where('renew_answers.educationType', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.p_school_name', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.m_school_name', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.h_school_name', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.current_university', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.class', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.university_class', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.oKN3UeDifPTo', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.name', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.surname', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.tel_no', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.email', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.tc_no', 'like', "%{$searchValue}%")
                        ->orWhere('renew_answers.aday_turu', 'like', "%{$searchValue}%")
                        ->orWhere('scholars.aday_id', 'like', "%{$searchValue}%")
                        ->orWhere('scholars.id', 'like', "%{$searchValue}%");
                });
            }
        }, true)
        ->order(function ($query) use ($request) {
            if ($request->has('order')) {

                $order = json_decode($request->order, true);
                $isordered = false;
                if ($order && isset($order['column'])) {
                    $columnName = $order['column'];
                    if (str_starts_with($columnName, 'renew_answers.')) {
                        $columnName = substr($columnName, 11);
                    }

                    if($columnName === 'p_school_name' && !$isordered){
                      // NULL değerlerin sıralamasını order direction'a göre ayarlıyoruz
                      $nullOrder = $order['dir'] === 'asc' ? 0 : 1;
                      $notNullOrder = $order['dir'] === 'asc' ? 1 : 0;

                      $query->orderByRaw("
                          CASE
                              WHEN renew_answers.educationType = 'ilkokul' THEN
                                  CASE WHEN renew_answers.p_school_name IS NULL THEN {$nullOrder} ELSE {$notNullOrder} END
                              WHEN renew_answers.educationType = 'ortaokul' THEN
                                  CASE WHEN renew_answers.m_school_name IS NULL THEN {$nullOrder} ELSE {$notNullOrder} END
                              WHEN renew_answers.educationType = 'lise' THEN
                                  CASE WHEN renew_answers.h_school_name IS NULL THEN {$nullOrder} ELSE {$notNullOrder} END
                              WHEN renew_answers.educationType = 'onlisans' THEN
                                  CASE WHEN renew_answers.oKN3UeDifPTo IS NULL THEN {$nullOrder} ELSE {$notNullOrder} END
                              ELSE
                                  CASE WHEN renew_answers.current_university IS NULL THEN {$nullOrder} ELSE {$notNullOrder} END
                          END,
                          CASE
                              WHEN renew_answers.educationType = 'ilkokul' THEN renew_answers.p_school_name
                              WHEN renew_answers.educationType = 'ortaokul' THEN renew_answers.m_school_name
                              WHEN renew_answers.educationType = 'lise' THEN renew_answers.h_school_name
                              WHEN renew_answers.educationType = 'onlisans' THEN renew_answers.oKN3UeDifPTo
                              ELSE renew_answers.current_university
                          END COLLATE utf8_turkish_ci " . $order['dir']
                      );
                      $isordered = true;
                    }
                    else if($columnName === 'class' && !$isordered){
                      $nullOrder = $order['dir'] === 'asc' ? 0 : 1;
                      $notNullOrder = $order['dir'] === 'asc' ? 1 : 0;

                      $query->orderByRaw("
                          CASE
                              WHEN renew_answers.educationType IN ('ilkokul', 'ortaokul', 'lise') THEN
                                  CASE WHEN renew_answers.class IS NULL THEN {$nullOrder} ELSE {$notNullOrder} END
                              WHEN renew_answers.educationType = 'onlisans' THEN
                                  CASE WHEN renew_answers.oKN3UeDifPTo IS NULL THEN {$nullOrder} ELSE {$notNullOrder} END
                              ELSE
                                  CASE WHEN renew_answers.university_class IS NULL THEN {$nullOrder} ELSE {$notNullOrder} END
                          END,
                          CASE
                              WHEN renew_answers.educationType IN ('ilkokul', 'ortaokul', 'lise') THEN renew_answers.class
                              WHEN renew_answers.educationType = 'onlisans' THEN renew_answers.oKN3UeDifPTo
                              ELSE renew_answers.university_class
                          END COLLATE utf8_turkish_ci " . $order['dir']
                      );
                      $isordered = true;
                    }
                      else if($columnName === 'aday_id' && !$isordered){
                          $query->orderBy('scholars.aday_id', $order['dir']);
                          $isordered = true;
                      }
                      else if (str_contains($columnName, '.') && !$isordered) {
                          $parts = explode('.', $columnName);
                          $field = array_pop($parts);
                          $lastTable = last($parts) . 's';
                          $query->orderBy($lastTable . '.' . $field, $order['dir']);
                          $isordered = true;
                      }
                      else if(!$isordered){
                          $query->orderBy($columnName, $order['dir']);
                          $isordered = true;
                      }
                }
            }
            else{
                $query->orderBy('id', 'desc');
            }
        })
        ->rawColumns(['checkbox', 'action','educationType','status']);

        // Dinamik sütunlar için otomatik aramayı kapat
        foreach ($validDynamicColumns as $column) {
            $datatables->filterColumn($column, function($query, $keyword) {});
        }

        return $datatables->make(true);
    }
    private function handleColumnFilter($query, $column, $keyword)
    {
        if (array_key_exists($column, $this->searchableColumns)) {
            $query->orWhere($this->searchableColumns[$column], 'like', "%{$keyword}%");
        }
    }
    private function getFilterOptions($column, $type)
    {
        $options = $this->filterController->returnFilterOptions();

        if($column === 'aday_turu'){
            return [
                '0' => 'Dernek',
                '1' => 'Vakıf',
                '2' => 'Boş'
            ];
        }
        // Özel durumlar için
        if ($column === 'interview_result') {
            $values= ['Planlandı','Olumlu','Olumsuz'];
            return $values;
        }
        if ($column === 'interview_platform') {
            $values= ['Yüz Yüze','Çevrim içi'];
            return $values;
        }

        if ($column === 'educationType') {
            $values= ['İlkokul','Ortaokul','Lise','Ön lisans','Lisans','Yüksek Lisans','Doktora'];
            return $values;
        }
        if ($column === 'doc_fotograf') {
            return ['Profil Var', 'Profil Yok', 'Uyumsuz'];
        }
        if (str_starts_with($column, 'doc_')) {
            return [
                '0' => 'Hayır',
                '1' => 'Evet'
            ];
        }
        if ($column === 'uye_sistem_durumu') {
            $values= ['Aktif','Pasif'];
            return $values;
        }
        if ($column === 'aidat_odeme') {
            $values= ['Başarılı','Ödeme Bekleniyor','Ödeme Başarısız'];
            return $values;
        }
        if ($column === 'status') {
            $values= ['Devam Ediyor','Onay Bekliyor','İade Edildi','Onaylandı','Red Edildi','İadeden Döndü'];

            return $values;
        }
        if ($column === 'mulakat_durumu') {
            $values= ['Mülakat Yapılacak','Planlandı','Olumlu','Olumsuz'];
            return $values;
        }

        return $options[$this->getFilterType($type)] ?? $options['text'];
    }
    protected function getColumnType($model, $column)
    {
        $casts = $model->getCasts();
        if($column === 'tc_no' || $column === 'bursiyer_id' || $column === 'aday_id' || $column === 'tel_no' || $column === 'class'){
            return 'number';
        }
        if($column === 'created_at'){
            return 'date';
        }
        if (isset($casts[$column])) {
            switch ($casts[$column]) {
                case 'date':
                case 'datetime':
                    return 'date';
                case 'integer':
                case 'int':
                case 'bigint':
                case 'decimal':
                case 'float':
                case 'decimal':
                    return 'number';
                default:
                    return 'text';
            }
        }

        $selectColumns = ['role_id'];
        if (in_array($column, $selectColumns)) return 'select';
        if (Str::endsWith($column, '_date')) return 'date';
        if (Str::endsWith($column, ['_id', '_count'])) return 'number';

        return 'text';
    }

    protected function getColumnTitle($column)
    {
        $title = Str::title(str_replace('_', ' ', $column));

        // Özel başlık çevirileri
        $translations = [
            'Tc No' => 'TC No',
            'Gpa' => 'Not Ortalaması',
            'Status' => 'Durum',
            'Birth Date' => 'Doğum Tarihi',
            'Created At' => 'Kayıt Tarihi',
        ];

        return $translations[$title] ?? $title;
    }

    protected function getColumnDefinitions()
    {
        $model = new RenewAnswer();
        $columns = [];

        // İlk olarak fotoğraf sütununu ekle


        $columns['aday_id'] = [
            'title' => 'Başvuru No',
            'name' => 'aday_id',
            'type' => 'number',
            'filterable' => true,
            'filterType' => $this->getFilterType('number'),
            'filterOptions' => $this->getFilterOptions('aday_id', 'number'),
            'filterValue' => $this->getFilterValue('aday_id', 'number'),
            'conditions' => $this->getColumnConditions('number'),
            'is_visible' => true,
            'searchable' => true,
            'order' => 1
        ];
        $columns['bursiyer_id'] = [
            'title' => 'Bursiyer No',
            'name' => 'bursiyer_id',
            'type' => 'number',
            'filterable' => true,
            'filterType' => $this->getFilterType('number'),
            'filterOptions' => $this->getFilterOptions('bursiyer_id', 'number'),
            'filterValue' => $this->getFilterValue('bursiyer_id', 'number'),
            'conditions' => $this->getColumnConditions('number'),
            'is_visible' => true,
            'searchable' => false,
            'order' => 2
        ];
        $sira = 0;
        $list = ['id',
        'doc_fotograf',
        //'scholar.id',
        'name',
        'surname',
        'tel_no',
        'email',
        'tc_no',
        'educationType',
        'aday_turu',
        'status',
        'p_school_name',
        'class',
        'grade_departmant',
        'islemi_yapan',
        'doc_ogrenciBelgesi',
        'doc_adlisicilkaydi',
        'doc_nufuskayitornegi',
        'doc_annegelirbelgesi',
        'doc_babagelirbelgesi',
        'doc_taahhutname',
        'doc_kimlik',
        'doc_bankahesap',
        'doc_transkript',
        'doc_ikametgah',
        'doc_Karne',
        'doc_Diger',
        'created_at'];
        // Mülakat bilgileri
        foreach ($list as $column  ) {
            $type = $this->getColumnType($model, $column);
            $title = $this->getColumnTitle($column);
            $order = $this->setOrderColumns($list,$column);
            $isVisible = true;
            $searchable = true;
            $columnDef = [
                'title' => $title,
                'name' => $column,
                'type' => $type,
                'filterable' => true,
                'filterType' => $this->getFilterType($type),
                'filterOptions' => $this->getFilterOptions($column, $type),
                'filterValue' => $this->getFilterValue($column, $type),
                'conditions' => $this->getColumnConditions($type),
                'is_visible' => $isVisible,
                'order' => $order,
                'searchable' => $searchable
            ];

            if ($type === 'select') {
                $columnDef['options'] = $this->getColumnOptions($column);
            }

            $columns[$column] = $columnDef;
        }
        $columns['educationType'] = [
            'title' => 'Öğrenim Türü',
            'name' => 'educationType',
            'type' => 'text',
            'filterable' => true,
            'filterType' => $this->getFilterType('text'),
            'filterOptions' => $this->getFilterOptions('educationType', 'text'),
            'filterValue' => $this->getFilterValue('educationType', 'text'),
            'conditions' => $this->getColumnConditions('text'),
            'is_visible' => true,
            'searchable' => true
        ];

        return $columns;
    }

    protected function getColumnOptions($column)
    {
        switch ($column) {
            case  'aday_turu':
                return [
                    '0' => 'Dernek',
                    '1' => 'Vakıf',
                    '2' => 'Boş'
                ];
            case 'status':
                return [
                    '0' => 'Devam Ediyor',
                    '1' => 'Onay Bekliyor',
                    '2' => 'İade Edildi',
                    '3' => 'Onaylandı',
                    '4' => 'Red Edildi',
                    '5' => 'İadeden Döndü'
                ];
            case 'mulakat_durumu':
                return [
                        '0' => 'Mülakat Yapılacak',
                        '1' => 'Planlandı',
                        '2' => 'Olumlu',
                        '3' => 'Olumsuz',
                ];
            case 'aday_turu':
                return [
                    '0' => 'Dernek',
                    '1' => 'Vakıf',
                    '2' => 'Boş'
                ];
            case 'educationType':
                return [
                    '0' => 'İlkokul',
                    '1' => 'Ortaokul',
                    '2' => 'Lise',
                    '3' => 'Ön Lisans',
                    '4' => 'Lisans',
                    '5' => 'Yüksek Lisans',
                    '6' => 'Doktora',
                ];
            case 'doc_fotograf':
                return [
                    'Profil Var',
                    'Profil Yok',
                    'Uyumsuz'
                ];
            case (str_starts_with($column, 'doc_')):
                return [
                    '0' => 'Hayır',
                    '1' => 'Evet'
                ];

            default:
                return [];
        }
    }
    protected function applyColumnFilter($query, $column, $filter)
    {
        $value = $filter['value'] ?? '';
        $condition = $filter['condition'] ?? 'contains';

        // Checkbox grubundaki "Tümünü Seç/Kaldır" alanının varsayılan "on"
        // değeri sayısal status alanında MySQL tarafından 0 kabul edilmemelidir.
        if ($column === 'status' && $condition === 'in' && is_array($value)) {
            $value = array_values(array_filter(
                array_map('strval', $value),
                fn ($status) => in_array($status, ['0', '1', '2', '3', '4', '5'], true)
            ));
        }

        $virtualColumnMap = [
            'school_city' => ['renew_answers.p_school_city', 'renew_answers.m_school_city', 'renew_answers.h_school_city'],
            'school_district' => ['renew_answers.p_school_district', 'renew_answers.m_school_district', 'renew_answers.h_school_district'],
            'school_name' => ['renew_answers.p_school_name', 'renew_answers.m_school_name', 'renew_answers.h_school_name'],
            'school_type' => ['renew_answers.primary_educ_type', 'renew_answers.middle_educ_type', 'renew_answers.high_educ_type'],
        ];

        if (array_key_exists($column, $virtualColumnMap)) {
            $this->buildJointCondition($query, $value, $condition, $virtualColumnMap[$column]);
            return;
        }

        $type = $this->getColumnDefinitions()[$column]['type'] ?? 'text';
        // İlişkisel alan kontrolü
        if (str_contains($column, '.')) {
            $parts = explode('.', $column);
            $field = array_pop($parts); // Son eleman field adı

            // İlişki zincirini oluştur (örn: teachers.cities)
            $relationPath = implode('s.', $parts) . 's';

            // İlişkili tablonun field'ını oluştur (örn: cities.name)
            $lastTable = last($parts) . 's';
            $fullField = $lastTable . '.' . $field;
            $this->buildCondition($query, $fullField, $value, $condition, $type);
            return;
        }

        // Normal alan için filtreleme
        $this->buildCondition($query, $column, $value, $condition, $type);
    }

    protected function buildJointCondition($query, $value, $condition, array $cols)
    {
        switch ($condition) {
            case 'equals':
                $query->where(function($q) use ($cols, $value) {
                    foreach ($cols as $i => $col) {
                        if ($i === 0) $q->where($col, '=', $value);
                        else $q->orWhere($col, '=', $value);
                    }
                });
                break;
            case 'not_equals':
                $query->where(function($q) use ($cols, $value) {
                    foreach ($cols as $col) {
                        $q->where($col, '!=', $value);
                    }
                });
                break;
            case 'contains':
                $query->where(function($q) use ($cols, $value) {
                    foreach ($cols as $i => $col) {
                        if ($i === 0) $q->where($col, 'like', "%{$value}%");
                        else $q->orWhere($col, 'like', "%{$value}%");
                    }
                });
                break;
            case 'not_contains':
                $query->where(function($q) use ($cols, $value) {
                    foreach ($cols as $col) {
                        $q->where($col, 'not like', "%{$value}%");
                    }
                });
                break;
            case 'starts':
            case 'starts_with':
                $query->where(function($q) use ($cols, $value) {
                    foreach ($cols as $i => $col) {
                        if ($i === 0) $q->where($col, 'like', "{$value}%");
                        else $q->orWhere($col, 'like', "{$value}%");
                    }
                });
                break;
            case 'not_starts':
            case 'not_starts_with':
                $query->where(function($q) use ($cols, $value) {
                    foreach ($cols as $col) {
                        $q->where($col, 'not like', "{$value}%");
                    }
                });
                break;
            case 'ends':
            case 'ends_with':
                $query->where(function($q) use ($cols, $value) {
                    foreach ($cols as $i => $col) {
                        if ($i === 0) $q->where($col, 'like', "%{$value}");
                        else $q->orWhere($col, 'like', "%{$value}");
                    }
                });
                break;
            case 'not_ends':
            case 'not_ends_with':
                $query->where(function($q) use ($cols, $value) {
                    foreach ($cols as $col) {
                        $q->where($col, 'not like', "%{$value}");
                    }
                });
                break;
            case 'empty':
                $query->where(function($q) use ($cols) {
                    foreach ($cols as $col) {
                        $q->where(function($sub) use ($col) {
                            $sub->whereNull($col)->orWhere($col, '');
                        });
                    }
                });
                break;
            case 'not_empty':
                $query->where(function($q) use ($cols) {
                    foreach ($cols as $i => $col) {
                        if ($i === 0) {
                            $q->where(function($sub) use ($col) {
                                $sub->whereNotNull($col)->where($col, '!=', '');
                            });
                        } else {
                            $q->orWhere(function($sub) use ($col) {
                                $sub->whereNotNull($col)->where($col, '!=', '');
                            });
                        }
                    }
                });
                break;
            default:
                if (is_array($value) && !empty($value)) {
                    $query->where(function($q) use ($cols, $value) {
                        foreach ($cols as $i => $col) {
                            if ($i === 0) $q->whereIn($col, $value);
                            else $q->orWhereIn($col, $value);
                        }
                    });
                }
                break;
        }
    }
    protected function getColumnConditions($type)
    {
        $common = [
            'empty' => 'Boş',
            'not_empty' => 'Boş Değil'
        ];

        switch ($type) {
            case 'text':
            case 'varchar':
                return [
                    'equals' => 'Eşittir',
                    'not_equals' => 'Eşit Değildir',
                    'contains' => 'İçerir',
                    'not_contains' => 'İçermez',
                    'starts_with' => 'İle Başlar',
                    'not_starts_with' => 'İle Başlamaz',
                    'ends_with' => 'İle Biter',
                    'not_ends_with' => 'İle Bitmez'
                ] + $common;

            case 'number':
            case 'int':
                return [
                    'equals' => 'Eşittir',
                    'not_equals' => 'Eşit Değildir',
                    'greater' => 'Büyüktür',
                    'greater_or_equal' => 'Büyük veya Eşittir',
                    'less' => 'Küçüktür',
                    'less_or_equal' => 'Küçük veya Eşittir'
                ] + $common;

            case 'date':
                return [
                    'equals' => 'Eşittir',
                    'not_equals' => 'Eşit Değildir',
                    'before' => 'Öncesi',
                    'after' => 'Sonrası',
                    'before_or_equal' => 'Öncesi veya Eşit',
                    'after_or_equal' => 'Sonrası veya Eşit'
                ] + $common;

            case 'select':
                return [
                    'equals' => 'Eşittir',
                    'not_equals' => 'Eşit Değildir'
                ] + $common;

            default:
                return $common;
        }
    }
    private function getFilterValue($column, $type)
    {

        if ($column === 'doc_fotograf') {
            return ['Profil Var', 'Profil Yok', 'Uyumsuz'];
        }
        if (strpos($column, 'doc_') === 0) {
            $values = ['Hayır', 'Evet'];
            return $values;
        }
        if ($column === 'status') {
            $values= ['0','1','2','3','4','5'];
            return $values;
        }

        if ($column === 'educationType') {
            $values= ['ilkokul','ortaokul','lise','onlisans','lisans','yukseklisans','doktora'];
            return $values;
        }
        if ($column === 'aday_turu') {
            $values= ['Dernek','Vakıf','null'];
            return $values;
        }

        return null;
    }
    private function getFilterType($columnType)
    {
        switch ($columnType) {
            case 'integer':
            case 'int':
            case 'bigint':
            case 'decimal':
                return 'number';
            case 'date':
            case 'datetime':
                return 'date';
            case 'boolean':
                return 'boolean';
            default:
                return 'text';
        }
    }
    protected function buildCondition($query, $field, $value, $condition, $type)
    {
        switch ($type) {
            case 'number':
            case 'int':
                $this->buildNumberCondition($query, $field, $value, $condition);
                break;
            case 'date':
                $this->buildDateCondition($query, $field, $value, $condition);
                break;
            default:
                $this->buildTextCondition($query, $field, $value, $condition);
                break;
        }
    }

    protected function buildBaseColumns( $field){
        $baseColumns = ['id','name', 'surname', 'email', 'tel_no', 'tc_no','educationType','aday_turu','mulakat_durumu','status'];
        if (in_array($field, $baseColumns)) {
            $field = 'renew_answers.' . $field;
        }
        return $field;
    }
    protected function buildNumberCondition($query, $field, $value, $condition)
    {
        $field = $this->buildBaseColumns($field);
        // sinif arama fonksiyonu
        if($field == 'class'){
            switch($condition){
                case 'empty':
                    $query->whereNull('renew_answers.class')
                    ->orWhereNull('renew_answers.university_class')
                    ->orWhereNull('renew_answers.oKN3UeDifPTo');
                    return;
                case 'not_empty':
                    $query->whereNotNull('renew_answers.class')
                    ->orWhereNotNull('renew_answers.university_class')
                    ->orWhereNotNull('renew_answers.oKN3UeDifPTo');
                    return;
                case 'equals':
                    $query->where('renew_answers.class', '=', $value)
                    ->orWhere('renew_answers.university_class', '=', $value)
                    ->orWhere('renew_answers.oKN3UeDifPTo', '=', $value);
                    return;
                case 'not_equals':
                    $query->where('renew_answers.class', '!=', $value)
                    ->orWhere('renew_answers.university_class', '!=', $value)
                    ->orWhere('renew_answers.oKN3UeDifPTo', '!=', $value);
                    return;
                case 'greater':
                    $query->where('renew_answers.class', '>', $value)
                    ->orWhere('renew_answers.university_class', '>', $value)
                    ->orWhere('renew_answers.oKN3UeDifPTo', '>', $value);
                    return;
                case 'less':
                    $query->where('renew_answers.class', '<', $value)
                    ->orWhere('renew_answers.university_class', '<', $value)
                    ->orWhere('renew_answers.oKN3UeDifPTo', '<', $value);
                    return;
                case 'greater_or_equal':
                    $query->where('renew_answers.class', '>=', $value)
                    ->orWhere('renew_answers.university_class', '>=', $value)
                    ->orWhere('renew_answers.oKN3UeDifPTo', '>=', $value);
                    return;
                case 'less_or_equal':
                    $query->where('renew_answers.class', '<=', $value)
                    ->orWhere('renew_answers.university_class', '<=', $value)
                    ->orWhere('renew_answers.oKN3UeDifPTo', '<=', $value);
                    return;
            }
        }

        switch ($condition) {
            case 'equals':
                $query->where($field, '=', $value);
                break;
            case 'not_equals':
                $query->where($field, '!=', $value);
                break;
            case 'greater':
                $query->where($field, '>', $value);
                break;
            case 'greater_or_equal':
                $query->where($field, '>=', $value);
                break;
            case 'less':
                $query->where($field, '<', $value);
                break;
            case 'less_or_equal':
                $query->where($field, '<=', $value);
                break;
            case 'empty':
                $query->whereNull($field);
                break;
            case 'not_empty':
                $query->whereNotNull($field);
                break;
            case 'in':
                $query->whereIn($field, $value);
                break;
        }
    }

    protected function buildDateCondition($query, $field, $value, $condition)
    {
        if($field == 'created_at'){
            $field = 'scholars.created_at';
        }
        switch ($condition) {
            case 'equals':
                $query->whereDate($field, '=', $value);
                break;
            case 'not_equals':
                $query->whereDate($field, '!=', $value);
                break;
            case 'before':
                $query->whereDate($field, '<', $value);
                break;
            case 'after':
                $query->whereDate($field, '>', $value);
                break;
            case 'before_or_equal':
                $query->whereDate($field, '<=', $value);
                break;
            case 'after_or_equal':
                $query->whereDate($field, '>=', $value);
                break;
            case 'empty':
                $query->whereNull($field);
                break;
            case 'not_empty':
                $query->whereNotNull($field);
                break;
            case 'in':
                $query->whereIn($field, $value);
                break;
        }
    }

    protected function buildSchoolNameCondition($query, $field, $value, $condition)
    {
        // Okul adı için özel filtreleme
        if ($field === 'school_name' || $field === 'p_school_name') {
            if (!empty($value)) {
                    $query->where(function($schoolQ) use ($value) {
                        $schoolQ->where('renew_answers.p_school_name', 'like', "%{$value}%")
                            ->orWhere('renew_answers.m_school_name', 'like', "%{$value}%")
                            ->orWhere('renew_answers.h_school_name', 'like', "%{$value}%")
                            ->orWhere('renew_answers.current_university', 'like', "%{$value}%");
                    });
            }
            return;
        }
    }
    protected function buildClassCondition($query, $field, $value, $condition)
    {
        // Sınıf için özel filtreleme
        if ($field === 'class') {

                $query->where(function($classQ) use ($value) {
                    $classQ->where('renew_answers.class', 'like', "%{$value}%")
                        ->orWhere('renew_answers.university_class', 'like', "%{$value}%")
                        ->orWhere('renew_answers.oKN3UeDifPTo', 'like', "%{$value}%");
                });
        }
    }

    protected function buildTextCondition($query, $field, $value, $condition)
    {
        // Temel sütunlar için tablo adı belirtme
        $baseColumns = ['id','name', 'surname', 'email', 'tel_no', 'tc_no','educationType','aday_turu','mulakat_durumu','status'];
        if (in_array($field, $baseColumns)) {
            $field = 'renew_answers.' . $field;
        }

        if ($field === 'school_name' || $field === 'p_school_name') {
            $this->buildSchoolNameCondition($query, $field, $value, $condition);
            return;
        }
        if ($field === 'class') {
            $this->buildClassCondition($query, $field, $value, $condition);
            return;
        }

        switch ($condition) {
            case 'equals':
                $query->where($field, '=', $value);
                break;
            case 'not_equals':
                $query->where($field, '!=', $value);
                break;
            case 'contains':
                $query->where($field, 'like', "%{$value}%");
                break;
            case 'not_contains':
                $query->where($field, 'not like', "%{$value}%");
                break;
            case 'starts_with':
                $query->where($field, 'like', "{$value}%");
                break;
            case 'not_starts_with':
                $query->where($field, 'not like', "{$value}%");
                break;
            case 'ends_with':
                $query->where($field, 'like', "%{$value}");
                break;
            case 'in':
                if (str_contains($field, 'doc_fotograf')) {
                    $query->where(function($q) use ($value) {
                        $allRecords = \DB::table('renew_answers')
                            ->join('renew_forms', 'renew_answers.form_id', '=', 'renew_forms.id')
                            ->leftJoin('scholars', 'renew_forms.scholar_id', '=', 'scholars.id')
                            ->select('renew_answers.id as id', 'scholars.id as bursiyer_id', 'renew_answers.doc_fotograf as doc_fotograf')
                            ->get();
                        
                        $scholarIds = $allRecords->pluck('bursiyer_id')->filter()->unique()->all();
                        
                        $latestPhotos = [];
                        if (!empty($scholarIds)) {
                            $photos = \DB::table('scholar_forms')
                                ->join('active_answers', 'scholar_forms.id', '=', 'active_answers.form_id')
                                ->whereIn('scholar_forms.scholar_id', $scholarIds)
                                ->whereNotNull('active_answers.doc_fotograf')
                                ->where('active_answers.doc_fotograf', '!=', '')
                                ->orderBy('scholar_forms.created_at', 'desc')
                                ->select('scholar_forms.scholar_id', 'active_answers.doc_fotograf')
                                ->get();
                            
                            foreach ($photos as $p) {
                                if (!isset($latestPhotos[$p->scholar_id])) {
                                    $latestPhotos[$p->scholar_id] = $p->doc_fotograf;
                                }
                            }
                        }
                        
                        $varIds = [];
                        $yokIds = [];
                        $uyumsuzIds = [];
                        
                        foreach ($allRecords as $record) {
                            $resolvedPhoto = $record->doc_fotograf;
                            if (empty($resolvedPhoto) && $record->bursiyer_id && isset($latestPhotos[$record->bursiyer_id])) {
                                $resolvedPhoto = $latestPhotos[$record->bursiyer_id];
                            }
                            
                            $path = trim($resolvedPhoto);
                            if (empty($path)) {
                                $yokIds[] = $record->id;
                                continue;
                            }
                            
                            $cleanPath = ltrim($path, '/');
                            if (str_starts_with($cleanPath, 'storage/')) {
                                $cleanPath = substr($cleanPath, 8);
                            } elseif (str_starts_with($cleanPath, 'public/')) {
                                $cleanPath = substr($cleanPath, 7);
                            }
                            
                            $filePhysicalPath = storage_path($cleanPath);
                            $publicPhysicalPath = public_path($cleanPath);
                            
                            if ((file_exists($filePhysicalPath) && is_file($filePhysicalPath)) || 
                                (file_exists($publicPhysicalPath) && is_file($publicPhysicalPath))) {
                                $varIds[] = $record->id;
                            } else {
                                $uyumsuzIds[] = $record->id;
                            }
                        }
                        
                        $isFirst = true;
                        foreach ($value as $item) {
                            if ($item === 'Profil Yok') {
                                if ($isFirst) {
                                    $q->whereIn('renew_answers.id', $yokIds);
                                    $isFirst = false;
                                } else {
                                    $q->orWhereIn('renew_answers.id', $yokIds);
                                }
                            } elseif ($item === 'Profil Var') {
                                if ($isFirst) {
                                    $q->whereIn('renew_answers.id', $varIds);
                                    $isFirst = false;
                                } else {
                                    $q->orWhereIn('renew_answers.id', $varIds);
                                }
                            } elseif ($item === 'Uyumsuz') {
                                if ($isFirst) {
                                    $q->whereIn('renew_answers.id', $uyumsuzIds);
                                    $isFirst = false;
                                } else {
                                    $q->orWhereIn('renew_answers.id', $uyumsuzIds);
                                }
                            }
                        }
                    });
                    break;
                }
                if (!is_array($value) || empty($value)) {
                    break;
                }

                // Aynı sütundaki seçenekler OR, farklı sütun filtreleri AND olmalıdır.
                // OR koşulları gruplanmazsa daha önce uygulanan filtreler etkisiz kalır.
                $query->where(function($valueQuery) use ($field, $value) {
                    $isDocument = str_starts_with($field, 'doc_');

                    foreach (array_values($value) as $index => $item) {
                        $boolean = $index === 0 ? 'and' : 'or';

                        if ($isDocument) {
                            if ($item === 'Hayır') {
                                $valueQuery->whereNull($field, $boolean);
                            } else {
                                $valueQuery->whereNotNull($field, $boolean);
                            }
                        } elseif ($item === 'null') {
                            $valueQuery->whereNull($field, $boolean);
                        } else {
                            $valueQuery->where($field, '=', $item, $boolean);
                        }
                    }
                });
                break;
            case 'not_ends_with':
                $query->where($field, 'not like', "%{$value}");
                break;
            case 'empty':
                $query->where(function($q) use ($field) {
                    $q->whereNull($field)->orWhere($field, '');
                });
                break;
            case 'not_empty':
                $query->where(function($q) use ($field) {
                    $q->whereNotNull($field)->where($field, '!=', '');
                });
                break;
        }
    }

    /**
     * DataTables ve Excel export ile aynı filtre + global arama mantığı (getData ile uyumlu).
     */
    protected function getRenewListFiltersFromRequest(Request $request): array
    {
        $raw = $request->input('filters');
        if (is_array($raw)) {
            return $raw;
        }
        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    protected function getRenewListGlobalSearchValue(Request $request): ?string
    {
        $search = $request->input('search');
        if (is_array($search) && array_key_exists('value', $search)) {
            $v = $search['value'];
            if ($v !== null && $v !== '') {
                return (string) $v;
            }

            return null;
        }
        if (is_string($search) && $search !== '') {
            return $search;
        }

        return null;
    }

    protected function renewListBaseQuery()
    {
        return RenewAnswer::query()
            ->join('renew_forms', 'renew_answers.form_id', '=', 'renew_forms.id')
            ->join('scholars', 'renew_forms.scholar_id', '=', 'scholars.id')
            ->select([
                'renew_answers.*',
                'scholars.id as bursiyer_id',
                'scholars.created_at as scholar_created_at',
                'renew_forms.scholar_id as scholar_id',
                'renew_forms.created_at as form_created_at',
                'renew_forms.updated_at as form_updated_at',
                'scholars.aday_id as aday_id',
            ]);
    }

    protected function applyRenewListDataFilters($query, Request $request): void
    {
        $filters = $this->getRenewListFiltersFromRequest($request);
        if (! empty($filters)) {
            foreach ($filters as $column => $filter) {
                switch ($column) {
                    case 'aday_id':
                        $column = 'scholar.aday_id';
                        $this->applyColumnFilter($query, $column, $filter);
                        break;
                    case 'bursiyer_id':
                        $column = 'scholar.id';
                        $this->applyColumnFilter($query, $column, $filter);
                        break;
                    default:
                        $this->applyColumnFilter($query, $column, $filter);
                        break;
                }
            }
        }

        $searchValue = $this->getRenewListGlobalSearchValue($request);
        if ($searchValue !== null && $searchValue !== '') {
            $query->where(function ($query) use ($searchValue) {
                $query->where('renew_answers.educationType', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.p_school_name', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.m_school_name', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.h_school_name', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.current_university', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.class', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.university_class', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.oKN3UeDifPTo', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.name', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.surname', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.tel_no', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.email', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.tc_no', 'like', "%{$searchValue}%")
                    ->orWhere('renew_answers.aday_turu', 'like', "%{$searchValue}%")
                    ->orWhere('scholars.aday_id', 'like', "%{$searchValue}%")
                    ->orWhere('scholars.id', 'like', "%{$searchValue}%");
            });
        }
    }

    /**
     * Seçim yoksa: filtre + arama ile aynı son kümeden form_id listesi.
     * Seçim varsa: gönderilen form_id değerleri (checkbox data-export-id).
     */
    protected function extractRenewExportFormIds(Request $request): array
    {
        $raw = $request->input('userIds', $request->input('ids'));
        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }
        $ids = is_array($raw) ? $raw : [];
        $ids = array_values(array_unique(array_map('intval', $ids)));

        if (! empty($ids)) {
            return $ids;
        }

        $query = $this->renewListBaseQuery();
        $this->applyRenewListDataFilters($query, $request);

        return $query->clone()
            ->select('renew_answers.form_id')
            ->orderBy('renew_answers.id', 'desc')
            ->pluck('renew_answers.form_id')
            ->unique()
            ->values()
            ->all();
    }

    protected function getRenewExportableColumnKeys(): array
    {
        return array_keys($this->getColumnDefinitions());
    }

    protected function resolveRenewExportColumnKeys(array $visibleColumns): array
    {
        $allowed = $this->getRenewExportableColumnKeys();
        if (empty($visibleColumns)) {
            return $allowed;
        }
        $out = [];
        foreach ($visibleColumns as $col) {
            if (in_array($col, ['checkbox', 'action', 'actions'], true)) {
                continue;
            }
            if (in_array($col, $allowed, true)) {
                $out[] = $col;
            }
        }

        return $out !== [] ? $out : $allowed;
    }

    protected function getRenewExportColumnTitleMap(): array
    {
        $defs = $this->getColumnDefinitions();
        $map = [];
        foreach ($defs as $key => $def) {
            $map[$key] = $def['title'] ?? $key;
        }

        return $map;
    }

    protected function computeRenewExportSchoolName(RenewAnswer $row): string
    {
        switch ($row->educationType) {
            case 'ilkokul':
                return (string) ($row->p_school_name ?? '');
            case 'ortaokul':
                return (string) ($row->m_school_name ?? '');
            case 'lise':
                return (string) ($row->h_school_name ?? '');
            case 'onlisans':
            case 'lisans':
            case 'yukseklisans':
            case 'doktora':
                return (string) ($row->current_university ?? '');
            default:
                return '';
        }
    }

    protected function computeRenewExportClass(RenewAnswer $row): string
    {
        switch ($row->educationType) {
            case 'ilkokul':
            case 'ortaokul':
            case 'lise':
                return (string) ($row->class ?? '');
            case 'onlisans':
                return (string) ($row->oKN3UeDifPTo ?? '');
            case 'lisans':
            case 'yukseklisans':
            case 'doktora':
                return (string) ($row->university_class ?? '');
            default:
                return '';
        }
    }

    protected function formatRenewExportStatusLabel($status): string
    {
        switch ((int) $status) {
            case 0:
                return 'Devam Ediyor';
            case 1:
                return 'Onay Bekliyor';
            case 2:
                return 'İade Edildi';
            case 3:
                return 'Onaylandı';
            case 4:
                return 'Reddedildi';
            case 5:
                return 'İadeden Döndü';
            default:
                return '';
        }
    }

    protected function formatRenewExportAdayTuru($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        $map = [
            '0' => 'Dernek', '1' => 'Vakıf', '2' => 'Boş',
            0 => 'Dernek', 1 => 'Vakıf', 2 => 'Boş',
            'Dernek' => 'Dernek', 'Vakıf' => 'Vakıf', 'Boş' => 'Boş', 'null' => 'Boş',
        ];

        return $map[$value] ?? (string) $value;
    }

    protected function formatRenewExportCell(RenewAnswer $row, string $col): string
    {
        switch ($col) {
            case 'aday_id':
                return (string) ($row->aday_id ?? '');
            case 'bursiyer_id':
                return (string) ($row->bursiyer_id ?? '');
            case 'id':
                return (string) ($row->id ?? '');
            case 'doc_fotograf':
                $path = $row->doc_fotograf;
                if ($path === null && ! empty($row->bursiyer_id)) {
                    $scholar = \App\Models\Scholar::find($row->bursiyer_id);
                    $path = $scholar ? $scholar->latestPhoto() : null;
                }

                return $path ? 'Evet' : 'Hayır';
            case 'name':
            case 'surname':
            case 'tel_no':
            case 'email':
            case 'tc_no':
            case 'grade_departmant':
            case 'islemi_yapan':
                return (string) ($row->{$col} ?? '');
            case 'educationType':
                return education_type_label($row->educationType ?? null);
            case 'aday_turu':
                return $this->formatRenewExportAdayTuru($row->aday_turu ?? null);
            case 'status':
                return $this->formatRenewExportStatusLabel($row->status ?? null);
            case 'p_school_name':
                return $this->computeRenewExportSchoolName($row);
            case 'class':
                return $this->computeRenewExportClass($row);
            case 'created_at':
                if (! empty($row->form_created_at)) {
                    return Carbon::parse($row->form_created_at)->format('d.m.Y');
                }

                return '';
            default:
                if (str_starts_with($col, 'doc_')) {
                    return $this->getBelgeDurum($row->{$col} ?? null);
                }

                return (string) ($row->{$col} ?? '');
        }
    }

    protected function buildRenewExportRowArray(RenewAnswer $row, array $columnKeys): array
    {
        $assoc = [];
        foreach ($columnKeys as $key) {
            $assoc[$key] = $this->formatRenewExportCell($row, $key);
        }

        return $assoc;
    }

    public function startRenewExport(Request $request)
    {
        $visibleColumns = $request->input('visibleColumns');
        if (is_string($visibleColumns)) {
            $visibleColumns = json_decode($visibleColumns, true);
        }
        $visibleColumns = is_array($visibleColumns) ? $visibleColumns : [];

        $wideExport = $request->boolean('wideExport', false);

        $formIds = $this->extractRenewExportFormIds($request);
        $columnKeys = $wideExport
            ? []
            : $this->resolveRenewExportColumnKeys($visibleColumns);

        $exportId = uniqid('renew_export_', true);
        Cache::put($exportId, [
            'formIds' => $formIds,
            'columnKeys' => $columnKeys,
            'wideExport' => $wideExport,
        ], 3600);

        \Illuminate\Support\Facades\Log::info('Renew Export Started (Cache)', ['id' => $exportId, 'count' => count($formIds)]);

        return response()->json([
            'exportId' => $exportId,
            'total' => count($formIds),
            'batchSize' => 50,
        ]);
    }

    public function processRenewExportChunk(Request $request)
    {
        $exportId = $request->exportId;
        $chunkIndex = (int) $request->chunkIndex;
        $batchSize = (int) $request->batchSize;

        $meta = Cache::get($exportId);
        if (! $meta || ! isset($meta['formIds'])) {
            return response()->json(['error' => 'Oturum süresi dolmuş veya Cache hatası.'], 400);
        }

        $formIds = $meta['formIds'];
        $columnKeys = $meta['columnKeys'] ?? $this->resolveRenewExportColumnKeys([]);
        $wideExport = $meta['wideExport'] ?? false;

        \Illuminate\Support\Facades\Log::info('Renew Export Chunk Processing', ['id' => $exportId, 'index' => $chunkIndex, 'total_ids' => count($formIds)]);

        $chunkFormIds = array_slice($formIds, $chunkIndex * $batchSize, $batchSize);

        $rows = [];
        if (! empty($chunkFormIds)) {
            if ($wideExport) {
                $models = $this->renewListBaseQuery()
                    ->whereIn('renew_answers.form_id', $chunkFormIds)
                    ->with(['bursTipi'])
                    ->get()
                    ->keyBy(fn ($m) => (int) $m->form_id);

                foreach ($chunkFormIds as $fid) {
                    $row = $models->get((int) $fid);
                    if ($row) {
                        $rows[] = $row->toArray();
                    }
                }
            } else {
                $models = $this->renewListBaseQuery()
                    ->whereIn('renew_answers.form_id', $chunkFormIds)
                    ->get();

                foreach ($chunkFormIds as $fid) {
                    $target = (int) $fid;
                    $row = $models->first(function ($m) use ($target) {
                        return (int) $m->form_id === $target;
                    });
                    if (! $row) {
                        continue;
                    }
                    $rows[] = $this->buildRenewExportRowArray($row, $columnKeys);
                }
            }
        }

        $tempDir = storage_path('app/public/temp/' . $exportId);
        if (! File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0777, true);
        }

        File::put($tempDir.'/chunk_'.$chunkIndex.'.json', json_encode($rows));

        return response()->json(['success' => true]);
    }

    public function finalizeRenewExport(Request $request)
    {
        $exportId = $request->exportId;
        $totalChunks = (int) $request->totalChunks;

        $meta = Cache::get($exportId);
        if (! $meta) {
            return response()->json(['error' => 'Oturum süresi dolmuş veya Cache hatası.'], 400);
        }

        $wideExport = $meta['wideExport'] ?? false;

        $tempDir = storage_path('app/public/temp/'.$exportId);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if ($wideExport) {
            $headers = $this->getRenewWideExportHeaders();
            foreach ($headers as $key => $header) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
                $sheet->setCellValue($col.'1', $header);
            }

            $rowNum = 2;
            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFile = $tempDir.'/chunk_'.$i.'.json';
                if (! File::exists($chunkFile)) {
                    continue;
                }
                $chunkData = json_decode(File::get($chunkFile));
                if (! is_array($chunkData)) {
                    continue;
                }
                foreach ($chunkData as $data) {
                    $this->writeRenewWideExportFullRow($sheet, $rowNum, $data);
                    $rowNum++;
                }
            }
        } else {
            $columnKeys = $meta['columnKeys'] ?? $this->resolveRenewExportColumnKeys([]);
            $titleMap = $this->getRenewExportColumnTitleMap();

            $headers = [];
            foreach ($columnKeys as $key) {
                $headers[] = $titleMap[$key] ?? $key;
            }

            foreach ($headers as $i => $header) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
                $sheet->setCellValue($col.'1', $header);
            }

            $rowNum = 2;
            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFile = $tempDir.'/chunk_'.$i.'.json';
                if (! File::exists($chunkFile)) {
                    continue;
                }
                $chunkData = json_decode(File::get($chunkFile), true);
                if (! is_array($chunkData)) {
                    continue;
                }
                foreach ($chunkData as $assocRow) {
                    if (! is_array($assocRow)) {
                        continue;
                    }
                    $colIdx = 1;
                    foreach ($columnKeys as $key) {
                        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
                        $val = $assocRow[$key] ?? '';
                        $sheet->setCellValue($col.$rowNum, $val);
                        $colIdx++;
                    }
                    $rowNum++;
                }
            }
        }

        File::deleteDirectory($tempDir);
        Cache::forget($exportId);

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Kayit_Yenileme_'.time().'.xlsx';
        $directoryPath = storage_path('app/public/temp');
        $filePath = $directoryPath.'/'.$fileName;

        if (! File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0777, true);
        }

        $writer->save($filePath);

        return response()->json([
            'success' => true,
            'fileName' => $fileName,
            'downloadUrl' => route('renew.export.download', ['fileName' => $fileName]),
        ]);
    }

    /**
     * Aday (NewAnswer) toplu export ile aynı sütun başlıkları — kayıt yenileme geniş aktarım.
     */
    protected function getRenewWideExportHeaders(): array
    {
        return [
            'Başvuru No', 'Toplam Puan', 'Ad', 'Soyad', 'TC No', 'Öğrenim Tipi', 'Cep Telefonu', 'Burs Tipi', 'Başvuru Durumu', 'Ret Sebebi', 'E-Posta', 'Doğum Tarihi',
            'Nüfus Kayıtlı Olduğu Şehir', 'Nüfus Kayıtlı Olduğu İlçe', 'Doğduğu Şehir', 'Doğduğu İlçe', 'Cinsiyet', 'Medeni Durum',
            'Uyruk', 'Okul Tipi', 'İlkokul Adı', 'İlkokul Bulunduğu Şehir', 'Sınıf', 'Öğrenci No', 'Not Ortalaması', 'Nakil Yaptı Mı',
            'Ortaokul Adı', 'Ortaokul Bulunduğu Şehir', 'Ortaokul Bulunduğu İlçe', 'Lise Adı', 'Lise Bulunduğu Şehir', 'Lise Bulunduğu İlçe',
            'Bitirdiğiniz Lise', 'Üniversiteye Giriş Puanı', 'Üniversite Şehri', 'Öğrenime Devam Ettiğiniz Üniversite',
            'Öğrenime Devam Ettiğiniz Fakülte', 'Öğrenime Devam Ettiğiniz Bölüm', 'Üniversitenin Statüsü', 'Kaçıncı Sınıfta Olacaksınız?',
            'Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)', 'AGNO Sisteminiz', 'AGNO', 'Yatay/Dikey Geçiş Yaptı mı?',
            'Yatay/Dikey Geçiş yaptıysanız geçiş bilgilerinizi yazınız', 'Bildiğiniz diller nelerdir? Seviyeleri ile birlikte yazınız',
            'Bitirdiğiniz Üniversite', 'Mezun Olduğunuz Bölüm', 'Yüksek Lisans Yaptığınız Üniversite', 'Yüksek Lisans Yaptığınız Dal',
            'Mezuniyet AGNO', 'Barınma Türü', 'Ödenen Ücret', 'Birlikte Yaşanılan Kişi Sayısı', 'Kaldığı İl', 'Kaldığı İlçe',
            'Tam Adres', 'Annenin Yaşadığı İl', 'Annenin Yaşadığı İlçe', 'Babanın Yaşadığı İl', 'Babanın Yaşadığı İlçe',
            'Açık Adres', 'Aile Cep Telefonu', 'Aile Ev Telefonu', 'Aile E-posta Adresi', 'Acil Durum Kişisi Ad',
            'Acil Durum Kişisi Soyad', 'Acil Durum Kişisi Telefonu', 'Acil Durum Kişisi Yakınlık Derecesi',
            'Anne Baba Birlikte Mi?', 'Anne Baba Sağ Mı?', 'Anne Ad', 'Anne Soyad', 'Baba Ad', 'Baba Soyad', 'Anne Meslek',
            'Baba Meslek', 'Anne Tahsil Durumu', 'Baba Tahsil Durumu', 'Anne Bağlı Olduğu Sosyal Güvenlik Kurumu',
            'Baba Bağlı Olduğu Sosyal Güvenlik Kurumu', 'Kardeş Sayısı', 'Kendisi Dahil Okuyan Kardeş Sayısı',
            'Ailenin Geçimini Kim/Kimler Sağlıyor?', 'Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye Bakıyor?',
            'Annenin Aylık Net Geliri (TL)', 'Babanın Aylık Net Geliri (TL)', 'Diğer Kişilerin Aylık Net Geliri (TL)',
            'Ailenin Başka Geliri Var Mı?', 'Ailenin Yaşamakta Olduğu Ev Türü', 'Kira ise Aylık Net Kirası (TL)',
            'Diğer Gelir Bilgisi', 'Devlet Bursu Almakta mı ya da Başvurdu mu?', 'Özel Burs Almakta ya da Başvurdu mu?',
            'Herhangi Bir Engeliniz Var mı?', 'Engel Durumunu Açıklayınız (Varsa)', 'Bizden Nasıl Haberdar Oldunuz?',
            'Güçlü Yanlarınızın Ne olduğunu Düşünüyorsunuz?', 'Katkıda Bulunduğunuz Sosyal Projeler', 'Hobileriniz',
            'İlgilendiğiniz Spor Dalı (Varsa)', 'Son Okuduğunuz Kitaplar', 'Bize Mesajınız', 'Banka', 'IBAN', 'Hesap Numarası',
            'Düzenli olarak bir kurumda kazanç sağlıyor mu?', 'Kurum Adı', 'Görev', 'Sosyal Güvenlik Kurumu', 'Aylık Net Ücret (TL)',
            'Öğrenci Belgesi', 'Adli Sicil Kaydı', 'Nüfus Kayıt Örneği', 'Anne Gelir Belgesi', 'Baba Gelir Belgesi', 'Taahhütname',
            'Kimlik', 'Banka Hesap', 'Transkript', 'İkametgah', 'Karne', 'Diğer', 'Mülakat Durumu',
        ];
    }

    /**
     * @param  \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet  $sheet
     * @param  object  $data  json_decode ile gelen renew_answers satırı (+ burs_tipi)
     */
    protected function writeRenewWideExportFullRow($sheet, int $rowNum, object $data): void
    {
        $status = 'Belirsiz';
        switch ((int) ($data->status ?? -1)) {
            case 0:
                $status = 'Devam Ediyor';
                break;
            case 1:
                $status = 'Onay Bekliyor';
                break;
            case 2:
                $status = 'İade Edildi';
                break;
            case 3:
                $status = 'Onaylandı';
                break;
            case 4:
                $status = 'Reddedildi';
                break;
            case 5:
                $status = 'İadeden Döndü';
                break;
        }

        $bursTipiAdi = '';
        if (isset($data->burs_tipi) && is_object($data->burs_tipi)) {
            $bursTipiAdi = $data->burs_tipi->burs_tipi ?? '';
        } elseif (isset($data->burs_tipi) && is_array($data->burs_tipi)) {
            $bursTipiAdi = $data->burs_tipi['burs_tipi'] ?? '';
        }

        $sheet->setCellValue('A'.$rowNum, $data->id ?? '');
        $sheet->setCellValue('B'.$rowNum, $data->totalPoints ?? '');
        $sheet->setCellValue('C'.$rowNum, $data->name ?? '');
        $sheet->setCellValue('D'.$rowNum, $data->surname ?? '');
        $sheet->setCellValue('E'.$rowNum, $data->tc_no ?? '');
        $sheet->setCellValue('F'.$rowNum, education_type_label($data->educationType ?? null));
        $sheet->setCellValue('G'.$rowNum, $data->tel_no ?? '');
        $sheet->setCellValue('H'.$rowNum, $bursTipiAdi);
        $sheet->setCellValue('I'.$rowNum, $status);
        $sheet->setCellValue('J'.$rowNum, $data->redSebebi ?? '');
        $sheet->setCellValue('K'.$rowNum, $data->email ?? '');
        $sheet->setCellValue('L'.$rowNum, $data->b_dob ?? '');
        $sheet->setCellValue('M'.$rowNum, $data->registered_city ?? '');
        $sheet->setCellValue('N'.$rowNum, $data->registered_district ?? '');
        $sheet->setCellValue('O'.$rowNum, $data->born_city ?? '');
        $sheet->setCellValue('P'.$rowNum, $data->born_district ?? '');
        $sheet->setCellValue('Q'.$rowNum, $data->gender ?? '');
        $sheet->setCellValue('R'.$rowNum, $data->maritality ?? '');
        $sheet->setCellValue('S'.$rowNum, $data->nationality ?? '');
        $sheet->setCellValue('T'.$rowNum, $data->primary_educ_type ?? '');
        $sheet->setCellValue('U'.$rowNum, $data->p_school_name ?? '');
        $sheet->setCellValue('V'.$rowNum, $data->p_school_city ?? '');
        $sheet->setCellValue('W'.$rowNum, $data->class ?? '');
        $sheet->setCellValue('X'.$rowNum, $data->student_number ?? '');
        $sheet->setCellValue('Y'.$rowNum, $data->grade_avg ?? '');
        $sheet->setCellValue('Z'.$rowNum, $data->is_transfered ?? '');
        $sheet->setCellValue('AA'.$rowNum, $data->m_school_name ?? '');
        $sheet->setCellValue('AB'.$rowNum, $data->m_school_city ?? '');
        $sheet->setCellValue('AC'.$rowNum, $data->m_school_district ?? '');
        $sheet->setCellValue('AD'.$rowNum, $data->h_school_name ?? '');
        $sheet->setCellValue('AE'.$rowNum, $data->h_school_city ?? '');
        $sheet->setCellValue('AF'.$rowNum, $data->h_school_district ?? '');
        $sheet->setCellValue('AG'.$rowNum, $data->grade_high_school ?? '');
        $sheet->setCellValue('AH'.$rowNum, $data->entry_grade_university ?? '');
        $sheet->setCellValue('AI'.$rowNum, $data->university_city ?? '');
        $sheet->setCellValue('AJ'.$rowNum, $data->current_university ?? '');
        $sheet->setCellValue('AK'.$rowNum, $data->university_faculty ?? '');
        $sheet->setCellValue('AL'.$rowNum, $data->grade_departmant ?? '');
        $sheet->setCellValue('AM'.$rowNum, $data->university_type ?? '');
        $sheet->setCellValue('AN'.$rowNum, $data->university_class ?? '');
        $sheet->setCellValue('AO'.$rowNum, $data->university_educ_time ?? '');
        $sheet->setCellValue('AP'.$rowNum, $data->agno_type ?? '');
        $sheet->setCellValue('AQ'.$rowNum, $data->agno ?? '');
        $sheet->setCellValue('AR'.$rowNum, $data->university_transfer ?? '');
        $sheet->setCellValue('AS'.$rowNum, $data->university_transfer_desc ?? '');
        $sheet->setCellValue('AT'.$rowNum, $data->languages ?? '');
        $sheet->setCellValue('AU'.$rowNum, $data->grade_university ?? '');
        $sheet->setCellValue('AV'.$rowNum, $data->grade_departmant ?? '');
        $sheet->setCellValue('AW'.$rowNum, $data->master_university ?? '');
        $sheet->setCellValue('AX'.$rowNum, $data->master_field ?? '');
        $sheet->setCellValue('AY'.$rowNum, $data->grade_agno ?? '');
        $sheet->setCellValue('AZ'.$rowNum, $data->housing_type ?? '');
        $sheet->setCellValue('BA'.$rowNum, $data->housing_fee ?? '');
        $sheet->setCellValue('BB'.$rowNum, $data->living_with_count ?? '');
        $sheet->setCellValue('BC'.$rowNum, $data->residing_city ?? '');
        $sheet->setCellValue('BD'.$rowNum, $data->residing_district ?? '');
        $sheet->setCellValue('BE'.$rowNum, $data->address_detail ?? '');
        $sheet->setCellValue('BF'.$rowNum, $data->mother_city ?? '');
        $sheet->setCellValue('BG'.$rowNum, $data->mother_district ?? '');
        $sheet->setCellValue('BH'.$rowNum, $data->father_city ?? '');
        $sheet->setCellValue('BI'.$rowNum, $data->father_district ?? '');
        $sheet->setCellValue('BJ'.$rowNum, $data->parent_address ?? '');
        $sheet->setCellValue('BK'.$rowNum, $data->parent_mobile ?? '');
        $sheet->setCellValue('BL'.$rowNum, $data->parent_phone ?? '');
        $sheet->setCellValue('BM'.$rowNum, $data->parent_email ?? '');
        $sheet->setCellValue('BN'.$rowNum, $data->emergency_person_name ?? '');
        $sheet->setCellValue('BO'.$rowNum, $data->emergency_person_surname ?? '');
        $sheet->setCellValue('BP'.$rowNum, $data->emergency_mobile ?? '');
        $sheet->setCellValue('BQ'.$rowNum, $data->emergency_closeness ?? '');
        $sheet->setCellValue('BR'.$rowNum, $data->parent_together ?? '');
        $sheet->setCellValue('BS'.$rowNum, $data->mother_alive ?? '');
        $sheet->setCellValue('BT'.$rowNum, $data->mother_name ?? '');
        $sheet->setCellValue('BU'.$rowNum, $data->mother_surname ?? '');
        $sheet->setCellValue('BV'.$rowNum, $data->father_name ?? '');
        $sheet->setCellValue('BW'.$rowNum, $data->father_surname ?? '');
        $sheet->setCellValue('BX'.$rowNum, $data->mother_job ?? '');
        $sheet->setCellValue('BY'.$rowNum, $data->father_job ?? '');
        $sheet->setCellValue('BZ'.$rowNum, $data->mother_educ ?? '');
        $sheet->setCellValue('CA'.$rowNum, $data->father_educ ?? '');
        $sheet->setCellValue('CB'.$rowNum, $data->mother_company ?? '');
        $sheet->setCellValue('CC'.$rowNum, $data->father_company ?? '');
        $sheet->setCellValue('CD'.$rowNum, $data->educ_count ?? '');
        $sheet->setCellValue('CE'.$rowNum, $data->count ?? '');
        $sheet->setCellValue('CF'.$rowNum, $data->income_person ?? '');
        $sheet->setCellValue('CG'.$rowNum, $data->total_person ?? '');
        $sheet->setCellValue('CH'.$rowNum, $data->mother_salary ?? '');
        $sheet->setCellValue('CI'.$rowNum, $data->father_salary ?? '');
        $sheet->setCellValue('CJ'.$rowNum, $data->other_salary ?? '');
        $sheet->setCellValue('CK'.$rowNum, $data->other_income ?? '');
        $sheet->setCellValue('CL'.$rowNum, $data->parent_housing_type ?? '');
        $sheet->setCellValue('CM'.$rowNum, $data->rent_count ?? '');
        $sheet->setCellValue('CN'.$rowNum, $data->other_detail ?? '');
        $sheet->setCellValue('CO'.$rowNum, $data->government ?? '');
        $sheet->setCellValue('CP'.$rowNum, $data->special ?? '');
        $sheet->setCellValue('CQ'.$rowNum, $data->disabled_status ?? '');
        $sheet->setCellValue('CR'.$rowNum, $data->disabled_detail ?? '');
        $sheet->setCellValue('CS'.$rowNum, $data->platform ?? '');
        $sheet->setCellValue('CT'.$rowNum, $data->skills ?? '');
        $sheet->setCellValue('CU'.$rowNum, $data->social_projects ?? '');
        $sheet->setCellValue('CV'.$rowNum, $data->hobbies ?? '');
        $sheet->setCellValue('CW'.$rowNum, $data->sports ?? '');
        $sheet->setCellValue('CX'.$rowNum, $data->last_books ?? '');
        $sheet->setCellValue('CY'.$rowNum, $data->message ?? '');
        $sheet->setCellValue('CZ'.$rowNum, $data->bank_name ?? '');
        $sheet->setCellValue('DA'.$rowNum, $data->iban ?? '');
        $sheet->setCellValue('DB'.$rowNum, $data->account_number ?? '');
        $sheet->setCellValue('DC'.$rowNum, $data->is_working ?? '');
        $sheet->setCellValue('DD'.$rowNum, $data->job_company ?? '');
        $sheet->setCellValue('DE'.$rowNum, $data->job_rank ?? '');
        $sheet->setCellValue('DF'.$rowNum, $data->job_sgk ?? '');
        $sheet->setCellValue('DG'.$rowNum, $data->job_salary ?? '');
        $sheet->setCellValue('DH'.$rowNum, $this->getBelgeDurum($data->doc_ogrenciBelgesi ?? null));
        $sheet->setCellValue('DI'.$rowNum, $this->getBelgeDurum($data->doc_adlisicilkaydi ?? null));
        $sheet->setCellValue('DJ'.$rowNum, $this->getBelgeDurum($data->doc_nufuskayitornegi ?? null));
        $sheet->setCellValue('DK'.$rowNum, $this->getBelgeDurum($data->doc_annegelirbelgesi ?? null));
        $sheet->setCellValue('DL'.$rowNum, $this->getBelgeDurum($data->doc_babagelirbelgesi ?? null));
        $sheet->setCellValue('DM'.$rowNum, $this->getBelgeDurum($data->doc_taahhutname ?? null));
        $sheet->setCellValue('DN'.$rowNum, $this->getBelgeDurum($data->doc_kimlik ?? null));
        $sheet->setCellValue('DO'.$rowNum, $this->getBelgeDurum($data->doc_bankahesap ?? null));
        $sheet->setCellValue('DP'.$rowNum, $this->getBelgeDurum($data->doc_transkript ?? null));
        $sheet->setCellValue('DQ'.$rowNum, $this->getBelgeDurum($data->doc_ikametgah ?? null));
        $sheet->setCellValue('DR'.$rowNum, $this->getBelgeDurum($data->doc_Karne ?? null));
        $sheet->setCellValue('DS'.$rowNum, $this->getBelgeDurum($data->doc_Diger ?? null));
        $sheet->setCellValue('DT'.$rowNum, $data->mulakat_durumu ?? '');
    }

    public function downloadRenewExport($fileName)
    {
        $filePath = storage_path('app/public/temp/' . $fileName);

        if (File::exists($filePath)) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        return abort(404);
    }

    private function getBelgeDurum($value)
    {
        return empty($value) ? 'Hayır' : 'Evet';
    }
}
