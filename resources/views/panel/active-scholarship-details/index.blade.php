@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yönetici Paneli
@endsection
@section('local-css')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">
    <style>
        #applicationFormContent {
            padding: 20px;
        }
        .modal-body
        {
            width: 100% !important;
        }
        #applicationFormContent .form-control {
            background-color: #fff !important;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
            margin-bottom: 10px;
        }

        #applicationFormContent .form-check {
            margin-bottom: 10px;
        }

        @media print {
            #applicationFormContent {
                padding: 0;
            }

            #applicationFormContent .form-control {
                border: none;
            }
        }
    </style>
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <form action="{{ route('active-relation-profile-form') }}" id="basvuruForm" method="post"
                enctype="multipart/form-data"> @csrf

                <div class=" mt-1">
                    <div class="navbar-button-container">
                        <button type="button" class="btn btn-outline-primary" id="save-close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z"
                                    fill="#4069E5" />
                            </svg>
                            Kaydet ve Kapat
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="save">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z"
                                    fill="#4069E5" />
                            </svg>
                            Kaydet
                        </button>
                        <button type="button" class="btn btn-mezun" id="graduate" data-bs-toggle="modal"
                            data-bs-target="#graduateConfirmModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M10 1.66675L0 7.50008L10 13.3334L18.3333 8.47233V14.5834H20V7.50008L10 1.66675ZM3.33252 11.2422V15.0002C4.85287 17.0242 7.27343 18.3335 9.99983 18.3335C12.7262 18.3335 15.1467 17.0242 16.6671 15.0002L16.6667 11.2428L10.0003 15.1317L3.33252 11.2422Z"
                                    fill="white" />
                            </svg>
                            Mezun Et
                        </button>

                        <button type="button" class="btn btn-outline-danger" id="denied" data-bs-toggle="modal"
                            data-bs-target="#cancelScholarshipModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z"
                                    fill="#A82200" />
                            </svg>
                            Burs İptal
                        </button>
                        <x-application-form-modal :candidate="$aday->infos" :siblings="$aday->scholar->kardesler" :scholarships="$aday->infos->otherScholarships" :foto_url="$aday->infos->doc_fotograf ?? $latestPhoto" />
                        <a href="{{ route('getScholarMailForm', ['eposta' => $aday->scholar->email]) }}">
                            <button type="button" class="btn me-3 btn-outline-info" id="mail"
                                onclick="window.location.href='/admin/send-mail.html'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none">
                                    <path
                                        d="M2.5 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.5C2.03976 17.5 1.66666 17.1269 1.66666 16.6667V3.33333C1.66666 2.8731 2.03976 2.5 2.5 2.5ZM16.6667 6.0316L10.0598 11.9483L3.33333 6.01328V15.8333H16.6667V6.0316ZM3.75955 4.16667L10.0516 9.71833L16.2508 4.16667H3.75955Z"
                                        fill="#8353E2" />
                                </svg>
                                E-Posta
                            </button>
                        </a>
                        <button type="button" class="btn me-3 btn-outline-warning" id="sms"
                            data-tel="{{ $aday->infos->tel_no }}" data-name="{{ $aday->infos->name }}"
                            data-surname="{{ $aday->infos->surname }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                fill="none">
                                <path
                                    d="M4.80235 14.1667H16.6667V4.16667H3.33333V15.3209L4.80235 14.1667ZM5.37879 15.8333L1.66667 18.75V3.33333C1.66667 2.8731 2.03977 2.5 2.5 2.5H17.5C17.9603 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9603 15.8333 17.5 15.8333H5.37879Z"
                                    fill="#FF8B00" />
                            </svg>
                            SMS
                        </button>
                        <a href="{{ route('deleteactiverelation', ['id' => $aday->scholar->id]) }}">
                            <button type="button" class="btn btn-outline-primary" id="waste">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none">
                                    <path
                                        d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                        fill="#4069E5" />
                                </svg>
                            </button>
                        </a>

                        <button type="button" class="btn btn-outline-primary" id="waste">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M16.6667 2.5C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5H16.6667ZM9.16667 10.8333H4.16667V15.8333H9.16667V10.8333ZM10.8333 15.8333H15.8333V4.16667H10.8333V15.8333ZM9.16667 4.16667H4.16667V9.16667H9.16667V4.16667Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="reload" data-bs-toggle="tooltip"
                            data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                viewBox="0 0 30 30">
                                <path
                                    d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z"
                                    fill="#4069E5"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="scroll">
                                <ul class="nav nav-tabs d-flex flex-nowrap custom-nav-tabs" id="myTab"
                                    role="tablist">
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link active custom-nav-link" id="general-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#general-info" type="button"
                                            role="tab" aria-controls="general-info" aria-selected="true"
                                            data-target="1">Genel Bilgiler</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="personal-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#personal-info" type="button"
                                            role="tab" aria-controls="personal-info" aria-selected="false"
                                            data-target="2">Kişisel
                                            Bilgiler</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="education-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#education-info" type="button"
                                            role="tab" aria-controls="education-info" aria-selected="false"
                                            data-target="3">Eğitim
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="place-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#place-info" type="button" role="tab"
                                            aria-controls="place-info" aria-selected="false" data-target="4">Kalınan Yer
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="family-address-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#family-address-info" type="button"
                                            role="tab" aria-controls="family-address-info" aria-selected="false"
                                            data-target="5">Aile Adres
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link " id="parent-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#parent-info" type="button"
                                            role="tab" aria-controls="parent-info" aria-selected="false"
                                            data-target="6">Ebeveyn Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="sibling-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#sibling-info" type="button"
                                            role="tab" aria-controls="sibling-info" aria-selected="false"
                                            data-target="7">Kardeş Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="income-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#income-info" type="button"
                                            role="tab" aria-controls="income-info" aria-selected="false"
                                            data-target="8">Gelir Beyanı</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="other-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#other-info" type="button" role="tab"
                                            aria-controls="other-info" aria-selected="false" data-target="9">Diğer
                                            Burslar</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="disabled-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#disabled-info" type="button"
                                            role="tab" aria-controls="disabled-info" aria-selected="false"
                                            data-target="10">Engel
                                            Durumu</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="social-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#social-info" type="button"
                                            role="tab" aria-controls="social-info" aria-selected="false"
                                            data-target="11">Sosyal Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="account-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#account-info" type="button"
                                            role="tab" aria-controls="account-info" aria-selected="false"
                                            data-target="12">Hesap Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="job-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#job-info" type="button" role="tab"
                                            aria-controls="job-info" aria-selected="false" data-target="13">İş
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="document-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#document-info" type="button"
                                            role="tab" aria-controls="document-info" aria-selected="false"
                                            data-target="14">Belge
                                            Yükleme</button>
                                    </li>
                                    <!--<li class="nav-item custom-nav-item" role="presentation">
                                                <button class="nav-link custom-nav-link" id="interview-info-tab" data-bs-toggle="tab"
                                                        data-bs-target="#interview-info" type="button" role="tab"
                                                        aria-controls="interview-info" aria-selected="false"
                                                        data-target="15">Mülakatlar</button>
                                            </li>-->
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="payment-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#payment-info" type="button"
                                            role="tab" aria-controls="payment-info" aria-selected="false"
                                            data-target="15">Burs Ödeme Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="timeline" data-bs-toggle="tab"
                                            data-bs-target="#timeline" type="button" role="tab"
                                            aria-controls="timeline" aria-selected="false" data-target="16">Zaman
                                            Çizelgesi</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 profile-card">
                            <div class="profile-header">
                                <h5>Genel Bilgi</h5>
                            </div>
                            <div class="profile-content">
                                <div class="profile-photo text-center">
                                    @php
                                        $fotografPath = $latestPhoto;

                                    @endphp
                                    <img width='150'
                                        src=" @if ($latestPhoto) {{ url($latestPhoto) }} @else {{ url('assets/images/default-profile.svg') }} @endif "
                                        alt="Profile Photo" class="img-fluid">


                                </div>
                                <div class="profile-info">
                                    <h6>{{ $aday->scholar->name }} {{ $aday->scholar->surname }}</h6>
                                    <p>Aktif Bursiyer</p>
                                    <div class="profile-icons d-flex justify-content-center">
                                        <a href="{{ route('getScholarMailForm', ['eposta' => $aday->scholar->email]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.49996C2.03973 17.5 1.66663 17.1269 1.66663 16.6667V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5ZM16.6666 6.0316L10.0598 11.9483L3.33329 6.01328V15.8333H16.6666V6.0316ZM3.75951 4.16667L10.0515 9.71833L16.2508 4.16667H3.75951Z"
                                                    fill="#0052CC" />
                                            </svg>
                                        </a>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M4.80231 14.1667H16.6666V4.16667H3.33329V15.3209L4.80231 14.1667ZM5.37875 15.8333L1.66663 18.75V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9602 15.8333 17.5 15.8333H5.37875Z"
                                                fill="#0052CC" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4317C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                                fill="#0052CC" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="profile-tabs mt-3">
                                    <button class="tab-button" id="aboutButton">Hakkında</button>
                                    <button class="tab-button" id="notesButton">Notlar</button>

                                </div>
                                <div id="aboutContent">
                                    <div class="profile-details"scholar->
                                        <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z"
                                                        fill="#00875A" />
                                                </svg>Burs Durumu:</strong> <span id="bursDurumu" class="bursiyerStatusu">
                                                @if ($aday->status == '4')
                                                    Pasif Bursiyer
                                                @elseif($aday->status == '2')
                                                    Mezun
                                                @elseif($aday->status == '3')
                                                    Aktif Bursiyer
                                                @endif
                                            </span></p>
                                        <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M2.50004 5.00004H17.5V15H2.50004V5.00004ZM1.66671 3.33337C1.20647 3.33337 0.833374 3.70647 0.833374 4.16671V15.8334C0.833374 16.2936 1.20647 16.6667 1.66671 16.6667H18.3334C18.7936 16.6667 19.1667 16.2936 19.1667 15.8334V4.16671C19.1667 3.70647 18.7936 3.33337 18.3334 3.33337H1.66671ZM10.8334 6.66671H15.8334V8.33337H10.8334V6.66671ZM15 10H10.8334V11.6667H15V10ZM8.75004 8.33337C8.75004 9.48396 7.8173 10.4167 6.66671 10.4167C5.51612 10.4167 4.58337 9.48396 4.58337 8.33337C4.58337 7.18278 5.51612 6.25004 6.66671 6.25004C7.8173 6.25004 8.75004 7.18278 8.75004 8.33337ZM6.66671 11.25C5.05587 11.25 3.75004 12.5559 3.75004 14.1667H9.58337C9.58337 12.5559 8.27754 11.25 6.66671 11.25Z"
                                                        fill="#FFAB00" />
                                                </svg>Uyruk:</strong>
                                            @if (isset($aday->infos->nationality))
                                                {{ $aday->infos->nationality }}
                                            @endif
                                        </p>
                                        <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M10 19.7732L4.6967 14.47C1.76777 11.541 1.76777 6.79226 4.6967 3.86333C7.62563 0.934393 12.3743 0.934393 15.3033 3.86333C18.2323 6.79226 18.2323 11.541 15.3033 14.47L10 19.7732ZM14.1248 13.2914C16.4028 11.0134 16.4028 7.31989 14.1248 5.04183C11.8468 2.76378 8.15327 2.76378 5.87521 5.04183C3.59715 7.31989 3.59715 11.0134 5.87521 13.2914L10 17.4162L14.1248 13.2914ZM10 10.8333C9.0795 10.8333 8.33333 10.0871 8.33333 9.16663C8.33333 8.24615 9.0795 7.49996 10 7.49996C10.9205 7.49996 11.6667 8.24615 11.6667 9.16663C11.6667 10.0871 10.9205 10.8333 10 10.8333Z"
                                                        fill="#F03000" />
                                                </svg>Adresi:</strong>
                                            @if (isset($aday->infos->address_detail))
                                                {{ $aday->infos->address_detail }}
                                            @endif
                                        </p>
                                        <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.49996C2.03973 17.5 1.66663 17.1269 1.66663 16.6667V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5ZM16.6666 6.0316L10.0598 11.9483L3.33329 6.01328V15.8333H16.6666V6.0316ZM3.75951 4.16667L10.0515 9.71833L16.2508 4.16667H3.75951Z"
                                                        fill="#4069E5" />
                                                </svg>E-mail:</strong>
                                            @if (isset($aday->infos->email))
                                                {{ $aday->infos->email }}
                                            @endif
                                        </p>
                                        <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4318C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                                        fill="#8353E2" />
                                                </svg>Cep Telefonu:</strong>
                                            @if (isset($aday->infos->tel_no))
                                                {{ $aday->infos->tel_no }}
                                            @endif
                                        </p>
                                        <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M17.5 16.6667H19.1667V18.3334H0.833374V16.6667H2.50004V2.50002C2.50004 2.03979 2.87314 1.66669 3.33337 1.66669H16.6667C17.127 1.66669 17.5 2.03979 17.5 2.50002V16.6667ZM15.8334 16.6667V3.33335H4.16671V16.6667H15.8334ZM6.66671 9.16669H9.16671V10.8334H6.66671V9.16669ZM6.66671 5.83335H9.16671V7.50002H6.66671V5.83335ZM6.66671 12.5H9.16671V14.1667H6.66671V12.5ZM10.8334 12.5H13.3334V14.1667H10.8334V12.5ZM10.8334 9.16669H13.3334V10.8334H10.8334V9.16669ZM10.8334 5.83335H13.3334V7.50002H10.8334V5.83335Z"
                                                        fill="#00BDD6" />
                                                </svg>Öğrenim Türü</strong>
                                            @if (isset($aday->infos->educationType))
                                                {{ $aday->infos->educationType }}
                                            @endif
                                        </p>
                                        <p><strong>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z"
                                                        fill="#00875A" />
                                                </svg>
                                                İşlemi Yapan
                                            </strong> {{ $aday->islemi_yapan }}</p>
                                    </div>
                                </div>
                                <div id="notesContent" style="display: none;">
                                    <button class="btn btn-primary mb-3" id="addNoteButton">Not Ekle</button>
                                    <div id="notesList">
                                        <!-- Notlar buraya eklenecek -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-container col-md-8">
                            <div class="mt-1">
                                <div class="tab-content" id="myTabContent">
                                    <input type="hidden" name="form_id" id="form_id" value="{{ $aday->id }}">
                                    <input type="hidden" name="period_id" id="period_id"
                                        value="{{ $aday->period_id }}">
                                    <input type="hidden" name="scholar_id" id="scholar_id"
                                        value="{{ $aday->scholar_id }}">
                                    @include('panel.active-forms.general-infos')
                                    @include('panel.active-forms.personal-infos')
                                    @include('panel.active-forms.educational-infos')
                                    @include('panel.active-forms.housing-infos')
                                    @include('panel.active-forms.family-address-infos')
                                    @include('panel.active-forms.parent-infos')
                                    @include('panel.active-forms.sibling-infos')
                                    @include('panel.active-forms.income-infos')
                                    @include('panel.active-forms.scholars-infos')
                                    @include('panel.active-forms.disabled-infos')
                                    @include('panel.active-forms.social-infos')
                                    @include('panel.active-forms.account-infos')
                                    @include('panel.active-forms.job-infos')
                                    @include('panel.active-forms.documents')

                                    <div class="tab-pane fade" id="payment-info" role="tabpanel"
                                        aria-labelledby="payment-info-tab" data-content="15">
                                        <div class="tab-section">
                                            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mt-3 mb-2">
                                                <span class="text-muted small">Bu bursiyere ait ödeme kayıtları</span>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#manualBursPaymentModal">
                                                    + Burs Ödemesi Ekle
                                                </button>
                                            </div>
                                            @include('panel.active-scholarship-details.manual-payment-modal')
                                            <div class="table-responsive mt-3">
                                                @include('layouts.student.paymenttable')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline"
                                        data-content="16">
                                        <div class="tab-section">
                                            <div class="container mt-3">
                                                <ul class="timeline-member">
                                                    @php
                                                        // Rastegele sınıf listesi
                                                        $classes = [
                                                            'badge-green',
                                                            'badge-purple',
                                                            'badge-yellow',
                                                            'badge-red',
                                                        ];
                                                    @endphp
                                                    @foreach ($aday->scholar->logs as $log)
                                                        <li class="timeline-item-member">
                                                            @php
                                                                // Rastgele sınıf seçimi
                                                                $randomClass = $classes[array_rand($classes)];
                                                            @endphp
                                                            <span class="timeline-icon-member {{ $randomClass }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" fill="none">
                                                                    <circle cx="12" cy="12" r="10"
                                                                        stroke="white" stroke-width="2" />
                                                                    <path d="M9 12l2 2 4-4" stroke="white"
                                                                        stroke-width="2" />
                                                                </svg>
                                                            </span>
                                                            <div class="timeline-content-member">
                                                                <p>{{ $log->topTitle }}</p>
                                                                <div class="d-flex timeline-content-note">
                        
                                                                    <div class="p-2">
                                                                        <p><strong>{{ $log->Title }}</strong></p>
                                                                        <p><?= $log->text ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="timeline-date-member">{{ $log->created_at }}
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="transfer-modal-footer d-flex justify-content-end g-3 ">
                        <button type="button" onclick="window.location.href='{{ route('bursiyerler') }}'"
                            class=" btn cancel-button" id="prevStep">Vazgeç</button>
                        <button style="display: none;" type="button" class="btn  btn-outline-primary next-button"
                            id="prevButton">Önceki</button>
                        <button type="button" class="btn btn-primary next-button" id="nextStep">Sonraki</button>
                        <button style="display: none;" type="button" class="btn  btn-primary next-button"
                            id="completeButton">Tamamla</button>
                    </div>
                </div>
            </form>
        </main>
        <!--Modal Alanı-->
        <!-- Burs İptal Modal -->
        <div class="modal fade" id="cancelScholarshipModal" tabindex="-1" aria-labelledby="cancelScholarshipModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                            class="bi bi-x-circle-fill" viewBox="0 0 16 16" style="color: #dc3545;">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.646 4.646a.5.5 0 0 0 0 .708L7.293 8 4.646 10.646a.5.5 0 1 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646a.5.5 0 0 0-.708 0z" />
                        </svg>
                        <h5 class="mt-3">Burs İptal Edilsin mi?</h5>
                        <p>Burs iptal işlemi geri alınamaz. Bu işlemi onaylıyor musunuz?</p>
                        <div class="d-flex">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                Vazgeç</button>
                            <a href="{{ route('activeIptalEt', ['id' => $aday->scholar->id]) }}">

                                <button type="button" class="btn btn-outline-danger" id="cancelbtn"
                                    data-bs-dismiss="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z"
                                            fill="#A82200" />
                                    </svg>
                                    Burs İptal
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mezun Et Onay Modalı -->
        <div class="modal fade" id="graduateConfirmModal" tabindex="-1" aria-labelledby="graduateConfirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                            fill="none">
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M11.3633 11.2497C11.6572 10.4143 12.2372 9.70987 13.0007 9.26115C13.7642 8.81243 14.6619 8.64841 15.5348 8.79813C16.4076 8.94784 17.1993 9.40164 17.7696 10.0791C18.34 10.7566 18.6521 11.6141 18.6508 12.4997C18.6508 14.9997 14.9008 16.2497 14.9008 16.2497"
                                stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 21.25H15.0125" stroke="#8353E2" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <h5 class="mt-3">Bursiyer mezun edilecek ve mezunlar alanına taşınacaktır!</h5>
                        <p>Onaylıyor musunuz?</p>
                        <div class=" d-flex">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                            <a href="{{ route('tekliMezunEt', ['id' => $aday->id]) }}"> <button type="button"
                                    class="btn me-3 text-white" id="graduatebtn" data-bs-dismiss="modal"> <svg
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M10 1.66675L0 7.50008L10 13.3334L18.3333 8.47233V14.5834H20V7.50008L10 1.66675ZM3.33252 11.2422V15.0002C4.85287 17.0242 7.27343 18.3335 9.99983 18.3335C12.7262 18.3335 15.1467 17.0242 16.6671 15.0002L16.6667 11.2428L10.0003 15.1317L3.33252 11.2422Z"
                                            fill="white" />
                                    </svg>Mezun Et
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mezun et başarılı Modal -->
        <div class="modal fade" id="graduatebtnModal" tabindex="-1" aria-labelledby="graduatebtnModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                            fill="none">
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" fill="#00875A" />
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" stroke="white"
                                stroke-width="2" />
                            <path
                                d="M10.533 13.8859C9.77395 13.1615 8.54324 13.1615 7.78415 13.8859C7.02507 14.6104 7.02507 15.785 7.78415 16.5095L11.6717 20.2197C12.4307 20.9441 13.6615 20.9441 14.4205 20.2197L22.1955 12.7992C22.9546 12.0748 22.9546 10.9002 22.1955 10.1757C21.4365 9.45127 20.2057 9.45127 19.4467 10.1757L13.0461 16.2844L10.533 13.8859Z"
                                fill="white" />
                        </svg>
                        <h5 class="mt-3">Öğrenci başarıyla mezun edildi!</h5>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kayıt Yenileme Süreci Başarılı Modalı -->
        <div class="modal fade" id="scholarshipCompletionModal" tabindex="-1"
            aria-labelledby="scholarshipCompletionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29"
                            fill="none">
                            <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A" />
                            <rect x="1" y="1" width="28" height="27" rx="9" stroke="white"
                                stroke-width="2" />
                            <path
                                d="M10.535 13.1693C9.7759 12.4356 8.54519 12.4356 7.78611 13.1693C7.02703 13.9031 7.02703 15.0928 7.78611 15.8266L11.6736 19.5845C12.4327 20.3183 13.6634 20.3183 14.4225 19.5845L22.1975 12.0687C22.9566 11.3349 22.9566 10.1452 22.1975 9.41142C21.4384 8.67764 20.2077 8.67764 19.4486 9.41142L13.048 15.5986L10.535 13.1693Z"
                                fill="white" />
                        </svg>
                        <h5 class="mt-3">Kayıt yenileme süreci başarıyla tamamlandı !</h5>
                        <p>Süreçle ilgili SMS ve E-posta yolu ile bilgilendirileceksiniz.</p>
                        <button type="button" id="modalCloseButton" class="btn btn-primary"
                            data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kardeş Ekle Modal -->
        <div class="modal fade" id="kardesEkleModal" tabindex="-1" aria-labelledby="kardesEkleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kardesEkleModalLabel">Kardeş Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('kardesEkle.crm') }}" method="post">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="tc_no" value="{{ $aday->infos->tc_no }}">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesAdi" class="form-label">Adı</label>
                                    <input type="text" class="form-control" id="kardesAdi"
                                        placeholder="Ad giriniz..." name="name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesSoyadi" class="form-label">Soyadı</label>
                                    <input type="text" class="form-control" id="kardesSoyadi"
                                        placeholder="Soyad giriniz..." name="surname">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesYasi" class="form-label">Yaşı</label>
                                    <input type="number" class="form-control" id="kardesYasi" name="age"
                                        placeholder="Yaş giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                                    <select class="form-select" id="kardesOgrenimDurumu" name="educ_status" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Okumuyor</option>
                                        <option>Okul Öncesi</option>
                                        <option>İlkokul</option>
                                        <option>Ortaokul</option>
                                        <option>Lise</option>
                                        <option>Lisans</option>
                                        <option>Yüksek Lisans</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu" class="form-label">Medeni Durumu</label>
                                    <select class="form-select" id="kardesMedeniDurumu" name="maritality" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Bekar</option>
                                        <option>Evli</option>
                                        <option>Boşanmış</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="kardesMeslegi" name="job"
                                        placeholder="Meslek giriniz...">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Ekle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kardeş Düzenle Modal -->
        <div class="modal fade" id="kardesDuzenleModal" tabindex="-1" aria-labelledby="kardesDuzenleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kardesDuzenleModalLabel">Kardeş Bilgileri Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('editNewSiblingDetail') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" id="editKardesId" value="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesAdi" class="form-label">Adı</label>
                                    <input type="text" class="form-control" id="editkardesAdi" name="name"
                                        placeholder="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesSoyadi" class="form-label">Soyadı</label>
                                    <input type="text" class="form-control" id="editkardesSoyadi" name="surname"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesYasi" class="form-label">Yaşı</label>
                                    <input type="number" class="form-control" id="editkardesYasi" name="age"
                                        placeholder="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                                    <select class="form-select" id="editkardesOgrenimDurumu" name="educ_status" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Okumuyor</option>
                                        <option>Okul Öncesi</option>
                                        <option>İlkokul</option>
                                        <option>Ortaokul</option>
                                        <option>Lise</option>
                                        <option>Lisans</option>
                                        <option>Yüksek Lisans</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu" class="form-label">Medeni Durumu</label>
                                    <select class="form-select" id="editkardesMedeniDurumu" name="maritality" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Bekar</option>
                                        <option>Evli</option>
                                        <option>Boşanmış</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="editkardesMeslegi" name="job"
                                        placeholder="Öğretmen">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editButtons = document.querySelectorAll('.editSiblingBtn');

                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const name = this.getAttribute('data-name');
                        const surname = this.getAttribute('data-surname');
                        const age = this.getAttribute('data-age');
                        const educStatus = this.getAttribute('data-educ_status');
                        const maritality = this.getAttribute('data-maritality');
                        const job = this.getAttribute('data-job');

                        // Modal form alanlarını doldur
                        document.getElementById('editKardesId').value = id;
                        document.getElementById('editkardesAdi').value = name;
                        document.getElementById('editkardesSoyadi').value = surname;
                        document.getElementById('editkardesYasi').value = age;

                        // Select elementleri için seçili değerleri ayarla
                        const educStatusSelect = document.getElementById('editkardesOgrenimDurumu');
                        const maritalitySelect = document.getElementById('editkardesMedeniDurumu');

                        // Öğrenim durumu seçimi
                        for (let i = 0; i < educStatusSelect.options.length; i++) {
                            if (educStatusSelect.options[i].value === educStatus) {
                                educStatusSelect.selectedIndex = i;
                                break;
                            }
                        }

                        // Medeni durum seçimi
                        for (let i = 0; i < maritalitySelect.options.length; i++) {
                            if (maritalitySelect.options[i].value === maritality) {
                                maritalitySelect.selectedIndex = i;
                                break;
                            }
                        }

                        document.getElementById('editkardesMeslegi').value = job || '';
                    });
                });
            });
        </script>
        <!-- Burs Ekle Modal -->
        <div class="modal fade" id="bursEkleModal" tabindex="-1" aria-labelledby="bursEkleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="burssEkleModalLabel">Burs Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('crmActiveOtherScholarship') }}" method="post">
                            @csrf
                            <input type="hidden" name="form_id" value="{{ $aday->id }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="kurumAdi" class="form-label">Burs Alınan Kurum Adı</label>
                                    <input name="company_name" type="text" class="form-control" id="kurumAdi"
                                        placeholder="Kurum adı giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kurumTuru" class="form-label">Kurum Türü</label>
                                    <select name="company_type" class="form-select" id="kurumTuru" required>
                                        <option selected disabled>Seçiniz...</option>
                                        <option>Devlet</option>
                                        <option>Özel</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                                    <input name="count" type="text" class="form-control" id="bursMıktarı"
                                        placeholder="Örnek Tutar : 1000">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Ekle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Burs Düzenle Modal -->
        <div class="modal fade" id="bursDuzenleModal" tabindex="-1" aria-labelledby="bursDuzenleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="burssDuzenleModalLabel">Burs Bilgileri Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>

                            <input type="hidden" name="form_id" value="{{ $aday->id }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="kurumAdi" class="form-label">Burs Alınan Kurum Adı</label>
                                    <input name="company_name" type="text" class="form-control" id="kurumAdi"
                                        placeholder="GSB">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kurumTuru" class="form-label">Kurum Türü</label>
                                    <select name="company_type" class="form-select" id="kurumTuru" required>
                                        <option disabled>Seçiniz...</option>
                                        <option selected>Devlet</option>
                                        <option>Özel</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                                    <input name="count" type="text" class="form-control" id="bursMıktarı"
                                        placeholder="Örnek Tutar : 1000">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Belge Gosterme Modal -->
        <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentModalLabel">Belge Görüntüleyici</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                    </div>
                    <div class="modal-body">
                        <object id="documentViewer" data="" type="application/pdf"
                            style="width: 100%; height: 500px;">
                            PDF dosyanız burada görüntülenemiyor. Lütfen <a id="pdfDownloadLink" href="#"
                                download>indirerek</a> açın.
                        </object>
                    </div>
                </div>
            </div>
        </div>
        <!-- Eksik Belge Bildirimi Modalı -->
        <div class="modal fade" id="missingDocumentModal" tabindex="-1" aria-labelledby="missingDocumentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                            fill="none">
                            <path
                                d="M15 27.5C8.09644 27.5 2.5 21.9035 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9035 2.5 27.5 8.09644 27.5 15C27.5 21.9035 21.9035 27.5 15 27.5ZM13.75 18.75V21.25H16.25V18.75H13.75ZM13.75 8.75V16.25H16.25V8.75H13.75Z"
                                fill="#636363" />
                        </svg>
                        <h5 class="mt-3">Başvuru iade edildi !</h5>
                        <div class="col-md-12 mb-3">
                            <label for="ıadeSebebi" class="form-label">İade Sebebi</label>
                            <select id="ıadeSebebi" class="form-select">
                                <option disabled>İade sebebini seçiniz</option>
                                <option value="1">Belge eksik</option>
                                <option value="2">Belge yanlış</option>
                                <option value="3">Bilgiler yanlış</option>
                                <option value="4">Diğer</option>
                            </select>
                        </div>
                        <p>Diğer ise kısaca açıklayınız.</p>
                        <textarea class="form-control" rows="3" placeholder="Açıklama giriniz..."></textarea>
                        <small class="form-text text-muted mt-2">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu
                            ile bilgilendirilecektir!</small>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakat Oluştur Modalı -->
        <div class="modal fade" id="interviewModal" tabindex="-1" aria-labelledby="interviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="interviewModalLabel">Mülakat Oluştur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('aktif-mulakat-olustur') }}" method="post" id="interviewForm"> @csrf
                            <div class="row">
                                <input type="hidden" name="form_id" id="form_id" value="{{ $aday->id }}">
                                <input type="hidden" name="form" id="form_id" value="1">
                                <div class="col-md-6 mb-3">
                                    <label for="interviewDate" class="form-label">Mülakat Tarihi</label>
                                    <input name="date" type="date" class="form-control" id="interviewDate"
                                        onclick="document.getElementById('interviewDate').showPicker()" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="interviewTime" class="form-label">Mülakat Saati</label>
                                    <input name="time" type="time" class="form-control" id="interviewTime"
                                        required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="interviewType" class="form-label">Mülakat Tipi</label>
                                <select name="platform" class="form-select" id="interviewType" required>
                                    <option selected disabled>Seçiniz</option>
                                    <option value="Çevrim içi">Çevrim içi</option>
                                    <option value="Yüz Yüze">Yüz Yüze</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="interviewLocation" class="form-label">Mülakat Yeri / Linki</label>
                                <input name="address" type="text" class="form-control" id="interviewLocation"
                                    placeholder="Yer bilgisi giriniz..">
                            </div>
                            <div class="mb-3">
                                <label for="interviewer" class="form-label">Mülakatı Yapacak Kişi</label>
                                <input type="text" class="form-control" id="interviewer" placeholder="Yazınız.."
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Başvuru Reddet Modalı -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                            fill="none">
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.75 11.25L11.25 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M11.25 11.25L18.75 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <h5 class="mt-3">Başvuru reddedildi !</h5>
                        <p>Ret sebebini açıklayınız.</p>
                        <div class="col-md-12 mb-3">
                            <label for="redSebebi" class="form-label">Ret Sebebi</label>
                            <select id="redSebebi" class="form-select">
                                <option>Ret sebebini seçiniz</option>
                                <option value="1">Başarısızlık</option>
                                <option value="2">Belge Eksikliği</option>
                                <option value="3">Mezun</option>
                                <option value="4">Ekonomik olarak uygun olmamız</option>
                                <option value="5">Başka kurumdan burs alacağınız için</option>
                                <option value="6">Dernek burs yönetmeliğine uygun olmadığınız için</option>
                                <option value="7">Burstan vazgeçtiğiniz için</option>
                                <option value="8">Okulu bıraktığınız için</option>
                                <option value="9">Nakil gittiğniz il/ilçede derneğimiz olmadığı için</option>
                            </select>
                        </div>
                        <p>Diğer ise kısaca açıklayınız.</p>
                        <textarea class="form-control" rows="3" placeholder="Açıklama giriniz..."></textarea>
                        <small class="form-text text-muted mt-2">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu
                            ile bilgilendirilecektir!</small>
                        <button type="button" class="btn btn-primary mt-3">Gönder</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Modal -->
        <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="warningModalLabel">Uyarı Bildirimi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                            fill="none">
                            <path
                                d="M14 26.5C20.9036 26.5 26.5 20.9036 26.5 14C26.5 7.09644 20.9036 1.5 14 1.5C7.09644 1.5 1.5 7.09644 1.5 14C1.5 20.9036 7.09644 26.5 14 26.5Z"
                                stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-3">Kayıt silinecektir!<br>Onaylıyor musunuz?</p>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary me-3"
                                data-bs-dismiss="modal">Vazgeç</button>
                            <button type="button" class="btn btn-primary" id="confirmButton">Onayla</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Uyarı Bildirimi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29"
                            fill="none">
                            <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A" />
                            <rect x="1" y="1" width="28" height="27" rx="9" stroke="white"
                                stroke-width="2" />
                            <path
                                d="M10.5369 13.1696C9.77786 12.4358 8.54714 12.4358 7.78806 13.1696C7.02898 13.9034 7.02898 15.093 7.78806 15.8268L11.6756 19.5847C12.4346 20.3185 13.6654 20.3185 14.4244 19.5847L22.1994 12.0689C22.9585 11.3351 22.9585 10.1454 22.1994 9.41166C21.4404 8.67788 20.2096 8.67788 19.4506 9.41166L13.05 15.5989L10.5369 13.1696Z"
                                fill="white" />
                        </svg>
                        <p class="mt-3">Kayıt başarı ile kaldırıldı</p>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Mülakat Oluştur-->
        <div class="modal fade" id="createInterviewModal" tabindex="-1" aria-labelledby="createInterviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createInterviewModalLabel">Mülakat Oluştur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="title">Mülakat bilgilerini giriniz</p>
                        <p class="small">Oluştur butonuna bastığınızda aday otomatik olarak bilgilendirilecektir</p>
                        <form action="{{ route('aktif-mulakat-olustur') }}" method="post" id="interviewForm"> @csrf
                            <input type="hidden" name="form_id" id="form_id" value="{{ $aday->id }}">

                            <div class="mb-3">
                                <label for="interviewDate" class="form-label">Mülakat Tarihi</label>
                                <div class="d-flex">
                                    <select name='day' class="form-select me-2" id="interviewDay">
                                        <option selected>Gün</option>
                                    </select>
                                    <select name='month' class="form-select me-2" id="interviewMonth">
                                        <option selected>Ay</option>
                                    </select>
                                    <select name='year' class="form-select" id="interviewYear">
                                        <option selected>Yıl</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="interviewTime" class="form-label">Mülakat Saati</label>
                                <div class="d-flex">
                                    <select name="hour" class="form-select me-2 " id="interviewHour">
                                        <option selected>Saat</option>
                                    </select>
                                    <select name="minute" class="form-select" id="interviewMinute">
                                        <option selected>Dakika</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="interviewType" class="form-label">Mülakat Tipi</label>
                                <select name="type" class="form-select" id="interviewType" required>
                                    <option selected disabled>Seçiniz</option>
                                    <option value="Çevrim içi">Çevrim içi</option>
                                    <option value="Yüz Yüze">Yüz Yüze</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="interviewLocation" class="form-label">Mülakat Yeri / Linki</label>
                                <input name="address" type="text" class="form-control" id="interviewLocation"
                                    placeholder="Yer bilgisi giriniz..">
                            </div>
                            <div class="mb-3">
                                <label for="interviewer" class="form-label">Mülakat Yapacak Kişi</label>
                                <input name="person" type="text" class="form-control" id="interviewer"
                                    placeholder="Kişi bilgisi giriniz..">
                            </div>
                            <button id="createInterviewCreateButton" type="submit"
                                class="btn btn-primary mt-3">Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakatı Güncelle Modalı -->
        <div class="modal fade" id="updateInterviewModal" tabindex="-1" aria-labelledby="updateInterviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateInterviewModalLabel">Mülakat Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yapmak istediğiniz işlemi seçiniz</p>
                        <button type="button" class="btn btn-primary mb-2" id="updateInterviewDetails">Mülakat
                            Bilgilerini
                            Güncelle</button>
                        <button type="button" class="btn btn-secondary" id="concludeInterview">Mülakat
                            Sonuçlandır</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Mülakat Bilgileri Güncelle Modal -->
        <div class="modal fade" id="interviewDetailsModal" tabindex="-1"
            aria-labelledby="interviewDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="interviewDetailsModalLabel">Mülakat Bilgilerini Güncelle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="interviewDetailsForm">
                            <!-- Todo ogrenci listesini guncellestir -->
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="bursiyerSelect">Mülakat Yapılacak Kişi</label>
                                    <select class="form-select" id="bursiyerSelect">
                                        <option selected>Seçiniz</option>
                                        <option value="1">Ahsen Eser</option>
                                        <option value="2">Kadir Köreken</option>
                                        <option value="3">Melisa Aydıncı</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="interviewDate" class="form-label">Mülakat Tarihi</label>
                                    <input type="date" class="form-control" id="interviewDate"
                                        onclick="document.getElementById('interviewDate').showPicker()" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="interviewTime" class="form-label">Mülakat Saati</label>
                                    <input type="time" class="form-control" id="interviewTime" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="interviewType" class="form-label">Mülakat Tipi</label>
                                <select class="form-select" id="interviewType" required>
                                    <option selected disabled>Seçiniz</option>
                                    <option value="Çevrim içi">Çevrim içi</option>
                                    <option value="Yüz Yüze">Yüz Yüze</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="interviewer" class="form-label">Mülakatı Yapacak Kişi</label>
                                <input type="text" class="form-control" id="interviewer" placeholder="Yazınız.."
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakat Oluşturuldu Başarı Modalı -->
        <div class="modal fade" id="createInterviewSuccessModal" tabindex="-1"
            aria-labelledby="createInterviewSuccessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="green"
                            class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path
                                d="M10.97 4.97a.75.75 0 011.07 1.05L7.477 10.525a.75.75 0 01-1.064.02L4.324 8.448a.75.75 0 111.082-1.04l1.528 1.54 4.036-4.036z" />
                            <path d="M16 8A8 8 0 11.001 8a8 8 0 0115.999 0zM1.5 8a6.5 6.5 0 1013 0 6.5 6.5 0 00-13 0z" />
                        </svg>
                        <h5 class="mt-3">Mülakat başarıyla oluşturuldu</h5>
                        <p>Aday e-posta ve mesaj yolu ile bilgilendirilecek</p>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakat Notları Modal -->
        <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h5 class="modal-title" id="noteModalLabel">Mülakat Notları</h5>
                        <div class="form-group">
                            <label for="interviewNote">Mülakat Değerlendirmesi</label>
                            <textarea class="form-control" id="interviewNote" rows="4" placeholder="Açıklama giriniz..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary mt-3" id="saveNoteButton">Kaydet</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakat Sonuçlandır Modalı -->
        <div class="modal fade" id="concludeInterviewModal" tabindex="-1"
            aria-labelledby="concludeInterviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="concludeInterviewModalLabel">Mülakat Sonuçlandır</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="concludeInterviewForm">
                            <p>Mülakat sonuçlarını giriniz</p>
                            <p>Güncelle butonuna bastığınızda aday otomatik olarak bilgilendirilecektir</p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="interviewScore" class="form-label">Mülakat Puanı</label>
                                    <input type="number" class="form-control" id="interviewScore"
                                        placeholder="Puan yazınız..." required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="interviewResult" class="form-label">Mülakat Sonucu</label>
                                    <select class="form-select" id="interviewResult" required>
                                        <option selected disabled>Seçiniz</option>
                                        <option value="Olumlu">Olumlu</option>
                                        <option value="Olumsuz">Olumsuz</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Mülakat Silme Modalı-->
        <div class="modal fade" id="deleteInterviewModal" tabindex="-1" aria-labelledby="deleteInterviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="deleteInterviewModalLabel">Mülakat Başarıyla Silindi!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                            fill="none">
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.75 11.25L11.25 18.75" stroke="#FF0000" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M11.25 11.25L18.75 18.75" stroke="#FF0000" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p>Mülakatın neden silindiğini kısaca açıklayınız.</p>
                        <form id="deleteInterviewForm">
                            <div class="mb-3">
                                <textarea class="form-control" id="deleteReason" rows="3" placeholder="Açıklama giriniz.." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gönder</button>
                        </form>
                        <p class="mt-3">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu ile
                            bilgilendirilecektir!</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mezun Et Onay Modalı -->
        <div class="modal fade" id="graduateConfirmModal" tabindex="-1" aria-labelledby="graduateConfirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                            fill="none">
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M11.3633 11.2497C11.6572 10.4143 12.2372 9.70987 13.0007 9.26115C13.7642 8.81243 14.6619 8.64841 15.5348 8.79813C16.4076 8.94784 17.1993 9.40164 17.7696 10.0791C18.34 10.7566 18.6521 11.6141 18.6508 12.4997C18.6508 14.9997 14.9008 16.2497 14.9008 16.2497"
                                stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 21.25H15.0125" stroke="#8353E2" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <h5 class="mt-3">Bursiyer mezun edilecek ve mezunlar alanına taşınacaktır!</h5>
                        <p>Onaylıyor musunuz?</p>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                        <button type="button" class="btn btn-primary" id="confirmGraduate">Onayla</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Not Ekleme Modalı -->
        <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNoteModalLabel">Yeni Not Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style='width: 100%'>
                        <form id="addNoteForm">
                            <div class="mb-3">
                                <label for="noteTitle" class="form-label">Başlık</label>
                                <input type="text" class="form-control" id="noteTitle"
                                    placeholder="Başlık yazınız">
                            </div>
                            <div class="mb-3">
                                <label for="noteContent" class="form-label">İçerik</label>
                                <textarea class="form-control" id="noteContent" rows="3" placeholder="İçerik yazınız"></textarea>
                            </div>
                            <input type="hidden" id="noteTcNo" name="tc_no">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary" id="saveNoteBtn">Kaydet</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mezun Et Başarılı Modalı -->
        <div class="modal fade" id="graduateSuccessModal" tabindex="-1" aria-labelledby="graduateSuccessModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29"
                            fill="none">
                            <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A" />
                            <rect x="1" y="1" width="28" height="27" rx="9" stroke="white"
                                stroke-width="2" />
                            <path
                                d="M10.533 13.1696C9.77395 12.4358 8.54324 12.4358 7.78415 13.1696C7.02507 13.9034 7.02507 15.093 7.78415 15.8268L11.6717 19.5847C12.4307 20.3185 13.6615 20.3185 14.4205 19.5847L22.1955 12.0689C22.9546 11.3351 22.9546 10.1454 22.1955 9.41166C21.4365 8.67788 20.2057 8.67788 19.4467 9.41166L13.0461 15.5989L10.533 13.1696Z"
                                fill="white" />
                        </svg>
                        <h5 class="mt-3">Mezun etme işlemi başarılı</h5>
                        <p>Mezun öğrenciniz e-posta ile bilgilendirilecektir!</p>
                        <a href="{{ route('tekliMezunEt', ['id' => $aday->scholar->id]) }}">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                id="closeSuccessModal">Kapat</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @include('panel.active-scholarship-details.modals')
        @include('panel.includes.renew-update-detail-scripts')
    @endsection
    @section('scripts')
        <!-- App js -->
        @include('includes.js.toastr')


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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>

        @include('includes.js.teklisendsms')
        <script src="{{ url('') }}/assets/js/tab-manager.js"></script>
        <script>
            TabManager.init('myTab', 'aktifBursiyerDetay');
        </script>
        @include('student.ortakSelectFonksiyonlar')
        <script src="{{ url('') }}/assets/js/components/dashboard.js"></script>
        <script src="{{ url('') }}/assets/js/components/admin-direct-buttons.js"></script>
        <script src="{{ url('') }}/assets/js/registration.renewal.js"></script>
        <script src="{{ url('') }}/assets/js/manuel.js"></script>
        <script src="{{ url('') }}/assets/js/components/personCard.js"></script>
        <script src="{{ url('') }}/assets/js/components/modal.js"></script>
        <script src="{{ url('') }}/assets/js/document-control.js"></script>
        <script src="{{ url('') }}/assets/js/components/document-show.js"></script>
        <script src="{{ url('') }}/assets/js/components/detail-forms.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Global modal değişkeni
            let applicationModal;

            document.addEventListener('DOMContentLoaded', function() {
                // Modal'ı doğru config parametreleriyle başlat
                applicationModal = new bootstrap.Modal(document.getElementById('applicationFormModal'), {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });
            });

            // Modal açma fonksiyonu
            function openApplicationForm() {
                if (applicationModal) {
                    applicationModal.show();
                } else {
                    console.error('Modal başlatılamadı');
                }
            }

            // Modal kapatma fonksiyonu
            function closeApplicationForm() {
                if (applicationModal) {
                    applicationModal.hide();
                }
            }
            $(document).ready(function() {
                document.getElementById('activeopenform').addEventListener('click', function() {
                    var exampleModal = new bootstrap.Modal(document.getElementById('activeForm'));
                    exampleModal.show();
                });
                $('#downloadPdf').click(async function() {
                    try {
                        // Loading göster
                        Swal.fire({
                            title: 'PDF Oluşturuluyor...',
                            text: 'Lütfen bekleyiniz',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const element = document.getElementById('applicationFormContent');

                        // SVG'leri PNG'ye çevir
                        const svgElements = element.querySelectorAll('svg');
                        const svgImages = element.querySelectorAll('img[src*="svg"]');

                        // SVG elementlerini işle
                        svgElements.forEach(async (svg) => {
                            try {
                                const canvas = document.createElement('canvas');
                                const ctx = canvas.getContext('2d');
                                const svgData = new XMLSerializer().serializeToString(svg);
                                const img = new Image();
                                img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
                                await new Promise((resolve) => {
                                    img.onload = resolve;
                                });
                                canvas.width = img.width;
                                canvas.height = img.height;
                                ctx.drawImage(img, 0, 0);
                                svg.parentNode.replaceChild(img, svg);
                            } catch (err) {
                                console.warn('SVG dönüştürme hatası:', err);
                            }
                        });

                        // SVG imajları işle
                        svgImages.forEach((img) => {
                            img.style.visibility = 'hidden';
                        });

                        // Form elemanlarını temizle
                        $('#applicationFormContent select').each(function() {
                            const selectedText = $(this).find('option:selected').text();
                            $(this).replaceWith(`<div class="form-control">${selectedText}</div>`);
                        });

                        $('#applicationFormContent input[type="checkbox"]').each(function() {
                            const isChecked = $(this).prop('checked');
                            $(this).replaceWith(`<div>${isChecked ? '✓' : '✗'}</div>`);
                        });

                        // PDF oluşturma seçenekleri
                        const opt = {
                            margin: 10,
                            filename: '{{ $aday->name }}_{{ $aday->surname }}_basvuru_formu.pdf',
                            image: {
                                type: 'jpeg'
                            },
                            html2canvas: {
                                scale: 1,
                                useCORS: true,
                                logging: false,
                                removeContainer: true,
                                imageTimeout: 0,
                                onclone: function(clonedDoc) {
                                    Array.from(clonedDoc.images).forEach(img => {
                                        img.removeAttribute('srcset');
                                    });
                                }
                            },
                            jsPDF: {
                                unit: 'mm',
                                format: 'a4',
                                orientation: 'portrait',
                                compress: true
                            }
                        };

                        // PDF oluştur
                        await html2pdf().set(opt).from(element).save();

                        // Başarılı mesajı göster
                        Swal.fire({
                            icon: 'success',
                            title: 'PDF Oluşturuldu',
                            text: 'PDF başarıyla indirildi',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Sayfayı yenile
                        setTimeout(() => {
                            $('#applicationFormModal').modal('hide');
                            location.reload();
                        }, 2000);

                    } catch (error) {
                        console.error('PDF oluşturma hatası:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: 'PDF oluşturulurken bir hata oluştu. Lütfen tekrar deneyiniz.'
                        });
                    }
                });
            });
        </script>
        @include('layouts.student.notesjs')
        @include('layouts.student.paymenttablejs')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>
        <script>
            function normalizeManualPaymentDateToDMY(value) {
                if (!value) {
                    return value;
                }
                value = String(value).trim();
                if (/^\d{2}\.\d{2}\.\d{4}$/.test(value)) {
                    return value;
                }
                const iso = value.match(/^(\d{4})-(\d{2})-(\d{2})$/);
                if (iso) {
                    return `${iso[3]}.${iso[2]}.${iso[1]}`;
                }
                const dmy = value.match(/^(\d{1,2})[-/.](\d{1,2})[-/.](\d{4})$/);
                if (dmy) {
                    const dd = dmy[1].padStart(2, '0');
                    const mm = dmy[2].padStart(2, '0');
                    return `${dd}.${mm}.${dmy[3]}`;
                }
                const d = new Date(value);
                if (!isNaN(d.getTime())) {
                    const dd = String(d.getDate()).padStart(2, '0');
                    const mm = String(d.getMonth() + 1).padStart(2, '0');
                    const yyyy = String(d.getFullYear());
                    return `${dd}.${mm}.${yyyy}`;
                }
                return value;
            }

            (function() {
                let manualPaymentPikaday = null;
                const modalEl = document.getElementById('manualBursPaymentModal');
                if (!modalEl) {
                    return;
                }
                modalEl.addEventListener('shown.bs.modal', function() {
                    const field = document.getElementById('manual_baslangic_tarihi');
                    if (!field) {
                        return;
                    }
                    if (manualPaymentPikaday) {
                        manualPaymentPikaday.destroy();
                        manualPaymentPikaday = null;
                    }
                    manualPaymentPikaday = new Pikaday({
                        field: field,
                        format: 'DD.MM.YYYY',
                        firstDay: 1,
                        i18n: {
                            previousMonth: 'Önceki Ay',
                            nextMonth: 'Sonraki Ay',
                            months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                            weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                            weekdaysShort: ['Paz', 'Pts', 'Sal', 'Çar', 'Per', 'Cum', 'Cts']
                        }
                    });
                });
                modalEl.addEventListener('hidden.bs.modal', function() {
                    if (manualPaymentPikaday) {
                        manualPaymentPikaday.destroy();
                        manualPaymentPikaday = null;
                    }
                });
                $('#manualBursPaymentSubmit').on('click', function() {
                    const baslangicNormalized = normalizeManualPaymentDateToDMY($('#manual_baslangic_tarihi').val());
                    $('#manual_baslangic_tarihi').val(baslangicNormalized);
                    $.ajax({
                        url: @json(route('burs-odeme.aktif-bursiyer-manuel')),
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            form_id: $('#manual_payment_form_id').val(),
                            tc_kimlik_no: $('#manual_payment_tc').val(),
                            burs_tipi_id: $('#manual_burs_tipi_id').val(),
                            donem: $('#manual_donem').val(),
                            taksit_sayisi: $('#manual_taksit_sayisi').val(),
                            odeme_tutari: $('#manual_odeme_tutari').val(),
                            baslangic_tarihi: baslangicNormalized,
                        },
                        success: function(res) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success(res.message || 'Kayıtlar oluşturuldu');
                            } else {
                                alert(res.message || 'Kayıtlar oluşturuldu');
                            }
                            setTimeout(function() {
                                window.location.reload();
                            }, 400);
                        },
                        error: function(xhr) {
                            let msg = 'İşlem başarısız.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                msg = Object.values(xhr.responseJSON.errors).flat().join(' ');
                            }
                            if (typeof toastr !== 'undefined') {
                                toastr.error(msg);
                            } else {
                                alert(msg);
                            }
                        }
                    });
                });
            })();
        </script>

        @include('panel.active-scholarship-details.scriptf')
        @include('includes.js.sidebar')
    @endsection
