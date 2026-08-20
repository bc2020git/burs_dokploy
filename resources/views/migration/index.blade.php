<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosya Taşıma İşlemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow">

            <div class="card-body">
                <div class="alert alert-info">
                    Farkli ky donemleri oldugu icin ortaogretim , yuksekogretim seklinde ayrildi
                </div>

                <div class="mb-4">
                    <label class="form-label">Öğrenci Tipi Seçiniz:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="migrationType" id="typeLise"
                            value="lise">
                        <label class="form-check-label" for="typeLise">
                            İlkokul / Ortaokul / Lise
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="migrationType" id="typeLisans"
                            value="lisans" checked>
                        <label class="form-check-label" for="typeLisans">
                            Lisans / Yüksek Lisans / Doktora
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <button id="startBtn" class="btn btn-success btn-lg w-100" onclick="startMigration()">
                        Taşıma İşlemini Başlat
                    </button>
                </div>

                <div class="progress mb-3" style="height: 25px; display: none;" id="progressContainer">
                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar" style="width: 0%">0%</div>
                </div>

                <div class="card bg-success text-white mb-3" id="successContainer" style="display: none;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Başarılı İşlemler</span>
                        <button class="btn btn-light btn-sm" onclick="exportToExcel()">Excel'e Aktar</button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-success table-striped mb-0 text-white">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ad</th>
                                    <th>Soyad</th>
                                    <th>Öğrenim Türü</th>
                                    <th>DB Key</th>
                                </tr>
                            </thead>
                            <tbody id="successTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card bg-dark text-white">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>İşlem Logları</span>
                        <span id="statusCount" class="badge bg-warning">Bekleniyor...</span>
                    </div>
                    <div class="card-body p-0">
                        <div id="logs" class="p-3"
                            style="height: 400px; overflow-y: auto; font-family: monospace; font-size: 0.9em;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const logDiv = document.getElementById('logs');
        const progressBar = document.getElementById('progressBar');
        const progressContainer = document.getElementById('progressContainer');
        const statusCount = document.getElementById('statusCount');
        const startBtn = document.getElementById('startBtn');
        const successContainer = document.getElementById('successContainer');
        const successTableBody = document.getElementById('successTableBody');
        let allSuccessesData = [];

        function log(message, type = 'info') {
            const color = type === 'error' ? 'text-danger' : (type === 'success' ? 'text-success' : 'text-white');
            const time = new Date().toLocaleTimeString();
            logDiv.innerHTML += `<div class="${color}">[${time}] ${message}</div>`;
            logDiv.scrollTop = logDiv.scrollHeight;
        }

        function addSuccessRow(item) {
            const row = `<tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.surname}</td>
                <td>${item.type}</td>
                <td>${item.key}</td>
            </tr>`;
            successTableBody.innerHTML += row;
        }

        function exportToExcel() {
            if (allSuccessesData.length === 0) {
                alert("Dışa aktarılacak veri bulunamadı.");
                return;
            }

            const ws = XLSX.utils.json_to_sheet(allSuccessesData);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Basarili_Islemler");
            XLSX.writeFile(wb, "bursiyer_tasima_basarili_listesi.xlsx");
        }

        async function startMigration() {
            const type = document.querySelector('input[name="migrationType"]:checked').value;

            startBtn.disabled = true;
            progressContainer.style.display = 'block';
            successContainer.style.display = 'none';
            successTableBody.innerHTML = '';
            allSuccessesData = [];

            log(`Öğrenci listesi çekiliyor (${type.toUpperCase()})...`, 'info');

            try {
                // 1. Öğrenci ID'lerini çek
                const response = await axios.get('/migration-scholars', {
                    params: {
                        type: type
                    }
                });
                const allIds = response.data;
                const total = allIds.length;

                log(`${total} adet öğrenci bulundu. İşlem başlıyor...`, 'success');
                statusCount.innerText = `0 / ${total}`;

                // 2. Gruplara böl (10'arlı)
                const batchSize = 10;
                let processed = 0;
                let allSuccesses = [];

                for (let i = 0; i < total; i += batchSize) {
                    const batchIds = allIds.slice(i, i + batchSize);

                    try {
                        const batchResponse = await axios.post('/migration-batch', {
                            ids: batchIds,
                            type: type
                        });

                        // Log detayları
                        if (batchResponse.data.logs) {
                            batchResponse.data.logs.forEach(l => log(l));
                        }

                        // Başarılı işlemleri topla
                        if (batchResponse.data.successes) {
                            batchResponse.data.successes.forEach(s => {
                                allSuccessesData.push(s);
                                addSuccessRow(s); // Anlık olarak tabloya ekle
                            });
                        }

                        processed += batchIds.length;
                        const percent = Math.round((processed / total) * 100);
                        progressBar.style.width = `${percent}%`;
                        progressBar.innerText = `${percent}%`;
                        statusCount.innerText = `${processed} / ${total}`;

                    } catch (err) {
                        log(`Batch Hatası (${i}-${i+batchSize}): ${err.message}`, 'error');
                        console.error(err);
                    }
                }

                if (allSuccessesData.length > 0) {
                    successContainer.style.display = 'block';
                }

                log('Tüm işlemler tamamlandı.', 'success');
                startBtn.innerText = 'İşlem Tamamlandı';
                startBtn.disabled = false; // Re-enable for another run if needed

            } catch (error) {
                log(`Genel Hata: ${error.message}`, 'error');
                startBtn.disabled = false;
            }
        }

        async function startCleanup() {
            const cleanupBtn = document.getElementById('cleanupBtn');

            if (! confirm('75 dönemi çift kayıtları silmek istediğinize emin misiniz? Bu işlem sadece 65 dönemiyle birebir aynı olan kayıtları siler.')) {
                return;
            }

            cleanupBtn.disabled = true;
            progressContainer.style.display = 'none';
            successContainer.style.display = 'none';
            successTableBody.innerHTML = '';
            allSuccessesData = [];
            log('75 dönemi çift kayıt temizleme işlemi başlatılıyor...', 'info');

            try {
                const response = await axios.get('/cleanup-duplicate-75-forms');
                const data = response.data;

                if (data.logs) {
                    data.logs.forEach(l => log(l));
                }

                log(`İşlem tamamlandı. Silinen: ${data.deleted_count ?? 0}, Atlanan: ${data.skipped_count ?? 0}`, 'success');
            } catch (error) {
                log(`Temizleme Hatası: ${error.message}`, 'error');
                console.error(error);
            } finally {
                cleanupBtn.disabled = false;
            }
        }

        async function loadDuplicateReport() {
            const reportBtn = document.getElementById('reportBtn');
            reportBtn.disabled = true;
            reportBtn.innerText = 'Rapor Yükleniyor...';
            log('Çoklu kayıt raporu yükleniyor...', 'info');

            try {
                const response = await axios.get('/lise-duplicate-form-report');
                const data = response.data.data || [];
                reportData = data;

                const reportContainer = document.getElementById('reportContainer');
                const reportTableBody = document.getElementById('reportTableBody');
                reportTableBody.innerHTML = '';

                if (data.length === 0) {
                    log('Rapor için kayıt bulunamadı.', 'success');
                    reportContainer.style.display = 'none';
                } else {
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.scholar_id ?? ''}</td>
                            <td>${row.scholar_name ?? ''}</td>
                            <td>${row.scholar_surname ?? ''}</td>
                            <td>${row.scholar_forms_count ?? ''}</td>
                            <td>${row.scholar_form_period_ids ?? ''}</td>
                            <td>${row.active_answers_count ?? ''}</td>
                            <td>${row.period_id ?? ''}</td>
                            <td>${row.educationType ?? ''}</td>
                        `;
                        reportTableBody.appendChild(tr);
                    });

                    reportContainer.style.display = 'block';
                    log(`${data.length} adet kayıt getirildi.`, 'success');
                }

                reportBtn.innerText = 'Rapor Yüklendi';
            } catch (error) {
                log(`Rapor hatası: ${error.message}`, 'error');
                reportBtn.disabled = false;
                reportBtn.innerText = 'İlkokul/Ortaokul/Lise Çoklu Kayıt Raporu';
            }
        }

        function exportReportToExcel() {
            if (reportData.length === 0) {
                alert('Dışa aktarılacak rapor verisi bulunamadı.');
                return;
            }

            const ws = XLSX.utils.json_to_sheet(reportData);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Coklu_Kayit_Raporu');
            XLSX.writeFile(wb, 'coklu_kayit_raporu.xlsx');
        }
    </script>
</body>

</html>
