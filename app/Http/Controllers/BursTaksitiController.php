<?php

namespace App\Http\Controllers;

use App\Models\BursTaksiti;
use App\Models\TanimBursTipi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BursTaksitiController extends Controller
{
    protected FilterController $filterController;

    /** @return list<string> */
    private static function donemKeys(?int $nowYear = null): array
    {
        $y = $nowYear ?? (int) now()->format('Y');
        $start = $y - 3;
        $end = $y + 4;
        $keys = [];
        for ($i = $start; $i <= $end; $i++) {
            $keys[] = $i.'-'.($i + 1);
        }

        return $keys;
    }

    private static function donemLabel(string $key): string
    {
        $parts = explode('-', $key);
        $a = $parts[0] ?? $key;
        $b = $parts[1] ?? '';

        return trim($a.' - '.$b.' Dönemi');
    }

    /** @param list<string> $keys */
    private static function donemOptions(array $keys): array
    {
        $opts = [];
        foreach ($keys as $k) {
            $opts[$k] = self::donemLabel($k);
        }

        return $opts;
    }

    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
    }

    public function index()
    {
        session(['sidebar' => 51]);
        $checkboxColumns = [];
        $columns = $this->getTableColumns();
        $columns['id']['visible'] = false;
        if (isset($columns['burs_tipi_adi'])) {
            $columns['burs_tipi_adi']['title'] = 'Burs Tipi';
        }
        if (isset($columns['donem'])) {
            $columns['donem']['title'] = 'Dönem';
        }
        if (isset($columns['burs_tutari'])) {
            $columns['burs_tutari']['title'] = 'Burs Tutarı';
        }
        if (isset($columns['taksit_sayisi'])) {
            $columns['taksit_sayisi']['title'] = 'Taksit Sayısı';
        }
        if (isset($columns['baslangic_tarihi'])) {
            $columns['baslangic_tarihi']['title'] = 'Başlangıç Tarihi';
        }

        return view('panel.tanimlar.bursTaksiti.index', [
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns,
        ]);
    }

    public function getData(Request $request)
    {
        $query = BursTaksiti::query()
            ->leftJoin('tanim_burs_tipis', 'burs_taksitleri.burs_tipi_id', '=', 'tanim_burs_tipis.id')
            ->select(
                'burs_taksitleri.*',
                'tanim_burs_tipis.burs_tipi as burs_tipi_adi'
            );

        $totalRecords = BursTaksiti::query()->count();

        $columns = $this->getTableColumns();

        if ($request->has('search') && ! empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('tanim_burs_tipis.burs_tipi', 'like', "%{$searchValue}%")
                    ->orWhere('burs_taksitleri.donem', 'like', "%{$searchValue}%")
                    ->orWhere('burs_taksitleri.burs_tutari', 'like', "%{$searchValue}%")
                    ->orWhere('burs_taksitleri.taksit_sayisi', 'like', "%{$searchValue}%");
            });
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        if ($request->has('filters')) {
            $filters = $request->filters;
            foreach ($columns as $column) {
                $columnName = $column['name'];
                if (isset($filters[$columnName]) && ! empty($filters[$columnName]['value'])) {
                    $condition = $filters[$columnName]['condition'] ?? '=';
                    $value = $filters[$columnName]['value'];
                    $field = $columnName === 'burs_tipi_adi' ? 'tanim_burs_tipis.burs_tipi' : 'burs_taksitleri.'.$columnName;

                    if (is_array($value)) {
                        if (in_array('null', $value)) {
                            $query->where(function ($q) use ($field, $value) {
                                $q->whereIn($field, array_filter($value, fn ($v) => $v !== 'null'))
                                    ->orWhereNull($field);
                            });
                        } else {
                            $query->whereIn($field, $value);
                        }
                    } else {
                        if ($value === 'null') {
                            $query->whereNull($field);
                        } else {
                            $this->filterController->applyCondition($query, $field, $value, $condition);
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
                if ($columnName === 'burs_tipi_adi') {
                    $query->orderBy('tanim_burs_tipis.burs_tipi', $orderDir);
                } else {
                    $query->orderBy('burs_taksitleri.'.$columnName, $orderDir);
                }
            } else {
                $query->orderBy('burs_taksitleri.id', $orderDir);
            }
        } else {
            $query->orderBy('burs_taksitleri.id', 'desc');
        }

        $filteredRecords = (clone $query)->count();
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    private function getTableColumns(): array
    {
        $visibleColumns = [
            'id',
            'burs_tipi_adi',
            'donem',
            'burs_tutari',
            'taksit_sayisi',
            'baslangic_tarihi',
        ];

        $columnDetails = [];

        foreach ($visibleColumns as $column) {
            if ($column === 'burs_tipi_adi') {
                $columnDetails[$column] = [
                    'name' => $column,
                    'title' => 'Burs Tipi',
                    'type' => 'text',
                    'filterable' => true,
                    'filterType' => 'text',
                    'filterOptions' => $this->getFilterOptions($column, 'text'),
                    'filterValue' => $this->getFilterValue($column, 'text'),
                    'isRelation' => false,
                    'orderable' => true,
                    'visible' => true,
                ];

                continue;
            }

            if (Schema::hasColumn('burs_taksitleri', $column)) {
                $type = Schema::getColumnType('burs_taksitleri', $column);
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

        if ($column === 'donem') {
            return array_map(fn ($k) => self::donemLabel($k), self::donemKeys());
        }

        return $options[$this->getFilterType($type)] ?? $options['text'];
    }

    private function getFilterValue(string $column, string $type): ?array
    {
        if ($column === 'donem') {
            return self::donemKeys();
        }

        return null;
    }

    public function create()
    {
        $donemKeys = self::donemKeys();
        $donemOptions = self::donemOptions($donemKeys);
        $bursTipleri = TanimBursTipi::query()->orderBy('burs_tipi')->get();

        return view('panel.tanimlar.bursTaksiti.add', compact('donemOptions', 'bursTipleri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'formData.burs_tipi_id' => 'required|integer|exists:tanim_burs_tipis,id',
            'formData.taksit_sayisi' => 'required|integer|min:1',
            'formData.burs_tutari' => 'required|numeric|min:0',
            'formData.donem' => ['required', Rule::in(self::donemKeys())],
            'formData.baslangic_tarihi' => 'required|string',
        ]);

        $bursTipiId = (int) $request->input('formData.burs_tipi_id');
        $donem = (string) $request->input('formData.donem');

        $exists = BursTaksiti::query()
            ->where('burs_tipi_id', $bursTipiId)
            ->where('donem', $donem)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Bu burs tipi için seçilen dönem zaten tanımlı.',
            ], 400);
        }

        $baslangicYmd = $this->parseDateToYmd((string) $request->input('formData.baslangic_tarihi'));
        if (!$baslangicYmd) {
            return response()->json([
                'success' => false,
                'message' => 'Başlangıç tarihi geçersiz. GG.AA.YYYY formatında giriniz.',
            ], 400);
        }

        BursTaksiti::create([
            'burs_tipi_id' => $bursTipiId,
            'taksit_sayisi' => $request->input('formData.taksit_sayisi'),
            'burs_tutari' => $request->input('formData.burs_tutari'),
            'donem' => $donem,
            'baslangic_tarihi' => $baslangicYmd,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Burs taksiti başarıyla eklendi.',
        ]);
    }

    public function edit($id)
    {
        $bursTaksiti = BursTaksiti::query()->findOrFail($id);
        $donemKeys = self::donemKeys();
        if ($bursTaksiti->donem && ! in_array($bursTaksiti->donem, $donemKeys, true)) {
            $donemKeys[] = $bursTaksiti->donem;
        }
        $donemOptions = self::donemOptions($donemKeys);
        $bursTipleri = TanimBursTipi::query()->orderBy('burs_tipi')->get();

        return view('panel.tanimlar.bursTaksiti.edit', compact('bursTaksiti', 'donemOptions', 'bursTipleri'));
    }

    public function update(Request $request)
    {
        $allowedDonem = self::donemKeys();
        $current = (string) $request->input('formData.donem');
        if ($current && ! in_array($current, $allowedDonem, true)) {
            $allowedDonem[] = $current;
        }

        $request->validate([
            'formData.id' => 'required|integer|exists:burs_taksitleri,id',
            'formData.burs_tipi_id' => 'required|integer|exists:tanim_burs_tipis,id',
            'formData.taksit_sayisi' => 'required|integer|min:1',
            'formData.burs_tutari' => 'required|numeric|min:0',
            'formData.donem' => ['required', Rule::in($allowedDonem)],
            'formData.baslangic_tarihi' => 'required|string',
        ]);

        $id = (int) $request->input('formData.id');
        $bursTipiId = (int) $request->input('formData.burs_tipi_id');
        $donem = (string) $request->input('formData.donem');

        $bursTaksiti = BursTaksiti::query()->findOrFail($id);

        $duplicate = BursTaksiti::query()
            ->where('burs_tipi_id', $bursTipiId)
            ->where('donem', $donem)
            ->where('id', '!=', $id)
            ->exists();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'message' => 'Bu burs tipi için seçilen dönem zaten başka bir kayıtta kullanılıyor.',
            ], 400);
        }

        $baslangicYmd = $this->parseDateToYmd((string) $request->input('formData.baslangic_tarihi'));
        if (!$baslangicYmd) {
            return response()->json([
                'success' => false,
                'message' => 'Başlangıç tarihi geçersiz. GG.AA.YYYY formatında giriniz.',
            ], 400);
        }

        $bursTaksiti->fill([
            'burs_tipi_id' => $bursTipiId,
            'taksit_sayisi' => $request->input('formData.taksit_sayisi'),
            'burs_tutari' => $request->input('formData.burs_tutari'),
            'donem' => $donem,
            'baslangic_tarihi' => $baslangicYmd,
        ]);
        $bursTaksiti->save();

        return response()->json([
            'success' => true,
            'message' => 'Burs taksiti başarıyla güncellendi.',
        ]);
    }

    public function destroy(Request $request)
    {
        $datas = $request->ids;
        $result = BursTaksiti::query()->whereIn('id', $datas)->delete();
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
        $bursTaksiti = BursTaksiti::query()->findOrFail($id);
        $bursTaksiti->delete();

        return redirect()->route('burs-taksitleri.index');
    }

    private function parseDateToYmd(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }
        $value = trim($value);

        if (preg_match('/^\d{4}[-\/.]\d{1,2}[-\/.]\d{1,2}/', $value)) {
            try {
                return Carbon::parse($value)->format('Y-m-d');
            } catch (\Throwable $e) {
            }
        }

        foreach (['d.m.Y', 'd.m.y', 'd-m-Y', 'd-m-y', 'd/m/Y', 'd/m/y'] as $fmt) {
            try {
                return Carbon::createFromFormat($fmt, $value)->format('Y-m-d');
            } catch (\Throwable $e) {
            }
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
        } catch (\Throwable $e) {
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
