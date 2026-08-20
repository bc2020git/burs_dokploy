@extends('layouts.master')

@section('title')
    Aktif Cevap Dosya Düzenleme
@endsection

@section('local-css')
    <style>
        .repair-shell { max-width: 1500px; margin: 0 auto; }
        .repair-hero { background: linear-gradient(135deg, #172554, #4338ca); color: #fff; border-radius: 18px; padding: 28px; }
        .repair-step { display: none; }
        .repair-step.active { display: block; }
        .step-pill { flex: 1; min-width: 150px; padding: 12px 16px; border-radius: 12px; background: #eef2ff; color: #64748b; font-weight: 600; }
        .step-pill.active { background: #4338ca; color: #fff; }
        .step-pill.done { background: #dcfce7; color: #166534; }
        .column-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 10px; max-height: 360px; overflow-y: auto; }
        .column-option { border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px; background: #fff; }
        .table-path { min-width: 260px; max-width: 360px; word-break: break-all; font-size: 12px; }
        .sticky-actions { position: sticky; bottom: 0; z-index: 5; background: rgba(255,255,255,.96); border-top: 1px solid #e2e8f0; padding: 16px 0; }
        .result-log { max-height: 420px; overflow-y: auto; }
    </style>
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <main class="main-content px-3 py-4">
        <div class="repair-shell">
            <div class="repair-hero mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <div class="text-uppercase small opacity-75 mb-1">Active Answers</div>
                        <h2 class="mb-2">Dosya temizleme ve eşleştirme</h2>
                        <p class="mb-0 opacity-75">İlkokul, ortaokul ve lise öğrencilerinin dönem bazlı dosya pathlerini güvenli adımlarla düzenleyin.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <button type="button" class="btn btn-warning text-dark fw-bold btn-sm shadow-sm" id="resetTestDataBtn">
                            <i class="bx bx-refresh me-1"></i> Örnek Test Verilerini Yeniden Oluştur (Period 75)
                        </button>
                        <span class="badge bg-danger text-white fs-6">Geri alınamaz işlem</span>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-4" id="stepPills">
                <div class="step-pill active" data-pill="1">1. Dönem</div>
                <div class="step-pill" data-pill="2">2. Kayıtlar ve silinecek sütunlar</div>
                <div class="step-pill" data-pill="3">3. Tarih aralığı</div>
                <div class="step-pill" data-pill="4">4. Hedef sütunlar</div>
                <div class="step-pill" data-pill="5">5. Onay</div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <section class="repair-step active" data-step="1">
                        <h4>Dönem seçin</h4>
                        <p class="text-muted">Yalnızca seçilen `period_id` ile eşleşen ilkokul, ortaokul ve lise cevapları getirilecektir.</p>
                        <label for="periodId" class="form-label">Dönem</label>
                        <select id="periodId" class="form-select form-select-lg">
                            <option value="">Seçiniz</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}">#{{ $period->id }} - {{ $period->title ?? 'Dönem' }}</option>
                            @endforeach
                        </select>
                        <div class="sticky-actions text-end mt-4">
                            <button type="button" class="btn btn-primary btn-lg" id="loadScholars">Kayıtları getir</button>
                        </div>
                    </section>

                    <section class="repair-step" data-step="2">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <div>
                                <h4 class="mb-1">Eşleşen kayıtlar</h4>
                                <span class="text-muted" id="scholarCount"></span>
                            </div>
                            <input type="search" id="tableSearch" class="form-control" style="max-width: 320px" placeholder="Tabloda ara">
                        </div>
                        <div class="table-responsive mb-4" style="max-height: 460px">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light sticky-top">
                                    <tr id="scholarHead"></tr>
                                </thead>
                                <tbody id="scholarBody"></tbody>
                            </table>
                        </div>
                        <h5>Silinecek ve null yapılacak sütunlar</h5>
                        <p class="text-muted">Seçilen sütunlardaki `/storage/bursiyerler/{scholar_id}/...` dosyaları silinir ve değerler null yapılır.</p>
                        <div class="column-grid" id="clearColumns">
                            @foreach ($fileColumns as $key => $title)
                                <label class="column-option">
                                    <input type="checkbox" class="form-check-input me-2" value="{{ $key }}">
                                    <strong>{{ $title }}</strong>
                                    <small class="d-block text-muted mt-1">{{ $key }}</small>
                                </label>
                            @endforeach
                        </div>
                        <div class="sticky-actions d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-light" data-back="1">Geri</button>
                            <button type="button" class="btn btn-primary" id="toDates">Tarih aralığına geç</button>
                        </div>
                    </section>

                    <section class="repair-step" data-step="3">
                        <h4>Dosya tarih aralığını seçin</h4>
                        <p class="text-muted">Her öğrencinin `storage/bursiyerler/{scholar_id}` klasöründe değiştirilme tarihi bu aralıkta olan dosyalar taranır. İşlem için tam olarak iki uygun dosya bulunmalıdır.</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="startDate" class="form-label">Başlangıç tarihi</label>
                                <input type="date" id="startDate" class="form-control form-control-lg">
                            </div>
                            <div class="col-md-6">
                                <label for="endDate" class="form-label">Bitiş tarihi</label>
                                <input type="date" id="endDate" class="form-control form-control-lg">
                            </div>
                        </div>
                        <div class="sticky-actions d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-light" data-back="2">Geri</button>
                            <button type="button" class="btn btn-primary" id="toTargets">Hedef sütunlara geç</button>
                        </div>
                    </section>

                    <section class="repair-step" data-step="4">
                        <h4>İki hedef sütunu seçin</h4>
                        <p class="text-muted">Tarihe göre önce bulunan dosya birinci sütuna, ikinci dosya ikinci sütuna yazılır. Dolu hedef sütun, silinecek sütunlar arasında değilse öğrenci atlanır.</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="targetOne" class="form-label">Birinci dosyanın sütunu</label>
                                <select id="targetOne" class="form-select form-select-lg">
                                    <option value="">Seçiniz</option>
                                    @foreach ($fileColumns as $key => $title)
                                        <option value="{{ $key }}">{{ $title }} ({{ $key }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="targetTwo" class="form-label">İkinci dosyanın sütunu</label>
                                <select id="targetTwo" class="form-select form-select-lg">
                                    <option value="">Seçiniz</option>
                                    @foreach ($fileColumns as $key => $title)
                                        <option value="{{ $key }}">{{ $title }} ({{ $key }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="sticky-actions d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-light" data-back="3">Geri</button>
                            <button type="button" class="btn btn-primary" id="toConfirmation">Özeti göster</button>
                        </div>
                    </section>

                    <section class="repair-step" data-step="5">
                        <h4>İşlem özeti</h4>
                        <div class="alert alert-danger">Seçilen mevcut dosyalar projeden kalıcı olarak silinecektir. Bu işlem geri alınamaz.</div>
                        <dl class="row" id="summary"></dl>
                        <label class="column-option d-block mt-3">
                            <input type="checkbox" class="form-check-input me-2" id="confirmation">
                            Dosyaların kalıcı olarak silineceğini ve veritabanı alanlarının değişeceğini onaylıyorum.
                        </label>
                        <div class="sticky-actions d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-light" data-back="4">Geri</button>
                            <button type="button" class="btn btn-danger btn-lg" id="processRepair">İşleme başla</button>
                        </div>
                    </section>

                    <section class="repair-step" data-step="6">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <h4 class="mb-0">İşlem Sonuç Raporu</h4>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-success" id="exportResultsExcelBtn">
                                    <i class="bx bx-download me-1"></i> İşlem Sonuç Raporunu Excel İndir
                                </button>
                                <button type="button" class="btn btn-info text-white" id="loadFolderFilesBtn">
                                    <i class="bx bx-folder me-1"></i> Klasör Dosyalarını Göster ve İndir
                                </button>
                            </div>
                        </div>
                        <div id="resultSummary"></div>
                        <div class="table-responsive result-log mt-3">
                            <table class="table table-sm table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr><th>Answer ID</th><th>Scholar ID</th><th>Öğrenci</th><th>Tür</th><th>Durum</th><th>Açıklama</th></tr>
                                </thead>
                                <tbody id="resultBody"></tbody>
                            </table>
                        </div>

                        <!-- Öğrenci Klasör Dosyaları Alanı -->
                        <div id="folderFilesSection" class="mt-4 p-3 border rounded bg-light" style="display: none;">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                <div>
                                    <h5 class="mb-1"><i class="bx bx-folder-open me-1"></i> Öğrenci Klasör Dosyaları</h5>
                                    <small class="text-muted" id="folderFilesCountInfo"></small>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <input type="search" id="folderFilesSearch" class="form-control form-control-sm" style="max-width: 250px;" placeholder="Klasör dosyalarında ara...">
                                    <button type="button" class="btn btn-success btn-sm" id="exportFolderFilesExcelBtn">
                                        <i class="bx bx-download me-1"></i> Klasör Dosyalarını Excel İndir
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 400px;">
                                <table class="table table-sm table-striped table-hover align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Scholar ID</th>
                                            <th>Öğrenci Adı Soyadı</th>
                                            <th>Öğrenim Türü</th>
                                            <th>Dönem ID</th>
                                            <th>Tanımlı Sütun</th>
                                            <th>Dosya Adı</th>
                                            <th>Dosya Yolu (Path)</th>
                                            <th>Son Değiştirilme</th>
                                        </tr>
                                    </thead>
                                    <tbody id="folderFilesBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-secondary" onclick="window.location.reload()">Yeni İşlem Yap</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        const state = { scholars: [], columns: @json($fileColumns), lastResults: [], folderFiles: [] };
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const previewUrl = @json(route('active-answer-file-repair.scholars'));
        const processUrl = @json(route('active-answer-file-repair.process'));
        const exportResultsUrl = @json(route('active-answer-file-repair.export-results'));
        const folderFilesUrl = @json(route('active-answer-file-repair.folder-files'));
        const exportFolderFilesUrl = @json(route('active-answer-file-repair.export-folder-files'));
        const resetTestDataUrl = @json(route('active-answer-file-repair.reset-test-data'));

        function showStep(step) {
            document.querySelectorAll('.repair-step').forEach(item => item.classList.toggle('active', Number(item.dataset.step) === step));
            document.querySelectorAll('.step-pill').forEach(item => {
                const number = Number(item.dataset.pill);
                item.classList.toggle('active', number === step);
                item.classList.toggle('done', number < step);
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function selectedClearColumns() {
            return Array.from(document.querySelectorAll('#clearColumns input:checked')).map(input => input.value);
        }

        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value == null ? '' : String(value);
            return div.innerHTML;
        }

        function renderTable(items) {
            const fileKeys = Object.keys(state.columns);
            document.getElementById('scholarHead').innerHTML = ['Answer ID', 'Scholar ID', 'Ad Soyad', 'Öğrenim', ...fileKeys.map(key => state.columns[key])]
                .map(title => `<th>${escapeHtml(title)}</th>`).join('');
            document.getElementById('scholarBody').innerHTML = items.map(item => {
                const paths = fileKeys.map(key => `<td class="table-path">${item[key] ? `<a href="${escapeHtml(item[key])}" target="_blank">${escapeHtml(item[key])}</a>` : '<span class="text-muted">Boş</span>'}</td>`).join('');
                return `<tr><td>${item.id}</td><td>${item.scholar_id}</td><td>${escapeHtml(`${item.name || ''} ${item.surname || ''}`.trim())}</td><td>${escapeHtml(item.educationType)}</td>${paths}</tr>`;
            }).join('');
        }

        async function jsonRequest(url, payload) {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify(payload)
            });
            const data = await response.json();
            if (!response.ok) {
                const messages = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
                throw new Error(messages || 'İşlem gerçekleştirilemedi.');
            }
            return data;
        }

        function triggerFormDownload(url, payload) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.target = '_blank';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = token;
            form.appendChild(csrfInput);

            for (const key in payload) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = typeof payload[key] === 'object' ? JSON.stringify(payload[key]) : payload[key];
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        document.getElementById('loadScholars').addEventListener('click', async function () {
            const periodId = document.getElementById('periodId').value;
            if (!periodId) return alert('Dönem seçin.');
            this.disabled = true;
            this.textContent = 'Yükleniyor...';
            try {
                const data = await jsonRequest(previewUrl, { period_id: periodId });
                state.scholars = data.scholars;
                state.columns = data.columns;
                document.getElementById('scholarCount').textContent = `${data.count} öğrenci cevabı bulundu.`;
                renderTable(state.scholars);
                showStep(2);
            } catch (error) {
                alert(error.message);
            } finally {
                this.disabled = false;
                this.textContent = 'Kayıtları getir';
            }
        });

        document.getElementById('tableSearch').addEventListener('input', function () {
            const query = this.value.toLocaleLowerCase('tr-TR');
            renderTable(state.scholars.filter(item => JSON.stringify(item).toLocaleLowerCase('tr-TR').includes(query)));
        });

        document.getElementById('toDates').addEventListener('click', function () {
            if (!state.scholars.length) return alert('İşlenecek kayıt bulunmuyor.');
            if (!selectedClearColumns().length) return alert('En az bir silinecek sütun seçin.');
            showStep(3);
        });

        document.getElementById('toTargets').addEventListener('click', function () {
            const start = document.getElementById('startDate').value;
            const end = document.getElementById('endDate').value;
            if (!start || !end) return alert('Başlangıç ve bitiş tarihlerini seçin.');
            if (end < start) return alert('Bitiş tarihi başlangıç tarihinden önce olamaz.');
            showStep(4);
        });

        document.getElementById('toConfirmation').addEventListener('click', function () {
            const first = document.getElementById('targetOne').value;
            const second = document.getElementById('targetTwo').value;
            if (!first || !second) return alert('İki hedef sütunu da seçin.');
            if (first === second) return alert('Hedef sütunlar farklı olmalıdır.');
            const clearLabels = selectedClearColumns().map(key => `${state.columns[key]} (${key})`).join(', ');
            document.getElementById('summary').innerHTML = `
                <dt class="col-sm-4">Dönem ID</dt><dd class="col-sm-8">${escapeHtml(document.getElementById('periodId').value)}</dd>
                <dt class="col-sm-4">Eşleşen cevap</dt><dd class="col-sm-8">${state.scholars.length}</dd>
                <dt class="col-sm-4">Silinecek sütunlar</dt><dd class="col-sm-8">${escapeHtml(clearLabels)}</dd>
                <dt class="col-sm-4">Tarih aralığı</dt><dd class="col-sm-8">${escapeHtml(document.getElementById('startDate').value)} - ${escapeHtml(document.getElementById('endDate').value)}</dd>
                <dt class="col-sm-4">Birinci hedef</dt><dd class="col-sm-8">${escapeHtml(state.columns[first])} (${escapeHtml(first)})</dd>
                <dt class="col-sm-4">İkinci hedef</dt><dd class="col-sm-8">${escapeHtml(state.columns[second])} (${escapeHtml(second)})</dd>`;
            showStep(5);
        });

        document.querySelectorAll('[data-back]').forEach(button => button.addEventListener('click', () => showStep(Number(button.dataset.back))));

        document.getElementById('processRepair').addEventListener('click', async function () {
            if (!document.getElementById('confirmation').checked) return alert('Devam etmek için onay kutusunu işaretleyin.');
            if (!confirm('Dosyalar kalıcı olarak silinecek. İşleme devam edilsin mi?')) return;
            this.disabled = true;
            this.textContent = 'İşleniyor...';
            try {
                const data = await jsonRequest(processUrl, {
                    period_id: document.getElementById('periodId').value,
                    clear_columns: selectedClearColumns(),
                    start_date: document.getElementById('startDate').value,
                    end_date: document.getElementById('endDate').value,
                    target_columns: [document.getElementById('targetOne').value, document.getElementById('targetTwo').value],
                    confirmation: true
                });
                state.lastResults = data.results;
                document.getElementById('resultSummary').innerHTML = `<div class="alert alert-info"><strong>${data.updated_count}</strong> kayıt güncellendi, <strong>${data.deleted_count}</strong> dosya silindi, <strong>${data.skipped_count}</strong> kayıt atlandı/hata aldı.</div>`;
                document.getElementById('resultBody').innerHTML = data.results.map(item => `<tr><td>${item.answer_id}</td><td>${item.scholar_id}</td><td>${escapeHtml(item.name)}</td><td>${escapeHtml(item.education_type)}</td><td><span class="badge ${item.status === 'success' ? 'bg-success' : item.status === 'error' ? 'bg-danger' : 'bg-warning text-dark'}">${escapeHtml(item.status)}</span></td><td>${escapeHtml(item.message)}</td></tr>`).join('');
                showStep(6);
            } catch (error) {
                alert(error.message);
                this.disabled = false;
                this.textContent = 'İşleme başla';
            }
        });

        // 1. İşlem sonuç raporunu Excel indir
        document.getElementById('exportResultsExcelBtn').addEventListener('click', function () {
            const periodId = document.getElementById('periodId').value;
            if (!state.lastResults || !state.lastResults.length) {
                return alert('İndirilecek işlem sonucu bulunamadı.');
            }
            triggerFormDownload(exportResultsUrl, {
                period_id: periodId,
                results: state.lastResults
            });
        });

        // 2. Klasör dosyalarını getir ve göster
        document.getElementById('loadFolderFilesBtn').addEventListener('click', async function () {
            const periodId = document.getElementById('periodId').value;
            if (!periodId) return alert('Dönem seçin.');

            this.disabled = true;
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Klasörler taranıyor...';

            try {
                const data = await jsonRequest(folderFilesUrl, { period_id: periodId });
                state.folderFiles = data.files;

                document.getElementById('folderFilesCountInfo').textContent = `${data.files.length} dosya kaydı listelendi.`;
                renderFolderFilesTable(state.folderFiles);
                document.getElementById('folderFilesSection').style.display = 'block';
                document.getElementById('folderFilesSection').scrollIntoView({ behavior: 'smooth' });
            } catch (error) {
                alert(error.message);
            } finally {
                this.disabled = false;
                this.innerHTML = originalText;
            }
        });

        function renderFolderFilesTable(files) {
            document.getElementById('folderFilesBody').innerHTML = files.map(item => `
                <tr>
                    <td>${item.scholar_id}</td>
                    <td>${escapeHtml(item.name_surname)}</td>
                    <td>${escapeHtml(item.education_type)}</td>
                    <td>${item.period_id !== '-' ? `<span class="badge bg-primary">#${escapeHtml(item.period_id)}</span>` : '<span class="badge bg-secondary">Boş</span>'}</td>
                    <td>${escapeHtml(item.matched_column)}</td>
                    <td>${escapeHtml(item.filename)}</td>
                    <td class="table-path">${item.path !== '-' ? `<a href="${escapeHtml(item.path)}" target="_blank">${escapeHtml(item.path)}</a>` : '-'}</td>
                    <td>${escapeHtml(item.last_modified)}</td>
                </tr>
            `).join('');
        }

        // Klasör dosyaları içi arama
        document.getElementById('folderFilesSearch').addEventListener('input', function () {
            const query = this.value.toLocaleLowerCase('tr-TR');
            renderFolderFilesTable(state.folderFiles.filter(item =>
                JSON.stringify(item).toLocaleLowerCase('tr-TR').includes(query)
            ));
        });

        // 3. Klasör dosyaları raporunu Excel indir
        document.getElementById('exportFolderFilesExcelBtn').addEventListener('click', function () {
            const periodId = document.getElementById('periodId').value;
            if (!periodId) return alert('Dönem seçin.');
            triggerFormDownload(exportFolderFilesUrl, { period_id: periodId });
        });

        // 4. Örnek test verilerini sıfırla / yeniden oluştur
        document.getElementById('resetTestDataBtn').addEventListener('click', async function () {
            const selectedPeriod = document.getElementById('periodId').value || 75;
            if (!confirm(`Dönem #${selectedPeriod} için 40 bursiyerin dosya yolları ve storage klasöründeki test dosyaları sıfırlanıp yeniden oluşturulacak. Devam edilsin mi?`)) {
                return;
            }

            this.disabled = true;
            const originalHtml = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Veriler sıfırlanıyor...';

            try {
                const data = await jsonRequest(resetTestDataUrl, { period_id: selectedPeriod });
                alert(data.message);
                document.getElementById('periodId').value = selectedPeriod;
                document.getElementById('loadScholars').click();
            } catch (error) {
                alert(error.message);
            } finally {
                this.disabled = false;
                this.innerHTML = originalHtml;
            }
        });
    </script>
@endsection
