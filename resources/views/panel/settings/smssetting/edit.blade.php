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
        <h3>İzinler</h3>
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

@endsection

