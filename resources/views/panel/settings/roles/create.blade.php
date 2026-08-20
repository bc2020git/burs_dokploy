@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Rol Ekle
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">

    <form action="{{ route('roles.store') }}" method="POST">
        <div class="  mb-3">
            <a class="btn btn-danger me-3" href="{{route('roles.index')}}">Vazgeç</a>
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>


        @csrf
        <div class="form-group">
            <label for="name">Rol Adı</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Açıklama</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <h3>İzinler</h3>
        @php
            $groupedPermissions = [];
            foreach ($permissions as $permission) {
                $category = $permission->category ?? 'Boş Kategori'; // Kategori boşsa 'Boş Kategori' kullan
                $groupedPermissions[$category][] = $permission;
            }
        @endphp

        @foreach ($groupedPermissions as $category => $categoryPermissions)
            <div class="category">
                <div class="form-check d-flex align-items-center">
                    <h3><label for="category_{{ $category }}" class="form-check-label">{{ $category }}</label></h3>
                    <input type="checkbox" class="category-checkbox form-check-input mb-2 ms-4" id="category_{{ $category }}" data-category="{{ $category }}">

                </div>

                @foreach ($categoryPermissions as $permission)
                    <div class="form-check" style="padding-left: 60px;">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" class="form-check-input permission-checkbox">
                        <label for="permission_{{ $permission->id }}" class="form-check-label">{{ $permission->description }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </form>
            </div>
        </main>
        <!--Modal Alanı-->
        @include('panel.tanimlar.districts.modals')
        @include('includes.js.toastr')

    @endsection
    @section('scripts')
        <!-- App js -->

        <script>
    // Kategori checkbox'ları için tüm izinleri işaretleme fonksiyonu
    document.querySelectorAll('.category-checkbox').forEach(function(categoryCheckbox) {
        categoryCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            const category = this.getAttribute('data-category');
            const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

            permissionCheckboxes.forEach(function(checkbox) {
                const permissionCategory = checkbox.closest('.category').querySelector('label').innerText;
                if (permissionCategory === category) {
                    checkbox.checked = isChecked;
                }
            });
        });
    });
</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/scholarmodal.js"></script>
        <script src="{{url('')}}/assets/js/tables/banks.js"></script>


            @include('includes.js.sidebar')

@endsection

