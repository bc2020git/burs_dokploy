<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ilce;
use App\Models\Il;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
class IlceController extends Controller
{
    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
    }
     public function index(){
        session(['sidebar' => 10]);
        $checkboxColumns = ['bv_ilkokul', 'bv_ortaokul', 'bv_lise'];

        $columns = $this->getColumnDefinitions();
        $columns['id']['title'] = 'İlçe No';
        $columns['isim']['title'] = 'İlçe Adı';
        $columns['bv_ilkokul']['title'] = 'B.V İlkokul';
        $columns['bv_ortaokul']['title'] = 'B.V Ortaokul';
        $columns['bv_lise']['title'] = 'B.V Lise';
        $result = [
            'docColumns' => [],
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns

        ];
        return view('panel.tanimlar.districts.index',$result);
    }
    public function getData(Request $request)
    {
        $query = Ilce::query();
        $query->leftJoin('ils', 'ilces.il_no', '=', 'ils.il_no');
        $query->select([
            'ilces.*',
            'ils.name as il_name',
            'ils.il_no as il_il_no'
        ]);

        return DataTables::of($query)
        ->addColumn('checkbox', function($row){
            return '<input type="checkbox" name="userCheckbox" class="form-check-input" value="'.$row->id.'">';
            })
            ->addColumn('action', function($row){
                $url =  route('detail-district',['id'=>$row->id]);
                $btn = '
                        <a href="'.$url.'" class="btn btn-sm edit-member">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                            </svg>
                        </a>';

                return $btn;
            })
            ->addColumn('bv_ilkokul', function($row){
                if($row->bv_ilkokul == 1){
                    return '<span class="status-box-success">Evet</span>';
                }else{
                    return '<span class="status-box-danger">Hayır</span>';
                }
            })
            ->addColumn('bv_ortaokul', function($row){
                if($row->bv_ortaokul == 1){
                    return '<span class="status-box-success">Evet</span>';
                }else{
                    return '<span class="status-box-danger">Hayır</span>';
                }
            })
            ->addColumn('bv_lise', function($row){
                if($row->bv_lise == 1){
                    return '<span class="status-box-success">Evet</span>';
                }else{
                    return '<span class="status-box-danger">Hayır</span>';
                }
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && $request->get('search')['value'] != '') {
                    $searchValue = $request->get('search')['value'];
                    $query->where(function($query) use ($searchValue) {
                        $query->where('ilces.isim', 'like', "%{$searchValue}%")
                            ->orWhere('ilces.il_no', 'like', "%{$searchValue}%")
                            ->orWhere('ilces.bv_ilkokul', 'like', "%{$searchValue}%")
                            ->orWhere('ilces.bv_ortaokul', 'like', "%{$searchValue}%")
                            ->orWhere('ilces.bv_lise', 'like', "%{$searchValue}%")
                            ->orWhere('ilces.il_no', 'like', "%{$searchValue}%")
                            ->orWhere('ils.name', 'like', "%{$searchValue}%");
                    });
                }
                if ($request->has('filters')) {
                    $filters = json_decode($request->filters, true);
                    foreach ($filters as $column => $filter) {
                        $this->applyColumnFilter($query, $column, $filter);
                    }
                }
            }, true)
            ->order(function ($query) use ($request) {
                if ($request->has('order')) {
                    $order = json_decode($request->order, true);
                    if ($order && isset($order['column'])) {
                        $columnName = $order['column'];

                        // students. prefix'ini kaldır
                        if (str_starts_with($columnName, 'ilces.')) {
                            $columnName = substr($columnName, 21);
                        }

                        if (str_contains($columnName, '.')) {
                            $parts = explode('.', $columnName);
                            $field = array_pop($parts);
                            $lastTable = last($parts) . 's';
                            $query->orderBy($lastTable . '.' . $field, $order['dir']);
                        } else {
                            $query->orderBy( $columnName, $order['dir']);
                        }
                    }
                }
            })
            ->rawColumns(['checkbox', 'action', 'bv_ilkokul', 'bv_ortaokul', 'bv_lise','odeme_durumu'])
            ->make(true);
    }
    protected function getColumnDefinitions()
    {
        $acceptedColumns = $this->getColumnList();
        $columns = [];
        // Model sütunlarını al
        // NewAnswer modelinin tüm sütunlarını al
        $allColumns = \Schema::getColumnListing('ilces');

        // visibleColumns'ı allColumns'dan çıkart
        $hiddenColumns = array_diff($allColumns, $acceptedColumns);

        $allColumns = Schema::getColumnListing('ilces');
        $columnDetailces = [];
        // Sıralı şekilde sütunları ekleyelim
        foreach ($acceptedColumns as $column) {
            if (in_array($column, $allColumns)) {  // Veritabanında var olan sütunları kontrol et
                $title = $this->getColumnTitle($column);

                $type = Schema::getColumnType('ilces', $column);
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
        // İlişkisel alanları ekle
        $columns['il.name'] = [
            'title' => 'İl Adı',
            'name' => 'il.name',
            'type' => 'text',
            'filterable' => true,
            'conditions' => $this->getColumnConditions('text'),
            'is_visible' => true,
            'filterOptions' => $this->getColumnOptions($column),
                'filterValue' => $this->getFilterValue($column, $type)
        ];
        $columns['il.il_no'] = [
            'title' => 'İl Plaka No',
            'name' => 'il.il_no',
            'type' => 'number',
            'filterable' => true,
            'conditions' => $this->getColumnConditions('number'),
            'is_visible' => true,
            'filterOptions' => $this->getColumnOptions($column),
                'filterValue' => $this->getFilterValue($column, $type)
        ];
        return $columns;
    }

    protected function getColumnType($model, $column)
    {
        $casts = $model->getCasts();

        if (isset($casts[$column])) {
            switch ($casts[$column]) {
                case 'date':
                case 'datetime':
                    return 'date';
                case 'integer':
                case 'int':
                case 'bigint':
                case 'decimal':
                case 'float':
                case 'decimal':
                    return 'number';
                default:
                    return 'text';
            }
        }

        $selectColumns = ['role_id'];
        if (in_array($column, $selectColumns)) return 'select';
        if (Str::endsWith($column, '_date')) return 'date';
        if (Str::endsWith($column, ['_id', '_count'])) return 'number';

        return 'text';
    }

    protected function getColumnTitle($column)
    {
        return $column;
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
            case str_starts_with($column, 'bv_'):
                return ['Hayır', 'Evet'];
            case 'odeme_durumu':
                return [
                    '0' => 'Beklemede',
                    '1' => 'Ödendi',
                    '2' => 'Ödeme Başarısız',
                ];
            case 'burs_ayi':
                return [
                    '0' => 'Ocak',
                    '1' => 'Şubat',
                    '2' => 'Mart',
                    '3' => 'Nisan',
                    '4' => 'Mayıs',
                    '5' => 'Haziran',
                    '6' => 'Temmuz',
                    '7' => 'Ağustos',
                    '8' => 'Eylül',
                    '9' => 'Ekim',
                    '10' => 'Kasım',
                    '11' => 'Aralık',
                ];
            case 'burs_tipi':
                return Ilce::all()->pluck('burs_tipi');
            case 'okul_tipi':
                return [
                    '0' => 'İlkokul',
                    '1' => 'Ortaokul',
                    '2' => 'Lise',
                    '3' => 'Ön Lisans',
                    '4' => 'Lisans',
                    '5' => 'Yüksek Lisans',
                    '6' => 'Doktora',
                ];
            case 'status':
                return [
                    '0' => 'Devam Ediyor',
                    '1' => 'Onay Bekliyor',
                    '2' => 'İade Edildi',
                    '3' => 'Onaylandı',
                    '4' => 'Red Edildi',
                    '5' => 'İadeden Döndü'
                ];
            case 'mulakat_durumu':
                return [
                        '0' => 'Mülakat Yapılacak',
                        '1' => 'Planlandı',
                        '2' => 'Olumlu',
                        '3' => 'Olumsuz',
                ];
            case 'aday_turu':
                return [
                    '0' => 'Dernek',
                    '1' => 'Vakıf',
                    '2' => 'Boş'
                ];
            case 'okul_tipi':
                return [
                    '0' => 'İlkokul',
                    '1' => 'Ortaokul',
                    '2' => 'Lise',
                    '3' => 'Ön Lisans',
                    '4' => 'Lisans',
                    '5' => 'Yüksek Lisans',
                    '6' => 'Doktora',
                ];
            case (str_starts_with($column, 'doc_')):
                return [
                    '0' => 'Hayır',
                    '1' => 'Evet'
                ];

            default:
                return [];
        }
    }

    private function getColumnList(){
        $list = [
            'id',
            'isim',
            'il.name',
            'il.il_no',
            'bv_ilkokul',
            'bv_ortaokul',
            'bv_lise',

        ];
        return $list;
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
        switch ($type) {
            case 'number':
            case 'int':
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
        switch ($field) {
            case 'id':
                $field = 'ilces.id';
                break;
            case 'bv_ilkokul':
                $field = 'ilces.bv_ilkokul';
                break;
            case 'bv_ortaokul':
                $field = 'ilces.bv_ortaokul';
                break;
            case 'bv_lise':
                $field = 'ilces.bv_lise';
                break;
        }

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
            case 'in':
                $query->whereIn($field, $value);
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
            case 'in':
                $query->whereIn($field, $value);
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
            case 'in':
                if(str_starts_with($field, 'doc_')){
                    foreach($value as $item){
                        if($item == 'Hayır'){

                            $query->orWhereNull($field);
                        }else{
                            $query->orWhereNotNull($field);
                        }
                    }
                }
                if(is_array($value)){
                    foreach($value as $item){
                        if($item == 'null'){
                            $query->orWhereNull($field);
                        }else{
                            $query->orWhere($field, $item);
                        }
                    }
                }
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
    public function getColumnTypes(){
        Cache::remember('new_answers_column_types', now()->addDay(), function() {
            $types = [];
            try {
                $columns = \Schema::getColumnListing('new_answers');
                foreach ($columns as $column) {
                    $types[$column] = \Schema::getColumnType('new_answers', $column);
                }
                \Log::info('Sütun tipleri cache\'lendi', ['types' => $types]);
            } catch (\Exception $e) {
                \Log::error('Sütun tipleri alınırken hata:', ['error' => $e->getMessage()]);
                return [];
            }
            return $types;
        });
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
        if (strpos($column, 'bv_') === 0) {
            $values = ['Hayır', 'Evet'];
            return $values;
        }
        if ($column === 'burs_ayi') {
            $values = ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'];
            return $values;
        }
        if ($column === 'burs_tipi') {
            $values = Ilce::all()->pluck('burs_tipi');
            return $values;
        }
        if (strpos($column, 'doc_') === 0) {
            $values = ['Hayır', 'Evet'];
            return $values;
        }
        // Özel durumlar için
        if ($column === 'aday_turu') {
            $values= ['Dernek','Vakıf','Boş'];
            return $values;
        }

        if ($column === 'okul_tipi') {
            $values= ['İlkokul','Ortaokul','Lise','Ön lisans','Lisans','Yüksek Lisans','Doktora'];
            return $values;
        }
        if (str_starts_with($column, 'doc_')) {
            return [
                '0' => 'Hayır',
                '1' => 'Evet'
            ];
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
            $values= ['Devam Ediyor','Onay Bekliyor','İade Edildi','Onaylandı','Red Edildi','İadeden Döndü'];

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
        if (strpos($column, 'bv_') === 0) {
            $values = ['0', '1'];
            return $values;
        }
        if ($column === 'odeme_durumu') {
            $values= ['Beklemede','Ödendi','Ödeme Başarısız'];
            return $values;
        }
        if ($column === 'burs_tipi') {
            $values = Ilce::all()->pluck('burs_tipi');
            return $values;
        }
        if (strpos($column, 'doc_') === 0) {
            $values = ['Hayır', 'Evet'];
            return $values;
        }
        if ($column === 'status') {
            $values= ['0','1','2','3','4','5'];
            return $values;
        }
        if ($column === 'burs_ayi') {
            $values = ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'];
            return $values;
        }
        if ($column === 'okul_tipi') {
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

    public function ilceTopluSil(Request $request){
        $bursDurum = $request->bursDurum;
        $islemid = $request->islemId;
        $datas = $request->ids;

        if ($islemid == '1'){
            $result = Ilce::whereIn('id',$datas)->delete();
            $this->filterController->checkResult($result);
            return response()->json(['success' => true]);
        }

        if($islemid == '3'){
            return $this->TopluAktar($datas);
        }

        if ($islemid == '2'){
            $bv_ilkokul = $request->bv_ilkokul;
            $bv_ortaokul = $request->bv_ortaokul;
            $bv_lise = $request->bv_lise;

            foreach ($datas as $data){
                $item = Ilce::find($data);
                if ($bv_ilkokul==1){
                    $item->bv_ilkokul = $bursDurum;
                }
                if ($bv_ortaokul==1){
                    $item->bv_ortaokul = $bursDurum;
                }
                if ($bv_lise==1){
                    $item->bv_lise = $bursDurum;
                }
                $item->save();
            }
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Geçersiz işlem'], 400);
    }
    public function TopluAktar($userIds)
    {
        if(is_null($userIds)){
            $userIds = Ilce::pluck('id')->toArray();
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
                'İlçe No',
                'İlçe Adı',
                'İl Adı',
                'İl Plaka No',
                'B.V İlkokul',
                'B.V Ortaokul',
                'B.V Lise',
            ];

            // Başlıkları yaz
            foreach ($headers as $key => $header) {
                $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
                $sheet->setCellValue($column . '1', $header);
            }

            // Verileri çek ve yaz
            $row = 2;
            foreach ($userIds as $id) {
                $data = Ilce::find($id);
                $il = Il::where('il_no',$data->il_no)->first();
                if ($data) {
                    $sheet->setCellValue('A' . $row, $data->ilce_no);
                    $sheet->setCellValue('B' . $row, $data->isim);
                    $sheet->setCellValue('C' . $row, $il->name);
                    $sheet->setCellValue('D' . $row, $il->il_no);
                    $sheet->setCellValue('E' . $row, $this->bvText($data->bv_ilkokul));
                    $sheet->setCellValue('F' . $row, $this->bvText($data->bv_ortaokul));
                    $sheet->setCellValue('G' . $row, $this->bvText($data->bv_lise));
                    $row++;
                }
            }

            // Excel dosyasını oluştur
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Ilceler' . time() . '.xlsx';
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
            dd($e->getMessage());
            return response()->json(['error' => 'Excel dosyası oluşturulamadı'], 500);
        }
    }
    private function bvText($value){
        if($value == 1){
            return 'Evet';
        }
        else{
            return 'Hayır';
        }
    }
}
