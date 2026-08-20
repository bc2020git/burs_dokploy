<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\LastUserPassword;
use App\Models\InterviewGroup;
use Illuminate\Support\Str;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UserController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct(FilterController $filterController)
    {
        $this->filterController = $filterController;
        $this->ortak = new OrtakController();

        // Status sütununu kontrol et ve yoksa ekle
        if (!Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status')->default('Aktif');
            });
        }
    }
    protected function getColumnDefinitions()
    {
        $model = new User();
        $columns = [];

        // Model sütunlarını al
        foreach ($model->getFillable() as $column) {
            if ($column === 'gorev') {
                $columns['role_name'] = [
                    'title' => 'Rol',
                    'name' => 'role_name',
                    'type' => 'text',
                    'filterable' => true,
                    'conditions' => $this->getColumnConditions('text'),
                    'is_visible' => true,
                    'filterOptions' => $this->getColumnOptions('role_name'),
                    'filterValue' => $this->getColumnOptions('role_name')
                ];
            }

            $type = $this->getColumnType($model, $column);
            $title = $this->getColumnTitle($column);

            // Görünmez olması gereken sütunları belirleme
            $isVisible = !in_array($column, ['id', 'notes', 'teacher_id','accepted_ip','password','role_id']);

            $columnDef = [
                'title' => $title,
                'name' => $title,
                'type' => $type,
                'filterable' => true,
                'conditions' => $this->getColumnConditions($type),
                'is_visible' => $isVisible,
                'filterOptions' => $this->getColumnOptions($column)
            ];
            if ($type === 'select') {
                $columnDef['filterOptions'] = $this->getColumnOptions($column);
            }

            $columns[$column] = $columnDef;
        }
        $columns['accepted_ip'] = [
            'title' => ' Kabul Edilen IP',
            'name' => 'accepted_ip',
            'type' => 'text',
            'filterable' => true,
            'conditions' => $this->getColumnConditions('text'),
            'is_visible' => false,
            'filterOptions' => $this->getColumnOptions($column)

        ];
        $columns['status_switch'] = [
            'name' => 'status',
            'filterable' => false,
            'type' => 'text',
            'title' => 'Durum',
            'is_visible' => true,
            'filterOptions' => []
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
        $title = Str::title(str_replace('_', ' ', $column));

        // Özel başlık çevirileri
        $translations = [
            'Tc No' => 'TC No',
            'Gpa' => 'Not Ortalaması',
            'Status' => 'Durum',
            'Birth Date' => 'Doğum Tarihi',
            'Created At' => 'Kayıt Tarihi',
        ];

        return $translations[$title] ?? $title;
    }

    protected function getColumnConditions($type)
    {
        $common = [
            'empty' => 'Boş',
            'not_empty' => 'Boş Değil'
        ];

        switch ($type) {
            case 'text':
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
            case 'role_name':
                return Role::query()
                    ->orderBy('name')
                    ->pluck('name', 'name')
                    ->toArray();
            case 'status':
                return [
                    'active' => 'Aktif',
                    'inactive' => 'Pasif'
                ];
            default:
                return [];
        }
    }
    public function index()
    {
        session(['sidebar' => 23]);

        $roles = Role::all();
        $users = User::with('role')->get();
        $checkboxColumns =
         [
            'status',
            'role_name',

        ];
        $columns = $this->getColumnDefinitions();
        $columns['name']['title'] = 'Ad';
        $columns['surname']['title'] = 'Soyad';
        $columns['email']['title'] = 'E-Posta';
        $columns['tel_no']['title'] = 'Telefon';
        $columns['gorev']['title'] = 'Görev';
        $result = [
            'users' => $users,
            'roles' => $roles,
            'columns' => $columns,
            'checkboxColumns' => $checkboxColumns,
            'docColumns' => []
        ];
        return view('panel.settings.users.index', $result); // Kullanıcıları view'a gönder
    }

    public function getData(Request $request)
    {
        $users = User::query();

        // İlişkisel tabloları join et
        $users->leftJoin('roles', 'users.role_id', '=', 'roles.id');

        $users->select([
            'users.id',
            'users.name',
            'users.surname',
            'users.email',
            'users.tel_no',
            'users.status',
            'users.gorev',
            'users.created_at',
            'roles.name as role_name'
        ]);

        return DataTables::of($users)
            ->editColumn('status', fn($user) => $user->status === 'Aktif' ? 'Aktif' : 'Pasif')
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="userCheckbox" class="form-check-input" value="'.$row->id.'">';
            })
            ->addColumn('status_switch', function($row){
                $checked = $row->status == 'Aktif' ? 'checked' : '';
                $switch = '<div class="d-flex justify-content-center">';
                $switch .= '<label class="switch">';
                $switch .= '<input type="checkbox" onclick="changeStatus(this)" class="status-switch" data-id="'.$row->id.'" '.$checked.'>';
                $switch .= '<span class="slider"></span>';
                $switch .= '<span class="switch-text"></span>';
                $switch .= '</label>';
                $switch .= '</div>';
                return $switch;
            })
            ->addColumn('action', function($row){
                $userData = [
                    'id' => $row->id,
                    'name' => $row->name,
                    'surname' => $row->surname,
                    'email' => $row->email,
                    'tel_no' => $row->tel_no,
                    'role_id' => $row->role_id,
                    'gorev' => $row->gorev,
                    'accepted_ip' => $row->accepted_ip,
                    'role_name' => $row->role_name
                ];
                $userData = json_encode($userData);
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<button class="btn btn-warning btn-sm" onclick="openUserModal('.$row->id.')">Düzenle</button>';
                $btn .= '<button class="btn btn-danger btn-sm" onclick="deleteUser('.$row->id.')">Sil</button>';
                $btn .= '</div>';
                return $btn;
            })
            ->filter(function ($query) use ($request) {
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
                        if (str_starts_with($columnName, 'users.')) {
                            $columnName = substr($columnName, 9);
                        }

                        if ($columnName === 'role_name') {
                            $query->orderBy('roles.name', $order['dir']);
                        } elseif (str_contains($columnName, '.')) {
                            $parts = explode('.', $columnName);
                            $field = array_pop($parts);
                            $lastTable = last($parts) . 's';
                            $query->orderBy($lastTable . '.' . $field, $order['dir']);
                        } else {
                            $query->orderBy('users.' . $columnName, $order['dir']);
                        }
                    }
                }
            })
            ->rawColumns(['checkbox', 'action', 'status_switch'])
            ->make(true);
    }

    protected function applyColumnFilter($query, $column, $filter)
    {
        $value = $filter['value'] ?? '';
        $condition = $filter['condition'] ?? 'contains';

        $type = $this->getColumnDefinitions()[$column]['type'] ?? 'text';

        if ($column === 'role_name') {
            $this->buildCondition($query, 'roles.name', $value, $condition, $type);
            return;
        }

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
            $field = 'users.' . $field;
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
            case 'in':
                $query->whereIn($field, $value);
                break;
        }
    }





    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Mevcut şifre yanlış.']);
        }

        // Son 3 şifreyi kontrol et
        $lastPasswords = LastUserPassword::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($lastPasswords as $lastPassword) {
            if (Hash::check($request->newPassword, $lastPassword->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Yeni şifre, son kullandığınız 3 şifreden biri olamaz.'
                ]);
            }
        }

        // Yeni şifreyi kaydet
        $user->password = Hash::make($request->newPassword);
        $user->save();

        // Yeni şifreyi LastUserPassword modeline kaydet
        LastUserPassword::create([
            'user_id' => $user->id,
            'password' => $user->password
        ]);

        return response()->json(['success' => true, 'message' => 'Şifre başarıyla değiştirildi.']);
    }

    public function updateAccount(Request $request)
    {
        // Gelen verileri doğrula
        $validator = Validator::make($request->all(), [
            'formData.name' => 'required|string|max:255',
            'formData.email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // Kullanıcı bilgilerini güncelle
        $user->name = $request->input('formData.name');
        $user->surname = $request->input('formData.surname');
        $user->email = $request->input('formData.email');
        $user->tel_no = $request->input('formData.tel_no');
        $user->gorev = $request->input('formData.gorev');
        // Değişiklikleri kaydet
        if ($user->save()) {
            session()->flash('success', 'Hesap bilgileri başarıyla güncellendi.');
            return response()->json([
                'success' => true,
                'message' => 'Hesap bilgileri başarıyla güncellendi.'
            ]);
        } else {
            session()->flash('error', 'Hesap bilgileri güncellenirken bir hata oluştu.');
            return response()->json([
                'success' => false,
                'message' => 'Hesap bilgileri güncellenirken bir hata oluştu.'
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'gorev' => 'required|string|max:255',
            'tel_no' => 'nullable|string|max:32',
            'accepted_ip' => 'nullable|string|max:64',
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'gorev' => $request->gorev,
            'tel_no' => $request->tel_no,
            'accepted_ip' => $request->accepted_ip,
        ]);
        if($user->role_id == 6){
            $item  = new  InterviewGroup();
            $item->name = $user->name . ' ' . $user->surname;
            $item->members = [(string)$user->id];
            $item->save();
        }

        return response()->json(['message' => 'Kullanıcı başarıyla eklendi.', 'user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        if($user->role_id == 6 &&  $request->role_id != 6){
            $group  = InterviewGroup::where('name',$user->name . ' ' . $user->surname)->first();
            if($group){
                $group->delete();
            }
        }
        $rules = [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'gorev' => 'required|string|max:255',
            'tel_no' => 'nullable|string|max:20',
            'accepted_ip' => 'nullable|string|max:64',
        ];

        // Eğer şifre alanı doldurulmuşsa, şifre doğrulama kurallarını ekle
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->gorev = $request->gorev;
        $user->tel_no = $request->tel_no;
        $user->accepted_ip = $request->accepted_ip;

        // Şifre alanı doldurulmuşsa şifreyi güncelle
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        if($user->role_id == 6){
            $check = InterviewGroup::where('name',$user->name . ' ' . $user->surname)->first();
            if(!$check){
                $item  = new  InterviewGroup();
                $item->name = $user->name . ' ' . $user->surname;
                $item->members = [(string)$user->id];
                $item->save();
            }
        }
        if($user->role_id != 6){
            $item  = InterviewGroup::where('name',$user->name . ' ' . $user->surname)->first();
            if($item){
                $item->delete();
            }
        }
        return response()->json(['message' => 'Kullanıcı başarıyla güncellendi.', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Kullanıcı başarıyla silindi.']);
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = $request->status;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Kullanıcı durumu başarıyla güncellendi.',
                'status' => $user->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı durumu güncellenirken bir hata oluştu.'
            ], 500);
        }
    }

    public function edit($id)
    {
        $user = User::with('role')->findOrFail($id);
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
