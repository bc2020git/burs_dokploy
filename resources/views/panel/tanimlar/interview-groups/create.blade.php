@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yeni Mülakat Grubu
@endsection

@section('local-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-selection {
        min-height: 38px !important;
    }
</style>
@endsection

@section('content')
<main class="main-content px-3 py-4">
    <div class="mt-1">
        <form action="{{ route('mulakat-grup.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <a href="{{ route('mulakat-grup.index') }}" class="btn btn-danger me-3">Vazgeç</a>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Grup Adı</label>
                        <input id="name" type="text" class="form-control" name="name" placeholder="Grup Adı Giriniz" >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="members" class="form-label">Üyeler</label>
                        <select class="form-select @error('members') is-invalid @enderror"
                                id="members" name="members[]" multiple required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} {{ $user->surname }}
                                </option>
                            @endforeach
                        </select>
                        @error('members')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#members').select2({
            theme: 'bootstrap-5',
            placeholder: 'Üye seçiniz',
            allowClear: true
        });
    });
</script>
@endsection
