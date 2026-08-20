@extends('layouts.master')
@section('title')
    Mezunlar
@endsection
@section('page-title')
    Mezunlar
@endsection
@section('local-css')
<style>
    .dropdown{
        border:none !important;
        height: initial !important;
    }
    #vis-column-menu{
        padding: 0 10px;
        max-height: 400px;
        overflow-y: scroll;
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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
                    <div class="d-flex">

                    </div>
                    <div class="btn-toolbar  mb-md-0">
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-danger me-3" id="denied">
                                Öğrenciyi Geri Al
                            </button>
                            <button type="button" class="btn me-3 text-white setAktif" id="graduate">
                                Öğrenciyi Aktif Et
                            </button>
                        </div>
                        <button type="button" class="btn me-3 btn-outline-info" id="mail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M2.5 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.5C2.03976 17.5 1.66666 17.1269 1.66666 16.6667V3.33333C1.66666 2.8731 2.03976 2.5 2.5 2.5ZM16.6667 6.0316L10.0598 11.9483L3.33333 6.01328V15.8333H16.6667V6.0316ZM3.75955 4.16667L10.0516 9.71833L16.2508 4.16667H3.75955Z"
                                    fill="#8353E2" />
                            </svg>
                            E-Posta
                        </button>
                        <button type="button" class="btn me-3 btn-outline-warning" id="sms">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                 fill="none">
                                <path
                                    d="M4.80235 14.1667H16.6667V4.16667H3.33333V15.3209L4.80235 14.1667ZM5.37879 15.8333L1.66667 18.75V3.33333C1.66667 2.8731 2.03977 2.5 2.5 2.5H17.5C17.9603 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9603 15.8333 17.5 15.8333H5.37879Z"
                                    fill="#FF8B00" />
                            </svg>
                            SMS
                        </button>
                        <div class="dropdown-export">
                            <button type="button"
                            class="btn me-3 dropdown-toggle"
                            id="export"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside"
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
                            <ul class="dropdown-menu dropdown-menu-end" id="export-menu" aria-labelledby="export">
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

                            <div class="dropdown-columns">
                                <button onclick="showDropdown('vis-column-menu')" type="button" class="btn btn-primary me-3" id="column" data-bs-toggle="dropdown"
                                        aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="left" title="Sütunlar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                         fill="none">
                                        <path
                                            d="M9.16667 4.16667H4.16667V15.8333H9.16667V4.16667ZM10.8333 4.16667V15.8333H15.8333V4.16667H10.8333ZM3.33333 2.5H16.6667C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5Z"
                                            fill="#0065FF" />
                                    </svg>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" id="vis-column-menu" aria-labelledby="column">
                                    @foreach($columns as $column)
                                    <div class="form-check">
                                        <input class="form-check-input column-visibility"
                                               type="checkbox"
                                               id="{{ $column['name'] }}Checkbox"
                                               data-column="{{ $column['name'] }}"
                                               checked>
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
                        <button type="button" class="btn btn-sm me-3" id="search" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Ara">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M15.0258 13.8474L18.5948 17.4163L17.4163 18.5948L13.8473 15.0259C12.5641 16.0526 10.9367 16.6667 9.16667 16.6667C5.02667 16.6667 1.66667 13.3067 1.66667 9.16675C1.66667 5.02675 5.02667 1.66675 9.16667 1.66675C13.3067 1.66675 16.6667 5.02675 16.6667 9.16675C16.6667 10.9367 16.0525 12.5642 15.0258 13.8474ZM13.3539 13.2291C14.3729 12.1789 15 10.7464 15 9.16675C15 5.94383 12.3896 3.33341 9.16667 3.33341C5.94376 3.33341 3.33334 5.94383 3.33334 9.16675C3.33334 12.3897 5.94376 15.0001 9.16667 15.0001C10.7463 15.0001 12.1788 14.373 13.229 13.354L13.3539 13.2291Z"
                                    fill="#0065FF" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="waste" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Sil">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="reload" onclick="location.reload()" data-bs-toggle="tooltip"
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
        @include('panel.graduate-scholar.modals')

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
        @include('includes.js.sendsms')

        @include('panel.graduate-scholar.scriptf')
        @include('panel.graduate-scholar.scriptf2')
        <script src="../assets/js/components/dashboard.js"></script>
        <script src="../assets/js/components/modal.js"></script>
        @include('includes.js.tableSmsbutton')





    <script>
        function  checkleng(){
            const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
            var length  = selectedCheckboxes.length;
            return length > 0;
        }

        function startChunkedMezunExport(userIds) {
            $('#exportProgressModal').modal('show');
            $('#exportProgressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
            $('#exportProgressStatus').text('Dışa aktarma başlatılıyor...');

            $.ajax({
                url: '{{ route('mezun.export.start') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    userIds: JSON.stringify(userIds)
                },
                success: function(response) {
                    const exportId = response.exportId;
                    const total = response.total;
                    const batchSize = response.batchSize;
                    const totalChunks = Math.ceil(total / batchSize);

                    if (total === 0) {
                        alert('Seçili kayıt bulunamadı.');
                        $('#exportProgressModal').modal('hide');
                        return;
                    }

                    processMezunChunk(exportId, 0, totalChunks, batchSize, total);
                },
                error: function() {
                    alert('Export başlatılamadı.');
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function processMezunChunk(exportId, index, totalChunks, batchSize, total) {
            if (index >= totalChunks) {
                finalizeMezunExportRequest(exportId, totalChunks);
                return;
            }

            const progress = Math.round((index / totalChunks) * 100);
            $('#exportProgressBar').css('width', progress + '%').attr('aria-valuenow', progress).text(progress + '%');
            $('#exportProgressStatus').text('Parça ' + (index + 1) + ' / ' + totalChunks + ' işleniyor...');

            $.ajax({
                url: '{{ route('mezun.export.chunk') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    exportId: exportId,
                    index: index,
                    batchSize: batchSize
                },
                success: function() {
                    processMezunChunk(exportId, index + 1, totalChunks, batchSize, total);
                },
                error: function(xhr) {
                    var msg = 'Parça işlenirken hata oluştu.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        msg = xhr.responseJSON.error;
                    }
                    alert(msg);
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function finalizeMezunExportRequest(exportId, totalChunks) {
            $('#exportProgressStatus').text('Dosya birleştiriliyor ve Excel oluşturuluyor...');
            $('#exportProgressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');

            $.ajax({
                url: '{{ route('mezun.export.finalize') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    exportId: exportId,
                    totalChunks: totalChunks
                },
                success: function(response) {
                    $('#exportProgressStatus').text('Tamamlandı! İndiriliyor...');
                    setTimeout(function() {
                        $('#exportProgressModal').modal('hide');
                        window.location.href = response.downloadUrl;
                    }, 1000);
                },
                error: function() {
                    alert('Dosya oluşturulamadı.');
                    $('#exportProgressModal').modal('hide');
                }
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
            if (islemid === 4) {
                startChunkedMezunExport(selectedUserIds);
                return;
            }

            $.ajax({
                url: '{{route('panel_mezun_toplu_islem')}}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    userIds: selectedUserIds,
                    islemId: islemId,

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

        $('#mail').on('click', function() {
            if (checkleng()){
                sendEmails('redirectmultiplemail');
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
        $(document).ready(function() {
            $('#waste').click(function(e) {
                e.preventDefault();
                islemIcinDiziGonder(2);
            });
        });
        //geri al modalı için
        document.getElementById('denied').addEventListener('click', function () {
                if (checkleng()){
                    const undoModal = new bootstrap.Modal(document.getElementById('undoModal'));
                    undoModal.show();                }
                else{
                    const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                    interviewWarningModal.show();
                }
        });
        function selectAll(a){
            const checkboxes = document.querySelectorAll('input[name="userCheckbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = a.checked;
            });

        }
        //Öğrenciyi Aktif Et modalı için
        document.getElementById('graduate').addEventListener('click', function () {
                if (checkleng()){
                    const setAktifModal = new bootstrap.Modal(document.getElementById('setAktifModal'));
                    setAktifModal.show();                }
                else{
                    const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                    interviewWarningModal.show();
                }
        });
        function selectAll(a){
            const checkboxes = document.querySelectorAll('input[name="userCheckbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = a.checked;
            });

        }
        $('#deniedbtn').on('click', function() {
            islemIcinDiziGonder(1);
        });
        $('#setAktifBtn').on('click', function() {
            islemIcinDiziGonder(5);
        });
        $('#topluIndirBtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(4);
        });

    </script>
            @include('includes.js.sidebar')

@endsection
