<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TanimUnivercity;
use App\Models\TanimFaculty;
use App\Models\TanimDepartmant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
class UniversiteController extends Controller
{
    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
    }
     public function index(){
        session(['sidebar' => 12]);
        $checkboxColumns = ['bv_onlisans', 'bv_lisans', 'bv_yukseklisans', 'bv_doktora','type'];

        $columns = $this->getTableColumns();
        $columns['id']['visible'] = false;
        $columns['code']['title'] = 'Üniversite Kodu';
        $columns['name']['title'] = 'Üniversite Adı';
        $columns['type']['title'] = 'Üniversite Türü';
        $columns['city']['title'] = 'Üniversite Şehri';
        $columns['bv_onlisans']['title'] = 'B.V Ön Lisans';
        $columns['bv_lisans']['title'] = 'B.V Lisans';
        $columns['bv_yukseklisans']['title'] = 'B.V Yüksek Lisans';
        $columns['bv_doktora']['title'] = 'B.V Doktora';
        $result = [
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns

        ];
        return view('panel.tanimlar.univercities.index',$result);
    }
    public function getData(Request $request)
    {
        $query = TanimUnivercity::query();
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
                                $this->filterController->applyCondition($q, $columnName, $value, $condition);
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
                           $this->filterController->applyCondition($query, $columnName, $value, $condition);
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
                            $query->orderBy('tanim_univercities.' . $field, $orderDir);
                            break;
                        case 'scholar':
                            $query->orderBy('tanim_univercities.' . $field, $orderDir);
                            break;
                        default:
                            $query->orderBy('tanim_univercities.' . $columnName, $orderDir);
                    }
                } else {
                    $query->orderBy('tanim_univercities.' . $columnName, $orderDir);
                }
            } else {
                // Varsayılan sıralama
                $query->orderBy('tanim_univercities.id', $orderDir);
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
            'status',
            'payment_type',
            // ... diğer checkbox kolonları
        ];
    }
    private function getTableColumns()
    {
        $visibleColumns = [
            'code',
            'name',
            'type',
            'city',
            'bv_onlisans',
            'bv_lisans',
            'bv_yukseklisans',
            'bv_doktora',
            'id',
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
                    'filterType' => $this->getFilterType($column, 'text'),
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
                if (Schema::hasColumn('tanim_univercities', $column)) {
                    $type = Schema::getColumnType('tanim_univercities', $column);
                    $title = Str::title(str_replace('_', ' ', $column));

                    $columnDetails[$column] = [
                        'name' => $column,
                        'title' => $title,
                        'type' => $type,
                        'filterable' => true,
                        'filterType' => $this->getFilterType($column, $type),
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
    private function getFilterType($column, $columnType)
    {
        switch ($column) {
            case 'code':
                return 'number';
        }
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
        $options = $this->filterController->returnFilterOptions();

        // Özel durumlar için
        if (str_starts_with($column, 'bv_')) {
            $values= ['Evet','Hayır'];
            return $values;
        }
        if ($column === 'type') {
            $values = ['Vakıf/Özel', 'Devlet'];
            return $values;
        }





        return $options[$this->getFilterType($column, $type)] ?? $options['text'];
    }
    private function getFilterValue($column, $type)
    {
        if (str_starts_with($column, 'bv_')) {
            $values= ['1','0'];
            return $values;
        }
        if ($column === 'type') {
            $values = ['Vakıf/Özel', 'Devlet'];
            return $values;
        }
        return null;
    }
    public function TopluAktar($userIds)
    {
        if(is_null($userIds)){
            $userIds = TanimUnivercity::pluck('id')->toArray();
        }
        try {
            // userIds'in dizi olduğundan emin ol
            if (!is_array($userIds)) {
                $userIds = explode(',', $userIds);
            }

            // Excel dosyası oluştur
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Başlıkları tanımla
            $headers = [
                'Üniversite Kodu',
                'Üniversite Adı',
                'Üniversite Türü',
                'Şehir',
                'B.V Ön Lisans',
                'B.V Lisans',
                'B.V Yüksek Lisans',
                'B.V Doktora'
            ];

            // Başlıkları yaz
            foreach ($headers as $key => $header) {
                $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
                $sheet->setCellValue($column . '1', $header);
            }

            // Verileri çek ve yaz
            $row = 2;
            foreach ($userIds as $id) {
                $data = TanimUnivercity::find($id);
                if ($data) {
                    $sheet->setCellValue('A' . $row, $data->code);
                    $sheet->setCellValue('B' . $row, $data->name);
                    $sheet->setCellValue('C' . $row, $data->type);
                    $sheet->setCellValue('D' . $row, $data->city);
                    $sheet->setCellValue('E' . $row, $data->bv_onlisans ? 'Evet' : 'Hayır');
                    $sheet->setCellValue('F' . $row, $data->bv_lisans ? 'Evet' : 'Hayır');
                    $sheet->setCellValue('G' . $row, $data->bv_yukseklisans ? 'Evet' : 'Hayır');
                    $sheet->setCellValue('H' . $row, $data->bv_doktora ? 'Evet' : 'Hayır');
                    $row++;
                }
            }

            // Excel dosyasını oluştur
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Universiteler' . time() . '.xlsx';
            $filePath = storage_path('app/public/temp/' . $fileName);

            // Temp klasörünü kontrol et
            if (!file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0777, true);
            }

            // Dosyayı kaydet
            $writer->save($filePath);

            // Dosya URL'sini oluştur
            $fileUrl = asset('storage/app/public/temp/' . $fileName);

            return response()->json([
                'success' => true,
                'file_url' => $fileUrl,
                'file_name' => $fileName
            ]);

        } catch (\Exception $e) {
            \Log::error('Excel oluşturma hatası: ' . $e->getMessage());
            \Log::error('userIds: ' . print_r($userIds, true));
            return response()->json(['error' => 'Excel dosyası oluşturulamadı'], 500);
        }
    }

    public function UniversiteTopluSil(Request $request){
        $bursDurum = $request->bursDurum;
        $islemid = $request->islemId;
        $datas = $request->ids;

        if($islemid == '1'){
            foreach($datas as $data){
                $item = TanimUnivercity::find($data);
                $checkDelete = $item->delete();
                if($checkDelete){
                    $faculty = TanimFaculty::where('univercity_id',$data)->get();
                }
                if($faculty){
                    foreach($faculty as $faculty){
                        $checkDelete = $faculty->delete();
                        if($checkDelete){
                            $departmant = TanimDepartmant::where('faculty_id',$faculty->id)->get();
                            if($departmant){
                                foreach($departmant as $departmant){
                                    $departmant->delete();
                                }
                            }
                    }
                }
            }
            $result = TanimUnivercity::whereIn('id',$datas)->delete();
            return response()->json(['success' => true]);
        }
    }
        if($islemid == '3'){
            return $this->TopluAktar($datas);
        }

        if ($islemid == '2'){
            $bv_onlisans = $request->bv_onlisans;
            $bv_lisans = $request->bv_lisans;
            $bv_yukseklisans = $request->bv_yukseklisans;
            $bv_doktora = $request->bv_doktora;

            foreach ($datas as $data){
                $item = TanimUnivercity::find($data);
                if ($bv_onlisans==1){
                    $item->bv_onlisans = $bursDurum;
                }
                if ($bv_lisans==1){
                    $item->bv_lisans = $bursDurum;
                }
                if ($bv_yukseklisans==1){
                    $item->bv_yukseklisans = $bursDurum;
                }
                if ($bv_doktora==1){
                    $item->bv_doktora = $bursDurum;
                }
                $result = $item->save();
            }
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Geçersiz işlem'], 400);
    }

}
