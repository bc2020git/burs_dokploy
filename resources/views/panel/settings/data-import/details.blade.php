@extends('layouts.master')
@section('title')
    İçe Aktarım Detayları
@endsection
@section('local-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <style>
        .log-table th, .log-table td {
            vertical-align: middle;
        }
        .json-data {
            max-width: 300px;
            overflow: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .error-badge {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
        }
        .success-badge {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
        }
        .view-data {
            cursor: pointer;
            color: #0d6efd;
        }
        .modal-body dl {
            margin-bottom: 0;
        }
        .modal-body dt {
            font-weight: bold;
            margin-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.5rem;
        }
        .modal-body dd {
            margin-bottom: 1rem;
            padding-left: 1rem;
        }
        .info-card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1) !important;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
            background: white;
            margin-bottom: 20px;
        }
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
        }
        .info-card .card-body {
            padding: 1.5rem;
            position: relative;
            z-index: 1;
        }
        .info-card .card-title {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .info-card .card-value {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
            color: #2c3e50;
        }
        .info-card.success {
            border-left: 4px solid #28a745;
        }
        .info-card.error {
            border-left: 4px solid #dc3545;
        }
        .info-card.info {
            border-left: 4px solid #17a2b8;
        }
        .info-card.warning {
            border-left: 4px solid #ffc107;
        }
        .info-card i {
            font-size: 3rem;
            opacity: 0.5;
            position: absolute;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            color: #000;
        }
        .stats-row {
            margin: -10px;
        }
        .stats-row > div {
            padding: 10px;
        }
        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row stats-row mt-3">
            <div class="col-md-3">
                <div class="card info-card info">
                    <div class="card-body">
                        <h6 class="card-title">Dosya Adı</h6>
                        <p class="card-value text-truncate" title="{{ $data_import->original_name }}">{{ $data_import->original_name }}</p>
                        <i class="fas fa-file-excel fa-5x me-2 text-center" style="color: #28a745;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card info-card warning">
                    <div class="card-body">
                        <h6 class="card-title">Durum</h6>
                        <p class="card-value">{{ $data_import->status }}</p>
                        <i class="fas fa-info-circle fa-5x me-2 text-center" style="color: #ffc107;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card info-card info">
                    <div class="card-body">
                        <h6 class="card-title">Toplam Kayıt</h6>
                        <p class="card-value">{{ $data_import->total_record }}</p>
                        <i class="fas fa-list fa-5x me-2 text-center" style="color: #17a2b8;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card info-card success">
                    <div class="card-body">
                        <h6 class="card-title">Başarılı</h6>
                        <p class="card-value">{{ $data_import->success_record }}</p>
                        <i class="fas fa-check fa-5x me-2 text-center" style="color: #28a745;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card info-card error">
                    <div class="card-body">
                        <h6 class="card-title">Başarısız</h6>
                        <p class="card-value">{{ $data_import->error_record }}</p>
                        <i class="fas fa-times fa-5x me-2 text-center" style="color: #dc3545;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">İşlem Detayları</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="logsTable" class="table table-bordered table-hover log-table">
                                <thead>
                                    <tr>
                                        <th>Satır No</th>
                                        <th>Durum</th>
                                        <th>Açıklama</th>
                                        <th>Tarih</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_import->logs as $log)
                                        <tr>
                                            <td>{{ $log->row_number }}</td>
                                            <td>
                                                <span class="badge {{ $log->status == 'Hata' ? 'error-badge' : 'success-badge' }}">
                                                    {{ $log->status }}
                                                </span>
                                            </td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->created_at->format('d.m.Y H:i:s') }}</td>
                                            <td class="text-center">
                                                @if($log->data)
                                                    <i class="fas fa-eye view-data" data-bs-toggle="modal" data-bs-target="#dataModal" data-log-data="{{ json_encode($log->data) }}"></i>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Veri Detay Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Veri Detayları</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="dataList" class="mb-0">
                        <!-- Veriler buraya JavaScript ile eklenecek -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DataTables başlatma
        $('#logsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json"
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]],
            "order": [[0, "asc"]],
            "columnDefs": [
                {
                    "targets": [4], // İşlemler sütunu
                    "orderable": false,
                    "searchable": false
                }
            ],
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                   '<"row"<"col-sm-12"tr>>' +
                   '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "responsive": true,
            "autoWidth": false
        });

        const dataModal = document.getElementById('dataModal');
        const dataList = document.getElementById('dataList');

        document.querySelectorAll('.view-data').forEach(button => {
            button.addEventListener('click', function() {
                const rawData = this.getAttribute('data-log-data');
                console.log(rawData);
                try {
                    // İlk JSON.parse ile kaçış karakterlerini kaldır
                    const parsedData = JSON.parse(rawData);
                    // İkinci JSON.parse ile gerçek objeye çevir
                    const data = JSON.parse(parsedData);

                    // DataList'i temizle
                    dataList.innerHTML = '';

                    // Obje içindeki her bir alanı yazdır
                    for (const [key, value] of Object.entries(data)) {
                        dataList.innerHTML += `
                            <div class="row">
                                <div class="col-sm-4">${key}</div>
                                <div class="col-sm-8">${value !== null ? value : ''}</div>
                            </div>
                        `;
                    }
                } catch (e) {
                    console.error('JSON parse hatası:', e);
                    dataList.innerHTML = '<p class="text-danger">Veri görüntülenirken bir hata oluştu.</p>';
                }
            });
        });
    });
</script>
@endsection
