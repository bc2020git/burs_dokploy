<?php

namespace App\Http\Controllers;

use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $versions = Version::orderBy('id','desc')->get();
        $columns = $this->getTableColumns();
        $columns['frontend_date']['title'] = 'Frontend Tarih';
        $columns['frontend_version']['title'] = 'Frontend Versiyon';
        $columns['backend_date']['title'] = 'Backend Tarih';
        $columns['backend_version']['title'] = 'Backend Versiyon';
        $checkboxColumns = [];
        $result= [
            'versions' => $versions,
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns
        ];
        return view('panel.settings.versions.index', $result);
    }
    public function getData(Request $request)
    {
        $query = Version::query();
        $columns = $this->getTableColumns();

        $totalRecords = $query->count();
        // Sayfalama parametreleri
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);

        // Toplam kayıt sayısı
        // Filtreleri uygula
        if ($request->has('filters')) {
            $query = $this->filterController->applyFilters($query, $request->filters);
        }

        // Sıralama
        $orderColumn = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $columnName = $columns[array_keys($columns)[$orderColumn]]['name'];
        $query->orderBy($columnName, $orderDir);

        // Filtrelenmiş kayıt sayısı
        $filteredRecords = $query->count();

        // Sayfalama
        $data = $query->skip($start)->take($length)->get();


        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
    private function getTableColumns()
    {
        $visibleColumns = [
            'frontend_version',
            'frontend_date',
            'backend_date',
            'backend_version',
        ];

        // Member modelinin tüm sütunlarını al
        $allColumns = \Schema::getColumnListing('versions');

        // visibleColumns'ı allColumns'dan çıkart
        $hiddenColumns = array_diff($allColumns, $visibleColumns);

        $columns = Schema::getColumnListing('versions');
        $columnDetails = [];

        foreach ($columns as $column) {
            // Eğer sütun gizlenecekler listesinde değilse ekle
            if (!in_array($column, $hiddenColumns)) {
                $type = Schema::getColumnType('versions', $column);
                $title = Str::title(str_replace('_', ' ', $column));

                $columnDetails[$column] = [
                    'name' => $column,
                    'title' => $title,
                    'type' => $type,
                    'visible' => true,
                    'filterable' => false,
                    'filterType' => $this->getFilterType($type),
                    'filterOptions' => $this->getFilterOptions($column, $type)
                ];
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


        return $options[$this->getFilterType($type)] ?? $options['text'];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.settings.versions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Version::create($request->all());

        return redirect()->route('versions.index')->with('success', 'Versiyon başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $version = Version::findOrFail($id);
        return view('panel.settings.versions.edit', compact('version'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $version)
    {
        $version = Version::findOrFail($version);
        $version->update($request->all());

        return redirect()->route('versions.index')
            ->with('success', 'Versiyon başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $version = Version::findOrFail($request->id);
            $version->delete();

            return response()->json([
                'success' => true,
                'message' => 'Versiyon başarıyla silindi.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Silme işlemi başarısız oldu.'
            ], 500);
        }
    }
    public function delete($id)
    {
        $version = Version::findOrFail($id);
        $version->delete();
        return redirect()->route('versions.index')->with('success', 'Versiyon başarıyla silindi.');
    }
}
