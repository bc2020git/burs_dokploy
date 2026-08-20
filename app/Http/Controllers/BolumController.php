<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TanimDepartmant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BolumController extends Controller
{
    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
    }
     public function index(){
        $this->checkgradetype();
        session(['sidebar' => 14]);
        $checkboxColumns = ['bv_onlisans', 'bv_lisans', 'bv_yukseklisans', 'bv_doktora','univercity.type'];

        $columns = $this->getTableColumns();
        $columns['id']['visible'] = false;
        $columns['faculty.code']['title'] = 'Fakülte Kodu';
        $columns['faculty.name']['title'] = 'Fakülte Adı';
        $columns['univercity.code']['title'] = 'Üniversite Kodu';
        $columns['univercity.name']['title'] = 'Üniversite Adı';
        $columns['univercity.type']['title'] = 'Üniversite Türü';
        $columns['univercity.city']['title'] = 'Üniversite Şehri';
        $columns['name']['title'] = 'Bölüm Adı';
        $columns['code']['title'] = 'Bölüm Kodu';
        $columns['bv_onlisans']['title'] = 'B.V Ön Lisans';
        $columns['bv_lisans']['title'] = 'B.V Lisans';
        $columns['bv_yukseklisans']['title'] = 'B.V Yüksek Lisans';
        $columns['bv_doktora']['title'] = 'B.V Doktora';
        $result = [
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns

        ];
        return view('panel.tanimlar.departmants.index',$result);
    }
    public function getData(Request $request)
    {
        $columns = $this->getTableColumns();

        $query = TanimDepartmant::with(['faculty.univercity'])
            ->select('tanim_departmants.*')
            ->leftJoin('tanim_faculties', 'tanim_departmants.faculty_id', '=', 'tanim_faculties.id')
            ->leftJoin('tanim_univercities', 'tanim_faculties.univercity_id', '=', 'tanim_univercities.id');

        // Arama
        if ($request->has('search') && !empty($request->input('search.value'))) {
            $searchValue = $request->input('search.value');
            $query->where(function($q) use ($searchValue) {
                $q->where('tanim_departmants.name', 'like', "%{$searchValue}%")
                  ->orWhere('tanim_departmants.code', 'like', "%{$searchValue}%")
                  ->orWhere('tanim_faculties.name', 'like', "%{$searchValue}%")
                  ->orWhere('tanim_univercities.name', 'like', "%{$searchValue}%");
            });
        }

        // Çoklu filtreler
        if ($request->has('filters')) {
            $filters = $request->filters;
            foreach ($filters as $columnName => $filter) {
                if (!empty($filter['values'])) {
                    $query->where(function($q) use ($columnName, $filter) {
                        $hasNull = in_array('null', $filter['values']);
                        $nonNullValues = array_filter($filter['values'], function($value) {
                            return $value !== 'null';
                        });

                        // İlişkili tablolar için filtreleme
                        if (str_contains($columnName, '.')) {
                            list($relation, $field) = explode('.', $columnName);

                            if ($relation === 'faculty') {
                                if (!empty($nonNullValues)) {
                                    foreach ($nonNullValues as $value) {
                                        $condition = $filter['condition'] ?? 'contains';
                                        switch ($condition) {
                                            case 'contains':
                                                $q->orWhere('tanim_faculties.' . $field, 'like', "%{$value}%");
                                                break;
                                            case 'not_contains':
                                                $q->orWhere('tanim_faculties.' . $field, 'not like', "%{$value}%");
                                                break;
                                            case 'starts':
                                                $q->orWhere('tanim_faculties.' . $field, 'like', "{$value}%");
                                                break;
                                            case 'not_starts':
                                                $q->orWhere('tanim_faculties.' . $field, 'not like', "{$value}%");
                                                break;
                                            case 'ends':
                                                $q->orWhere('tanim_faculties.' . $field, 'like', "%{$value}");
                                                break;
                                            case 'not_ends':
                                                $q->orWhere('tanim_faculties.' . $field, 'not like', "%{$value}");
                                                break;
                                            case 'equals':
                                                $q->orWhere('tanim_faculties.' . $field, '=', $value);
                                                break;
                                            case 'not_equals':
                                                $q->orWhere('tanim_faculties.' . $field, '!=', $value);
                                                break;
                                            case 'empty':
                                                $q->orWhereNull('tanim_faculties.' . $field);
                                                break;
                                            case 'not_empty':
                                                $q->orWhereNotNull('tanim_faculties.' . $field);
                                                break;
                                            default:
                                                $q->orWhere('tanim_faculties.' . $field, $value);
                                        }
                                    }
                                }
                                if ($hasNull) {
                                    $q->orWhereNull('tanim_faculties.' . $field);
                                }
                            } elseif ($relation === 'univercity') {
                                if (!empty($nonNullValues)) {
                                    foreach ($nonNullValues as $value) {
                                        $condition = $filter['condition'] ?? 'contains';
                                        switch ($condition) {
                                            case 'contains':
                                                $q->orWhere('tanim_univercities.' . $field, 'like', "%{$value}%");
                                                break;
                                            case 'not_contains':
                                                $q->orWhere('tanim_univercities.' . $field, 'not like', "%{$value}%");
                                                break;
                                            case 'starts':
                                                $q->orWhere('tanim_univercities.' . $field, 'like', "{$value}%");
                                                break;
                                            case 'not_starts':
                                                $q->orWhere('tanim_univercities.' . $field, 'not like', "{$value}%");
                                                break;
                                            case 'ends':
                                                $q->orWhere('tanim_univercities.' . $field, 'like', "%{$value}");
                                                break;
                                            case 'not_ends':
                                                $q->orWhere('tanim_univercities.' . $field, 'not like', "%{$value}");
                                                break;
                                            case 'equals':
                                                $q->orWhere('tanim_univercities.' . $field, '=', $value);
                                                break;
                                            case 'not_equals':
                                                $q->orWhere('tanim_univercities.' . $field, '!=', $value);
                                                break;
                                            case 'empty':
                                                $q->orWhereNull('tanim_univercities.' . $field);
                                                break;
                                            case 'not_empty':
                                                $q->orWhereNotNull('tanim_univercities.' . $field);
                                                break;
                                            default:
                                                $q->orWhere('tanim_univercities.' . $field, $value);
                                        }
                                    }
                                }
                                if ($hasNull) {
                                    $q->orWhereNull('tanim_univercities.' . $field);
                                }
                            }
                        } else {
                            // Ana tablo için filtreleme
                            if (!empty($nonNullValues)) {
                                foreach ($nonNullValues as $value) {
                                    $condition = $filter['condition'] ?? 'contains';
                                    switch ($condition) {
                                        case 'contains':
                                            $q->orWhere('tanim_departmants.' . $columnName, 'like', "%{$value}%");
                                            break;
                                        case 'not_contains':
                                            $q->orWhere('tanim_departmants.' . $columnName, 'not like', "%{$value}%");
                                            break;
                                        case 'starts':
                                            $q->orWhere('tanim_departmants.' . $columnName, 'like', "{$value}%");
                                            break;
                                        case 'ends':
                                            $q->orWhere('tanim_departmants.' . $columnName, 'like', "%{$value}");
                                            break;
                                        case 'not_starts':
                                            $q->orWhere('tanim_departmants.' . $columnName, 'not like', "{$value}%");
                                            break;
                                        case 'not_ends':
                                            $q->orWhere('tanim_departmants.' . $columnName, 'not like', "%{$value}");
                                            break;
                                        case 'equals':
                                            $q->orWhere('tanim_departmants.' . $columnName, '=', $value);
                                            break;
                                        case 'not_equals':
                                            $q->orWhere('tanim_departmants.' . $columnName, '!=', $value);
                                            break;
                                        case 'empty':
                                            $q->orWhereNull('tanim_departmants.' . $columnName);
                                            break;
                                        case 'not_empty':
                                            $q->orWhereNotNull('tanim_departmants.' . $columnName);
                                            break;
                                        default:
                                            $q->orWhere('tanim_departmants.' . $columnName, $value);
                                    }
                                }
                            }
                            if ($hasNull) {
                                $q->orWhereNull('tanim_departmants.' . $columnName);
                            }
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
                if (str_starts_with($columnName, 'univercity.')) {
                    $field = explode('.', $columnName)[1];
                    $query->orderBy("tanim_univercities.{$field}", $orderDir);
                } elseif (str_starts_with($columnName, 'faculty.')) {
                    $field = explode('.', $columnName)[1];
                    $query->orderBy("tanim_faculties.{$field}", $orderDir);
                } else {
                    $query->orderBy("tanim_departmants.{$columnName}", $orderDir);
                }
            } else {
                $query->orderBy('tanim_departmants.id', 'asc');
            }
        } else {
            $query->orderBy('tanim_departmants.id', 'asc');
        }

        // Sayfalama
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $totalRecords = TanimDepartmant::count();
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



    private function getTableColumns()
    {
        $visibleColumns = [
            'univercity.code',
            'univercity.name',
            'univercity.type',
            'univercity.city',
            'faculty.code',
            'faculty.name',
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
                if (Schema::hasColumn('tanim_departmants', $column)) {
                    $type = Schema::getColumnType('tanim_departmants', $column);
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
            case 'faculty.code':
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
    private function checkgradetype()
    {
        try {
            if (Schema::hasColumn('tanim_departmants', 'grade_type')) {
                // Sütun bilgilerini al
                $columnInfo = DB::select("SHOW COLUMNS FROM tanim_departmants WHERE Field = 'grade_type'")[0];

                // Eğer sütun NULL değilse, nullable yap
                if ($columnInfo->Null === 'NO') {
                    Schema::table('tanim_departmants', function ($table) {
                        $table->string('grade_type')->nullable()->change();
                    });
                }
            } else {
                // Sütun yoksa oluştur
                Schema::table('tanim_departmants', function ($table) {
                    $table->string('grade_type')->nullable();
                });
            }
        } catch (\Exception $e) {
            \Log::error('Grade type sütun kontrolünde hata: ' . $e->getMessage());
        }
    }
    public function DepartmantTopluSil(Request $request){
        $bursDurum = $request->bursDurum;
        $islemid = $request->islemId;
        $datas = $request->ids;

        if($islemid == '1'){
            $result = TanimDepartmant::whereIn('id',$datas)->delete();
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
                $item = TanimDepartmant::find($data);
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
            $userIds = TanimDepartmant::pluck('id')->toArray();
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
                'Bölüm Kodu',
                'Bölüm Adı',
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
                $data = TanimDepartmant::with(['faculty.univercity'])->find($id);
                if ($data && $data->faculty && $data->faculty->univercity) {
                    $sheet->setCellValue('A' . $row, $data->faculty->univercity->code);
                    $sheet->setCellValue('B' . $row, $data->faculty->univercity->name);
                    $sheet->setCellValue('C' . $row, $data->faculty->univercity->type);
                    $sheet->setCellValue('D' . $row, $data->faculty->univercity->city);
                    $sheet->setCellValue('E' . $row, $data->faculty->code);
                    $sheet->setCellValue('F' . $row, $data->faculty->name);
                    $sheet->setCellValue('G' . $row, $data->code);
                    $sheet->setCellValue('H' . $row, $data->name);
                    $sheet->setCellValue('I' . $row, $data->bv_onlisans ? 'Evet' : 'Hayır');
                    $sheet->setCellValue('J' . $row, $data->bv_lisans ? 'Evet' : 'Hayır');
                    $sheet->setCellValue('K' . $row, $data->bv_yukseklisans ? 'Evet' : 'Hayır');
                    $sheet->setCellValue('L' . $row, $data->bv_doktora ? 'Evet' : 'Hayır');
                    $row++;
                }
            }

            // Excel dosyasını oluştur
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Bolumler' . time() . '.xlsx';
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
}
