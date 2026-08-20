<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewAnswer;
use App\Models\InterviewGroup;
use App\Models\MulakatAta;
use App\Models\NewInterview;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\FilterController;
use App\Models\Sebep;
use App\Models\Soru;
class AdayBursiyerController extends Controller
{
    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
        $this->bankNames = Soru::getBankNames();
        $this->tables = ['new_answers','sorus','renew_answers','active_answers'];
        foreach ($this->tables as $table) {
            if (Schema::hasColumn($table, 'C9l7SUqOxSvZ') && !Schema::hasColumn($table, 'C9l7SUqOxSvZ')) {
                // Rename the column
                \DB::statement('ALTER TABLE '.$table.' CHANGE C9l7SUqOxSvZ C9l7SUqOxSvZ VARCHAR(255)');
            }
        }
    }
    private  function getColumnList(){
        $list = [
            'doc_fotograf',
            'id',
            'email',
            'tc_no',
            'totalPoints',
            'name',
            'surname',
            'tel_no',
            'status',
            'redSebebi',
            'mulakat_durumu',
            'educationType',
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
            'islemi_yapan',
        ];
        return $list;
    }
    private  function   setColumnDetails($columns){
        $columns['id']['title'] = 'Başvuru No.';
        $columns['id']['order'] = 1;
        $columns['doc_fotograf']['title'] = 'Fotoğraf';
        $columns['doc_fotograf']['filterable'] = true;
        $columns['doc_fotograf']['order'] = 0;
        $columns['totalPoints']['title'] = 'Başvuru Puanı';
        $columns['totalPoints']['order'] = 3;
        $columns['name']['title'] = 'Ad';
        $columns['name']['order'] = 5;
        $columns['surname']['title'] = 'Soyad';
        $columns['surname']['order'] = 6;
        $columns['tc_no']['title'] = 'T.C. Kimlik No.';
        $columns['tc_no']['order'] = 7;
        $columns['status']['title'] = 'Başvuru Durumu';
        $columns['status']['order'] = 8;
        $columns['redSebebi']['title'] = 'Ret Sebebi';
        $columns['redSebebi']['order'] = 9;
        $columns['tel_no']['title'] = 'Telefon Numarası';
        $columns['tel_no']['order'] = 10;
        $columns['islemi_yapan']['title'] = 'İşlem Yapan';
        $columns['islemi_yapan']['order'] = 11;
        $columns['educationType']['title'] = 'Öğrenim Türü';
        $columns['educationType']['order'] = 12;
        $columns['mulakat_durumu']['title'] = 'Mülakat Durumu';
        $columns['mulakat_durumu']['order'] = 13;

        $columns['doc_ogrenciBelgesi']['title'] = 'Öğrenci Belgesi';
        $columns['doc_adlisicilkaydi']['title'] = 'Adli Sicil Belgesi';
        $columns['doc_nufuskayitornegi']['title'] = 'Nüfus Belgesi';
        $columns['doc_annegelirbelgesi']['title'] = 'Anne Gelir Belgesi';
        $columns['doc_babagelirbelgesi']['title'] = 'Baba Gelir Belgesi';
        $columns['doc_taahhutname']['title'] = 'Taahhütname';
        $columns['doc_kimlik']['title'] = 'Kimlik';
        $columns['doc_bankahesap']['title'] = 'Banka Hesabı';
        $columns['doc_transkript']['title'] = 'Transkript';
        $columns['doc_ikametgah']['title'] = 'İkametgah';
        $columns['doc_Karne']['title'] = 'Karne';
        $columns['doc_Diger']['title'] = 'Diğer';


        $columns['redSebebi']['title'] = 'Ret Sebebi';
        $columns['redSebebi']['filterOptions'] = $this->getFilterOptions('redSebebi','select');
        $columns['redSebebi']['filterValue'] = $this->getFilterValue('redSebebi','select');

        $columns['email']['is_visible'] = true;
        $columns['email']['title'] = 'E-posta';

        return $columns;
    }
    public function index()
    {
        $sebepler = Sebep::orderBy('text','asc')->get();
        $checkboxColumns =
         [
             'mulakat_durumu',
            'status',
            'educationType',
            'aidat_odeme',
            'doc_fotograf',
            'doc_ogrencibelgesi',
            'doc_adlisicilkaydi',
            'doc_nufuskayitornegi',
            'doc_annegelirbelgesi',
            'doc_babagelirbelgesi',
            'doc_taahhutname',
            'doc_kimlik',
            'doc_bankahesap',
            'doc_transkript',
            'doc_ikametgah',
            'doc_karne',
            'doc_diger'
        ];
        $columns = $this->getColumnDefinitions();
        $allColumns = $this->getColumnList();
        $docColumns = [];

        foreach ($allColumns as $column) {
            if (str_starts_with($column, 'doc_')) {
                $docColumns[] = $column;
            }
        }
        $docColumns = array_merge($docColumns, ['redSebebi']);
        $columns = $this->setColumnDetails($columns);
        $columns = collect($columns)->sortBy('order')->toArray();

        session(['sidebar' => 2]);
        $userId = Auth::id();
        $authuser = User::find($userId);

        $query = NewAnswer::whereNot('status', -1)
            ->with(['interviews' => function($query) {
                $query->latest()->limit(1);
            }]);

        if ($authuser && $authuser->role_id == 6) {
            $adayIds = $this->getAssignedAdayIds($userId);
            $query->whereIn('id', $adayIds);
        }
        $adaylar = $query->get();
        
        // Tüm soruları getir - checkbox için (Okulun Bulunduğu Şehir tekil olarak birleştirildi)
        $allQuestions = $this->getColvisQuestions();
        
        $result = [
            'columns' => $columns,
            'adaylar' => $adaylar,
            'mulakatGruplar' => InterviewGroup::all(),
            'sebepler' => $sebepler,
            'checkboxColumns' => $checkboxColumns,
            'allQuestions' => $allQuestions
        ];
        return view('panel.candidate-scholars.index', $result);
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
    protected function getColumnDefinitions()
    {
        $acceptedColumns = $this->getColumnList();
        $columns = [];
        // Model sütunlarını al
        // NewAnswer modelinin tüm sütunlarını al
        $allColumns = \Schema::getColumnListing('new_answers');

        // visibleColumns'ı allColumns'dan çıkart
        $hiddenColumns = array_diff($allColumns, $acceptedColumns);

        $allColumns = Schema::getColumnListing('new_answers');
        $columnDetails = [];
        // Sıralı şekilde sütunları ekleyelim
        foreach ($acceptedColumns as $column) {
            if (in_array($column, $allColumns)) {  // Veritabanında var olan sütunları kontrol et
                $title = $this->getColumnTitle($column);

                $type = Schema::getColumnType('new_answers', $column);
                $type = $this->getFilterType($column,$type);
            // Görünmez olması gereken sütunları belirleme
            $isVisible = in_array($column, $acceptedColumns);
            $columnDef = [
                'title' => $title,
                'name' => $title,
                'type' => $type,
                'filterable' => true,
                'conditions' => $this->getColumnConditions($type),
                'is_visible' => $isVisible,
                'filterOptions' => $this->getColumnOptions($column),
                'filterValue' => $this->getFilterValue($column, $type),
                'order' => 99

            ];


            $columns[$column] = $columnDef;
            }
        }

        return $columns;
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
                    '4' => 'Reddedildi',
                    '5' => 'İadeden Döndü'
                ];
            case 'mulakat_durumu':
                return [
                        '0' => 'Mülakat Yapılacak',
                        '1' => 'Planlandı',
                        '2' => 'Olumlu',
                        '3' => 'Olumsuz',
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
    public function getData(Request $request)
    {
        $userId = Auth::id();
        $authuser = User::find($userId);

        $users = NewAnswer::whereNot('status', -1);

        if ($authuser && $authuser->role_id == 6) {
            $adayIds = $this->getAssignedAdayIds($userId);
            $users->whereIn('new_answers.id', $adayIds);
        }

        // Get base columns
        $columns = $this->getColumnList();
        
        // Add dynamic columns if requested
        $validDynamicColumns = [];
        if ($request->has('dynamic_columns') && !empty($request->dynamic_columns)) {
            $dynamicColumns = is_array($request->dynamic_columns) ? $request->dynamic_columns : explode(',', $request->dynamic_columns);
            
            // Check if dynamic columns exist in the database
            $existingColumns = Schema::getColumnListing('new_answers');
            $validDynamicColumns = array_values(array_intersect($dynamicColumns, $existingColumns));
            
            $virtualGroupMap = [
                'school_city' => ['p_school_city', 'm_school_city', 'h_school_city'],
                'school_district' => ['p_school_district', 'm_school_district', 'h_school_district'],
                'school_name' => ['p_school_name', 'm_school_name', 'h_school_name'],
                'school_type' => ['primary_educ_type', 'middle_educ_type', 'high_educ_type'],
            ];

            foreach ($virtualGroupMap as $vKey => $dbCols) {
                if (in_array($vKey, $dynamicColumns)) {
                    $columns = array_merge($columns, $dbCols);
                    if (!in_array($vKey, $validDynamicColumns)) {
                        $validDynamicColumns[] = $vKey;
                    }
                }
            }

            $columns = array_merge($columns, $validDynamicColumns);
        }

        $users->select($columns);

        $datatables = DataTables::of($users)
            // DataTables'ın otomatik column search'ini devre dışı bırak
            ->filterColumn('doc_fotograf', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('educationType', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('mulakat_durumu', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_ogrenciBelgesi', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_adlisicilkaydi', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_nufuskayitornegi', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_annegelirbelgesi', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_babagelirbelgesi', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_taahhutname', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_kimlik', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_bankahesap', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_transkript', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_ikametgah', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_Karne', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('doc_Diger', function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            });
            
        // Add filterColumn for dynamic columns (disable automatic search)
        foreach ($validDynamicColumns as $column) {
            $datatables = $datatables->filterColumn($column, function($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            });
        }

        return $datatables
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="userCheckbox" data-tel="'.$row->tel_no.'" data-name="'.$row->name.'" data-surname="'.$row->surname.'" class="form-check-input user-checkbox checkbox" value="'.$row->id.'">';
            })
            ->addColumn('action', function($row){
                $url =  route('panel-basvuru-incele', ['id' => $row->id]) ;
                $smsUrl = route('send-sms', ['id' => $row->id]);
                $mailUrl = route('getScholarMailForm', ['eposta' => $row->email]);
                $btn = '<button class="btn btn-sm me-1 send-sms" onclick="sendSmsByButon(this)"  data-id="'.$row->id.'" data-phone="'.$row->tel_no.'" data-name="'.$row->name.'" data-surname="'.$row->surname.'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#FFA800"/>
                            </svg>
                        </button>
                        <button class="btn btn-sm me-1 send-mail" onclick="sendMailByButton(this)" data-id="'.$row->id.'" data-name="'.$row->name.'" data-surname="'.$row->surname.'" data-email="'.$row->email.'">
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

            ->filter(function ($query) use ($request) {
                // Column filters
                if ($request->has('filters')) {
                    $filters = json_decode($request->filters, true);
                    foreach ($filters as $column => $filter) {
                        $this->applyColumnFilter($query, $column, $filter);
                    }
                }

                // DataTables native search - genişletilmiş
                if ($request->has('search') && $request->search['value'] != '') {
                    $searchValue = $request->search['value'];
                    \Log::info('Search yapılıyor: ' . $searchValue); // Debug için
                    $query->where(function($query) use ($searchValue) {
                        $query->where('new_answers.name', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.surname', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.tc_no', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.email', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.tel_no', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.id', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.educationType', 'like', "%{$searchValue}%");
                    });
                }
            }, true)
            ->order(function ($query) use ($request) {
                if ($request->has('order')) {
                    $order = json_decode($request->order, true);
                    if ($order && isset($order['column'])) {
                        $columnName = $order['column'];

                        // students. prefix'ini kaldır
                        if (str_starts_with($columnName, 'newanswers.')) {
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
                else{
                    $query->orderBy('id', 'desc');
                }
            })
            ->rawColumns(['checkbox', 'action','status'])
            ->make(true);
    }
    public function applyColumnFilterPublic($query, $column, $filter)
    {
        return $this->applyColumnFilter($query, $column, $filter);
    }

    protected function applyColumnFilter($query, $column, $filter)
    {
        $value = $filter['value'] ?? '';
        $condition = $filter['condition'] ?? 'contains';

        $virtualColumnMap = [
            'school_city' => ['new_answers.p_school_city', 'new_answers.m_school_city', 'new_answers.h_school_city'],
            'school_district' => ['new_answers.p_school_district', 'new_answers.m_school_district', 'new_answers.h_school_district'],
            'school_name' => ['new_answers.p_school_name', 'new_answers.m_school_name', 'new_answers.h_school_name'],
            'school_type' => ['new_answers.primary_educ_type', 'new_answers.middle_educ_type', 'new_answers.high_educ_type'],
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

    protected function buildNumberCondition($query, $field, $value, $condition)
    {
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

    protected function buildTextCondition($query, $field, $value, $condition)
    {
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
                        $allPhotos = \DB::table('new_answers')
                            ->whereNotNull('doc_fotograf')
                            ->where('doc_fotograf', '!=', '')
                            ->select('id', 'doc_fotograf')
                            ->get();
                        
                        $varIds = [];
                        $uyumsuzIds = [];
                        
                        foreach ($allPhotos as $photo) {
                            $path = trim($photo->doc_fotograf);
                            if (empty($path)) {
                                $uyumsuzIds[] = $photo->id;
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
                                $varIds[] = $photo->id;
                            } else {
                                $uyumsuzIds[] = $photo->id;
                            }
                        }
                        
                        $isFirst = true;
                        foreach ($value as $item) {
                            if ($item === 'Profil Yok') {
                                if ($isFirst) {
                                    $q->where(function($sub) {
                                        $sub->whereNull('doc_fotograf')->orWhere('doc_fotograf', '');
                                    });
                                    $isFirst = false;
                                } else {
                                    $q->orWhere(function($sub) {
                                        $sub->whereNull('doc_fotograf')->orWhere('doc_fotograf', '');
                                    });
                                }
                            } elseif ($item === 'Profil Var') {
                                if ($isFirst) {
                                    $q->whereIn('id', $varIds);
                                    $isFirst = false;
                                } else {
                                    $q->orWhereIn('id', $varIds);
                                }
                            } elseif ($item === 'Uyumsuz') {
                                if ($isFirst) {
                                    $q->whereIn('id', $uyumsuzIds);
                                    $isFirst = false;
                                } else {
                                    $q->orWhereIn('id', $uyumsuzIds);
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
    public function getColumnTypes(){
        Cache::remember('new_answers_column_types', now()->addDay(), function() {
            $types = [];
            try {
                $columns = \Schema::getColumnListing('new_answers');
                foreach ($columns as $column) {
                    $types[$column] = \Schema::getColumnType('new_answers', $column);
                }
                \Log::info('Sütun tipleri cache\'lendi', ['types' => $types]);
            } catch (\Exception $e) {
                \Log::error('Sütun tipleri alınırken hata:', ['error' => $e->getMessage()]);
                return [];
            }
            return $types;
        });
    }
    private function getTableColumns()
    {
        $visibleColumns = [
            'mulakat_durumu',
            'doc_fotograf',
            'id',
            'tc_no',
            'totalPoints',
            'name',
            'surname',
            'tel_no',
            'status',
            'redSebebi',
            'educationType',
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

        ];

        // NewAnswer modelinin tüm sütunlarını al
        $allColumns = \Schema::getColumnListing('new_answers');

        // visibleColumns'ı allColumns'dan çıkart
        $hiddenColumns = array_diff($allColumns, $visibleColumns);

        $columns = Schema::getColumnListing('new_answers');
        $columnDetails = [];

        // Sıralı şekilde sütunları ekleyelim
        foreach ($visibleColumns as $column) {
            if (in_array($column, $columns)) {  // Veritabanında var olan sütunları kontrol et
                $type = Schema::getColumnType('new_answers', $column);
                $title = $column;

                $columnDetails[$column] = [
                    'name' => $column,
                    'title' => $title,
                    'type' => $type,
                    'visible' => true,
                    'filterable' => true,
                    'filterType' => $this->getFilterType($column,$type),
                    'filterOptions' => $this->getFilterOptions($column, $type),
                    'filterValue' => $this->getFilterValue($column, $type)
                ];
            }
        }

        return $columnDetails;
    }
    private function getFilterType($column,$columnType)
    {
        switch ($column) {
            case 'tc_no':
            case 'totalPoints':
            case 'tel_no':
                return 'number';
        }
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
        $redSebepler = Sebep::where('type','Red')->orderBy('text','asc')->get();
        if ($column === 'doc_fotograf') {
            return ['Profil Var', 'Profil Yok', 'Uyumsuz'];
        }
        if($column === 'redSebebi'){
            $values = ['Boş',
            ];
            foreach($redSebepler as $sebep){
                $values[] = $sebep->text;
            }
            return $values;
        }
        if (strpos($column, 'doc_') === 0) {
            $values = ['Hayır', 'Evet'];
            return $values;
        }
        // Özel durumlar için
        if ($column === 'educationType') {
            $values= ['İlkokul','Ortaokul','Lise','Ön lisans','Lisans','Yüksek Lisans','Doktora'];
            return $values;
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
            $values= ['Devam Ediyor','Onay Bekliyor','İade Edildi','Onaylandı','Reddedildi','İadeden Döndü'];

            return $values;
        }
        if ($column === 'mulakat_durumu') {
            $values= ['Mülakat Yapılacak','Planlandı','Olumlu','Olumsuz'];
            return $values;
        }

        return $options[$this->getFilterType($column,$type)] ?? $options['text'];
    }
    private function getFilterValue($column, $type)
    {
        if ($column === 'doc_fotograf') {
            return ['Profil Var', 'Profil Yok', 'Uyumsuz'];
        }
        if($column === 'redSebebi'){
            $redSebepler = Sebep::where('type','Red')->orderBy('text','asc')->get();

            $values = ['null',
            ];
            foreach($redSebepler as $sebep){
                $values[] = $sebep->text;
            }
            return $values;
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
        if ($column === 'mulakat_durumu') {
            $values= ['Mülakat Yapılacak','Planlandı','Olumlu','Olumsuz'];
            return $values;
        }
        return null;
    }
    public function bursiyerAdaySutunEkle()
    {
        Schema::table('scholars', function (Blueprint $table) {
            $table->unsignedBigInteger('aday_id')->nullable()->after('id');
        });
    }

    private function getAssignedAdayIds($userId)
    {
        $allGroups = InterviewGroup::all();
        $groupIds = $allGroups->filter(function ($group) use ($userId) {
            if (!$group->members) {
                return false;
            }
            $members = is_array($group->members) ? $group->members : json_decode($group->members, true);
            if (!is_array($members)) {
                return false;
            }
            return in_array($userId, $members) || in_array((string)$userId, $members) || in_array((int)$userId, $members);
        })->pluck('id')->toArray();

        // 1. MulakatAta tablosundan atanmış aday ID'leri
        $adayIdsFromMulakatAta = MulakatAta::where(function($q) use ($groupIds, $userId) {
            if (!empty($groupIds)) {
                $q->whereIn('user_id', $groupIds);
            }
            $q->orWhere('user_id', $userId);
        })->pluck('aday_id')->toArray();

        // 2. NewInterview tablosundan mülakat oluşturulmuş/atanmış aday TC'leri
        $adayTcsFromInterviews = NewInterview::where(function($q) use ($groupIds, $userId) {
            if (!empty($groupIds)) {
                $q->whereIn('interview_person', $groupIds);
            }
            $q->orWhere('interview_person', $userId);
        })->pluck('tc_no')->filter()->toArray();

        $adayIdsFromInterviews = [];
        if (!empty($adayTcsFromInterviews)) {
            $adayIdsFromInterviews = NewAnswer::whereIn('tc_no', $adayTcsFromInterviews)
                ->pluck('id')
                ->toArray();
        }

        return array_values(array_unique(array_merge($adayIdsFromMulakatAta, $adayIdsFromInterviews)));
    }


}
