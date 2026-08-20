@extends('layouts.master')
@section('local-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <style>
        .form-label {
            color: var(--Black-700, #333);
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 150%; /* 21px */
        }
        .table thead th, .table tbody td {
            border: 1px solid #dee2e6;
        }
    </style>
@endsection
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Dönem Yönetimi
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <script>
            function validateForm(formId, formType) {
                const form = document.getElementById(formId);
                const termCheckboxes = form.querySelectorAll('input[name="term[]"]');
                const educTypeCheckboxes = form.querySelectorAll('input[name="educType[]"]');

                let termSelected = false;
                let educTypeSelected = false;

                termCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) termSelected = true;
                });

                educTypeCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) educTypeSelected = true;
                });

                if (!termSelected || !educTypeSelected) {
                    const formTitle = formType === 'burs' ? 'Burs Başvuru' : 'Kayıt Yenileme';
                    let message = '';

                    if (!termSelected && !educTypeSelected) {
                        message = 'Lütfen en az bir dönem ve bir öğrenim türü seçiniz.';
                    } else if (!termSelected) {
                        message = 'Lütfen en az bir dönem seçiniz (Güz veya Bahar).';
                    } else {
                        message = 'Lütfen en az bir öğrenim türü seçiniz.';
                    }

                    Swal.fire({
                        title: formTitle + ' Hatası',
                        text: message,
                        icon: 'warning',
                        confirmButtonText: 'Tamam'
                    });

                    return false;
                }

                return true;
            }

            function validateBursBasvuruForm(event) {
                event.preventDefault();
                if (validateForm('bursBasvuruForm', 'burs')) {
                    event.target.submit();
                }
            }

            function validateKayitYenilemeForm(event) {
                event.preventDefault();
                if (validateForm('kayitYenilemeForm', 'kayit')) {
                    event.target.submit();
                }
            }
        </script>
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="row">
                    <div id="scholarshipPeriod" class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Burs Başvuru Dönemi
                            </div>
                            <div class="card-body">
                                <form action="{{route('add-new-period')}}" method="post" id="bursBasvuruForm" onsubmit="return validateBursBasvuruForm(event)">@csrf
                                    <input type="hidden" name="type" value="0">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursDonemi" class="form-label">Dönem Seçiniz</label>
                                            <select name="bursDonemi" id="bursDonemi" class="form-select">
                                                <option selected>Yıl seçiniz..</option>
                                                @foreach($yillar as $yil)
                                                    <option value='{{$yil}}'>{{$yil}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="form-check form-check-inline mt-4">
                                                <input class="form-check-input" type="checkbox" id="guzDonemi" name="term[]" value="Güz Dönemi">
                                                <label class="form-check-label" for="guzDonemi">Güz Dönemi</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-4">
                                                <input class="form-check-input" type="checkbox" id="baharDonemi" name="term[]" value="Bahar Dönemi">
                                                <label class="form-check-label" for="baharDonemi">Bahar Dönemi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3 position-relative">
                                            <label for="bursBasvuruBaslama" class="form-label">Burs Başvuruları Başlama Tarihi</label>
                                            <input name="start_time" type="date" class="form-control" id="bursBasvuruBaslama" required placeholder="Tarih seçiniz..">
                                            <div class="date-icon" onclick="document.getElementById('bursBasvuruBaslama').showPicker()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z" fill="#8C8C8C"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 position-relative">
                                            <label for="bursBasvuruBitis" class="form-label">Burs Başvuruları Bitiş Tarihi</label>
                                            <input name="end_time" type="date" class="form-control" id="bursBasvuruBitis" required placeholder="Tarih seçiniz..">
                                            <div class="date-icon" onclick="document.getElementById('bursBasvuruBitis').showPicker()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z" fill="#8C8C8C"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Öğrenim türünü/türlerini seçiniz</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="ilkokul"  name="educType[]" id="ilkokul">
                                                    <label class="form-check-label" for="ilkokul">İlkokul</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="ortaokul"  name="educType[]" id="ortaokul">
                                                    <label class="form-check-label" for="ortaokul">Ortaokul</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="lise"  name="educType[]" id="lise">
                                                    <label class="form-check-label" for="lise">Lise</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="onlisans" name="educType[]"  id="onlisans">
                                                    <label class="form-check-label" for="onlisans">Ön Lisans</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="lisans" name="educType[]"  id="lisans">
                                                    <label class="form-check-label" for="lisans">Lisans</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="yukseklisans" name="educType[]"  id="yukseklisans">
                                                    <label class="form-check-label" for="yukseklisans">Yüksek Lisans</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="doktora" name="educType[]"  id="doktora">
                                                    <label class="form-check-label" for="doktora">Doktora</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="form-label">Belge Yönetimi</label>
                                        <div class="accordion" id="documentsAccordion">
                                            @foreach ($periods as $period)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading{{ Str::slug($period[1]) }}">
                                                        <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ Str::slug($period[0]) }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapse{{ Str::slug($period[0]) }}">
                                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                                <span class="fw-bold">{{ $period[1] }}</span>
                                                                <div class="form-check ms-3">
                                                                    <input type="checkbox"
                                                                        class="category-checkbox form-check-input me-2"
                                                                        id="category_{{ Str::slug($period[0]) }}"
                                                                        data-category="{{ $period[0] }}"
                                                                        onclick="event.stopPropagation();">
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ Str::slug($period[0]) }}"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="heading{{ Str::slug($period[0]) }}"
                                                        data-bs-parent="#documentsAccordion">
                                                        <div class="accordion-body">
                                                            @foreach ($documents as $document)
                                                                <div class="form-check mb-2">
                                                                    <input type="checkbox"
                                                                        name="newdocuments_{{$period[0] }}[]"
                                                                        value="{{ $document->db_key }}"
                                                                        id="document_{{ $document->db_key }}"
                                                                        class="form-check-input permission-checkbox" >
                                                                    <label for="document_{{ $document->db_key }}"
                                                                        class="form-check-label">
                                                                        {{ $document->name }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    <div class="d-flex justify-content-center mt-3 align-items-center">
                                        <button  type="submit" class="btn me-3" id="save">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z" fill="#4069E5" />
                                            </svg>
                                            Kaydet
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h5>İşlem Geçmişi</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Dönem</th>
                                        <th scope="col">Başlangıç</th>
                                        <th scope="col">Bitiş</th>
                                        <th scope="col">Durum</th>
                                        <th scope="col">Durdur / Devam Et</th>
                                        <th scope="col">Seçenekler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($newperiods as $period)
                                        <tr>
                                            <td>{{$period->title}}</td>
                                            <td>{{$period->start_time}}</td>
                                            <td>{{$period->end_time}}</td>
                                             @php
                                                $canStartNew = false;
                                                if (!empty($period->start_time) && !empty($period->end_time)) {
                                                    $now = \Carbon\Carbon::now();
                                                    $start = \Carbon\Carbon::parse($period->start_time)->startOfDay();
                                                    $end = \Carbon\Carbon::parse($period->end_time)->endOfDay();
                                                    if ($now->between($start, $end)) {
                                                        $canStartNew = true;
                                                    }
                                                }
                                            @endphp
                                            @switch($period->status)
                                                @case(0)
                                                    <td><span class="status-box-warning">Duraklatıldı</span></td>
                                                    <td>
                                                        @if($period->is_ended == 1)
                                                            <button class="btn custom-btn bg-secondary" disabled>Devam Ettir</button>
                                                        @elseif($canStartNew)
                                                            <a href="{{ route('change-period-status', ['id' => $period->id, 'durum' => $period->status]) }}">
                                                                <button class="btn custom-btn bg-success">
                                                                Devam Ettir
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="11" viewBox="0 0 10 11" fill="none">
                                                                    <path d="M0 0.5V10.5L10 5.5L0 0.5Z" fill="white"></path>
                                                                </svg>
                                                            </button>
                                                            </a>
                                                        @else
                                                            <button class="btn custom-btn bg-secondary" disabled title="Bugünün tarihi dönemin başlama ve bitiş tarihleri arasında değildir">Başlatılamaz</button>
                                                        @endif
                                                    </td>
                                                    @break
                                                @case(1)
                                                    <td><span class="status-box-success">Devam Ediyor</span></td>
                                                    <td>
                                                        @if($period->is_ended == 1 || !$canStartNew)
                                                            <button class="btn custom-btn bg-secondary" disabled title="Bugünün tarihi dönemin başlama ve bitiş tarihleri arasında değildir">Başlatılamaz</button>
                                                        @else
                                                            <a href="{{ route('change-period-status', ['id' => $period->id, 'durum' => $period->status]) }}">
                                                                <button class="btn custom-btn bg-danger">
                                                                    Duraklat
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
                                                                        <path d="M6 0.5C2.68 0.5 0 3.18 0 6.5C0 9.82 2.68 12.5 6 12.5C9.32 12.5 12 9.82 12 6.5C12 3.18 9.32 0.5 6 0.5Z" fill="white"></path>
                                                                    </svg>
                                                                </button>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    @break
                                                @case(2)
                                                    <td><span class="completed-write">Tamamlandı</span></td>
                                                    <td><span class="not-allow-write">İzin verilmiyor</span></td>
                                                    @break
                                            @endswitch
                                            <td>
                                                        <button class="btn edit-period" data-bs-toggle="modal" data-id="{{ $period->id }}" data-bs-target="#kayıtYenilemeDuzenleBaslaModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M5.34517 13.2418L13.7969 4.78997L12.6184 3.61145L4.16667 12.0633V13.2418H5.34517ZM6.03553 14.9084H2.5V11.3728L12.0292 1.84368C12.3547 1.51825 12.8822 1.51825 13.2077 1.84368L15.5647 4.20071C15.8902 4.52614 15.8902 5.05378 15.5647 5.37922L6.03553 14.9084ZM2.5 16.5751H17.5V18.2418H2.5V16.5751Z" fill="#4069E5"></path>
                                                    </svg>
                                                </button>
                                                <button class="btn delete-period" data-id="{{ $period->id }}"   data-id="{{ $period->id }}" data-bs-toggle="modal" data-bs-target="#warningModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M14.1641 5.00008H18.3307V6.66675H16.6641V17.5001C16.6641 17.9603 16.291 18.3334 15.8307 18.3334H4.16406C3.70383 18.3334 3.33073 17.9603 3.33073 17.5001V6.66675H1.66406V5.00008H5.83073V2.50008C5.83073 2.03985 6.20383 1.66675 6.66406 1.66675H13.3307C13.791 1.66675 14.1641 2.03985 14.1641 2.50008V5.00008ZM7.4974 9.16675V14.1667H9.16406V9.16675H7.4974ZM10.8307 9.16675V14.1667H12.4974V9.16675H10.8307ZM7.4974 3.33341V5.00008H12.4974V3.33341H7.4974Z" fill="#F03000"></path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="registrationRenewal" class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light-yellow">
                                Kayıt Yenileme Dönemi
                            </div>
                            <div class="card-body">
                                <form action="{{route('add-new-period')}}" method="post" id="kayitYenilemeForm" onsubmit="return validateKayitYenilemeForm(event)">@csrf
                                    <input type="hidden" name="type" value="1">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursDonemi2" class="form-label">Dönem Seçiniz</label>
                                            <select name="bursDonemi" id="bursDonemi2" class="form-select">
                                                <option selected>Yıl seçiniz..</option>
                                                @foreach($yillar as $yil)
                                                    <option value='{{$yil}}'>{{$yil}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="form-check form-check-inline mt-4">
                                                <input class="form-check-input" type="checkbox" id="guzDonemi2" name="term[]" value="Güz Dönemi">
                                                <label class="form-check-label" for="guzDonemi2">Güz Dönemi</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-4">
                                                <input class="form-check-input" type="checkbox" id="baharDonemi2" name="term[]" value="Bahar Dönemi">
                                                <label class="form-check-label" for="baharDonemi2">Bahar Dönemi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3 position-relative">
                                            <label for="bursBasvuruBaslama2" class="form-label">Burs Başvuruları Başlama Tarihi</label>
                                            <input name="start_time" type="date" class="form-control" id="bursBasvuruBaslama2" required placeholder="Tarih seçiniz..">
                                            <div class="date-icon" onclick="document.getElementById('bursBasvuruBaslama2').showPicker()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z" fill="#8C8C8C"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 position-relative">
                                            <label for="bursBasvuruBitis2" class="form-label">Burs Başvuruları Bitiş Tarihi</label>
                                            <input name="end_time" type="date" class="form-control" id="bursBasvuruBitis2" required placeholder="Tarih seçiniz..">
                                            <div class="date-icon" onclick="document.getElementById('bursBasvuruBitis2').showPicker()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z" fill="#8C8C8C"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Öğrenim türünü/türlerini seçiniz</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="ilkokul"  name="educType[]" id="ilkokul2">
                                                    <label class="form-check-label" for="ilkokul2">İlkokul</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="ortaokul"  name="educType[]" id="ortaokul2">
                                                    <label class="form-check-label" for="ortaokul2">Ortaokul</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="lise"  name="educType[]" id="lise2">
                                                    <label class="form-check-label" for="lise2">Lise</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="onlisans" name="educType[]"  id="onlisans2">
                                                    <label class="form-check-label" for="onlisans2">Ön Lisans</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="lisans" name="educType[]"  id="lisans2">
                                                    <label class="form-check-label" for="lisans2">Lisans</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="yukseklisans" name="educType[]"  id="yukseklisans2">
                                                    <label class="form-check-label" for="yukseklisans2">Yüksek Lisans</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="doktora" name="educType[]"  id="doktora2">
                                                    <label class="form-check-label" for="doktora2">Doktora</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="form-label">Belge Yönetimi</label>
                                    <div class="accordion" id="renewdocumentsAccordion">
                                        @foreach ($periods as $period)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="renewheading{{ Str::slug($period[1]) }}">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#renewcollapse{{ Str::slug($period[0]) }}"
                                                            aria-expanded="false"
                                                            aria-controls="renewcollapse{{ Str::slug($period[0]) }}">
                                                        <div class="d-flex align-items-center justify-content-between w-100">
                                                            <span class="fw-bold">{{ $period[1] }}</span>
                                                            <div class="form-check ms-3">
                                                                <input type="checkbox"
                                                                    class="category-checkbox form-check-input me-2"
                                                                    id="category_{{ Str::slug($period[0]) }}"
                                                                    data-category="{{ $period[0] }}"
                                                                    onclick="event.stopPropagation();">
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="renewcollapse{{ Str::slug($period[0]) }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="renewheading{{ Str::slug($period[0]) }}"
                                                    data-bs-parent="#renewdocumentsAccordion">
                                                    <div class="accordion-body">
                                                        @foreach ($documents as $document)
                                                            <div class="form-check mb-2">
                                                                <input type="checkbox"
                                                                name="renewdocuments_{{ $period[0] }}[]"
                                                                value="{{ $document->db_key }}"
                                                                    id="document_{{ $document->db_key }}"
                                                                    class="form-check-input permission-checkbox"
                                                                    >
                                                                <label for="document_{{ $document->db_key }}"
                                                                    class="form-check-label">
                                                                    {{ $document->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="d-flex justify-content-center mt-3 align-items-center">
                                        <button  type="submit" class="btn me-3" id="save">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z" fill="#4069E5" />
                                            </svg>
                                            Kaydet
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h5>İşlem Geçmişi</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Dönem</th>
                                        <th scope="col">Başlangıç</th>
                                        <th scope="col">Bitiş</th>
                                        <th scope="col">Durum</th>
                                        <th scope="col">Durdur / Devam Et</th>
                                        <th scope="col">Kayıt Yenileme</th>
                                        <th scope="col">Seçenekler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($renewperiods as $period)
                                        <tr>
                                            <td>{{$period->title}}</td>
                                            <td>{{$period->start_time}}</td>
                                            <td>{{$period->end_time}}</td>
                                            @php
                                                $canStartRenew = false;
                                                if (!empty($period->start_time) && !empty($period->end_time)) {
                                                    $now = \Carbon\Carbon::now();
                                                    $start = \Carbon\Carbon::parse($period->start_time)->startOfDay();
                                                    $end = \Carbon\Carbon::parse($period->end_time)->endOfDay();
                                                    if ($now->between($start, $end)) {
                                                        $canStartRenew = true;
                                                    }
                                                }
                                            @endphp
                                            @switch($period->status)
                                                @case(0)
                                                    <td><span class="status-box-warning">Duraklatıldı</span></td>
                                                    <td>
                                                        @if($period->is_ended == 1)
                                                            <button class="btn custom-btn bg-secondary" disabled>Devam Ettir</button>
                                                        @elseif($canStartRenew)
                                                            <a href="{{ route('change-period-status', ['id' => $period->id, 'durum' => $period->status]) }}">
                                                                <button class="btn custom-btn bg-success">
                                                                    Devam Ettir
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="11" viewBox="0 0 10 11" fill="none">
                                                                        <path d="M0 0.5V10.5L10 5.5L0 0.5Z" fill="white"></path>
                                                                    </svg>
                                                                </button>
                                                            </a>
                                                        @else
                                                            <button class="btn custom-btn bg-secondary" disabled title="Bugünün tarihi dönemin başlama ve bitiş tarihleri arasında değildir">Başlatılamaz</button>
                                                        @endif
                                                    </td>
                                                    @break
                                                @case(1)
                                                    <td><span class="status-box-success">Devam Ediyor</span></td>
                                                    <td>
                                                        @if($period->is_ended == 1 || !$canStartRenew)
                                                            <button class="btn custom-btn bg-secondary" disabled title="Bugünün tarihi dönemin başlama ve bitiş tarihleri arasında değildir">Başlatılamaz</button>
                                                        @else
                                                            <a href="{{ route('change-period-status', ['id' => $period->id, 'durum' => $period->status]) }}">
                                                                <button class="btn custom-btn bg-danger">
                                                                    Duraklat
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
                                                                        <path d="M6 0.5C2.68 0.5 0 3.18 0 6.5C0 9.82 2.68 12.5 6 12.5C9.32 12.5 12 9.82 12 6.5C12 3.18 9.32 0.5 6 0.5Z" fill="white"></path>
                                                                    </svg>
                                                                </button>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    @break
                                                @case(2)
                                                    <td><span class="completed-write">Tamamlandı</span></td>
                                                    <td><span class="not-allow-write">İzin verilmiyor</span></td>
                                                    @break
                                            @endswitch
                                            <td>
                                                @if($period->is_ended == 1)
                                                    <button class="btn custom-btn bg-secondary" disabled>Bitirildi</button>
                                                @elseif($period->is_started == 1)
                                                    <a href="{{route('period-start-stop', ['id' => $period->id])}}">
                                                        <button class="btn period-start-stop custom-btn bg-danger">Bitir</button>
                                                    </a>
                                                @else
                                                    @if($canStartRenew)
                                                        <a href="{{route('period-start-stop', ['id' => $period->id])}}">
                                                            <button class="btn period-start-stop custom-btn bg-success">Başlat</button>
                                                        </a>
                                                    @else
                                                        <button class="btn custom-btn bg-secondary" disabled title="Bugünün tarihi dönemin başlama ve bitiş tarihleri arasında değildir">Başlatılamaz</button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td><button class="btn   edit-period " data-bs-toggle="modal"  data-bs-target="#kayıtYenilemeDuzenleBaslaModal" data-id="{{$period->id}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M5.34517 13.2418L13.7969 4.78997L12.6184 3.61145L4.16667 12.0633V13.2418H5.34517ZM6.03553 14.9084H2.5V11.3728L12.0292 1.84368C12.3547 1.51825 12.8822 1.51825 13.2077 1.84368L15.5647 4.20071C15.8902 4.52614 15.8902 5.05378 15.5647 5.37922L6.03553 14.9084ZM2.5 16.5751H17.5V18.2418H2.5V16.5751Z" fill="#4069E5"></path>
                                                    </svg>
                                                </button>
                                                <button class="btn   delete-period " data-bs-toggle="modal" data-bs-target="#warningModal" data-id="{{$period->id}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M14.1641 5.00008H18.3307V6.66675H16.6641V17.5001C16.6641 17.9603 16.291 18.3334 15.8307 18.3334H4.16406C3.70383 18.3334 3.33073 17.9603 3.33073 17.5001V6.66675H1.66406V5.00008H5.83073V2.50008C5.83073 2.03985 6.20383 1.66675 6.66406 1.66675H13.3307C13.791 1.66675 14.1641 2.03985 14.1641 2.50008V5.00008ZM7.4974 9.16675V14.1667H9.16406V9.16675H7.4974ZM10.8307 9.16675V14.1667H12.4974V9.16675H10.8307ZM7.4974 3.33341V5.00008H12.4974V3.33341H7.4974Z" fill="#F03000"></path>
                                                    </svg>
                                                </button>
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
        </main>
        <!--Modal Alanı-->
        <!-- Kayıt Yenile Düzenle Modal -->
        <div class="modal fade" id="kayıtYenilemeDuzenleBaslaModal" tabindex="-1"
             aria-labelledby="kayıtYenilemeDuzenleBaslaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body mx-auto">
                        <div class="text-center">
                            <h5 class="modal-title mb-3" id="kayıtYenilemeDuzenleBaslaModalLabel">Dönem Düzenle</h5>
                            <p>Dönem bilgilerini giriniz.</p>
                            <p>Güncelle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</p>
                        </div>
                        <form id="editPeriodForm" >
                            <input type="hidden" name="edit_id" id="edit_id">
                            <input type="hidden" name="edit_type" id="edit_type">
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="editBursDonemi" class="form-label">Dönem Seçiniz</label>
                                            <select id="editBursDonemi" class="form-select" name="edit_title">
                                                <option selected>Yıl seçiniz..</option>
                                                @foreach($yillar as $yil)
                                                <option value='{{$yil}}'>{{$yil}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="form-check form-check-inline mt-4">
                                                <input class="form-check-input" type="checkbox" id="editGuzDonemi"
                                                       value="Aktif" name="edit-guz">
                                                <label class="form-check-label" for="editGuzDonemi">Güz Dönemi</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-4">
                                                <input class="form-check-input" type="checkbox" id="editBaharDonemi"
                                                       value="Aktif" name="edit-bahar">
                                                <label class="form-check-label" for="editBaharDonemi">Bahar Dönemi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="kayıtYenilemeDuzenleBasla" class="form-label">Kayıt yenileme başlama
                                                tarihi</label>
                                            <input type="date" class="form-control custom-date-input"
                                                   id="kayıtYenilemeDuzenleBasla"
                                                   onclick="document.getElementById('kayıtYenilemeDuzenleBasla').showPicker()" name="edit_start_time">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kayıtYenilemeDuzenleBitis" class="form-label">Kayıt yenileme bitiş
                                                tarihi</label>
                                            <input type="date" class="form-control custom-date-input"
                                                   id="kayıtYenilemeDuzenleBitis"
                                                   onclick="document.getElementById('kayıtYenilemeDuzenleBitis').showPicker()" name="edit_end_time">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Öğrenim türünü/türlerini seçiniz</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="ilkokul" id="editType_ilkokul" name="editType[]">
                                                    <label class="form-check-label" for="editType_ilkokul">İlkokul</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="ortaokul" id="editType_ortaokul" name="editType[]">
                                                    <label class="form-check-label" for="editType_ortaokul">Ortaokul</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="lise" id="editType_lise" name="editType[]">
                                                    <label class="form-check-label" for="editType_lise">Lise</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="onlisans" id="editType_onlisans" name="editType[]">
                                                    <label class="form-check-label" for="editType_onlisans">Ön Lisans</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="lisans" id="editType_lisans" name="editType[]">
                                                    <label class="form-check-label" for="editType_lisans">Lisans</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="yukseklisans" id="editType_yukseklisans" name="editType[]">
                                                    <label class="form-check-label" for="editType_yukseklisans">Yüksek Lisans</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="doktora" id="editType_doktora" name="editType[]">
                                                    <label class="form-check-label" for="editType_doktora">Doktora</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Belge Yönetimi</label>
                                    <div class="accordion" id="renewdocumentsAccordion">
                                        @foreach ($periods as $period)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="editheading{{ Str::slug($period[1]) }}">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#editcollapse{{ Str::slug($period[0]) }}"
                                                            aria-expanded="false"
                                                            aria-controls="editcollapse{{ Str::slug($period[0]) }}">
                                                        <div class="d-flex align-items-center justify-content-between w-100">
                                                            <span class="fw-bold">{{ $period[1] }}</span>
                                                            <div class="form-check ms-3">
                                                                <input type="checkbox"
                                                                    class="category-checkbox form-check-input me-2"
                                                                    id="editcategory_{{ Str::slug($period[0]) }}"
                                                                    data-category="{{ $period[0] }}"
                                                                    onclick="event.stopPropagation();">
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="editcollapse{{ Str::slug($period[0]) }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="editheading{{ Str::slug($period[0]) }}"
                                                    data-bs-parent="#editdocumentsAccordion">
                                                    <div class="accordion-body">
                                                        @foreach ($documents as $document)
                                                            <div class="form-check mb-2">
                                                                <input type="checkbox"
                                                                name="editdocuments_{{ $period[0] }}[]"
                                                                value="{{ $document->db_key }}"
                                                                    id="editdocument_{{ $document->db_key }}"
                                                                    class="form-check-input permission-checkbox"
                                                                    >
                                                                <label for="editdocument_{{ $document->db_key }}"
                                                                    class="form-check-label">
                                                                    {{ $document->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="updateButton">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Modal -->
        <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <path d="M7.66406 0.666992C5.80755 0.666992 4.02707 1.40449 2.71431 2.71724C1.40156 4.03 0.664062 5.81048 0.664062 7.66699V14.667C0.664062 15.9557 1.70873 17.0003 2.9974 17.0003C4.28606 17.0003 5.33073 15.9557 5.33073 14.667V7.66699C5.33073 7.04815 5.57656 6.45466 6.01415 6.01708C6.45173 5.57949 7.04522 5.33366 7.66406 5.33366H14.6641C15.9527 5.33366 16.9974 4.28899 16.9974 3.00033C16.9974 1.71166 15.9527 0.666992 14.6641 0.666992H7.66406Z" fill="#2D3648"/>
                                <path d="M33.3307 0.666992C32.0421 0.666992 30.9974 1.71166 30.9974 3.00033C30.9974 4.28899 32.0421 5.33366 33.3307 5.33366H40.3307C40.9496 5.33366 41.5431 5.57949 41.9806 6.01708C42.4182 6.45466 42.6641 7.04815 42.6641 7.66699V14.667C42.6641 15.9557 43.7087 17.0003 44.9974 17.0003C46.2861 17.0003 47.3307 15.9557 47.3307 14.667V7.66699C47.3307 5.81048 46.5932 4.03 45.2805 2.71724C43.9677 1.40449 42.1872 0.666992 40.3307 0.666992H33.3307Z" fill="#2D3648"/>
                                <path d="M5.33073 33.3337C5.33073 32.045 4.28606 31.0003 2.9974 31.0003C1.70873 31.0003 0.664062 32.045 0.664062 33.3337V40.3337C0.664062 42.1902 1.40156 43.9706 2.71431 45.2834C4.02707 46.5962 5.80755 47.3337 7.66406 47.3337H14.6641C15.9527 47.3337 16.9974 46.289 16.9974 45.0003C16.9974 43.7117 15.9527 42.667 14.6641 42.667H7.66406C7.04523 42.667 6.45173 42.4212 6.01415 41.9836C5.57656 41.546 5.33073 40.9525 5.33073 40.3337V33.3337Z" fill="#2D3648"/>
                                <path d="M47.3307 33.3337C47.3307 32.045 46.2861 31.0003 44.9974 31.0003C43.7087 31.0003 42.6641 32.045 42.6641 33.3337V40.3337C42.6641 40.9525 42.4182 41.546 41.9806 41.9836C41.5431 42.4212 40.9496 42.667 40.3307 42.667H33.3307C32.0421 42.667 30.9974 43.7117 30.9974 45.0003C30.9974 46.289 32.0421 47.3337 33.3307 47.3337H40.3307C42.1872 47.3337 43.9677 46.5962 45.2805 45.2834C46.5932 43.9707 47.3307 42.1902 47.3307 40.3337V33.3337Z" fill="#2D3648"/>
                            </svg>
                            <svg class="question-icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z" stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.3594 11.2497C11.6533 10.4143 12.2333 9.70987 12.9968 9.26115C13.7603 8.81243 14.658 8.64841 15.5308 8.79813C16.4037 8.94784 17.1954 9.40164 17.7657 10.0791C18.336 10.7566 18.6482 11.6141 18.6469 12.4997C18.6469 14.9997 14.8969 16.2497 14.8969 16.2497" stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15 21.25H15.0125" stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="mt-3">Kayıt silinecektir!</p>
                        <span class="mb-3">Onaylıyor musunuz?</span>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn  me-3" data-bs-dismiss="modal">Vazgeç</button>
                            <button type="button" class="btn btn-primary" id="confirmButton">Onayla</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <path d="M7.66406 0.666992C5.80755 0.666992 4.02707 1.40449 2.71431 2.71724C1.40156 4.03 0.664062 5.81048 0.664062 7.66699V14.667C0.664062 15.9557 1.70873 17.0003 2.9974 17.0003C4.28606 17.0003 5.33073 15.9557 5.33073 14.667V7.66699C5.33073 7.04815 5.57656 6.45466 6.01415 6.01708C6.45173 5.57949 7.04522 5.33366 7.66406 5.33366H14.6641C15.9527 5.33366 16.9974 4.28899 16.9974 3.00033C16.9974 1.71166 15.9527 0.666992 14.6641 0.666992H7.66406Z" fill="#2D3648"/>
                                <path d="M33.3307 0.666992C32.0421 0.666992 30.9974 1.71166 30.9974 3.00033C30.9974 4.28899 32.0421 5.33366 33.3307 5.33366H40.3307C40.9496 5.33366 41.5431 5.57949 41.9806 6.01708C42.4182 6.45466 42.6641 7.04815 42.6641 7.66699V14.667C42.6641 15.9557 43.7087 17.0003 44.9974 17.0003C46.2861 17.0003 47.3307 15.9557 47.3307 14.667V7.66699C47.3307 5.81048 46.5932 4.03 45.2805 2.71724C43.9677 1.40449 42.1872 0.666992 40.3307 0.666992H33.3307Z" fill="#2D3648"/>
                                <path d="M5.33073 33.3337C5.33073 32.045 4.28606 31.0003 2.9974 31.0003C1.70873 31.0003 0.664062 32.045 0.664062 33.3337V40.3337C0.664062 42.1902 1.40156 43.9706 2.71431 45.2834C4.02707 46.5962 5.80755 47.3337 7.66406 47.3337H14.6641C15.9527 47.3337 16.9974 46.289 16.9974 45.0003C16.9974 43.7117 15.9527 42.667 14.6641 42.667H7.66406C7.04523 42.667 6.45173 42.4212 6.01415 41.9836C5.57656 41.546 5.33073 40.9525 5.33073 40.3337V33.3337Z" fill="#2D3648"/>
                                <path d="M47.3307 33.3337C47.3307 32.045 46.2861 31.0003 44.9974 31.0003C43.7087 31.0003 42.6641 32.045 42.6641 33.3337V40.3337C42.6641 40.9525 42.4182 41.546 41.9806 41.9836C41.5431 42.4212 40.9496 42.667 40.3307 42.667H33.3307C32.0421 42.667 30.9974 43.7117 30.9974 45.0003C30.9974 46.289 32.0421 47.3337 33.3307 47.3337H40.3307C42.1872 47.3337 43.9677 46.5962 45.2805 45.2834C46.5932 43.9707 47.3307 42.1902 47.3307 40.3337V33.3337Z" fill="#2D3648"/>
                            </svg>
                            <svg class="confirm-icon" xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29" fill="none">
                                <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A"/>
                                <rect x="1" y="1" width="28" height="27" rx="9" stroke="white" stroke-width="2"/>
                                <path d="M10.5369 13.1696C9.77786 12.4358 8.54714 12.4358 7.78806 13.1696C7.02898 13.9034 7.02898 15.093 7.78806 15.8268L11.6756 19.5847C12.4346 20.3185 13.6654 20.3185 14.4244 19.5847L22.1994 12.0689C22.9585 11.3351 22.9585 10.1454 22.1994 9.41166C21.4404 8.67788 20.2096 8.67788 19.4506 9.41166L13.05 15.5989L10.5369 13.1696Z" fill="white"/>
                            </svg>
                        </div>
                        <p class="mt-3">Kayıt başarı ile kaldırıldı</p>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sayfa yüklendiğinde kategori checkbox'larını kontrol et
                document.querySelectorAll('.accordion-item').forEach(function(category) {
                    const categoryCheckbox = category.querySelector('.category-checkbox');
                    const permissionCheckboxes = category.querySelectorAll('.permission-checkbox');
                    const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
                    categoryCheckbox.checked = allChecked;
                });

                // Kategori checkbox'ları için tüm izinleri işaretleme fonksiyonu
                document.querySelectorAll('.category-checkbox').forEach(function(categoryCheckbox) {
                    categoryCheckbox.addEventListener('change', function(e) {
                        e.stopPropagation();
                        const isChecked = this.checked;
                        const accordionItem = this.closest('.accordion-item');
                        const permissionCheckboxes = accordionItem.querySelectorAll('.permission-checkbox');

                        permissionCheckboxes.forEach(function(checkbox) {
                            checkbox.checked = isChecked;
                        });
                    });
                });

                // İzin checkbox'ları değiştiğinde kategori checkbox'ını güncelle
                document.querySelectorAll('.permission-checkbox').forEach(function(permissionCheckbox) {
                    permissionCheckbox.addEventListener('change', function() {
                        const accordionItem = this.closest('.accordion-item');
                        const categoryCheckbox = accordionItem.querySelector('.category-checkbox');
                        const permissionCheckboxes = accordionItem.querySelectorAll('.permission-checkbox');
                        const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
                        categoryCheckbox.checked = allChecked;
                    });
                });
            });
        </script>
<script>
    $(document).ready(function() {
        var editPeriodRoute = "{{ route('edit-period', ':id') }}";

        // Güz / Bahar tekli seçim kontrolü (biri seçildiğinde diğeri kaldırılsın)
        $('#editGuzDonemi').on('change', function() {
            if (this.checked) {
                $('#editBaharDonemi').prop('checked', false);
            }
        });

        $('#editBaharDonemi').on('change', function() {
            if (this.checked) {
                $('#editGuzDonemi').prop('checked', false);
            }
        });

        // Düzenle butonu tıklama
        $('.edit-period').click(function() {
            var periodId = $(this).data('id');
            var url = editPeriodRoute.replace(':id', periodId);
            $.get(url, function(data) {
                // Modal'ı aç ve verileri doldur
                $('#kayıtYenilemeDuzenleBaslaModal').modal('show');
                // Form verilerini doldur
                var titleYear = data.period.title ? data.period.title.split(' ')[0] : '';
                $('#editPeriodForm').find('[name="edit_title"]').val(titleYear);
                $('#editPeriodForm').find('[name="edit_id"]').val(data.period.id);
                $('#editPeriodForm').find('[name="edit_type"]').val(data.period.type);
                $('#editPeriodForm').find('[name="edit_start_time"]').val(data.period.start_time);
                $('#editPeriodForm').find('[name="edit_end_time"]').val(data.period.end_time);

                // Güz / Bahar dönem checkbox durumlarını başlık bilgisine göre işaretle
                $('#editGuzDonemi').prop('checked', false);
                $('#editBaharDonemi').prop('checked', false);

                if (data.period.title) {
                    if (data.period.title.indexOf('Güz') !== -1) {
                        $('#editGuzDonemi').prop('checked', true);
                    }
                    if (data.period.title.indexOf('Bahar') !== -1) {
                        $('#editBaharDonemi').prop('checked', true);
                    }
                }

                // Tüm editType checkbox'larını işaretsiz yap
                $('input[name="editType[]"]').prop('checked', false);

                // Eğitim türlerini işaretle
                data.period.types.forEach(type => {
                    $(`#editType_${type.educationType}`).prop('checked', true);
                });

                // Tüm document checkbox'larını ve kategori checkbox'larını işaretsiz yap
                $('input[name^="editdocuments_"]').prop('checked', false);
                $('.category-checkbox').prop('checked', false);

                // Belgeleri işaretle
                data.period.documents.forEach(doc => {
                    try {
                        const documents = JSON.parse(doc.documents);
                        const schoolType = doc.school_type;

                        console.log(`${schoolType} için belgeler:`, documents);

                        // Her belge için ilgili okul türünün checkbox'larını işaretle
                        documents.forEach(docKey => {
                            $(`input[name="editdocuments_${schoolType}[]"][value="${docKey}"]`)
                                .prop('checked', true);
                        });

                        // İlgili okul türünün tüm belgeleri işaretli mi kontrol et
                        const totalCheckboxes = $(`input[name="editdocuments_${schoolType}[]"]`).length;
                        const checkedCheckboxes = $(`input[name="editdocuments_${schoolType}[]"]:checked`).length;

                        // Eğer tüm belgeler işaretliyse kategori checkbox'ını da işaretle
                        if(totalCheckboxes === checkedCheckboxes) {
                            $(`#editcategory_${schoolType}`).prop('checked', true);
                        }

                    } catch (e) {
                        console.error('JSON parse hatası:', e);
                    }
                });

                // Modal gösterildikten sonra tekrar kontrol et
                $('#kayıtYenilemeDuzenleBaslaModal').one('shown.bs.modal', function () {
                    console.log('Modal gösterildi, checkbox durumları:');
                    data.period.documents.forEach(doc => {
                        const documents = JSON.parse(doc.documents);
                        const schoolType = doc.school_type;
                        documents.forEach(docKey => {
                            console.log(`${schoolType} - ${docKey}:`,
                                $(`input[name="editdocuments_${schoolType}[]"][value="${docKey}"]`).prop('checked')
                            );
                        });
                    });
                });
            });
        });

        // Guncelleme butonu tıklama
        $('#editPeriodForm').on('submit', function(e) {
            var updatePeriodRoute = "{{ route('update-period', ':id') }}";
            e.preventDefault();
            var periodId = $('#edit_id').val();
            var url = updatePeriodRoute.replace(':id', periodId);
            // Form verilerini al
            const formData = new FormData(this);

            // Belge verilerini topla
            const documents = {};
            $('.accordion-item').each(function() {
                const schoolType = $(this).find('.category-checkbox').data('category');
                const checkedDocs = $(this).find('input[name^="editdocuments_"]:checked').map(function() {
                    return $(this).val();
                }).get();

                if(checkedDocs.length > 0) {
                    documents[`editdocuments_${schoolType}`] = checkedDocs;
                }
            });

            // Belge verilerini formData'ya ekle
            Object.keys(documents).forEach(key => {
                documents[key].forEach(value => {
                    formData.append(`${key}[]`, value);
                });
            });

            Swal.fire({
                title: 'Dönem bilgilerini güncellemek istediğinize emin misiniz?',
                text: "Bu işlem geri alınamaz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, güncelle!',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.success) {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: 'Dönem bilgileri başarıyla güncellendi.',
                                    icon: 'success',
                                    confirmButtonText: 'Tamam'
                                }).then(() => {
                                    // Modal'ı kapat
                                    $('#kayıtYenilemeDuzenleBaslaModal').modal('hide');
                                    // Sayfayı yenile
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Hata!',
                                    text: 'Dönem bilgileri güncellenirken bir hata oluştu.',
                                    icon: 'error',
                                    confirmButtonText: 'Tamam'
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Bir hata oluştu!';
                            if(xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                title: 'Hata!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'Tamam'
                            });
                        }
                    });
                }
            });
        });
        // Sil butonu tıklama
        $('.delete-period').click(function() {
            if(confirm('Bu dönemi silmek istediğinizden emin misiniz?')) {
                var periodId = $(this).data('id');
                $.ajax({
                    url: `/panel/Donem-Sil/${periodId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        location.reload();
                    }
                });
            }
        });
    });
    </script>
        <script src="{{url('public')}}/assets/js/components/modal.js"></script>
        <script src="{{url('public')}}/assets/js/tables/scholar-table.js"></script>
        <script src="{{url('public')}}/assets/js/registration.renewal.js"></script>
        <script>
            document.getElementById('confirmButton').addEventListener('click', function () {
                var warningModal = bootstrap.Modal.getInstance(document.getElementById('warningModal'));
                warningModal.hide();

                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            });
        </script>
        @include('includes.js.toastr')
        @include('includes.js.sidebar')
@endsection
