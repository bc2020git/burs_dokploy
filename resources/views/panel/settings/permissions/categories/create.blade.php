@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    İzin Kategorisi Ekle
@endsection
@section('body')
    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class="mt-1">
                <form action="{{ route('permission-categories.store') }}" method="POST">
                    @csrf
                    <div class='row'>
                        <div class='col-12'>
                            <div class="form-group">
                                <label for="title">Kategori Adı</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="description">Açıklama</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('permissions.index') }}" class="btn btn-secondary me-2">İptal</a>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </main>
    @endsection
    @include('includes.js.sidebar')
@endsection
