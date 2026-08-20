<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
class FilterController extends Controller
{
    public function filterTable(Request $request)
    {
        $filters = $request->filters ?? [];
        $modelName = "App\\Models\\" . $request->model;
        $relations = $request->relations ?? [];
        $columnMappings = $request->columnMappings ?? [];

        $query = $modelName::with($relations);

        // Okul araması için özel işlem
        if (isset($filters['school_name'])) {
            $query->where(function($q) use ($filters, $columnMappings) {
                $searchValue = $filters['school_name'];
                if (isset($columnMappings['school_name'])) {
                    $relation = $columnMappings['school_name']['relation'];
                    $field = $columnMappings['school_name']['field'];
                    $q->whereHas($relation, function($query) use ($searchValue) {
                        $query->where(function($subQuery) use ($searchValue) {
                            $subQuery->where('p_school_name', 'LIKE', "%{$searchValue}%")
                                    ->orWhere('m_school_name', 'LIKE', "%{$searchValue}%")
                                    ->orWhere('h_school_name', 'LIKE', "%{$searchValue}%")
                                    ->orWhere('current_university', 'LIKE', "%{$searchValue}%");
                        });
                    });
                }
            });
            unset($filters['school_name']);
        }

        // İl filtresi için özel işlem
        if (isset($filters['il_no'])) {
            $query->where(function($q) use ($filters) {
                $il_no = $filters['il_no'];
                $q->where('il_no', $il_no);
            });
            unset($filters['il_no']);
        }

        // Diğer filtreler için işlem
        if (!empty($filters)) {
            foreach ($filters as $column => $value) {
                if (is_array($value)) {
                    // Çoklu seçim (checkbox) için whereIn kullan
                    if (isset($columnMappings[$column])) {
                        // İlişkili tablo için
                        $mapping = $columnMappings[$column];
                        $query->whereHas($mapping['relation'], function($q) use ($mapping, $value) {
                            $q->whereIn($mapping['field'], $value);
                        });
                    } else {
                        // Ana tablo için
                        $query->whereIn($column, $value);
                    }
                } else {
                    // Tekil değer için mevcut mantık
                    if ($value === 'null') {
                        $query->whereNull($column);
                    } else if (isset($columnMappings[$column])) {
                        $mapping = $columnMappings[$column];
                        $query->whereHas($mapping['relation'], function($q) use ($mapping, $value) {
                            $q->where($mapping['field'], 'LIKE', "%{$value}%");
                        });
                    } else {
                        $query->where($column, 'LIKE', "%{$value}%");
                    }
                }
            }
        }

        // Where koşulları için özel işlem
        if ($request->where) {
            foreach ($request->where as $column => $value) {
                if (is_array($value)) {
                    $query->whereIn($column, $value);
                } else {
                    $query->where($column, $value);
                }
            }
        }

        $data = $query->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function applyCondition($q, $columnName, $value, $condition){
        switch ($condition) {
            case 'equals':
                $q->where($columnName, '=', $value);
                break;
            case 'not_equals':
                $q->where($columnName, '!=', $value);
                break;
            case 'contains':
                $q->where($columnName, 'like', "%{$value}%");
                break;
            case 'not_contains':
                $q->where($columnName, 'not like', "%{$value}%");
                break;
            case 'starts':
                $q->where($columnName, 'like', "{$value}%");
                break;
            case 'not_starts':
                $q->where($columnName, 'not like', "{$value}%");
                break;
            case 'ends':
                $q->where($columnName, 'like', "%{$value}");
                break;
            case 'not_ends':
                $q->where($columnName, 'not like', "%{$value}");
                break;
            case 'empty':
                $q->whereNull($columnName)->orWhere($columnName, '');
                break;
            case 'not_empty':
                $q->whereNotNull($columnName)->where($columnName, '!=', '');
                break;
            case 'greater':
                $q->where($columnName, '>', $value);
                break;
            case 'greater_equals':
                $q->where($columnName, '>=', $value);
                break;
            case 'less':
                $q->where($columnName, '<', $value);
                break;
            case 'less_equals':
                $q->where($columnName, '<=', $value);
                break;
            default:
                $q->orWhere($columnName, $value);
        }
    }
    public function  returnFilterOptions()
    {
        $options = [
            'text' => [
            'equals' => 'Eşittir',
            'not_equals' => 'Eşit Değildir',
            'contains' => 'İçerir',
            'not_contains' => 'İçermez',
            'starts' => 'İle Başlar',
            'not_starts' => 'İle Başlamaz',
            'ends' => 'İle Biter',
            'not_ends' => 'İle Bitmez',
            'empty' => 'Boş',
            'not_empty' => 'Boş Değil'
        ],
        'number' => [
            'equals' => 'Eşittir',
            'not_equals' => 'Eşit Değildir',
            'greater' => 'Büyüktür',
            'greater_equals' => 'Büyük veya Eşittir',
            'less' => 'Küçüktür',
            'less_equals' => 'Küçük veya Eşittir',
            'empty' => 'Boş',
            'not_empty' => 'Boş Değil'
        ],
        'date' => [
            'equals' => 'Eşittir',
            'not_equals' => 'Eşit Değildir',
            'after' => 'Sonra',
            'before' => 'Önce',
            'empty' => 'Boş',
            'not_empty' => 'Boş Değil'
        ],
        'boolean' => [
            'equals' => 'Eşittir',
            'not_equals' => 'Eşit Değildir'
        ]
        ];
        return $options;
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
        // İlişkisel alan kontrolü
        if (!str_contains($field, '.')) {
            $field = 'students.' . $field;
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
        }
    }
    public function getColumnDefinitions($table,$tableColumns)
    {
        $acceptedColumns = $tableColumns;
        $columns = [];
        // Model sütunlarını al
        // NewAnswer modelinin tüm sütunlarını al
        $allColumns = \Schema::getColumnListing($table);

        // visibleColumns'ı allColumns'dan çıkart
        $hiddenColumns = array_diff($allColumns, $acceptedColumns);

        $allColumns = Schema::getColumnListing($table);
        $columnDetails = [];
        // Sıralı şekilde sütunları ekleyelim
        foreach ($acceptedColumns as $column) {
            if (in_array($column, $allColumns)) {  // Veritabanında var olan sütunları kontrol et
                $title = $this->getColumnTitle($column);

                $type = Schema::getColumnType($table, $column);
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
    protected function getColumnTitle($column)
    {


        $title = strtolower($column);
        return $translations[$title] ?? $title;
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

            case (str_starts_with($column, 'doc_')):
                return [
                    '0' => 'Hayır',
                    '1' => 'Evet'
                ];

            default:
                return [];
        }
    }
    private function getFilterValue($column, $type)
    {
        if (strpos($column, 'doc_') === 0) {
            $values = ['Hayır', 'Evet'];
            return $values;
        }

        return null;
    }
    public function checkResult($result){
        if ($result){
            session()->flash('success', 'İşlem Başarılı!');
        }
        else{
            session()->flash('error', 'İşlem Başarısız!');
        }
    }
}
