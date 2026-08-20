@php
    $user = Auth::user();
    $permissions = $user->role->permissions->pluck('name')->toArray();

    function hasPermissions($permissionName, $permissions) {
        return in_array($permissionName, $permissions);
    }
@endphp
@if(hasPermissions('sifre-sifirlama', $permissions))
<button type="button" id="sifreSifirlamaBtn" class="btn btn-primary text-white ms-2">
    Şifre Bildir
</button>
@endif
