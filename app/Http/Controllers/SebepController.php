<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sebep;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
class SebepController extends Controller
{
    public function __construct()
    {
        $this->vFolder = 'panel.';
        $this->subFolder = 'tanimlar.';
        $this->lastFolder = 'sebep.';
    }
     public function index(){
        $checkboxColumns = ['type'];
        session(['sidebar' => 20]);

        $columns = $this->getTableColumns();
        $columns['id']['visible'] = false;
        $columns['text']['title'] = 'Sebep Metni';
        $columns['type']['title'] = 'Sebep Tipi';
        $result = [
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns,
        ];
        return view($this->vFolder.$this->subFolder.$this->lastFolder.'index',$result);
    }
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'text' => 'required',
        ]);
        Sebep::create($request->all());
        return redirect()->route('sebep.index')->with('success', 'Sebep başarıyla oluşturuldu.');
    }
    public function edit($id)
    {
        $item = Sebep::find($id);
        return view($this->vFolder.$this->subFolder.$this->lastFolder.'edit', compact('item'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'text' => 'required',
        ]);
        $item = Sebep::find($request->id);
        $item->update($request->all());
        return redirect()->route('sebep.index')->with('success', 'Sebep başarıyla güncellendi.');
    }

    public function getData(Request $request)
    {
        $query = Sebep::query();
        $totalRecords = $query->count();
        $columns = $this->getTableColumns();
        // Global arama
        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $query->where(function($q) use ($searchValue, $columns) {
                foreach ($columns as $column) {
                    if ($column['filterable']) {
                        $q->orWhere($column['name'], 'like', "%{$searchValue}%");
                    }
                }
            });
        }

          // Çoklu filtreler
          if ($request->has('filters')) {
            $filters = $request->filters;
            foreach ($filters as $columnName => $filter) {
                if (!empty($filter['values'])) {
                    $query->where(function($q) use ($columnName, $filter) {
                        // null değeri var mı kontrol et
                        $hasNull = in_array('null', $filter['values']);
                        // null olmayan değerleri filtrele
                        $nonNullValues = array_filter($filter['values'], function($value) {
                            return $value !== 'null';
                        });

                        if (!empty($nonNullValues)) {
                            foreach ($nonNullValues as $value) {
                                $condition = $filter['condition'] ?? 'contains';
                                switch ($condition) {
                                    case 'contains':
                                        $q->orWhere($columnName, 'like', "%{$value}%");
                                        break;
                                    case 'starts':
                                        $q->orWhere($columnName, 'like', "{$value}%");
                                        break;
                                    case 'ends':
                                        $q->orWhere($columnName, 'like', "%{$value}");
                                        break;
                                    default:
                                        $q->orWhere($columnName, $value);
                                }
                            }
                        }

                        // Eğer null değeri varsa, null koşulunu ekle
                        if ($hasNull) {
                            $q->orWhereNull($columnName);
                        }
                    });
                }
            }
        }

        // Sayfalama parametreleri
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);

        // Filtreleri uygula
        if ($request->has('filters')) {
            $filters = $request->filters;
            foreach ($columns as $column) {
                $columnName = $column['name'];
                if (isset($filters[$columnName]) && !empty($filters[$columnName]['value'])) {
                    $condition = $filters[$columnName]['condition'] ?? '=';
                    $value = $filters[$columnName]['value'];

                    if (is_array($value)) {
                        // 'null' stringini kontrol et ve null değerleri filtrele
                        if (in_array('null', $value)) {
                            $query->where(function($q) use ($columnName, $value) {
                                $q->whereIn($columnName, array_filter($value, fn($v) => $v !== 'null'))
                                  ->orWhereNull($columnName);
                            });
                        } else {
                            $query->whereIn($columnName, $value);
                        }
                    } else {
                        if ($value === 'null') {
                            $query->whereNull($columnName);
                        } else {
                            switch ($condition) {
                                case 'contains':
                                    $query->where($columnName, 'like', "%{$value}%");
                                    break;
                                case 'starts':
                                    $query->where($columnName, 'like', "{$value}%");
                                    break;
                                case 'ends':
                                    $query->where($columnName, 'like', "%{$value}");
                                    break;
                                default:
                                    $query->where($columnName, $condition, $value);
                                    break;
                            }
                        }
                    }
                }
            }
        }

        // Sıralama
        if ($request->has('order') && isset($request->order[0])) {
            $orderColumn = $request->order[0]['column'] ?? 0;
            $orderDir = $request->order[0]['dir'] ?? 'asc';

            $columnName = null;
            if (is_numeric($orderColumn)) {
                $columnKeys = array_keys($columns);
                if (isset($columnKeys[$orderColumn])) {
                    $columnName = $columnKeys[$orderColumn];
                }
            } else {
                if (isset($columns[$orderColumn])) {
                    $columnName = $orderColumn;
                }
            }

            if ($columnName) {
                // İlişkili alan kontrolü
                if (str_contains($columnName, '.')) {
                    list($relation, $field) = explode('.', $columnName);
                    switch($relation) {
                        case 'form':
                            $query->orderBy('sebeps.' . $field, $orderDir);
                            break;
                        case 'scholar':
                            $query->orderBy('sebeps.' . $field, $orderDir);
                            break;
                        default:
                            $query->orderBy('sebeps.' . $columnName, $orderDir);
                    }
                } else {
                    $query->orderBy('sebeps.' . $columnName, $orderDir);
                }
            } else {
                // Varsayılan sıralama
                $query->orderBy('sebeps.id', $orderDir);
            }
        }

        // Filtrelenmiş kayıt sayısı
        $filteredRecords = $query->count();

        // Sayfalama
        $data = $query->skip($start)->take($length)->get();

        // Tarih formatlaması gerekiyorsa

        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
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
            'type',
            // ... diğer checkbox kolonları
        ];
    }
    private function getTableColumns()
    {
        $visibleColumns = [
            'id',
            'text',
            'type',
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
                    'orderable' => true,
                    'visible' => true
                ];
            } else {
                // Normal sütunlar için mevcut işlem
                if (Schema::hasColumn('sebeps', $column)) {
                    $type = Schema::getColumnType('sebeps', $column);
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
                'equals' => 'Eşittir'
            ],
            'number' => [
                '=' => 'Eşittir',
                '>' => 'Büyüktür',
                '<' => 'Küçüktür'
            ],

            'date' => [
                '=' => 'Eşittir',
                '>' => 'Sonra',
                '<' => 'Önce'
            ],
            'boolean' => [
                '=' => 'Eşittir'
            ]
        ];



        if ($column === 'type') {
            $values = ['İade','Red'];
            return $values;
        }




        return $options[$this->getFilterType($type)] ?? $options['text'];
    }
    private function getFilterValue($column, $type)
    {
        if ($column === 'type') {
            $values = ['İade','Red'];
            return $values;
        }

        return null;
    }
    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $islem = $request->islemId;
        switch ($islem) {
            case '3':
                $this->destroy($ids);
                break;
        }
    }
    public function destroy($ids)
    {
        Sebep::whereIn('id', $ids)->delete();
        return response()->json(['success' => true,'message' => 'Toplu silme işlemi başarıyla gerçekleştirildi.']);
    }
}
