@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Burs Taksiti Oluştur
@endsection
@section('local-css')
    <style>
        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        #taksitOzet {
            font-size: 0.9rem;
            color: #444;
        }
    </style>
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="container">
                    <h2 class="mb-3">Burs Taksiti Oluştur</h2>
                    <p class="text-muted small mb-4">Öğrenim türüne göre burs tipi, ardından o burs tipine tanımlı dönemleri seçin. Ödeme satırları seçilen dönem kaydındaki burs tutarı, taksit sayısı ve başlangıç tarihine göre üretilir.</p>
                    <form action="{{ route('burs-odeme.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="okul_tipi" class="form-label">Öğrenim türü</label>
                                    <select name="okul_tipi" id="okul_tipi" class="form-select">
                                        <option value="">Seçiniz</option>
                                        <option value="ilkokul">İlkokul</option>
                                        <option value="ortaokul">Ortaokul</option>
                                        <option value="lise">Lise</option>
                                        <option value="onlisans">Ön lisans</option>
                                        <option value="lisans">Lisans</option>
                                        <option value="yukseklisans">Yüksek lisans</option>
                                        <option value="doktora">Doktora</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="burs_tipi_id" class="form-label">Burs tipi</label>
                                    <select name="burs_tipi_id" id="burs_tipi_id" class="form-select" disabled>
                                        <option value="">Önce öğrenim türü seçiniz</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="donem" class="form-label">Dönem</label>
                                    <select name="donem" id="donem" class="form-select" disabled>
                                        <option value="">Önce burs tipi seçiniz</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12" id="taksitOzetWrap" style="display: none;">
                                <div class="alert alert-light border" id="taksitOzet" role="status"></div>
                            </div>

                            <div class="col-12 d-flex justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary">
                                    Oluştur
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        @include('panel.scholarship-recipient-list.modals')
        @include('includes.js.toastr')
    @endsection
    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

        <script src="../assets/js/components/dashboard.js"></script>
        <script>
            $(document).ready(function() {
                let taksitByDonem = {};

                function resetDonem() {
                    taksitByDonem = {};
                    $('#donem').prop('disabled', true)
                        .empty()
                        .append('<option value="">Önce burs tipi seçiniz</option>');
                    $('#taksitOzetWrap').hide();
                    $('#taksitOzet').empty();
                }

                function showOzet(donemKey) {
                    const row = taksitByDonem[donemKey];
                    if (!row) {
                        $('#taksitOzetWrap').hide();
                        return;
                    }
                    const tutar = Number(row.burs_tutari).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    $('#taksitOzet').html(
                        '<strong>Seçilen dönem özeti:</strong> Burs tutarı <strong>' + tutar + ' ₺</strong>, ' +
                        '<strong>' + row.taksit_sayisi + '</strong> taksit, başlangıç <strong>' + row.baslangic_tarihi + '</strong>.'
                    );
                    $('#taksitOzetWrap').show();
                }

                $('#okul_tipi').change(function() {
                    const schoolType = $(this).val();

                    $('#burs_tipi_id').prop('disabled', true)
                        .empty()
                        .append('<option value="">Yükleniyor...</option>');

                    resetDonem();

                    if (!schoolType) {
                        $('#burs_tipi_id').prop('disabled', true)
                            .empty()
                            .append('<option value="">Önce öğrenim türü seçiniz</option>');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('get.burs.tipleri.by.school.type') }}",
                        type: 'POST',
                        data: {
                            okul_tipi: schoolType,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#burs_tipi_id').empty().append('<option value="">Seçiniz</option>');
                            response.forEach(function(item) {
                                $('#burs_tipi_id').append(
                                    `<option value="${item.id}">${item.burs_tipi}</option>`
                                );
                            });
                            $('#burs_tipi_id').prop('disabled', false);
                        },
                        error: function() {
                            alert('Burs tipi listesi alınırken bir hata oluştu!');
                            $('#burs_tipi_id').prop('disabled', true)
                                .empty()
                                .append('<option value="">Seçiniz</option>');
                        }
                    });
                });

                $('#burs_tipi_id').change(function() {
                    const bursTipiId = $(this).val();
                    $('#donem').prop('disabled', true)
                        .empty()
                        .append('<option value="">Yükleniyor...</option>');
                    $('#taksitOzetWrap').hide();

                    if (!bursTipiId) {
                        resetDonem();
                        return;
                    }

                    $.ajax({
                        url: "{{ route('get.burs.taksitleri.by.burs.tipi') }}",
                        type: 'POST',
                        data: {
                            burs_tipi_id: bursTipiId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            taksitByDonem = {};
                            $('#donem').empty().append('<option value="">Seçiniz</option>');
                            response.forEach(function(row) {
                                taksitByDonem[row.donem] = row;
                                const label = row.donem_label || row.donem;
                                $('#donem').append(
                                    `<option value="${row.donem}">${label}</option>`
                                );
                            });
                            if (response.length === 0) {
                                $('#donem').empty().append('<option value="">Bu burs tipi için dönem tanımı yok</option>');
                                $('#donem').prop('disabled', true);
                            } else {
                                $('#donem').prop('disabled', false);
                            }
                        },
                        error: function() {
                            alert('Dönem listesi alınırken bir hata oluştu!');
                            resetDonem();
                        }
                    });
                });

                $('#donem').change(function() {
                    const v = $(this).val();
                    if (v) {
                        showOzet(v);
                    } else {
                        $('#taksitOzetWrap').hide();
                    }
                });

                $('form').on('submit', function(e) {
                    e.preventDefault();

                    const kontrolAlanlar = {
                        'okul_tipi': 'Öğrenim türü',
                        'burs_tipi_id': 'Burs tipi',
                        'donem': 'Dönem',
                    };

                    let hataMesaji = '';
                    let formGecerli = true;

                    Object.entries(kontrolAlanlar).forEach(([id, label]) => {
                        const alan = $(`#${id}`);
                        const deger = alan.val();

                        if (!deger || String(deger).trim() === '') {
                            formGecerli = false;
                            hataMesaji += `${label}, `;
                            alan.addClass('is-invalid');
                        } else {
                            alan.removeClass('is-invalid');
                        }
                    });

                    if (!formGecerli) {
                        hataMesaji = hataMesaji.slice(0, -2);
                        toastr.error(`Lütfen şu alanları doldurunuz: ${hataMesaji}`);
                        return false;
                    }

                    this.submit();
                });
            });
        </script>
        @include('includes.js.sidebar')
    @endsection
