@php
$user = Auth::user();
$permissions = $user->role->permissions->pluck('name')->toArray();
function checkPermission($permissionName, $permissions) {
    return in_array($permissionName, $permissions);
}
@endphp
@extends('layouts.master')
@section('title')
    Burs Ödeme Düzenle
@endsection
@section('page-title')
    Burs Ödeme Düzenle
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <div class="d-flex">
        </div>
        <div class="btn-toolbar  mb-md-0">
            <div class="d-flex align-items-center">
                <a href="{{ route('bursodemebilgileri') }}" type="button" class="btn btn-outline-danger me-3 cancel-button">Vazgeç</a>
                <button type="button" class="btn btn-outline-primary me-3" id="kaydetVeKapatBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z" fill="#4069E5"/>
                    </svg>
                    Kaydet ve Kapat
                </button>
                <button type="button" class="btn btn-outline-primary me-3"  id="kaydetBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z" fill="#4069E5"/>
                    </svg>
                    Kaydet
                </button>
            </div>
        </div>
    </div>

    <main class="main-content px-3 py-4">
        <div class="container mt-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Burs Ödeme Bilgileri</h5>
                    <form id="bursOdemeForm" class="p-4">
                        @csrf
                        <input type="hidden" name="id" value="{{ $bursOdeme->id }}">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="tc_kimlik_no" class="custom-label">T.C Kimlik No.</label>
                                <input id="tc_kimlik_no" name="tc_kimlik_no" type="text" class="form-control" value="{{ $bursOdeme->tc_kimlik_no }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="burs_tipi" class="custom-label">Burs Tipi</label>
                                <select disabled id="burs_tipi" name="burs_tipi" class="form-select">
                                    @foreach ($bursTipleri as $bursTipi)
                                        <option value="{{ $bursTipi->burs_tipi }}" {{ $bursOdeme->burs_tipi == $bursTipi->burs_tipi ? 'selected' : '' }}>{{ $bursTipi->burs_tipi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="okul_tipi" class="custom-label">Okul Tipi</label>
                                <input id="okul_tipi" name="okul_tipi" type="text" class="form-control" value="{{ $bursOdeme->okul_tipi }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="ad" class="custom-label">Ad</label>
                                <input id="ad" name="ad" type="text" class="form-control" value="{{ $bursOdeme->ad }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="soyad" class="custom-label">Soyad</label>
                                <input id="soyad" name="soyad" type="text" class="form-control" value="{{ $bursOdeme->soyad }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="donem" class="custom-label">Dönem</label>
                                <input id="donem" name="donem" type="text" class="form-control" value="{{ $bursOdeme->donem }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="iban" class="custom-label">IBAN</label>
                                <input id="iban" name="iban" type="text" class="form-control" value="{{ $bursOdeme->iban }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="bursveren" class="custom-label">Bursveren</label>
                                <input id="bursveren" name="bursveren" type="text" class="form-control" value="{{ $bursOdeme->bursveren }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="burs_ayi" class="custom-label">Burs Ayı</label>
                                <input id="burs_ayi" name="burs_ayi" type="text" class="form-control" value="{{ $bursOdeme->burs_ayi }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="odeme_periyodu" class="custom-label">Ödeme Periyodu</label>
                                <input id="odeme_periyodu" name="odeme_periyodu" type="text" class="form-control" value="{{ $bursOdeme->odeme_periyodu }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="odeme_tutari" class="custom-label">Ödeme Tutarı</label>
                                <input id="odeme_tutari" name="odeme_tutari" type="number" step="0.01" class="form-control" value="{{ $bursOdeme->odeme_tutari }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="odeme_tarihi" class="custom-label">Ödeme Tarihi</label>
                                <input id="odeme_tarihi" name="odeme_tarihi" type="date" class="form-control" value="{{ $bursOdeme->odeme_tarihi }}" readonly>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="ogrenciye_burs_odeme_tarihi" class="custom-label">Öğrenciye Burs Ödeme Tarihi</label>
                                <input id="ogrenciye_burs_odeme_tarihi" @if(!checkPermission('burs-tipi-degistirebilir', $permissions)) disabled @endif name="ogrenciye_burs_odeme_tarihi" type="date" class="form-control date-input"  value="{{ $bursOdeme->ogrenciye_burs_odeme_tarihi }}" @if($bursOdeme->odeme_durumu == 'Odendi') disabled @endif>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="odeme_durumu" class="custom-label">Ödeme Durumu</label>
                                <select @if(!checkPermission('burs-tipi-degistirebilir', $permissions)) disabled @endif id="odeme_durumu" name="odeme_durumu" class="form-select" @if($bursOdeme->odeme_durumu == 'Odendi') disabled @endif>
                                    <option value="Odendi" {{ $bursOdeme->odeme_durumu == 'Odendi' ? 'selected' : '' }}>Ödendi</option>
                                    <option value="Beklemede" {{ $bursOdeme->odeme_durumu == 'Beklemede' ? 'selected' : '' }}>Beklemede</option>
                                    <option value="İptal Edildi" {{ $bursOdeme->odeme_durumu == 'İptal Edildi' ? 'selected' : '' }}>İptal Edildi</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @include('includes.js.toastr')
@endsection

@section('scripts')
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
<script>
        $(document).ready(function() {
            function submitForm(redirectUrl = null) {
                let formData = $('#bursOdemeForm').serialize();

                $.ajax({
                    url: '{{ route('burs-odeme-guncelle', $bursOdeme->id) }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            iziToast.success({
                                title: 'İşlem Başarılı',
                                message: 'Burs Ödeme Bilgileri Güncellendi',
                            });
                            if (redirectUrl) {
                                window.location.href = redirectUrl;
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        iziToast.error({
                            title: 'İşlem Başarısız',
                            message: 'Bir hata oluştu. Lütfen tekrar deneyin.',
                        });
                        console.error("AJAX Hatası:", status, error);
                        console.error("Hata Detayları:", xhr.responseText);
                    }
                });
            }

            $('#kaydetBtn').click(function() {
                submitForm();
            });

            $('#kaydetVeKapatBtn').click(function() {
                submitForm('{{ route('bursodemebilgileri') }}');
            });
        });
    </script>
@endsection
