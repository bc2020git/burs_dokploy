@extends('layouts.master')
@section('title')
Burs Taksiti Düzenleme
@endsection
@section('page-title')
    Burs Taksiti Düzenleme
@endsection
@section('local-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
            <div class="d-flex">

            </div>
            <div class="btn-toolbar  mb-md-0">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-primary me-3" id="kaydetVeKapatBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z"
                                fill="#4069E5" />
                        </svg>
                        Kaydet ve Kapat
                    </button>
                    <button type="button" class="btn btn-outline-primary me-3"  id="kaydetBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z"
                                fill="#4069E5" />
                        </svg>
                        Kaydet
                    </button>
                </div>

                <a href="{{ route('burs-taksitleri.delete', ['id' => $bursTaksiti->id]) }}">
                    <button type="button" class="btn btn-outline-primary me-3" id="waste" data-bs-toggle="tooltip"
                            data-bs-placement="left" title="Sil">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                fill="#4069E5" />
                        </svg>
                    </button>
                </a>

                <button type="button" class="btn btn-outline-primary me-3" id="reload" data-bs-toggle="tooltip"
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

        <main class="main-content px-3 py-4">
            <div class="container mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form id="bankDetailForm" class="p-4">
                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <input type="hidden" name="id" id="id" value="{{ $bursTaksiti->id }}">
                                    <label for="burs_tipi_id" class="custom-label">Burs Tipi</label>
                                    <select name="burs_tipi_id" id="burs_tipi_id" class="form-select">
                                        @foreach ($bursTipleri as $tip)
                                            <option value="{{ $tip->id }}" @selected($bursTaksiti->burs_tipi_id == $tip->id)>{{ $tip->burs_tipi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="donem" class="custom-label">Dönem</label>
                                    <select name="donem" id="donem" class="form-select">
                                        <option value="">Seçiniz</option>
                                        @foreach ($donemOptions as $key => $label)
                                            <option value="{{ $key }}" @selected($bursTaksiti->donem === $key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="burs_tutari" class="custom-label">Burs Tutarı</label>
                                    <input type="number" name="burs_tutari" id="burs_tutari" class="form-control" min="0" step="0.01" value="{{ old('burs_tutari', $bursTaksiti->burs_tutari) }}">
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="taksit_sayisi" class="custom-label">Taksit Sayısı</label>
                                    <input type="number" name="taksit_sayisi" id="taksit_sayisi" class="form-control" min="1" value="{{ old('taksit_sayisi', $bursTaksiti->taksit_sayisi) }}">
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="baslangic_tarihi" class="custom-label">Başlangıç Tarihi</label>
                                    <input type="text" name="baslangic_tarihi" id="baslangic_tarihi" class="form-control" autocomplete="off" value="{{ old('baslangic_tarihi', optional($bursTaksiti->baslangic_tarihi)->format('d.m.Y')) }}">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>
        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/scholarmodal.js"></script>

<script>
    function parseTurkishDate(dateString) {
        if (!dateString) return null;
        if (dateString instanceof Date) return dateString;
        dateString = String(dateString).trim();

        const isoMatch = dateString.match(/^(\d{4})[-/.]([0-9]{1,2})[-/.]([0-9]{1,2})/);
        if (isoMatch) {
            const year = parseInt(isoMatch[1], 10);
            const month = parseInt(isoMatch[2], 10) - 1;
            const day = parseInt(isoMatch[3], 10);
            return new Date(year, month, day);
        }

        const dmyMatch = dateString.match(/^([0-9]{1,2})[-/.]([0-9]{1,2})[-/.](\d{4})/);
        if (dmyMatch) {
            const day = parseInt(dmyMatch[1], 10);
            const month = parseInt(dmyMatch[2], 10) - 1;
            const year = parseInt(dmyMatch[3], 10);
            return new Date(year, month, day);
        }

        const d = new Date(dateString);
        return isNaN(d.getTime()) ? null : d;
    }

    function normalizeToDMY(value) {
        if (!value) return value;
        const d = parseTurkishDate(value);
        if (d && !isNaN(d.getTime())) {
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}.${month}.${year}`;
        }
        return value;
    }

    $(document).ready(function() {
        function submitForm(redirectUrl = null) {
            let formData = {};
            formData['id'] = document.getElementById('id').value;
            formData['burs_tipi_id'] = document.getElementById('burs_tipi_id').value;
            formData['donem'] = document.getElementById('donem').value;
            formData['burs_tutari'] = document.getElementById('burs_tutari').value;
            formData['taksit_sayisi'] = document.getElementById('taksit_sayisi').value;
            formData['baslangic_tarihi'] = normalizeToDMY(document.getElementById('baslangic_tarihi').value);

            $.ajax({
                url: '{{ route('burs-taksitleri.update') }}',
                type: 'POST',
                data: {
                    formData: formData,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            title: 'İşlem Başarılı',
                            message: 'Burs taksiti güncellendi',
                        });
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    }
                },
                error: function(xhr) {
                    iziToast.error({
                        title: 'İşlem Başarısız',
                        message: (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Kayıt güncellenemedi.',
                    });
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    }
                }
            });
        }

        $('#kaydetBtn').click(function() {
            submitForm();
        });
        $('#kaydetVeKapatBtn').click(function() {
            submitForm('/panel/Burs-Taksitleri');
        });
    });

    $('#reload').on('click', function() {
        location.reload();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const field = document.getElementById('baslangic_tarihi');
        if (!field) return;

        const rawValue = field.value;
        const initialDate = parseTurkishDate(rawValue);

        const picker = new Pikaday({
            field,
            format: 'DD.MM.YYYY',
            firstDay: 1,
            defaultDate: initialDate || undefined,
            setDefaultDate: !!initialDate,
            toString(date, format) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}.${month}.${year}`;
            },
            parse(dateString, format) {
                return parseTurkishDate(dateString);
            },
            i18n: {
                previousMonth: 'Önceki Ay',
                nextMonth: 'Sonraki Ay',
                months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                weekdaysShort: ['Paz', 'Pts', 'Sal', 'Çar', 'Per', 'Cum', 'Cts']
            }
        });
        picker.parse = function(dateString, format) {
            return parseTurkishDate(dateString);
        };
        if (initialDate) {
            const day = String(initialDate.getDate()).padStart(2, '0');
            const month = String(initialDate.getMonth() + 1).padStart(2, '0');
            const year = initialDate.getFullYear();
            field.value = `${day}.${month}.${year}`;
        }
    });
</script>
            @include('includes.js.sidebar')

@endsection
