<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soru;
use App\Models\NewAnswer;
use App\Models\AdayPoint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SoruKategori;
use Illuminate\Support\Facades\DB;
class SoruController extends Controller
{
    public function __construct()
    {
        $this->vFolder = 'panel.';
        $this->subFolder = 'tanimlar.';
        $this->lastFolder = 'questions.';
        $this->checkColumn();
    }
    private function checkColumn(){
        if (Schema::hasColumn('sorus', 'points')) {
            $columnType = Schema::getColumnType('sorus', 'points');
            if ($columnType !== 'text') {
                DB::statement('ALTER TABLE sorus MODIFY points LONGTEXT DEFAULT NULL');
            }
        }
        $columns = ['modal_title','modal_content','redirect_text','redirect_url','scoring_ranges'];
        foreach ($columns as $column) {
            if (!Schema::hasColumn('sorus', $column)) {
                DB::statement('ALTER TABLE sorus ADD '.$column.' LONGTEXT DEFAULT NULL');
            }
        }
$fileSoruDbKeys = Soru::where('type', 'file')->pluck('db_key')->toArray();
        $tables = ['new_answers', 'active_answers', 'renew_answers','new_documents','active_documents','renew_documents'];

        foreach ($fileSoruDbKeys as $dbKey) {
            foreach ($tables as $tableName) {
                if (!Schema::hasColumn($tableName, $dbKey)) {
                    Schema::table($tableName, function ($table) use ($dbKey) {
                        $table->text($dbKey)->nullable();
                    });
                }
            }
        }
    }
     public function index(){
        $checkboxColumns = ['category_title','status','has_conditions'];
        session(['sidebar' => 15]);

        $columns = $this->getTableColumns();
        $columns['id']['visible'] = false;
        $columns['category_title']['title'] = 'Kategori';
        $columns['status']['title'] = 'Durum';
        $columns['name']['title'] = 'Soru Adı';
        $columns['has_conditions']['title'] = 'Koşul Var mı?';
        $result = [
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns,
            'categories' => SoruKategori::where('status','Aktif')->orderBy('siralama','asc')->get()

        ];
        return view($this->vFolder.$this->subFolder.$this->lastFolder.'index',$result);
    }
    public function getData(Request $request)
    {
        $query = Soru::query();
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
                            $query->orderBy('sorus.' . $field, $orderDir);
                            break;
                        case 'scholar':
                            $query->orderBy('sorus.' . $field, $orderDir);
                            break;
                        default:
                            $query->orderBy('sorus.' . $columnName, $orderDir);
                    }
                } else {
                    $query->orderBy('sorus.' . $columnName, $orderDir);
                }
            } else {
                // Varsayılan sıralama
                $query->orderBy('sorus.id', $orderDir);
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
            'id',
            'name',
            'category_title',
            'status',
            'has_conditions',
            ];

        $columnDetails = [];

        foreach ($visibleColumns as $column) {
            // İlişkili sütun kontrolü
            if (str_contains($column, '.')) {
                // İlişkili sütun için özel tanımlama
                list($relation, $field) = explode('.', $column);
                $name = Str::title(str_replace('_', ' ', $field));

                $columnDetails[$column] = [
                    'name' => $column,
                    'title' => $name,
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
                if (Schema::hasColumn('sorus', $column)) {
                    $type = Schema::getColumnType('sorus', $column);
                    $name = Str::title(str_replace('_', ' ', $column));

                    $columnDetails[$column] = [
                        'name' => $column,
                        'title' => $name,
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


        if ($column === 'category_title') {
            $values = SoruKategori::pluck('title');
            return $values;
        }
        if ($column === 'status') {
            $values = ['Aktif','Pasif'];
            return $values;
        }
        if ($column === 'has_conditions') {
            $values = ['Evet','Hayır'];
            return $values;
        }




        return $options[$this->getFilterType($type)] ?? $options['text'];
    }
    private function getFilterValue($column, $type)
    {
        if ($column === 'status') {
            $values = ['Aktif','Pasif'];
            return $values;
        }
        if ($column === 'has_conditions') {
            $values = ['Evet','Hayır'];
            return $values;
        }
        if ($column === 'category_title') {
            $values = SoruKategori::pluck('title');
            return $values;
        }
        return null;
    }
    public function soruIcerikKontrol(){
        $sorular = $this->getSorular();
        foreach($sorular as $soruData){
          $soru = Soru::where('db_key',$soruData['db_key'])->first();
          if($soru){
            $soru->update($soruData);
          }
        }
    }
    private function getSorular(){
        $sorular = [
            [
                'db_key' => 'check_taahhutname',
                'type' => 'modal',
                'modal_title' => 'Taahhütname Yeni',
                'modal_content' => '{{universite}} Üniversitesi {{bolum}} Bölümünde kayıtlı {{ogrenci_no}} numaralı öğrenci {{isim}} olarak,İşbu Açık Rıza Formu, 6698 sayılı Kişisel Verilerin Korunması Kanunu ["Kanun"] md.10 uyarınca, veri sorumlusu sıfatıyla Süreyya Ağaoğlu Çocuk Dostları Derneği ["SAÇDD"] tarafından dernek üyelerinden özel nitelikli kişisel verilerinin işlenmesine ilişkin rıza alınmasına ilişkindir.',
                'options' => '["modal","TAAHH\u00dcTNAME S\u00dcREYYA A\u011eAO\u011eLU \u00c7OCUK DOSTLARI DERNE\u011e\u0130 VE S\u00dcREYYA A\u011eAO\u011eLU E\u011e\u0130T\u0130M ve \u00d6\u011eRET\u0130M VAKFINA","{{universite}} \u00dcniversitesi {{bolum}} B\u00f6l\u00fcm\u00fcnde kay\u0131tl\u0131 {{ogrenci_no}} numaral\u0131 \u00f6\u011frenci {{isim}} olarak,\u0130\u015fbu A\u00e7\u0131k R\u0131za Formu, 6698 say\u0131l\u0131 Ki\u015fisel Verilerin Korunmas\u0131 Kanunu [\u201cKanun\u201d] md.10 uyar\u0131nca, veri sorumlusu s\u0131fat\u0131yla S\u00fcreyya A\u011fao\u011flu \u00c7ocuk Dostlar\u0131 Derne\u011fi [\u201cSA\u00c7DD\u201d] taraf\u0131ndan dernek \u00fcyelerinden \u00f6zel nitelikli ki\u015fisel verilerinin i\u015flenmesine ili\u015fkin r\u0131za al\u0131nmas\u0131na ili\u015fkindir."]'
            ],
            [
                'db_key' => 'check_acikriza',
                'type' => 'redirect',
                'redirect_url' => 'https://saasdasdasd/com',
                'options' => '["modal","TAAHH\u00dcTNAME S\u00dcREYYA A\u011eAO\u011eLU \u00c7OCUK DOSTLARI DERNE\u011e\u0130 VE S\u00dcREYYA A\u011eAO\u011eLU E\u011e\u0130T\u0130M ve \u00d6\u011eRET\u0130M VAKFINA","{{universite}} \u00dcniversitesi {{bolum}} B\u00f6l\u00fcm\u00fcnde kay\u0131tl\u0131 {{ogrenci_no}} numaral\u0131 \u00f6\u011frenci {{isim}} olarak,\u0130\u015fbu A\u00e7\u0131k R\u0131za Formu, 6698 say\u0131l\u0131 Ki\u015fisel Verilerin Korunmas\u0131 Kanunu [\u201cKanun\u201d] md.10 uyar\u0131nca, veri sorumlusu s\u0131fat\u0131yla S\u00fcreyya A\u011fao\u011flu \u00c7ocuk Dostlar\u0131 Derne\u011fi [\u201cSA\u00c7DD\u201d] taraf\u0131ndan dernek \u00fcyelerinden \u00f6zel nitelikli ki\u015fisel verilerinin i\u015flenmesine ili\u015fkin r\u0131za al\u0131nmas\u0131na ili\u015fkindir."]'
            ]
        ];
        return $sorular;
    }

    public function soruTopluIslem(Request $request){
        $islemid = $request->islemId;
        $datas = $request->ids;

        if($islemid == '1'){
            $result = Soru::whereIn('id',$datas)->delete();
            return response()->json(['success' => true]);
        }

        if($islemid == '3'){
            return $this->TopluAktar($datas);
        }

        return response()->json(['error' => 'Geçersiz işlem'], 400);
    }

    public function TopluAktar($userIds)
    {
        if(is_null($userIds)){
            $userIds = Soru::pluck('id')->toArray();
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
                'Soru Adı',
                'Kategori',
                'Durum',
            ];

            // Başlıkları yaz
            foreach ($headers as $key => $header) {
                $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
                $sheet->setCellValue($column . '1', $header);
            }

            // Verileri çek ve yaz
            $row = 2;
            foreach ($userIds as $id) {
                $data = Soru::find($id);
                if ($data) {
                    $sheet->setCellValue('A' . $row, $data->name);
                    $sheet->setCellValue('B' . $row, $data->category_title);
                    $sheet->setCellValue('C' . $row, $data->status);
                    $row++;
                }
            }

            // Excel dosyasını oluştur
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Sorular' . time() . '.xlsx';
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

 public function getSorusHavePoints()
    {
        $sorular = Soru::where('points','!=',null)->
        orWhere('scoring_ranges','!=',null)->
        get();
        return response()->json($sorular);
    }
    public function getAdayCevaplar($adayId)
    {
        $adayCevaplar = NewAnswer::where('id',$adayId)->first();
        return $adayCevaplar;
    }

    public function checkAdayPoints($adayId,$soruId){
        // Bu method spesifik bir soru için puan kontrolü yapar
        $soru = Soru::find($soruId);
        $aday = NewAnswer::find($adayId);

        if (!$soru || !$aday) {
            return null;
        }

        // Soru db_key'ine göre adayın cevabını al
        $dbKey = $soru->db_key;
        $adayCevap = $aday->$dbKey ?? null;

        // Puanlama mantığını uygula
        return $this->calculatePointForAnswer($soru, $adayCevap, $aday);
    }

    public function adayPuanHesapla(Request $request){
        try {
            $adayId = $request->aday_id;
            $aday = NewAnswer::find($adayId);

            if (!$aday) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aday bulunamadı'
                ], 404);
            }

            if (!$aday->tc_no) {
                return response()->json([
                    'success' => false,
                    'message' => 'Adayın TC numarası bulunamadı'
                ], 400);
            }

            // Mevcut puan kayıtlarını sil
            AdayPoint::where('tc_no', $aday->tc_no)->delete();

            // Puanlanabilir soruları getir
            $sorular = Soru::where('points','!=',null)
                ->orWhere('scoring_ranges','!=',null)
                ->get();

            \Log::info("=== ADAY PUAN HESAPLAMA BAŞLADI ===");
            \Log::info("Aday ID: {$adayId}, TC: {$aday->tc_no}");
            \Log::info("Puanlanabilir soru sayısı: " . $sorular->count());

            $totalPoints = 0;
            $pointDetails = [];

            foreach ($sorular as $soru) {
                $dbKey = $soru->db_key;
                \Log::info("--- Soru işleniyor: {$soru->name} (db_key: {$dbKey}) ---");

                // Veritabanı alanının varlığını kontrol et
                $adayCevap = null;
                if ($dbKey && property_exists($aday, $dbKey)) {
                    $adayCevap = $aday->$dbKey;
                    \Log::info("Property exists kullanılarak cevap alındı: " . ($adayCevap ?? 'NULL'));
                } elseif ($dbKey) {
                    // Dinamik olarak alanın varlığını kontrol et
                    try {
                        $adayCevap = $aday->getAttribute($dbKey);
                        \Log::info("getAttribute kullanılarak cevap alındı: " . ($adayCevap ?? 'NULL'));
                    } catch (\Exception $e) {
                        \Log::warning("Alan bulunamadı: {$dbKey} için aday ID: {$aday->id}");
                        continue;
                    }
                }

                // Özel hesaplama kontrolü
                if ($this->hasCustomCalculation($soru->db_key)) {
                    \Log::info("Özel hesaplama uygulanacak");
                    $puan = $this->calculateCustomPoints($soru, $aday);
                } else {
                    \Log::info("Normal hesaplama uygulanacak");
                    $puan = $this->calculatePointForAnswer($soru, $adayCevap, $aday);
                }

                \Log::info("Hesaplanan puan: {$puan}");

                // Sadece 0'dan büyük puanları kaydet
                if ($puan > 0) {
                    $totalPoints += $puan;

                    // AdayPoint tablosuna kaydet
                    AdayPoint::create([
                        'tc_no' => $aday->tc_no,
                        'soru' => $soru->name,
                        'cevap' => $adayCevap ?? '',
                        'puan' => $puan
                    ]);

                    $pointDetails[] = [
                        'soru' => $soru->name,
                        'cevap' => $adayCevap ?? '',
                        'puan' => $puan
                    ];

                    \Log::info("Puan kaydedildi: {$soru->name} = {$puan}");
                } else {
                    \Log::info("Puan 0 olduğu için kaydedilmedi");
                }
            }

            \Log::info("=== ADAY PUAN HESAPLAMA TAMAMLANDI ===");
            \Log::info("Toplam puan: {$totalPoints}");

            // Adayın toplam puanını güncelle
            $aday->totalPoints = $totalPoints;
            $aday->save();

            return response()->json([
                'success' => true,
                'totalPoints' => $totalPoints,
                'details' => $pointDetails,
                'message' => 'Puanlar başarıyla hesaplandı ve aday_points tablosuna kaydedildi'
            ]);

        } catch (\Exception $e) {
            \Log::error('Puan hesaplama hatası: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Puan hesaplama sırasında bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    private function calculatePointForAnswer($soru, $cevap, $aday)
    {
        \Log::info("=== PUAN HESAPLAMA BAŞLADI ===");
        \Log::info("Soru: {$soru->name} (db_key: {$soru->db_key})");
        \Log::info("Cevap: " . ($cevap ?? 'NULL'));
        \Log::info("Points field: " . ($soru->points ?? 'NULL'));
        \Log::info("Scoring ranges field: " . ($soru->scoring_ranges ?? 'NULL'));

        if (empty($cevap) || is_null($cevap)) {
            \Log::info("Cevap boş veya null, 0 puan dönüyor");
            return 0;
        }

        // Points field'ında JSON formatında puanlar varsa
        if (!empty($soru->points)) {
            try {
                $points = json_decode($soru->points, true);
                \Log::info("Points JSON decode edildi: " . json_encode($points));

                // Eğer points array formatındaysa ve options varsa
                if (is_array($points) && !empty($soru->options)) {
                    $options = json_decode($soru->options, true);
                    \Log::info("Options JSON decode edildi: " . json_encode($options));

                    if (is_array($options)) {
                        // Cevabın options array'inde hangi index'te olduğunu bul
                        $index = array_search($cevap, $options);
                        \Log::info("Cevap '{$cevap}' options array'inde index: " . ($index !== false ? $index : 'bulunamadı'));

                        if ($index !== false && isset($points[$index])) {
                            $puan = (int) $points[$index];
                            \Log::info("Index {$index} için puan bulundu: {$puan}");
                            return $puan;
                        }
                    }
                }

                // Direkt key-value eşleşmesi kontrol et
                if (isset($points[$cevap])) {
                    $puan = (int) $points[$cevap];
                    \Log::info("Direkt key-value eşleşmesi bulundu: {$puan}");
                    return $puan;
                }

                \Log::info("Points array'inde eşleşme bulunamadı");
            } catch (\Exception $e) {
                \Log::error('JSON decode error for points: ' . $e->getMessage());
            }
        }

        // Scoring ranges varsa
        if (!empty($soru->scoring_ranges)) {
            try {
                $ranges = json_decode($soru->scoring_ranges, true);
                \Log::info("Scoring ranges JSON decode edildi: " . json_encode($ranges));
                $numericValue = (int) $cevap;
                \Log::info("Numeric value: {$numericValue}");

                foreach ($ranges as $range) {
                    if (isset($range['min'], $range['max'], $range['points'])) {
                        \Log::info("Range kontrol: min={$range['min']}, max={$range['max']}, points={$range['points']}");
                        if ($numericValue >= $range['min'] && $numericValue <= $range['max']) {
                            $puan = (int) $range['points'];
                            \Log::info("Range eşleşmesi bulundu: {$puan}");
                            return $puan;
                        }
                    }
                }
                \Log::info("Hiçbir range eşleşmedi");
            } catch (\Exception $e) {
                \Log::error('JSON decode error for scoring_ranges: ' . $e->getMessage());
            }
        }

        \Log::info("Hiçbir puanlama kuralı eşleşmedi, 0 puan dönüyor");
        \Log::info("=== PUAN HESAPLAMA BİTTİ ===");
        return 0;
    }

    private function hasCustomCalculation($dbKey)
    {
        // Özel hesaplama gereken alanları tanımla
        $customFields = ['housing_fee','agno','grade_avg','kaSQQWBD3IH2'];
        return in_array($dbKey, $customFields);
    }

    private function calculateCustomPoints($soru, $aday)
    {
        switch ($soru->db_key) {
            case 'housing_fee':
                return $this->calculateHousingFeePoints($soru, $aday);
            case 'agno':
                return $this->calculateAgnoPoints($soru, $aday);
            case 'grade_avg':
                return $this->calculateGradeAvgPoints($soru, $aday);
            case 'kaSQQWBD3IH2':
                return $this->calculateToplamGelir($soru, $aday);
            default:
                return 0;
        }
    }

        private function calculateHousingFeePoints($soru, $aday)
    {
        $housingType = trim($aday->housing_type ?? '');
        $rawFee = $aday->housing_fee ?? null;

        \Log::info("Housing fee puanı hesaplanıyor. Housing Type: '{$housingType}', Housing Fee: " . ($rawFee ?? 'NULL'));

        if ($rawFee === null || $rawFee === '') {
            \Log::info("Housing fee boş veya null, 0 puan dönüyor.");
            return 0;
        }
        $cleaned = str_replace([' ', 'TL', 'tl', '₺'], '', (string)$rawFee);
        if (preg_match('/^\d{1,3}(\.\d{3})+$/', $cleaned)) {
            $cleaned = str_replace('.', '', $cleaned);
        } else {
            $cleaned = str_replace(',', '.', $cleaned);
        }
        $numericValue = (float) $cleaned;
        \Log::info("Housing fee sayısal değer: " . $numericValue);

        $normalizedType = mb_strtolower($housingType, 'UTF-8');

        if ($normalizedType === 'öğrenci evi') {

            if ($numericValue <= 15000) {

                \Log::info("Öğrenci Evi koşulu sağlandı (ücret <= 15000), 10 puan.");
                \Log::info("sadece kiraya puan veriliyor");
                return 10;
            } else {
                \Log::info("Öğrenci Evi koşulu sağlanmadı (ücret > 15000), 0 puan.");
                return 0;
            }
        } elseif ($normalizedType === 'yurt') {
            if ($numericValue <= 2500) {
                \Log::info("Yurt koşulu sağlandı (ücret <= 2500), 10 puan.");
                return 10;
            } else {
                \Log::info("Yurt koşulu sağlanmadı (ücret > 2500), 0 puan.");
                return 0;
            }
        } elseif ($normalizedType === 'misafir') {
            if ($numericValue > 0) {
                \Log::info("Misafir koşulu sağlandı (ücret > 0), 10 puan.");
                return 10;
            } else {
                \Log::info("Misafir koşulu sağlanmadı (ücret <= 0), 0 puan.");
                return 0;
            }
        } else {
            \Log::info("Barınma türü ('{$housingType}') için puan verilmiyor.");
            return 0;
        }
    }

    private function calculateGradeAvgPoints($soru,$aday){
        if($aday->grade_avg && ($aday->educationType != 'lisans' || $aday->educationType != 'yukseklisans' || $aday->educationType != 'doktora')){
            $puan = $aday->grade_avg * 0.4;
            return $puan;
        }
        else{
            return 0;
        }
    }
    private function calculateAgnoPoints($soru,$aday){

        if($aday->agno && in_array($aday->educationType, ['lisans', 'yukseklisans', 'doktora'])){
            \Log::info("AGNO puanı hesaplanacak");

            if($aday->agno_type == "4'lük"){
                $puan = $aday->agno * 10;
                \Log::info("4'lük sistemde puan: {$puan}");
            }
            else{
                $puan = $aday->agno * 0.4;
                \Log::info("100'lük sistemde puan: {$puan}");
            }

            return $puan;
        }
        else{
            \Log::info("AGNO puanı hesaplanamadı - Koşullar sağlanmıyor");
            return 0;
        }
    }

    private function calculateToplamGelir($soru,$aday){
        $toplamGelir = $aday->father_salary + $aday->mother_salary + $aday->other_salary + $aday->other_income;
        $aday->kaSQQWBD3IH2 = $toplamGelir;
        if($aday->kaSQQWBD3IH2){
                $ranges = json_decode($soru->scoring_ranges, true);
                \Log::info("Scoring ranges: " . json_encode($ranges));
                $numericValue = (int) $aday->kaSQQWBD3IH2;
                \Log::info("Numeric value: " . $numericValue);

                foreach ($ranges as $range) {
                    \Log::info("Range kontrol ediliyor: " . json_encode($range));

                    if (isset($range['points'])) {
                        $minValue = $range['min'] ?? 0; // null ise 0 kabul et
                        $maxValue = $range['max'] ?? PHP_INT_MAX; // null ise sınırsız kabul et

                        \Log::info("Min: " . $minValue . ", Max: " . $maxValue . ", Points: " . $range['points']);

                        if ($numericValue >= $minValue && $numericValue <= $maxValue) {
                            $puan = (int) $range['points'];
                            \Log::info("Toplam Gelir puanı bulundu: " . $puan);
                            return $puan;
                        }
                    }
                }

                \Log::info("Hiçbir Toplam Gelir range'i eşleşmedi");
                return 0;
        }
        else{
            \Log::info("Toplam Gelir uygun değil: " . $aday->kaSQQWBD3IH2);
            return 0;
        }
    }

}

