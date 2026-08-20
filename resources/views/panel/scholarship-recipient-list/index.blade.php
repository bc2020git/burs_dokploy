@extends('layouts.master')
@section('title')
    Bursiyerler
@endsection
@section('page-title')
    Bursiyerler
@endsection
@section('local-css')
<style>
    .dropdown{
        border:none !important;
        height: initial !important;
    }
</style>
    <link rel="stylesheet" href="{{ url('') }}/public/assets/css/panel/export-modal.css">
    <link rel="stylesheet" href="https://datatables-cdn.com/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="navbar-button-container">
                    <div class="d-flex flex-wrap">
                        <a href="{{route('add-manuel-active')}}">
                            <button type="button" class="btn me-3 text-white"  id="newAdd">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                                </svg>
                                Yeni
                            </button>
                        </a>

                    </div>
                    <div class="navbar-button-container">
                        <button type="button" class="btn me-3 text-white" id="bursiyerTipGuncelle">
                            <i class="fas fa-exchange-alt"></i>
                            Bursiyer Tipi Güncelle
                        </button>
                        <button type="button" class="btn me-3 text-white" id="graduate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M10 1.66675L0 7.50008L10 13.3334L18.3333 8.47233V14.5834H20V7.50008L10 1.66675ZM3.33252 11.2422V15.0002C4.85287 17.0242 7.27343 18.3335 9.99983 18.3335C12.7262 18.3335 15.1467 17.0242 16.6671 15.0002L16.6667 11.2428L10.0003 15.1317L3.33252 11.2422Z"
                                    fill="white" />
                            </svg>Mezun Et
                        </button>
                        <button type="button" class="btn btn-outline-danger" id="cancel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z" fill="#A82200"></path>
                            </svg>
                            Burs İptal
                        </button>
                        <div class="dropdown-export">
                            <button type="button" class="btn me-3" id="export" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
                                    <path
                                        d="M3.33334 15.8333H16.6667V10H18.3333V16.6667C18.3333 17.1269 17.9603 17.5 17.5 17.5H2.50001C2.03977 17.5 1.66667 17.1269 1.66667 16.6667V10H3.33334V15.8333ZM10.8333 7.5V13.3333H9.16667V7.5H5.00001L10 2.5L15 7.5H10.8333Z"
                                        fill="#0065FF" />
                                </svg>
                                Dışa Aktar
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8"
                                     fill="none">
                                    <path
                                        d="M6.63602 4.94978L11.5858 0L13 1.41422L6.63602 7.77818L0.272121 1.41422L1.68632 0L6.63602 4.94978Z"
                                        fill="#0065FF" />
                                </svg>
                            </button>
                            <ul class="dropdown-menu " aria-labelledby="export">
                                <li id="pdfButton" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/pdf.svg" alt="PDF" width="24" height="24">
                                        PDF olarak aktar
                                    </a></li>
                                <li id="excelButton" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/excel.svg" alt="Excel" width="24" height="24">
                                        Excel dosyasında aktar
                                    </a></li>
                                <li id="wordExport" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/word.svg" alt="Word" width="24" height="24">
                                        Word dosyasında aktar
                                    </a></li>
                                <li id="csvButton" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/csv.svg" alt="CSV" width="24" height="24">
                                        .csv olarak aktar
                                    </a></li>
                                    <li id="topluIndirBtn" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/excel.svg" alt="Toplu Aktar" width="24" height="24">
                                        Toplu Aktar
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <button onclick="sendEmails()" type="button" class="btn me-3 btn-outline-info" id="mail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M2.5 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.5C2.03976 17.5 1.66666 17.1269 1.66666 16.6667V3.33333C1.66666 2.8731 2.03976 2.5 2.5 2.5ZM16.6667 6.0316L10.0598 11.9483L3.33333 6.01328V15.8333H16.6667V6.0316ZM3.75955 4.16667L10.0516 9.71833L16.2508 4.16667H3.75955Z"
                                    fill="#8353E2" />
                            </svg>
                            E-Posta
                        </button>
                        <button type="button" class="btn btn-outline-warning" id="sms">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path
                                    d="M4.80235 14.1667H16.6667V4.16667H3.33333V15.3209L4.80235 14.1667ZM5.37879 15.8333L1.66667 18.75V3.33333C1.66667 2.8731 2.03977 2.5 2.5 2.5H17.5C17.9603 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9603 15.8333 17.5 15.8333H5.37879Z"
                                    fill="#FF8B00" />
                            </svg>
                            SMS
                        </button>
                        <button onclick="$('#graduateTable_filter label').toggleClass('d-none');" type="button" class="btn btn-outline-primary" id="search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="waste">
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

                                @if(isset($allQuestions) && count($allQuestions) > 0)
                                    <hr class="dropdown-divider">
                                    <div class="dropdown-header">Tüm Alanlar</div>
                                    @foreach ($allQuestions as $question)
                                        <div class="form-check">
                                            <input class="form-check-input question-column" type="checkbox"
                                                id="question_{{ $question->db_key }}Checkbox" data-column="{{ $question->db_key }}"
                                                data-title="{{ $question->title }}">
                                            <label class="form-check-label" for="question_{{ $question->db_key }}Checkbox">
                                                {{ $question->title }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary" id="reload" data-bs-toggle="tooltip"
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

                <div class="table-responsive mt-3">
                    <table class="table table-hover" id="graduateTable">
                        @include('panel.includes.datatable-head-guncel')
                        <tbody id="graduateTableBody">

                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!--Modal Alanı-->

                @include('panel.scholarship-recipient-list.modals')
                @include('includes.js.toastr')

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
            <!-- Toastr kütüphanesi - jQuery'den sonra yükle -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Toastr ayarları
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "1000"
        };
    </script>
        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        @include('includes.js.sendsms')
        @include('panel.includes.scholarship-recipient-list-scripts')
        @include('panel.includes.scholarship-recipient-list-scripts2')


        @include('includes.js.tableSmsbutton')




        <script>
            function sortTable(column, order) {
                const table = document.getElementById("graduateTable");
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

                @include('includes.js.sidebar')
        <script src="../assets/js/components/dashboard.js"></script>
        <script src="../assets/js/components/modal.js"></script>
        <script src="../assets/js/tables/scholar-table.js"></script>
        <script src="../assets/js/registration.renewal.js"></script>
@endsection
