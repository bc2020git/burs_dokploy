<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScholarForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\ActiveAnswer;
use App\Models\Soru;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Yajra\DataTables\Facades\DataTables;
class BursiyerController extends Controller
{
    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
        $this->checkColumns();
    }
    private function checkColumns()
    {
        if (!Schema::hasColumn('active_answers', 'islemi_yapan')) {
            Schema::table('active_answers', function (Blueprint $table) {
                $table->string('islemi_yapan')->nullable()->after('aday_id');
            });
        }
    }
    private function setColumnDetails($columns)
    {
        $columns['doc_fotograf']['filterable'] = true;
        $columns['doc_fotograf']['orderable'] = false;
        $columns['doc_fotograf']['title'] = 'Fotoğraf';
        $columns['doc_fotograf']['order'] = 0;
        $columns['form_id']['title'] = 'Bursiyer No';
        $columns['form_id']['order'] = 1;
        $columns['aday_id']['title'] = 'Başvuru No';
        $columns['aday_id']['order'] = 2;
        $columns['aday_turu']['title'] = 'Bursiyer Tipi';
        $columns['aday_turu']['order'] = 3;
        $columns['burs_tipi_id']['title'] = 'Burs Tipi';
        $columns['burs_tipi_id']['order'] = 4;
        $columns['burs_tipi_id']['type'] = 'text';
        $columns['burs_tipi_id']['filterOptions'] = $this->getFilterOptions('burs_tipi_id', 'text');
        $columns['burs_tipi_id']['filterValue'] = $this->getFilterValue('burs_tipi_id', 'text');
        $columns['burs_tipi_id']['conditions'] = $this->getColumnConditions('text');
        $columns['name']['title'] = 'Ad';
        $columns['name']['order'] = 5;
        $columns['surname']['title'] = 'Soyad';
        $columns['surname']['order'] = 6;
        $columns['tel_no']['title'] = 'Telefon No';
        $columns['tel_no']['order'] = 7;
        $columns['email']['title'] = 'E-posta';
        $columns['email']['order'] = 8;
        $columns['tc_no']['title'] = 'T.C Kimlik No.';
        $columns['tc_no']['order'] = 9;
        $columns['tc_no']['type'] = 'number';
        $columns['tc_no']['filterOptions'] = $this->getFilterOptions('tc_no', 'number');
        $columns['tc_no']['filterValue'] = $this->getFilterValue('tc_no', 'number');
        $columns['tc_no']['conditions'] = $this->getColumnConditions('number');
        $columns['educationType']['title'] = 'Öğrenim Türü';
        $columns['educationType']['order'] = 10;
        $columns['p_school_name']['title'] = 'Okul Adı';
        $columns['p_school_name']['order'] = 11;
        $columns['class']['title'] = 'Sınıf';
        $columns['class']['type'] = 'number';
        $columns['class']['order'] = 12;
        $columns['grade_departmant']['title'] = 'Bölüm';
        $columns['grade_departmant']['order'] = 13;

        $columns = collect($columns)->sortBy('order')->toArray();

        return $columns;
    }
    public function index()
    {
        session(['sidebar' => 5]);
        $this->tekrarFormDuzenle();

        $columns = $this->getColumnDefinitions();

        $query = ActiveAnswer::with(['scholar', 'form', 'bursTipi']);
        $adaylar = $query->get();
        $columns = $this->setColumnDetails($columns);
        $result = [
            'columns' => $columns,
            'scholars' => $adaylar,
            'checkboxColumns' => $this->getCheckboxColumns(),
            // Dinamik sütun checkbox'ları için tüm sorular (Okulun Bulunduğu Şehir tekil olarak birleştirildi)
            'allQuestions' => $this->getColvisQuestions(),
        ];

        return view('panel.scholarship-recipient-list.index', $result);
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
    private function getCheckboxColumns()
    {
        return ['aday_turu', 'burs_tipi_id', 'form.status', 'educationType', 'burs_durumu', 'doc_fotograf'];
    }
    public function getData(Request $request)
    {
        $query = $this->newBaseBursiyerListQuery()->with('bursTipi');

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
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('educationType', function ($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('aday_turu', function ($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('burs_tipi_id', function ($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('burs_durumu', function ($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->filterColumn('form.status', function ($query, $keyword) {
                // Boş - DataTables'ın otomatik search'ini engelle
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="userCheckbox" class="form-check-input" value="' . $row->form_id . '">';
            })
            ->editColumn('burs_tipi_id', function ($row) {
                return $row->bursTipi ? $row->bursTipi->burs_tipi : 'Boş';
            })
            ->editColumn('doc_fotograf', function ($row) {
                if ($row->doc_fotograf == null) {
                    $scholar = \App\Models\Scholar::find($row->bursiyer_id);
                    return $scholar ? $scholar->latestPhoto() : null;
                }
                return $row->doc_fotograf;
            })
            ->addColumn('burs_baslangic_tarihi', function ($row) {
                return Carbon::parse($row->burs_baslangic_tarihi)->format('d.m.Y');
            })
            ->addColumn('islemi_yapan', function ($row) {
                return $row->form->islemi_yapan;
            })
            ->editColumn('burs_durumu', function ($row) {
                if ($row->burs_durumu == 1 || $row->burs_durumu == 2) {
                    return '<span class="status-box-success">Aktif Bursiyer</span>';
                }
                if ($row->burs_durumu == 4) {
                    return '<span class="status-box-danger">Pasif Bursiyer</span>';
                }
                if ($row->burs_durumu == 3) {
                    return 'mezun';
                }


            })
            ->addColumn('class', function ($row) {
                $ortaOgretim = ['ilkokul', 'ortaokul', 'lise'];
                if (in_array($row->educationType, $ortaOgretim)) {
                    return $row->class;
                }
                if ($row->educationType == 'onlisans') {
                    return $row->oKN3UeDifPTo;
                }
                return $row->university_class;
            })
            ->addColumn('p_school_name', function ($row) {
                $ortaOgretim = ['ilkokul', 'ortaokul', 'lise'];
                switch ($row->educationType) {
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
            ->addColumn('action', function ($row) {
                $url = route('panel-aktif-bursiyer-incele', ['id' => $row->form_id]);
                $smsUrl = "{{ route('send-sms', ['id' => $row->id]) }}";
                $mailUrl = "{{ route('getScholarMailForm', ['eposta' => $row->email]) }}";
                $btn = '<button class="btn btn-sm me-1 send-sms" onclick="sendSmsByButon(this)" data-id="' . $row->id . '" data-phone="' . $row->tel_no . '" data-name="' . $row->name . '" data-surname="' . $row->surname . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#FFA800"/>
                            </svg>
                        </button>
                        <button class="btn btn-sm me-1 send-mail" onclick="sendMailByButton(this)" data-id="' . $row->id . '" data-name="' . $row->name . '" data-surname="' . $row->surname . '" data-email="' . $row->email . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#8353E2"/>
                            </svg>
                        </button>
                        <a href="' . $url . '" class="btn btn-sm edit-member">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                            </svg>
                        </a>';

                return $btn;
            })

            ->filter(function ($query) use ($request) {
                $this->applyBursiyerListDataFilters($query, $request);
            }, true)
            ->order(function ($query) use ($request) {
                if ($request->has('order')) {
                    $order = json_decode($request->order, true);
                    if ($order && isset($order['column'])) {
                        $columnName = $order['column'];
                        if ($columnName == 'aday_id') {
                            $columnName = 'scholar.aday_id';
                        }
                        if ($columnName == 'p_school_name') {
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
                            $query->orderBy($columnName, $order['dir']);
                        }
                    }
                } else {
                    $query->orderBy('id', 'desc');
                }
            })
            ->rawColumns(['checkbox', 'action', 'class', 'university_class', 'p_school_name', 'school_name', 'grade_departmant', 'burs_durumu', 'burs_baslangic_tarihi', 'email', 'tel_no']);

        // Dinamik sütunlar için otomatik aramayı kapat
        foreach ($validDynamicColumns as $column) {
            $datatables->filterColumn($column, function ($query, $keyword) {});
        }

        return $datatables->make(true);
    }

    /**
     * Aktif bursiyer listesi için ortak taban sorgusu (getData ve Excel export).
     */
    protected function newBaseBursiyerListQuery()
    {
        $query = ActiveAnswer::query();

        $query->join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
            ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id');

        $query->whereIn('scholar_forms.id', function ($q) {
            $q->select(DB::raw('MAX(id)'))
                ->from('scholar_forms')
                ->whereNotNull('scholar_id')
                ->groupBy('scholar_id');
        });

        $query->whereNotNull('scholars.id');

        $query->select([
            'active_answers.*',
            'scholars.id as bursiyer_id',
            'scholars.status as burs_durumu',
            'scholar_forms.scholar_id as scholar_id',
            'scholar_forms.created_at as form_created_at',
            'scholar_forms.updated_at as form_updated_at',
            'scholars.aday_id as aday_id',
            'scholars.created_at as burs_baslangic_tarihi',
        ]);

        return $query;
    }

    /**
     * Filtreleri DataTables (string JSON) veya dizi olarak güvenle okur.
     */
    protected function getBursiyerListFiltersFromRequest(Request $request): array
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

    /**
     * DataTables ve Excel export ile aynı filtre + global arama mantığı.
     */
    protected function applyBursiyerListDataFilters($query, Request $request): void
    {
        $query->where('scholar_forms.status', '!=', '2');

        $filters = $this->getBursiyerListFiltersFromRequest($request);
        $hasFilters = !empty($filters);

        $hasBursDurumuFilter = $hasFilters && isset($filters['burs_durumu'])
            && !empty($filters['burs_durumu']['value']);

        if (!$hasBursDurumuFilter) {
            $query->where(function ($q) {
                $q->where('scholars.status', '1')
                    ->orWhere('scholars.status', '2');
            });
        }

        if ($hasFilters) {
            foreach ($filters as $column => $filter) {
                $this->applyColumnFilter($query, $column, $filter);
            }
        }

        $searchValue = $this->getBursiyerListGlobalSearchValue($request);
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
                    ->orWhereHas('bursTipi', function ($subQ) use ($searchValue) {
                        $subQ->where('burs_tipi', 'like', "%{$searchValue}%");
                    });
            });
        }
    }

    protected function getBursiyerListGlobalSearchValue(Request $request): ?string
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

    /**
     * form_id listesini üretir. get() ile sadece scholar_forms.id seçildiğinde Eloquent
     * active_answers.id (PK) olmadan model yükleyemediği için boş sonuç dönebiliyordu;
     * bu yüzden doğrudan sorgu üzerinde pluck kullanılır.
     */
    protected function extractBursiyerExportFormIds($query): array
    {
        return $query->clone()
            ->select('scholar_forms.id')
            ->orderBy('active_answers.id', 'desc')
            ->pluck('scholar_forms.id')
            ->unique()
            ->values()
            ->all();
    }

    private function getColumnList()
    {
        $list = [
            'doc_fotograf',
            'form_id',
            'aday_id',
            'form.scholar.id',
            'aday_turu',
            'burs_tipi_id',
            'tc_no',
            'form.scholar.created_at',
            'burs_durumu',
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
            'islemi_yapan',
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
                    'filterType' => $this->getFilterType($column, $type),
                    'filterOptions' => $this->getFilterOptions($column, $type),
                    'filterValue' => $this->getFilterValue($column, $type),
                    'conditions' => $this->getColumnConditions($type),
                    'is_visible' => $isVisible

                ];


                $columns[$column] = $columnDef;
            }
        }
        $columns['burs_durumu'] = [
            'title' => 'Burs Durumu',
            'name' => 'burs_durumu',
            'type' => 'text',
            'filterable' => true,
            'filterType' => $this->getFilterType('burs_durumu', 'text'),
            'filterOptions' => $this->getFilterOptions('burs_durumu', 'text'),
            'filterValue' => $this->getFilterValue('burs_durumu', 'text'),
            'conditions' => $this->getColumnConditions('text'),
            'is_visible' => true,
            'order' => 14
        ];
        $columns['burs_baslangic_tarihi'] = [
            'title' => 'Burs Başlangıç Tarihi',
            'name' => 'burs_baslangic_tarihi',
            'type' => 'date',
            'filterable' => true,
            'filterType' => $this->getFilterType('burs_baslangic_tarihi', 'date'),
            'filterOptions' => $this->getFilterOptions('burs_baslangic_tarihi', 'date'),
            'filterValue' => $this->getFilterValue('burs_baslangic_tarihi', 'date'),
            'conditions' => $this->getColumnConditions('date'),
            'is_visible' => true,
            'order' => 15
        ];
        $columns['islemi_yapan'] = [
            'title' => 'İşlemi Yapan',
            'name' => 'islemi_yapan',
            'type' => 'text',
            'filterable' => true,
            'filterType' => $this->getFilterType('islemi_yapan', 'text'),
            'filterOptions' => $this->getFilterOptions('islemi_yapan', 'text'),
            'filterValue' => $this->getFilterValue('islemi_yapan', 'text'),
            'conditions' => $this->getColumnConditions('text'),
            'is_visible' => true,
            'order' => 16
        ];

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
                    return 'number';
                default:
                    return 'text';
            }
        }

        $selectColumns = ['role_id'];
        if (in_array($column, $selectColumns))
            return 'select';
        if (Str::endsWith($column, '_date'))
            return 'date';
        if (Str::endsWith($column, ['_id', '_count']))
            return 'number';

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

        $columns = $this->setColumnDetails($this->getColumnDefinitions());
        $type = $columns[$column]['type'] ?? 'text';

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
    protected function buildBaseColumns($field)
    {
        $baseColumns = ['id', 'name', 'surname', 'email', 'tel_no', 'tc_no', 'educationType', 'aday_turu', 'mulakat_durumu', 'status', 'burs_tipi_id'];
        if (in_array($field, $baseColumns)) {
            $field = 'active_answers.' . $field;
        }
        return $field;
    }
    protected function buildNumberCondition($query, $field, $value, $condition)
    {
        $field = $this->buildBaseColumns($field);
        if ($field == 'form_id') {
            $field = 'active_answers.form_id';
        }

        if ($condition !== 'in' && !is_array($value)) {
            $value = intval($value);
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
        if ($field == 'burs_baslangic_tarihi') {
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
        if ($field === 'active_answers.class' || $field === 'active_answers.university_class' || $field === 'active_answers.oKN3UeDifPTo') {
            $query->where('active_answers.class', 'like', "%{$value}%")
                ->orWhere('active_answers.university_class', 'like', "%{$value}%")
                ->orWhere('active_answers.oKN3UeDifPTo', 'like', "%{$value}%");
            return;
        }
    }

    protected function buildTextCondition($query, $field, $value, $condition)
    {

        $field = $this->buildBaseColumns($field);
        if ($field == 'class') {
            switch ($condition) {
                case 'empty':
                    $query->whereNull('active_answers.class')
                        ->orWhereNull('active_answers.university_class')
                        ->orWhereNull('active_answers.oKN3UeDifPTo');
                    return;
                case 'not_empty':
                    $query->whereNotNull('active_answers.class')
                        ->orWhereNotNull('active_answers.university_class')
                        ->orWhereNotNull('active_answers.oKN3UeDifPTo');
                    return;
                case 'equals':
                    $query->where('active_answers.class', '=', $value)
                        ->orWhere('active_answers.university_class', '=', $value)
                        ->orWhere('active_answers.oKN3UeDifPTo', '=', $value);
                    return;
                case 'not_equals':
                    $query->where('active_answers.class', '!=', $value)
                        ->orWhere('active_answers.university_class', '!=', $value)
                        ->orWhere('active_answers.oKN3UeDifPTo', '!=', $value);
                    return;
                case 'greater':
                    $query->where('active_answers.class', '>', $value)
                        ->orWhere('active_answers.university_class', '>', $value)
                        ->orWhere('active_answers.oKN3UeDifPTo', '>', $value);
                    return;
                case 'less':
                    $query->where('active_answers.class', '<', $value)
                        ->orWhere('active_answers.university_class', '<', $value)
                        ->orWhere('active_answers.oKN3UeDifPTo', '<', $value);
                    return;
                case 'greater_or_equal':
                    $query->where('active_answers.class', '>=', $value)
                        ->orWhere('active_answers.university_class', '>=', $value)
                        ->orWhere('active_answers.oKN3UeDifPTo', '>=', $value);
                    return;
                case 'less_or_equal':
                    $query->where('active_answers.class', '<=', $value)
                        ->orWhere('active_answers.university_class', '<=', $value)
                        ->orWhere('active_answers.oKN3UeDifPTo', '<=', $value);
                    return;
            }
        }
        if ($field === 'school_name' || $field === 'p_school_name') {
            $this->buildSchoolNameCondition($query, $field, $value, $condition);
            return;
        }
        if ($field === 'active_answers.class' || $field === 'active_answers.university_class' || $field === 'active_answers.oKN3UeDifPTo') {
            $this->buildClassCondition($query, $field, $value, $condition);
            return;
        }
        if ($field === 'burs_durumu') {
            $this->buildBursDurumuCondition($query, $field, $value, $condition);
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
                if (str_starts_with($field, 'doc_')) {
                    $query->where(function ($q) use ($field, $value) {
                        foreach ($value as $item) {
                            if ($item == 'Hayır') {
                                $q->orWhereNull($field);
                            } else {
                                $q->orWhereNotNull($field);
                            }
                        }
                    });
                } else if (is_array($value)) {
                    $query->where(function ($q) use ($field, $value) {
                        $q->whereIn($field, $value);
                        foreach ($value as $item) {
                            if ($item == 'null') {
                                $q->orWhereNull($field);
                            }
                        }
                    });
                }
                break;
            case 'not_ends_with':
                $query->where($field, 'not like', "%{$value}");
                break;
            case 'empty':
                $query->where(function ($q) use ($field) {
                    $q->whereNull($field)->orWhere($field, '');
                });
                break;
            case 'not_empty':
                $query->where(function ($q) use ($field) {
                    $q->whereNotNull($field)->where($field, '!=', '');
                });
                break;
        }
    }

    protected function buildBursDurumuCondition($query, $field, $value, $condition)
    {
        $query->where(function ($q) use ($value) {
            $first = true;
            foreach ($value as $item) {
                if ($item == "1" || $item == 1) {
                    // 1 seçildiğinde hem 1 hem de 2 durumunu getir
                    if ($first) {
                        $q->where(function ($subQ) {
                            $subQ->where('scholars.status', '1')
                                ->orWhere('scholars.status', '2');
                        });
                        $first = false;
                    } else {
                        $q->orWhere(function ($subQ) {
                            $subQ->where('scholars.status', '1')
                                ->orWhere('scholars.status', '2');
                        });
                    }
                } else {
                    // Diğer durumlar için sadece o durumu getir
                    if ($first) {
                        $q->where('scholars.status', $item);
                        $first = false;
                    } else {
                        $q->orWhere('scholars.status', $item);
                    }
                }
            }
        });
    }









    // Eski kodlar
    // Yardımcı metodlar
    private function handleDateFilter($query, $values, $hasNull)
    {
        if (!empty($values)) {
            $query->where(function ($q) use ($values) {
                foreach ($values as $value) {
                    $q->orWhereDate('scholars.created_at', '=', $value);
                }
            });
        }
        if ($hasNull) {
            $query->orWhereNull('scholars.created_at');
        }
    }

    private function handleSchoolNameFilter($query, $values, $hasNull)
    {
        if (!empty($values)) {
            $query->where(function ($q) use ($values) {
                foreach ($values as $value) {
                    $q->orWhere('p_school_name', 'like', "%{$value}%")
                        ->orWhere('m_school_name', 'like', "%{$value}%")
                        ->orWhere('h_school_name', 'like', "%{$value}%")
                        ->orWhere('current_university', 'like', "%{$value}%");
                }
            });
        }
    }

    private function handleClassFilter($query, $values, $hasNull)
    {
        if (!empty($values)) {
            $query->where(function ($q) use ($values) {
                foreach ($values as $value) {
                    $q->orWhere('class', 'like', "%{$value}%")
                        ->orWhere('university_class', 'like', "%{$value}%")
                        ->orWhere('oKN3UeDifPTo', 'like', "%{$value}%");
                }
            });
        }
        if ($hasNull) {
            $query->orWhereNull('class')
                ->orWhereNull('university_class')
                ->orWhereNull('oKN3UeDifPTo');
        }
    }

    private function applyRelationFilter($query, $table, $field, $values, $hasNull, $condition)
    {
        if (!empty($values)) {
            $query->where(function ($q) use ($table, $field, $values, $condition) {
                foreach ($values as $value) {
                    switch ($condition) {
                        case 'equals':
                            $q->orWhere("$table.$field", $value);
                            break;
                        case 'not_equals':
                            $q->orWhere("$table.$field", '!=', $value);
                            break;
                        case 'contains':
                            $q->orWhere("$table.$field", 'like', "%{$value}%");
                            break;
                        case 'starts':
                            $q->orWhere("$table.$field", 'like', "{$value}%");
                            break;
                        case 'not_starts':
                            $q->orWhere("$table.$field", 'not like', "{$value}%");
                            break;
                        case 'ends':
                            $q->orWhere("$table.$field", 'like', "%{$value}");
                            break;
                        case 'not_ends':
                            $q->orWhere("$table.$field", 'not like', "%{$value}");
                            break;
                        case 'not_contains':
                            $q->orWhere("$table.$field", 'not like', "%{$value}%");
                            break;
                        case 'empty':
                            $q->orWhereNull("$table.$field");
                            break;
                        case 'not_empty':
                            $q->orWhereNotNull("$table.$field");
                            break;
                        case 'greater':
                            $q->orWhere("$table.$field", '>', $value);
                            break;
                        case 'greater_equals':
                            $q->orWhere("$table.$field", '>=', $value);
                            break;
                        case 'less':
                            $q->orWhere("$table.$field", '<', $value);
                            break;
                        case 'less_equals':
                            $q->orWhere("$table.$field", '<=', $value);
                            break;
                        default:
                            $q->orWhere("$table.$field", $value);
                    }
                }
            });
        }
        if ($hasNull) {
            $query->orWhereNull("$table.$field");
        }
    }

    private function applyMainTableFilter($query, $field, $values, $hasNull, $condition)
    {
        if (!empty($values)) {
            $query->where(function ($q) use ($field, $values, $condition) {
                foreach ($values as $value) {
                    switch ($condition) {
                        case 'equals':
                            $q->orWhere("active_answers.$field", $value);
                            break;
                        case 'not_equals':
                            $q->orWhere("active_answers.$field", '!=', $value);
                            break;
                        case 'contains':
                            $q->orWhere("active_answers.$field", 'like', "%{$value}%");
                            break;
                        case 'not_contains':
                            $q->orWhere("active_answers.$field", 'not like', "%{$value}%");
                            break;
                        case 'starts':
                            $q->orWhere("active_answers.$field", 'like', "{$value}%");
                            break;
                        case 'ends':
                            $q->orWhere("active_answers.$field", 'like', "%{$value}");
                            break;
                        case 'not_starts':
                            $q->orWhere("active_answers.$field", 'not like', "{$value}%");
                            break;
                        case 'not_ends':
                            $q->orWhere("active_answers.$field", 'not like', "%{$value}");
                            break;
                        case 'empty':
                            $q->orWhereNull("active_answers.$field");
                            break;
                        case 'not_empty':
                            $q->orWhereNotNull("active_answers.$field");
                            break;
                        case 'greater':
                            $q->orWhere("active_answers.$field", '>', $value);
                            break;
                        case 'greater_equals':
                            $q->orWhere("active_answers.$field", '>=', $value);
                            break;
                        case 'less':
                            $q->orWhere("active_answers.$field", '<', $value);
                            break;
                        case 'less_equals':
                            $q->orWhere("active_answers.$field", '<=', $value);
                            break;
                        default:
                            $q->orWhere("active_answers.$field", $value);
                    }
                }
            });
        }
        if ($hasNull) {
            $query->orWhereNull("active_answers.$field");
        }
    }


    private function getFilterOptionsByType($columnType)
    {
        switch ($columnType) {
            case 'integer':
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
    private function getFilterType($column, $columnType)
    {
        switch ($column) {
            case 'tc_no':
            case 'tel_no':
                $type = 'number';
                break;
            case 'burs_tipi_id':
                $type = 'select';
                break;
            default:
                $type = $columnType;
        }

        switch ($columnType) {
            case 'integer':
            case 'int':
            case 'bigint':
            case 'decimal':
                $type = 'number';
                break;
            case 'date':
            case 'datetime':
                $type = 'date';
            case 'boolean':
                $type = 'boolean';
                break;
            default:
                $type = 'text';
        }
        return $type;
    }
    private function getFilterOptions($column, $type)
    {
        $options = $this->filterController->returnFilterOptions();

        if ($column === 'doc_fotograf') {
            return ['Profil Var', 'Profil Yok', 'Uyumsuz'];
        }

        // Özel durumlar için
        if ($column === 'educationType') {
            $values = ['İlkokul', 'Ortaokul', 'Lise', 'Ön lisans', 'Lisans', 'Yüksek Lisans', 'Doktora'];
            return $values;
        }


        if ($column === 'aday_turu') {
            $values = ['Dernek', 'Vakıf', 'Boş'];
            return $values;
        }
        if ($column === 'burs_durumu') {
            $values = ['Aktif Bursiyer', 'Pasif Bursiyer'];
            return $values;
        }
        if ($column === 'burs_tipi_id') {
            $values = \App\Models\TanimBursTipi::pluck('burs_tipi')->toArray();
            $values[] = 'Boş';
            return $values;
        }


        return $options[$this->getFilterType($column, $type)] ?? $options['text'];
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
            $values = ['Dernek', 'Vakıf', 'null'];
            return $values;
        }
        if ($column === 'burs_durumu') {
            $values = [1, 4];
            return $values;
        }
        if ($column === 'burs_tipi_id') {
            $values = \App\Models\TanimBursTipi::pluck('id')->toArray();
            $values[] = 'null';
            return $values;
        }
        return null;
    }

    public function startBursiyerListExport(Request $request)
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

        if (!empty($userIds)) {
            $formIds = array_values(array_unique(array_map('intval', $userIds)));
        } else {
            $query = $this->newBaseBursiyerListQuery();
            $this->applyBursiyerListDataFilters($query, $request);
            $formIds = $this->extractBursiyerExportFormIds($query);
        }

        $exportId = uniqid('export_bursiyer_', true);
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

    public function processBursiyerListExportChunk(Request $request)
    {
        $exportId = $request->input('exportId');
        $index = (int) $request->input('index');
        $batchSize = (int) $request->input('batchSize', 50);

        $meta = Cache::get($exportId);
        if (!$meta || !isset($meta['formIds'])) {
            return response()->json(['error' => 'Geçersiz export ID'], 400);
        }

        $formIds = $meta['formIds'];
        $visibleColumns = $meta['visibleColumns'] ?? [];
        $columnKeys = $this->resolveBursiyerExportColumnKeys($visibleColumns);

        $offset = $index * $batchSize;
        $chunkFormIds = array_slice($formIds, $offset, $batchSize);

        $rows = [];
        if (!empty($chunkFormIds)) {
            $models = ActiveAnswer::with(['form.scholar'])
                ->whereIn('form_id', $chunkFormIds)
                ->get();

            foreach ($chunkFormIds as $fid) {
                $target = (int) $fid;
                $row = $models->first(function ($m) use ($target) {
                    return (int) $m->form_id === $target;
                });
                if (!$row) {
                    continue;
                }
                $rows[] = $this->buildBursiyerExportRowArray($row, $columnKeys);
            }
        }

        $tempDir = storage_path('app/public/temp/' . $exportId);
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0777, true);
        }

        File::put($tempDir . '/chunk_' . $index . '.json', json_encode($rows));

        return response()->json(['success' => true]);
    }

    public function finalizeBursiyerListExport(Request $request)
    {
        $exportId = $request->input('exportId');
        $totalChunks = (int) $request->input('totalChunks');

        $meta = Cache::get($exportId);
        if (!$meta) {
            return response()->json(['error' => 'Geçersiz export ID'], 400);
        }

        $visibleColumns = $meta['visibleColumns'] ?? [];
        $columnKeys = $this->resolveBursiyerExportColumnKeys($visibleColumns);
        $titleMap = $this->getBursiyerExportColumnTitleMap();

        $headers = [];
        foreach ($columnKeys as $key) {
            $headers[] = $titleMap[$key] ?? $key;
        }

        $tempDir = storage_path('app/public/temp/' . $exportId);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($headers as $i => $header) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
            $sheet->setCellValue($col . '1', $header);
        }

        $rowNum = 2;
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkFile = $tempDir . '/chunk_' . $i . '.json';
            if (!File::exists($chunkFile)) {
                continue;
            }
            $chunkData = json_decode(File::get($chunkFile), true);
            if (!is_array($chunkData)) {
                continue;
            }
            foreach ($chunkData as $assocRow) {
                if (!is_array($assocRow)) {
                    continue;
                }
                $colIdx = 1;
                foreach ($columnKeys as $key) {
                    $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
                    $val = $assocRow[$key] ?? '';
                    $sheet->setCellValue($col . $rowNum, $val);
                    $colIdx++;
                }
                $rowNum++;
            }
        }

        File::deleteDirectory($tempDir);
        Cache::forget($exportId);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Aktif_Bursiyerler_' . time() . '.xlsx';
        $directoryPath = storage_path('app/public/temp');
        $filePath = $directoryPath . '/' . $fileName;

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0777, true);
        }

        $writer->save($filePath);

        return response()->json([
            'success' => true,
            'fileName' => $fileName,
            'downloadUrl' => route('bursiyer.export.download', ['fileName' => $fileName]),
        ]);
    }

    public function downloadBursiyerListExport($fileName)
    {
        $filePath = storage_path('app/public/temp/' . $fileName);
        if (File::exists($filePath)) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        return abort(404);
    }

    protected function getBursiyerExportableColumnKeys(): array
    {
        return [
            'doc_fotograf',
            'form_id',
            'aday_id',
            'form.scholar.id',
            'aday_turu',
            'burs_tipi_id',
            'tc_no',
            'form.scholar.created_at',
            'burs_durumu',
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
            'islemi_yapan',
            'burs_baslangic_tarihi',
        ];
    }

    protected function resolveBursiyerExportColumnKeys(array $visibleColumns): array
    {
        $allowed = $this->getBursiyerExportableColumnKeys();
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

    protected function getBursiyerExportColumnTitleMap(): array
    {
        $cols = $this->setColumnDetails($this->getColumnDefinitions());
        $overrides = [
            'form.scholar.id' => 'Scholar ID',
            'form.scholar.created_at' => 'Form Tarihi',
            'form.status' => 'Form Durumu',
            'form.islemi_yapan' => 'İşlemi Yapan (Kayıt)',
        ];
        $map = [];
        foreach ($this->getBursiyerExportableColumnKeys() as $key) {
            $map[$key] = $overrides[$key]
                ?? ($cols[$key]['title'] ?? $key);
        }

        return $map;
    }

    protected function buildBursiyerExportRowArray(ActiveAnswer $row, array $columnKeys): array
    {
        $assoc = [];
        foreach ($columnKeys as $key) {
            $assoc[$key] = $this->formatBursiyerExportCell($row, $key);
        }

        return $assoc;
    }

    protected function formatBursiyerExportCell(ActiveAnswer $row, string $col): string
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
                return $this->formatAdayTuruExport($row->aday_turu ?? null);
            case 'burs_tipi_id':
                return $row->bursTipi ? (string) $row->bursTipi->burs_tipi : 'Boş';
            case 'tc_no':
                return (string) ($row->tc_no ?? '');
            case 'form.scholar.created_at':
                if ($form && $form->created_at) {
                    return Carbon::parse($form->created_at)->format('d.m.Y H:i');
                }

                return '';
            case 'burs_durumu':
                return $this->formatBursDurumuExport($scholar->status ?? null);
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
                return $this->computeBursiyerExportSchoolName($row);
            case 'class':
                return $this->computeBursiyerExportClass($row);
            case 'grade_departmant':
                return (string) ($row->grade_departmant ?? '');
            case 'form.status':
                return $form ? (string) ($form->status ?? '') : '';
            case 'form.islemi_yapan':
            case 'islemi_yapan':
                return (string) (($form ? ($form->islemi_yapan ?? '') : '') ?: '');
            case 'burs_baslangic_tarihi':
                if ($scholar && $scholar->created_at) {
                    return Carbon::parse($scholar->created_at)->format('d.m.Y');
                }

                return '';
            default:
                return '';
        }
    }

    protected function formatAdayTuruExport($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        $map = [
            '0' => 'Dernek',
            '1' => 'Vakıf',
            '2' => 'Boş',
            0 => 'Dernek',
            1 => 'Vakıf',
            2 => 'Boş',
        ];

        return $map[$value] ?? (string) $value;
    }

    protected function formatBursDurumuExport($status): string
    {
        if ($status === null || $status === '') {
            return '';
        }
        $s = (int) $status;
        if ($s === 1 || $s === 2) {
            return 'Aktif Bursiyer';
        }
        if ($s === 4) {
            return 'Pasif Bursiyer';
        }
        if ($s === 3) {
            return 'mezun';
        }

        return (string) $status;
    }

    protected function computeBursiyerExportClass(ActiveAnswer $row): string
    {
        $ortaOgretim = ['ilkokul', 'ortaokul', 'lise'];
        if (in_array($row->educationType, $ortaOgretim, true)) {
            return (string) ($row->class ?? '');
        }
        if ($row->educationType === 'onlisans') {
            return (string) ($row->oKN3UeDifPTo ?? '');
        }

        return (string) ($row->university_class ?? '');
    }

    protected function computeBursiyerExportSchoolName(ActiveAnswer $row): string
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

    public function tekrarFormDuzenle()
    {
        try {
            // Tekrarlı kayıtları grupla ve say
            $duplicates = ScholarForm::where('status', 3)
                ->select('period_id', 'scholar_id', DB::raw('COUNT(*) as count'))
                ->groupBy('period_id', 'scholar_id')
                ->having('count', '>', 1)
                ->get();

            $silinen = 0;

            // Her tekrarlı grup için
            foreach ($duplicates as $duplicate) {
                // Aynı period_id ve scholar_id'ye sahip kayıtları created_at'e göre sırala
                $records = ScholarForm::where('period_id', $duplicate->period_id)
                    ->where('scholar_id', $duplicate->scholar_id)
                    ->where('status', 3)
                    ->orderBy('created_at', 'asc')
                    ->get();

                // İlk kaydı (en eski) sil, diğerlerini tut
                $records->first()->delete();
                $silinen++;
            }

            return response()->json([
                'status' => 'success',
                'message' => "Toplam $silinen adet tekrarlı kayıt temizlendi.",
                'deleted_count' => $silinen
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tekrarlı kayıtlar temizlenirken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
    public function bursiyertarihduzenle()
    {
        $activeAnswers = ActiveAnswer::all();
        foreach ($activeAnswers as $activeAnswer) {
            $newDate = $this->formatDate($activeAnswer->b_dob);
            $activeAnswer->b_dob = $newDate;
            $activeAnswer->save();
        }
    }
    private function formatDate($date)
    {
        if (is_numeric($date) && strlen((string) $date) >= 5 && strlen((string) $date) <= 6) {
            try {

                $baseDate = new \DateTime('1899-12-31'); // Excel başlangıç tarihi
                $days = (int) $date;

                // 60'dan büyük değerler için 1 gün çıkar (Excel'in 1900 şubat hatası)
                if ($days > 60) {
                    $days -= 1;
                }

                $interval = new \DateInterval("P{$days}D");
                $baseDate->add($interval);

                // GG-AA-YYYY formatında döndür
                return $baseDate->format('d-m-Y');
            } catch (\Exception $e) {
                \Log::error('Tarih dönüşüm hatası: ' . $e->getMessage());
                return $date; // Dönüşüm başarısız olursa orijinal değeri döndür
            }
        }
    }
}
