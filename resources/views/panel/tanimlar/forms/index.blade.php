@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('local-css')
@endsection
@section('page-title')
    Formlar
@endsection
@section('body')

    <body data-sidebar="colored">
@endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="navbar-button-container">
                    <div class="d-flex flex-wrap">

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


                        <button type="button" class="btn btn-outline-primary" id="reload" data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                                <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z" fill="#4069E5"></path>
                            </svg>
                        </button>
                    </div>

                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover" id="candidateTable">
                        <thead>
                        <tr>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Form Adı</span>
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

                            <th>Seçenekler</th>
                        </tr>
                        </thead>

                        <tbody id="candidateTableBody">
                        @foreach($datas as $item)
                            <tr>
                                <td>{{$item->title}}</td>
                                <td>
                                    <a href="{{ route('panel-form-detay', ['id' => $item->id]) }}">
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
            </div>
        </main>
        <!--Modal Alanı-->
        <!--Kategori Oluştur-->
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
        <script src="{{url('')}}/assets/js/tables/questions.js"></script>
        <script>
            function  checkleng(){
                const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
                var length  = selectedCheckboxes.length;
                return length > 0;
            }
            $(document).ready(function() {
                function sendEmails() {
                    // Seçili checkbox'ları bul
                    const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
                    var length  = selectedCheckboxes.length;
                    console.log(length);
                    // Seçili checkbox'ların e-posta adreslerini topla
                    const emailList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-email'));

                    // E-posta adreslerini sunucuya gönder
                    fetch('/send-emails', {
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
                $('#pdfButton').on('click', function() {
                    table.button('.buttons-pdf').trigger();
                });

                $('#createInterview').on('click', function() {
                    if (!checkleng()){
                        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                        interviewWarningModal.show();
                    }
                    else{
                        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
                        var length  = selectedCheckboxes.length;
                        if(length > 1){
                            const interviewWarningModal2 = new bootstrap.Modal(document.getElementById('interviewWarningModal2'));
                            interviewWarningModal2.show();

                        }
                        else{
                            const selectedUserIds = [];


                            // Checkbox'lar arasında işaretli olanları bul
                            const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                            // Eğer en az bir checkbox işaretli ise ilk elemanın 'data-id' değerini al
                            if (checkboxes.length > 0) {
                                const selectedUserId = checkboxes[0].getAttribute('data-id');

                                // 'mülakatsoruid' inputunun value değerini bu ID olarak ayarla
                                const mulakatsoruIdInput = document.querySelector('input[name="mulakatsoruid"]');
                                if (mulakatsoruIdInput) {
                                    mulakatsoruIdInput.value = selectedUserId;
                                }
                            }
                            const interviewWarningModal = new bootstrap.Modal(document.getElementById('createInterviewModal'));
                            interviewWarningModal.show();
                        }


                    }
                });

                $('#mail').on('click', function() {
                    if (checkleng()){
                        sendEmails();
                    }
                    else{
                        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                        interviewWarningModal.show();
                    }
                });
                $('#excelButton').on('click', function() {
                    table.button('.buttons-excel').trigger();
                });

                $('#csvButton').on('click', function() {
                    table.button('.buttons-csv').trigger();
                });
            });
        </script>
        <script>
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
                console.log(selectedUserIds.length);
                // İşlem ID'sini belirle
                const islemId = islemid;

                // red durumundaki bilgileri ver
                const redSebebi = document.getElementById('redSebebi') ? document.getElementById('redSebebi').value : null;
                const digerAciklama = document.getElementById('digeraciklama') ? document.getElementById('digeraciklama').value : null;
                // iade durumundaki bilgileri ver
                const iadeSebebi = document.getElementById('iadeSebebi') ? document.getElementById('iadeSebebi').value : null;
                const iadeDigerAciklama = document.getElementById('iadeDigerAciklama') ? document.getElementById('iadeDigerAciklama').value : null;

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
                $('#confirm').click(function(e) {
                    e.preventDefault();

                    if (checkleng()){
                        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                        confirmModal.show();
                    }
                    else{
                        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                        interviewWarningModal.show();
                    }
                });
            });
            $(document).ready(function() {
                $('#denied').click(function(e) {
                    e.preventDefault();

                    if (checkleng()){
                        const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
                        rejectModal.show();
                    }
                    else{
                        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                        interviewWarningModal.show();
                    }
                });
            });
            $(document).ready(function() {
                $('#to-return').click(function(e) {
                    e.preventDefault();

                    if (checkleng()){
                        const missingDocumentModal = new bootstrap.Modal(document.getElementById('missingDocumentModal'));
                        missingDocumentModal.show();
                    }
                    else{
                        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                        interviewWarningModal.show();
                    }
                });
            });
            $(document).ready(function() {
                $('#btndenied').click(function(e) {
                    e.preventDefault();
                    if (checkleng()){
                        islemIcinDiziGonder(0);
                    }
                    else{
                        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                        interviewWarningModal.show();
                    }

                });
            });
            $(document).ready(function() {
                $('#confirmbtnmodel').click(function(e) {
                    e.preventDefault();
                    islemIcinDiziGonder(1);
                });
            });$(document).ready(function() {
                $('#confirmbtnmodel').click(function(e) {
                    e.preventDefault();
                    islemIcinDiziGonder(1);
                });
            });

            $(document).ready(function() {
                $('#btnreturn').click(function(e) {
                    e.preventDefault();
                    islemIcinDiziGonder(2);
                });
            });

            $(document).ready(function() {
                $('#waste5').click(function(e) {
                    e.preventDefault();
                    if (checkleng()){
                        islemIcinDiziGonder(3);
                    }
                    else{
                        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                        interviewWarningModal.show();
                    }
                });
                $('#reload').click(function(e) {
                    location.reload();
                });
            });
            // Topbar'daki butonları bağlama



        </script>
    @include('includes.js.sidebar')

    @endsection
