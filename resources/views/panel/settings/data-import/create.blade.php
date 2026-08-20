@extends('layouts.master')
@section('title')
    Veri İçe Aktarım
@endsection
@section('local-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>


        .step-item.completed .step-number {
            background: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        .step-text {
            font-size: 14px;
            color: #495057;
        }

        .step-content {
            display: none;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .step-content.show.active {
            display: block;
        }

        .file-upload-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-area.dragover {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }

        .file-preview {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background-color: white;
        }

        .selected-file {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 0 !important;
        }

        .selected-file .card {
            border: 2px dashed #dee2e6 !important;
        }
        .data-import-title {
            display: inline-flex;
            align-items: center;
            color: #0E2087 !important;
            font-size: 20px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%;
        }
        .status-indicator {
            display: inline-block;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #dee2e6;
            transition: all 0.3s ease;
        }

        .status-indicator.matched {
            background-color: var(--green-400);
        }

        .mapping-row {
            padding: 15px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .mapping-row > div:not(:last-child) {
            border: 1px dashed #0065FF;
            padding: 10px 5px;

        }
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding-left: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #ced4da;
        }

        .select2-dropdown {
            border: 1px solid #ced4da;
        }
    </style>
@endsection

@section('content')
    <main class="main-content px-3 py-4">
        <div class="mt-1">
            <div id="application-form-high">
                <div class="main-content-manuel">
                    <div class="step-container">
                        <div class="step-item active" data-target="1">
                            <div class="step-number">1</div>
                            <div class="step-text">Alan Seçimi</div>
                        </div>
                        <div class="step-item" data-target="2">
                            <div class="step-number">2</div>
                            <div class="step-text">Dosya Yükleme</div>
                        </div>
                        <div class="step-item" data-target="3">
                            <div class="step-number">3</div>
                            <div class="step-text">Tablo</div>
                        </div>
                        <div class="step-item" data-target="4">
                            <div class="step-number">4</div>
                            <div class="step-text">Tamamlandı</div>
                        </div>
                    </div>

                    <form>
                        <div class="step-content show active" id="step-1" data-content="1">
                            <div class="tab-section">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Yüklenecek alan</label>
                                        <select id="gender" class="form-select select2">
                                            <option selected disabled >Seçiniz..</option>
                                            <option value="Aday Bursiyerler">Aday Bursiyerler</option>
                                            <option value="Bursiyerler">Bursiyerler</option>
                                            <option value="Kayıt Yenileme">Kayıt Yenileme</option>
                                            <option value="Mezunlar">Mezunlar</option>
                                            <option value="Universite">Universite</option>
                                            <option value="Fakulte">Fakulte</option>
                                            <option value="Bolumler">Bolumler</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="step-content" id="step-2" data-content="2">
                            <div class="file-upload-container">
                                <div class="upload-area" id="uploadArea">
                                    <div class="upload-content text-center">
                                        <i class="fas fa-file-excel fa-3x mb-3" style="color: #28a745;"></i>
                                        <h5>Excel Dosyası Yükle</h5>
                                        <p class="text-muted">Dosyayı sürükleyip bırakın veya seçin</p>
                                        <input type="file" id="fileInput" class="file-input" accept=".xlsx,.xls" hidden>
                                        <button type="button" class="btn btn-outline-primary" id="browseButton">
                                            Dosya Seç
                                        </button>
                                    </div>
                                </div>
                                <div id="filePreview" class="file-preview d-none">
                                    <div class="selected-file">
                                        <div class="card">
                                            <div class="card-header">
                                                Yüklenecek olan excel dosyası
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex gap-4 flex-column justify-content-center">
                                                    <i class="fas fa-file-excel fa-5x me-2 text-center" style="color: #28a745;"></i>
                                                    <span>Kişileri sonraki butonu ile aktarabilirsiniz.</span>
                                                    <button type="button" class="btn w-100 btn-outline-danger" id="removeFile">
                                                        Sil
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-content" id="step-3" data-content="3">
                            <div id="columnMappingContainer">
                                <div class="row mb-3">
                                    <div class="col-5">Excel alanları</div>
                                    <div class="col-5">Veritabanı alanları</div>
                                </div>
                                <div class="row mapping-row align-items-center">
                                    <div class="col-5">
                                        <select class="form-select excel-column">
                                            <option selected disabled value="">Excel Sütunu Seçin</option>
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <select class="form-select db-column">
                                            <option value="">Alan Seçin</option>
                                        </select>
                                    </div>
                                    <div class="col-2 text-center">
                                        <span class="status-indicator"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-content" id="step-4" data-content="4">
                            <div class="row justify-content-center d-none" id="resultDiv">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="nav-item">
                                                <div class="navbar-custom">
                                                    İşlem Tamamlandı
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class="mb-3">
                                                    <img style='width:30px' src="{{ asset('public/assets/svg/success.svg') }}" alt="success">
                                                    <span class="ms-1" id="successRecord">0</span> Kayıt <span id="tableName">Bursiyerler</span> alanına başarılı bir şekilde aktarıldı.
                                                </div>
                                                <div>
                                                    <img style='width:35px; filter: invert(27%) sepia(51%) saturate(2878%) hue-rotate(346deg) brightness(104%) contrast(97%);' src="{{ asset('public/assets/svg/error.svg') }}" alt="error">
                                                    <span id="errorRecord">0</span> Kayıt aktarılamadı.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="transfer-modal-footer d-flex justify-content-end g-3">
            <button type="button" class="btn cancel-button" id="prevStep" onclick="location.href='{{ route('data-import.index') }}'">Vazgeç</button>
            <button style="display: none;" type="button" class="btn btn-outline-primary next-button" id="prevButton">Önceki</button>
            <button type="button" class="btn btn-primary next-button" id="nextStep">Sonraki</button>
            <button style="display: none;" type="button" class="btn btn-primary next-button" id="completeButton">Tamamla</button>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stepItems = document.querySelectorAll(".step-item");
            const stepContent = document.querySelectorAll(".step-content");
            let currentStep = 1;
            let hasUploadedFile = false;
            let excelColumns = [];
            let dbColumns = [];
            let currentImportId = null;

            const prevBtn = document.getElementById("prevButton");
            const nextBtn = document.getElementById("nextStep");
            const completeBtn = document.getElementById("completeButton");

            // Excel ve dosya yükleme işlemleri
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('fileInput');
            const browseButton = document.getElementById('browseButton');
            const filePreview = document.getElementById('filePreview');
            const removeFile = document.getElementById('removeFile');
            const importType = document.getElementById('gender');

            function showStep(step) {
                stepItems.forEach((item) => {
                    item.classList.remove("active", "completed");
                    const itemStep = parseInt(item.getAttribute("data-target"));
                    if (itemStep < step) {
                        item.classList.add("completed");
                    }
                    if (itemStep === step) {
                        item.classList.add("active");
                    }
                });

                stepContent.forEach((content) => {
                    content.classList.remove("show", "active");
                    if (parseInt(content.getAttribute("data-content")) === step) {
                        content.classList.add("show", "active");
                    }
                });

                if (step === 1) {
                    prevBtn.style.display = "none";
                } else {
                    prevBtn.style.display = "inline-block";
                }

                if (step === stepItems.length) {
                    nextBtn.style.display = "none";
                    completeBtn.style.display = "inline-block";
                } else {
                    nextBtn.style.display = "inline-block";
                    completeBtn.style.display = "none";
                }
            }

            function validateStep(step) {
                if (step === 2) {
                    if (!importType.value || importType.value === "") {
                        alert('Lütfen önce yüklenecek alanı seçin!');
                        return false;
                    }
                }
                if (step === 3) {
                    if (!hasUploadedFile) {
                        alert('Lütfen önce Excel dosyası yükleyin!');
                        return false;
                    }
                }
                return true;
            }

            function setDbColumns(type) {
                    fetch(`{{ route('data-import.columns') }}?type=${type}`)
                        .then(response => response.json())
                        .then(data => {
                            dbColumns = data;
                            updateMappingRows();
                        })
                        .catch(error => {
                            console.error('Hata:', error);
                            alert('Veritabanı sütunları alınırken bir hata oluştu.');
                        });
            }

            function readExcelColumns(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    const range = XLSX.utils.decode_range(firstSheet['!ref']);

                    excelColumns = [];
                    for (let col = range.s.c; col <= range.e.c; col++) {
                        const cellAddress = XLSX.utils.encode_cell({ r: 0, c: col });
                        const cell = firstSheet[cellAddress];
                        if (cell && cell.v) {
                            console.log(cell.v);
                            excelColumns.push(cell.v);
                        }
                    }
                    updateMappingRows();
                };
                reader.readAsArrayBuffer(file);
            }

            function updateMappingRows() {
    const container = document.getElementById('columnMappingContainer');
    container.innerHTML = '';

    // Başlık satırını ekle
    const headerRow = document.createElement('div');
    headerRow.className = 'row mb-3';
    headerRow.innerHTML = `
        <div class="col-5"><span class="data-import-title">Excel Alanları</span></div>
        <div class="col-5"><span class="data-import-title">${importType.options[importType.selectedIndex].text} Alanları</span></div>
    `;
    container.appendChild(headerRow);

    // Excel ve DB sütunlarının sayısını al
    const maxRows = Math.max(excelColumns.length, dbColumns.length);

    for (let i = 0; i < maxRows; i++) {
        const row = document.createElement('div');
        row.className = 'row mapping-row align-items-center';

        row.innerHTML = `
            <div class="col-5">
                <select class="form-select excel-column">
                    <option value="null">Excel Sütunu Seçin</option>
                    ${excelColumns.map((col, index) => `
                        <option value="${col}" ${index === i ? 'selected' : ''}>
                            ${col}
                        </option>
                    `).join('')}
                </select>
            </div>
            <div class="col-5">
                <select class="form-select db-column">
                    <option value="null" selected>Alan Seçin</option>
                    ${dbColumns.map((col, index) => `
                        <option value="${col.db_key}">
                            ${col.name}
                        </option>
                    `).join('')}
                </select>
            </div>
            <div class="col-2 text-center">
                <span class="status-indicator"></span>
            </div>
        `;

        container.appendChild(row);

        // Select2 ve diğer özellikleri ekle
        const selects = row.querySelectorAll('select');
        selects.forEach(select => {
            $(select).select2({
                width: '100%',
                placeholder: select.classList.contains('excel-column') ? 'Excel Sütunu Seçin' : 'Alan Seçin',
                allowClear: true,
                language: {
                    noResults: function() {
                        return "Sonuç bulunamadı";
                    },
                    searching: function() {
                        return "Aranıyor...";
                    }
                }
            });

            $(select).on('change', function() {
                checkMappingStatus(row);
            });
        });

        // İlk yüklemede eşleşme durumunu kontrol et
        checkMappingStatus(row);
    }
}

            function checkMappingStatus(row) {
                const excelSelect = $(row).find('.excel-column');
                const dbSelect = $(row).find('.db-column');
                const indicator = $(row).find('.status-indicator');

                if (excelSelect.val() && dbSelect.val() && excelSelect.val() !== "null" && dbSelect.val() !== "null") {
                    // Excel'deki seçilen değer ile DB'deki seçilen değerin metinlerini karşılaştır
                    const excelText = excelSelect.find('option:selected').text().trim().replace(/\s+/g, '').toLowerCase();
                    const dbText = dbSelect.find('option:selected').text().trim().replace(/\s+/g, '').toLowerCase();

                    if (excelText === dbText) {
                        indicator.addClass('matched');
                        indicator.css('background-color', '#006644'); // yeşil
                    } else {
                        indicator.addClass('matched');
                        indicator.css('background-color', '#FFA500'); // turuncu
                    }
                } else {
                    indicator.removeClass('matched');
                    indicator.css('background-color', '#dee2e6'); // varsayılan gri
                }
            }

            // Otomatik eşleştirme fonksiyonu
            function autoMatchColumns() {
                function normalize(str) {
                    if (!str) return '';
                    return str.toString().toLowerCase()
                        .trim()
                        .replace(/ı/g, 'i')
                        .replace(/ğ/g, 'g')
                        .replace(/ü/g, 'u')
                        .replace(/ş/g, 's')
                        .replace(/ö/g, 'o')
                        .replace(/ç/g, 'c')
                        .replace(/[^a-z0-9]/g, '');
                }

                const aliasMap = {
                    'tcno': 'tc_no',
                    'tc': 'tc_no',
                    'tckimlik': 'tc_no',
                    'tckimlikno': 'tc_no',
                    'tckimliknumarasi': 'tc_no',
                    'ceptelefonu': 'tel_no',
                    'telno': 'tel_no',
                    'telefon': 'tel_no',
                    'telefonnumarasi': 'tel_no',
                    'adlisicilkaydi': 'doc_adlisicilkaydi',
                    'nufuskayitonayi': 'doc_nufuskayitornegi',
                    'anneningelirbelgesi': 'doc_annegelirbelgesi',
                    'babaningelirbelgesi': 'doc_babagelirbelgesi',
                    'ogrencibelgesi': 'doc_ogrenciBelgesi',
                    'taahhutname': 'doc_taahhutname',
                    'kimlik': 'doc_kimlik',
                    'bankahesabi': 'doc_bankahesap',
                    'transkript': 'doc_transkript',
                    'ikametgah': 'doc_ikametgah',
                    'karne': 'doc_Karne',
                    'diger': 'doc_Diger',
                    'eposta': 'email',
                    'mail': 'email'
                };

                document.querySelectorAll('.mapping-row').forEach(row => {
                    const excelSelect = $(row).find('.excel-column');
                    const dbSelect = $(row).find('.db-column');

                    if (excelSelect.val() && excelSelect.val() !== "null") {
                        const excelText = excelSelect.find('option:selected').text().trim();
                        const normExcel = normalize(excelText);

                        let matchedValue = null;

                        dbSelect.find('option').each(function() {
                            const dbVal = $(this).val();
                            if (!dbVal || dbVal === "null") return;

                            const dbText = $(this).text().trim();
                            const normDbText = normalize(dbText);
                            const normDbVal = normalize(dbVal);

                            // 1. Birebir eşleşme
                            if (normExcel === normDbText || normExcel === normDbVal) {
                                matchedValue = dbVal;
                                return false;
                            }

                            // 2. Alias tablosundan eşleşme
                            if (aliasMap[normExcel] === dbVal || aliasMap[normExcel] === normDbVal || aliasMap[normExcel] === normDbText) {
                                matchedValue = dbVal;
                                return false;
                            }
                        });

                        if (matchedValue) {
                            dbSelect.val(matchedValue).trigger('change');
                        } else {
                            dbSelect.val("null").trigger('change');
                        }
                    }
                });
            }

            // Event Listeners
            nextBtn.addEventListener("click", () => {
                if (validateStep(currentStep)) {
                    if (currentStep === 1 && importType.value) {
                        setDbColumns(importType.value);
                    }
                    if (currentStep === 2 && currentStep < stepItems.length) {
                        currentStep++;
                        showStep(currentStep);
                        // 3. adıma geçildiğinde otomatik eşleştirme yap
                        setTimeout(() => {
                            autoMatchColumns();
                        }, 500);
                    } else if (currentStep < stepItems.length) {
                        currentStep++;
                        showStep(currentStep);
                    }
                }
            });

            prevBtn.addEventListener("click", () => {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            stepItems.forEach((item) => {
                item.addEventListener("click", function() {
                    const targetStep = parseInt(this.getAttribute("data-target"));
                    if (validateStep(targetStep)) {
                        currentStep = targetStep;
                        showStep(currentStep);
                    }
                });
            });

            // Excel dosyası yükleme işlemleri
            browseButton.addEventListener('click', () => {
                fileInput.click();
            });

            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files[0]) {
                    handleFile(files[0]);
                }
            });

            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    handleFile(file);
                }
            });

            function handleFile(file) {
                if (file) {
                    const extension = file.name.split('.').pop().toLowerCase();
                    if (['xlsx', 'xls'].includes(extension)) {
                        uploadFile(file);
                        readExcelColumns(file);
                    } else {
                        alert('Lütfen sadece Excel dosyası (.xlsx, .xls) yükleyin.');
                    }
                }
            }

            function uploadFile(file) {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('data-import.upload') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentImportId = data.data.id;
                        uploadArea.classList.add('d-none');
                        filePreview.classList.remove('d-none');
                        hasUploadedFile = true;
                    } else {
                        alert('Dosya yükleme başarısız: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert('Dosya yükleme sırasında bir hata oluştu.');
                });
            }

            removeFile.addEventListener('click', () => {
                if (currentImportId) {
                    fetch('{{ route('data-import.destroy') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: currentImportId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Dosya silme hatası:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Dosya silme hatası:', error);
                    });
                }

                fileInput.value = '';
                filePreview.classList.add('d-none');
                uploadArea.classList.remove('d-none');
                hasUploadedFile = false;
                excelColumns = [];
                currentImportId = null;
                updateMappingRows();
            });

            completeBtn.addEventListener("click", () => {
                const mappings = [];
                document.querySelectorAll('.mapping-row').forEach(row => {
                    const excelSelect = $(row).find('.excel-column');
                    const dbSelect = $(row).find('.db-column');

                    if (excelSelect.val() && dbSelect.val() && excelSelect.val() !== "null" && dbSelect.val() !== "null") {
                        mappings.push({
                            excel_column: excelSelect.val(),
                            db_column: dbSelect.val()
                        });
                    }
                });

                fetch('{{ route('data-import.process') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        type: importType.value,
                        mappings: mappings,
                        import_id: currentImportId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('successRecord').innerHTML = data.data.success;
                        document.getElementById('errorRecord').innerHTML = data.data.error;
                        document.getElementById('tableName').innerHTML = data.data.type;
                        document.getElementById('resultDiv').classList.remove('d-none');
                        completeBtn.innerHTML = 'Kapat';
                        completeBtn.onclick = function() {
                            window.location.href = '{{ route('data-import.index') }}';
                        };
                    }
                    else{
                        alert('İşlem Başarısız.Lütfen zorunlu alanları doldurunuz ve tekrar deneyiniz.');
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert('İşlem sırasında bir hata oluştu.');
                });
            });

            $('.select2').select2({
                width: '100%',
                placeholder: 'Seçiniz',
                allowClear: true,
                language: {
                    noResults: function() {
                        return "Sonuç bulunamadı";
                    },
                    searching: function() {
                        return "Aranıyor...";
                    }
                }
            });

            $('.select2').on('select2:open', function() {
                document.querySelector('.select2-search__field').focus();
            });

            // Initial step show
            showStep(currentStep);
        });
    </script>
@endsection
