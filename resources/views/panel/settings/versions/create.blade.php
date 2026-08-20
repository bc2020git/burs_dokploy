
@extends('layouts.master')
@section('title') Versiyon Ekle @endsection
@section('navbar-form')
    <form action="#" class="d-none d-sm-inline-block">
        <div class="input-group input-group-navbar">
        <span>Versiyonlar / <strong>Versiyon Ekle</strong></span>
        </div>
    </form>
@endsection
@section('local-css')
    <!-- Bootstrap 4 CSS (Summernote için gerekli) -->
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
    <form action="{{ route('versions.store') }}" method="POST">
        @csrf

        <div class='row'>
            <div class='col-6'>
                <div class="form-group">
                    <label for="frontend_version">Frontend Versiyonu</label>
                    <input type="text" name="frontend_version" id="frontend_version" class="form-control" required>
                </div>
            </div>
            <div class='col-6'>
                <div class="form-group">
                    <label for="frontend_date">Frontend Tarihi</label>
                    <input type="date" name="frontend_date" id="frontend_date" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class='col-6'>
                <div class="form-group">
                    <label for="backend_version">Backend Versiyonu</label>
                    <input type="text" name="backend_version" id="backend_version" class="form-control" required>
                </div>
            </div>
            <div class='col-6'>
                <div class="form-group">
                    <label for="backend_date">Backend Tarihi</label>
                    <input type="date" name="backend_date" id="backend_date" class="form-control" required>
                </div>
            </div>
        </div>
            <label for="description">Açıklama</label>
            <textarea  name="description" id="summernote" class="form-control w-100"></textarea>
        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-tr-TR.min.js"></script>

<!-- Summernote Initialize -->
<script>
    $(document).ready(function() {
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
                onImageUpload: function(files) {
                    // Resim yükleme devre dışı
                    return false;
                }
            }
        });
    });
</script>

<script src="{{url('')}}/assets/js/components/dashboard.js"></script>
<script src="{{url('')}}/assets/js/components/scholarmodal.js"></script>
<script src="{{url('')}}/assets/js/tables/banks.js"></script>
<script>





// Tarih seçicileri için Pikaday ayarları
function initializeDatePickers() {
    const commonConfig = {
        format: 'DD.MM.YYYY',
        i18n: {
            previousMonth: 'Önceki Ay',
            nextMonth: 'Sonraki Ay',
            months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
            weekdaysShort: ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt']
        },
        firstDay: 1
    };

    // Ödeme Başlangıç Tarihi için Pikaday
    new Pikaday({
        ...commonConfig,
        field: document.getElementById('aidatBasOdemeTarihi'),
        trigger: document.getElementById('aidatBasOdemeTarihiIcon'),
        onSelect: function(date) {
            // Son ödeme tarihi picker'ının minimum tarihini güncelle
            sonOdemePicker.setMinDate(date);
        }
    });

    // Son Ödeme Tarihi için Pikaday
    const sonOdemePicker = new Pikaday({
        ...commonConfig,
        field: document.getElementById('aidatSonOdemeTarihi'),
        trigger: document.getElementById('aidatSonOdemeTarihiIcon')
    });
}

// Sayfa yüklendiğinde tarih seçicileri başlat
document.addEventListener('DOMContentLoaded', function() {
    initializeDatePickers();
});
</script>
@endsection

