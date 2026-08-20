@extends('layouts.master')
@section('title')
Burs Ödeme Bilgileri
@endsection
@section('page-title')
    Burs Ödeme Bilgileri
@endsection
@section('local-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">


@endsection

@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
                <div class="navbar-button-container">

                    <div class="d-flex flex-wrap">
                            <button type="button" class="btn me-3 text-white" id="newAdd" data-bs-toggle="tooltip"
                                    data-bs-placement="left"
                                    onclick="window.location.href='{{route('burs-taksiti-yarat')}}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                                </svg>
                                Burs Taksiti Yarat
                            </button>
                            <button type="button" class="btn me-3 btn-primary text-white" id="newAddOdemeBilgisi">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                                </svg>
                                Ödeme Bilgisi Ekle
                            </button>
                    </div>
                </div>
                    <div class="btn-toolbar  mb-md-0">
                        <div class="d-flex align-items-center">
                        </div>
                        <div class="dropdown">
                            <button type="button" class="btn me-3 dropdown-toggle" id="export" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M3.33334 15.8333H16.6667V10H18.3333V16.6667C18.3333 17.1269 17.9603 17.5 17.5 17.5H2.50001C2.03977 17.5 1.66667 17.1269 1.66667 16.6667V10H3.33334V15.8333ZM10.8333 7.5V13.3333H9.16667V7.5H5.00001L10 2.5L15 7.5H10.8333Z" fill="#0065FF" />
                                </svg>
                                Dışa Aktar
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8" fill="none">
                                    <path d="M6.63602 4.94978L11.5858 0L13 1.41422L6.63602 7.77818L0.272121 1.41422L1.68632 0L6.63602 4.94978Z" fill="#0065FF" />
                                </svg>
                            </button>
                            <ul class="dropdown-menu" id="" aria-labelledby="export">
                                <li><a class="dropdown-item" href="#" id="pdfButton">
                                    <img src="../assets/images/pdf.svg" alt="PDF" width="24" height="24">
                                    PDF olarak aktar
                                </a></li>
                                <li><a class="dropdown-item" href="#" id="excelButton">
                                    <img src="../assets/images/excel.svg" alt="Excel" width="24" height="24">
                                    Excel dosyasında aktar
                                </a></li>
                                <li id="wordExport" ><a class="dropdown-item" href="#">
                                    <img src="../assets/images/word.svg" alt="Word" width="24" height="24">
                                    Word dosyasında aktar
                                </a></li>
                                <li><a class="dropdown-item" href="#" id="csvButton">
                                    <img src="../assets/images/csv.svg" alt="CSV" width="24" height="24">
                                    .csv olarak aktar
                                </a></li>
                            </ul>
                        </div>

                        <button type="button" class="btn btn-sm me-3" id="search"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Ara">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M15.0258 13.8474L18.5948 17.4163L17.4163 18.5948L13.8473 15.0259C12.5641 16.0526 10.9367 16.6667 9.16667 16.6667C5.02667 16.6667 1.66667 13.3067 1.66667 9.16675C1.66667 5.02675 5.02667 1.66675 9.16667 1.66675C13.3067 1.66675 16.6667 5.02675 16.6667 9.16675C16.6667 10.9367 16.0525 12.5642 15.0258 13.8474ZM13.3539 13.2291C14.3729 12.1789 15 10.7464 15 9.16675C15 5.94383 12.3896 3.33341 9.16667 3.33341C5.94376 3.33341 3.33334 5.94383 3.33334 9.16675C3.33334 12.3897 5.94376 15.0001 9.16667 15.0001C10.7463 15.0001 12.1788 14.373 13.229 13.354L13.3539 13.2291Z"
                                    fill="#0065FF" />
                            </svg>
                        </button>
                        <button  onclick="secilenKayitlariSil()" type="button" class="btn btn-sm me-3" id="waste"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Sil">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM7.5013 9.16699V14.167H9.16797V9.16699H7.5013ZM10.8346 9.16699V14.167H12.5013V9.16699H10.8346ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z" fill="#4069E5"/>
                            </svg>
                        </button>
                        <div class="dropdown-columns">
                            <button type="button" class="btn btn-primary me-3" id="column" data-bs-toggle="dropdown"
                                    aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="left" title="Sütunlar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
                                    <path
                                        d="M9.16667 4.16667H4.16667V15.8333H9.16667V4.16667ZM10.8333 4.16667V15.8333H15.8333V4.16667H10.8333ZM3.33333 2.5H16.6667C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5Z"
                                        fill="#0065FF" />
                                </svg>
                            </button>
                            @php $docColumns = ['doc_ogrenciBelgesi','doc_adlisicilkaydi','doc_nufuskayitornegi','doc_annegelirbelgesi','doc_babagelirbelgesi','doc_taahhutname','doc_kimlik','doc_bankahesap','doc_transkript','doc_ikametgah','doc_Karne','doc_Diger']; @endphp
                            <div class="dropdown-menu" id="colvis-menu"  aria-labelledby="column">
                                @foreach($columns as $column)
                                <div class="form-check">
                                    <input class="form-check-input column-visibility"
                                           type="checkbox"
                                           id="{{ $column['name'] }}Checkbox"
                                           data-column="{{ $column['name'] }}"
                                           @if(!in_array($column['name'], $docColumns)) checked @endif>
                                    <label class="form-check-label" for="{{ $column['name'] }}Checkbox">
                                        {{ $column['title'] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary" id="reload"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                                <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z"  fill="#4069E5" ></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table  class="table table-hover" id="paymentInfoTable">
                        @include('panel.includes.datatable-head-guncel')
                        <tbody id="paymentInfoTableBody">

                        </tbody>
                    </table>
                </div>
            </div>        </main>
        <!--Modal Alanı-->
<!-- Ödeme Bilgisi Ekle Modal -->
<div class="modal fade" id="addPaymentInfoModal" tabindex="-1" aria-labelledby="addPaymentInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentInfoModalLabel">Ödeme Bilgisi Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body w-100">
                <form id="addPaymentInfoForm">
                    @csrf
                    <div class="mb-3">
                        <label for="ogrenciye_burs_odeme_tarihi" class="form-label">Öğrenciye Burs Ödeme Tarihi</label>
                        <input type="date" class="form-control w-100 date-input" id="ogrenciye_burs_odeme_tarihi" name="ogrenciye_burs_odeme_tarihi" required>
                    </div>
                    <div class="mb-3 row  px-2">
                        <div class="col-md-6 form-check">
                            <input class="form-check-input" type="checkbox" checked="" id="sms_check">
                            <label class="form-check-label mt-1" for="sms_check">
                                <u>Sms</u> gönder
                            </label>
                        </div>
                        <div class="col-md-6 form-check">
                            <input class="form-check-input" type="checkbox" checked="" id="email_check">
                            <label class="form-check-label mt-1" for="email_check">
                                <u>Email</u> gönder
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-primary" id="confirmAddPaymentInfo">Onayla</button>
            </div>
        </div>
    </div>
</div>

<!-- Uyarı Modalı -->
<div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warningModalLabel">Uyarı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Lütfen burs taksiti seçiniz!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tamam</button>
            </div>
        </div>
    </div>
</div>
@include('includes.js.toastr')

    @endsection
    @section('scripts')
        <!-- App js -->
        <!-- Select2 CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

        <!-- jQuery -->

        <!-- Select2 JS -->
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>
    <!-- Toastr kütüphanesi - jQuery'den sonra yükle -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Toastr ayarları
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
    </script>
        @include('includes.js.sendsms')
        @include('panel.scholarship-payment-information.filtre')


            @include('includes.js.sidebar')

        <script>
            $(document).ready(function() {
                // Tablo satırına çift tıklama olayı
                $('.redirect-row').on('dblclick', function() {
                    const candidateId = $(this).data('id'); // Satırdan aday ID'sini al
                    const url = "{{ route('burs-odeme-duzenle', ['id' => ':id']) }}".replace(':id', candidateId);
                    window.location.href = url; // İlgili sayfaya yönlendir
                });
            });
        </script>
<script>
$(document).ready(function() {
    $('#addPaymentInfoModal').on('shown.bs.modal', function () {
        $('.select2').select2({
            dropdownParent: $('#addPaymentInfoModal')
        });
    });
    $(document).ready(function() {
        $('.select2').select2({
            minimumResultsForSearch: Infinity // Arama çubuğunu gizler
        });
    });
// Ödeme Bilgisi Ekle butonuna tıklandığında
$('#newAddOdemeBilgisi').click(function(e) {
    e.preventDefault();

    const secilenler = document.querySelectorAll('tbody input[type="checkbox"]:checked');

    if (secilenler.length === 0) {
        // Var olan warning modalı göster
        $('#warningModal').modal('show');
    } else {
        // Seçili kayıt varsa ödeme bilgisi modalını aç
        $('#addPaymentInfoModal').modal('show');
    }
});
    $('#confirmAddPaymentInfo').click(function() {
        // Seçili checkbox'ları bul
        const secilenler = document.querySelectorAll('tbody input[type="checkbox"]:checked');

        if (secilenler.length === 0) {
            // Bootstrap modal ile uyarı göster
            let warningModal = new bootstrap.Modal(document.createElement('div'));
            warningModal.element.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Uyarı</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Lütfen burs taksiti seçiniz!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tamam</button>
                        </div>
                    </div>
                </div>
            `;
            warningModal.show();
            return;
        }

        // Seçili kayıtların ID'lerini al
        const secilenIdler = Array.from(secilenler)
            .filter(checkbox => checkbox.value && checkbox.value !== 'on')
            .map(checkbox => checkbox.value);

        var formData = new FormData();
        formData.append('odeme_ids', JSON.stringify(secilenIdler));
        formData.append('ogrenciye_burs_odeme_tarihi', $('#ogrenciye_burs_odeme_tarihi').val());
        formData.append('sms_check', $('#sms_check').is(':checked') ? 'on' : 'off');
        formData.append('email_check', $('#email_check').is(':checked') ? 'on' : 'off');
        formData.append('_token', $('input[name="_token"]').val());

        $.ajax({
            url: '{{ route("update-payment-info") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    toastr.success( 'İşlem Başarılı');
                    $('#addPaymentInfoModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error('İşlem Başarısız');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function() {
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            }
        });
    });
});
function secilenKayitlariSil() {
    // Seçili olan checkbox'ları bul
    const secilenler = document.querySelectorAll('tbody input[type="checkbox"]:checked');

    if (secilenler.length === 0) {
        alert('Lütfen silinecek kayıtları seçiniz!');
        return;
    }

    // Seçili kayıtların ID'lerini al
    const silinecekIdler = Array.from(secilenler)
        .filter(checkbox => checkbox.value && checkbox.value !== 'on') // 'on' değerini filtrele
        .map(checkbox => checkbox.value);

    if (silinecekIdler.length === 0) {
        alert('Lütfen silinecek kayıtları seçiniz!');
        return;
    }

    // Kullanıcıya onay sor
    if (confirm(`${secilenler.length} adet kaydı silmek istediğinizden emin misiniz?`)) {
        // AJAX ile silme işlemi
        fetch('/burs-odeme-bilgi/toplu-sil', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ idler: silinecekIdler })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                 toastr.success('İşlem Başarılı');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
            } else {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Hata:', error);
            alert('İşlem sırasında bir hata oluştu!');
        });
    }
}
</script>
@endsection
