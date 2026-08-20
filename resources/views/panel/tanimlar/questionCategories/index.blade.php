@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Form Soru Kategorileri
@endsection
@section('body')

    <body data-sidebar="colored">
@endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="navbar-button-container">
                    <div class="d-flex flex-wrap">
                            <button type="button" class="btn me-3 text-white" id="graduate" data-bs-toggle="modal"
                                    data-bs-target="#createInterviewModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                                </svg>
                                Yeni Ekle
                            </button>

                    </div>
                    <div class="navbar-button-container">
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
                                <li ><a id="pdfButton" class="dropdown-item" href="#">
                                        <img src="../assets/images/pdf.svg" alt="PDF" width="24" height="24">
                                        PDF olarak aktar
                                    </a></li>
                                <li><a id="excelexportbtn" class="dropdown-item" href="#">
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

                        <button type="button" class="btn btn-outline-primary" id="waste5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="reload" data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                                <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z" fill="#4069E5"></path>
                            </svg>
                        </button>
                    </div>

                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover" id="rankTable">
                        @include('panel.includes.datatable-head')


                        <tbody id="candidateTableBody">

                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!--Modal Alanı-->
        <!--Kategori Oluştur-->
        <div class="modal fade" id="createInterviewModal" tabindex="-1" aria-labelledby="createInterviewModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createInterviewModalLabel">Kategori Oluştur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="title">Kategori bilgilerini giriniz</p>
                        <p class="small">Oluştur butonuna bastığınızda kategori eklenecektir.</p>
                        <form method='post' action='{{route('panel-soru-kategori-ekle')}}'  id="createInterviewForm"> @csrf
                            <div class="mb-3">
                                <label for="interviewLocation" class="form-label">Kategori Başlığı</label>
                                <input name='title' type="text" class="form-control" id="title"
                                       placeholder="Başlığı giriniz..">
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="forms" class="custom-label">Gösterilen Formlar <span style="color: red" >(Birden fazla seçmek için CTRL basılı tutunuz) </span></label>
                                <select required style="min-height: 160px" multiple id="forms" name="forms[]" class="form-select">
                                    <option value="ilkokul">İlkokul</option>
                                    <option value="ortaokul">Ortaokul</option>
                                    <option value="lise">Lise</option>
                                    <option value="onlisans">Ön lisans</option>
                                    <option value="lisans">Lisans</option>
                                    <option value="yukseklisans">Yükseklisans</option>
                                    <option value="doktora">Doktora</option>
                                </select>
                            </div>
                            <button id="createInterviewCreateButton" type="submit"
                                    class="btn btn-primary mt-3">Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Uyarı Modali -->
        <div class="modal fade" id="interviewWarningModal" tabindex="-1" aria-labelledby="interviewWarningModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="interviewWarningModalLabel">Uyarı</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body fw-medium">
                        Henuz Islev Eklenmedi.
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
                    </div>
                </div>
            </div>
        </div>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>

        @include('panel.tanimlar.questionCategories.scriptf')
        @include('panel.includes.filtreleme')

        @php $tabloadi='soru_kategoris'; @endphp
        @include('includes.js.siralamaDegistir')
        <script>
            function  checkleng(){
                const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
                var length  = selectedCheckboxes.length;
                return length > 0;
            }
        </script>
        <script>
            //todo kategori silme islemini kararlastirdiktan sonra sil
            function soruSil() {
                // Seçili checkbox'ları bul
                const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
                const isChecked = selectedCheckboxes.length;

                // Seçili checkbox'ların e-posta adreslerini topla
                const emailList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-email'));

                // E-posta adreslerini sunucuya gönder
                fetch('/panel/soru-Toplu-Sil', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token eklenmesi
                    },
                    body: JSON.stringify({ emails: emailList })
                })
                    .then(response => response.json())
                    .then(data => {
                        window.location.href = data.redirectUrl;
                    })
                    .catch(error => {
                        console.error('Hata:', error);
                    });
            }
        </script>

        <script>


            //TABLO SIRALAMA
            function sortTable(columnIndex, order, type) {
                var table = document.querySelector("table");
                var rows = Array.from(table.rows).slice(1);

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
            function selectAll(a){
                const checkboxes = document.querySelectorAll('input[name="userCheckbox"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = a.checked;
                });

            }
            function islemIcinDiziGonder(islemid) {
                // Tüm checkbox'ları seç
                const selectedUserIds = [];
                const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                // Her bir işaretli checkbox'ın 'data-id' değerini al
                checkboxes.forEach(checkbox => {
                    const userId = checkbox.getAttribute('data-id');
                    if (userId) {
                        selectedUserIds.push(userId);
                    }
                });
                // İşlem ID'sini belirle
                const islemId = islemid;
                $.ajax({
                    url: '/soru-Toplu-Islem',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        userIds: selectedUserIds,
                        islemId: islemId,
                        redSebebi: redSebebi,          // Red sebebi (null olabilir)
                        digerAciklama: digerAciklama,   // Diğer açıklama (null olabilir)
                        iadeSebebi: iadeSebebi,          // Red sebebi (null olabilir)
                        iadeDigerAciklama: iadeDigerAciklama   // Diğer açıklama (null olabilir)
                    },
                    success: function(response) {
                        console.log('Veriler gönderildi:', response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Hatası:", status, error);
                        console.error("Hata Detayları:", xhr.responseText);
                    }
                });
            }




            $(document).ready(function() {
                $('#waste5').click(function(e) {
                    e.preventDefault();
                    const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                    interviewWarningModal.show();
                    /*if (checkleng()){
                        islemIcinDiziGonder(3);
                    }
                    else{
                        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                        interviewWarningModal.show();
                    }*/
                });
                $('#reload').click(function(e) {
                    location.reload();
                });
            });
            // Topbar'daki butonları bağlama



        </script>
    @include('includes.js.sidebar')

    @endsection
