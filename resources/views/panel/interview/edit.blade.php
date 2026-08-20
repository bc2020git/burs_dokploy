@extends('layouts.master')
@section('title')
    Yönetici Paneli - Mülakat Düzenle
@endsection
@section('page-title')
    Mülakat Düzenle
@endsection

@section('local-css')
    <style>
        .timeline {
            position: relative;
            padding: 20px 0;
            list-style: none;
        }
        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
            left: 31px;
            margin-right: -1.5px;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        .timeline-point {
            position: absolute;
            width: 12px;
            height: 12px;
            background: #0065FF;
            border-radius: 50%;
            left: 26px;
            top: 5px;
            z-index: 1;
        }
        .timeline-content {
            margin-left: 60px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #0065FF;
        }
        .timeline-date {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
            display: block;
        }
        .nav-tabs-custom .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            font-weight: 500;
            color: #495057;
            padding: 12px 20px;
        }
        .nav-tabs-custom .nav-link.active {
            color: #0065FF;
            border-bottom-color: #0065FF;
            background: transparent;
        }

        .interview-edit-page .form-group {
            margin-bottom: 1rem;
        }

        /* Page-scoped toggle switch (same approach as OTP settings page) */
        .interview-edit-page .form-switch {
            padding-left: 0;
            min-height: auto;
        }

        .interview-edit-page .form-check.form-switch {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .interview-edit-page .form-switch .form-check-input {
            --track-w: 46px;
            --track-h: 26px;
            --knob: 20px;
            --gap: 3px;

            width: var(--track-w) !important;
            height: var(--track-h) !important;
            margin: 0 !important;
            padding: 0 !important;
            display: inline-block;
            vertical-align: middle;

            cursor: pointer;
            border-radius: 999px !important;
            border: 1px solid rgba(0, 0, 0, .10) !important;

            background-color: #e9ecef !important;
            background-image: none !important;
            background-position: initial !important;
            background-repeat: no-repeat !important;
            box-shadow: none !important;
            outline: none !important;

            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
            transition: background-color .15s ease, border-color .15s ease;
        }

        .interview-edit-page .form-switch .form-check-input::after {
            content: '';
            position: absolute;
            top: var(--gap);
            left: var(--gap);
            width: var(--knob);
            height: var(--knob);
            border-radius: 999px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .18);
            transform: translateX(0);
            transition: transform .15s ease;
        }

        .interview-edit-page .form-switch .form-check-input:checked {
            background-color: #0d6efd !important;
            border-color: rgba(13, 110, 253, .45) !important;
        }

        .interview-edit-page .form-switch .form-check-input:checked::after {
            transform: translateX(calc(var(--track-w) - var(--knob) - (var(--gap) * 2)));
        }

        .interview-edit-page .form-switch .form-check-input:focus {
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .18) !important;
        }
    </style>
@endsection

@section('body')
    <body data-sidebar="colored">
    @endsection

    @section('content')
        <main class="main-content px-3 py-4 interview-edit-page">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
                <div class="d-flex">
                    <h4 class="mb-0">{{ $data->aday->name }} {{ $data->aday->surname }} - Mülakat Yönetimi</h4>
                </div>
                <div class="btn-toolbar mb-md-0">
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-outline-primary me-3" id="kaydetVeKapatBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z" fill="#4069E5" />
                            </svg>
                            Kaydet ve Kapat
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="kaydetBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z" fill="#4069E5" />
                            </svg>
                            Kaydet
                        </button>
                    </div>
                </div>
            </div>

            <div class="container mt-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-white p-0">
                        <ul class="nav nav-tabs nav-tabs-custom" id="interviewTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">Genel Bilgiler</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="concluding-tab" data-bs-toggle="tab" data-bs-target="#concluding" type="button" role="tab">Mülakat Sonuçlandırma</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="participation-tab" data-bs-toggle="tab" data-bs-target="#participation" type="button" role="tab">Katılım Takibi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline" type="button" role="tab">Zaman Çizelgesi</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content" id="interviewTabsContent">
                            <!-- Tab 1: Genel Bilgiler -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                @php
                                    $interviewDateValue = '';
                                    if (!empty($data->interview_date)) {
                                        try {
                                            $dateString = trim((string) $data->interview_date);
                                            $interviewDateValue = preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateString)
                                                ? $dateString
                                                : \Carbon\Carbon::parse($dateString)->format('d-m-Y');
                                        } catch (\Throwable $e) {
                                            $interviewDateValue = '';
                                        }
                                    }
                                @endphp
                                <form id="interviewUpdateForm" action="{{ route('updateInterviewsMulakatSayfasindan') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="editinterviewDate" class="custom-label">Mülakat Tarihi</label>
                                            <div class="input-group">
                                                <input name="editinterviewDate" type="text" class="form-control inputDate" id="editinterviewDate"
                                                       value="{{ $interviewDateValue }}" placeholder="Tarih seçiniz" required>
                                                <div style="z-index: 3;" class="input-group-append no-border">
                                                    <span class="input-group-text no-border" id="editinterviewDateIcon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="24" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                            <path d="M14 4h-1V2.5a.5.5 0 0 0-1 0V4H4V2.5a.5.5 0 0 0-1 0V4H2a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM1 6a1 1 0 0 1 1-1h1v.5a.5.5 0 0 0 1 0V5h8v.5a.5.5 0 0 0 1 0V5h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6zm1 2v5h12V8H2z"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="editinterviewTime" class="custom-label">Mülakat Saati</label>
                                            <input name="editinterviewTime" type="time" class="form-control" id="editinterviewTime"
                                                   value="{{ $data->interview_time }}" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="editinterviewType" class="custom-label">Mülakat Tipi</label>
                                            <select name="editinterviewType" class="form-select" id="editinterviewType" required>
                                                <option value="Çevrim içi" {{ $data->interview_platform == 'Çevrim içi' ? 'selected' : '' }}>Çevrim içi</option>
                                                <option value="Yüz Yüze" {{ $data->interview_platform == 'Yüz Yüze' ? 'selected' : '' }}>Yüz Yüze</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="editinterviewer" class="custom-label">Mülakatı Yapacak Kişi/Grup</label>
                                            <select name="editinterviewer" class="form-select" id="editinterviewer" required>
                                                <option value="" disabled>Seçiniz</option>
                                                @foreach($groups as $group)
                                                    <option value="{{ $group->id }}" {{ $data->interview_person == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="editinterview_address" class="custom-label">Adres / Link</label>
                                            <input name="editinterviewadress" type="text" class="form-control" id="editinterview_address"
                                                   value="{{ $data->interview_address }}" placeholder="Adres veya toplantı linki giriniz..." required>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab: Katılım Takibi -->
                            <div class="tab-pane fade" id="participation" role="tabpanel">
                                <div class="row">
                                    <!-- Sol Sütun: Aday Katılımı -->
                                    <div class="col-md-6 border-end">
                                        <h5 class="mb-4 text-primary"><i class="fas fa-user-graduate me-2"></i>Aday Katılım Durumu</h5>

                                        <div class="form-group">
                                            <label for="aday_katilim_durumu" class="custom-label">Katılım Durumu</label>
                                            <select name="aday_katilim_durumu" form="interviewUpdateForm" class="form-select" id="aday_katilim_durumu">
                                                <option value="" selected disabled>Seçiniz...</option>
                                                <option value="Katılacağım" {{ $data->aday_katilim_durumu == 'Katılacağım' ? 'selected' : '' }}>Katılacağım</option>
                                                <option value="Başka bir tarihte ve/veya saatte katılmak istiyorum" {{ $data->aday_katilim_durumu == 'Başka bir tarihte ve/veya saatte katılmak istiyorum' ? 'selected' : '' }}>Başka bir tarihte ve/veya saatte katılmak istiyorum</option>
                                                <option value="Katılmayacağım" {{ $data->aday_katilim_durumu == 'Katılmayacağım' ? 'selected' : '' }}>Katılmayacağım</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Sağ Sütun: Mülakatçı Katılımı -->
                                    <div class="col-md-6 ps-md-4">
                                        <h5 class="mb-4 text-primary"><i class="fas fa-users me-2"></i>Mülakatçı Katılım Durumu</h5>

                                        <div class="list-group">
                                            @forelse($interviewerDetails as $interviewer)
                                                @php
                                                    $isChecked = isset($data->interviewer_participation[$interviewer->id]) && $data->interviewer_participation[$interviewer->id] == '1';
                                                @endphp
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-0">{{ $interviewer->name }}</h6>
                                                    </div>
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                               name="interviewer_participation[{{ $interviewer->id }}]"
                                                               value="1"
                                                               form="interviewUpdateForm"
                                                               id="interviewer_{{ $interviewer->id }}"
                                                               {{ $isChecked ? 'checked' : '' }}>
                                                        <label class="form-check-label mb-0" for="interviewer_{{ $interviewer->id }}">Katıldı</label>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="alert alert-warning">
                                                    Mülakatçı atanmamış veya grup üyeleri bulunamadı.
                                                </div>
                                            @endforelse
                                        </div>

                                        @if(count($interviewerDetails) > 0)
                                            <div class="mt-3 small text-muted">
                                                <i class="fas fa-info-circle me-1"></i> Sadece mülakata katılanları işaretleyiniz.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: mülakat Sonuçlandırma -->
                            <div class="tab-pane fade" id="concluding" role="tabpanel">
                                <form id="concludeInterviewForm" action="{{ route('end-interview') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="endinterviewScore" class="custom-label">Mülakat Puanı</label>
                                            <input name="editinterviewScore" type="number" class="form-control" id="endinterviewScore"
                                                   value="{{ $data->interview_score }}" placeholder="Puan yazınız...">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="endinterviewResult" class="custom-label">Mülakat Sonucu</label>
                                            <select name="editinterviewResult" class="form-select" id="endinterviewResult">
                                                <option value="" disabled {{ is_null($data->interview_result) ? 'selected' : '' }}>Seçiniz</option>
                                                <option value="Olumlu" {{ $data->interview_result == 'Olumlu' ? 'selected' : '' }}>Olumlu</option>
                                                <option value="Olumsuz" {{ $data->interview_result == 'Olumsuz' ? 'selected' : '' }}>Olumsuz</option>
                                                <option value="Planlandı" {{ $data->interview_result == 'Planlandı' ? 'selected' : '' }}>Planlandı</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i> Sonuçları kaydettiğinizde aday otomatik olarak bilgilendirilecektir.
                                    </div>

                                    <div class="d-flex mt-4">
                                        <button type="submit" class="btn btn-success px-5">
                                            Sonuçları Kaydet ve Bildir
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab 3: Zaman Çizelgesi -->
                            <div class="tab-pane fade" id="timeline" role="tabpanel">
                                <div class="timeline">
                                    @forelse($logs as $log)
                                        <div class="timeline-item">
                                            <div class="timeline-point"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1 fw-bold">{{ $log->title }}</h6>
                                                <p class="mb-0 text-muted small">{{ $log->text }}</p>
                                                <span class="timeline-date">{{ \Carbon\Carbon::parse($log->created_at)->format('d.m.Y H:i') }}</span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-5">
                                            <p class="text-muted">Bu mülakat için henüz bir kayıt bulunmuyor.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('includes.js.toastr')
    @endsection

    @section('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>
        <script>
            $(document).ready(function() {
                const editInterviewDatePicker = new Pikaday({
                    field: document.getElementById('editinterviewDate'),
                    format: 'DD-MM-YYYY',
                    yearRange: [1900, new Date().getFullYear()],
                    toString(date) {
                        const day = (`0${date.getDate()}`).slice(-2);
                        const month = (`0${date.getMonth() + 1}`).slice(-2);
                        const year = date.getFullYear();
                        return `${day}-${month}-${year}`;
                    },
                    parse(dateString) {
                        const parts = dateString.split('-');
                        const day = parseInt(parts[0], 10);
                        const month = parseInt(parts[1], 10) - 1;
                        const year = parseInt(parts[2], 10);
                        return new Date(year, month, day);
                    },
                    i18n: {
                        previousMonth: 'Önceki Ay',
                        nextMonth: 'Sonraki Ay',
                        months: ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
                        weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                        weekdaysShort: ['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct']
                    },
                    firstDay: 1,
                });

                $('#editinterviewDateIcon').on('click', function() {
                    editInterviewDatePicker.show();
                });

                $('#kaydetBtn').on('click', function() {
                    $('#interviewUpdateForm').submit();
                });

                $('#kaydetVeKapatBtn').on('click', function() {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'redirect_to',
                        value: 'index'
                    }).appendTo('#interviewUpdateForm');
                    $('#interviewUpdateForm').submit();
                });

                // Bildirim Gönder
                $('#bildirimGonderBtn').on('click', function() {
                    const id = "{{ $data->id }}";

                    Swal.fire({
                        title: 'Bildirim Gönderilsin mi?',
                        text: "Atanan gruba bilgilendirme bildirimi gönderilecektir.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#0065FF',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Evet, Gönder',
                        cancelButtonText: 'Vazgeç',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('notifications.send-interview') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    id: id
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Gönderildi!',
                                            response.message,
                                            'success'
                                        );
                                    } else {
                                        Swal.fire(
                                            'Hata!',
                                            response.message,
                                            'error'
                                        );
                                    }
                                },
                                error: function(xhr) {
                                    const response = xhr.responseJSON;
                                    Swal.fire(
                                        'Hata!',
                                        response.message || 'Bir hata oluştu.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });
        </script>
        @include('includes.js.sidebar')
    @endsection
