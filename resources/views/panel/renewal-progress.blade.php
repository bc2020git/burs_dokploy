@extends('layouts.master')

@section('local-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<style>
    .progress-container {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .progress-bar-custom {
        height: 25px;
        border-radius: 15px;
        background: linear-gradient(90deg, #4CAF50 0%, #45a049 100%);
        transition: width 0.5s ease-in-out;
    }

    .progress-bg {
        background-color: #e9ecef;
        border-radius: 15px;
        overflow: hidden;
    }

    .stats-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 15px;
    }

    .education-type-badge {
        background: #007bff;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        margin: 5px;
        display: inline-block;
    }

    .log-container {
        max-height: 300px;
        overflow-y: auto;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        font-family: 'Courier New', monospace;
        font-size: 13px;
    }

    .log-entry {
        margin-bottom: 5px;
        padding: 3px 0;
    }

    .log-success { color: #28a745; }
    .log-info { color: #17a2b8; }
    .log-warning { color: #ffc107; }
    .log-error { color: #dc3545; }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endsection

@section('title')
Kayıt Yenileme İşlemi
@endsection

@section('page-title')
Kayıt Yenileme Formları Oluşturuluyor
@endsection

@section('body')
<body data-sidebar="colored">
@endsection

@section('content')
<main class="main-content px-3 py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="progress-container">
                    <div class="text-center mb-4">
                        <h3 class="text-primary">
                            <i class="ri-refresh-line pulse"></i>
                            Kayıt Yenileme İşlemi Devam Ediyor
                        </h3>
                        <p class="text-muted">Lütfen sayfayı kapatmayın, işlem otomatik olarak tamamlanacaktır.</p>
                    </div>

                    <!-- Ana Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Genel İlerleme</span>
                            <span id="progress-percentage" class="fw-bold text-primary">0%</span>
                        </div>
                        <div class="progress-bg">
                            <div id="main-progress-bar" class="progress-bar-custom" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- İstatistikler -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="stats-card text-center">
                                <h5 class="text-primary mb-1" id="total-students">0</h5>
                                <small class="text-muted">Toplam Öğrenci</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card text-center">
                                <h5 class="text-success mb-1" id="processed-students">0</h5>
                                <small class="text-muted">İşlenen Öğrenci</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card text-center">
                                <h5 class="text-info mb-1" id="current-batch">0</h5>
                                <small class="text-muted">Mevcut Batch</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card text-center">
                                <h5 class="text-warning mb-1" id="remaining-students">0</h5>
                                <small class="text-muted">Kalan Öğrenci</small>
                            </div>
                        </div>
                    </div>

                    <!-- Öğretim Tipleri -->
                    <div class="mb-4">
                        <h6 class="mb-3">İşlenecek Öğretim Tipleri:</h6>
                        <div id="education-types-container">
                            @foreach($educationTypes as $type)
                                <span class="education-type-badge">{{ ucfirst($type) }}</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mevcut İşlem Durumu -->
                    <div class="stats-card mb-4">
                        <h6 class="mb-3">
                            <i class="ri-information-line"></i>
                            Mevcut İşlem Durumu
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>İşlenen Öğretim Tipi:</strong>
                                <span id="current-education-type" class="text-primary">Başlatılıyor...</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Son İşlem:</strong>
                                <span id="last-message" class="text-info">İşlem başlatılıyor...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Log Alanı -->
                    <div class="stats-card">
                        <h6 class="mb-3">
                            <i class="ri-file-text-line"></i>
                            İşlem Logları
                        </h6>
                        <div id="log-container" class="log-container">
                            <div class="log-entry log-info">
                                [<span id="start-time"></span>] İşlem başlatılıyor...
                            </div>
                        </div>
                    </div>

                    <!-- Kontrol Butonları -->
                    <div class="text-center mt-4">
                        <button id="pause-btn" class="btn btn-warning me-2" style="display: none;">
                            <i class="ri-pause-line"></i>
                            Duraklat
                        </button>
                        <button id="resume-btn" class="btn btn-success me-2" style="display: none;">
                            <i class="ri-play-line"></i>
                            Devam Et
                        </button>
                        <button id="complete-btn" class="btn btn-primary" style="display: none;" onclick="goToPeriodManagement()">
                            <i class="ri-check-line"></i>
                            Dönem Yönetimine Dön
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
let sessionId = '{{ $sessionId }}';
let isProcessing = false;
let isPaused = false;
let batchInterval;

document.addEventListener('DOMContentLoaded', function() {
    // Başlangıç zamanını ayarla
    document.getElementById('start-time').textContent = new Date().toLocaleTimeString('tr-TR');

    // İşlemi başlat
    startRenewalProcess();
});

function startRenewalProcess() {
    addLog('İşlem başlatılıyor...', 'info');

    fetch('{{ route("start-renewal-process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            sessionId: sessionId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('total-students').textContent = data.totalStudents;
            document.getElementById('remaining-students').textContent = data.totalStudents;

            addLog(`Toplam ${data.totalStudents} öğrenci bulundu`, 'success');
            addLog(`İşlenecek öğretim tipleri: ${data.educationTypes.join(', ')}`, 'info');

            // Batch işlemeyi başlat
            isProcessing = true;
            processBatches();
        } else {
            addLog('Hata: ' + data.message, 'error');
            Swal.fire('Hata', data.message, 'error');
        }
    })
    .catch(error => {
        addLog('Network hatası: ' + error.message, 'error');
        console.error('Error:', error);
    });
}

function processBatches() {
    if (!isProcessing || isPaused) return;

    fetch('{{ route("process-renewal-batch") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            sessionId: sessionId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Progress bar güncelle
            updateProgress(data.progress);

            // İstatistikleri güncelle
            document.getElementById('processed-students').textContent = data.totalProcessed;
            document.getElementById('remaining-students').textContent = data.totalStudents - data.totalProcessed;
            document.getElementById('current-education-type').textContent = data.currentType || 'Tamamlandı';
            document.getElementById('last-message').textContent = data.message;

            // Batch sayısını güncelle (yaklaşık)
            let currentBatch = Math.ceil(data.totalProcessed / 70);
            document.getElementById('current-batch').textContent = currentBatch;

            // Log ekle
            addLog(data.message, 'success');

            if (data.completed) {
                // İşlem tamamlandı
                isProcessing = false;
                addLog('Tüm işlemler başarıyla tamamlandı!', 'success');
                document.getElementById('complete-btn').style.display = 'inline-block';

                Swal.fire({
                    title: 'İşlem Tamamlandı!',
                    text: `Toplam ${data.totalStudents} öğrenci için kayıt yenileme formları oluşturuldu ve mail gönderildi.`,
                    icon: 'success',
                    confirmButtonText: 'Tamam'
                });
            } else {
                // Sonraki batch'i işle
                setTimeout(() => {
                    processBatches();
                }, 1000); // 1 saniye bekle
            }
        } else {
            addLog('Batch hatası: ' + data.message, 'error');
            isProcessing = false;
        }
    })
    .catch(error => {
        addLog('Network hatası: ' + error.message, 'error');
        console.error('Error:', error);
        isProcessing = false;
    });
}

function updateProgress(percentage) {
    document.getElementById('progress-percentage').textContent = percentage + '%';
    document.getElementById('main-progress-bar').style.width = percentage + '%';
}

function addLog(message, type = 'info') {
    const logContainer = document.getElementById('log-container');
    const timestamp = new Date().toLocaleTimeString('tr-TR');
    const logEntry = document.createElement('div');
    logEntry.className = `log-entry log-${type}`;
    logEntry.innerHTML = `[${timestamp}] ${message}`;

    logContainer.appendChild(logEntry);
    logContainer.scrollTop = logContainer.scrollHeight;
}

function pauseProcess() {
    isPaused = true;
    document.getElementById('pause-btn').style.display = 'none';
    document.getElementById('resume-btn').style.display = 'inline-block';
    addLog('İşlem duraklatıldı', 'warning');
}

function resumeProcess() {
    isPaused = false;
    document.getElementById('resume-btn').style.display = 'none';
    document.getElementById('pause-btn').style.display = 'inline-block';
    addLog('İşlem devam ettiriliyor', 'info');
    processBatches();
}

function goToPeriodManagement() {
    window.location.href = '{{ route("period-management") }}';
}

// Sayfa kapatılmaya çalışıldığında uyarı
window.addEventListener('beforeunload', function(e) {
    if (isProcessing && !isPaused) {
        e.preventDefault();
        e.returnValue = 'İşlem devam ediyor. Sayfayı kapatmak istediğinizden emin misiniz?';
    }
});
</script>
@endsection
