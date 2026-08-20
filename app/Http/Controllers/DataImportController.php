<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataImport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FilterController;
use App\Models\Scholar;
use App\Models\ScholarForm;
use App\Models\NewAnswer;
use App\Models\ActiveAnswer;
use Illuminate\Support\Facades\Hash;



class DataImportController extends Controller
{
   public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
        $this->Vfolder = 'panel.settings.data-import';
    }
    public function index()
    {
        session(['sidebar' => 33]);

        $data_imports = DataImport::orderBy('id','desc')->get();
        $checkboxColumns = [];
        $columns = $this->getTableColumns();
        $columns['file_name']['title'] = 'Dosya Adı';
        $columns['id']['title'] = 'No';
        $columns['total_record']['title'] = 'Kişi Sayısı';
        $columns['success_record']['title'] = 'Eklenen Kişi ';
        $columns['error_record']['title'] = 'Eklenemeyen Kişi ';
        $columns['created_at']['title'] = 'Oluşturulma Tarihi';
        $result = [
            'data_imports' => $data_imports,
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns
        ];
        return view($this->Vfolder.'.index',$result);
    }
    public function create()
    {
        return view($this->Vfolder.'.create');
    }

    public function deleteBulk(Request $request)
    {
        try {
            $idler = $request->input('idler');
             // 'on' değerlerini filtrele
            $idler = array_filter($idler, function($id) {
                return $id !== 'on';
            });
            // Toplu silme işlemi
            DataImport::whereIn('id', $idler)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kayıtlar başarıyla silindi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Silme işlemi sırasında bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
    public function delete($id)
    {
        $data_import = DataImport::find($id);
        $data_import->delete();
        return redirect()->route('data-import.index')->with('success', 'Kayıt başarıyla silindi');
    }
    public function details($id)
    {
        $data_import = DataImport::find($id);
        return view($this->Vfolder.'.details',compact('data_import'));
    }

    private function logImportActivity($dataImportId, $status, $data = null, $description = null, $rowNumber = null)
    {
        try {
            \App\Models\DataImportLog::create([
                'data_import_id' => $dataImportId,
                'status' => $status,
                'data' => $data ? json_encode($data, JSON_UNESCAPED_UNICODE) : null,
                'description' => $description,
                'row_number' => $rowNumber
            ]);
        } catch (\Exception $e) {
            \Log::error('Log kaydı oluşturulurken hata: ' . $e->getMessage());
        }
    }

    public function getData(Request $request)
    {
        $query = DataImport::query();
        $columns = $this->getTableColumns();

        $totalRecords = $query->count();
        // Sayfalama parametreleri
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = $request->input('draw', 1);

        // Toplam kayıt sayısı
        // Filtreleri uygula
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

        $query->orderBy('id','desc');

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
            'id',
            'file_name',
            'total_record',
            'success_record',
            'error_record',
            'created_at',
        ];

        // Member modelinin tüm sütunlarını al
        $allColumns = \Schema::getColumnListing('data_import');

        // visibleColumns'ı allColumns'dan çıkart
        $hiddenColumns = array_diff($allColumns, $visibleColumns);

        $columns = Schema::getColumnListing('data_import');
        $columnDetails = [];

        foreach ($columns as $column) {
            // Eğer sütun gizlenecekler listesinde değilse ekle
            if (!in_array($column, $hiddenColumns)) {
                $type = Schema::getColumnType('data_import', $column);
                $title = Str::title(str_replace('_', ' ', $column));

                $columnDetails[$column] = [
                    'name' => $column,
                    'title' => $title,
                    'type' => $type,
                    'visible' => true,
                    'filterable' => true,
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


        if ($column === 'aday_turu') {
            $values= ['Dernek','Vakıf','Boş'];
            return $values;
        }

        if ($column === 'educationType') {
            $values= ['İlkokul','Ortaokul','Lise','Ön lisans','Lisans','Yüksek Lisans','Doktora'];
            return $values;
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
            $values= ['Tamamlanmadı','Onay Bekliyor','İade Edildi','Onaylandı','Red Edildi','İade Döndü'];

            return $values;
        }
        if ($column === 'mulakat_durumu') {
            $values= ['Mülakat Yapılacak','Planlandı','Olumlu','Olumsuz'];
            return $values;
        }

        return $options[$this->getFilterType($type)] ?? $options['text'];
    }
    private function getFilterValue($column, $type)
    {
        if ($column === 'status') {
            $values= ['0','1','2','3','4','5'];
            return $values;
        }
        if ($column === 'educationType') {
            $values= ['ilkokul','ortaokul','lise','onlisans','lisans','ylisans','doktora'];
            return $values;
        }
        if ($column === 'aday_turu') {
            $values= ['Dernek','Vakıf','null'];
            return $values;
        }
        if ($column === 'mulakat_durumu') {
            $values= ['Mülakat Yapılacak','Planlandı','Olumlu','Olumsuz'];
            return $values;
        }
        return null;
    }
    public function upload(Request $request)
    {
        try {
            if (!$request->hasFile('file')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dosya yüklenemedi'
                ]);
            }

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $originalName = $file->getClientOriginalName();

            if (!in_array($extension, ['xlsx', 'xls'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sadece Excel dosyaları (.xlsx, .xls) yüklenebilir'
                ]);
            }

            $dataImport = new \App\Models\DataImport();
            $dataImport->original_name = $originalName;
            $dataImport->file_name = time() . '_' . $originalName;
            $dataImport->status = 'Devam Ediyor';
            $dataImport->total_record = 0;
            $dataImport->success_record = 0;
            $dataImport->error_record = 0;
            $dataImport->save();

            $file->storeAs('public', $dataImport->file_name);

            return response()->json([
                'success' => true,
                'message' => 'Dosya başarıyla yüklendi',
                'data' => [
                    'id' => $dataImport->id,
                    'file_name' => $dataImport->file_name,
                    'original_name' => $dataImport->original_name
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Dosya yükleme hatası: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Dosya yüklenirken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }

    public function getExcelHeaders(Request $request)
    {
        try {
            $filePath = storage_path('app/public/' . $request->file);

            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dosya bulunamadı'
                ]);
            }

            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $headers = [];

            // İlk satırı başlık olarak al
            foreach ($worksheet->getRowIterator(1, 1) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $cell) {
                    if ($cell->getValue()) {
                        $headers[] = $cell->getValue();
                    }
                }
            }

            return response()->json($headers);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Excel başlıkları okunurken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }

    public function getDbColumns(Request $request)
    {
        try {
            $type = $request->type;
            $columns = [];
            switch ($type) {
                case 'Aday Bursiyerler':
                    $columns = $this->getAdayBursiyerColumns();
                    break;
                case 'Bursiyerler':
                    $columns = $this->getBursiyerColumns();
                    break;
                case 'Kayıt Yenileme':
                    $columns = $this->getKayitYenilemeColumns();
                    break;
                case 'Mezunlar':
                    $columns = $this->getBursiyerColumns();
                    break;
                case 'Universite':
                    $columns = $this->getUniversiteColumns();
                    break;
                case 'Fakulte':
                    $columns = $this->getFakulteColumns();
                    break;
                case 'Bolumler':
                    $columns = $this->getBolumColumns();
                    break;
            }

            return response()->json($columns);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Veritabanı sütunları alınırken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }
    private function getAdayBursiyerColumns(){

        $columns[] = [
            'name' => 'Başvuru No',
            'db_key' => 'id'
        ];

        $columns[] = [
            'name' => 'Ad',
            'db_key' => 'name'
        ];

        $columns[] = [
            'name' => 'Soyad',
            'db_key' => 'surname'
        ];

        $columns[] = [
            'name' => 'E-posta',
            'db_key' => 'email'
        ];

        $columns[] = [
            'name' => 'Cep Telefonu',
            'db_key' => 'tel_no'
        ];

        $columns[] = [
            'name' => 'Basvuru Durumu',
            'db_key' => 'status'
        ];

        // Soru modelinden db_key'leri al
        $questions = \App\Models\Soru::select('name', 'db_key')
            ->whereIn('db_key', function($query) {
                $query->select(\DB::raw('DISTINCT COLUMN_NAME COLLATE utf8_turkish_ci'))
                    ->from('INFORMATION_SCHEMA.COLUMNS')
                    ->where('TABLE_NAME', '=', 'new_answers');
            })
            ->where('db_key', 'NOT LIKE', 'doc_%')
            ->orderBy('name', 'asc')
            ->get();

        foreach ($questions as $question) {
            $columns[] = [
                'name' => $question->name,
                'db_key' => $question->db_key,
            ];
        }
        return $columns;
    }

    private function getKayitYenilemeColumns(){

        $columns[] = [
            'name' => 'Başvuru No',
            'db_key' => 'id'
        ];

        $columns[] = [
            'name' => 'Ad',
            'db_key' => 'name'
        ];

        $columns[] = [
            'name' => 'Soyad',
            'db_key' => 'surname'
        ];

        $columns[] = [
            'name' => 'E-posta',
            'db_key' => 'email'
        ];

        $columns[] = [
            'name' => 'Cep Telefonu',
            'db_key' => 'tel_no'
        ];

        $columns[] = [
            'name' => 'Başvuru Durumu',
            'db_key' => 'status'
        ];

        // Soru modelinden db_key'leri al
        $questions = \App\Models\Soru::select('name', 'db_key')
            ->whereIn('db_key', function($query) {
                $query->select(\DB::raw('DISTINCT COLUMN_NAME COLLATE utf8_turkish_ci'))
                    ->from('INFORMATION_SCHEMA.COLUMNS')
                    ->where('TABLE_NAME', '=', 'renew_answers');
            })
            ->where('db_key', 'NOT LIKE', 'doc_%')
            ->orderBy('name', 'asc')
            ->get();

        foreach ($questions as $question) {
            $columns[] = [
                'name' => $question->name,
                'db_key' => $question->db_key,
            ];
        }
        return $columns;
    }
    private function getBursiyerColumns(){

        $columns[] = [
            'name' => 'Başvuru No',
            'db_key' => 'aday_id'
        ];

        $columns[] = [
            'name' => 'Ad',
            'db_key' => 'name'
        ];

        $columns[] = [
            'name' => 'Soyad',
            'db_key' => 'surname'
        ];

        $columns[] = [
            'name' => 'E-posta',
            'db_key' => 'email'
        ];

        $columns[] = [
            'name' => 'Cep Telefonu',
            'db_key' => 'tel_no'
        ];

        $columns[] = [
            'name' => 'Basvuru Durumu',
            'db_key' => 'status'
        ];
$columns[] = [
            'name' => 'Öğrenim Türü',
            'db_key' => 'educationType'
        ];
        $columns[] = [
            'name' => 'Bursiyer Tipi',
            'db_key' => 'aday_turu'
        ];
        // Soru modelinden db_key'leri al
        $questions = \App\Models\Soru::select('name', 'db_key')
            ->whereIn('db_key', function($query) {
                $query->select(\DB::raw('DISTINCT COLUMN_NAME COLLATE utf8_turkish_ci'))
                    ->from('INFORMATION_SCHEMA.COLUMNS')
                    ->where('TABLE_NAME', '=', 'active_answers');
            })
            ->where('db_key', 'NOT LIKE', 'doc_%')
            ->orderBy('name', 'asc')
            ->get();

        foreach ($questions as $question) {
            $columns[] = [
                'name' => $question->name,
                'db_key' => $question->db_key,
            ];
        }
        return $columns;
    }
    private function getFakulteColumns(){

        $columns = [

            [
                'name' => 'Üniversite Adı',
                'db_key' => 'uni_name'
            ],

            [
                'name' => 'Fakülte Kodu',
                'db_key' => 'code'
            ],
            [
                'name' => 'Fakülte Adı',
                'db_key' => 'name'
            ],
            [
                'name' => 'B.V Ön Lisans',
                'db_key' => 'bv_onlisans'
            ],
            [
                'name' => 'B.V Lisans',
                'db_key' => 'bv_lisans'
            ],
            [
                'name' => 'B.V Yüksek Lisans',
                'db_key' => 'bv_yukseklisans'
            ],
            [
                'name' => 'B.V Doktora',
                'db_key' => 'bv_doktora'
            ]
        ];
        return $columns;
    }
    private function getUniversiteColumns(){

        $columns = [
            [
                'name' => 'Üniversite Kodu',
                'db_key' => 'code'
            ],
            [
                'name' => 'Üniversite Adı',
                'db_key' => 'name'
            ],
            [
                'name' => 'Üniversite Türü',
                'db_key' => 'type'
            ],
            [
                'name' => 'Üniversite Şehri',
                'db_key' => 'city'
            ],
            [
                'name' => 'B.V Ön Lisans',
                'db_key' => 'bv_onlisans'
            ],
            [
                'name' => 'B.V Lisans',
                'db_key' => 'bv_lisans'
            ],
            [
                'name' => 'B.V Yüksek Lisans',
                'db_key' => 'bv_yukseklisans'
            ],
            [
                'name' => 'B.V Doktora',
                'db_key' => 'bv_doktora'
            ]
        ];
        return $columns;
    }
    private function getBolumColumns(){

        $columns = [
            [
                'name' => 'Üniversite Adı',
                'db_key' => 'uni_name'
            ],
            [
                'name' => 'Fakülte Adı',
                'db_key' => 'fak_name'
            ],
            [
                'name' => 'Bölüm Kodu',
                'db_key' => 'code'
            ],
            [
                'name' => 'Bölüm Adı',
                'db_key' => 'name'
            ],
            [
                'name' => 'B.V Ön Lisans',
                'db_key' => 'bv_onlisans'
            ],
            [
                'name' => 'B.V Lisans',
                'db_key' => 'bv_lisans'
            ],
            [
                'name' => 'B.V Yüksek Lisans',
                'db_key' => 'bv_yukseklisans'
            ],
            [
                'name' => 'B.V Doktora',
                'db_key' => 'bv_doktora'
            ]
        ];
        return $columns;
    }


    public function processImport(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|string',
                'mappings' => 'required|array',
                'import_id' => 'required|integer'
            ]);

            $dataImport = \App\Models\DataImport::findOrFail($request->import_id);

            if (!$dataImport) {
                throw new \Exception('Import kaydı bulunamadı');
            }

            if (!Storage::exists('public/' . $dataImport->file_name)) {
                throw new \Exception('Dosya bulunamadı');
            }

            $dataImport->type = $request->type;
            $dataImport->status = 'processing';
            $dataImport->save();

            $result = match ($request->type) {
                'Aday Bursiyerler' => $this->adayBursiyerImport($request->mappings, $dataImport),
                'Bursiyerler' => $this->bursiyerImport($request->mappings, $dataImport, 'Bursiyerler'),
                'Kayıt Yenileme' => $this->kayitYenilemeImport($request->mappings, $dataImport),
                'Mezunlar' => $this->bursiyerImport($request->mappings, $dataImport, 'Mezunlar'),
                'Universite' => $this->universiteImport($request->mappings, $dataImport),
                'Fakulte' => $this->fakulteImport($request->mappings, $dataImport),
                'Bolumler' => $this->bolumImport($request->mappings, $dataImport),
                default => throw new \Exception('Geçersiz import tipi'),
            };

            return response()->json([
                'success' => true,
                'message' => 'İşlem tamamlandı',
                'data' => [
                    'total' => $dataImport->total_record,
                    'success' => $dataImport->success_record,
                    'error' => $dataImport->error_record,
                    'status' => $dataImport->status,
                    'type' => $dataImport->type
                ]
            ]);

        } catch (\Exception $e) {
            if (isset($dataImport)) {
                $dataImport->status = 'failed';
                $dataImport->save();
            }
            return response()->json([
                'success' => false,
                'message' => 'İşlem sırasında bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    private function strToUpperTr($string)
    {
        $string = str_replace(array('i', 'ı'), array('İ', 'I'), $string);
        return mb_convert_case($string, MB_CASE_UPPER, 'UTF-8');
    }

    private function formatErrorMessage($e, $rowData)
    {
        $message = $e->getMessage();

        // Boş alan hatası
        if (strpos($message, "Field") !== false && strpos($message, "doesn't have a default value") !== false) {
            preg_match("/Field '(.+)' doesn't/", $message, $matches);
            $field = $matches[1] ?? '';
            $fieldNames = [
                'tel_no' => 'Telefon Numarası',
                'tc_no' => 'T.C Kimlik No.',
                'name' => 'Ad',
                'surname' => 'Soyad',
                'email' => 'E-posta',
                'status' => 'Durum'
                // Diğer alan isimleri buraya eklenebilir
            ];
            $fieldName = $fieldNames[$field] ?? $field;
            return "$fieldName alanı boş bırakılamaz.";
        }

        // Mükerrer kayıt hatası
        if (strpos($message, 'Duplicate entry') !== false && strpos($message, 'PRIMARY') !== false) {
            preg_match("/Duplicate entry '(.+)' for key/", $message, $matches);
            $id = $matches[1] ?? '';
            return "Bu ID ($id) ile daha önce kayıt yapılmış.";
        }

        // Veri tipi/format hataları
        if (strpos($message, 'Data too long') !== false) {
            preg_match("/column '(.+)' at/", $message, $matches);
            $field = $matches[1] ?? '';
            $fieldNames = [
                'tel_no' => 'Telefon Numarası',
                'tc_no' => 'T.C Kimlik No.',
                'name' => 'Ad',
                'surname' => 'Soyad',
                'email' => 'E-posta',
                'status' => 'Durum'
                // Diğer alan isimleri buraya eklenebilir
            ];
            $fieldName = $fieldNames[$field] ?? $field;
            return "$fieldName alanı için girilen veri çok uzun. Lütfen karakter sınırını kontrol edin.";
        }

        if (strpos($message, 'Incorrect integer value') !== false) {
            preg_match("/column '(.+)'/", $message, $matches);
            $field = $matches[1] ?? '';
            $fieldNames = [
                'tel_no' => 'Telefon Numarası',
                'tc_no' => 'T.C Kimlik No.',
                'status' => 'Durum'
                // Sayısal alan isimleri buraya eklenebilir
            ];
            $fieldName = $fieldNames[$field] ?? $field;
            return "$fieldName alanı için geçersiz sayısal değer girilmiş.";
        }

        // TC Kimlik kontrolü
        if (isset($rowData['tc_no']) && (!is_numeric($rowData['tc_no']) || strlen($rowData['tc_no']) !== 11)) {
            return "TC Kimlik numarası 11 haneli sayısal değer olmalıdır.";
        }

        // Telefon format kontrolü
        if (isset($rowData['tel_no']) && !preg_match('/^[0-9\s-]+$/', $rowData['tel_no'])) {
            return "Telefon numarası geçersiz format içeriyor.";
        }

        // Genel hata mesajı
        return "Veri eklenirken bir hata oluştu: " . $message;
    }

    private function adayBursiyerImport($mappings, $dataImport)
    {
        try {
            $filePath = storage_path('app/public/' . $dataImport->file_name);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $headerRow = [];
            foreach ($worksheet->getRowIterator(1, 1) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    $headerRow[] = $cell->getValue();
                }
            }

            $totalRows = 0;
            $successRows = 0;
            $errorRows = 0;

            $rows = $worksheet->getRowIterator(2);

            foreach ($rows as $row) {
                $totalRows++;
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $columnIndex = 0;
                foreach ($cellIterator as $cell) {
                    $excelColumnHeader = $headerRow[$columnIndex];
                    foreach ($mappings as $mapping) {
                        if ($mapping['excel_column'] === $excelColumnHeader) {
                            $rowData[$mapping['db_column']] = $cell->getValue();
                        }
                    }
                    $columnIndex++;
                }
                switch ($rowData['status']) {
                    case 'Devam Ediyor':
                        $rowData['status'] = 0;
                        break;
                    case 'Onay Bekliyor':
                        $rowData['status'] = 1;
                        break;
                    case 'İade Edildi':
                        $rowData['status'] = 2;
                        break;
                    case 'Onaylandı':
                        $rowData['status'] = 3;
                        break;
                    case 'Red Edildi':
                        $rowData['status'] = 4;
                        break;
                    case 'İade Döndü':
                        $rowData['status'] = 5;
                        break;
                }
                try {
                    $period = \App\Models\Period::where('type', 0)->orderBy('id', 'desc')->first();
                    $newAnswer = new \App\Models\NewAnswer();
                    foreach ($rowData as $key => $value) {
                        $newAnswer->$key = $value;
                    }
                    $newAnswer->period_id = $period->id;
                    $newAnswer->save();

                    $successRows++;

                    $this->logImportActivity(
                        $dataImport->id,
                        'Başarılı',
                        $rowData,
                        'Kayıt başarıyla eklendi',
                        $totalRows + 1
                    );

                } catch (\Exception $e) {
                    $errorRows++;

                    $errorMessage = $this->formatErrorMessage($e, $rowData);

                    $this->logImportActivity(
                        $dataImport->id,
                        'Hata',
                        $rowData,
                        $errorMessage,
                        $totalRows + 1
                    );
                }
            }

            $dataImport->total_record = $totalRows;
            $dataImport->success_record = $successRows;
            $dataImport->error_record = $errorRows;
            $dataImport->status = 'Tamamlandı';
            $dataImport->save();

            return true;

        } catch (\Exception $e) {
            $dataImport->status = 'Hatalı İşlem';
            $dataImport->save();

            $this->logImportActivity(
                $dataImport->id,
                'Hata',
                null,
                'Genel Hata: ' . $this->formatErrorMessage($e, [])
            );

            throw $e;
        }
    }
private function bursiyerImport($mappings, $dataImport, $type)
    {
        try {
            \Log::info('bursiyerImport: Başlatıldı', [
                'type' => $type,
                'data_import_id' => $dataImport->id,
                'mappings' => $mappings
            ]);

            $filePath = storage_path('app/public/' . $dataImport->file_name);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $headerRow = [];
            foreach ($worksheet->getRowIterator(1, 1) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    $headerRow[] = $cell->getValue();
                }
            }

            \Log::info('bursiyerImport: Okunan Başlıklar (headerRow)', [
                'headers' => $headerRow
            ]);

            $totalRows = 0;
            $successRows = 0;
            $errorRows = 0;

            $rows = $worksheet->getRowIterator(2);

            foreach ($rows as $row) {
                $totalRows++;
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                // Satır numarasını al
                $rowIndex = $row->getRowIndex();

                // 1. Excel'deki verileri mapping tanımlarına göre dinamik olarak oku
                $rowData = [];
                $columnIndex = 0;
                foreach ($cellIterator as $cell) {
                    $excelColumnHeader = isset($headerRow[$columnIndex]) ? $headerRow[$columnIndex] : null;
                    if ($excelColumnHeader !== null) {
                        foreach ($mappings as $mapping) {
                            if ($mapping['excel_column'] === $excelColumnHeader) {
                                $cellValue = $cell->getValue();
                                $rowData[$mapping['db_column']] = ($cellValue !== null) ? trim($cellValue) : null;
                            }
                        }
                    }
                    $columnIndex++;
                }

                // 2. Gerekli alanların varlık ve boşluk kontrolü
                $requiredFields = ['name', 'surname', 'email', 'tel_no', 'tc_no'];
                $fieldNames = [
                    'name' => 'Ad',
                    'surname' => 'Soyad',
                    'email' => 'E-posta',
                    'tel_no' => 'Cep Telefonu',
                    'tc_no' => 'TC No'
                ];

                foreach ($requiredFields as $field) {
                    $value = isset($rowData[$field]) ? $rowData[$field] : null;
                    if ($value === null || $value === '' || $value === '-') {
                        $errorRows++;
                        $this->logImportActivity(
                            $dataImport->id,
                            'Hata',
                            $rowData,
                            ($fieldNames[$field] ?? $field) . ' alanı boş olamaz',
                            $totalRows + 1
                        );
                        continue 2; // Dış döngüye devam et
                    }
                }

                // 3. Dönem (period) ve form durumlarını belirle
                if ($type == 'Bursiyerler') {
                    $period = \App\Models\Period::where('type', 0)->orderBy('id', 'desc')->first();
                    $formStatus = 3;
                    $status = 1;
                } else {
                    $period = \App\Models\Period::where('type', 1)->orderBy('id', 'desc')->first();
                    $formStatus = 2;
                    $status = 3;
                }

                // 4. Mükerrer kayıt kontrolü (Veritabanında TC No veya Email var mı?)
                $bursiyerCheck = \App\Models\Scholar::where('tc_no', $rowData['tc_no'])
                    ->orWhere('email', $rowData['email'])
                    ->first();

                if ($bursiyerCheck) {
                    $errorRows++;
                    $this->logImportActivity(
                        $dataImport->id,
                        'Hata',
                        $rowData,
                        'Bu T.C Kimlik No. veya E-posta ile zaten kayıtlı',
                        $totalRows + 1
                    );
                    continue;
                }

                try {
                    \DB::beginTransaction();

                    // Scholar kaydı
                    $bursiyer = new \App\Models\Scholar();
                    $bursiyer->name = $rowData['name'];
                    $bursiyer->surname = $rowData['surname'];
                    $bursiyer->email = $rowData['email'];
                    $bursiyer->tel_no = $rowData['tel_no'];
                    $bursiyer->tc_no = $rowData['tc_no'];
                    $bursiyer->aday_id = isset($rowData['aday_id']) ? $rowData['aday_id'] : null;
                    $bursiyer->password = 1;
                    $bursiyer->status = $status;
                    $bursiyer->save();

                    $period = \App\Models\Period::where('type', 0)->orderBy('id', 'desc')->first();
                    
                    // ScholarForm kaydı
                    $scholarForm = new \App\Models\ScholarForm();
                    $scholarForm->scholar_id = $bursiyer->id;
                    $scholarForm->status = $formStatus;
                    $scholarForm->period_id = $period->id;
                    $scholarForm->save();

                    // ActiveAnswer kaydı
                    $newAnswer = new \App\Models\ActiveAnswer();
                    $newAnswer->form_id = $scholarForm->id;
                    $newAnswer->password = 1;

                    // Excel'den gelen tüm verileri aktar
                    foreach ($mappings as $mapping) {
                        $excelColumn = $mapping['excel_column'];
                        $dbColumn = $mapping['db_column'];

                        // Excel'den değeri al
                        $columnLetter = array_search($excelColumn, $headerRow);
                        if ($columnLetter !== false) {
                            $value = trim($worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnLetter + 1) . $rowIndex)->getValue());
                            if ($value !== null && $value !== '-' && trim($value) !== '') {
                                $newAnswer->$dbColumn = $value;
                            }
                        }
                    }

                    // Status değerini kontrol et ve güncelle
                    $statusMap = [
                        'Devam Ediyor' => 0,
                        'Onay Bekliyor' => 1,
                        'İade Edildi' => 2,
                        'Onaylandı' => 3,
                        'Red Edildi' => 4,
                        'İade Döndü' => 5
                    ];

                    if (isset($statusMap[$newAnswer->status])) {
                        $newAnswer->status = $statusMap[$newAnswer->status];
                    }
                    $newAnswer->period_id = $period->id;
                    $newAnswer->save();
                    \DB::commit();

                    $successRows++;

                    $this->logImportActivity(
                        $dataImport->id,
                        'Başarılı',
                        $rowData,
                        'Kayıt başarıyla eklendi',
                        $totalRows + 1
                    );

                } catch (\Throwable $e) {
                    \DB::rollBack();
                    $errorRows++;

                    $errorMessage = $this->formatErrorMessage($e, $rowData);

                    $this->logImportActivity(
                        $dataImport->id,
                        'Hata',
                        $rowData,
                        $errorMessage,
                        $totalRows + 1
                    );
                }
            }

            $dataImport->total_record = $totalRows;
            $dataImport->success_record = $successRows;
            $dataImport->error_record = $errorRows;
            $dataImport->status = 'Tamamlandı';
            $dataImport->save();

            return true;

        } catch (\Throwable $e) {
            $dataImport->status = 'Hatalı İşlem';
            $dataImport->save();

            $this->logImportActivity(
                $dataImport->id,
                'Hata',
                null,
                'Genel Hata: ' . $this->formatErrorMessage($e, [])
            );

            throw $e;
        }
    }
    private function kayitYenilemeImport($mappings, $dataImport)
    {
        try {
            $filePath = storage_path('app/public/' . $dataImport->file_name);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $headerRow = [];
            foreach ($worksheet->getRowIterator(1, 1) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    $headerRow[] = $cell->getValue();
                }
            }

            $totalRows = 0;
            $successRows = 0;
            $errorRows = 0;

            $rows = $worksheet->getRowIterator(2);
            foreach ($rows as $row) {
                $totalRows++;
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $columnIndex = 0;
                foreach ($cellIterator as $cell) {
                    $excelColumnHeader = $headerRow[$columnIndex];
                    foreach ($mappings as $mapping) {
                        if ($mapping['excel_column'] === $excelColumnHeader) {
                            $rowData[$mapping['db_column']] = $cell->getValue();
                        }
                    }
                    $columnIndex++;
                }
                // Debug için rowData kontrolü
                \Log::info('Row Data:', $rowData);
                $bursiyerCheck = \App\Models\Scholar::where('tc_no', $rowData['tc_no'])->orWhere('email', $rowData['email'])->first();
                \Log::info('Bursiyer Check:', ['bursiyer' => $bursiyerCheck]);

                if($bursiyerCheck){
                    $formCheck  = \App\Models\RenewForm::where('scholar_id', $bursiyerCheck->id)->first();
                    $bursiyer = $bursiyerCheck;
                    \Log::info('Form Check:', ['form' => $formCheck]);
                }

                if($bursiyerCheck  && $formCheck){
                    $bursiyer = $bursiyerCheck;
                    $errorRows++;
                    $this->logImportActivity(
                        $dataImport->id,
                        'Hata',
                        $rowData,
                        'Bu T.C Kimlik No. veya E-posta ile zaten kayit yenileme kaydı bulunmaktadır',
                        $totalRows + 1
                    );
                    continue;
                }
                switch ($rowData['status']) {

                    case 'Onay Bekliyor':
                        $rowData['status'] = 0;
                        break;
                    case 'İade Edildi':
                        $rowData['status'] = 3;
                        break;
                    case 'Onaylandı':
                        $rowData['status'] = 1;
                        break;
                    case 'Red Edildi':
                        $rowData['status'] = 2;
                        break;
                    case 'İade Döndü':
                        $rowData['status'] = 4;
                        break;
                }

                if(!$bursiyerCheck){
                    $bursiyer = new \App\Models\Scholar();
                    $bursiyer->name = $rowData['name'];
                    $bursiyer->surname = $rowData['surname'];
                    $bursiyer->email = $rowData['email'];
                    $bursiyer->tel_no = $rowData['tel_no'];
                    $bursiyer->tc_no = $rowData['tc_no'];
                    $randomStr = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                    $bursiyer->password = 1;
                    $bursiyer->status = 2;
                    try {
                        $bursiyer->save();

                        \Log::info('New Scholar Created:', ['scholar' => $bursiyer]);
                    } catch (\Exception $e) {
                        \Log::error('Scholar Creation Error:', ['error' => $e->getMessage()]);
                        throw $e;
                    }
                }

                $period = \App\Models\Period::where('type', 1)->orderBy('id', 'desc')->first();
                $formStatus = 2;
                $status = 3;
                try {
                    $scholarForm = new \App\Models\RenewForm();
                    $scholarForm->scholar_id = $bursiyer->id;
                    $scholarForm->status = $formStatus ?? 1; // formStatus tanımlı değilse 1 olarak ayarla
                    $scholarForm->period_id = $period->id ?? 1; // period tanımlı değilse 1 olarak ayarla
                    $scholarForm->save();

                    \Log::info('New Form Created:', ['form' => $scholarForm]);
                } catch (\Exception $e) {
                    \Log::error('Form Creation Error:', ['error' => $e->getMessage()]);
                    throw $e;
                }

                try {
                    $newAnswer = new \App\Models\RenewAnswer();
                    foreach ($rowData as $key => $value) {
                        $newAnswer->$key = $value;
                    }
                    switch($newAnswer->status){
                        case 'Devam Ediyor':
                            $newAnswer->status = 0;
                            break;
                        case 'Onay Bekliyor':
                            $newAnswer->status = 1;
                            break;
                        case 'İade Edildi':
                            $newAnswer->status = 2;
                            break;
                        case 'Onaylandı':
                            $newAnswer->status = 3;
                            break;
                        case 'Red Edildi':
                            $newAnswer->status = 4;
                            break;
                        case 'İade Döndü':
                            $newAnswer->status = 5;
                            break;
                    }
                    $newAnswer->form_id = $scholarForm->id;
                    $newAnswer->password = 1;
                    $newAnswer->save();
                    $successRows++;

                    $this->logImportActivity(
                        $dataImport->id,
                        'Başarılı',
                        $rowData,
                        'Kayıt başarıyla eklendi',
                        $totalRows + 1
                    );

                } catch (\Exception $e) {
                    $errorRows++;

                    $errorMessage = $this->formatErrorMessage($e, $rowData);

                    $this->logImportActivity(
                        $dataImport->id,
                        'Hata',
                        $rowData,
                        $errorMessage,
                        $totalRows + 1
                    );
                }
            }

            $dataImport->total_record = $totalRows;
            $dataImport->success_record = $successRows;
            $dataImport->error_record = $errorRows;
            $dataImport->status = 'Tamamlandı';
            $dataImport->save();

            return true;

        } catch (\Exception $e) {
            $dataImport->status = 'Hatalı İşlem';
            $dataImport->save();

            $this->logImportActivity(
                $dataImport->id,
                'Hata',
                null,
                'Genel Hata: ' . $this->formatErrorMessage($e, [])
            );

            throw $e;
        }
    }
    private function universiteImport($mappings, $dataImport)
    {
        try {
            $filePath = storage_path('app/public/' . $dataImport->file_name);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $headerRow = [];
            foreach ($worksheet->getRowIterator(1, 1) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    $headerRow[] = $cell->getValue();
                }
            }

            $totalRows = 0;
            $successRows = 0;
            $errorRows = 0;
            $rows = $worksheet->getRowIterator(2);
            foreach ($rows as $row) {
                $totalRows++;
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $columnIndex = 0;
                foreach ($cellIterator as $cell) {
                    $excelColumnHeader = $headerRow[$columnIndex];
                    foreach ($mappings as $mapping) {
                        if ($mapping['excel_column'] === $excelColumnHeader) {
                            $rowData[$mapping['db_column']] = $cell->getValue();
                        }
                    }
                    $columnIndex++;
                }
                // Debug için rowData kontrolü
                \Log::info('Row Data:', $rowData);
                $uniNameUpper = $this->strToUpperTr(trim($rowData['name']));
                $uniCheck = \App\Models\TanimUnivercity::whereRaw('UPPER(name) = ?', [$uniNameUpper])->first();
                \Log::info('Üniversite Check:', ['uni' => $uniCheck]);

                if($uniCheck){
                    $uni = $uniCheck;
                    $errorRows++;
                    $this->logImportActivity(
                        $dataImport->id,
                        'Hata',
                        $rowData,
                        'Bu Isimle Üniversite zaten kayıtlıdır',
                        $totalRows + 1
                    );
                    continue;
                }


                if(!$uniCheck){
                    $uni = new \App\Models\TanimUnivercity();
                    $uni->name = $uniNameUpper ?? 'Belirtilmedi';
                    $uni->code = $rowData['code'] ?? 'Belirtilmedi';
                    $uni->city = $rowData['city'] ?? 'Belirtilmedi';
                    $uni->type = $rowData['type'] ?? 'Belirtilmedi';
                    $uni->bv_onlisans = isset($rowData['bv_onlisans']) ? (($rowData['bv_onlisans'] === 'Evet') ? 1 : 0) : 0;
                    $uni->bv_lisans = isset($rowData['bv_lisans']) ? (($rowData['bv_lisans'] === 'Evet') ? 1 : 0) : 1;
                    $uni->bv_yukseklisans = isset($rowData['bv_yukseklisans']) ? (($rowData['bv_yukseklisans'] === 'Evet') ? 1 : 0) : 0;
                    $uni->bv_doktora = isset($rowData['bv_doktora']) ? (($rowData['bv_doktora'] === 'Evet') ? 1 : 0) : 0;


                    try {
                        $uni->save();
                        $successRows++;
                        $this->logImportActivity(
                            $dataImport->id,
                            'Başarılı',
                            $rowData,
                            'Kayıt başarıyla eklendi',
                            $totalRows + 1
                        );
                    } catch (\Exception $e) {
                        $errorRows++;
                        $this->logImportActivity(
                            $dataImport->id,
                            'Hata',
                            $rowData,
                            'Kayıt eklenirken bir hata oluştu',
                            $totalRows + 1
                        );
                        \Log::error('University Creation Error:', ['error' => $e->getMessage()]);
                        throw $e;
                    }
                }
            }
            $dataImport->total_record = $totalRows;
            $dataImport->success_record = $successRows;
            $dataImport->error_record = $errorRows;
            $dataImport->status = 'Tamamlandı';
            $dataImport->save();

            return true;

        } catch (\Exception $e) {
            $dataImport->status = 'Hatalı İşlem';
            $dataImport->save();

            $this->logImportActivity(
                $dataImport->id,
                'Hata',
                null,
                'Genel Hata: ' . $this->formatErrorMessage($e, [])
            );

            throw $e;
        }
    }
    private function fakulteImport($mappings, $dataImport)
    {
        try {
            $filePath = storage_path('app/public/' . $dataImport->file_name);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $headerRow = [];
            foreach ($worksheet->getRowIterator(1, 1) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    $headerRow[] = $cell->getValue();
                }
            }

            $totalRows = 0;
            $successRows = 0;
            $errorRows = 0;
            $rows = $worksheet->getRowIterator(2);
            foreach ($rows as $row) {
                $totalRows++;
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $columnIndex = 0;
                foreach ($cellIterator as $cell) {
                    $excelColumnHeader = $headerRow[$columnIndex];
                    foreach ($mappings as $mapping) {
                        if ($mapping['excel_column'] === $excelColumnHeader) {
                            $rowData[$mapping['db_column']] = $cell->getValue();
                        }
                    }
                    $columnIndex++;
                }
                // Debug için rowData kontrolü
                \Log::info('Row Data:', $rowData);

                $uniNameUpper = $this->strToUpperTr(trim($rowData['uni_name']));
                $uni = \App\Models\TanimUnivercity::whereRaw('UPPER(name) = ?', [$uniNameUpper])->first();

                if (!$uni) {
                    $uni = \App\Models\TanimUnivercity::create([
                        'name' => $uniNameUpper,
                        'code' => 'Belirtilmedi',
                        'city' => 'Belirtilmedi',
                        'type' => 'Belirtilmedi',
                        'bv_onlisans' => 0,
                        'bv_lisans' => 1,
                        'bv_yukseklisans' => 0,
                        'bv_doktora' => 0
                    ]);
                }

                $fakCheck = \App\Models\TanimFaculty::where('name', $rowData['name'])->where('univercity_id', $uni->id)->first();

                if($fakCheck){
                    $errorRows++;
                    $this->logImportActivity(
                        $dataImport->id,
                        'Hata',
                        $rowData,
                        'Bu Isimle Fakülte zaten kayıtlıdır',
                        $totalRows + 1
                    );
                    continue;
                }

                if(!$fakCheck){
                    $fak = new \App\Models\TanimFaculty();
                    $fak->name = $rowData['name'] ?? 'Belirtilmedi';
                    $fak->code = $rowData['code'] ?? 'Belirtilmedi';
                    $fak->bv_onlisans = isset($rowData['bv_onlisans']) ? (($rowData['bv_onlisans'] === 'Evet') ? 1 : 0) : 0;
                    $fak->bv_lisans = isset($rowData['bv_lisans']) ? (($rowData['bv_lisans'] === 'Evet') ? 1 : 0) : 1;
                    $fak->bv_yukseklisans = isset($rowData['bv_yukseklisans']) ? (($rowData['bv_yukseklisans'] === 'Evet') ? 1 : 0) : 0;
                    $fak->bv_doktora = isset($rowData['bv_doktora']) ? (($rowData['bv_doktora'] === 'Evet') ? 1 : 0) : 0;
                    $fak->univercity_id = $uni->id;

                    try {
                        $fak->save();
                        $successRows++;
                        $this->logImportActivity(
                            $dataImport->id,
                            'Başarılı',
                            $rowData,
                            'Kayıt başarıyla eklendi',
                            $totalRows + 1
                        );
                    } catch (\Exception $e) {
                        $errorRows++;
                        $this->logImportActivity(
                            $dataImport->id,
                            'Hata',
                            $rowData,
                            'Kayıt eklenirken bir hata oluştu',
                            $totalRows + 1
                        );
                        \Log::error('University Creation Error:', ['error' => $e->getMessage()]);
                        throw $e;
                    }
                }
            }
            $dataImport->total_record = $totalRows;
            $dataImport->success_record = $successRows;
            $dataImport->error_record = $errorRows;
            $dataImport->status = 'Tamamlandı';
            $dataImport->save();

            return true;

        } catch (\Exception $e) {
            $dataImport->status = 'Hatalı İşlem';
            $dataImport->save();

            $this->logImportActivity(
                $dataImport->id,
                'Hata',
                null,
                'Genel Hata: ' . $this->formatErrorMessage($e, [])
            );

            throw $e;
        }
    }
    private function bolumImport($mappings, $dataImport)
    {
        try {
            $filePath = storage_path('app/public/' . $dataImport->file_name);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $headerRow = [];
            foreach ($worksheet->getRowIterator(1, 1) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    $headerRow[] = $cell->getValue();
                }
            }

            $totalRows = 0;
            $successRows = 0;
            $errorRows = 0;
            $rows = $worksheet->getRowIterator(2);
            foreach ($rows as $row) {
                $totalRows++;
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $columnIndex = 0;
                foreach ($cellIterator as $cell) {
                    $excelColumnHeader = $headerRow[$columnIndex];
                    foreach ($mappings as $mapping) {
                        if ($mapping['excel_column'] === $excelColumnHeader) {
                            $rowData[$mapping['db_column']] = $cell->getValue();
                        }
                    }
                    $columnIndex++;
                }

                // Satır verilerini logla
                \Log::info('İşlenecek Satır Verileri:', $rowData);

                // Üniversite kontrolü
                $uniNameUpper = $this->strToUpperTr(trim($rowData['uni_name']));
                $uni = \App\Models\TanimUnivercity::whereRaw('UPPER(name) = ?', [$uniNameUpper])->first();

                if (!$uni) {
                    $uni = \App\Models\TanimUnivercity::create([
                        'name' => $uniNameUpper,
                        'code' => 'Belirtilmedi',
                        'city' => 'Belirtilmedi',
                        'type' => 'Belirtilmedi',
                        'bv_onlisans' => 0,
                        'bv_lisans' => 1,
                        'bv_yukseklisans' => 0,
                        'bv_doktora' => 0
                    ]);
                    \Log::info('Üniversite Bulunamadı ve Oluşturuldu:', [
                        'isim' => $uniNameUpper,
                        'uni' => $uni->toArray()
                    ]);
                } else {
                    \Log::info('Üniversite Arama Sonucu:', [
                        'aranan_isim' => $rowData['uni_name'],
                        'bulunan_uni' => $uni->toArray()
                    ]);
                }

                // Eğer üniversite bulunduysa fakülte kontrolü yap
                if ($uni) {
                    $fak = \App\Models\TanimFaculty::firstOrCreate(
                        [
                            'name' => $rowData['fak_name'],
                            'univercity_id' => $uni->id
                        ],
                        [
                            'code' => 'Belirtilmedi',
                            'bv_onlisans' => 0,
                            'bv_lisans' => 1,
                            'bv_yukseklisans' => 0,
                            'bv_doktora' => 0
                        ]
                    );
                    \Log::info('Fakülte Arama/Oluşturma Sonucu:', [
                        'aranan_isim' => $rowData['fak_name'],
                        'univercity_id' => $uni->id,
                        'bulunan_fakulte' => $fak ? $fak->toArray() : 'Bulunamadı/Oluşturulamadı'
                    ]);
                } else {
                    $fak = null;
                    \Log::warning('Üniversite bulunamadığı için fakülte araması yapılmadı');
                }

                // Üniversite veya fakülte bulunamadıysa hata log'u
                if(!$uni || !$fak) {
                    $errorRows++;
                    $errorMessage = !$uni ? 'Üniversite bulunamadı' : 'Fakülte bulunamadı';
                    \Log::error('Veri Doğrulama Hatası:', [
                        'hata' => $errorMessage,
                        'satir_no' => $totalRows + 1,
                        'veriler' => $rowData
                    ]);

                    $this->logImportActivity(
                        $dataImport->id,
                        'Hata',
                        $rowData,
                        'Üniversite veya Fakülte bulunamadı. Üniversite ve Fakülte bilgilerini kontrol ediniz.',
                        $totalRows + 1
                    );
                    continue;
                }

                // Bölüm kontrolü
                $bolumCheck = \App\Models\TanimDepartmant::where('name', $rowData['name'])
                                                        ->where('faculty_id', $fak->id)
                                                        ->first();
                \Log::info('Bölüm Kontrol Sonucu:', [
                    'aranan_isim' => $rowData['name'],
                    'faculty_id' => $fak->id,
                    'mevcut_bolum' => $bolumCheck ? $bolumCheck->toArray() : 'Yok'
                ]);

                if($bolumCheck){
                    $errorRows++;
                    $this->logImportActivity(
                        $dataImport->id,
                        'Hata',
                        $rowData,
                        'Bu Isimle Universitenin Fakültesinde Bölüm zaten kayıtlıdır',
                        $totalRows + 1
                    );
                    continue;
                }

                if(!$bolumCheck){
                    $bolum = new \App\Models\TanimDepartmant();
                    $bolum->name = $rowData['name'] ?? 'Belirtilmedi';
                    $bolum->code = $rowData['code'] ?? 'Belirtilmedi';
                        $bolum->bv_onlisans = isset($rowData['bv_onlisans']) ? (($rowData['bv_onlisans'] === 'Evet') ? 1 : 0) : 1;
                    $bolum->bv_lisans = isset($rowData['bv_lisans']) ? (($rowData['bv_lisans'] === 'Evet') ? 1 : 0) : 1;
                    $bolum->bv_yukseklisans = isset($rowData['bv_yukseklisans']) ? (($rowData['bv_yukseklisans'] === 'Evet') ? 1 : 0) : 1;
                    $bolum->bv_doktora = isset($rowData['bv_doktora']) ? (($rowData['bv_doktora'] === 'Evet') ? 1 : 0) : 1;
                    $bolum->faculty_id = $fak->id;
                    $bolum->grade_type = ' ';

                    try {
                        $bolum->save();
                        $successRows++;
                        $this->logImportActivity(
                            $dataImport->id,
                            'Başarılı',
                            $rowData,
                            'Kayıt başarıyla eklendi',
                            $totalRows + 1
                        );
                    } catch (\Exception $e) {
                        $errorRows++;
                        $this->logImportActivity(
                            $dataImport->id,
                            'Hata',
                            $rowData,
                            'Kayıt eklenirken bir hata oluştu',
                            $totalRows + 1
                        );
                        \Log::error('Bölüm Olusturma Hata:', ['error' => $e->getMessage()]);
                        throw $e;
                    }
                }
            }
            $dataImport->total_record = $totalRows;
            $dataImport->success_record = $successRows;
            $dataImport->error_record = $errorRows;
            $dataImport->status = 'Tamamlandı';
            $dataImport->save();

            return true;

        } catch (\Exception $e) {
            \Log::error('Genel Hata:', [
                'hata_mesaji' => $e->getMessage(),
                'satir' => $e->getLine(),
                'dosya' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            $dataImport->status = 'Hatalı İşlem';
            $dataImport->save();

            $this->logImportActivity(
                $dataImport->id,
                'Hata',
                null,
                'Genel Hata: ' . $e->getMessage()
            );

            throw $e;
        }
    }

    public function destroy(Request $request)
    {
        try {
            $dataImport = \App\Models\DataImport::findOrFail($request->id);

            if (Storage::exists('public/' . $dataImport->file_name)) {
                Storage::delete('public/' . $dataImport->file_name);
            }

            $dataImport->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kayıt başarıyla silindi'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kayıt silinirken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exampleFileDownload($type)
    {
        switch($type){
            case 'Universite':
                $fileName='Universiteler_ornek_liste.xlsx';
                break;
            case 'Fakulte':
                $fileName='Fakulteler_ornek_liste.xlsx';
                break;
            case 'Bolumler':
                $fileName='Bolumler_ornek_liste.xlsx';
                break;
            case 'Aday_Bursiyerler':
                $fileName='Aday_Bursiyerler_ornek_liste.xlsx';
                break;
            case 'Bursiyerler':
                $fileName='Bursiyerler_ornek_liste.xlsx';
                break;
            case 'Mezunlar':
                $fileName='Mezunlar_ornek_liste.xlsx';
                break;
            case 'Kayit_Yenileme':
                $fileName='Kayit_Yenileme_ornek_liste.xlsx';
                break;
        }
        $file = public_path('import_ornek_listeler/'.$fileName);

        return response()->download($file);
    }
}
