<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewInterview;
use App\Models\InterviewGroup;
use App\Models\NewAnswer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\FilterController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Schema\Blueprint;
class MulakatController extends Controller
{
    public $filterController;
    public $mailController;

    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
        $this->mailController = new MailController;
    }

    public function index()
    {
        $checkboxColumns = ['interview_platform', 'interview_result', 'aday_educationType', 'aidat_odeme', 'interview_person', 'aday_katilim_durumu', 'bildirim_gonderildi_mi'];
        session(['sidebar' => 3]);
        $columns = $this->getColumnDefinitions();
        $columns['interview_result']['title'] = 'Mülakat Sonucu';
        $columns['interview_date']['title'] = 'Mülakat Tarihi';
        $columns['interview_score']=[
            'type' => 'number',
            'title' => 'Mülakat Puanı',
            'name' => 'interview_score',
            'filterable' => true,
            'filterType' => $this->getFilterType('number'),
            'filterOptions' => $this->getFilterOptions('interview_score', 'number'),
            'filterValue' => $this->getFilterValue('interview_score', 'number'),
            'conditions' => $this->getColumnConditions('number'),
            'is_visible' => true
        ];
        $columns['interview_person']['title'] = 'Mülakat Yapan Kişi/Grup';

        $columns['interview_platform']['title'] = 'Mülakat Tipi';
        $groups = InterviewGroup::all();
        $userId = Auth::id(); // Giriş yapmış kullanıcının ID'si
        $authuser = User::find($userId);
        $user = Auth::user();
        $permissions = $user->role->permissions->pluck('name')->toArray();
        $interviews = NewInterview::with(['aday'])
        ->whereHas('aday')
        ->when(!in_array('tum-mulakatlar', $permissions), function ($query) use ($userId) {
            // 'tum-mulakatlar' yetkisi yoksa sadece kendi mülakatlarını görsün
            $query->whereExists(function ($subquery) use ($userId) {
                $subquery->from('interview_groups')
                    ->whereRaw('interview_groups.id = new_interviews.interview_person')
                    ->whereRaw('JSON_CONTAINS(interview_groups.members, ?)', ['"' . $userId . '"']);
            });
        })
        ->orderBy('interview_date', 'desc')
        ->get();
        $adaylar = NewAnswer::orderBy('name','asc')->get();
        $result = [
            'interviews' => $interviews,
            'adaylar'   => $adaylar,
            'groups'    => $groups,
            'columns'   => $columns,
            'checkboxColumns' => $checkboxColumns

        ];
        return view('panel.interview.index', $result);
    }

    protected function getColumnDefinitions()
    {
        $model = new NewInterview();
        $columns = [];

        // İlk olarak fotoğraf sütununu ekle
        $columns['aday_doc_fotograf'] = [
            'title' => 'Fotoğraf',
            'name' => 'aday_doc_fotograf',
            'type' => 'text',
            'filterable' => false,
            'filterType' => $this->getFilterType('text'),
            'filterOptions' => $this->getFilterOptions('aday_doc_fotograf', 'text'),
            'filterValue' => $this->getFilterValue('aday_doc_fotograf', 'text'),
            'conditions' => $this->getColumnConditions('text'),
            'is_visible' => true
        ];
        $columns['aday_id'] = [
            'title' => 'Başvuru No',
            'name' => 'aday_id',
            'type' => 'number',
            'filterable' => true,
            'filterType' => $this->getFilterType('number'),
            'filterOptions' => $this->getFilterOptions('aday_id', 'number'),
            'filterValue' => $this->getFilterValue('aday_id', 'number'),
            'conditions' => $this->getColumnConditions('number'),
            'is_visible' => true
        ];
        $columns['id'] = [
            'title' => 'Mülakat No',
            'name' => 'id',
            'type' => 'number',
            'filterable' => true,
            'filterType' => $this->getFilterType('number'),
            'filterOptions' => $this->getFilterOptions('id', 'number'),
            'filterValue' => $this->getFilterValue('id', 'number'),
            'conditions' => $this->getColumnConditions('number'),
            'is_visible' => true
        ];
        $type = 'text';
        $columns['interview_result'] = [
            'title' => 'Mülakat Sonucu',
            'name' => 'interview_result',
            'type' => $type,
            'filterable' => true,
            'filterType' => $this->getFilterType($type),
            'filterOptions' => $this->getFilterOptions('interview_result', $type),
            'filterValue' => $this->getFilterValue('interview_result', $type),
            'conditions' => $this->getColumnConditions($type),
            'is_visible' => true
        ];

        // Aday bilgileri
        $columns['aday_name'] = [
            'title' => 'Adı',
            'name' => 'aday_name',
            'type' => 'text',
            'filterable' => true,
            'filterType' => $this->getFilterType('text'),
            'filterOptions' => $this->getFilterOptions('aday_name', 'text'),
            'filterValue' => $this->getFilterValue('aday_name', 'text'),
            'conditions' => $this->getColumnConditions('text'),
            'is_visible' => true
        ];

        $columns['aday_surname'] = [
            'title' => 'Soyadı',
            'name' => 'aday_surname',
            'type' => 'text',
            'filterable' => true,
            'filterType' => $this->getFilterType('text'),
            'filterOptions' => $this->getFilterOptions('aday_surname', 'text'),
            'filterValue' => $this->getFilterValue('aday_surname', 'text'),
            'conditions' => $this->getColumnConditions('text'),
            'is_visible' => true
        ];




        // Mülakat bilgileri
        foreach (['interview_date', 'interview_platform', 'interview_person', 'interview_score', 'interview_result', 'aday_katilim_durumu', 'bildirim_gonderildi_mi'] as $column) {
            $type = $this->getColumnType($model, $column);
            $title = $this->getColumnTitle($column);
            $isVisible = true;

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

            if ($type === 'select') {
                $columnDef['options'] = $this->getColumnOptions($column);
            }

            $columns[$column] = $columnDef;
        }
        $columns['aday_educationType'] = [
            'title' => 'Öğrenim Türü',
            'name' => 'aday_educationType',
            'type' => 'text',
            'filterable' => true,
            'filterType' => $this->getFilterType('text'),
            'filterOptions' => $this->getFilterOptions('aday_educationType', 'text'),
            'filterValue' => $this->getFilterValue('aday_educationType', 'text'),
            'conditions' => $this->getColumnConditions('text'),
            'is_visible' => true
        ];
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
                case 'float':
                case 'decimal':
                    return 'number';
                default:
                    return 'text';
            }
        }

        // Özel tip kontrolleri
        if ($column === 'status') return 'select';
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
            'Aday Katilim Durumu' => 'Mülakat Katılımı',
            'Bildirim Gonderildi Mi' => 'Bildirim Gönderildi Mi',
        ];

        return $translations[$title] ?? $title;
    }

    protected function getColumnConditions($type)
    {
        $common = [
            'empty' => 'Boş',
            'not_empty' => 'Boş Değil'
        ];

        switch ($type) {
            case 'text':
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
                    'active' => 'Aktif',
                    'inactive' => 'Pasif'
                ];
            default:
                return [];
        }
    }



    public function getData(Request $request)
    {
        $students = NewInterview::query();

        // Yetki kontrolü - kullanıcının yetkilerine göre kısıtlama
        $userId = Auth::id();
        $user = Auth::user();
        $permissions = $user->role->permissions->pluck('name')->toArray();

        // 'tum-mulakatlar' yetkisi yoksa sadece kendi mülakatlarını görsün
        $students->when(!in_array('tum-mulakatlar', $permissions), function ($query) use ($userId) {
            $query->whereExists(function ($subquery) use ($userId) {
                $subquery->from('interview_groups')
                    ->whereRaw('interview_groups.id = new_interviews.interview_person')
                    ->whereRaw('JSON_CONTAINS(interview_groups.members, ?)', ['"' . $userId . '"']);
            });
        });

        // İlişkisel tabloları join et
        $students->join('new_answers', 'new_interviews.tc_no', '=', 'new_answers.tc_no')
                ->leftJoin('interview_groups', 'new_interviews.interview_person', '=', 'interview_groups.id');

        $students->select([
            'new_answers.doc_fotograf as aday_doc_fotograf',
            'new_answers.name as aday_name',
            'new_answers.surname as aday_surname',
            'new_answers.id as aday_id',
            'new_interviews.interview_date',
            'new_interviews.interview_platform',
            'new_interviews.interview_person',
            'interview_groups.name as group_name',
            'new_interviews.interview_address',
            'new_interviews.interview_score',
            'new_interviews.interview_result as interview_result',
            'new_interviews.aday_katilim_durumu',
            'new_interviews.aday_katiliim_mazereti',
            'new_interviews.bildirim_gonderildi_mi',
            'new_interviews.tc_no',
            'new_interviews.id as id',
            'new_interviews.interview_time',
            'new_answers.educationType as aday_educationType',
        ]);

        return DataTables::of($students)
                        ->addColumn('action', function ($row) {
                            $row->interview_date = date('d-m-Y', strtotime($row->interview_date));
                $editUrl = route('panel-mulakat-duzenle', ['id' => $row->id]);
                $editBtn = '<a href="'.$editUrl.'" class="btn me-2" title="Düzenle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"></path>
                            </svg>
                        </a>';

                $concludeBtn = '';
                // Sadece henüz sonuçlanmamış mülakatlar için sonuçlandır butonu göster
                if ($row->interview_result == 'Planlandı' || $row->interview_result == 'Planlama Bekliyor' || is_null($row->interview_result)) {
                    $concludeBtn = '<a href="'.$editUrl.'" class="btn me-2" title="Sonuçlandır">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" fill="#28a745"></path>
                                </svg>
                            </a>';
                }

                return $editBtn . $concludeBtn;
            })
            ->editColumn('interview_date', function ($row) {
                return $row->interview_date . ' ' . $row->interview_time;
            })
            ->editColumn('aday_doc_fotograf', function ($row) {
                if($row->aday_doc_fotograf){
                    return '<img class="rounded-circle" src="'.asset($row->aday_doc_fotograf).'" alt="Fotoğraf" style="width: 50px; height: 50px;">';
                }else{
                    return '<img class="rounded-circle" src="'.asset('assets/images/default-profile.svg').'" alt="Fotoğraf" style="width: 50px; height: 50px;">';
                }
            })
            ->editColumn('aday_educationType', function ($row) {
                switch ($row->aday_educationType) {
                    case 'ilkokul':
                        return 'İlkokul';
                    case 'ortaokul':
                        return 'Ortaokul';
                    case 'lise':
                        return 'Lise';
                    case 'onlisans':
                        return 'Ön Lisans';
                    case 'lisans':
                        return 'Lisans';
                    case 'yukseklisans':
                        return 'Yüksek Lisans';
                    case 'doktora':
                        return 'Doktora';
                }
            })
            ->editColumn('interview_result', function ($row) {
                switch ($row->interview_result) {
                    case 'Planlandı':
                        return '<span class="status-box-warning">Planlandı</span>';
                    case 'Olumlu':
                        return '<span class="status-box-success">Olumlu</span>';
                    case 'Olumsuz':
                        return '<span class="status-box-danger">Olumsuz</span>';
                }
            })
            ->filterColumn('aday_educationType', function($query, $keyword) {
                $query->where('new_answers.educationType', 'like', "%{$keyword}%");
            })
            ->filterColumn('aday_name', function($query, $keyword) {
                $query->where('new_answers.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('aday_surname', function($query, $keyword) {
                $query->where('new_answers.surname', 'like', "%{$keyword}%");
            })
            ->filterColumn('aday_id', function($query, $keyword) {
                $query->where('new_answers.id', 'like', "%{$keyword}%");
            })
            ->filterColumn('interview_result', function($query, $keyword) {
                $query->where('new_interviews.interview_result', 'like', "%{$keyword}%");
            })
            ->filterColumn('interview_date', function($query, $keyword) {
                $query->where('new_interviews.interview_date', 'like', "%{$keyword}%");
            })
            ->filterColumn('aday_katilim_durumu', function($query, $keyword) {
                $query->where('new_interviews.aday_katilim_durumu', 'like', "%{$keyword}%");
            })
            ->filterColumn('bildirim_gonderildi_mi', function($query, $keyword) {
                $query->where('new_interviews.bildirim_gonderildi_mi', 'like', "%{$keyword}%");
            })
            ->filterColumn('interview_platform', function($query, $keyword) {
                $query->where('new_interviews.interview_platform', 'like', "%{$keyword}%");
            })
            ->filterColumn('interview_score', function($query, $keyword) {
                $query->where('new_interviews.interview_score', 'like', "%{$keyword}%");
            })
            ->filterColumn('interview_person', function($query, $keyword) {
                $query->whereExists(function ($subquery) use ($keyword) {
                    $subquery->from('interview_groups')
                        ->whereRaw('interview_groups.id = new_interviews.interview_person')
                        ->where('interview_groups.name', 'like', "%{$keyword}%");
                });
            })
            ->filter(function ($query) use ($request) {
                // Global arama
                if ($request->has('search') && $request->get('search')['value'] != '') {
                    $searchValue = $request->get('search')['value'];
                    $query->where(function($query) use ($searchValue) {
                        $query->where('new_interviews.interview_result', 'like', "%{$searchValue}%")
                            ->orWhere('new_interviews.interview_date', 'like', "%{$searchValue}%")
                            ->orWhere('new_interviews.interview_platform', 'like', "%{$searchValue}%")
                            ->orWhere('new_interviews.interview_score', 'like', "%{$searchValue}%")
                            ->orWhere('new_interviews.bildirim_gonderildi_mi', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.id', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.name', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.surname', 'like', "%{$searchValue}%")
                            ->orWhere('new_answers.educationType', 'like', "%{$searchValue}%")
                            ->orWhere('interview_groups.name', 'like', "%{$searchValue}%");
                    });
                }

                // Kolon filtreleri
                if ($request->has('filters')) {
                    $filters = json_decode($request->filters, true);
                    foreach ($filters as $colKey => $filter) {
                        if ($colKey === 'aday_katilim_durumu') {
                            $column = 'new_interviews.aday_katilim_durumu';
                        } elseif ($colKey === 'bildirim_gonderildi_mi') {
                            $column = 'new_interviews.bildirim_gonderildi_mi';
                        } elseif (substr($colKey, 0, 5) === 'aday_') {
                            $column = str_replace('aday_', 'new_answers.', $colKey);
                        } else {
                            $column = 'new_interviews.' . $colKey;
                        }
                        $this->applyColumnFilter($query, $column, $filter);
                    }
                }

            })

            ->order(function ($query) use ($request) {
                if ($request->has('order')) {
                    $order = json_decode($request->order, true);
                    if ($order && isset($order['column'])) {
                        $columnName = $order['column'];

                        if ($columnName === 'aday_katilim_durumu') {
                            $query->orderBy('new_interviews.aday_katilim_durumu', $order['dir']);
                        } elseif ($columnName === 'bildirim_gonderildi_mi') {
                            $query->orderBy('new_interviews.bildirim_gonderildi_mi', $order['dir']);
                        } else {
                            // students. prefix'ini kaldır
                            if (str_starts_with($columnName, 'new_interviews.')) {
                                $columnName = substr($columnName, 16);
                            }
                            if (str_starts_with($columnName, 'aday_')) {
                                $columnName = str_replace('aday_', 'new_answers.', $columnName);
                            }
                            $query->orderBy($columnName, $order['dir']);
                        }
                    }
                }
                else{
                    $query->orderBy('id', 'desc');
                }
            })
            ->editColumn('interview_person', function ($row) {
                return $row->group_name ?? '';
            })
            ->rawColumns(['action','aday_doc_fotograf', 'interview_result', 'aday_educationType', 'interview_date'])
            ->setRowId('tc_no')
            ->make(true);
    }

    protected function applyColumnFilter($query, $column, $filter)
    {
        $value = $filter['value'] ?? '';
        $condition = $filter['condition'] ?? 'contains';
        $type = $this->getColumnDefinitions()[$column]['type'] ?? 'text';
        // İlişkisel alan kontrolü
        if (str_contains($column, '.')) {


            $this->buildCondition($query, $column, $value, $condition, $type);
            return;
        }

        // Normal alan için filtreleme
        $this->buildCondition($query, $column, $value, $condition, $type);
    }

    protected function buildCondition($query, $field, $value, $condition, $type)
    {
        // İlişkisel alan kontrolü
        if (!str_contains($field, '.')) {
            $field = 'new_interviews.' . $field;
        }
        switch ($type) {
            case 'number':
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
            case 'in':
                if (is_array($value) && count($value) > 0) {
                    $query->where(function ($q) use ($field, $value) {
                        foreach ($value as $item) {
                            if ($item == 'null') {
                                $q->orWhereNull($field);
                            } else {
                                $q->orWhere($field, $item);
                            }
                        }
                    });
                }
                break;
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


        // Özel durumlar için
        if ($column === 'interview_result') {
            $values= ['Planlandı','Olumlu','Olumsuz'];
            return $values;
        }
        if ($column === 'interview_platform') {
            $values= ['Yüz Yüze','Çevrim içi'];
            return $values;
        }

        if ($column === 'aday_educationType') {
            $values= ['İlkokul','Ortaokul','Lise','Ön lisans','Lisans','Yüksek Lisans','Doktora'];
            return $values;
        }
        if ($column === 'aday_katilim_durumu') {
            return [
                'Katılacağım',
                'Başka bir tarihte ve/veya saatte katılmak istiyorum',
                'Katılmayacağım',
            ];
        }
        if ($column === 'bildirim_gonderildi_mi') {
            return ['Evet', 'Hayır'];
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
        if($column === 'interview_person'){
            $values = InterviewGroup::all()->pluck('name');
            return $values;
        }

        return $options[$this->getFilterType($type)] ?? $options['text'];
    }
    private function getFilterValue($column, $type)
    {
        if ($column === 'interview_result') {
            $values= ['Planlandı','Olumlu','Olumsuz'];
            return $values;
        }
        if ($column === 'interview_platform') {
            $values= ['Yüz Yüze','Çevrim içi'];
            return $values;
        }

        if ($column === 'aday_educationType') {
            $values= ['ilkokul','ortaokul','lise','onlisans','lisans','ylisans','doktora'];
            return $values;
        }
        if ($column === 'aday_katilim_durumu') {
            return [
                'Katılacağım',
                'Başka bir tarihte ve/veya saatte katılmak istiyorum',
                'Katılmayacağım',
            ];
        }
        if ($column === 'bildirim_gonderildi_mi') {
            return ['Evet', 'Hayir'];
        }
        if ($column === 'aday_turu') {
            $values= ['Dernek','Vakıf','null'];
            return $values;
        }
        if ($column === 'mulakat_durumu') {
            $values= ['Mülakat Yapılacak','Planlandı','Olumlu','Olumsuz'];
            return $values;
        }
        if($column === 'interview_person'){
            $values = InterviewGroup::all()->pluck('id');
            return $values;
        }
        return null;
    }

    public function notifyInterviewGroups(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:new_interviews,id',
        ]);

        $ids = collect($request->input('ids'))
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $user = Auth::user();
        $userId = Auth::id();
        $permissions = $user && $user->role
            ? $user->role->permissions->pluck('name')->toArray()
            : [];

        $query = NewInterview::with(['aday', 'group'])->whereIn('id', $ids->all());

        if (! in_array('tum-mulakatlar', $permissions, true)) {
            $query->whereExists(function ($subquery) use ($userId) {
                $subquery->from('interview_groups')
                    ->whereRaw('interview_groups.id = new_interviews.interview_person')
                    ->whereRaw('JSON_CONTAINS(interview_groups.members, ?)', ['"' . $userId . '"']);
            });
        }

        $interviews = $query->get();
        $result = [
            'success' => false,
            'message' => '',
            'selected_count' => $ids->count(),
            'sent_count' => 0,
            'failed_count' => 0,
            'skipped_count' => $ids->count() - $interviews->count(),
            'updated_interview_count' => 0,
            'errors' => [],
        ];

        if ($interviews->isEmpty()) {
            $result['message'] = 'Seçilen mülakatlar için gönderilebilir kayıt bulunamadı.';

            return response()->json($result, 404);
        }

        $updatedInterviewIds = [];

        foreach ($interviews->groupBy('interview_person') as $groupId => $groupInterviews) {
            $group = $groupInterviews->first()->group;

            if (! $group) {
                $result['skipped_count'] += $groupInterviews->count();
                $result['errors'][] = "Grup bilgisi bulunamadı. Mülakat ID'leri: ".$groupInterviews->pluck('id')->implode(', ');
                continue;
            }

            $memberIds = $this->normalizeGroupMembers($group->members);
            if (empty($memberIds)) {
                $result['skipped_count'] += $groupInterviews->count();
                $result['errors'][] = "{$group->name} grubunda üye bulunamadı.";
                continue;
            }

            $members = User::whereIn('id', $memberIds)->get()->keyBy('id');
            $interviewTable = $this->buildInterviewNotificationTable($groupInterviews);
            $groupSent = false;

            foreach ($memberIds as $memberId) {
                $member = $members->get((int) $memberId);

                if (! $member || empty($member->email)) {
                    $result['skipped_count']++;
                    $result['errors'][] = "{$group->name} grubunda e-posta adresi olmayan üye atlandı. Kullanıcı ID: {$memberId}";
                    continue;
                }

                try {
                    $sent = $this->mailController->sendTemplateEmail(
                        'mulakat-grubu-bildirimi',
                        $member->email,
                        'Mülakat Listeniz',
                        [
                            'name' => $member->name ?? '',
                            'surname' => $member->surname ?? '',
                            'interview_table' => $interviewTable,
                        ]
                    );

                    if ($sent) {
                        $result['sent_count']++;
                        $groupSent = true;
                    } else {
                        $result['failed_count']++;
                        $result['errors'][] = "{$member->email} adresine mail gönderilemedi.";
                    }
                } catch (\Throwable $e) {
                    $result['failed_count']++;
                    $result['errors'][] = "{$member->email} adresine mail gönderilemedi: ".$e->getMessage();
                    Log::error('Mülakat grubu bildirimi mail gönderim hatası', [
                        'group_id' => $group->id,
                        'user_id' => $member->id,
                        'email' => $member->email,
                        'exception' => $e->getMessage(),
                    ]);
                }
            }

            if ($groupSent) {
                $updatedInterviewIds = array_merge($updatedInterviewIds, $groupInterviews->pluck('id')->all());
            }
        }

        $updatedInterviewIds = array_values(array_unique($updatedInterviewIds));

        if (! empty($updatedInterviewIds)) {
            DB::table('new_interviews')
                ->whereIn('id', $updatedInterviewIds)
                ->update(['bildirim_gonderildi_mi' => 'Evet']);

            $result['updated_interview_count'] = count($updatedInterviewIds);
        }

        $result['success'] = $result['sent_count'] > 0;
        $result['message'] = $result['success']
            ? 'Mülakat grubu bildirimi tamamlandı.'
            : 'Mülakat grubu bildirimi gönderilemedi.';

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    private function normalizeGroupMembers($members): array
    {
        if (is_string($members)) {
            $decoded = json_decode($members, true);
            $members = is_array($decoded) ? $decoded : [];
        }

        if (! is_array($members)) {
            return [];
        }

        return collect($members)
            ->filter(fn ($memberId) => $memberId !== null && $memberId !== '')
            ->map(fn ($memberId) => (int) $memberId)
            ->unique()
            ->values()
            ->all();
    }

    private function buildInterviewNotificationTable($interviews): string
    {
        $rows = $interviews->map(function (NewInterview $interview) {
            $aday = $interview->aday;

            return '<tr>'
                .'<td>'.$this->mailCell($aday?->id).'</td>'
                .'<td>'.$this->mailCell($interview->id).'</td>'
                .'<td>'.$this->mailCell($aday?->name).'</td>'
                .'<td>'.$this->mailCell($aday?->surname).'</td>'
                .'<td>'.$this->mailCell($this->formatInterviewDateTime($interview)).'</td>'
                .'<td>'.$this->mailCell($interview->interview_platform).'</td>'
                .'<td>'.$this->mailCell($interview->interview_address).'</td>'
                .'<td>'.$this->mailCell($interview->aday_katilim_durumu).'</td>'
                .'<td>'.$this->mailCell($this->educationTypeLabel($aday?->educationType)).'</td>'
                .'</tr>';
        })->implode('');

        return '<table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; color: #ffffff; border-color: #ffffff;">'
            .'<thead><tr>'
            .'<th>Başvuru No</th>'
            .'<th>Mülakat No</th>'
            .'<th>Adı</th>'
            .'<th>Soyadı</th>'
            .'<th>Mülakat Tarihi</th>'
            .'<th>Mülakat Tipi</th>'
            .'<th>Mülakat Adresi</th>'
            .'<th>Mülakat Katılımı</th>'
            .'<th>Öğrenim Türü</th>'
            .'</tr></thead>'
            .'<tbody>'.$rows.'</tbody>'
            .'</table>';
    }

    private function mailCell($value): string
    {
        $value = $value === null || $value === '' ? '-' : (string) $value;

        return e($value);
    }

    private function formatInterviewDateTime(NewInterview $interview): string
    {
        $date = $interview->interview_date;

        if (! empty($date)) {
            try {
                $date = Carbon::parse($date)->format('d.m.Y');
            } catch (\Throwable $e) {
                $date = (string) $interview->interview_date;
            }
        }

        return trim(($date ?: '-').' '.($interview->interview_time ?: ''));
    }

    private function educationTypeLabel(?string $educationType): string
    {
        return [
            'ilkokul' => 'İlkokul',
            'ortaokul' => 'Ortaokul',
            'lise' => 'Lise',
            'onlisans' => 'Ön Lisans',
            'lisans' => 'Lisans',
            'yukseklisans' => 'Yüksek Lisans',
            'ylisans' => 'Yüksek Lisans',
            'doktora' => 'Doktora',
        ][$educationType] ?? ($educationType ?: '-');
    }

    public function getAdayByMulakatId($id){
        $mulakat = NewInterview::find($id);
        $tcno = $mulakat->tc_no;
        $aday = NewAnswer::where('tc_no', $tcno)->first();
        $adayId = $aday->id;
        return redirect()->route('panel-basvuru-incele', ['id' => $adayId]);
    }

    public function edit($id)
    {
        $interview = NewInterview::with(['aday' => function($query) {
            $query->with('logs');
        }])->findOrFail($id);
        $groups = InterviewGroup::all();
        $logs = \App\Models\InterviewTimeline::where('interview_id', $interview->id)->orderBy('created_at', 'desc')->get();

        // Atanan grubun üyelerini getir
        $interviewerDetails = [];
        if ($interview->interview_person) {
            $group = InterviewGroup::find($interview->interview_person);
            if ($group && !empty($group->members)) {
                $interviewerDetails = User::whereIn('id', $group->members)->select('id', 'name')->get();
            }
        }

        $result = [
            'data' => $interview,
            'groups' => $groups,
            'logs' => $logs,
            'interviewerDetails' => $interviewerDetails
        ];
        return view('panel.interview.edit', $result);
    }
}
