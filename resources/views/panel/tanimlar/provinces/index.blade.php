@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
     İller
@endsection
@php
    $modelName = 'Il';
    $tableId = 'provinceTableBody';
    $relations = [];
    $where = [];

    // Iliskili tablolarin sutunlarini mapping'lerini tanımla
    $columnMappings = [

    ];
@endphp
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="navbar-button-container">
                    <div class="d-flex flex-wrap">
                        <button type="button" class="btn me-3 text-white" id="newAdd" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Yeni İl Ekle"
                                onclick="window.location.href='{{route('add-province')}}'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                            </svg>
                            Yeni
                        </button>
                    </div>
                    <div class="navbar-button-container">
                        <button type="button" class="btn" id="bursCheck">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16658C11.8423 9.16658 13.334 7.67492 13.334 5.83325C13.334 3.99158 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99158 6.66732 5.83325C6.66732 7.67492 8.15898 9.16658 10.0007 9.16658ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z"
                                    fill="#fff" />
                            </svg>
                            Burs veriliyor mu?
                        </button>
                        <x-export-buttons table-id="provinceTable" model="il" />
                        <button type="button" class="btn btn-outline-primary me-3" id="search" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Ara">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M15.0252 13.8477L18.5941 17.4166L17.4156 18.5951L13.8467 15.0262C12.5634 16.0528 10.936 16.667 9.16602 16.667C5.02602 16.667 1.66602 13.307 1.66602 9.16699C1.66602 5.02699 5.02602 1.66699 9.16602 1.66699C13.306 1.66699 16.666 5.02699 16.666 9.16699C16.666 10.937 16.0518 12.5644 15.0252 13.8477ZM13.3533 13.2293C14.3723 12.1792 14.9993 10.7467 14.9993 9.16699C14.9993 5.94408 12.3889 3.33366 9.16602 3.33366C5.9431 3.33366 3.33268 5.94408 3.33268 9.16699C3.33268 12.3899 5.9431 15.0003 9.16602 15.0003C10.7457 15.0003 12.1782 14.3732 13.2283 13.3542L13.3533 13.2293Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="filter" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Filtrele">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M11.6673 11.6667V16.6667L8.33398 18.3333V11.6667L3.33398 4.16667V2.5H16.6673V4.16667L11.6673 11.6667ZM5.33707 4.16667L10.0007 11.162L14.6642 4.16667H5.33707Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="waste" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Sil">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                    fill="#4069E5" />
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
                            <div class="dropdown-menu" id="colvis-menu" aria-labelledby="column">
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
                        <button type="button" class="btn btn-outline-primary me-3" id="reload"   onclick="location.reload();" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                 viewBox="0 0 30 30">
                                <path
                                    d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z"
                                    fill="#4069E5"></path>
                            </svg>
                        </button>
                    </div>
                </div>


                <div class="form-container1">
                    <div class="mt-1">
                        <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link active" id="waiting-interview-tab" data-bs-toggle="tab"
                                     data-bs-target="#waiting-interview" type="button" role="tab"
                                     aria-controls="waiting-interview" aria-selected="true" data-target="1">Bekleyen
                                     Mülakatlar</button>
                             </li>
                              <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="completed-interview-tab" data-bs-toggle="tab"
                                     data-bs-target="#completed-interview" type="button" role="tab"
                                     aria-controls="completed-interview" aria-selected="false" data-target="2">Tamamlanan
                                     Mülakatlar</button>
                             </li>

                         </ul> -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="waiting-interview" role="tabpanel"
                                 aria-labelledby="waiting-interview-tab" data-content="1">
                                <div class="table-responsive mt-3">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-hover" id="provinceTable">
                                            @include('panel.includes.datatable-head-guncel')
                                            <tbody id="provinceTableBody">


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!--Modal Alanı-->
        <div class="modal fade" id="bursModal" tabindex="-1" aria-labelledby="bursModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M11.3633 11.2497C11.6572 10.4143 12.2372 9.70987 13.0007 9.26115C13.7642 8.81243 14.6619 8.64841 15.5348 8.79813C16.4076 8.94784 17.1993 9.40164 17.7696 10.0791C18.34 10.7566 18.6521 11.6141 18.6508 12.4997C18.6508 14.9997 14.9008 16.2497 14.9008 16.2497"
                                stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 21.25H15.0125" stroke="#8353E2" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round" />
                        </svg>
                        <div class="col-md-12">
                            <label for="bursVeriliyorMuDurum" class="custom-label">Bu İlçe/İlçelere Burs Veriliyor
                                Mu?</label>
                            <select class="form-control" name="bursVeriliyorMuDurum" id="bursVeriliyorMuDurum">
                                <option disabled value="seçenekler">Burs verilme durumunu seçiniz</option>
                                <option value="1" id="confirmYes">Evet</option>
                                <option value="0" id="confirmNo">Hayır</option>
                            </select>
                            <div class="col-md-12 mt-3">
                                <label>Burs Verilen Eğitim Seviyeleri</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="schooltype" value="ilkokul" id="ilkokul">
                                            <label class="form-check-label" for="ilkokul">İlkokul</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="schooltype" value="ortaokul" id="ortaokul">
                                            <label class="form-check-label" for="ortaokul">Ortaokul</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="schooltype" value="lise" id="lise">
                                            <label class="form-check-label" for="lise">Lise</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="schooltype" value="onLisans" id="onlisans">
                                            <label class="form-check-label" for="onLisans">Ön Lisans</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="schooltype" value="lisans" id="lisans">
                                            <label class="form-check-label" for="lisans">Lisans</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="schooltype" value="yuksekLisans" id="yukseklisans">
                                            <label class="form-check-label" for="yuksekLisans">Yüksek Lisans</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="schooltype" value="doktora" id="doktora">
                                            <label class="form-check-label" for="doktora">Doktora</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-outline-success me-3" id="confirmBursDurum"
                                data-bs-dismiss="modal">Tümüne
                            Uygula</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Vazgeç</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Uyarı Modali -->
        <div class="modal fade" id="interviewWarningModal" tabindex="-1" aria-labelledby="interviewWarningModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="interviewWarningModalLabel">Uyarı</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body fw-medium">
                        Lütfen en az bir satır seçiniz.
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <!-- App js -->

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


        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="{{url('')}}/assets/js/tables/interview.js"></script>
        <script src="{{url('')}}/assets/js/tables/completed-interview.js"></script>
        @include('panel.tanimlar.provinces.scriptf')
        <script>
            document.getElementById('bursCheck').addEventListener('click', function () {
                const checkboxes = document.querySelectorAll('.user-checkbox');
                let isChecked = false;

                checkboxes.forEach(function (checkbox) {
                    if (checkbox !== document.getElementById('masterCheckbox') && checkbox.checked) {
                        isChecked = true;
                    }
                });

                if (isChecked) {
                    const bursModal = new bootstrap.Modal(document.getElementById('bursModal'));
                    bursModal.show();
                } else {
                    const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                    interviewWarningModal.show();
                }
            });

            function islemIcinDiziGonder(islemid) {
                // Tüm checkbox'ları seç
                const selectedIds = [];
                const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                // Her bir işaretli checkbox'ın 'data-id' değerini al
                checkboxes.forEach(checkbox => {
                    const userId = checkbox.getAttribute('data-id');
                    if (userId) {
                        selectedIds.push(userId);
                    }
                });
                const islemId = islemid;
                const bv_ilkokul = document.querySelector('input[id="ilkokul"]').checked ? 1 : 0;
                const bv_ortaokul = document.querySelector('input[id="ortaokul"]').checked ? 1 : 0;
                const bv_lise = document.querySelector('input[id="lise"]').checked ? 1 : 0;
                const bv_onlisans = document.querySelector('input[id="onlisans"]').checked ? 1 : 0;
                const bv_lisans = document.querySelector('input[id="lisans"]').checked ? 1 : 0;
                const bv_yukseklisans = document.querySelector('input[id="yukseklisans"]').checked ? 1 : 0;
                const bv_doktora = document.querySelector('input[id="doktora"]').checked ? 1 : 0;
                const bursDurumElement = document.getElementById('bursVeriliyorMuDurum');
                const bursDurumValue = bursDurumElement.options[bursDurumElement.selectedIndex].value;

                $.ajax({
                    url: '{{route('delete_multiple_province')}}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds,
                        islemId: islemId,
                        bv_ilkokul: bv_ilkokul,
                        bv_ortaokul: bv_ortaokul,
                        bv_lise: bv_lise,
                        bv_onlisans: bv_onlisans,
                        bv_lisans: bv_lisans,
                        bv_yukseklisans: bv_yukseklisans,
                        bv_doktora: bv_doktora,
                        bursDurum: bursDurumValue,
                    },
                    success: function(response) {
                        if (response.success && response.file_url) {
                            // Dosya indirme işlemi için gizli bir link oluştur
                            var link = document.createElement('a');
                            link.href = response.file_url;
                            link.download = response.file_name;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        } else if (response.success) {
                            // Diğer başarılı işlemler için

                        }
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Hatası:", status, error);
                        console.error("Hata Detayları:", xhr.responseText);
                        toastr.error('İşlem sırasında bir hata oluştu');
                    }
                });
            }
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('updateInterviewDetails').addEventListener('click', function () {
                    $('#updateInterviewModal').modal('hide');
                    $('#interviewDetailsModal').modal('show');
                });

                document.getElementById('concludeInterview').addEventListener('click', function () {
                    $('#updateInterviewModal').modal('hide');
                    $('#concludeInterviewModal').modal('show');
                });



            });
        </script>
<script>
    $(document).ready(function() {
        $('#pdfButton').on('click', function() {
            table.button('.buttons-pdf').trigger();
        });

        $('#excelButton').on('click', function() {
            table.button('.buttons-excel').trigger();
        });
        $('#waste').on('click', function() {
            islemIcinDiziGonder(1);
        });
        $('#confirmBursDurum').on('click', function() {
            islemIcinDiziGonder(2);
        });
        $('#topluIndirBtn').on('click', function() {
            islemIcinDiziGonder(3);
        });

        $('#csvButton').on('click', function() {
            table.button('.buttons-csv').trigger();
        }); $('#reload').on('click', function() {
            location.reload();
        });
    });

    document.querySelectorAll('.edit-interview-info-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Butonun data attribute'lerinden bilgileri alıyoruz
            const id = this.getAttribute('data-id');
            const date = this.getAttribute('data-date');
            const time = this.getAttribute('data-time');
            const platform = this.getAttribute('data-platform');
            const person = this.getAttribute('data-person');
            const score = this.getAttribute('data-score');
            const result = this.getAttribute('data-result');
            const address = this.getAttribute('data-address');

            // Modal içindeki form alanlarını güncelliyoruz
            document.getElementById('mulakatid2').value = id;
            document.getElementById('mulakatid').value = id;
            document.getElementById('editeditinterviewDate').value = date;
            document.getElementById('editinterviewTime').value = time;
            document.getElementById('editinterviewType').value = platform;
            document.getElementById('editinterviewer').value = person;
            document.getElementById('endinterviewScore').value = score;
            document.getElementById('endinterviewResult').value = result;
            document.getElementById('editinterview_address').value = address;

            // Modalı açıyoruz
            new bootstrap.Modal(document.getElementById('updateInterviewModal')).show();
        });
    });
</script>
        <script>
            function sortTable(column, order) {
                const table = document.getElementById("interviewTable");
                const tbody = table.tBodies[0];
                const rows = Array.from(tbody.querySelectorAll("tr"));

                rows.sort((a, b) => {
                    const cellA = a.cells[column].innerText.toLowerCase();
                    const cellB = b.cells[column].innerText.toLowerCase();

                    if (order === 'asc') {
                        return cellA > cellB ? 1 : cellA < cellB ? -1 : 0;
                    } else {
                        return cellA < cellB ? 1 : cellA > cellB ? -1 : 0;
                    }
                });

                rows.forEach(row => tbody.appendChild(row));
            }
        </script>
        <script !src="">

            $(document).ready(function() {

                // Interview elementleri varsa doldur (sadece interview sayfalarında)
                const daySelect = document.getElementById("interviewDay");
                const monthSelect = document.getElementById("interviewMonth");
                const yearSelect = document.getElementById("interviewYear");
                const hourSelect = document.getElementById("interviewHour");
                const minuteSelect = document.getElementById("interviewMinute");

                // Elementler varsa devam et
                if (daySelect && monthSelect && yearSelect && hourSelect && minuteSelect) {
                    console.log('📅 Initializing interview date selectors...');

                    // Gün, Ay ve Yıl için Seçenekleri Doldur
                    for (let day = 1; day <= 31; day++) {
                        const option = document.createElement("option");
                        option.value = day;
                        option.textContent = day;
                        daySelect.appendChild(option);
                    }

                    for (let i = 1; i <= 24; i++) {
                        const option = document.createElement("option");
                        option.value = i;
                        option.textContent = i;
                        hourSelect.appendChild(option);
                    }

                    for (let i = 0; i <= 55;) {
                        const option = document.createElement("option");
                        option.value = i;
                        option.textContent = i;
                        minuteSelect.appendChild(option);
                        i = i + 5;
                    }

                    const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];
                    months.forEach((month, index) => {
                        const option = document.createElement("option");
                        option.value = index+1;
                        option.textContent = month;
                        monthSelect.appendChild(option);
                    });

                    const currentYear = new Date().getFullYear();
                    for (let year = currentYear; year >= 1900; year--) {
                        const option = document.createElement("option");
                        option.value = year;
                        option.textContent = year;
                        yearSelect.appendChild(option);
                    }

                    console.log('✅ Interview date selectors initialized');
                } else {
                    console.log('ℹ️ Interview date selectors not found (normal for this page)');
                }
            });
        </script>
            @include('includes.js.sidebar')

@endsection
