<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TanimFaculty;
use App\Models\TanimDepartmant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
class FakulteController extends Controller
{
    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
    }
     public function index(){
        session(['sidebar' => 13]);
        $checkboxColumns = ['bv_onlisans', 'bv_lisans', 'bv_yukseklisans', 'bv_doktora','univercity.type'];

        $columns = $this->getTableColumns();
        $columns['id']['visible'] = false;
        $columns['code']['title'] = 'Fakülte Kodu';
        $columns['univercity.code']['title'] = 'Üniversite Kodu';
        $columns['univercity.name']['title'] = 'Üniversite Adı';
        $columns['univercity.type']['title'] = 'Üniversite Türü';
        $columns['univercity.city']['title'] = 'Üniversite Şehri';
        $columns['name']['title'] = 'Fakülte Adı';
        $columns['bv_onlisans']['title'] = 'B.V Ön Lisans';
        $columns['bv_lisans']['title'] = 'B.V Lisans';
        $columns['bv_yukseklisans']['title'] = 'B.V Yüksek Lisans';
        $columns['bv_doktora']['title'] = 'B.V Doktora';
        $result = [
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns

        ];
        return view('panel.tanimlar.faculties.index',$result);
    }
    public function getData(Request $request)
    {
        $columns = $this->getTableColumns();

        $query = TanimFaculty::with(['univercity'])
            ->select('tanim_faculties.*')
            ->leftJoin('tanim_univercities', 'tanim_faculties.univercity_id', '=', 'tanim_univercities.id');

        // Arama
        if ($request->has('search') && !empty($request->input('search.value'))) {
            $searchValue = $request->input('search.value');
            $query->where(function($q) use ($searchValue) {
                $q->where('tanim_faculties.name', 'like', "%{$searchValue}%")
                  ->orWhereHas('univercity', function($subQ) use ($searchValue) {
                      $subQ->where('name', 'like', "%{$searchValue}%");
                  });
            });
        }

        // Çoklu filtreler
        if ($request->has('filters')) {
            $filters = $request->filters;
            foreach ($filters as $columnName => $filter) {
                if (!empty($filter['values'])) {
                    $query->where(function($q) use ($columnName, $filter, $columns) {
                        // null değeri var mı kontrol et
                        $hasNull = in_array('null', $filter['values']);
                        // null olmayan değerleri filtrele
                        $nonNullValues = array_filter($filter['values'], function($value) {
                            return $value !== 'null';
                        });

                        // İlişkili sütun kontrolü
                        if (str_contains($columnName, 'univercity.')) {
                            $field = explode('.', $columnName)[1];
                            if (!empty($nonNullValues)) {
                                $q->whereHas('univercity', function($subQ) use ($nonNullValues, $filter, $field) {
                                    $subQ->where(function($innerQ) use ($nonNullValues, $filter, $field) {
                                        foreach ($nonNullValues as $value) {
                                            $condition = $filter['condition'] ?? 'contains';
                                            switch ($condition) {
                                                case 'contains':
                                                    $innerQ->orWhere("tanim_univercities.{$field}", 'like', "%{$value}%");
                                                    break;
                                                case 'not_contains':
                                                    $innerQ->orWhere("tanim_univercities.{$field}", 'not like', "%{$value}%");
                                                    break;
                                                case 'starts':
                                                    $innerQ->orWhere("tanim_univercities.{$field}", 'like', "{$value}%");
                                                    break;
                                                case 'not_starts':
                                                    $innerQ->orWhere("tanim_univercities.{$field}", 'not like', "{$value}%");
                                                    break;
                                                case 'ends':
                                                    $innerQ->orWhere("tanim_univercities.{$field}", 'like', "%{$value}");
                                                    break;
                                                case 'not_ends':
                                                    $innerQ->orWhere("tanim_univercities.{$field}", 'not like', "%{$value}");
                                                    break;
                                                case 'equals':
                                                    $innerQ->orWhere("tanim_univercities.{$field}", '=', $value);
                                                    break;
                                                case 'not_equals':
                                                    $innerQ->orWhere("tanim_univercities.{$field}", '!=', $value);
                                                    break;
                                                case 'empty':
                                                    $innerQ->orWhereNull("tanim_univercities.{$field}");
                                                    break;
                                                case 'not_empty':
                                                    $innerQ->orWhereNotNull("tanim_univercities.{$field}");
                                                    break;
                                                default:
                                                    $innerQ->orWhere("tanim_univercities.{$field}", 'like', "%{$value}%");
                                            }
                                        }
                                    });
                                });
                            }
                            if ($hasNull) {
                                $q->orWhereDoesntHave('univercity');
                            }
                            return;
                        }

                        // Ana tablo için filtreleme
                        if (!empty($nonNullValues)) {
                            foreach ($nonNullValues as $value) {
                                $condition = $filter['condition'] ?? 'contains';
                                switch ($condition) {
                                    case 'contains':
                                        $q->orWhere("tanim_faculties.{$columnName}", 'like', "%{$value}%");
                                        break;
                                    case 'not_contains':
                                        $q->orWhere("tanim_faculties.{$columnName}", 'not like', "%{$value}%");
                                        break;
                                    case 'starts':
                                        $q->orWhere("tanim_faculties.{$columnName}", 'like', "{$value}%");
                                        break;
                                    case 'not_starts':
                                        $q->orWhere("tanim_faculties.{$columnName}", 'not like', "{$value}%");
                                        break;
                                    case 'ends':
                                        $q->orWhere("tanim_faculties.{$columnName}", 'like', "%{$value}");
                                        break;
                                    case 'not_ends':
                                        $q->orWhere("tanim_faculties.{$columnName}", 'not like', "%{$value}");
                                        break;
                                    case 'equals':
                                        $q->orWhere("tanim_faculties.{$columnName}", $value);
                                        break;
                                    case 'not_equals':
                                        $q->orWhere("tanim_faculties.{$columnName}", '!=', $value);
                                        break;
                                    case 'empty':
                                        $q->orWhereNull("tanim_faculties.{$columnName}");
                                        break;
                                    case 'not_empty':
                                        $q->orWhereNotNull("tanim_faculties.{$columnName}");
                                        break;
                                    default:
                                        $q->orWhere("tanim_faculties.{$columnName}", $value);
                                }
                            }
                        }
                        if ($hasNull) {
                            $q->orWhereNull("tanim_faculties.{$columnName}");
                        }
                    });
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
                if (str_contains($columnName, 'univercity.')) {
                    $field = explode('.', $columnName)[1];
                    $query->orderBy("tanim_univercities.{$field}", $orderDir);
                } else {
                    $query->orderBy("tanim_faculties.{$columnName}", $orderDir);
                }
            } else {
                $query->orderBy('tanim_faculties.id', 'asc');
            }
        } else {
            $query->orderBy('tanim_faculties.id', 'asc');
        }

        // Sayfalama
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = TanimFaculty::count();
        $filteredRecords = $query->count();

        $data = $query->skip($start)
                      ->take($length)
                      ->get();

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
            'univercity.code',
            'univercity.name',
            'univercity.type',
            'univercity.city',
            'code',
            'name',
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
            case 'univercity.code':
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
        if ($column === 'univercity.type') {
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
        if ($column === 'univercity.type') {
            $values = ['Vakıf/Özel', 'Devlet'];
            return $values;
        }
        return null;
    }
    public function FacultyTopluSil(Request $request){
        $bursDurum = $request->bursDurum;
        $islemid = $request->islemId;
        $datas = $request->ids;

        if($islemid == '1'){
            foreach($datas as $data){
                $item = TanimFaculty::find($data);
                $checkDelete = $item->delete();
                if($checkDelete){
                    $departmant =TanimDepartmant::where('faculty_id',$data)->get();
                    if($departmant){
                        foreach($departmant as $departmant){
                            $departmant->delete();
                        }
                    }
                }
            }
            $result = TanimFaculty::whereIn('id',$datas)->delete();
            $this->filterController->checkResult($result);
            return response()->json(['success' => true]);
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
                $item = TanimFaculty::find($data);
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
    public function TopluAktar($userIds)
    {
        if(is_null($userIds)){
            $userIds = TanimFaculty::pluck('id')->toArray();
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
                'Fakülte Kodu',
                'Fakülte Adı',
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
                $data = TanimFaculty::with('univercity')->find($id);
                if ($data) {
                    $sheet->setCellValue('A' . $row, $data->univercity->code);
                    $sheet->setCellValue('B' . $row, $data->univercity->name);
                    $sheet->setCellValue('C' . $row, $data->univercity->type);
                    $sheet->setCellValue('D' . $row, $data->univercity->city);
                    $sheet->setCellValue('E' . $row, $data->code);
                    $sheet->setCellValue('F' . $row, $data->name);
                    $sheet->setCellValue('G' . $row, $data->bv_onlisans ? 'Evet' : 'Hayır');
                    $sheet->setCellValue('H' . $row, $data->bv_lisans ? 'Evet' : 'Hayır');
                    $sheet->setCellValue('I' . $row, $data->bv_yukseklisans ? 'Evet' : 'Hayır');
                    $sheet->setCellValue('J' . $row, $data->bv_doktora ? 'Evet' : 'Hayır');
                    $row++;
                }
            }

            // Excel dosyasını oluştur
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Fakulteler' . time() . '.xlsx';
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
    public function getUniversityId(Request $request)
    {
        $university = \App\Models\TanimUnivercity::where('name', $request->universityName)->first();
        return response()->json(['id' => $university ? $university->id : null]);
    }
    // Üniversiteleri getiren fonksiyon
    public function getUniversities()
    {
        $universities = \App\Models\TanimUnivercity::select('id', 'name')->get();
        return response()->json($universities);
    }

    // Toplu güncelleme fonksiyonu
    public function bulkUpdate(Request $request)
    {
        try {
            $facultyIds = $request->faculty_ids;
            $universityId = $request->university_id;

            TanimFaculty::whereIn('id', $facultyIds)
                ->update(['univercity_id' => $universityId]);

            return response()->json([
                'success' => true,
                'message' => 'Fakülteler başarıyla güncellendi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Güncelleme sırasında bir hata oluştu'
            ], 500);
        }
    }
}
