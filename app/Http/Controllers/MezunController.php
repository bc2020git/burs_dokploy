<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScholarForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\ActiveAnswer;
use App\Models\Scholar;
use App\Models\Soru;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\PanelController;
class MezunController extends Controller
{
    public function __construct(FilterController $filterController, PanelController $panelController)
    {
        $this->filterController = $filterController;
        $this->panelController = $panelController;
    }
    public function index()
    {
        session(['sidebar' => 7]);


        $columns = $this->getColumnDefinitions();
        $columns['name']['title'] = 'Ad';
        $columns['surname']['title'] = 'Soyad';
        $columns['educationType']['title'] = 'Öğrenim Türü';
        $columns['doc_fotograf']['filterable'] = true;
        $columns['doc_fotograf']['orderable'] = false;
        $columns['doc_fotograf']['title'] = 'Fotoğraf';
        $columns['form_id']['title'] = 'Bursiyer No';
        $columns['aday_id']['title'] = 'Başvuru No';
        //$columns['form.scholar.aday_id']['title'] = 'Başvuru No';
        //$columns['tc_no']['title'] = 'T.C Kimlik No..';
        $columns['aday_turu']['title'] = 'Bursiyer Tipi';
        $columns['tel_no']['title'] = 'Telefon No';
        $columns['email']['title'] = 'E-posta';
        //$columns['form.status']['title'] = 'Burs Durumu';
        $columns['p_school_name']['title'] = 'Okul Adı';
        $columns['class']['title'] = 'Sınıf';
        $columns['class']['type'] = 'number';
        $columns['tc_no']['title'] = 'T.C Kimlik No.';
        $columns['tc_no']['type'] = 'number';
        $columns['tc_no']['conditions'] = $this->getColumnConditions('number');
        $columns['grade_departmant']['title'] = 'Bölüm';
        //$columns['form.islemi_yapan']['title'] = 'İşlem Yapan';
        //$columns['form.scholar.id']['title'] = 'Bursiyer No';
        //$columns['form.scholar.created_at']['title'] = 'Burs Başlangıç';
        //$columns['form.scholar.created_at']['filterType'] = 'date';
        //$columns['form.scholar.created_at']['filterOptions'] = ['=' => 'Eşittir', '>' => 'Sonra', '<' => 'Önce'];
        //$columns['form_id']['visible'] = false;
        $query = ActiveAnswer::with(['scholar','form']);
        $adaylar = $query->get();
        $result = [
            'columns' => $columns,
            'scholars' => $adaylar,
            'checkboxColumns'  => $this->getCheckboxColumns(),
            'docColumns' => [],
            // Dinamik sütun checkbox'ları için tüm sorular (Okulun Bulunduğu Şehir tekil olarak birleştirildi)
            'allQuestions' => $this->getColvisQuestions(),
        ];

        return view('panel.graduate-scholar.index',$result);
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
    private function getCheckboxColumns(){
        return ['aday_turu','form.status','educationType', 'doc_fotograf'];
    }
    public function getData(Request $request)
    {
        $query = $this->newBaseMezunListQuery();

        // Dinamik sütunları doğrula. Taban sorgu zaten 'active_answers.*' seçtiği için
        // veriyi ayrıca select etmeye gerek yok; sadece otomatik aramayı kapatacağız.
        $validDynamicColumns = [];
        if ($request->has('dynamic_columns') && !empty($request->dynamic_columns)) {
            $dynamicColumns = is_array($request->dynamic_columns) ? $request->dynamic_columns : explode(',', $request->dynamic_columns);
            $existingColumns = Schema::getColumnListing('active_answers');
            $validDynamicColumns = array_values(array_intersect($dynamicColumns, $existingColumns));
            $virtualKeys = ['school_city', 'school_district', 'school_name', 'school_type'];
            foreach ($virtualKeys as $vKey) {
                if (in_array($vKey, $dynamicColumns) && !in_array($vKey, $validDynamicColumns)) {
                    $validDynamicColumns[] = $vKey;
                }
            }
        }

        $datatables = DataTables::of($query)
            // DataTables'ın otomatik column search'ini devre dışı bırak
            ->filterColumn('doc_fotograf', function ($query, $keyword) {
            })
            ->filterColumn('educationType', function ($query, $keyword) {
            })
            ->filterColumn('aday_turu', function ($query, $keyword) {
            })
            ->filterColumn('form.status', function ($query, $keyword) {
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="userCheckbox" class="form-check-input" value="'.$row->form_id.'">';
            })

            ->addColumn('class', function($row){
                $ortaOgretim  =  ['ilkokul','ortaokul','lise'];
                if(in_array($row->educationType,$ortaOgretim)){
                    return $row->class;
                }
                return $row->university_class;
            })
            ->addColumn('p_school_name', function($row){
                $ortaOgretim  =  ['ilkokul','ortaokul','lise'];
                switch($row->educationType){
                    case 'ilkokul':
                        return $row->p_school_name;
                    case 'ortaokul':
                        return $row->m_school_name;
                    case 'lise':
                        return $row->h_school_name;
                    default:
                        return $row->current_university;
                }
            })
            ->addColumn('action', function($row){
                $url =  route('panel-mezun-bursiyer-incele', ['id' => $row->form_id]) ;
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

            ->filter(function ($query) use ($request) {
                $this->applyMezunListDataFilters($query, $request);
            }, true)
            ->order(function ($query) use ($request) {
                if ($request->has('order')) {
                    $order = json_decode($request->order, true);
                    if ($order && isset($order['column'])) {
                        $columnName = $order['column'];
                        if($columnName == 'aday_id'){
                            $columnName = 'scholar.aday_id';
                        }
                        if($columnName == 'p_school_name'){
                            // Tüm okul alanlarına göre sıralama
                            $query->orderBy('active_answers.p_school_name', $order['dir'])
                                  ->orderBy('active_answers.m_school_name', $order['dir'])
                                  ->orderBy('active_answers.h_school_name', $order['dir'])
                                  ->orderBy('active_answers.current_university', $order['dir']);
                            return; // Diğer sıralama işlemlerini atlayalım
                        }
                        // students. prefix'ini kaldır
                        if (str_starts_with($columnName, 'active_answers.')) {
                            $columnName = substr($columnName, 11);
                        }

                        if (str_contains($columnName, '.')) {
                            $parts = explode('.', $columnName);
                            $field = array_pop($parts);
                            $lastTable = last($parts) . 's';
                            $query->orderBy($lastTable . '.' . $field, $order['dir']);
                        } else {
                            $query->orderBy( $columnName, $order['dir']);
                        }
                    }
                }
            })
            ->rawColumns(['checkbox', 'action','class','university_class','p_school_name','school_name','grade_departmant']);

        // Dinamik sütunlar için otomatik aramayı kapat
        foreach ($validDynamicColumns as $column) {
            $datatables->filterColumn($column, function($query, $keyword) {});
        }

        return $datatables->make(true);
    }

    protected function newBaseMezunListQuery()
    {
        $query = ActiveAnswer::query();

        $query->join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
            ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
            ->where('scholar_forms.status', '=', 2);

        $query->select([
            'active_answers.*',
            'scholars.id as bursiyer_id',
            'scholar_forms.scholar_id as scholar_id',
            'scholar_forms.created_at as form_created_at',
            'scholar_forms.updated_at as form_updated_at',
            'scholars.aday_id as aday_id',
        ]);

        return $query;
    }

    protected function getMezunListFiltersFromRequest(Request $request): array
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

    protected function applyMezunListDataFilters($query, Request $request): void
    {
        $query->where('scholar_forms.status', '=', 2);

        $filters = $this->getMezunListFiltersFromRequest($request);
        if (! empty($filters)) {
            foreach ($filters as $column => $filter) {
                $this->applyColumnFilter($query, $column, $filter);
            }
        }

        $searchValue = $this->getMezunListGlobalSearchValue($request);
        if ($searchValue !== null && $searchValue !== '') {
            $query->where(function ($q) use ($searchValue) {
                $q->where('active_answers.name', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.surname', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.tc_no', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.p_school_name', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.m_school_name', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.h_school_name', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.current_university', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.class', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.university_class', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.oKN3UeDifPTo', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.educationType', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.tel_no', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.email', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.aday_turu', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.grade_departmant', 'like', "%{$searchValue}%")
                    ->orWhere('scholars.aday_id', 'like', "%{$searchValue}%")
                    ->orWhere('scholars.id', 'like', "%{$searchValue}%")
                    ->orWhere('active_answers.form_id', 'like', "%{$searchValue}%");
            });
        }
    }

    protected function getMezunListGlobalSearchValue(Request $request): ?string
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

    protected function extractMezunExportFormIds($query): array
    {
        return $query->clone()
            ->select('scholar_forms.id')
            ->orderBy('active_answers.id', 'desc')
            ->pluck('scholar_forms.id')
            ->unique()
            ->values()
            ->all();
    }

    private  function getColumnList(){
        $list = [
            'doc_fotograf',
            'form_id',
            'aday_id',
            'form.scholar.id',
            'aday_turu',
            'tc_no',
            'form.scholar.created_at',
            'name',
            'surname',
            'tel_no',
            'email',
            'educationType',
            'p_school_name',
            'class',
            'grade_departmant',
            'form.status',
            'form.islemi_yapan',
        ];
        return $list;
    }

    protected function getColumnDefinitions()
    {
        $model = new ActiveAnswer();

        $acceptedColumns = $this->getColumnList();
        $columns = [];



        // NewAnswer modelinin tüm sütunlarını al
        $allColumns = \Schema::getColumnListing('active_answers');

        // visibleColumns'ı allColumns'dan çıkart
        $hiddenColumns = array_diff($allColumns, $acceptedColumns);

        $allColumns = Schema::getColumnListing('active_answers');
        $columnDetails = [];
        // Sıralı şekilde sütunları ekleyelim
        foreach ($acceptedColumns as $column) {
            if (in_array($column, $allColumns)) {  // Veritabanında var olan sütunları kontrol et
                $title = $this->getColumnTitle($column);

                $type = $this->getColumnType($model, $column);
            $isVisible = in_array($column, $acceptedColumns);
            $columnDef = [
                'title' => $title,
                'name' => $column,
                'type' => $type,
                'filterable' => true,
                'filterType' => $this->getFilterType($type),
                'filterOptions' => $this->getFilterOptions($column, $type),
                'filterValue' => $this->getFilterValue($column, $type),
                'conditions' => $this->getColumnConditions($type),
                'is_visible' => $isVisible

            ];


            $columns[$column] = $columnDef;
            }
        }

        return $columns;
    }
    protected function getColumnTitle($column)
    {
        return $column;
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
    protected function getColumnOptions($column)
    {
        switch ($column) {
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
    protected function getColumnType($model, $column)
    {
        $casts = $model->getCasts();

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
    protected function applyColumnFilter($query, $column, $filter)
    {
        $value = $filter['value'] ?? '';
        $condition = $filter['condition'] ?? 'contains';

        $virtualColumnMap = [
            'school_city' => ['active_answers.p_school_city', 'active_answers.m_school_city', 'active_answers.h_school_city'],
            'school_district' => ['active_answers.p_school_district', 'active_answers.m_school_district', 'active_answers.h_school_district'],
            'school_name' => ['active_answers.p_school_name', 'active_answers.m_school_name', 'active_answers.h_school_name'],
            'school_type' => ['active_answers.primary_educ_type', 'active_answers.middle_educ_type', 'active_answers.high_educ_type'],
        ];

        if (array_key_exists($column, $virtualColumnMap)) {
            $this->buildJointCondition($query, $value, $condition, $virtualColumnMap[$column]);
            return;
        }

        $type = $this->getColumnDefinitions()[$column]['type'] ?? 'text';

        if ($column === 'aday_id') {
            $column = 'scholar.aday_id';
        }

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
        $baseColumns = ['id','name', 'surname', 'email', 'tel_no', 'tc_no','educationType','aday_turu','aday_id','mulakat_durumu','status'];
        if (in_array($field, $baseColumns)) {
            $field = 'active_answers.' . $field;
        }

        return $field;
    }
    protected function buildNumberCondition($query, $field, $value, $condition)
    {
        if ($field === 'active_answers.class' || $field === 'active_answers.university_class') {
            $this->buildClassCondition($query, $field, $value, $condition);
            return;
        }
        $field = $this->buildBaseColumns($field);
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
        switch ($condition) {
            case 'empty':
                $query->whereNull('active_answers.p_school_name')
                ->orWhereNull('active_answers.m_school_name')
                ->orWhereNull('active_answers.h_school_name')
                ->orWhereNull('active_answers.current_university');
                break;
            case 'not_empty':
                $query->whereNotNull('active_answers.p_school_name')
                ->orWhereNotNull('active_answers.m_school_name')
                ->orWhereNotNull('active_answers.h_school_name')
                ->orWhereNotNull('active_answers.current_university');
                break;
             default:
                $query->where('active_answers.p_school_name', 'like', "%{$value}%")
                ->orWhere('active_answers.m_school_name', 'like', "%{$value}%")
                ->orWhere('active_answers.h_school_name', 'like', "%{$value}%")
                ->orWhere('active_answers.current_university', 'like', "%{$value}%");
            return;
        }
    }
    protected function buildClassCondition($query, $field, $value, $condition)
    {
        // Sınıf için özel filtreleme
        if ($field === 'active_answers.class' || $field === 'active_answers.university_class') {
            $query->where('active_answers.class', 'like', "%{$value}%")
                ->orWhere('active_answers.university_class', 'like', "%{$value}%");
            return;
        }
    }

    protected function buildTextCondition($query, $field, $value, $condition)
    {
        $field = $this->buildBaseColumns($field);
        if ($field === 'school_name' || $field === 'p_school_name') {
            $this->buildSchoolNameCondition($query, $field, $value, $condition);
            return;
        }
        if ($field === 'active_answers.class' || $field === 'active_answers.university_class') {
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
                        $allRecords = \DB::table('active_answers')
                            ->join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
                            ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                            ->select('active_answers.id as id', 'scholars.id as bursiyer_id', 'active_answers.doc_fotograf as doc_fotograf')
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
                                    $q->whereIn('active_answers.id', $yokIds);
                                    $isFirst = false;
                                } else {
                                    $q->orWhereIn('active_answers.id', $yokIds);
                                }
                            } elseif ($item === 'Profil Var') {
                                if ($isFirst) {
                                    $q->whereIn('active_answers.id', $varIds);
                                    $isFirst = false;
                                } else {
                                    $q->orWhereIn('active_answers.id', $varIds);
                                }
                            } elseif ($item === 'Uyumsuz') {
                                if ($isFirst) {
                                    $q->whereIn('active_answers.id', $uyumsuzIds);
                                    $isFirst = false;
                                } else {
                                    $q->orWhereIn('active_answers.id', $uyumsuzIds);
                                }
                            }
                        }
                    });
                    break;
                }
                if(str_starts_with($field, 'doc_')){
                    foreach($value as $item){
                        if($item == 'Hayır'){
                            $query->orWhereNull($field);
                        }else{
                            $query->orWhereNotNull($field);
                        }
                    }
                }
                if(is_array($value)){
                    foreach($value as $item){
                        if($item == 'null'){
                            $query->orWhereNull($field);
                        }else{
                            $query->orWhere($field, $item);
                        }
                    }
                }
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

    protected function buildBursDurumuCondition($query, $field, $value, $condition)
    {
        foreach($value as $item){
            $query->where('scholars.status', $item);
        }
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
    private function getFilterOptions($column, $type)
    {
        $options = $this->filterController->returnFilterOptions();

        if ($column === 'doc_fotograf') {
            return ['Profil Var', 'Profil Yok', 'Uyumsuz'];
        }

        // Özel durumlar için
        if ($column === 'educationType') {
            $values = ['İlkokul','Ortaokul','Lise','Ön lisans','Lisans','Yüksek Lisans','Doktora'];
            return $values;
        }


        if ($column === 'aday_turu') {
            $values= ['Dernek','Vakıf','Boş'];
            return $values;
        }



        return $options[$this->getFilterType($type)] ?? $options['text'];
    }
    private function getFilterValue($column, $type)
    {
        if ($column === 'doc_fotograf') {
            return ['Profil Var', 'Profil Yok', 'Uyumsuz'];
        }

        if ($column === 'educationType') {
            // Veritabanında kayıtlı değerlerle eşleşmeli
            $values = ['ilkokul', 'ortaokul', 'lise', 'onlisans', 'lisans', 'yukseklisans', 'doktora'];
            return $values;
        }

        if ($column === 'aday_turu') {
            $values = ['Dernek','Vakıf','null'];
            return $values;
        }

        return null;
    }

    public function startMezunListExport(Request $request)
    {
        $userIds = $request->input('userIds');
        if (is_string($userIds)) {
            $userIds = json_decode($userIds, true);
        }
        $userIds = is_array($userIds) ? $userIds : [];

        $visibleColumns = $request->input('visibleColumns');
        if (is_string($visibleColumns)) {
            $visibleColumns = json_decode($visibleColumns, true);
        }
        $visibleColumns = is_array($visibleColumns) ? $visibleColumns : [];

        if (! empty($userIds)) {
            $formIds = array_values(array_unique(array_map('intval', $userIds)));
        } else {
            $query = $this->newBaseMezunListQuery();
            $this->applyMezunListDataFilters($query, $request);
            $formIds = $this->extractMezunExportFormIds($query);
        }

        $exportId = uniqid('export_mezun_list_', true);
        Cache::put($exportId, [
            'formIds' => $formIds,
            'visibleColumns' => $visibleColumns,
        ], 1800);

        return response()->json([
            'exportId' => $exportId,
            'total' => count($formIds),
            'batchSize' => 50,
        ]);
    }

    public function processMezunListExportChunk(Request $request)
    {
        $exportId = $request->input('exportId');
        $index = (int) $request->input('index');
        $batchSize = (int) $request->input('batchSize', 50);

        $meta = Cache::get($exportId);
        if (! $meta || ! isset($meta['formIds'])) {
            return response()->json(['error' => 'Geçersiz export ID'], 400);
        }

        $formIds = $meta['formIds'];
        $visibleColumns = $meta['visibleColumns'] ?? [];
        $columnKeys = $this->resolveMezunExportColumnKeys($visibleColumns);

        $offset = $index * $batchSize;
        $chunkFormIds = array_slice($formIds, $offset, $batchSize);

        $rows = [];
        if (! empty($chunkFormIds)) {
            $models = ActiveAnswer::with(['form.scholar'])
                ->whereIn('form_id', $chunkFormIds)
                ->get();

            foreach ($chunkFormIds as $fid) {
                $target = (int) $fid;
                $row = $models->first(function ($m) use ($target) {
                    return (int) $m->form_id === $target;
                });
                if (! $row) {
                    continue;
                }
                $rows[] = $this->buildMezunExportRowArray($row, $columnKeys);
            }
        }

        $tempDir = storage_path('app/public/temp/'.$exportId);
        if (! File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0777, true);
        }

        File::put($tempDir.'/chunk_'.$index.'.json', json_encode($rows));

        return response()->json(['success' => true]);
    }

    public function finalizeMezunListExport(Request $request)
    {
        $exportId = $request->input('exportId');
        $totalChunks = (int) $request->input('totalChunks');

        $meta = Cache::get($exportId);
        if (! $meta) {
            return response()->json(['error' => 'Geçersiz export ID'], 400);
        }

        $visibleColumns = $meta['visibleColumns'] ?? [];
        $columnKeys = $this->resolveMezunExportColumnKeys($visibleColumns);
        $titleMap = $this->getMezunExportColumnTitleMap();

        $headers = [];
        foreach ($columnKeys as $key) {
            $headers[] = $titleMap[$key] ?? $key;
        }

        $tempDir = storage_path('app/public/temp/'.$exportId);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

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

        File::deleteDirectory($tempDir);
        Cache::forget($exportId);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Mezunlar_'.time().'.xlsx';
        $directoryPath = storage_path('app/public/temp');
        $filePath = $directoryPath.'/'.$fileName;

        if (! File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0777, true);
        }

        $writer->save($filePath);

        return response()->json([
            'success' => true,
            'fileName' => $fileName,
            'downloadUrl' => route('mezunlar.export.download', ['fileName' => $fileName]),
        ]);
    }

    public function downloadMezunListExport($fileName)
    {
        $filePath = storage_path('app/public/temp/'.$fileName);
        if (File::exists($filePath)) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        return abort(404);
    }

    protected function getMezunExportableColumnKeys(): array
    {
        return [
            'doc_fotograf', 'form_id', 'aday_id', 'form.scholar.id', 'aday_turu', 'tc_no',
            'form.scholar.created_at', 'name', 'surname', 'tel_no', 'email',
            'educationType', 'p_school_name', 'class', 'grade_departmant', 'form.status', 'form.islemi_yapan',
        ];
    }

    protected function resolveMezunExportColumnKeys(array $visibleColumns): array
    {
        $allowed = $this->getMezunExportableColumnKeys();
        if (empty($visibleColumns)) {
            return $allowed;
        }
        $out = [];
        foreach ($visibleColumns as $col) {
            if (in_array($col, ['checkbox', 'action'], true)) {
                continue;
            }
            if (in_array($col, $allowed, true)) {
                $out[] = $col;
            }
        }

        return $out !== [] ? $out : $allowed;
    }

    protected function getMezunExportColumnTitleMap(): array
    {
        $overrides = [
            'doc_fotograf' => 'Fotoğraf',
            'form_id' => 'Bursiyer No',
            'aday_id' => 'Başvuru No',
            'form.scholar.id' => 'Scholar ID',
            'aday_turu' => 'Bursiyer Tipi',
            'tc_no' => 'T.C Kimlik No.',
            'form.scholar.created_at' => 'Form Tarihi',
            'name' => 'Ad',
            'surname' => 'Soyad',
            'tel_no' => 'Telefon No',
            'email' => 'E-posta',
            'educationType' => 'Öğrenim Türü',
            'p_school_name' => 'Okul Adı',
            'class' => 'Sınıf',
            'grade_departmant' => 'Bölüm',
            'form.status' => 'Form Durumu',
            'form.islemi_yapan' => 'İşlemi Yapan',
        ];
        $map = [];
        foreach ($this->getMezunExportableColumnKeys() as $key) {
            $map[$key] = $overrides[$key] ?? $key;
        }

        return $map;
    }

    protected function buildMezunExportRowArray(ActiveAnswer $row, array $columnKeys): array
    {
        $assoc = [];
        foreach ($columnKeys as $key) {
            $assoc[$key] = $this->formatMezunExportCell($row, $key);
        }

        return $assoc;
    }

    protected function formatMezunExportCell(ActiveAnswer $row, string $col): string
    {
        $form = $row->form;
        $scholar = $form && $form->scholar ? $form->scholar : null;

        switch ($col) {
            case 'doc_fotograf':
                $path = $row->doc_fotograf;
                if ($path === null && $scholar) {
                    $path = $scholar->latestPhoto();
                }

                return $path ? 'Evet' : 'Hayır';
            case 'form_id':
                return (string) ($row->form_id ?? '');
            case 'aday_id':
                return (string) ($scholar->aday_id ?? '');
            case 'form.scholar.id':
                return (string) ($scholar->id ?? '');
            case 'aday_turu':
                return $this->formatMezunAdayTuruExport($row->aday_turu ?? null);
            case 'tc_no':
                return (string) ($row->tc_no ?? '');
            case 'form.scholar.created_at':
                if ($form && $form->created_at) {
                    return Carbon::parse($form->created_at)->format('d.m.Y H:i');
                }

                return '';
            case 'name':
                return (string) ($row->name ?? '');
            case 'surname':
                return (string) ($row->surname ?? '');
            case 'tel_no':
                return (string) ($row->tel_no ?? '');
            case 'email':
                return (string) ($row->email ?? '');
            case 'educationType':
                return education_type_label($row->educationType ?? null);
            case 'p_school_name':
                return $this->computeMezunExportSchoolName($row);
            case 'class':
                return $this->computeMezunExportClass($row);
            case 'grade_departmant':
                return (string) ($row->grade_departmant ?? '');
            case 'form.status':
                return $form ? (string) ($form->status ?? '') : '';
            case 'form.islemi_yapan':
                return (string) (($form ? ($form->islemi_yapan ?? '') : '') ?: '');
            default:
                return '';
        }
    }

    protected function formatMezunAdayTuruExport($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        $map = [
            '0' => 'Dernek', '1' => 'Vakıf', '2' => 'Boş',
            0 => 'Dernek', 1 => 'Vakıf', 2 => 'Boş',
        ];

        return $map[$value] ?? (string) $value;
    }

    protected function computeMezunExportClass(ActiveAnswer $row): string
    {
        $ortaOgretim = ['ilkokul', 'ortaokul', 'lise'];
        if (in_array($row->educationType, $ortaOgretim, true)) {
            return (string) ($row->class ?? '');
        }

        return (string) ($row->university_class ?? '');
    }

    protected function computeMezunExportSchoolName(ActiveAnswer $row): string
    {
        $ortaOgretim = ['ilkokul', 'ortaokul', 'lise'];
        switch ($row->educationType) {
            case 'ilkokul':
                return (string) ($row->p_school_name ?? '');
            case 'ortaokul':
                return (string) ($row->m_school_name ?? '');
            case 'lise':
                return (string) ($row->h_school_name ?? '');
            default:
                return (string) ($row->current_university ?? '');
        }
    }

    public function getFormIdByMezunId($id){
        $id = intval($id);

        return $this->panelController->graduateScholarDetails($id);
    }
}
