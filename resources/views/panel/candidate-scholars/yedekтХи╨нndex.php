@extends('layouts.master')
@section('title')
    Aday Bursiyerler
@endsection
@section('page-title')
    Aday Bursiyerler
@endsection
@section('local-css')
<style>

#candidateTable_filter div label:first-child {
    display: none;
}
</style>
@endsection
@php
    $modelName = 'NewAnswer';
    $tableId = 'candidateTableBody';
    $relations = ['interviews'];
    $where = [];

    // Iliskili tablolarin sutunlarini mapping'lerini tanımla
    $columnMappings = [
        'interview_result' => [
            'relation' => 'interviews',
            'field' => 'interview_result'
        ],
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
                        <a href="{{route('add-manuel-new')}}">
                            <button type="button" class="btn me-3 text-white" id="newAdd" data-bs-toggle="tooltip" data-bs-placement="left" title="Yeni Başvuru Ekle">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                                </svg>
                                Yeni
                            </button>
                        </a>

                    </div>
                    <div class="navbar-button-container">
                        <button type="button" class="btn btn-outline-success" id="confirm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16658C11.8423 9.16658 13.334 7.67492 13.334 5.83325C13.334 3.99158 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99158 6.66732 5.83325C6.66732 7.67492 8.15898 9.16658 10.0007 9.16658ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z" fill="#006644" />
                            </svg>
                            Burs Onay
                        </button>
                        <button type="button" class="btn btn-outline-danger" id="denied">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z"
                                    fill="#A82200" />
                            </svg>
                            Burs Ret
                        </button>
                        <button type="button" class="btn btn-outline-dark" id="toReturn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.4888 14.1666L13.9652 12.6429L15.1437 11.4644L18.6792 14.9999L15.1437 18.5354L13.9652 17.3569L15.4888 15.8333H12.5007V14.1666H15.4888Z"
                                    fill="#1A1A1A" />
                            </svg>
                            Başvuru İade
                        </button>
                        <button type="button" id="mulakatAtaBtn" class="btn btn-primary text-white ms-2">
                            Mülakat Ata
                        </button>
                        <button type="button" class="btn btn-primary text-white" id="createInterview">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7.5013 0.833008V2.49967H12.5013V0.833008H14.168V2.49967H17.5013C17.9616 2.49967 18.3346 2.87277 18.3346 3.33301V16.6663C18.3346 17.1266 17.9616 17.4997 17.5013 17.4997H2.5013C2.04107 17.4997 1.66797 17.1266 1.66797 16.6663V3.33301C1.66797 2.87277 2.04107 2.49967 2.5013 2.49967H5.83464V0.833008H7.5013ZM16.668 9.16634H3.33464V15.833H16.668V9.16634ZM5.83464 4.16634H3.33464V7.49967H16.668V4.16634H14.168V5.83301H12.5013V4.16634H7.5013V5.83301H5.83464V4.16634Z"
                                      fill="white" />
                            </svg>
                            Mülakat Oluştur
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
                                <li id="csvButton"><a class="dropdown-item" href="#">
                                    <img src="../assets/images/csv.svg" alt="CSV" width="24" height="24">
                                    .csv olarak aktar
                                </a></li>
                                <li id="topluIndirBtn" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/excel.svg" alt="Toplu Aktar" width="24" height="24">
                                        Toplu Aktar
                                    </a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn me-3 btn-outline-info" id="mail">
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
                        <button type="button" class="btn btn-outline-primary" id="search"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Ara">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="filter"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Filtrele">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M11.6654 11.6667V16.6667L8.33203 18.3333V11.6667L3.33203 4.16667V2.5H16.6654V4.16667L11.6654 11.6667ZM5.33511 4.16667L9.9987 11.162L14.6623 4.16667H5.33511Z" fill="#4069E5"/>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="waste"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Sil">
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
                            <div class="dropdown-menu" aria-labelledby="column">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="idCheckbox" checked>
                                    <label class="form-check-label" for="idCheckbox">ID</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="fotoCheckbox" checked>
                                    <label class="form-check-label" for="fotoCheckbox">Fotoğraf</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="noCheckbox" checked>
                                    <label class="form-check-label" for="noCheckbox">Başvuru No.</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="adayTuruCheckbox" checked>
                                    <label class="form-check-label" for="adayTuruCheckbox">Aday Türü</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="tcCheckbox" checked>
                                    <label class="form-check-label" for="tcCheckbox">T.C Kimlik No.</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="puanCheckbox" checked>
                                    <label class="form-check-label" for="tcCheckbox">Başvuru Puanı</label>
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
                                    <input class="form-check-input" type="checkbox" id="durumCheckbox" checked>
                                    <label class="form-check-label" for="durumCheckbox">Başvuru Durumu</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ogrenimCheckbox" checked>
                                    <label class="form-check-label" for="ogrenimCheckbox">Öğrenim Türü</label>
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
                <div class="table-responsive mt-3">
                    <table class="table table-hover" id="candidateTable">
                        <thead>
                        <tr>
                            <th>
                                <input onchange="selectAll(this)" type="checkbox" class="checkbox" id="selectAll">
                            </th>
                            <th>Fotoğraf</th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Başvuru No.</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(2, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(2, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>Bursiyer Tipi</th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>T.C Kimlik No..</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(3, 'asc', 'numeric')">Büyükten Küçüğe</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(3, 'desc', 'numeric')">Küçükten Büyüğe</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Başvuru Puanı</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(3, 'asc', 'numeric')">Büyükten Küçüğe</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(3, 'desc', 'numeric')">Küçükten Büyüğe</a></li>
                                    </ul>
                                </div>
                            </th>

                            <th>
                                <div class="dropdown-sort">
                                    <span>Ad</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(4, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(4, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Soyad</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(5, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(5, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Telefon Numarası</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(6, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(6, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Başvuru Durumu</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" >
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(7, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(7, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th> Mülakat Durumu </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Öğrenim Türü</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>

                                </div>
                            </th>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>İşlem Yapan</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc', 'status')">Onaylandı</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc', 'status')">Mülakat Bekliyor</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc', 'status')">Red Edildi</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>Seçenekler</th>
                        </tr>
                        <tr class="search-row">
                            <!-- Checkbox/Seç -->
                            <td>
                            </td>
                            <!-- Fotoğraf -->
                            <td>
                            </td>
                            <!-- Basvuru Numarası-->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="id" placeholder="">

                                    <button class="btn btn-sm search-toggle" data-target="id">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Aday Türü -->
                            <td>
                                <div class="search-field-container">
                                    <select class="form-control d-none" data-sutun="aday_turu">
                                        <option value=""></option>
                                        <option value="">Tümü</option>
                                        <option value="null">Boş</option>
                                        <option value="Dernek">Dernek</option>
                                        <option value="Vakıf">Vakıf</option>
                                    </select>
                                    <button class="btn btn-sm search-toggle" data-target="aday_turu">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- TC No -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="tc_no" placeholder="">
                                    <button class="btn btn-sm search-toggle" data-target="tc_no">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Burs Başlangıç -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="totalPoints">
                                    <button class="btn btn-sm search-toggle" data-target="totalPoints">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Ad -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="name" placeholder="">
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
                                    <input type="text" class="form-control d-none" data-sutun="surname" placeholder="">
                                    <button class="btn btn-sm search-toggle" data-target="surname">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Telefon -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="tel_no" placeholder="">
                                    <button class="btn btn-sm search-toggle" data-target="tel_no">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Basvuru Durumu -->
                            <td>
                                <div class="search-field-container">
                                    <select class="form-control d-none" data-sutun="status">
                                        <option value="">Tümü</option>
                                        <option value="0">Devam Ediyor</option>
                                        <option value="1">Onay Bekliyor</option>
                                        <option value="2">Iade Edildi</option>
                                        <option value="3">Onaylandı</option>
                                        <option value="4">Red Edildi</option>
                                    </select>
                                    <button class="btn btn-sm search-toggle" data-target="status">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Mulakat Durumu -->
                            <td>
                                <div class="search-field-container">
                                    <select class="form-control d-none" data-sutun="interview_result">
                                        <option value="">Tümü</option>
                                        <option value="Planlandı">Planlandı</option>
                                        <option value="Olumlu">Olumlu</option>
                                        <option value="Olumsuz">Olumsuz</option>
                                    </select>
                                    <button class="btn btn-sm search-toggle" data-target="interview_result">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Ogrenim Tur -->
                            <td>
                                <div class="search-field-container">
                                    <select class="form-control d-none" data-sutun="educationType">
                                        <option value="">Tümü</option>
                                        <option value="ilkokul">İlkokul</option>
                                        <option value="ortaokul">Ortaokul</option>
                                        <option value="lise">Lise</option>
                                        <option value="onlisans">Ön lisans</option>
                                        <option value="lisans">Lisans</option>
                                        <option value="yukseklisans">Yüksek Lisans</option>
                                    </select>
                                    <button class="btn btn-sm search-toggle" data-target="educationType">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.0271 13.8467L18.5961 17.4156L17.4176 18.5941L13.8486 15.0252C12.5654 16.0518 10.938 16.666 9.16797 16.666C5.02797 16.666 1.66797 13.306 1.66797 9.16602C1.66797 5.02602 5.02797 1.66602 9.16797 1.66602C13.308 1.66602 16.668 5.02602 16.668 9.16602C16.668 10.936 16.0538 12.5634 15.0271 13.8467ZM13.3552 13.2283C14.3742 12.1782 15.0013 10.7457 15.0013 9.16602C15.0013 5.9431 12.3909 3.33268 9.16797 3.33268C5.94505 3.33268 3.33464 5.9431 3.33464 9.16602C3.33464 12.3889 5.94505 14.9993 9.16797 14.9993C10.7476 14.9993 12.1801 14.3723 13.2303 13.3533L13.3552 13.2283Z" fill="#4069E5"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- İşlemi Yapan -->
                            <td>
                                <div class="search-field-container">
                                    <input type="text" class="form-control d-none" data-sutun="islemi_yapan" placeholder="">
                                    <button class="btn btn-sm search-toggle" data-target="islemi_yapan">
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
                        <tbody id="candidateTableBody">
                            @foreach($adaylar as $aday)
                                <tr class="redirect-row" data-id="{{ $aday->id }}">
                                    <a href="{{ route('panel-basvuru-incele', ['id' => $aday->id]) }}">
                                    <td><input data-email="{{$aday->email}}" data-id="{{$aday->id}}"  data-tel="{{$aday->tel_no}}" value="{{$aday->id}}" type="checkbox" name="userCheckbox" class="checkbox"></td>
                                    <td>
                                        @php
                                            $fotografPath = null;
                                                    $fotografPath = $aday->doc_fotograf;

                                        @endphp
                                        <div class="position-relative">
                                        <img width='50' src="{{ $fotografPath ? url($fotografPath) : '../assets/images/default-profile.svg' }}" alt="Profile Photo" class=" rounded-circle px50img img-fluid">
                                            @if($aday->status == 4)
                                                <img class="position-absolute top-0 end-0" src="{{url('assets/images/incorrect.svg')}}" width="20" height="20">
                                            @endif
                                            @if($aday->status == 3 )
                                                    <img class="position-absolute top-0 end-0" src="{{url('assets/images/verified-account.svg')}}" width="20" height="20">
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{$aday->id}}</td>
                                    <td>{{$aday->aday_turu}}</td>
                                    <td>{{$aday->tc_no}}</td>
                                    <td>{{$aday->totalPoints}}</td>
                                    <td>{{$aday->name}}</td>
                                    <td>{{$aday->surname}}</td>
                                    <td>{{$aday->tel_no}}</td>
                                    <td> @switch($aday->status) @case(4) <span class="status-box-danger">Red Edildi</span> @break @case(3) <span class="status-box-success">Onaylandı</span> @break @case(2) <span class="status-box-secondary">Iade Edildi</span> @break @case(1) @if($aday->iadeden_dondu == 1) <span class="status-box-danger">İade Döndü</span> @else <span class="status-box-warning">Onay Bekliyor</span> @endif @break  @case(0) <span class="status-box-warning">Devam Ediyor</span> @endswitch  </td>
                                    <td>
                                        @if($aday->interviews->first() && $aday->interviews->first()->interview_result == 'Planlandı') <span class="status-box-success">Planlandı</span> @endif
                                        @if($aday->interviews->first() && $aday->interviews->first()->interview_result == 'Olumlu') <span class="status-box-success">Olumlu</span> @endif
                                        @if($aday->interviews->first() && $aday->interviews->first()->interview_result == 'Olumsuz') <span class="status-box-danger">Olumsuz</span> @endif
                                        @if($aday->interviews->first() == null) <span class="status-box-warning">Mülakat Yapılacak </span> @endif
                                    </td>
                                    <td>@switch($aday->educationType) @case('ilkokul') İlkokul @break @case('ortaokul') Ortaokul @break @case('lise') Lise @break @case('onlisans') Ön lisans @break @case('lisans') Lisans @break @case('yukseklisans') Yüksek Lisans @break @endswitch</td>
                                    <td>@if($aday->islemi_yapan) {{$aday->islemi_yapan}} @else - @endif </td>
                                    <td>
                                        <button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#636363"/>
                                            </svg></button>
                                        <a href="{{ route('panel-basvuru-incele', ['id' => $aday->id]) }}">
                                        <button class="btn edit-candidate-info-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                    <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                                                </svg></button>
                                        </a>
                                    </td>
                                </a>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!--Modal Alanı-->
        @include('panel.candidate-scholars.modals')
                        @include('includes.js.toastr')

    @endsection
    @section('scripts')
        <!-- App js -->


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="https://datatables-cdn.com/buttons/1.7.1/css/buttons.dataTables.min.css">
        <script src="https://datatables-cdn.com/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="{{url('')}}/assets/js/tables/candidate.js"></script>
        @include('panel.candidate-scholars.scriptf')
        @include('panel.includes.data-filter')
        <script>
            // Her sayfa için özel satır oluşturma fonksiyonu
            function generateTableRow(item) {
                return `
                    <tr class="redirect-row" data-id="${item.id}">
                        <td>
                            <input
                                data-email="${item.email || ''}"
                                data-tel="${item.tel_no || ''}"
                                data-name="${item.name || ''}"
                                data-surname="${item.surname || ''}"
                                data-id="${item.id || ''}"
                                value="${item.id || ''}"
                                type="checkbox"
                                name="userCheckbox"
                                class="checkbox"
                            >
                        </td>
                        <td>
                            <img width=50
                                src="${item.doc_fotograf || '/assets/images/default-profile.svg'}"
                                alt="Profile Photo"
                                class="rounded-circle px50img img-fluid"
                            >
                        </td>
                        <td>${item.id || ''}</td>
                        <td>${item.aday_turu || ''}</td>
                        <td>${item.tc_no || ''}</td>
                        <td>${item.totalPoints }</td>
                        <td>${item.name || ''}</td>
                        <td>${item.surname || ''}</td>
                        <td>${item.tel_no || ''}</td>
                        <td>${getStatusBadge(item.status)}</td>
                        <td>${getInterviewStatus(item)}</td>
                        <td>${getScholarStatus(item)}</td>
                        <td>${item.islemi_yapan || '--'}</td>
                        <td>${generateActions(item.id)}</td>
                    </tr>
                `;
            }

            // Yardımcı fonksiyonlar
            function getScholarStatus(item) {
                if(item.educationType == 'ilkokul') return 'İlkokul';
                if(item.educationType == 'ortaokul') return 'Ortaokul';
                if(item.educationType == 'lise') return 'Lise';
                if(item.educationType == 'onlisans') return 'Ön lisans';
                if(item.educationType == 'lisans') return 'Lisans';
                if(item.educationType == 'yukseklisans') return 'Yüksek Lisans';
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
                if(status == 0) return '<span class="status-box-warning">Devam Ediyor</span>';
                if(status == 1) return '<span class="status-box-success">Onaylandı</span>';
                if(status == 2) return '<span class="status-box-secondary">Iade Edildi</span>';
                if(status == 3) return '<span class="status-box-success">Onaylandı</span>';
                if(status == 4) return '<span class="status-box-danger">Red Edildi</span>';
            }

            function generateActions(id) {
                return `
                    <button class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#636363"/>
                        </svg>
                    </button>
                    <a href="/panel/Aktif-Bursiyer-Incele/${id}">
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
        function sendSmsToSelected() {
            const selectedIds = [];
            const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

            checkboxes.forEach(checkbox => {
                if (checkbox.value) {
                    selectedIds.push(checkbox.value);
                }
            });

            if (selectedIds.length === 0) {
                alert('Lütfen en az bir kişi seçiniz.');
                return;
            }

            window.location.href = `{{ route('send.sms') }}?member_ids=${JSON.stringify(selectedIds)}`;
        }

        // SMS butonuna click event listener ekle
        document.getElementById('smsButton').addEventListener('click', sendSmsToSelected);
        </script>

        @endsection
