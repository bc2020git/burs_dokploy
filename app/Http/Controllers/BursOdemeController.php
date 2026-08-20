<?php

namespace App\Http\Controllers;

use App\Models\ActiveAnswer;
use App\Models\BursOdemeBilgi;
use App\Models\ScholarForm;
use App\Models\Period;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Bursveren;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SmsController;
use App\Models\NewInterview;
use App\Models\InterviewGroup;
use App\Models\NewAnswer;
use App\Models\User;
use App\Models\TanimBursTipi;
use App\Models\BursTaksiti;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Schema\Blueprint;
class BursOdemeController extends Controller
{
    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
    }

    /**
     * Burs ödemesi / taksit üretimi için aktif bursiyer adayları.
     *
     * İlişki zinciri (modeller): ActiveAnswer belongsTo Scholar (tc_no), belongsTo ScholarForm (form_id);
     * ScholarForm, scholar_id ile Scholar'a bağlı. Burada hem tc_no hem form_id üzerinden join yapılıp
     * scholar_forms.scholar_id = scholars.id ile formun ilgili bursiyer kaydına ait olduğu doğrulanır.
     *
     * Koşullar: scholars.status = 1 (aktif bursiyer), scholar_forms.status = 3 (onaylı aktif form).
     */
    private function baseActiveBursiyerQueryForOdeme(): Builder
    {
        return ActiveAnswer::query()
            ->join('scholars', 'active_answers.tc_no', '=', 'scholars.tc_no')
            ->join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
            ->where('scholars.status', 1)
            ->where('scholar_forms.status', 3)
            ->whereColumn('scholar_forms.scholar_id', 'scholars.id');
    }

    private function getColumnList()
    {
        $list = [
            'id',
            'tc_kimlik_no',
            'burs_tipi',
            'okul_tipi',
            'ad',
            'soyad',
            'donem',
            'iban',
            'bursveren',
            'burs_ayi',
            'odeme_periyodu',
            'odeme_tutari',
            'odeme_tarihi',
            'ogrenciye_burs_odeme_tarihi',
            'odeme_durumu'
        ];
        return $list;
    }
    private function setColumnDetails($columns)
    {
        $columns['id']['is_visible'] = false;
        $columns['ogrenciye_burs_odeme_tarihi']['title'] = 'Öğrenciye Burs Ödeme Tarihi';
        $columns['odeme_tarihi']['title'] = 'Ödeme Tarihi';
        $columns['odeme_periyodu']['title'] = 'Ödeme Periyodu';
        $columns['odeme_tutari']['title'] = 'Ödeme Tutarı';
        $columns['bursveren']['title'] = 'Bursveren';
        $columns['burs_ayi']['title'] = 'Burs Ayı';
        $columns['donem']['title'] = 'Dönem';
        $columns['odeme_durumu']['title'] = 'Ödeme Durumu';
        $columns['iban']['title'] = 'IBAN';
        $columns['okul_tipi']['title'] = 'Öğrenim Türü';
        $columns['burs_tipi']['title'] = 'Burs Tipi';
        $columns['tc_kimlik_no']['title'] = 'T.C Kimlik No.';
        $columns['ad']['title'] = 'Adı';
        $columns['soyad']['title'] = 'Soyadı';
        $columns['tc_kimlik_no']['type'] = 'number';
        $columns['tc_kimlik_no']['conditions'] = $this->getColumnConditions('number');
        return $columns;
    }
    public function index()
    {
        session(['sidebar' => 6]);
        $checkboxColumns = ['burs_tipi', 'okul_tipi', 'odeme_durumu', 'burs_ayi'];
        $columns = $this->getColumnDefinitions();
        $columns = $this->setColumnDetails($columns);

        $result = [
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns,
            'docColumns' => []

        ];
        return view('panel.scholarship-payment-information', $result);

    }

    public function getData(Request $request)
    {
        $searchColumns = $this->getColumnList();
        $users = BursOdemeBilgi::query();


        $users->select($this->getColumnList());

        return DataTables::of($users)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="userCheckbox" class="form-check-input" value="' . $row->id . '">';
            })
            ->addColumn('action', function ($row) {
                $url = route('burs-odeme-duzenle', ['id' => $row->id]);
                $btn = '
                        <a href="' . $url . '" class="btn btn-sm edit-member">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                            </svg>
                        </a>';

                return $btn;
            })
            ->addColumn('odeme_tarihi', function ($row) {
                return $row->odeme_tarihi ? Carbon::parse($row->odeme_tarihi)->format('d.m.Y') : '';
            })
            ->addColumn('odeme_tutari', function ($row) {
                return $row->odeme_tutari . ' TL';
            })
            ->addColumn('okul_tipi', function ($row) {
                return ucfirst($row->okul_tipi);
            })
            ->addColumn('ogrenciye_burs_odeme_tarihi', function ($row) {
                return $row->ogrenciye_burs_odeme_tarihi ? Carbon::parse($row->ogrenciye_burs_odeme_tarihi)->format('d.m.Y') : '';
            })
            ->addColumn('odeme_durumu', function ($row) {
                switch ($row->odeme_durumu) {
                    case 'Beklemede':
                        return '<span class="badge bg-warning">Beklemede</span>';
                    case 'Odendi':
                        return '<span class="badge bg-success">Ödendi</span>';
                    case 'Ödeme Başarısız':
                        return '<span class="badge bg-danger">Ödeme Başarısız</span>';
                    case 'İptal Edildi':
                        return '<span class="badge bg-danger">İptal Edildi</span>';
                }
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('filters')) {
                    $filters = json_decode($request->filters, true);
                    foreach ($filters as $column => $filter) {
                        $this->applyColumnFilter($query, $column, $filter);
                    }
                }
                if ($request->has('search') && $request->search['value'] != '') {
                    $searchValue = $request->search['value'];
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('burs_odeme_bilgileri.id', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.tc_kimlik_no', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.burs_tipi', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.okul_tipi', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.ad', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.soyad', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.donem', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.iban', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.bursveren', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.burs_ayi', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.odeme_periyodu', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.odeme_tutari', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.odeme_tarihi', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.ogrenciye_burs_odeme_tarihi', 'like', "%{$searchValue}%")
                            ->orWhere('burs_odeme_bilgileri.odeme_durumu', 'like', "%{$searchValue}%");
                    });
                }
            }, true)
            ->order(function ($query) use ($request) {
                if ($request->has('order')) {
                    $order = json_decode($request->order, true);
                    if ($order && isset($order['column'])) {
                        $columnName = $order['column'];

                        // students. prefix'ini kaldır
                        if (str_starts_with($columnName, 'burs_odeme_bilgileri.')) {
                            $columnName = substr($columnName, 21);
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
                }
            })
            ->rawColumns(['checkbox', 'action', 'odeme_durumu', 'odeme_tarihi', 'okul_tipi', 'burs_tipi', 'ogrenciye_burs_odeme_tarihi'])
            ->make(true);
    }
    protected function getColumnDefinitions()
    {
        $acceptedColumns = $this->getColumnList();
        $columns = [];
        // Model sütunlarını al
        // NewAnswer modelinin tüm sütunlarını al
        $allColumns = \Schema::getColumnListing('burs_odeme_bilgileri');

        // visibleColumns'ı allColumns'dan çıkart
        $hiddenColumns = array_diff($allColumns, $acceptedColumns);

        $allColumns = Schema::getColumnListing('burs_odeme_bilgileri');
        $columnDetails = [];
        // Sıralı şekilde sütunları ekleyelim
        foreach ($acceptedColumns as $column) {
            if (in_array($column, $allColumns)) {  // Veritabanında var olan sütunları kontrol et
                $title = $this->getColumnTitle($column);

                $type = Schema::getColumnType('burs_odeme_bilgileri', $column);
                $type = $this->getFilterType($type);
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
                    'filterValue' => $this->getFilterValue($column, $type)

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
        if (in_array($column, $selectColumns))
            return 'select';
        if (Str::endsWith($column, '_date'))
            return 'date';
        if (Str::endsWith($column, ['_id', '_count']))
            return 'number';

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
            case 'odeme_durumu':
                return [
                    '0' => 'Beklemede',
                    '1' => 'Ödendi',
                    '2' => 'Ödeme Başarısız',
                ];
            case 'burs_ayi':
                return [
                    '0' => 'Ocak',
                    '1' => 'Şubat',
                    '2' => 'Mart',
                    '3' => 'Nisan',
                    '4' => 'Mayıs',
                    '5' => 'Haziran',
                    '6' => 'Temmuz',
                    '7' => 'Ağustos',
                    '8' => 'Eylül',
                    '9' => 'Ekim',
                    '10' => 'Kasım',
                    '11' => 'Aralık',
                ];
            case 'burs_tipi':
                return TanimBursTipi::all()->pluck('burs_tipi');
            case 'okul_tipi':
                return [
                    '0' => 'İlkokul',
                    '1' => 'Ortaokul',
                    '2' => 'Lise',
                    '3' => 'Ön Lisans',
                    '4' => 'Lisans',
                    '5' => 'Yüksek Lisans',
                    '6' => 'Doktora',
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
            case 'okul_tipi':
                return [
                    '0' => 'İlkokul',
                    '1' => 'Ortaokul',
                    '2' => 'Lise',
                    '3' => 'Ön Lisans',
                    '4' => 'Lisans',
                    '5' => 'Yüksek Lisans',
                    '6' => 'Doktora',
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

    private function getTableColumns()
    {
        $visibleColumns = [
            'id',
            'tc_kimlik_no',
            'burs_tipi',
            'okul_tipi',
            'ad',
            'soyad',
            'donem',
            'iban',
            'bursveren',
            'burs_ayi',
            'odeme_periyodu',
            'odeme_tutari',
            'odeme_tarihi',
            'ogrenciye_burs_odeme_tarihi',
            'odeme_durumu'

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
                    'filterType' => $this->getFilterType($type),
                    'filterOptions' => $this->getFilterOptions($column, $type),
                    'filterValue' => $this->getFilterValue($column, $type)
                ];
            }
        }

        return $columnDetails;
    }
    protected function applyColumnFilter($query, $column, $filter)
    {
        $value = $filter['value'] ?? '';
        $condition = $filter['condition'] ?? 'contains';

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
                if (is_array($value)) {
                    $query->where(function ($q) use ($field, $value) {
                        foreach ($value as $item) {
                            if (str_starts_with($field, 'doc_')) {
                                if ($item == 'Hayır') {
                                    $q->orWhereNull($field);
                                } else {
                                    $q->orWhereNotNull($field);
                                }
                            } else {
                                if ($item === 'null' || $item === null) {
                                    $q->orWhereNull($field);
                                } else {
                                    $q->orWhere($field, $item);
                                }
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
    public function getColumnTypes()
    {
        Cache::remember('new_answers_column_types', now()->addDay(), function () {
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
        if ($column === 'burs_ayi') {
            $values = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
            return $values;
        }
        if ($column === 'burs_tipi') {
            $values = TanimBursTipi::all()->pluck('burs_tipi');
            return $values;
        }
        if (strpos($column, 'doc_') === 0) {
            $values = ['Hayır', 'Evet'];
            return $values;
        }
        // Özel durumlar için
        if ($column === 'aday_turu') {
            $values = ['Dernek', 'Vakıf', 'Boş'];
            return $values;
        }

        if ($column === 'okul_tipi') {
            $values = ['İlkokul', 'Ortaokul', 'Lise', 'Ön lisans', 'Lisans', 'Yüksek Lisans', 'Doktora'];
            return $values;
        }
        if (str_starts_with($column, 'doc_')) {
            return [
                '0' => 'Hayır',
                '1' => 'Evet'
            ];
        }
        if ($column === 'uye_sistem_durumu') {
            $values = ['Aktif', 'Pasif'];
            return $values;
        }
        if ($column === 'aidat_odeme') {
            $values = ['Başarılı', 'Ödeme Bekleniyor', 'Ödeme Başarısız'];
            return $values;
        }
        if ($column === 'status') {
            $values = ['Devam Ediyor', 'Onay Bekliyor', 'İade Edildi', 'Onaylandı', 'Red Edildi', 'İadeden Döndü'];

            return $values;
        }
        if ($column === 'mulakat_durumu') {
            $values = ['Mülakat Yapılacak', 'Planlandı', 'Olumlu', 'Olumsuz'];
            return $values;
        }

        return $options[$this->getFilterType($type)] ?? $options['text'];
    }
    private function getFilterValue($column, $type)
    {
        if ($column === 'odeme_durumu') {
            $values = ['Beklemede', 'Ödendi', 'Ödeme Başarısız'];
            return $values;
        }
        if ($column === 'burs_tipi') {
            $values = TanimBursTipi::all()->pluck('burs_tipi');
            return $values;
        }
        if (strpos($column, 'doc_') === 0) {
            $values = ['Hayır', 'Evet'];
            return $values;
        }
        if ($column === 'status') {
            $values = ['0', '1', '2', '3', '4', '5'];
            return $values;
        }
        if ($column === 'burs_ayi') {
            $values = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
            return $values;
        }
        if ($column === 'okul_tipi') {
            $values = ['ilkokul', 'ortaokul', 'lise', 'onlisans', 'lisans', 'yukseklisans', 'doktora'];
            return $values;
        }
        if ($column === 'aday_turu') {
            $values = ['Dernek', 'Vakıf', 'null'];
            return $values;
        }
        if ($column === 'mulakat_durumu') {
            $values = ['Mülakat Yapılacak', 'Planlandı', 'Olumlu', 'Olumsuz'];
            return $values;
        }
        return null;
    }















    // Yardımcı metod: Tarih kolonlarını kontrol et
    private function isDateColumn($columnName)
    {
        return in_array($columnName, [
            'created_at',
            'updated_at',
            // Diğer tarih kolonları buraya eklenebilir
        ]);
    }

    // Checkbox kolonlarını tanımla
    private function getCheckboxColumns()
    {
        return [
            // Checkbox olarak filtrelenecek kolonları buraya ekleyin
            'status',
            'payment_type',
            // ... diğer checkbox kolonları
        ];
    }



    public function duzenle($id)
    {
        $bursOdeme = BursOdemeBilgi::findOrFail($id);
        $bursTipleri = TanimBursTipi::all();
        return view('panel.scholarship-payment.edit', compact('bursOdeme', 'bursTipleri'));
    }
    public function guncelle(Request $request, $id)
    {
        $bursOdeme = BursOdemeBilgi::findOrFail($id);

        $data = $request->all();
        $data['ogrenciye_burs_odeme_tarihi'] = Carbon::parse($data['ogrenciye_burs_odeme_tarihi'])->format('Y-m-d');
        $result = $bursOdeme->update($data);
        return response()->json(['success' => true]);
    }
    public function topluSil(Request $request)
    {
        try {
            $idler = $request->input('idler');
            // 'on' değerlerini filtrele
            $idler = array_filter($idler, function ($id) {
                return $id !== 'on';
            });
            // Toplu silme işlemi
            BursOdemeBilgi::whereIn('id', $idler)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kayıtlar başarıyla silindi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Silme işlemi sırasında bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
    public function create()
    {
        // Öğrenim türü → burs tipleri → dönem (burs_taksitleri) zinciri AJAX ile dolar.
        return view('panel.burs-odeme.create');
    }

    /** @return list<string> */
    private static function ogrenimTipiKeys(): array
    {
        return ['ilkokul', 'ortaokul', 'lise', 'onlisans', 'lisans', 'yukseklisans', 'doktora'];
    }

    public function getBursTipleriBySchoolType(Request $request)
    {
        $data = $request->validate([
            'okul_tipi' => ['required', Rule::in(self::ogrenimTipiKeys())],
        ]);

        $bursTipleri = TanimBursTipi::query()
            ->whereIn('ogrenim_tipi', [$data['okul_tipi'], 'tumu'])
            ->orderBy('burs_tipi')
            ->get(['id', 'burs_tipi', 'ogrenim_tipi']);

        return response()->json($bursTipleri);
    }

    public function getBursTaksitleriByBursTipi(Request $request)
    {
        $data = $request->validate([
            'burs_tipi_id' => ['required', 'integer', 'exists:tanim_burs_tipis,id'],
        ]);

        $rows = BursTaksiti::query()
            ->where('burs_tipi_id', $data['burs_tipi_id'])
            ->orderByDesc('donem')
            ->get(['donem', 'burs_tutari', 'taksit_sayisi', 'baslangic_tarihi']);

        $payload = $rows->map(function ($r) {
            return [
                'donem' => $r->donem,
                'donem_label' => $this->donemToText((string) $r->donem),
                'burs_tutari' => $r->burs_tutari,
                'taksit_sayisi' => $r->taksit_sayisi,
                'baslangic_tarihi' => $r->baslangic_tarihi?->format('d.m.Y'),
            ];
        })->values();

        return response()->json($payload);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'okul_tipi' => ['required', Rule::in(self::ogrenimTipiKeys())],
            'burs_tipi_id' => ['required', 'integer', 'exists:tanim_burs_tipis,id'],
            'donem' => ['required', 'string', 'max:64'],
        ]);

        /** @var TanimBursTipi $tanim */
        $tanim = TanimBursTipi::query()->findOrFail($validated['burs_tipi_id']);

        /** @var BursTaksiti|null $taksit */
        $taksit = BursTaksiti::query()
            ->where('burs_tipi_id', $validated['burs_tipi_id'])
            ->where('donem', $validated['donem'])
            ->first();

        if (!$taksit) {
            return back()->withErrors([
                'donem' => 'Seçilen dönem bu burs tipi için tanımlı değil.',
            ])->withInput();
        }

        if (!in_array($tanim->ogrenim_tipi, [$validated['okul_tipi'], 'tumu'], true)) {
            return back()->withErrors([
                'burs_tipi_id' => 'Seçilen burs tipi, seçilen okul tipi ile uyumlu değil.',
            ])->withInput();
        }

        $baslangicTarihi = $taksit->baslangic_tarihi instanceof Carbon
            ? $taksit->baslangic_tarihi
            : $this->parseBaslangicTarihiFlexible((string) $taksit->baslangic_tarihi);

        $scholarsQuery = $this->baseActiveBursiyerQueryForOdeme()
            ->select('active_answers.tc_no', 'active_answers.name', 'active_answers.surname', 'active_answers.iban', 'active_answers.educationType')
            ->where('active_answers.burs_tipi_id', $tanim->id);

        // "Tümü" öğrenim türüne sahip burs tanımı, tüm sınıf düzeylerinde seçilebilir; öğrencinin
        // educationType değeri farklı olsa da (ör. lise) taksit üretimi yapılabilmeli.
        if ($tanim->ogrenim_tipi !== 'tumu') {
            $scholarsQuery->where('active_answers.educationType', $validated['okul_tipi']);
        }

        $scholars = $scholarsQuery
            ->groupBy('active_answers.tc_no', 'active_answers.name', 'active_answers.surname', 'active_answers.iban', 'active_answers.educationType')
            ->get();

        $skipCount = 0;
        $createdCount = 0;
        $donemText = $this->donemToText((string) $taksit->donem);

        foreach ($scholars as $scholar) {
            $iban = $scholar->iban ?: null;

            for ($i = 0; $i < (int) $taksit->taksit_sayisi; $i++) {
                $odemeTarihi = $baslangicTarihi->copy()->addMonthsNoOverflow($i);

                $result = BursOdemeBilgi::create([
                    'tc_kimlik_no' => $scholar->tc_no,
                    'burs_tipi' => $tanim->burs_tipi,
                    'okul_tipi' => $scholar->educationType,
                    'ad' => $scholar->name,
                    'soyad' => $scholar->surname,
                    'donem' => $donemText,
                    'iban' => $iban,
                    'bursveren' => 'SACDD',
                    'burs_ayi' => $this->getTurkishMonth((int) $odemeTarihi->format('n')),
                    'odeme_periyodu' => ($i + 1) . ' Taksit',
                    'odeme_tutari' => $taksit->burs_tutari,
                    'odeme_tarihi' => $odemeTarihi->format('Y-m-d'),
                    'odeme_durumu' => 'Beklemede',
                ]);

                if (!$result) {
                    $skipCount++;
                    continue;
                }
                $createdCount++;
            }
        }

        return redirect()
            ->route('bursodemebilgileri')
            ->with('success', 'Burs taksitleri başarıyla oluşturuldu. Oluşturulan: ' . $createdCount . '. Atlanan: ' . $skipCount . '. Hedef bursiyer: ' . $scholars->count() . '.');
    }

    private function donemToText(string $donemKey): string
    {
        if (str_contains($donemKey, 'Dönemi')) {
            return $donemKey;
        }
        $parts = explode('-', $donemKey);
        $a = $parts[0] ?? $donemKey;
        $b = $parts[1] ?? '';
        return trim($a . ' - ' . $b . ' Dönemi');
    }

    /**
     * Form/tarayıcıdan gelen çeşitli tarih dizgilerini tek bir Carbon gününe çevirir.
     */
    private function parseBaslangicTarihiFlexible(?string $value): ?Carbon
    {
        if ($value === null || trim($value) === '') {
            return null;
        }
        $value = trim($value);

        if (preg_match('/^\d{4}[-\/.]\d{1,2}[-\/.]\d{1,2}/', $value)) {
            try {
                return Carbon::parse($value)->startOfDay();
            } catch (\Throwable $e) {
            }
        }

        $formats = ['d.m.Y', 'd.m.y', 'd-m-Y', 'd-m-y', 'd/m/Y', 'd/m/y', 'Y-m-d', 'Y/m/d'];
        foreach ($formats as $fmt) {
            try {
                return Carbon::createFromFormat($fmt, $value)->startOfDay();
            } catch (\Throwable $e) {
            }
        }
        try {
            return Carbon::parse($value)->startOfDay();
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function getTurkishMonth($month)
    {
        $turkishMonths = [
            1 => 'Ocak',
            2 => 'Şubat',
            3 => 'Mart',
            4 => 'Nisan',
            5 => 'Mayıs',
            6 => 'Haziran',
            7 => 'Temmuz',
            8 => 'Ağustos',
            9 => 'Eylül',
            10 => 'Ekim',
            11 => 'Kasım',
            12 => 'Aralık'
        ];

        return $turkishMonths[$month];
    }

    public function getScholarInfo(Request $request)
    {
        $scholar = ActiveAnswer::where('tc_no', $request->tc)->first();
        return response()->json($scholar);
    }
    public function aktifDonemGetir()
    {
        $donem = Period::where('status', 1)->
            where('type', 0)->first();
        return $donem->title;
    }

    public function updatePaymentInfo(Request $request)
    {
        $request->ogrenciye_burs_odeme_tarihi = Carbon::parse($request->ogrenciye_burs_odeme_tarihi)->format('Y-m-d');
        $request->validate([
            'odeme_ids' => 'required|json',
            'ogrenciye_burs_odeme_tarihi' => 'required|date',
        ]);

        $mailController = new MailController();
        $odemeIds = json_decode($request->odeme_ids, true);

        $updatedRows = BursOdemeBilgi::whereIn('id', $odemeIds)
            ->where('odeme_durumu', '!=', 'Odendi')
            ->get();

        foreach ($updatedRows as $row) {
            // Ödeme bilgilerini güncelle
            $row->update([
                'ogrenciye_burs_odeme_tarihi' => $request->ogrenciye_burs_odeme_tarihi,
                'odeme_durumu' => 'Odendi'
            ]);

            // Scholar modelinden email bilgisini al
            $scholar = \App\Models\Scholar::where('tc_no', $row->tc_kimlik_no)->first();

            if ($scholar && $scholar->email && $request->email_check == 'on') {
                try {
                    // Yeni template sistemi ile mail gönder
                    try {
                        $parameters = [
                            'name' => $scholar->name,
                            'surname' => $scholar->surname,
                            'burs_ayi' => $row->burs_ayi,
                        ];

                        $result = $mailController->sendTemplateEmail(
                            'burs-odemesi-girildi',
                            $scholar->email,
                            'Burs Ödemesi Bilgilendirmesi',
                            $parameters
                        );
                    } catch (\Exception $e) {
                        // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                        \Log::error('Burs ödemesi bilgilendirme mail gönderim hatası: ' . $e->getMessage());
                        $result = false;
                    }
                } catch (\Exception $e) {
                    \Log::error('Burs ödemesi mail gönderimi hatası: ' . $e->getMessage());
                    \Log::error('Hata detayı: ' . $e->getTraceAsString());
                }
            }
            if ($request->sms_check == 'on' && $scholar->tel_no) {
                $this->sendPaymentNotification($scholar, $row);
            }
        }

        return response()->json(['success' => true, 'updatedRows' => $updatedRows]);
    }
    public function getPaymentInfo(Request $request)
    {
        $tcKimlikNo = $request->input('tc_kimlik_no');

        $query = BursOdemeBilgi::query();

        if ($tcKimlikNo) {
            $query->where('tc_kimlik_no', $tcKimlikNo);
        }

        $bursOdemeleri = $query->get();

        return response()->json($bursOdemeleri);
    }

    /**
     * Aktif bursiyer detay sayfasından tek öğrenci için manuel taksit / ödeme satırları oluşturur.
     */
    public function storeManualScholarPayment(Request $request)
    {
        $validated = $request->validate([
            'form_id' => ['required', 'integer', 'exists:scholar_forms,id'],
            'tc_kimlik_no' => ['required', 'string'],
            'burs_tipi_id' => ['required', 'integer', 'exists:tanim_burs_tipis,id'],
            'donem' => ['required', 'string', Rule::in(self::manualDonemKeyList())],
            'taksit_sayisi' => ['required', 'integer', 'min:1', 'max:120'],
            'odeme_tutari' => ['required', 'numeric', 'min:0'],
            'baslangic_tarihi' => ['required', 'string'],
        ]);

        $baslangic = $this->parseBaslangicTarihiFlexible($validated['baslangic_tarihi']);
        if (!$baslangic) {
            return response()->json([
                'message' => 'Başlangıç tarihi okunamadı. GG.AA.YYYY formatında giriniz.',
                'errors' => ['baslangic_tarihi' => ['Başlangıç tarihi geçersiz.']],
            ], 422);
        }

        $active = ActiveAnswer::query()
            ->where('form_id', $validated['form_id'])
            ->where('tc_no', $validated['tc_kimlik_no'])
            ->first();

        if (!$active) {
            return response()->json([
                'message' => 'Bu form ve T.C. kimlik numarası için aktif bursiyer kaydı bulunamadı.',
            ], 422);
        }

        /** @var TanimBursTipi $tanim */
        $tanim = TanimBursTipi::query()->findOrFail($validated['burs_tipi_id']);

        if (!in_array($tanim->ogrenim_tipi, [$active->educationType, 'tumu'], true)) {
            return response()->json([
                'message' => 'Seçilen burs tipi, öğrencinin öğrenim türü ile uyumlu değil.',
            ], 422);
        }

        $donemText = self::manualDonemLabel($validated['donem']);
        $taksit = (int) $validated['taksit_sayisi'];

        DB::transaction(function () use ($active, $tanim, $baslangic, $donemText, $validated, $taksit) {
            for ($i = 0; $i < $taksit; $i++) {
                $odemeTarihi = $baslangic->copy()->addMonthsNoOverflow($i);
                BursOdemeBilgi::create([
                    'tc_kimlik_no' => $active->tc_no,
                    'burs_tipi' => $tanim->burs_tipi,
                    'okul_tipi' => $active->educationType,
                    'ad' => $active->name,
                    'soyad' => $active->surname,
                    'donem' => $donemText,
                    'iban' => $active->iban ?: null,
                    'bursveren' => 'SACDD',
                    'burs_ayi' => $this->getTurkishMonth((int) $odemeTarihi->format('n')),
                    'odeme_periyodu' => ($i + 1) . ' Taksit',
                    'odeme_tutari' => $validated['odeme_tutari'],
                    'odeme_tarihi' => $odemeTarihi->format('Y-m-d'),
                    'odeme_durumu' => 'Beklemede',
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => $taksit . ' adet ödeme kaydı oluşturuldu.',
            'created' => $taksit,
        ]);
    }

    /**
     * Burs tipi tanımı ekranındaki dönem listesi ile aynı aralık: (y-3)…(y+4) akademik yılları.
     *
     * @return list<string> "2024-2025" formatında anahtarlar
     */
    public static function manualDonemKeyList(?int $nowYear = null): array
    {
        $y = $nowYear ?? (int) now()->format('Y');
        $start = $y - 3;
        $end = $y + 4;
        $keys = [];
        for ($i = $start; $i <= $end; $i++) {
            $keys[] = $i . '-' . ($i + 1);
        }

        return $keys;
    }

    /** Örn. "2024 - 2025 Dönemi" */
    public static function manualDonemLabel(string $key): string
    {
        $parts = explode('-', $key);
        $a = $parts[0] ?? $key;
        $b = $parts[1] ?? '';

        return trim($a . ' - ' . $b . ' Dönemi');
    }

    /** @return list<array{value: string, label: string}> */
    public static function manualDonemOptionsForView(): array
    {
        $out = [];
        foreach (self::manualDonemKeyList() as $k) {
            $out[] = [
                'value' => $k,
                'label' => self::manualDonemLabel($k),
            ];
        }

        return $out;
    }

    protected function sendPaymentNotification($scholar, $row)
    {
        $mailController = app(\App\Http\Controllers\MailController::class);
        $smsController = app(\App\Http\Controllers\SmsController::class);

        // Mail bildirimi
        if ($scholar->email) {
            try {
                // Yeni template sistemi ile mail gönder
                try {
                    $parameters = [
                        'name' => $scholar->name,
                        'surname' => $scholar->surname,
                        'burs_ayi' => $row->burs_ayi,
                    ];

                    $mailController->sendTemplateEmail(
                        'burs-odemesi-girildi',
                        $scholar->email,
                        'Burs Ödemesi Bilgilendirmesi',
                        $parameters
                    );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Burs ödemesi bilgilendirme mail gönderim hatası: ' . $e->getMessage());
                }
            } catch (\Exception $e) {
                \Log::error('Burs ödemesi mail gönderimi hatası: ' . $e->getMessage());
            }
        }

        // SMS bildirimi
        if ($scholar->tel_no) {
            $phoneNumber = ltrim($scholar->tel_no, '0');
            try {
                $result = $smsController->sendSmsWithTemplate(
                    $phoneNumber,
                    'smstemplates.payment-notification',
                    [
                        'name' => $scholar->name,
                        'surname' => $scholar->surname,
                        'donem' => $row->donem,
                        'burs_ayi' => $row->burs_ayi,
                        'odeme_tutari' => $row->odeme_tutari,
                        'odeme_tarihi' => $row->ogrenciye_burs_odeme_tarihi
                    ]
                );
            } catch (\Exception $e) {
                \Log::error('Burs ödemesi SMS gönderimi hatası: ' . $e->getMessage());
            }
        }
    }
    public function getStudentsBySchoolType(Request $request)
    {
        $schoolType = $request->school_type;

        $scholars = $this->baseActiveBursiyerQueryForOdeme()
            ->select('active_answers.tc_no', 'active_answers.name', 'active_answers.surname', 'active_answers.iban')
            ->when($schoolType !== 'all', function ($query) use ($schoolType) {
                return $query->where('active_answers.educationType', $schoolType);
            })
            ->groupBy('active_answers.tc_no', 'active_answers.name', 'active_answers.surname', 'active_answers.iban')
            ->get();

        return response()->json($scholars);
    }
}
