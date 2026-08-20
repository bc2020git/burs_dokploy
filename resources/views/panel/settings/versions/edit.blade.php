@extends('layouts.master')
@section('title') Versiyon Düzenle @endsection
@section('navbar-form')
    <form action="#" class="d-none d-sm-inline-block">
        <div class="input-group input-group-navbar">
            <span>Versiyonlar / <strong>Versiyon Düzenle</strong></span>
        </div>
    </form>
@endsection

@section('local-css')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            width: 100% !important;
        }
        .note-editable {
            background-color: white;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid mt-2">
    <form action="{{ route('versions.update', ['version' => $version->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class='row'>
            <div class='col-6'>
                <div class="form-group">
                    <label for="frontend_version">Frontend Versiyonu</label>
                    <input type="text" name="frontend_version" id="frontend_version" class="form-control" value="{{ $version->frontend_version }}" required>
                </div>
            </div>
            <div class='col-6'>
                <div class="form-group">
                    <label for="frontend_date">Frontend Tarihi</label>
                    <input type="date" name="frontend_date" id="frontend_date" class="form-control"
                        value="{{ date('Y-m-d', strtotime($version->frontend_date)) }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class='col-6'>
                <div class="form-group">
                    <label for="backend_version">Backend Versiyonu</label>
                    <input type="text" name="backend_version" id="backend_version" class="form-control" value="{{ $version->backend_version }}" required>
                </div>
            </div>
            <div class='col-6'>
                <div class="form-group">
                    <label for="backend_date">Backend Tarihi</label>
                    <input type="date" name="backend_date" id="backend_date" class="form-control"
                        value="{{ date('Y-m-d', strtotime($version->backend_date)) }}" required>
                </div>
            </div>
        </div>

        <div class="form-group w-100">
            <label for="description">Açıklama</label>
            <textarea name="description" id="summernote" class="form-control w-100">{{ $version->description }}</textarea>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('versions.index') }}" class="btn btn-secondary me-2">İptal</a>
            <button type="submit" class="btn btn-primary">Güncelle</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
     <!-- jQuery ve Bootstrap 4 JS (Summernote için gerekli) -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

     <!-- Summernote JS -->
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-tr-TR.min.js"></script>

    <!-- Summernote Initialize -->
    <script>
        $(document).ready(function() {
            // Summernote yüklenip yüklenmediğini kontrol et
            if (typeof $.fn.summernote === 'undefined') {
                console.error('Summernote yüklenemedi!');
                return;
            }

            $('#summernote').summernote({
                height: 300,
                lang: 'tr-TR',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onInit: function() {
                        console.log('Summernote başarıyla başlatıldı');
                    },
                    onImageUpload: function(files) {
                        return false;
                    }
                }
            });

            // Container genişliğini ayarla
            $('.note-editing-area').css('width', '100%');
            $('.note-editor').css('width', '100%');
        });
    </script>
@endsection

