@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yönetici Paneli
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="d-flex justify-content-between  flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
                    <div class="d-flex flex-wrap">
                        <button type="button" class="btn me-3 text-white" id="graduate"
                                onclick="window.location.href='/admin/add-scholarship-application-manuel.html'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                            </svg>
                            Yeni
                        </button>
                    </div>
                    <div class="btn-toolbar  mb-md-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="dropdown-export">
                                <button type="button" class="btn me-3" id="confirm" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                         fill="none">
                                        <g clip-path="url(#clip0_1_29351)">
                                            <path
                                                d="M12.5554 9.5L4.64844 8V19.0835C4.64844 19.5897 5.03014 20 5.50099 20H19.1447C19.6156 20 19.9973 19.5897 19.9973 19.0835V15L12.5554 9.5Z"
                                                fill="#1A1A1A" />
                                            <path
                                                d="M12.5554 0H5.50099C5.03014 0 4.64844 0.410329 4.64844 0.916498V5L12.5554 10L16.7415 11.5L19.9973 10V5L12.5554 0Z"
                                                fill="#21A366" />
                                            <path d="M4.64844 5H12.5554V10H4.64844V5Z" fill="#107C41" />
                                            <path opacity="0.1"
                                                  d="M10.3075 4H4.64844V16.5H10.3075C10.7777 16.4984 11.1585 16.089 11.1601 15.5835V4.9165C11.1585 4.41101 10.7777 4.00164 10.3075 4Z"
                                                  fill="black" />
                                            <path opacity="0.2"
                                                  d="M9.84239 4.5H4.64844V17H9.84239C10.3126 16.9984 10.6934 16.589 10.6949 16.0835V5.4165C10.6934 4.91101 10.3126 4.50164 9.84239 4.5Z"
                                                  fill="black" />
                                            <path opacity="0.2"
                                                  d="M9.84239 4.5H4.64844V16H9.84239C10.3126 15.9984 10.6934 15.589 10.6949 15.0835V5.4165C10.6934 4.91101 10.3126 4.50164 9.84239 4.5Z"
                                                  fill="black" />
                                            <path opacity="0.2"
                                                  d="M9.37728 4.5H4.64844V16H9.37728C9.84749 15.9984 10.2283 15.589 10.2298 15.0835V5.4165C10.2283 4.91101 9.84749 4.50164 9.37728 4.5Z"
                                                  fill="black" />
                                            <path
                                                d="M0.852556 4.5H9.37999C9.85085 4.5 10.2325 4.91033 10.2325 5.4165V14.5835C10.2325 15.0897 9.85085 15.5 9.37999 15.5H0.852556C0.381701 15.5 0 15.0897 0 14.5835V5.4165C0 4.91033 0.381701 4.5 0.852556 4.5Z"
                                                fill="url(#paint0_linear_1_29351)" />
                                            <path
                                                d="M2.64062 12.979L4.43411 9.99151L2.79086 7.02051H4.11272L5.00946 8.92051C5.09226 9.10101 5.149 9.23501 5.1797 9.3235H5.19132C5.25024 9.1795 5.31225 9.03967 5.37737 8.904L6.33597 7.02151H7.54946L5.86434 9.97502L7.59226 12.979H6.30109L5.26528 10.8935C5.21649 10.8048 5.17509 10.7116 5.14156 10.615H5.12622C5.09587 10.7096 5.05561 10.8002 5.00621 10.885L3.9397 12.979H2.64062Z"
                                                fill="white" />
                                            <path
                                                d="M19.144 0H12.5547V5H19.9965V0.916498C19.9965 0.410329 19.6148 0 19.144 0Z"
                                                fill="#33C481" />
                                            <path d="M12.5547 10H19.9965V15H12.5547V10Z" fill="#107C41" />
                                        </g>
                                        <defs>
                                            <linearGradient id="paint0_linear_1_29351" x1="1.7776" y1="3.78387"
                                                            x2="9.20512" y2="15.7505" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#18884F" />
                                                <stop offset="0.5" stop-color="#117E43" />
                                                <stop offset="1" stop-color="#0B6631" />
                                            </linearGradient>
                                            <clipPath id="clip0_1_29351">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    Dışa Aktar
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
                            <button type="button" class="btn me-3 btn-outline-info" id="mail" onclick="window.location.href='/admin/send-mail.html'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path
                                        d="M2.5 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.5C2.03976 17.5 1.66666 17.1269 1.66666 16.6667V3.33333C1.66666 2.8731 2.03976 2.5 2.5 2.5ZM16.6667 6.0316L10.0598 11.9483L3.33333 6.01328V15.8333H16.6667V6.0316ZM3.75955 4.16667L10.0516 9.71833L16.2508 4.16667H3.75955Z"
                                        fill="#8353E2" />
                                </svg>
                                Mail
                            </button>
                            <button type="button" class="btn me-3 btn-outline-warning" id="sms" onclick="window.location.href='/admin/send-sms.html' ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M4.80235 14.1667H16.6667V4.16667H3.33333V15.3209L4.80235 14.1667ZM5.37879 15.8333L1.66667 18.75V3.33333C1.66667 2.8731 2.03977 2.5 2.5 2.5H17.5C17.9603 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9603 15.8333 17.5 15.8333H5.37879Z"
                                        fill="#FF8B00" />
                                </svg>
                                SMS
                            </button>
                            <button type="button" class="btn btn-sm me-3" id="search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
                                    <path
                                        d="M15.0258 13.8474L18.5948 17.4163L17.4163 18.5948L13.8473 15.0259C12.5641 16.0526 10.9367 16.6667 9.16667 16.6667C5.02667 16.6667 1.66667 13.3067 1.66667 9.16675C1.66667 5.02675 5.02667 1.66675 9.16667 1.66675C13.3067 1.66675 16.6667 5.02675 16.6667 9.16675C16.6667 10.9367 16.0525 12.5642 15.0258 13.8474ZM13.3539 13.2291C14.3729 12.1789 15 10.7464 15 9.16675C15 5.94383 12.3896 3.33341 9.16667 3.33341C5.94376 3.33341 3.33334 5.94383 3.33334 9.16675C3.33334 12.3897 5.94376 15.0001 9.16667 15.0001C10.7463 15.0001 12.1788 14.373 13.229 13.354L13.3539 13.2291Z"
                                        fill="#0065FF" />
                                </svg>
                            </button>
                            <div class="navbar-search-container">
                                <input type="text" id="navbar-search-input" class="form-control" placeholder="Ara...">
                            </div>
                            <button type="button" class="btn me-3" id="filter"> <svg xmlns="http://www.w3.org/2000/svg"
                                                                                     width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path
                                        d="M11.6667 11.6667V16.6667L8.33334 18.3333V11.6667L3.33334 4.16667V2.5H16.6667V4.16667L11.6667 11.6667ZM5.33643 4.16667L10 11.162L14.6636 4.16667H5.33643Z"
                                        fill="#0065FF" />
                                </svg>
                                Filtrele</button>
                            <button type="button" class="btn me-3" id="waste">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M14.1641 5.00033H18.3307V6.66699H16.6641V17.5003C16.6641 17.9606 16.291 18.3337 15.8307 18.3337H4.16406C3.70383 18.3337 3.33073 17.9606 3.33073 17.5003V6.66699H1.66406V5.00033H5.83073V2.50033C5.83073 2.04009 6.20383 1.66699 6.66406 1.66699H13.3307C13.791 1.66699 14.1641 2.04009 14.1641 2.50033V5.00033ZM14.9974 6.66699H4.9974V16.667H14.9974V6.66699ZM7.4974 9.16699H9.16406V14.167H7.4974V9.16699ZM10.8307 9.16699H12.4974V14.167H10.8307V9.16699ZM7.4974 3.33366V5.00033H12.4974V3.33366H7.4974Z" fill="#4069E5"/>
                                </svg></button>
                            <div class="dropdown-columns">
                                <button type="button" class="btn btn-primary me-3" id="column" data-bs-toggle="dropdown"
                                        aria-expanded="false">
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
                        </div>

                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover" id="candidateTable">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="checkbox" id="selectAll">
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
                                    <span>Ad</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
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
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
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
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
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
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(7, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(7, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Öğrenim Türü</span>
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
                        </thead>

                        <tbody id="candidateTableBody">

                        </tbody>
                    </table>
                </div>
            </div>
        </main>    @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="{{url('public')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('public')}}/assets/js/tables/candidate-empty.js"></script>
        <script>
            //TABLO SIRALAMA
            function sortTable(columnIndex, order, type) {
                var table = document.querySelector("table");
                var rows = Array.from(table.rows).slice(1); // Başlık satırını çıkar

                rows.sort(function(a, b) {
                    var cellA = a.cells[columnIndex].innerText.trim();
                    var cellB = b.cells[columnIndex].innerText.trim();

                    if (type === 'numeric') {
                        cellA = parseInt(cellA);
                        cellB = parseInt(cellB);
                    } else if (type === 'status') {
                        var statusOrder = {
                            "Onaylandı": 1,
                            "Mülakat Bekliyor": 2,
                            "Red Edildi": 3
                        };
                        cellA = statusOrder[cellA];
                        cellB = statusOrder[cellB];
                    } else {
                        cellA = cellA.toLowerCase();
                        cellB = cellB.toLowerCase();
                    }

                    if (cellA < cellB) {
                        return order === 'asc' ? -1 : 1;
                    }
                    if (cellA > cellB) {
                        return order === 'asc' ? 1 : -1;
                    }
                    return 0;
                });

                rows.forEach(function(row) {
                    table.appendChild(row);
                });
            }
        </script>@endsection
