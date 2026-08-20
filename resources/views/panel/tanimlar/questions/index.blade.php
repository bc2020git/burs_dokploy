@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('local-css')
    <style>
        .dataTables_filter{
            display: inherit;
        }
    </style>
@endsection
@section('page-title')
    Form Soruları
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
                        <x-export-buttons table-id="candidateTable" model="question" />
                        <button type="button" class="btn btn-outline-primary me-3" id="waste" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Sil">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="reload" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                                <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z" fill="#4069E5"></path>
                            </svg>
                        </button>
                    </div>

                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover" id="candidateTable">
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
                        <h5 class="modal-title" id="createInterviewModalLabel">Soru Oluştur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="title">Soru bilgilerini giriniz</p>
                        <p class="small">Oluştur butonuna bastığınızda kategori eklenecektir.</p>
                        <form method='post' action='{{route('panel-soru-ekle')}}'  id="createInterviewForm"> @csrf
                            <div class="mb-3">
                                <label for="category_id" class="custom-label">Kategori</label>
                                <select required id="category_id" name="category_id" class="form-select">
                                    @foreach($categories as $c)
                                        <option value="{{$c->id}}">{{$c->title}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Soru Adı <span style="color: red" > (Yönetici sayfasında görüntülenecek olan ad) </span></label>
                                <input required name='name' type="text" class="form-control" id="name"
                                       placeholder="Ad bilgisi giriniz..">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Soru Başlığı <span style="color: red" > (Başvuru formunda görüntülenecek olan metin) </span></label>
                                <input required name='title' type="text" class="form-control" id="title"
                                       placeholder="Başlık bilgisi giriniz..">
                            </div>
                            <div class="mb-3">
                                <label for="required" class="custom-label">Zorunluluk</label>
                                <select required id="required" name="required" class="form-select">
                                    <option value="Zorunlu">Zorunlu</option>
                                    <option value="Opsiyonel">Zorunlu Değil</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="disabled" class="custom-label">Doldurulabilir Mi?</label>
                                <select required id="disabled" name="disabled" class="form-select">
                                    <option value="notdisabled">Evet</option>
                                    <option value="disabled">Hayır</option>
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="has_conditions_div_modal">
                                <label for="has_conditions_modal" class="custom-label">Koşul Var mı?</label>
                                <select id="has_conditions_modal" name="has_conditions" class="form-select">
                                    <option value="">Hayır</option>
                                    <option value="on">Evet</option>
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="conditions_div_modal">
                                <label class="custom-label">Koşullar</label>
                                <div id="conditions_container_modal">
                                    <!-- Koşullar dinamik olarak eklenecek -->
                                </div>
                                <button type="button" id="addConditionButtonModal" class="btn btn-sm btn-primary">Koşul Ekle</button>
                            </div>

                            <div class="mb-3">
                                <label for="forms" class="custom-label">Gösterilen Formlar <span style="color: red" >(Birden fazla seçmek için CTRL basılı tutunuz) </span></label>
                                <select required style="min-height: 160px" multiple id="forms" name="forms[]" class="form-select">
                                    <option  value="ilkokul">İlkokul</option>
                                    <option  value="ortaokul">Ortaokul</option>
                                    <option  value="lise">Lise</option>
                                    <option  value="onlisans">Ön lisans</option>
                                    <option  value="lisans">Lisans</option>
                                    <option  value="yukseklisans">Yükseklisans</option>
                                    <option  value="doktora">Doktora</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="custom-label">Soru Tipi</label>
                                <select required id="type"  name="type" class="form-select">
                                    <option value="text">Metin</option>
                                    <option value="date">Tarih</option>
                                    <option value="number">Numara</option>
                                    <option value="email">Eposta</option>
                                    <option value="select">Seçenek</option>
                                    <option value="checkbox">Kutucuk</option>
                                    <option value="file">Dosya</option>
                                </select>
                            </div>
                            <div id="optiondiv" class="select-options d-none">
                                <div class="row" id="optionparentdiv" >
                                    <div class="col-md-3">
                                        <button type="button" id="addOptionButton" class="btn btn-primary mb-2">Seçenek Ekle</button>
                                    </div>

                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="options[]" placeholder="Seçenek Giriniz" >
                                    </div>
                                </div>
                            </div>
                            <button id="createInterviewCreateButton" type="submit"
                                    class="btn btn-primary mt-3">Oluştur</button>
                        </form>
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

        @include('panel.tanimlar.questions.scriptf')
        @include('panel.includes.filtreleme')

        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
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
                        ids: selectedUserIds,
                        islemId: islemId
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
                            if (islemId == '1') {
                                toastr.success('Seçilen sorular başarıyla silindi.', 'Başarılı');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Bir hata oluştu.', 'Hata');
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
                $('#waste').click(function(e) {
                    e.preventDefault();
                    if (checkleng()){
                        islemIcinDiziGonder(1);
                    }
                    else{
                        const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                        interviewWarningModal.show();
                    }
                });
                $('#topluIndirBtn').click(function(e) {
                    e.preventDefault();
                        islemIcinDiziGonder(3);
                });
                $('#reload').click(function(e) {
                    location.reload();
                });
            });
            // Topbar'daki butonları bağlama

            // Modal'da soru tipi değiştiğinde koşul alanını göster/gizle
            $(document).on('change', '#type', function() {
                const selectedValue = $(this).val();
                const hasConditionsDiv = $('#has_conditions_div_modal');
                const conditionsDiv = $('#conditions_div_modal');

                if (selectedValue === 'number') {
                    hasConditionsDiv.removeClass('d-none');
                } else {
                    hasConditionsDiv.addClass('d-none');
                    conditionsDiv.addClass('d-none');
                    $('#has_conditions_modal').val('');
                    $('#conditions_container_modal').empty();
                }
            });

            // Modal'da koşul var mı seçeneği değiştiğinde
            $(document).on('change', '#has_conditions_modal', function() {
                const selectedValue = $(this).val();
                const conditionsDiv = $('#conditions_div_modal');

                if (selectedValue === 'on') {
                    conditionsDiv.removeClass('d-none');
                } else {
                    conditionsDiv.addClass('d-none');
                    $('#conditions_container_modal').empty();
                }
            });

            // Modal'da koşul ekleme
            let conditionIndexModal = 0;
            $(document).on('click', '#addConditionButtonModal', function() {
                const conditionHtml = `
                    <div class="row mb-2 condition-row">
                        <div class="col-md-5">
                            <select name="condition_operator[${conditionIndexModal}]" class="form-select">
                                <option value="">Seçiniz</option>
                                <option value="<">Küçüktür (<)</option>
                                <option value=">">Büyüktür (>)</option>
                                <option value="<=">Küçük Eşittir (<=)</option>
                                <option value=">=">Büyük Eşittir (>=)</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="number" name="condition_value[${conditionIndexModal}]" class="form-control" placeholder="Değer">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-danger remove-condition-modal">Sil</button>
                        </div>
                    </div>
                `;
                $('#conditions_container_modal').append(conditionHtml);
                conditionIndexModal++;
            });

            // Modal'da koşul silme
            $(document).on('click', '.remove-condition-modal', function() {
                $(this).closest('.condition-row').remove();
            });

        </script>
    @include('includes.js.sidebar')

    @endsection
