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
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">

    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Rol Adı</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Açıklama</label>
            <textarea name="description" id="description" class="form-control">{{ $role->description }}</textarea>
        </div>

        <div class="form-group mt-3">
            <label>Kullanıcı Durumu</label>
            <div class="d-flex align-items-center mt-2">
                <label class="switch me-2">
                    <input type="checkbox" class="status-switch" data-id="{{ $user->id }}" {{ $user->status == 'Aktif' ? 'checked' : '' }}>
                    <span class="slider"></span>
                    <span class="switch-text"></span>
                </label>
            </div>
        </div>

        <h3 class="mt-4">İzinler</h3>
        @foreach($permissions as $permission)
            <div class="form-check">
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" class="form-check-input" {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                <label for="permission_{{ $permission->id }}" class="form-check-label">{{ $permission->description }}</label>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
            </div>
        </main>
        <!--Modal Alanı-->
        @include('panel.tanimlar.districts.modals')
        @include('includes.js.toastr')

    @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/scholarmodal.js"></script>
        <script src="{{url('')}}/assets/js/tables/banks.js"></script>


            @include('includes.js.sidebar')

        <script>
        $(document).ready(function() {
            $('.status-switch').on('change', function() {
                const userId = $(this).data('id');
                const newStatus = $(this).prop('checked') ? 'Aktif' : 'Pasif';

                $.ajax({
                    url: `/panel/settings/users/${userId}/change-status`,
                    type: 'POST',
                    data: {
                        status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                            $(this).prop('checked', !$(this).prop('checked'));
                        }
                    },
                    error: function() {
                        toastr.error('İşlem sırasında bir hata oluştu');
                        $(this).prop('checked', !$(this).prop('checked'));
                    }
                });
            });
        });
        </script>

@endsection

@section('local-css')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 30px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #198754;
    }

    input:checked + .slider:before {
        transform: translateX(30px);
    }

    .switch-text {
        position: absolute;
        width: 100%;
        text-align: center;
        font-size: 12px;
        font-weight: bold;
        color: black;
        left: 60px;
        line-height: 30px;
        text-transform: uppercase;
        z-index: 1;
    }

    input:checked ~ .switch-text:before {
        content: "Aktif";
        padding-right: 5px;
    }

    input:not(:checked) ~ .switch-text:before {
        content: "Pasif";
        padding-left: 5px;
    }
</style>
@endsection

