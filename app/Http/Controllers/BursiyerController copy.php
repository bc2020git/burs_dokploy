<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScholarForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Scholar;
class BursiyerController extends Controller
{
    public function index()
    {
        session(['sidebar' => 5]);


        $columns = $this->getTableColumns();
        $columns['form.infos.name']['title'] = 'Ad';
        $columns['form.infos.surname']['title'] = 'Soyad';
        $columns['form.infos.educationType']['title'] = 'Öğrenim Türü';
        $columns['form.infos.doc_fotograf']['filterable'] = false;
        $columns['form.infos.doc_fotograf']['orderable'] = false;
        $columns['form.infos.doc_fotograf']['title'] = 'Fotoğraf';
        $columns['scholar.aday_id']['title'] = 'Başvuru No';
        $columns['form.infos.tc_no']['title'] = 'T.C Kimlik No..';
        $columns['form.infos.aday_turu']['title'] = 'Bursiyer Tipi';
        $columns['form.infos.tel_no']['visible'] = false;
        $columns['form.infos.email']['visible'] = false;
        $columns['status']['title'] = 'Kayıt Yenileme';
        $columns['form.infos.p_school_name']['title'] = 'Okul Adı';
        $columns['form.infos.class']['title'] = 'Sınıf';
        $columns['form.infos.grade_departmant']['title'] = 'Bölüm';
        $columns['form.islemi_yapan']['title'] = 'İşlem Yapan';
        $columns['scholar.id']['title'] = 'Bursiyer No';
        $columns['scholar.created_at']['title'] = 'Burs Başlangıç';
        $columns['scholar.created_at']['filterType'] = 'date';
        $columns['scholar.created_at']['filterOptions'] = ['=' => 'Eşittir', '>' => 'Sonra', '<' => 'Önce'];

        $query = ScholarForm::with(['documents', 'educinfo', 'scholar', 'infos']);
        $checkboxColumns = ['infos.aday_turu','status'];
        $adaylar = $query->get();
        $result = [
            'columns' => $columns,
            'scholars' => $adaylar,
            'checkboxColumns'  => $checkboxColumns
        ];

        return view('panel.scholarship-recipient-list.index',$result);
    }
    public function getData(Request $request)
    {
        $columns = $this->getTableColumns();

        $query = ScholarForm::with([
            'documents',
            'educinfo',
            'scholar',
            'scholar.form',
            'scholar.form.infos'
        ]);

        if ($request->has('filters')) {
            $filters = $request->filters;
            foreach ($filters as $columnName => $filter) {
                if (!empty($filter['value'])) {
                    $condition = $filter['condition'] ?? '=';
                    $value = $filter['value'];
                    // Okul adı için özel filtreleme
                    if ($columnName === 'school_name' || $columnName === 'form.infos.p_school_name') {

                        $query->where(function($q) use ($value, $condition, $filter) {


                                $q->where(function($subQ) use ($value) {
                                    $subQ->whereHas('scholar.form.infos', function($q) {
                                        $q->where('educationType', 'ilkokul');
                                    })->where('p_school_name', 'like', "%{$value}%");
                                })
                                ->orWhere(function($subQ) use ($value) {
                                    $subQ->whereHas('scholar.form.infos', function($q) {
                                        $q->where('educationType', 'ortaokul');
                                    })->where('m_school_name', 'like', "%{$value}%");
                                })
                                ->orWhere(function($subQ) use ($value) {
                                    $subQ->whereHas('scholar.form.infos', function($q) {
                                        $q->where('educationType', 'lise');
                                    })->where('h_school_name', 'like', "%{$value}%");
                                })
                                ->orWhere(function($subQ) use ($value) {
                                    $subQ->whereHas('scholar.form.infos', function($q) {
                                        $q->whereIn('educationType', ['lisans', 'onlisans', 'yukseklisans', 'doktora']);
                                    })->where('current_university', 'like', "%{$value}%");
                                });

                        });
                        continue; // Diğer filtreleme işlemlerini atla

                    }
                    // Sınıf için özel filtreleme
                    else if ($columnName === 'class') {
                        $query->where(function($q) use ($value) {
                            $q->where(function($subQ) use ($value) {
                                $subQ->whereHas('scholar.form.infos', function($q) {
                                    $q->whereIn('educationType', ['ilkokul', 'ortaokul', 'lise']);
                                })->where('class', 'like', "%{$value}%");
                            })
                            ->orWhere(function($subQ) use ($value) {
                                $subQ->whereHas('scholar.form.infos', function($q) {
                                    $q->whereIn('educationType', ['lisans', 'onlisans', 'yukseklisans', 'doktora']);
                                })->where('university_class', 'like', "%{$value}%");
                            });
                        });
                        continue;
                    }
                    // İlişkili alanlar için filtreleme
                    if (str_contains($columnName, '.')) {
                        $parts = explode('.', $columnName);

                        if ($parts[0] === 'form' && $parts[1] === 'infos') {
                            // form.infos ile başlayan alanlar için
                            $fieldName = $parts[2]; // tc_no, aday_turu vs.

                            $query->whereHas('scholar.form', function($q) use ($fieldName, $value, $condition) {
                                $q->whereHas('infos', function($subQ) use ($fieldName, $value, $condition) {
                                    switch($condition) {
                                        case 'contains':
                                            $subQ->where($fieldName, 'like', "%{$value}%");
                                            break;
                                        case 'starts':
                                            $subQ->where($fieldName, 'like', "{$value}%");
                                            break;
                                        case 'ends':
                                            $subQ->where($fieldName, 'like', "%{$value}");
                                            break;
                                        case 'null':
                                            $subQ->where($fieldName, '=', null);
                                            break;
                                        default:
                                            $subQ->where($fieldName, $condition, $value);
                                    }
                                });
                            });
                        } else if ($parts[0] === 'scholar') {
                            $query->where(function($q) use ($parts, $value, $condition) {
                                switch($condition) {
                                    case 'contains':
                                        $q->where('scholars.' . $parts[1], 'like', "%{$value}%");
                                        break;
                                    case 'starts':
                                        $q->where('scholars.' . $parts[1], 'like', "{$value}%");
                                        break;
                                    case 'ends':
                                        $q->where('scholars.' . $parts[1], 'like', "%{$value}");
                                        break;
                                    case 'null':
                                        $q->where('scholars.' . $parts[1], '=', null);
                                        break;
                                    default:
                                        $q->where('scholars.' . $parts[1], $condition, $value);
                                }
                            });
                        }
                    } else {
                        // Normal sütunlar için filtreleme
                        switch ($condition) {
                            case 'contains':
                                $query->where('scholar_forms.' . $columnName, 'like', "%{$value}%");
                                break;
                            case 'starts':
                                $query->where('scholar_forms.' . $columnName, 'like', "{$value}%");
                                break;
                            case 'ends':
                                $query->where('scholar_forms.' . $columnName, 'like', "%{$value}");
                                break;
                            case 'null':
                                $query->where('scholar_forms.' . $columnName, '=', null);
                                break;
                            default:
                                $query->where('scholar_forms.' . $columnName, $condition, $value);
                        }
                    }
                }
            }
        }

        // Sıralama için özel mantık
        $orderColumn = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $columnName = $columns[array_keys($columns)[$orderColumn]]['name'];

        if (str_contains($columnName, '.')) {
            $relations = explode('.', $columnName);

            // İlişkili tablolara join ekle
            $query->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                  ->leftJoin('active_answers', 'scholar_forms.id', '=', 'active_answers.form_id')
                  ->select('scholar_forms.*')
                  ->distinct(); // Tekrarlanan kayıtları önle

            $lastPart = end($relations);

            switch($relations[0]) {
                case 'form':
                    $query->orderBy('active_answers.' . $lastPart, $orderDir);
                    break;
                case 'scholar':
                    $query->orderBy('scholars.' . $lastPart, $orderDir);
                    break;
                default:
                    $query->orderBy('scholar_forms.' . $lastPart, $orderDir);
            }
        } else {
            $query->orderBy('scholar_forms.' . $columnName, $orderDir);
        }

        // Sayfalama
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $filteredRecords = $query->count();

        $data = $query->skip($start)
                      ->take($length)
                      ->distinct()
                      ->get()
                      ->map(function($item) {
                          if ($item->scholar && $item->scholar->created_at) {
                              $item->scholar->created_at = Carbon::parse($item->scholar->created_at)->format('d.m.Y');
                          }
                          if ($item->created_at) {
                              $item->created_at = Carbon::parse($item->created_at)->format('d.m.Y');
                          }
                          return $item;
                      });

        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $filteredRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
    private function getTableColumns()
    {
        $visibleColumns = [
            'form.infos.doc_fotograf',
            'scholar.aday_id',
            'scholar.id',
            'form.infos.aday_turu',
            'form.infos.tc_no',
            'scholar.created_at',
            'form.infos.name',
            'form.infos.surname',
            'form.infos.educationType',
            'form.infos.p_school_name',
            'form.infos.class',
            'form.infos.grade_departmant',
            'form.infos.tel_no',
            'form.infos.email',
            'form_id',
            'status',
            'form.islemi_yapan',
        ];

        $columnDetails = [];

        foreach ($visibleColumns as $column) {
            // İlişkili sütun kontrolü
            if (str_contains($column, '.')) {
                // İlişkili sütun için özel tanımlama
                list($relation, $field) = explode('.', $column);
                $title = Str::title(str_replace('_', ' ', $field));

                $columnDetails[$column] = [
                    'name' => $column,
                    'title' => $title,
                    'type' => 'text',
                    'filterable' => true,
                    'filterType' => 'text',
                    'filterOptions' => $this->getFilterOptions($column, 'text'),
                    'filterValue' => $this->getFilterValue($column, 'text'),
                    'isRelation' => true,
                    'relation' => $relation,
                    'field' => $field,
                    'visible' => true
                ];
            } else {
                // Normal sütunlar için mevcut işlem
                if (Schema::hasColumn('scholar_forms', $column)) {
                    $type = Schema::getColumnType('scholar_forms', $column);
                    $title = Str::title(str_replace('_', ' ', $column));

                    $columnDetails[$column] = [
                        'name' => $column,
                        'title' => $title,
                        'type' => $type,
                        'filterable' => true,
                        'filterType' => $this->getFilterType($type),
                        'filterOptions' => $this->getFilterOptions($column, $type),
                        'filterValue' => $this->getFilterValue($column, $type),
                        'isRelation' => false,
                        'orderable' => true,
                        'visible' => true
                    ];
                }
            }
        }

        return $columnDetails;
    }
    private  function getFilterOptionsByType($columnType)
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
    private function getFilterType($columnType)
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
    private function getFilterOptions($column, $type)
    {
        $options = [
            'text' => [
                'contains' => 'İçerir',
                'starts' => 'İle Başlar',
                'ends' => 'İle Biter',
                'equals' => 'Eşittir',
                'null' => 'Boş'
            ],
            'number' => [
                '=' => 'Eşittir',
                '>' => 'Büyüktür',
                '<' => 'Küçüktür',
                'null' => 'Boş'
            ],

            'date' => [
                '=' => 'Eşittir',
                '>' => 'Sonra',
                '<' => 'Önce',
                'null' => 'Boş'
            ],
            'boolean' => [
                '=' => 'Eşittir',
                'null' => 'Boş'
            ]
        ];

        // Özel durumlar için
        if ($column === 'educationType') {
            $values = ['İlkokul','Ortaokul','Lise','Ön lisans','Lisans','Yüksek Lisans','Doktora'];
            return $values;
        }

        if ($column === 'aday_turu') {
            $values= ['Dernek','Vakıf','null'];
            return $values;
        }
        if ($column === 'status') {
            $values= ['Tamamlanmadı','Tamamlandı','İade Edildi','İadeden Döndü','Onaylandı'];
            return $values;
        }


        return $options[$this->getFilterType($type)] ?? $options['text'];
    }
    private function getFilterValue($column, $type)
    {
        if ($column === 'status') {
            $values = ['0','1','2','3','4'];
            return $values;
        }
        if ($column === 'educationType') {
            // Veritabanında kayıtlı değerlerle eşleşmeli
            $values = ['ilkokul', 'ortaokul', 'lise', 'onlisans', 'lisans', 'ylisans', 'doktora'];
            return $values;
        }

        if ($column === 'aday_turu') {
            $values = ['Dernek','Vakıf','null'];
            return $values;
        }
        if ($column === 'status') {
            $values = ['0','1','2','3','4'];
            return $values;
        }
        return null;
    }
}
