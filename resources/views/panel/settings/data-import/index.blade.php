@extends('layouts.master')
@section('title')
    Data Import
@endsection
@section('page-title')
    Data Import
@endsection
@section('local-css')
    <!-- Mevcut CSS'ler -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>

        /* Toastr özelleştirmeleri */
        #toast-container > div {
            opacity: 1;
            box-shadow: 0 0 12px rgba(0,0,0,.1);
        }

        .toast-success {
            background-color: #4CAF50;
        }

        .toast-error {
            background-color: #F44336;
        }
    </style>
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
                                    onclick="window.location.href='{{route('data-import.create')}}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                                </svg>
                                Data Import
                            </button>

                    </div>
                </div>
                    <div class="btn-toolbar  mb-md-0">
                        <div class="d-flex align-items-center">
                        </div>
                        <div class="dropdown-export me-3">
                            <button type="button" class="btn report me-3" id="reportExport" data-bs-toggle="dropdown"
                              aria-expanded="false">

                              Örnek Dosya İndir
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                  d="M10.636 10.9498L15.5858 6L17 7.41422L10.636 13.7782L4.27212 7.41422L5.68632 6L10.636 10.9498Z"
                                  fill="#FF2FF7" />
                              </svg>
                            </button>
                            <ul class="dropdown-menu"  aria-labelledby="export">
                              <li>
                                <a onclick="window.location.href='{{route('data-import.example-file-download',['type'=>'Universite'])}}'" class="dropdown-item" href="#">
                                  Üniversite
                                </a>
                              </li>
                              <li>
                                <a onclick="window.location.href='{{route('data-import.example-file-download',['type'=>'Fakulte'])}}'" class="dropdown-item" href="#">
                                  Fakülte
                                </a>
                              </li>
                              <li>
                                <a onclick="window.location.href='{{route('data-import.example-file-download',['type'=>'Bolumler'])}}'" class="dropdown-item" href="#">
                                  Bölüm
                                </a>
                              </li>
                              <li>
                                <a onclick="window.location.href='{{route('data-import.example-file-download',['type'=>'Aday_Bursiyerler'])}}'" class="dropdown-item" href="#">
                                  Aday Bursiyerler
                                </a>
                              </li>
                              <li>
                                <a onclick="window.location.href='{{route('data-import.example-file-download',['type'=>'Kayit_Yenileme'])}}'" class="dropdown-item" href="#">
                                  Kayıt  Yenileme
                                </a>
                              </li>
                              <li>
                                <a onclick="window.location.href='{{route('data-import.example-file-download',['type'=>'Bursiyerler'])}}'" class="dropdown-item" href="#">
                                  Bursiyerler
                                </a>
                              </li>
                              <li>
                                <a onclick="window.location.href='{{route('data-import.example-file-download',['type'=>'Mezunlar'])}}'" class="dropdown-item" href="#">
                                  Mezunlar
                                </a>
                              </li>
                            </ul>
                          </div>
                          @include('components.panel.export-buttons')
                        <button type="button" class="btn btn-sm me-3" id="search"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Ara">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M15.0258 13.8474L18.5948 17.4163L17.4163 18.5948L13.8473 15.0259C12.5641 16.0526 10.9367 16.6667 9.16667 16.6667C5.02667 16.6667 1.66667 13.3067 1.66667 9.16675C1.66667 5.02675 5.02667 1.66675 9.16667 1.66675C13.3067 1.66675 16.6667 5.02675 16.6667 9.16675C16.6667 10.9367 16.0525 12.5642 15.0258 13.8474ZM13.3539 13.2291C14.3729 12.1789 15 10.7464 15 9.16675C15 5.94383 12.3896 3.33341 9.16667 3.33341C5.94376 3.33341 3.33334 5.94383 3.33334 9.16675C3.33334 12.3897 5.94376 15.0001 9.16667 15.0001C10.7463 15.0001 12.1788 14.373 13.229 13.354L13.3539 13.2291Z"
                                    fill="#0065FF" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="filter"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Filtrele">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M11.6654 11.6667V16.6667L8.33203 18.3333V11.6667L3.33203 4.16667V2.5H16.6654V4.16667L11.6654 11.6667ZM5.33511 4.16667L9.9987 11.162L14.6623 4.16667H5.33511Z"
                                    fill="#4069E5" />
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
                                </svg>Sütunlar
                            </button>
                            <div class="dropdown-menu" aria-labelledby="column">
                                <div class="form-check">
                                    <input class="colvis-checkbox" type="checkbox" id="idCheckbox" checked>
                                    <label class="form-check-label" for="idCheckbox">ID</label>
                                </div>
                                <div class="form-check">
                                    <input class="colvis-checkbox" type="checkbox" id="tcCheckbox" checked>
                                    <label class="form-check-label" for="tcCheckbox">T.C. Kimlik No.</label>
                                </div>
                                <div class="form-check">
                                    <input class="colvis-checkbox" type="checkbox" id="adCheckbox" checked>
                                    <label class="form-check-label" for="adCheckbox">Ad</label>
                                </div>
                                <div class="form-check">
                                    <input class="colvis-checkbox" type="checkbox" id="soyadCheckbox" checked>
                                    <label class="form-check-label" for="soyadCheckbox">Soyad</label>
                                </div>
                                <div class="form-check">
                                    <input class="colvis-checkbox" type="checkbox" id="telefonCheckbox" checked>
                                    <label class="form-check-label" for="telefonCheckbox">Telefon Numarası</label>
                                </div>
                                <div class="form-check">
                                    <input class="colvis-checkbox" type="checkbox" id="evAdresiCheckbox">
                                    <label class="form-check-label" for="evAdresiCheckbox">Ev Adresi</label>
                                </div>
                                <div class="form-check">
                                    <input class="colvis-checkbox" type="checkbox" id="evTelefonuCheckbox">
                                    <label class="form-check-label" for="evTelefonuCheckbox">Ev Telefonu</label>
                                </div>
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
                        @include('panel.includes.datatable-head')
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
                        <input type="date" class="form-control w-100" id="ogrenciye_burs_odeme_tarihi" name="ogrenciye_burs_odeme_tarihi" required>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        @include('panel.includes.filtreleme')
        @include('panel.settings.data-import.scriptf')


            @include('includes.js.sidebar')

        <script>
            $(document).ready(function() {
                 // Toastr ayarları
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };


                @if(Session::has('success'))
                    toastr.success("{{ Session::get('success') }}", "Başarılı!");
                @endif

                @if(Session::has('error'))
                    toastr.error("{{ Session::get('error') }}", "Hata!");
                @endif
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
        formData.append('_token', $('input[name="_token"]').val());

        $.ajax({
            url: '{{ route("update-payment-info") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    alert('Ödeme bilgileri başarıyla güncellendi.');
                    $('#addPaymentInfoModal').modal('hide');
                    location.reload();
                } else {
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
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
        fetch('{{ route("data-import.delete-bulk") }}', {
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
                // Başarılı silme işlemi sonrası tabloyu güncelle

                alert('Seçili kayıtlar başarıyla silindi!');
                location.reload();
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

    <script
@endsection
