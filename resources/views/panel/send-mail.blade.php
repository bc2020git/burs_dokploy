@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yönetici Paneli
@endsection
@section('local-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css" />
    <!-- Quill.js CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <div class="backdrop" id="backdrop" style="display: none;"></div>
        <main class="main-content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="mt-1">
                        <div class=" main-container">

                            <form action="{{route('send-mail-scholar-list')}}" enctype="multipart/form-data" method="post">@csrf
                                <div class="row mb-3">
                                    <div class="col-12 ">
                                        <div class="add-dues-form d-flex justify-content-between">
                                            <label for="recipients" class="form-label ">Alıcı Bursiyerler * :</label>
                                            <span>Alıcı Sayısı : <span id="memberCountDues">{{ $aliciSayisi }}</span></span>
                                        </div>

                                        <div class="recipient-input">
                                            <select class="js-example-basic-multiple" id="alicilar" name="alicilar[]" multiple="multiple">
                                                @foreach($alici as $a)
                                                    <option selected value="{{$a->email}}">{{$a->name}} {{$a->surname}} </option>
                                                @endforeach
                                                <optgroup label="Aktif Bursiyerler">
                                                    @foreach($bursiyerler as $bursiyer)
                                                        <option value="{{$bursiyer->email}}">{{$bursiyer->name}} {{$bursiyer->surname}}</option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Aday Bursiyerler">
                                                    @foreach($adaylar as $aday)
                                                        <option value="{{$aday->email}}">{{$aday->name}} {{$aday->surname}}</option>
                                                    @endforeach
                                                </optgroup>

                                            </select>
                                            <label for="alicilar">
                                                <svg id="addMemberName" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 11H7V13H11V17H13V13H17V11H13V7H11V11Z" fill="#0065FF"/>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                </div>



                                <label for="emailSubject" class="form-label">Mail Bilgileri * :</label>
                                <div class=" main-container">
                                    <div class="row mb-3">
                                        <div class="col-12">

                                            <div class="email-subject">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594V19H20V7.23792ZM4.51146 5L12.0619 11.662L19.501 5H4.51146Z" fill="#1A1A1A"/>
                                                </svg>
                                                <input required name="topic" type="text" placeholder="Konu (En fazla 128 karakter)" maxlength="128">
                                                <span class="close-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z" fill="#1A1A1A"/>
                                                    </svg>
                                                </span>
                                            </div>
                                            <!-- Quill Editor Container -->
                                            <div id="quillEditor" style="height: 200px; margin-bottom: 15px;"></div>



                                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="emailBody" id="emailBodyInput" value="">
                                        </div>
                                    </div>
                                </div>
                                <input style="display: none" type="file" id="fileUpload" name="files" accept=".jpg,.jpeg,.png,.pdf">
                                <input type="hidden" name="draggedFiles" id="draggedFiles">

                                <!--<div class="row mb-3 fileUpload-container">
                                    <div class="col-12">
                                        <label for="fileUpload" class="form-label">Dosya Yükle :</label>
                                        <div class="upload-box" id="drop-zone">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"/>
                                            </svg>
                                            Sürükle ve Bırak veya Dosya Seç
                                        </div>
                                        <small class="form-text text-muted">
                                            <div class="d-flex justify-content-between">
                                                <p>Desteklenen Belgeler : jpg, jpeg, .png, PDF</p>
                                                <p> (Max Size : 5 MB, 1 Dosya)</p>
                                            </div>
                                        </small>
                                    </div>
                                </div>
                            -->
                                <div class="transfer-modal-footer g-3 ">
                                    <a  onclick="window.history.back()"><button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Vazgeç </button></a>
                                    <button type="submit" class="btn btn-primary" id="sendButton">
                                        Gönder</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </main>                        @include('includes.js.toastr')

    @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- Quill.js JavaScript -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="{{url('')}}/assets/js/tables/scholar-table.js"></script>
        <script src="{{url('')}}/assets/js/registration.renewal.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Quill.js Editor başlatma - HTML desteği ile
                var quill = new Quill('#quillEditor', {
                    theme: 'snow',
                    placeholder: 'Mail içeriğinizi buraya yazın...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ 'header': 1 }, { 'header': 2 }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'script': 'sub'}, { 'script': 'super' }],
                            [{ 'indent': '-1'}, { 'indent': '+1' }],
                            [{ 'direction': 'rtl' }],
                            [{ 'size': ['small', false, 'large', 'huge'] }],
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'font': [] }],
                            [{ 'align': [] }],
                            ['clean'],
                            ['link', 'image'],
                            // HTML kodu ekleme butonu
                            ['html']
                        ],
                        clipboard: {
                            matchVisual: false,
                            matchers: [
                                ['div', function(node, delta) {
                                    return delta;
                                }]
                            ]
                        }
                    },
                    formats: [
                        'bold', 'italic', 'underline', 'strike',
                        'blockquote', 'code-block',
                        'header', 'list', 'script',
                        'indent', 'direction', 'size',
                        'color', 'background', 'font', 'align',
                        'link', 'image', 'video'
                    ]
                });

                // HTML kodu ekleme butonu için özel işlev
                var toolbar = quill.getModule('toolbar');
                toolbar.addHandler('html', function() {
                    var html = prompt('HTML kodunu girin:');
                    if (html) {
                        // HTML'i Quill editörüne ekle
                        var range = quill.getSelection();
                        if (range) {
                            quill.clipboard.dangerouslyPasteHTML(range.index, html);
                        } else {
                            quill.clipboard.dangerouslyPasteHTML(quill.getLength(), html);
                        }
                    }
                });

                                // Form submit edilmeden önce Quill içeriğini hidden input'a kopyala
                $('form').on('submit', function(e) {
                    e.preventDefault();

                    // Quill.js'den HTML içeriğini al
                    var htmlContent = quill.root.innerHTML;

                    // Eğer içerik boşsa uyarı ver
                    if (!htmlContent || htmlContent.trim() === '<p><br></p>' || htmlContent.trim() === '') {
                        alert('Lütfen mail içeriği yazın!');
                        return false;
                    }

                    // HTML içeriğini hidden input'a kopyala
                    $('#emailBodyInput').val(htmlContent);

                    // Form gönder
                    var formData = new FormData(this);
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if(response.success) {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    timeOut: 1500
                                };
                                toastr.success('Mail başarıyla gönderildi', 'Başarılı');
                                setTimeout(function() {
                                    window.location.href = '{{ url()->previous() }}';
                                }, 2000);
                            } else {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    timeOut: 3000
                                };
                                toastr.error(response.error || 'Mail gönderilirken bir hata oluştu', 'Hata');
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 3000
                            };
                            toastr.error('Mail gönderilirken bir hata oluştu: ' + error, 'Hata');
                            console.error('Form gönderimi hatası:', error);
                        }
                    });
                });

                // HTML kodunu doğrudan editöre eklemek için global fonksiyon
                window.insertHTML = function(html) {
                    var range = quill.getSelection();
                    if (range) {
                        quill.clipboard.dangerouslyPasteHTML(range.index, html);
                    } else {
                        quill.clipboard.dangerouslyPasteHTML(quill.getLength(), html);
                    }
                };


                // HTML input alanından HTML ekleme fonksiyonu
                window.insertHTMLFromInput = function() {
                    var htmlInput = document.getElementById('htmlInput');
                    var html = htmlInput.value.trim();
                    if (html) {
                        insertHTML(html);
                        htmlInput.value = ''; // Input'u temizle
                    } else {
                        alert('Lütfen HTML kodu girin!');
                    }
                };

                const dropZone = document.getElementById('drop-zone');
                const fileInput = document.getElementById('fileUpload');
                const draggedFilesInput = document.getElementById('draggedFiles');

                // Drag over - allow drop
                dropZone.addEventListener('dragover', function(event) {
                    event.preventDefault();
                    event.dataTransfer.dropEffect = 'copy';
                }, false);

                // Drop handler
                dropZone.addEventListener('drop', function(event) {
                    event.preventDefault();
                    const files = event.dataTransfer.files;
                    handleFiles(files);
                }, false);

                // Click to open file dialog
                dropZone.addEventListener('click', function() {
                    fileInput.click();
                });

                // Change handler for file dialog
                fileInput.addEventListener('change', function(event) {
                    const files = event.target.files;
                    handleFiles(files);
                }, false);

                function handleFiles(files) {
                    let fileArray = Array.from(files);
                    if (fileArray.length === 0) { return; }
                    // Maksimum 1 dosya (UI gereği)
                    fileArray = [fileArray[0]];

                    // Dosyaları input[type=file]'a ata
                    const dt = new DataTransfer();
                    fileArray.forEach(file => dt.items.add(file));
                    fileInput.files = dt.files;

                    // Gizli inputa isimleri yaz
                    draggedFilesInput.value = fileArray.map(file => file.name).join(',');

                    // UI'da isimleri göster
                    const fileListContainer = document.createElement('div');
                    fileArray.forEach(file => {
                        const fileName = document.createElement('p');
                        fileName.textContent = file.name;
                        fileListContainer.appendChild(fileName);
                    });

                    dropZone.innerHTML = '';
                    dropZone.appendChild(fileListContainer);
                }

            });

            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
            $(document).ready(function() {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('showModal') === 'true') {
                    $('#applicationPeriodModal').modal('show');
                }
            });
        </script>

        <script>
            function sortTable(column, order) {
                const table = document.getElementById("registrationRenewalTable");
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

@endsection
