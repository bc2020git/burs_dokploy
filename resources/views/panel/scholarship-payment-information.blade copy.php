@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Burs Ödeme Bilgileri
@endsection
@section('local-css')


@endsection
@php
    $modelName = 'BursOdemeBilgi';
    $tableId = 'paymentInfoTableBody';
    $relations = ['ogrenci'];
    $where = [];

    // Iliskili tablolarin sutunlarini mapping'lerini tanımla
    $columnMappings = [
        'tc_no' => [
            'relation' => 'ogrenci',
            'field' => 'tc_no'
        ],

        'name' => [
            'relation' => 'ogrenci',
            'field' => 'name'
        ],
        'surname' => [
            'relation' => 'ogrenci',
            'field' => 'surname'
        ],
    ];
@endphp
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
                                <li id="pdfButton" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/pdf.svg" alt="PDF" width="24" height="24">
                                        PDF olarak aktar
                                    </a></li>
                                <li id="excelButton" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/excel.svg" alt="Excel" width="24" height="24">
                                        Excel dosyasında aktar
                                    </a></li>
                                <li  ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/word.svg" alt="Word" width="24" height="24">
                                        Word dosyasında aktar
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <img src="../assets/images/csv.svg" alt="CSV" width="24" height="24">
                                        .csv olarak aktar
                                    </a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn me-3 btn-outline-info" id="mail" onclick="window.location.href='/admin/send-mail.html'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M2.5 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.5C2.03976 17.5 1.66666 17.1269 1.66666 16.6667V3.33333C1.66666 2.8731 2.03976 2.5 2.5 2.5ZM16.6667 6.0316L10.0598 11.9483L3.33333 6.01328V15.8333H16.6667V6.0316ZM3.75955 4.16667L10.0516 9.71833L16.2508 4.16667H3.75955Z"
                                    fill="#8353E2" />
                            </svg>
                            E-Posta
                        </button>
                        <button type="button" class="btn me-3 btn-outline-warning" id="sms">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path
                                    d="M4.80235 14.1667H16.6667V4.16667H3.33333V15.3209L4.80235 14.1667ZM5.37879 15.8333L1.66667 18.75V3.33333C1.66667 2.8731 2.03977 2.5 2.5 2.5H17.5C17.9603 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9603 15.8333 17.5 15.8333H5.37879Z"
                                    fill="#FF8B00" />
                            </svg>
                            SMS
                        </button>
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
                                    <input class="form-check-input" type="checkbox" id="idCheckbox" checked>
                                    <label class="form-check-label" for="idCheckbox">ID</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="tcCheckbox" checked>
                                    <label class="form-check-label" for="tcCheckbox">T.C. Kimlik No.</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="adCheckbox" checked>
                                    <label class="form-check-label" for="adCheckbox">Ad</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="soyadCheckbox" checked>
                                    <label class="form-check-label" for="soyadCheckbox">Soyad</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="telefonCheckbox" checked>
                                    <label class="form-check-label" for="telefonCheckbox">Telefon Numarası</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="evAdresiCheckbox">
                                    <label class="form-check-label" for="evAdresiCheckbox">Ev Adresi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="evTelefonuCheckbox">
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
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="checkbox" id="masterCheckbox" id="selectAll">
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>T.C Kimlik No..</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>

                            <th>
                                <div class="dropdown-sort">
                                    <span>Burs Tipi</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Okul Tipi </span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Ad</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Soyad</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Dönem</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>IBAN</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Bursveren</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Burs Ayı</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Ödeme Periyodu</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Ödeme Tutarı</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>

                            <th>
                                <div class="dropdown-sort">
                                    <span>Ödeme Tarihi</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Öğrenciye Burs Ödeme Tarihi</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Ödeme Durumu</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>İşlem</span>

                                </div>
                            </th>
                        </tr>
                        <tr class="search-row">
                            <!-- Checkbox/Seç -->
                            <td>
                            </td>
                            <!-- TC No -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="tc_no" placeholder="Ara...">
                                    <button class="btn btn-sm search-toggle" data-target="tc_no">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Aday Türü -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control selected-text" readonly placeholder="" data-related="burs_tipi">

                                    <div class="form-control d-none checkbox-dropdown" data-sutun="burs_tipi">

                                        <div class="checkbox-group">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="burs_tipi_all" class="select-all" value="all">
                                                <label for="burs_tipi_all">Tümü</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="burs_tipi_Barinma" value="Barınma">
                                                <label for="burs_tipi_Barinma">Barınma</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="burs_tipi_SosyalDestek" value="Sosyal Destek">
                                                <label for="burs_tipi_SosyalDestek">Sosyal Destek</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="burs_tipi_Deprem" value="Deprem">
                                                <label for="burs_tipi_Deprem">Deprem</label>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm search-toggle" data-target="burs_tipi">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Ogrenim Tur -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control selected-text" readonly placeholder="" data-related="okul_tipi">
                                    <div class="form-control d-none checkbox-dropdown" data-sutun="okul_tipi">
                                        <div class="checkbox-group">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="okul_tipi_all" class="select-all" value="all">
                                                <label for="okul_tipi_all">Tümü</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="okul_tipi_ilkokul" value="ilkokul">
                                                <label for="okul_tipi_ilkokul">İlkokul</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="okul_tipi_ortaokul" value="ortaokul">
                                                <label for="okul_tipi_ortaokul">Ortaokul</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="okul_tipi_lise" value="lise">
                                                <label for="okul_tipi_lise">Lise</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="okul_tipi_onlisans" value="onlisans">
                                                <label for="okul_tipi_onlisans">Ön lisans</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="okul_tipi_lisans" value="lisans">
                                                <label for="okul_tipi_lisans">Lisans</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="okul_tipi_yukseklisans" value="yukseklisans">
                                                <label for="okul_tipi_yukseklisans">Yüksek Lisans</label>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm search-toggle" data-target="okul_tipi">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Ad -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="name" placeholder="Ara...">
                                    <button class="btn btn-sm search-toggle" data-target="name">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Soyad -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="surname" placeholder="Ara...">
                                    <button class="btn btn-sm search-toggle" data-target="surname">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Donem -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="donem" placeholder="Ara...">
                                    <button class="btn btn-sm search-toggle" data-target="donem">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Iban -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="iban" placeholder="Ara...">
                                    <button class="btn btn-sm search-toggle" data-target="iban">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Burs Veren -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="bursveren" placeholder="Ara...">
                                    <button class="btn btn-sm search-toggle" data-target="bursveren">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Burs Ayi -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="burs_ayi" placeholder="Ara...">
                                    <button class="btn btn-sm search-toggle" data-target="burs_ayi">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Odeme Periodu -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="odeme_periyodu" placeholder="Ara...">
                                    <button class="btn btn-sm search-toggle" data-target="odeme_periyodu">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Odeme Tutari -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="odeme_tutari" placeholder="Ara...">
                                    <button class="btn btn-sm search-toggle" data-target="odeme_tutari">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Odeme Tarihi -->
                            <td>
                                <div class="search-field-container">
                                    <input type="date" class="form-control d-none" data-sutun="odeme_tarihi">
                                    <button class="btn btn-sm search-toggle" data-target="odeme_tarihi">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Ogrenciye Odeme Tarihi -->
                            <td>
                                <div class="search-field-container">
                                    <input type="date" class="form-control d-none" data-sutun="ogrenciye_burs_odeme_tarihi">
                                    <button class="btn btn-sm search-toggle" data-target="ogrenciye_burs_odeme_tarihi">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>


                            <!-- Odeme Durumu -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control selected-text" readonly placeholder="" data-related="odeme_durumu">

                                    <div class="form-control d-none checkbox-dropdown" data-sutun="odeme_durumu">

                                        <div class="checkbox-group">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="odeme_durumu_all" class="select-all" value="all">
                                                <label for="odeme_durumu_all">Tümü</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="odeme_durumu_Odendi" value="Odendi">
                                                <label for="odeme_durumu_Odendi">Ödendi</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="odeme_durumu_Beklemede" value="Beklemede">
                                                <label for="odeme_durumu_Beklemede">Beklemede</label>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm search-toggle" data-target="odeme_durumu">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>






                            <!-- İşlemler -->
                            <td></td>
                        </tr>
                        </thead>
                        <tbody id="paymentInfoTableBody">
                            @foreach($items as $bursOdeme)
                                <tr class="redirect-row" data-id="{{ $bursOdeme->id }}">
                                    <td class="sorting_1"><input data-id="{{$bursOdeme->id}}" data-tel="{{$bursOdeme->tel_no}}" data-name="{{$bursOdeme->ad}}" data-surname="{{$bursOdeme->soyad}}" value='{{$bursOdeme->id}}' type="checkbox" name="userCheckbox" class="checkbox"></td>
                                    <td>{{ $bursOdeme->tc_kimlik_no }}</td>
                                    <td>{{ $bursOdeme->burs_tipi }}</td>
                                    <td><span class='text-capitalize' >{{ $bursOdeme->okul_tipi }}</span></td>
                                    <td>{{ $bursOdeme->ad }}</td>
                                    <td>{{ $bursOdeme->soyad }}</td>
                                    <td>{{ $bursOdeme->donem }}</td>
                                    <td>{{ $bursOdeme->iban }}</td>
                                    <td>{{ $bursOdeme->bursveren }}</td>
                                    <td>{{ $bursOdeme->burs_ayi }}</td>
                                    <td>{{ $bursOdeme->odeme_periyodu }}</td>
                                    <td>{{ $bursOdeme->odeme_tutari }} TL</td>
                                    <td>{{ $bursOdeme->odeme_tarihi }}</td>
                                    <td>{{ $bursOdeme->ogrenciye_burs_odeme_tarihi }}</td>
                                    <td>@switch($bursOdeme->odeme_durumu)
                                        @case('Odendi')
                                            <span class="badge bg-success">Ödendi</span>
                                            @break
                                        @case('İptal Edildi')
                                            <span class="badge bg-danger">İptal Edildi</span>
                                            @break
                                        @default
                                            <span class="badge bg-warning">Beklemede</span>
                                        @endswitch
                                    </td>
                                    <td>

                                        <a href="{{ route('burs-odeme-duzenle', $bursOdeme->id) }}">
                                            <button class="btn edit-candidate-info-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                                            </svg></button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="{{url('')}}/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="{{url('')}}/assets/datatables/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="{{url('')}}/assets/datatables/buttons.dataTables.min.css">
        <script src="{{url('')}}/assets/datatables/dataTables.buttons.min.js"></script>
        <script src="{{url('')}}/assets/datatables/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @include('includes.js.sendsms')
        @include('panel.includes.data-filter')
        <script>
            // Her sayfa için özel satır oluşturma fonksiyonu
            function generateTableRow(item) {
                return `
                    <tr class="redirect-row" data-id="${item.id}">
                        <td>
                            <input
                                data-id="${item.id}"
                                data-tel="${item.tel_no || ''}"
                                data-name="${item.ad || ''}"
                                data-surname="${item.soyad || ''}"
                                data-id="${item.id || ''}"
                                value="${item.id || ''}"
                                type="checkbox"
                                name="userCheckbox"
                                class="checkbox"
                            >
                        </td>

                        <td>${item.tc_kimlik_no || ''}</td>
                        <td>${item.burs_tipi || ''}</td>
                        <td>${getScholarStatus(item.okul_tipi)}</td>
                        <td>${item.ad || ''}</td>
                        <td>${item.soyad || ''}</td>
                        <td>${item.donem || ''}</td>
                        <td>${item.iban || ''}</td>
                        <td>${item.bursveren || ''}</td>
                        <td>${item.burs_ayi || ''}</td>
                        <td>${item.odeme_periyodu || ''}</td>
                        <td>${item.odeme_tutari || ''} TL</td>
                        <td>${item.odeme_tarihi || ''}</td>
                        <td>${item.ogrenciye_burs_odeme_tarihi || ''}</td>
                        <td>${getStatusBadge(item.odeme_durumu)}</td>
                        <td>${generateActions(item.id)}</td>
                    </tr>
                `;
            }

            // Yardımcı fonksiyonlar
            function getScholarStatus(item) {
                if(item == 'ilkokul') return 'İlkokul';
                if(item == 'ortaokul') return 'Ortaokul';
                if(item == 'lise') return 'Lise';
                if(item == 'onlisans') return 'Ön lisans';
                if(item == 'lisans') return 'Lisans';
                if(item == 'yukseklisans') return 'Yüksek Lisans';
            }
            function getInterviewStatus(item) {
                if (!item.interviews || item.interviews.length === 0) {
                    return '<span class="status-box-warning">Mülakat Yapılacak</span>';
                }

                const lastInterview = item.interviews[0]; // first() yerine ilk elemanı al

                switch(lastInterview.interview_result) {
                    case 'Planlandı':
                        return '<span class="status-box-success">Planlandı</span>';
                    case 'Olumlu':
                        return '<span class="status-box-success">Olumlu</span>';
                    case 'Olumsuz':
                        return '<span class="status-box-danger">Olumsuz</span>';
                    default:
                        return '<span class="status-box-warning">Mülakat Yapılacak</span>';
                }
            }
            function getSchoolName(infos) {
                if (!infos || !infos.educationType) return '';

                switch(infos.educationType) {
                    case 'ilkokul': return infos.p_school_name || '';
                    case 'ortaokul': return infos.m_school_name || '';
                    case 'lise': return infos.h_school_name || '';
                    case 'onlisans': return infos.university_name || '';
                    case 'lisans': return infos.university_name || '';
                    case 'yukseklisans': return infos.university_name || '';
                    default: return infos.current_university || '';
                }
            }

            function getClassName(infos) {
                if (!infos || !infos.educationType) return '';

                if(infos.educationType != 'ilkokul' &&
                infos.educationType != 'ortaokul' &&
                infos.educationType != 'lise') {
                    return infos.university_class || '';
                }
                return infos.class || '';
            }

            function getDepartment(infos) {
                if (!infos) return '';

                if (infos.master_departmant) return infos.master_departmant;
                if (infos.grade_departmant) return infos.grade_departmant;
                return '';
            }

            function getStatusBadge(status) {
                if(status == 'Odendi') return '<span class="status-box-success">Ödendi</span>';
                if(status == 'Beklemede') return '<span class="status-box-warning">Beklemede</span>';
            }

            function generateActions(id) {
                return `

                    <a href="/burs-odeme/${id}/duzenle">
                        <button class="btn edit-student-info-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                            </svg>
                        </button>
                    </a>
                `;
            }

            // Filtrelemeyi başlat
            $(document).ready(function() {
                initializeFilter('{{ $modelName }}', '{{ $tableId }}');
            });
            </script>

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
$(document).ready(function() {
    var table = $('#paymentInfoTable').DataTable({
        paging: true,
        searching: true,
        ordering: false,
        info: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]], // Sayfa başına kayıt seçenekleri
        dom: 'Blfrtip', // 'l' length menu için eklendi
        buttons: [
                {
                    extend: 'csv',
                    text: 'CSV olarak al',
                    action: function(e, dt, button, config) {
                        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                        let allData = dt.rows().data().toArray();
                        let exportData = allData;
                        if (selectedCheckboxes.length > 0) {
                            exportData = allData.filter(row => {
                                const cellContent = row[0];
                                const checkboxMatch = cellContent.match(/data-id="([^"]+)"/);
                                const rowId = checkboxMatch ? checkboxMatch[1] : null;

                                return Array.from(selectedCheckboxes).some(checkbox =>
                                    checkbox.dataset.id === rowId
                                );
                            });
                        }

                        let tempTable = $('<table>').append(
                            dt.table().header().cloneNode(true)
                        );
                        let tempDt = $(tempTable).DataTable({
                            data: exportData,
                            columns: dt.settings()[0].aoColumns
                        });

                        config.exportOptions = {
                            modifier: {
                                page: 'all'
                            }
                        };

                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(
                            this,
                            e,
                            tempDt,
                            button,
                            config
                        );

                        tempDt.destroy();
                        $(tempTable).remove();
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel olarak al',
                    action: function(e, dt, button, config) {
                        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                        let allData = dt.rows().data().toArray();
                        let exportData = allData;
                        if (selectedCheckboxes.length > 0) {
                            exportData = allData.filter(row => {
                                const cellContent = row[0];
                                const checkboxMatch = cellContent.match(/data-id="([^"]+)"/);
                                const rowId = checkboxMatch ? checkboxMatch[1] : null;

                                return Array.from(selectedCheckboxes).some(checkbox =>
                                    checkbox.dataset.id === rowId
                                );
                            });
                        }

                        let tempTable = $('<table>').append(
                            dt.table().header().cloneNode(true)
                        );
                        let tempDt = $(tempTable).DataTable({
                            data: exportData,
                            columns: dt.settings()[0].aoColumns
                        });

                        config.exportOptions = {
                            modifier: {
                                page: 'all'
                            }
                        };

                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(
                            this,
                            e,
                            tempDt,
                            button,
                            config
                        );

                        tempDt.destroy();
                        $(tempTable).remove();
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF olarak al',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    action: function(e, dt, button, config) {
                        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                        let allData = dt.rows().data().toArray();
                        let exportData = allData;
                        if (selectedCheckboxes.length > 0) {
                            exportData = allData.filter(row => {
                                const cellContent = row[0];
                                const checkboxMatch = cellContent.match(/data-id="([^"]+)"/);
                                const rowId = checkboxMatch ? checkboxMatch[1] : null;

                                return Array.from(selectedCheckboxes).some(checkbox =>
                                    checkbox.dataset.id === rowId
                                );
                            });
                        }

                        // HTML etiketlerini temizle
                        const cleanData = exportData.map(row => {
                            return row.map(cell => {
                                if (typeof cell === 'string') {
                                    return cell.replace(/<[^>]*>/g, '').trim();
                                }
                                return cell;
                            });
                        });

                        let tempTable = $('<table>').append(
                            dt.table().header().cloneNode(true)
                        );
                        let tempDt = $(tempTable).DataTable({
                            data: cleanData,
                            columns: dt.settings()[0].aoColumns
                        });

                        config.exportOptions = {
                            modifier: {
                                page: 'all'
                            }
                        };

                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(
                            this,
                            e,
                            tempDt,
                            button,
                            config
                        );

                        tempDt.destroy();
                        $(tempTable).remove();
                    }
                }
        ],
        language: {
        lengthMenu: "Göster _MENU_ kayıt",
        zeroRecords: "Kayıt bulunamadı",
        info: "  _END_ öğeden _TOTAL_ 'i",
        infoEmpty: "Gösterilecek kayıt yok",
        infoFiltered: "(_MAX_ kayıt içinde filtrelendi)",
        search: "Ara:",
        paginate: {
            first: "İlk",
            last: "Son",
            next: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                    <path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"/>
                    </svg>`,
            previous: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                    <path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"/>
                    </svg>`,
        },
        },
        language: {
            lengthMenu: "Göster _MENU_ kayıt",
            zeroRecords: "Kayıt bulunamadı",
            info: "_END_ öğeden _TOTAL_ 'i",
            infoEmpty: "Gösterilecek kayıt yok",
            infoFiltered: "(_MAX_ kayıt içinde filtrelendi)",
            search: "Ara:",
            paginate: {
                first: "İlk",
                last: "Son",
                next: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                          <path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"/>
                        </svg>`,
                previous: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                          <path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"/>
                        </svg>`,
            },
        },
        columnDefs: [
            { orderable: false, targets: 0 },
            { orderable: false, targets: -1 }
        ],
    });

    $('#excelButton').on('click', function() {
        table.button('.buttons-excel').trigger();
    });

    $('#pdfButton').on('click', function() {
        table.button('.buttons-pdf').trigger();
    });

    $('#csvButton').on('click', function() {
        table.button('.buttons-csv').trigger();
    });

    $('#search').on('click', function() {
        $('#paymentInfoTable_filter label').toggleClass('d-none');
    });

    function toggleColumnVisibility(checkbox) {
        var columnNumber = $(checkbox).attr('id').replace('vischk', '');
        var column = table.column(columnNumber);
        column.visible($(checkbox).is(':checked'));
    }

    $('.form-check-input').on('change', function() {
        toggleColumnVisibility(this);
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
                    @include('includes.js.sidebar')

    <script
@endsection
