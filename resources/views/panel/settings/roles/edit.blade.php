@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Rol Düzenle: {{ $role->name }}
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('local-css')
    <style>
        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            color: #0d6efd;
        }

        .accordion-item {
            border: 1px solid rgba(0,0,0,.125);
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0,0,0,.125);
        }

        .category-checkbox {
            z-index: 2;
        }

        .accordion-button::after {
            margin-left: 0;
        }

        .form-check {
            margin-bottom: 0;
        }

        .accordion-body {
            padding: 1rem 1.5rem;
            background-color: #fff;
        }

        .permission-checkbox {
            margin-right: 0.5rem;
        }

        /* Ek stil iyileştirmeleri */
        .accordion-button {
            padding: 1rem 1.25rem;
        }

        .accordion-button .form-check {
            min-height: auto;
            padding-left: 0;
        }

        .accordion-button:hover {
            background-color: #f8f9fa;
        }

        .accordion-body .form-check {
            padding-left: 2rem;
        }
    </style>
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class="mt-1">
                <form action="{{ route('roles.update', $role) }}" method="POST">
                    <div class="mb-3">
                        <a class="btn btn-danger me-3" href="{{route('roles.index')}}">Vazgeç</a>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="name">Rol Adı</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="description">Açıklama</label>
                        <textarea name="description" id="description" class="form-control">{{ $role->description }}</textarea>
                    </div>

                    <h3 class="mb-4">İzinler</h3>

                    @php
                        $groupedPermissions = [];
                        foreach ($permissions as $permission) {
                            $category = $permission->category ?? 'Boş Kategori';
                            $groupedPermissions[$category][] = $permission;
                        }
                    @endphp

                    <div class="accordion" id="permissionsAccordion">
                        @foreach ($groupedPermissions as $category => $categoryPermissions)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ Str::slug($category) }}">
                                    <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ Str::slug($category) }}"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ Str::slug($category) }}">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <span class="fw-bold">{{ $category }}</span>
                                            <div class="form-check ms-3">
                                                <input type="checkbox"
                                                       class="category-checkbox form-check-input"
                                                       id="category_{{ Str::slug($category) }}"
                                                       data-category="{{ $category }}"
                                                       onclick="event.stopPropagation();">
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ Str::slug($category) }}"
                                     class="accordion-collapse collapse"
                                     aria-labelledby="heading{{ Str::slug($category) }}"
                                     data-bs-parent="#permissionsAccordion">
                                    <div class="accordion-body">
                                        @foreach ($categoryPermissions as $permission)
                                            <div class="form-check mb-2">
                                                <input type="checkbox"
                                                       name="permissions[]"
                                                       value="{{ $permission->id }}"
                                                       id="permission_{{ $permission->id }}"
                                                       class="form-check-input permission-checkbox"
                                                       {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                <label for="permission_{{ $permission->id }}"
                                                       class="form-check-label">
                                                    {{ $permission->description }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
            document.addEventListener('DOMContentLoaded', function() {
                // Sayfa yüklendiğinde kategori checkbox'larını kontrol et
                document.querySelectorAll('.accordion-item').forEach(function(category) {
                    const categoryCheckbox = category.querySelector('.category-checkbox');
                    const permissionCheckboxes = category.querySelectorAll('.permission-checkbox');
                    const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
                    categoryCheckbox.checked = allChecked;
                });

                // Kategori checkbox'ları için tüm izinleri işaretleme fonksiyonu
                document.querySelectorAll('.category-checkbox').forEach(function(categoryCheckbox) {
                    categoryCheckbox.addEventListener('change', function(e) {
                        e.stopPropagation();
                        const isChecked = this.checked;
                        const accordionItem = this.closest('.accordion-item');
                        const permissionCheckboxes = accordionItem.querySelectorAll('.permission-checkbox');

                        permissionCheckboxes.forEach(function(checkbox) {
                            checkbox.checked = isChecked;
                        });
                    });
                });

                // İzin checkbox'ları değiştiğinde kategori checkbox'ını güncelle
                document.querySelectorAll('.permission-checkbox').forEach(function(permissionCheckbox) {
                    permissionCheckbox.addEventListener('change', function() {
                        const accordionItem = this.closest('.accordion-item');
                        const categoryCheckbox = accordionItem.querySelector('.category-checkbox');
                        const permissionCheckboxes = accordionItem.querySelectorAll('.permission-checkbox');
                        const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
                        categoryCheckbox.checked = allChecked;
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

