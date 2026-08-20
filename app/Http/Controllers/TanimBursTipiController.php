<?php

namespace App\Http\Controllers;

use App\Models\TanimBursTipi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TanimBursTipiController extends Controller
{
    protected FilterController $filterController;

    /** @return list<string> */
    private static function ogrenimTipiKeys(): array
    {
        return ['ilkokul', 'ortaokul', 'lise', 'onlisans', 'lisans', 'yukseklisans', 'doktora', 'tumu'];
    }

    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
    }

    public function index()
    {
        session(['sidebar' => 19]);
        $checkboxColumns = [];

        $columns = $this->getTableColumns();
        $columns['id']['visible'] = false;
        $columns['burs_tipi']['title'] = 'Burs Tipi';
        if (isset($columns['ogrenim_tipi'])) {
            $columns['ogrenim_tipi']['title'] = 'Öğrenim Türü';
        }

        return view('panel.tanimlar.bursTipi.index', [
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns,
        ]);
    }

    public function getData(Request $request)
    {
        $query = TanimBursTipi::query();
        $totalRecords = $query->count();
        $columns = $this->getTableColumns();

        if ($request->has('search') && ! empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue, $columns) {
                foreach ($columns as $column) {
                    if ($column['filterable']) {
                        $name = $column['name'];
                        $q->orWhere('tanim_burs_tipis.'.$name, 'like', "%{$searchValue}%");
                    }
                }
            });
        }

        if ($request->has('filters')) {
            $filters = $request->filters;
            foreach ($filters as $columnName => $filter) {
                if (! empty($filter['values'])) {
                    $query->where(function ($q) use ($columnName, $filter) {
                        $hasNull = in_array('null', $filter['values']);
                        $nonNullValues = array_filter($filter['values'], function ($value) {
                            return $value !== 'null';
                        });

                        if (! empty($nonNullValues)) {
                            foreach ($nonNullValues as $value) {
                                $condition = $filter['condition'] ?? 'contains';
                                $this->filterController->applyCondition($q, $columnName, $value, $condition);
                            }
                        }

                        if ($hasNull) {
                            $q->orWhereNull($columnName);
                        }
                    });
                }
            }
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);

        if ($request->has('filters')) {
            $filters = $request->filters;
            foreach ($columns as $column) {
                $columnName = $column['name'];
                if (isset($filters[$columnName]) && ! empty($filters[$columnName]['value'])) {
                    $condition = $filters[$columnName]['condition'] ?? '=';
                    $value = $filters[$columnName]['value'];

                    if (is_array($value)) {
                        if (in_array('null', $value)) {
                            $query->where(function ($q) use ($columnName, $value) {
                                $q->whereIn($columnName, array_filter($value, fn ($v) => $v !== 'null'))
                                    ->orWhereNull($columnName);
                            });
                        } else {
                            $query->whereIn($columnName, $value);
                        }
                    } else {
                        if ($value === 'null') {
                            $query->whereNull($columnName);
                        } else {
                            $this->filterController->applyCondition($query, $columnName, $value, $condition);
                        }
                    }
                }
            }
        }

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
                if (str_contains($columnName, '.')) {
                    list($relation, $field) = explode('.', $columnName);
                    $query->orderBy('tanim_burs_tipis.'.$field, $orderDir);
                } else {
                    $query->orderBy('tanim_burs_tipis.'.$columnName, $orderDir);
                }
            } else {
                $query->orderBy('tanim_burs_tipis.id', $orderDir);
            }
        }

        $filteredRecords = $query->count();

        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    private function getTableColumns(): array
    {
        $visibleColumns = [
            'id',
            'burs_tipi',
            'ogrenim_tipi',
        ];

        $columnDetails = [];

        foreach ($visibleColumns as $column) {
            if (Schema::hasColumn('tanim_burs_tipis', $column)) {
                $type = Schema::getColumnType('tanim_burs_tipis', $column);
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
                    'visible' => true,
                ];
            }
        }

        return $columnDetails;
    }

    private function getFilterType(string $columnType): string
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

    private function getFilterOptions(string $column, string $type): array
    {
        $options = $this->filterController->returnFilterOptions();

        if ($column === 'ogrenim_tipi') {
            return ['Tümü', 'İlkokul', 'Ortaokul', 'Lise', 'Ön Lisans', 'Lisans', 'Yüksek Lisans', 'Doktora'];
        }

        return $options[$this->getFilterType($type)] ?? $options['text'];
    }

    private function getFilterValue(string $column, string $type): ?array
    {
        if ($column === 'ogrenim_tipi') {
            return self::ogrenimTipiKeys();
        }

        return null;
    }

    public function create()
    {
        return view('panel.tanimlar.bursTipi.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'formData.bursTipi' => 'required|string|max:255',
            'formData.ogrenim_tipi' => ['required', Rule::in(self::ogrenimTipiKeys())],
        ]);

        $text = $request->input('formData.bursTipi');
        $existing = TanimBursTipi::where('burs_tipi', $text)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Bu burs tipi zaten mevcut.',
            ], 400);
        }

        TanimBursTipi::create([
            'burs_tipi' => $text,
            'ogrenim_tipi' => $request->input('formData.ogrenim_tipi'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Burs tipi başarıyla eklendi.',
        ]);
    }

    public function edit($id)
    {
        $bursTipi = TanimBursTipi::findOrFail($id);

        return view('panel.tanimlar.bursTipi.edit', compact('bursTipi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'formData.id' => 'required|integer|exists:tanim_burs_tipis,id',
            'formData.burs_tipi' => 'required|string|max:255',
            'formData.ogrenim_tipi' => ['required', Rule::in(self::ogrenimTipiKeys())],
        ]);

        $bursTipiId = $request->input('formData.id');
        $text = $request->input('formData.burs_tipi');
        $bursTipi = TanimBursTipi::find($bursTipiId);

        if (! $bursTipi) {
            return response()->json([
                'success' => false,
                'message' => 'Burs tipi bulunamadı.',
            ], 404);
        }

        $existingBursTipiWithName = TanimBursTipi::where('burs_tipi', $text)
            ->where('id', '!=', $bursTipiId)
            ->first();

        if ($existingBursTipiWithName) {
            return response()->json([
                'success' => false,
                'message' => 'Bu burs tipi adı zaten başka bir burs tipine ait.',
            ], 400);
        }

        $bursTipi->burs_tipi = $text;
        $bursTipi->ogrenim_tipi = $request->input('formData.ogrenim_tipi');
        $bursTipi->save();

        return response()->json([
            'success' => true,
            'message' => 'Burs tipi başarıyla güncellendi.',
        ]);
    }

    public function destroy(Request $request)
    {
        $datas = $request->ids;
        $result = TanimBursTipi::whereIn('id', $datas)->delete();
        $this->checkResult($result);
    }

    public function checkResult($result): void
    {
        if ($result) {
            session()->flash('success', 'İşlem Başarılı!');
        } else {
            session()->flash('error', 'İşlem Başarısız!');
        }
    }

    public function delete($id)
    {
        $bursTipi = TanimBursTipi::findOrFail($id);
        $bursTipi->delete();

        return redirect()->route('burs-tipleri.index');
    }
}
