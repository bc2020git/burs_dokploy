@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Burs Tipi Ekle
@endsection
@section('local-css')
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
            <div class="d-flex">

            </div>
            <div class="btn-toolbar  mb-md-0">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-primary me-3" id="kaydetVeKapatBtn" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z"
                                fill="#4069E5" />
                        </svg>
                        Kaydet ve Kapat
                    </button>
                    <button type="button" class="btn btn-outline-primary me-3"  id="kaydetBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z"
                                fill="#4069E5" />
                        </svg>
                        Kaydet
                    </button>
                </div>
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
                    <ul class="dropdown-menu " id="export-menu" aria-labelledby="export">
                        <li><a class="dropdown-item" href="#">
                                <img src="../assets/images/pdf.svg" alt="PDF" width="24" height="24">
                                PDF olarak aktar
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <img src="../assets/images/excel.svg" alt="Excel" width="24" height="24">
                                Excel dosyasında aktar
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <img src="../assets/images/word.svg" alt="Word" width="24" height="24">
                                Word dosyasında aktar
                            </a></li>
                        <li><a class="dropdown-item" href="#">
                                <img src="../assets/images/csv.svg" alt="CSV" width="24" height="24">
                                .csv olarak aktar
                            </a></li>
                    </ul>
                </div>
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
                <button type="button" class="btn btn-outline-primary me-3" id="column" data-bs-toggle="tooltip"
                        data-bs-placement="left" title="Sütunlar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M16.6667 2.5C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5H16.6667ZM9.16667 10.8333H4.16667V15.8333H9.16667V10.8333ZM10.8333 15.8333H15.8333V4.16667H10.8333V15.8333ZM9.16667 4.16667H4.16667V9.16667H9.16667V4.16667Z"
                            fill="#4069E5" />
                    </svg>
                </button>
                <button type="button" class="btn btn-outline-primary me-3" id="reload" data-bs-toggle="tooltip"
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

        <main class="main-content px-3 py-4">
            <div class="container mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{route('burs-tipleri.store')}}" id="bursTipiDetailForm" method="post" enctype="multipart/form-data" > @csrf

                                <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="bursTipi" class="custom-label">Burs Tipi</label>
                                    <input id="bursTipi" name="text" type="text" class="form-control" placeholder="Burs tipi giriniz">
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="ogrenim_tipi" class="custom-label">Öğrenim Türü</label>
                                    <select name="ogrenim_tipi" id="ogrenim_tipi" class="form-select">
                                        <option value="">Seçiniz</option>
                                        <option value="tumu">Tümü</option>
                                        <option value="ilkokul">İlkokul</option>
                                        <option value="ortaokul">Ortaokul</option>
                                        <option value="lise">Lise</option>
                                        <option value="onlisans">Ön Lisans</option>
                                        <option value="lisans">Lisans</option>
                                        <option value="yukseklisans">Yüksek Lisans</option>
                                        <option value="doktora">Doktora</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </main>
        @include('includes.js.toastr')
    @endsection

    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        @include('panel.tanimlar.bursTipi.scriptf')

        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/scholarmodal.js"></script>

<script>
    $('#reload').on('click', function() {
        location.reload();
    });
</script>
            @include('includes.js.sidebar')

@endsection
