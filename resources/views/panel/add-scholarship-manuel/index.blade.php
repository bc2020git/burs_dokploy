@extends('layouts.master')
@section('title')
    {{$title}}
@endsection
@section('page-title')
    {{$title}}
@endsection
@section('local-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">
@endsection
@section('body')

    <body data-sidebar="colored">
@endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <form id="manuelscholarform" method="post">
                @csrf
                <div class=" mt-1">
                    <div class="navbar-button-container">
                        <button type="button" class="btn btn-outline-primary" id="kaydetVeKapatBtns"
                            onclick="submitForm('/panel/Aday-Bursiyerler')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z"
                                    fill="#4069E5" />
                            </svg>
                            Kaydet ve Kapat
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="kaydetBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z"
                                    fill="#4069E5" />
                            </svg>
                            Kaydet
                        </button>
                        <button type="button" class="btn btn-outline-success" id="confirm" data-bs-toggle="modal"
                            data-bs-target="#newStudentWarningModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16658C11.8423 9.16658 13.334 7.67492 13.334 5.83325C13.334 3.99158 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99158 6.66732 5.83325C6.66732 7.67492 8.15898 9.16658 10.0007 9.16658ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z"
                                    fill="#006644" />
                            </svg>
                            Burs Onay
                        </button>
                        <button type="button" class="btn btn-outline-danger" id="denied" data-bs-toggle="modal"
                            data-bs-target="#newStudentWarningModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z"
                                    fill="#A82200" />
                            </svg>
                            Burs Ret
                        </button>
                        <button type="button" class="btn btn-outline-dark" id="toReturn" data-bs-toggle="modal"
                            data-bs-target="#newStudentWarningModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.4888 14.1666L13.9652 12.6429L15.1437 11.4644L18.6792 14.9999L15.1437 18.5354L13.9652 17.3569L15.4888 15.8333H12.5007V14.1666H15.4888Z"
                                    fill="#1A1A1A" />
                            </svg>
                            Başvuru İade
                        </button>
                        <button type="button" class="btn btn-primary text-white" id="createInterview" data-bs-toggle="modal"
                            data-bs-target="#newStudentWarningModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M7.5013 0.833008V2.49967H12.5013V0.833008H14.168V2.49967H17.5013C17.9616 2.49967 18.3346 2.87277 18.3346 3.33301V16.6663C18.3346 17.1266 17.9616 17.4997 17.5013 17.4997H2.5013C2.04107 17.4997 1.66797 17.1266 1.66797 16.6663V3.33301C1.66797 2.87277 2.04107 2.49967 2.5013 2.49967H5.83464V0.833008H7.5013ZM16.668 9.16634H3.33464V15.833H16.668V9.16634ZM5.83464 4.16634H3.33464V7.49967H16.668V4.16634H14.168V5.83301H12.5013V4.16634H7.5013V5.83301H5.83464V4.16634Z"
                                    fill="white" />
                            </svg>
                            Mülakat Oluştur
                        </button>
                        <button type="button" class="btn me-3 btn-outline-info" id="mail" data-bs-toggle="modal"
                            data-bs-target="#newStudentWarningModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M2.5 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.5C2.03976 17.5 1.66666 17.1269 1.66666 16.6667V3.33333C1.66666 2.8731 2.03976 2.5 2.5 2.5ZM16.6667 6.0316L10.0598 11.9483L3.33333 6.01328V15.8333H16.6667V6.0316ZM3.75955 4.16667L10.0516 9.71833L16.2508 4.16667H3.75955Z"
                                    fill="#8353E2" />
                            </svg>
                            E-posta
                        </button>
                        <button type="button" class="btn me-3 btn-outline-warning" id="sms" data-bs-toggle="modal"
                            data-bs-target="#newStudentWarningModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path
                                    d="M4.80235 14.1667H16.6667V4.16667H3.33333V15.3209L4.80235 14.1667ZM5.37879 15.8333L1.66667 18.75V3.33333C1.66667 2.8731 2.03977 2.5 2.5 2.5H17.5C17.9603 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9603 15.8333 17.5 15.8333H5.37879Z"
                                    fill="#FF8B00" />
                            </svg>
                            SMS
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="waste" data-bs-toggle="modal"
                            data-bs-target="#newStudentWarningModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="waste">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M16.6667 2.5C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5H16.6667ZM9.16667 10.8333H4.16667V15.8333H9.16667V10.8333ZM10.8333 15.8333H15.8333V4.16667H10.8333V15.8333ZM9.16667 4.16667H4.16667V9.16667H9.16667V4.16667Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="scroll">
                                <ul class="nav nav-tabs d-flex flex-nowrap custom-nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link active custom-nav-link" id="general-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#general-info" type="button" role="tab"
                                            aria-controls="general-info" aria-selected="true" data-target="1">Genel
                                            Bilgiler</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="personal-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#personal-info" type="button" role="tab"
                                            aria-controls="personal-info" aria-selected="false" data-target="2">Kişisel
                                            Bilgiler</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="education-info-tab"
                                            data-bs-toggle="tab" data-bs-target="#education-info" type="button" role="tab"
                                            aria-controls="education-info" aria-selected="false" data-target="3">Eğitim
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="place-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#place-info" type="button" role="tab" aria-controls="place-info"
                                            aria-selected="false" data-target="4">Kalınan Yer
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="family-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#family-info" type="button" role="tab"
                                            aria-controls="family-info" aria-selected="false" data-target="5">Aile Adres
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link " id="parent-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#parent-info" type="button" role="tab"
                                            aria-controls="parent-info" aria-selected="false" data-target="6">Ebeveyn
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="sibling-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#sibling-info" type="button" role="tab"
                                            aria-controls="sibling-info" aria-selected="false" data-target="7">Kardeş
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="income-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#income-info" type="button" role="tab"
                                            aria-controls="income-info" aria-selected="false" data-target="8">Gelir
                                            Beyanı</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="other-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#other-info" type="button" role="tab" aria-controls="other-info"
                                            aria-selected="false" data-target="9">Diğer Burslar</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="disabled-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#disabled-info" type="button" role="tab"
                                            aria-controls="disabled-info" aria-selected="false" data-target="10">Engel
                                            Durumu</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="social-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#social-info" type="button" role="tab"
                                            aria-controls="social-info" aria-selected="false" data-target="11">Sosyal
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="account-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#account-info" type="button" role="tab"
                                            aria-controls="account-info" aria-selected="false" data-target="12">Hesap
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="job-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#job-info" type="button" role="tab" aria-controls="job-info"
                                            aria-selected="false" data-target="13">İş Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="document-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#document-info" type="button" role="tab"
                                            aria-controls="document-info" aria-selected="false" data-target="14">Belge
                                            Yükleme
                                        </button>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3 col-sm-6 profile-card">
                                <div class="profile-header">
                                    <h5>Genel Bilgi</h5>
                                </div>
                                <div class="profile-content">
                                    <div class="profile-photo text-center">
                                        <img src="{{url('')}}/assets/images/default-profile.svg" alt="Profile Photo"
                                            class="img-fluid">
                                    </div>
                                    <div class="profile-info">
                                        <h6>Ad Soyad</h6>
                                        <p>Aday Bursiyer</p>
                                        <div class="profile-icons d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.49996C2.03973 17.5 1.66663 17.1269 1.66663 16.6667V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5ZM16.6666 6.0316L10.0598 11.9483L3.33329 6.01328V15.8333H16.6666V6.0316ZM3.75951 4.16667L10.0515 9.71833L16.2508 4.16667H3.75951Z"
                                                    fill="#0052CC" />
                                            </svg>
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
                                    <div class="tab-content active" id="about">
                                        <div class="profile-details">
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z"
                                                            fill="#00875A" />
                                                    </svg>Burs Durumu:</strong> <span id="bursDurumu"
                                                    class="bursiyerStatusu"></span></p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z"
                                                            fill="#0052CC" />
                                                    </svg>Başvuru Durumu:</strong><span class="basvuruDurumu"></span></p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M2.50004 5.00004H17.5V15H2.50004V5.00004ZM1.66671 3.33337C1.20647 3.33337 0.833374 3.70647 0.833374 4.16671V15.8334C0.833374 16.2936 1.20647 16.6667 1.66671 16.6667H18.3334C18.7936 16.6667 19.1667 16.2936 19.1667 15.8334V4.16671C19.1667 3.70647 18.7936 3.33337 18.3334 3.33337H1.66671ZM10.8334 6.66671H15.8334V8.33337H10.8334V6.66671ZM15 10H10.8334V11.6667H15V10ZM8.75004 8.33337C8.75004 9.48396 7.8173 10.4167 6.66671 10.4167C5.51612 10.4167 4.58337 9.48396 4.58337 8.33337C4.58337 7.18278 5.51612 6.25004 6.66671 6.25004C7.8173 6.25004 8.75004 7.18278 8.75004 8.33337ZM6.66671 11.25C5.05587 11.25 3.75004 12.5559 3.75004 14.1667H9.58337C9.58337 12.5559 8.27754 11.25 6.66671 11.25Z"
                                                            fill="#FFAB00" />
                                                    </svg>Uyruk:</strong> </p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M10 19.7732L4.6967 14.47C1.76777 11.541 1.76777 6.79226 4.6967 3.86333C7.62563 0.934393 12.3743 0.934393 15.3033 3.86333C18.2323 6.79226 18.2323 11.541 15.3033 14.47L10 19.7732ZM14.1248 13.2914C16.4028 11.0134 16.4028 7.31989 14.1248 5.04183C11.8468 2.76378 8.15327 2.76378 5.87521 5.04183C3.59715 7.31989 3.59715 11.0134 5.87521 13.2914L10 17.4162L14.1248 13.2914ZM10 10.8333C9.0795 10.8333 8.33333 10.0871 8.33333 9.16663C8.33333 8.24615 9.0795 7.49996 10 7.49996C10.9205 7.49996 11.6667 8.24615 11.6667 9.16663C11.6667 10.0871 10.9205 10.8333 10 10.8333Z"
                                                            fill="#F03000" />
                                                    </svg>Adresi:</strong> </p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.49996C2.03973 17.5 1.66663 17.1269 1.66663 16.6667V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5ZM16.6666 6.0316L10.0598 11.9483L3.33329 6.01328V15.8333H16.6666V6.0316ZM3.75951 4.16667L10.0515 9.71833L16.2508 4.16667H3.75951Z"
                                                            fill="#4069E5" />
                                                    </svg>E-mail Adresi:</strong> </p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4318C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                                            fill="#8353E2" />
                                                    </svg>Cep Telefonu:</strong> </p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M17.5 16.6667H19.1667V18.3334H0.833374V16.6667H2.50004V2.50002C2.50004 2.03979 2.87314 1.66669 3.33337 1.66669H16.6667C17.127 1.66669 17.5 2.03979 17.5 2.50002V16.6667ZM15.8334 16.6667V3.33335H4.16671V16.6667H15.8334ZM6.66671 9.16669H9.16671V10.8334H6.66671V9.16669ZM6.66671 5.83335H9.16671V7.50002H6.66671V5.83335ZM6.66671 12.5H9.16671V14.1667H6.66671V12.5ZM10.8334 12.5H13.3334V14.1667H10.8334V12.5ZM10.8334 9.16669H13.3334V10.8334H10.8334V9.16669ZM10.8334 5.83335H13.3334V7.50002H10.8334V5.83335Z"
                                                            fill="#00BDD6" />
                                                    </svg>Öğrenim Türü</strong> </p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M7.5013 0.833008V2.49967H12.5013V0.833008H14.168V2.49967H17.5013C17.9616 2.49967 18.3346 2.87277 18.3346 3.33301V16.6663C18.3346 17.1266 17.9616 17.4997 17.5013 17.4997H2.5013C2.04107 17.4997 1.66797 17.1266 1.66797 16.6663V3.33301C1.66797 2.87277 2.04107 2.49967 2.5013 2.49967H5.83464V0.833008H7.5013ZM16.668 9.16634H3.33464V15.833H16.668V9.16634ZM5.83464 4.16634H3.33464V7.49967H16.668V4.16634H14.168V5.83301H12.5013V4.16634H7.5013V5.83301H5.83464V4.16634Z"
                                                            fill="pink" />
                                                    </svg>Aday Dönemi:</strong> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 form-container">
                                <div class="mt-1">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="general-info" role="tabpanel"
                                            aria-labelledby="general-info-tab" data-content="1">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Adı</label><span style="color: red"> *
                                                        </span>
                                                        <input id="name" type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Soyadı</label><span style="color: red">
                                                            * </span>
                                                        <input id="surname" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">TC Kimlik Numarası</label><span
                                                            style="color: red"> * </span>
                                                        <input id="tc_no" type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">E-Posta</label><span style="color: red">
                                                            * </span>
                                                        <input id="email" type="email" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3 form-group">
                                                        <label for="phone" class="form-label">Telefon</label>
                                                        <br>
                                                        <input type="tel" style="margin-left: 55px !important; width:290px;"
                                                            class="form-control telinputs" id="tel_no">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Bursiyer Tipi</label>
                                                        <select id="aday_turu" class="form-select">
                                                            <option value="">Seçiniz</option>
                                                            <option value="Dernek">Dernek</option>
                                                            <option value="Vakıf">Vakıf</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Burs Tipi</label>
                                                        <select id="burs_tipi_id" class="form-select">
                                                            <option value="">Seçiniz</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 d-none form-group">
                                                        <label class="custom-label">Şube</label>
                                                        <input disabled id="sube" type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Aday Dönemi</label><span
                                                            style="color: red"> * </span>
                                                        <select id="period_id" class="form-select">
                                                            <option value="">Seçiniz</option>
                                                            @foreach(($periods ?? []) as $pOption)
                                                                <option value="{{ $pOption->id }}">{{ $pOption->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="check_taahhutname">
                                                        <p class="form-check-label mt-1" for="check_taahhutname"
                                                            data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                                            <u>Taahhütname'yi</u> okudum, kabul ediyorum
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="check_ailebireyleri">
                                                        <p class="form-check-label mt-1 " for="check_ailebireyleri"
                                                            data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                                            <u>Bursiyer Aile Bireyleri Aydınlatma Metni'ni</u> okudum,
                                                            anladım.
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="check_aydinlatma">
                                                        <p class="form-check-label mt-1 " for="check_aydinlatma"
                                                            style="cursor: pointer;"
                                                            onclick="window.location.href='https://sacdd.org.tr/index.php/burs-fonu/kvkk';">
                                                            <u>Bursiyer Aydınlatma Metni'ni okudum, anladım..</u>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 form-check">
                                                        <input class="form-check-input" type="checkbox" id="check_acikriza">
                                                        <p class="form-check-label mt-1 " for="check_acikriza"
                                                            data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                                            <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="check_ailerizaformu">
                                                        <p class="form-check-label mt-1 " for="check_ailerizaformu"
                                                            data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                                            <u>Bursiyer Aile Bireyleri Açık Rıza Formu'nu okudum, kabul
                                                                ediyorum.</u>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="check_bilgidogrulama">
                                                        <p class="form-check-label mt-1 " for="check_bilgidogrulama">
                                                            Başvuru formunda beyan ettiğim bilgilerin doğruluğunu ve
                                                            gerektiğinde
                                                            araştırma yapılmasını kabul ediyorum.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="personal-info" role="tabpanel"
                                            aria-labelledby="personal-info-tab" data-content="2">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label for="interviewDate">Doğum Tarihi</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control inputDate" id="b_dob"
                                                                placeholder="Tarih seçiniz">
                                                            <div class="input-group-append no-border">
                                                                <span class="input-group-text no-border" id="b_dobIcon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="48"
                                                                        height="24" fill="currentColor"
                                                                        class="bi bi-calendar3" viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M14 4h-1V2.5a.5.5 0 0 0-1 0V4H4V2.5a.5.5 0 0 0-1 0V4H2a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM1 6a1 1 0 0 1 1-1h1v.5a.5.5 0 0 0 1 0V5h8v.5a.5.5 0 0 0 1 0V5h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6zm1 2v5h12V8H2z" />
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Doğduğu Şehir</label>
                                                        <select id="born_city" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            @foreach($cities as $city)
                                                                <option data-id="{{ $city->id }}" value="{{$city->name}}">
                                                                    {{$city->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Doğduğu İlçe</label>
                                                        <select id="born_district" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Nüfusa Kayıtlı Olduğu İl</label>
                                                        <select id="registered_city" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            @foreach($cities as $city)
                                                                <option data-id="{{ $city->id }}" value="{{$city->name}}">
                                                                    {{$city->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Nüfusa Kayıtlı Olduğu İlçe</label>
                                                        <select id="registered_district" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Cinsiyet</label>
                                                        <select id="gender" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="Kadın">Kadın</option>
                                                            <option value="Erkek">Erkek</option>
                                                            <option value="Belirtmek İstemiyorum">Belirtmek İstemiyorum
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Medeni Durumu</label>
                                                        <select id="maritality" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="Bekar">Bekar</option>
                                                            <option value="Evli">Evli</option>
                                                            <option value="Boşanmış">Boşanmış</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Uyruk</label>
                                                        <select id="nationality" class="form-select">
                                                            <option value="Türkiye">Türkiye</option>
                                                            <option value="Diğer">Diğer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="education-info" role="tabpanel"
                                            aria-labelledby="education-info-tab" data-content="3">
                                            <div class="tab-section">
                                                <label class="custom-label">Öğretim Tipi</label><span style="color: red"> *
                                                </span>
                                                <select name="educationType" id="educationType" class="form-select">
                                                    <option selected disabled value="seçiniz">Seçiniz..</option>
                                                    <option value="ilkokul">İlkokul</option>
                                                    <option value="ortaokul">Ortaokul</option>
                                                    <option value="lise">Lise</option>
                                                    <option value="onlisans">Ön lisans</option>
                                                    <option value="lisans">Lisans</option>
                                                    <option value="yukseklisans">Yükseklisans</option>
                                                </select>

                                                <div id="ilkokuldiv" class="educdiv d-none">

                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="custom-label">Okul Tipi</label>
                                                            <select id="primary_educ_type" class="form-select">
                                                                <option disabled selected>Seçiniz..</option>
                                                                <option value="Özel Okul">Özel Okul</option>
                                                                <option value="Devlet Okulu">Devlet Okulu</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="custom-label">Okul Adı</label>
                                                            <input id="p_school_name" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="custom-label">Okulun Bulunduğu Şehir</label>
                                                            <select class="form-select" name="p_school_city"
                                                                id="p_school_city">
                                                                <option selected disabled value="seçiniz">Seçiniz..</option>
                                                                @foreach($cities as $city)
                                                                    <option data-id="{{ $city->id }}" value="{{$city->name}}">
                                                                        {{$city->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="custom-label">Okulun Bulunduğu İlçe</label>
                                                            <select class="form-select" name="p_school_district"
                                                                id="p_school_district">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Ortak Alanlar: İlkokul, Ortaokul, Lise -->
                                                <div id="common_fields" class="d-none">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="class">Sınıfınız</label>
                                                            <select id="class" class="form-select">
                                                                <option selected disabled value="">Seçiniz...</option>
                                                                <!-- İlkokul sınıfları -->
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '1') value="1"
                                                                    class="ilkokul-class">1</option>
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '2') value="2"
                                                                    class="ilkokul-class">2</option>
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '3') value="3"
                                                                    class="ilkokul-class">3</option>
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '4') value="4"
                                                                    class="ilkokul-class">4</option>
                                                                <!-- Ortaokul sınıfları -->
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '5') value="5"
                                                                    class="ortaokul-class">5</option>
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '6') value="6"
                                                                    class="ortaokul-class">6</option>
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '7') value="7"
                                                                    class="ortaokul-class">7</option>
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '8') value="8"
                                                                    class="ortaokul-class">8</option>
                                                                <!-- Lise sınıfları -->
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '9') value="9"
                                                                    class="lise-class">9</option>
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '10') value="10"
                                                                    class="lise-class">10</option>
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '11') value="11"
                                                                    class="lise-class">11</option>
                                                                <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '12') value="12"
                                                                    class="lise-class">12</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="student_number">Öğrenci Numarası</label>
                                                            <input type="text" class="form-control" id="student_number"
                                                                placeholder="Öğrenci numaranızı giriniz...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="is_transfered">Nakil Yaptı mı?</label>
                                                            <select id="is_transfered" class="form-select">
                                                                <option selected disabled value="">Seçiniz...</option>
                                                                <option @selected(isset($aday->educinfo->is_transfered) && $aday->educinfo->is_transfered == 'Evet') value="Evet">
                                                                    Evet</option>
                                                                <option @selected(isset($aday->educinfo->is_transfered) && $aday->educinfo->is_transfered == 'Hayır') value="Hayır">
                                                                    Hayır</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="grade_avg">Not Ortalaması</label>
                                                            <input
                                                                value="@if(isset($aday->educinfo->grade_avg)) {{$aday->educinfo->grade_avg}}@endif"
                                                                type="text" class="form-control" id="grade_avg"
                                                                placeholder="Not ortalamanızı giriniz...">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Ortak Alanlar: Üniversite Seviyeleri (Önlisans, Lisans, Yüksek Lisans) -->
                                                <div id="university_common_fields" class="d-none">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="grade_high_school">Bitirdiğiniz Lise</label>
                                                            <input type="text" class="form-control" id="grade_high_school"
                                                                placeholder="Lise bilgisi giriniz...">
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="entry_grade_university">Üniversiteye Giriş
                                                                Puanınız</label>
                                                            <input type="text" class="form-control"
                                                                id="entry_grade_university"
                                                                placeholder="Puanınızı giriniz...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="university_city">Okulun Bulunduğu Şehir</label>
                                                            <select id="university_city" class="form-select">
                                                                <option selected disabled value="seçiniz">Seçiniz..</option>
                                                                @foreach($cities as $city)
                                                                    <option data-id="{{ $city->id }}" value="{{$city->name}}">
                                                                        {{$city->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="current_university">Öğrenime Devam Ettiğiniz
                                                                Üniversite</label>
                                                            <select id="current_university" class="form-select">
                                                                <option value="">Seçiniz...</option>
                                                                @foreach($unis as $u)
                                                                    <option data-id='{{$u->id}}' value="{{$u->name}}">
                                                                        {{$u->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="university_faculty">Öğrenime Devam Ettiğiniz
                                                                Fakülte</label>
                                                            <select id="university_faculty" class="form-select">
                                                                <option value="">Seçiniz...</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="grade_departmant">Öğrenime Devam Ettiğiniz
                                                                Bölüm</label>
                                                            <select id="grade_departmant" class="form-select">
                                                                <option value="">Seçiniz...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="university_type">Üniversitenin Statüsü</label>
                                                            <select id="university_type" class="form-select">
                                                                <option value="">Seçiniz...</option>
                                                                <option value="Devlet">Devlet</option>
                                                                <option value="Vakıf/Özel">Vakıf/Özel</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="student_number">Öğrenci Numarası</label>
                                                            <input type="text" class="form-control" id="student_number"
                                                                placeholder="Öğrenci numaranızı giriniz...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="agno_type">AGNO Sisteminiz</label>
                                                            <select id="agno_type" class="form-select">
                                                                <option value="">Seçiniz...</option>
                                                                <option value="4'lük">4'lük</option>
                                                                <option value="100'lük">100'lük</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="agno">AGNO</label>
                                                            <input type="text" class="form-control" id="agno"
                                                                placeholder="Not ortalamanızı giriniz...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="university_types">Öğrenim Türü</label>
                                                            <select id="university_types" class="form-select">
                                                                <option value="">Seçiniz...</option>
                                                                <option value="Örgün">Örgün</option>
                                                                <option value="İkinci Öğretim">İkinci Öğretim</option>
                                                                <option value="Açık Öğretim">Açık Öğretim</option>
                                                                <option value="Uzaktan">Uzaktan</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="university_class">{{$period->title ?? ''}} Öğretim
                                                                Yılında Kaçıncı Sınıfta Olacaksınız?</label>
                                                            <select id="university_class" class="form-select"
                                                                style="display:none">
                                                                <option selected disabled value="">Seçiniz...</option>
                                                                <option value="Hazırlık">Hazırlık</option>
                                                                <option value="1">1.Sınıf</option>
                                                                <option value="2">2.Sınıf</option>
                                                                <option value="3">3.Sınıf</option>
                                                                <option value="4">4.Sınıf</option>
                                                                <option value="5">5.Sınıf</option>
                                                                <option value="6">6.Sınıf</option>
                                                            </select>
                                                            <select id="oKN3UeDifPTo" class="form-select"
                                                                style="display:none">
                                                                <option selected disabled value="">Seçiniz...</option>
                                                                <option value="1">1.Sınıf</option>
                                                                <option value="2">2.Sınıf</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç
                                                                Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                                            <select id="university_educ_time" class="form-select">
                                                                <option value="">Seçiniz...</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı
                                                                mı?</label>
                                                            <select id="university_transfer" class="form-select">
                                                                <option value="">Seçiniz...</option>
                                                                <option value="Evet">Evet</option>
                                                                <option value="Hayır">Hayır</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="university_transfer_desc">Yatay/Dikey Geçiş
                                                                yaptıysanız geçiş bilgilerinizi yazınız</label>
                                                            <textarea class="form-control" id="university_transfer_desc"
                                                                rows="3"
                                                                placeholder="Geçiş bilgilerinizi detaylı bir şekilde yazınız..."></textarea>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri
                                                                ile birlikte yazınız</label>
                                                            <input type="text" class="form-control" id="languages"
                                                                placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="ortaokuldiv" class="educdiv d-none">

                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="middle_educ_type">Okul Tipi</label>
                                                            <select id="middle_educ_type" class="form-select">
                                                                <option disabled selected>Seçiniz..</option>
                                                                <option value="Özel Okul">Özel Okul</option>
                                                                <option value="Devlet Okulu">Devlet Okulu</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="m_school_name">Okul Adı</label>
                                                            <input type="text" class="form-control"
                                                                @if(isset($aday->educinfo->m_school_name))
                                                                value="{{$aday->educinfo->m_school_name}}" @endif
                                                                id="m_school_name" placeholder="Okul adınızı giriniz...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                                                            <select onchange="getDistricts(this,'m_school_district')"
                                                                id="m_school_city" class="form-select">
                                                                <option selected disabled>Şehir Seçiniz</option>
                                                                @foreach($cities as $city)
                                                                    <option data-id="{{ $city->id }}"
                                                                        @if(isset($aday->educinfo->m_school_city) && $aday->educinfo->m_school_city == $city->name) selected
                                                                        @endif value="{{$city->name}}">{{$city->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                                                            <select id="m_school_district" class="form-select">
                                                                @if(isset($aday->educinfo->m_school_district))
                                                                    <option value="{{$aday->educinfo->m_school_district}} ">
                                                                        {{$aday->educinfo->m_school_district}}
                                                                </option>@endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="lisediv" class="educdiv d-none">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="schoolType">Okul Tipi</label>
                                                            <select id="h_school_type" class="form-select">
                                                                <option disabled selected>Seçiniz..</option>
                                                                <option value="Devlet Lisesi">Devlet Lisesi</option>
                                                                <option value="Özel Lise (Tam burslu)">Özel Lise (Tam
                                                                    burslu)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="h_school_name">Okul Adı</label>
                                                            <input type="text" class="form-control" id="h_school_name"
                                                                placeholder="Okul adınızı giriniz...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="h_school_city">Okulun Bulunduğu Şehir</label>
                                                            <select onchange="getDistricts(this,'h_school_district')"
                                                                id="h_school_city" class="form-select">
                                                                <option selected disabled value="seçiniz">Seçiniz..</option>
                                                                @foreach($cities as $city)
                                                                    <option data-id="{{ $city->id }}"
                                                                        @if(isset($aday->educinfo->h_school_city) && $aday->educinfo->m_school_city == $city->name) selected
                                                                        @endif value="{{$city->name}}">{{$city->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="h_school_district">Okulun Bulunduğu İlçe</label>
                                                            <select id="h_school_district" class="form-select">
                                                                <option> </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="onlisansdiv" class="educdiv d-none">
                                                    <!-- Önlisans için özel alanlar yoksa burayı boş bırak -->
                                                </div>

                                                <div id="lisansdiv" class="educdiv d-none">
                                                    <!-- Lisans için özel alanlar yoksa burayı boş bırak -->
                                                </div>
                                                <div id="yukseklisansdiv" class="educdiv d-none">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="grade_university">Lisans Mezunu Olduğunuz
                                                                Üniversite</label>
                                                            <select id="grade_university" class="form-select">
                                                                <option selected disabled value="seçiniz">Seçiniz..</option>
                                                                @foreach($unis as $u)
                                                                    <option data-id='{{$u->id}}' value="{{$u->name}}">
                                                                        {{$u->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="jyJoSxf90EeD">Mezun Olduğunuz Bölüm</label>
                                                            <input type="text" class="form-control" id="jyJoSxf90EeD"
                                                                placeholder="Mezun Olduğunuz Bölüm">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="master_university">Yüksek Lisans Yaptığınız
                                                                Üniversite</label>
                                                            <select id="master_university" class="form-select">
                                                                <option value="">Seçiniz...</option>
                                                                @foreach($unis as $u)
                                                                    <option data-id='{{$u->id}}' value="{{$u->name}}">
                                                                        {{$u->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="master_departmant">Yüksek Lisans Yaptığınız
                                                                Bölüm</label>
                                                            <input type="text" class="form-control" id="master_departmant"
                                                                placeholder="Yüksek lisans bölümünüzü giriniz...">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="master_field">Yüksek Lisans Yaptığınız Dal</label>
                                                            <input type="text" class="form-control" id="master_field"
                                                                placeholder="Dal bilgisi giriniz...">
                                                        </div>
                                                        <div class="col-md-6 mb-3 form-group">
                                                            <label for="grade_agno">Lisans Mezuniyet AGNO</label>
                                                            <input type="text" class="form-control" id="grade_agno"
                                                                placeholder="Lisans mezuniyet AGNO giriniz...">
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="place-info" role="tabpanel"
                                            aria-labelledby="place-info-tab" data-content="4">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Barınma Türü</label>
                                                        <select id="housing_type" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="Öğrenci Evi">Öğrenci Evi</option>
                                                            <option value="Yurt">Yurt</option>
                                                            <option value="Aile Yanı">Aile Yanı</option>
                                                            <option value="Misafir">Misafir</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Ödenen Ücret</label>
                                                        <input id="housing_fee" type="text" class="form-control"
                                                            placeholder="Ödenen ücreti giriniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Birlikte Yaşanılan Kişi Sayısı</label>
                                                        <input id="living_with_count" type="text" class="form-control"
                                                            placeholder="Birlikte kalınan kişi sayısını giriniz..">

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Kaldığı İl</label>
                                                        <select id="residing_city" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            @foreach($cities as $city)
                                                                <option data-id="{{ $city->id }}" value="{{$city->name}}">
                                                                    {{$city->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Kaldığı İlçe</label>
                                                        <select id="residing_district" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Tam Adres</label>
                                                        <input id="address_detail" type="text" class="form-control"
                                                            placeholder="Adres bilgilerinizi giriniz..">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="family-address-info" role="tabpanel"
                                            aria-labelledby="family-address-info-tab" data-content="5">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Annenin Yaşadığı İl</label>
                                                        <select id="mother_city" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            @foreach($cities as $city)
                                                                <option data-id="{{ $city->id }}" value="{{$city->name}}">
                                                                    {{$city->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Babanın Yaşadığı İl</label>
                                                        <select id="father_city" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            @foreach($cities as $city)
                                                                <option data-id="{{ $city->id }}" value="{{$city->name}}">
                                                                    {{$city->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Annenin Yaşadığı İlçe</label>
                                                        <select id="mother_district" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Babanın Yaşadığı İlçe</label>
                                                        <select id="father_district" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Açık Adres</label>
                                                        <input id="parent_address" type="text" class="form-control"
                                                            placeholder="Açık adres giriniz...">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label" for="phone">Aile Cep Telefonu</label>
                                                        <br>
                                                        <input type="tel" id="parent_mobile" class="form-control telinputs"
                                                            placeholder="+90 501 123 5288" style="width:390px ; ">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Aile Ev Telefonu</label>
                                                        <input id="parent_phone" type="text" class="form-control"
                                                            placeholder="Telefon numarası giriniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Aile E-posta Adresi</label>
                                                        <input id="parent_email" type="text" class="form-control"
                                                            placeholder="mail@mail.com">
                                                    </div>
                                                </div>
                                                <div class="urgent">
                                                    <div class="row">
                                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none">
                                                                <path
                                                                    d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z"
                                                                    fill="black" />
                                                            </svg> Acil Durum Kişisi</p>
                                                        <div class="col-md-6 form-group">
                                                            <label class="custom-label">Ad</label>
                                                            <input type="text" class="form-control "
                                                                id="emergency_person_name" placeholder="Adı giriniz..">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="custom-label">Soyad</label>
                                                            <input type="text" class="form-control "
                                                                id="emergency_person_surname"
                                                                placeholder="Soyadı giriniz..">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="custom-label">Yakınlık Derecesi</label>
                                                            <input type="text" class="form-control "
                                                                id="emergency_closeness"
                                                                placeholder="Yakınlık derecesi giriniz..">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="custom-label">Cep Telefonu</label>
                                                            <input type="text" class="form-control telinputs"
                                                                id="emergency_mobile"
                                                                placeholder="Telefon numarası giriniz..">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="custom-label">E-Posta Adresi</label>
                                                            <input type="text" class="form-control "
                                                                placeholder="E-posta adresi giriniz..">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="parent-info" role="tabpanel"
                                            aria-labelledby="parent-info-tab" data-content="6">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Anne Baba Birlikte Mi?</label>
                                                        <select id="parent_together" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="Evet">Evet</option>
                                                            <option value="Hayır">Hayır</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Anne Sağ Mı?</label>
                                                        <select id="mother_alive" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="Evet">Evet</option>
                                                            <option value="Hayır">Hayır</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Baba Sağ Mı?</label>
                                                        <select id="C9l7SUqOxSvZ" name='C9l7SUqOxSvZ' class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="Evet">Evet</option>
                                                            <option value="Hayır">Hayır</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Annenizin Adı</label>
                                                        <input id="mother_name" type="text" class="form-control"
                                                            placeholder="Anne soyadı giriniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Annenizin Soyadı</label>
                                                        <input id="mother_surname" type="text" class="form-control"
                                                            placeholder="Anne soyadı giriniz..">
                                                    </div>

                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Babanızın Adı</label>
                                                        <input id="father_name" type="text" class="form-control"
                                                            placeholder="Baba adı giriniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Babanızın Soyadı</label>
                                                        <input id="father_surname" type="text" class="form-control"
                                                            placeholder="Baba soyadı giriniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Annenin Mesleği</label>
                                                        <input id="mother_job" type="text" class="form-control"
                                                            placeholder="Anne meslek giriniz...">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Babanın Mesleği</label>
                                                        <input id="father_job" type="text" class="form-control"
                                                            placeholder="Baba meslek giriniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Annenin Tahsil Durumu</label>
                                                        <select class="form-select" id="mother_educ">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="İlkokul">İlkokul</option>
                                                            <option value="Ortaokul">Ortaokul</option>
                                                            <option value="Lise">Lise</option>
                                                            <option value="Ön Lisans">Ön Lisans</option>
                                                            <option value="Lisans">Lisans</option>
                                                            <option value="Yüksek Lisans">Yüksek Lisans</option>
                                                            <option value="Doktora">Doktora</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Babanın Tahsil Durumu</label>
                                                        <select class="form-select" id="father_educ">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="İlkokul">İlkokul</option>
                                                            <option value="Ortaokul">Ortaokul</option>
                                                            <option value="Lise">Lise</option>
                                                            <option value="Ön Lisans">Ön Lisans</option>
                                                            <option value="Lisans">Lisans</option>
                                                            <option value="Yüksek Lisans">Yüksek Lisans</option>
                                                            <option value="Doktora">Doktora</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Annenin Bağlı Olduğu Sosyal Güvenlik
                                                            Kurumu</label>
                                                        <select class="form-select" id="mother_company">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="BAĞ-KUR">BAĞ-KUR</option>
                                                            <option value="SGK">SGK</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Babanın Bağlı Olduğu Sosyal Güvenlik
                                                            Kurumu</label>
                                                        <select class="form-select" id="father_company">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="BAĞ-KUR">BAĞ-KUR</option>
                                                            <option value="SGK">SGK</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Kiminle Kalıyorsunuz?</label>
                                                        <input id="WAll7WvDPAjk" type="text" class="form-control"
                                                            placeholder="Kiminle kalıyorsunuz giriniz..">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="sibling-info" role="tabpanel"
                                            aria-labelledby="sibling-info-tab" data-content="7">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Kendisi Dahil Okuyan Kardeş
                                                            Sayısı</label>
                                                        <select name="count" id="count" class="form-select">
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5 ve üzeri">5 ve üzeri</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Kendisi Dahil Kardeş Sayısı</label>
                                                        <input id="educ_count" type="number" class="form-control"
                                                            placeholder="Kardeş sayısını giriniz..">
                                                    </div>

                                                    <button id="kardesEkleBtn" type="button"
                                                        class="btn addFormBtn col-lg-3 col-md-4 col-sm-4 btn-primary mb-3"
                                                        data-bs-toggle="modal" data-bs-target="#kardesEkleModal"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M9.16797 9.16663V4.16663H10.8346V9.16663H15.8346V10.8333H10.8346V15.8333H9.16797V10.8333H4.16797V9.16663H9.16797Z"
                                                                fill="#0065FF" />
                                                        </svg> Kardeş Ekle</button>

                                                    <table class="table table-striped" id="kardesTable">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Adı</th>
                                                                <th>Soyadı</th>
                                                                <th>Yaşı</th>
                                                                <th>Öğrenim Durumu</th>
                                                                <th>Medeni Durumu</th>
                                                                <th>Mesleği (Çalışıyorsa)</th>
                                                                <th>İşlemler</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="income-info" role="tabpanel"
                                            aria-labelledby="income-info-tab" data-content="8">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Ailenin Geçmişini Kim/Kimler
                                                            Sağlıyor?</label>
                                                        <input id="income_person" type="text" class="form-control"
                                                            placeholder="Kişi bilgisi giriniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç
                                                            Kişiye
                                                            Bakıyor?</label>
                                                        <input id="total_person" type="number" class="form-control"
                                                            placeholder="Kişi sayısı giriniz..">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Annenin Aylık Net Geliri (TL)</label>
                                                        <input id="mother_salary" type="text" class="form-control"
                                                            placeholder="Net geliri giriniz...">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Babanın Aylık Net Geliri (TL)</label>
                                                        <input id="father_salary" type="text" class="form-control"
                                                            placeholder="Net geliri giriniz...">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Diğer Kişilerin Aylık Net Geliri
                                                            (TL)</label>
                                                        <input id="other_salary" type="text" class="form-control"
                                                            placeholder="Net geliri giriniz...">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Ailenin Başka Geliri Var Mı?</label>
                                                        <input id="other_income" type="text" class="form-control"
                                                            placeholder="Gelir bilgisi giriniz..">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Ailenin Yaşamakta Olduğu Ev Türü</label>
                                                        <select class="form-select" id="gelirBeyaniEvTuru" required>
                                                            <option selected disabled>Seçiniz...</option>
                                                            <option value="Kendi Evi">Kendi Evi</option>
                                                            <option value="Kiralık">Kiralık</option>
                                                            <option value="Misafir">Misafir</option>
                                                            <option value="Diğer">Diğer</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Kira ise Aylık Net Kirası (TL)</label>
                                                        <input id="rent_count" type="text" class="form-control"
                                                            placeholder="Kira tutarını giriniz..">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label class="custom-label">Diğer</label>
                                                        <input id="other_detail" type="text" class="form-control"
                                                            placeholder="Diğer gelir bilgisi giriniz..">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="other-info" role="tabpanel"
                                            aria-labelledby="other-info-tab" data-content="9">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Devlet Bursu Almakta mı ya da Başvurdu
                                                            mu?</label>
                                                        <select id="government" class="form-select">
                                                            <option selected disabled>Seçiniz...</option>
                                                            <option value="evet">Evet</option>
                                                            <option value="hayır">Hayır</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Özel Burs Almakta ya da Başvurdu
                                                            mu?</label>
                                                        <select id="special" class="form-select">
                                                            <option selected disabled>Seçiniz...</option>
                                                            <option value="evet">Evet</option>
                                                            <option value="hayır">Hayır</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button id="bursEkleBtn" type="button"
                                                    class="btn addFormBtn col-lg-3 col-md-4 col-sm-4 btn-primary mb-3"
                                                    data-bs-toggle="modal" data-bs-target="#bursEkleModal"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M9.16797 9.16663V4.16663H10.8346V9.16663H15.8346V10.8333H10.8346V15.8333H9.16797V10.8333H4.16797V9.16663H9.16797Z"
                                                            fill="#0065FF" />
                                                    </svg> Burs Ekle</button>

                                                <table id="bursTable" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Kurum Adı</th>
                                                            <th>Kurum Türü</th>
                                                            <th> Burs Tutarı</th>
                                                            <th>Seçenekler</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="disabled-info" role="tabpanel"
                                            aria-labelledby="disabled-info-tab" data-content="10">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label class="custom-label">Herhangi Bir Engeliniz Var mı?</label>
                                                        <select id="disabled_detail" class="form-select">
                                                            <option selected disabled>Seçiniz...</option>
                                                            <option value="evet">Evet</option>
                                                            <option value="hayır">Hayır</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label class="custom-label">Engel Durumunu Açıklayınız
                                                            (Varsa)</label>
                                                        <input id="disabled_status" type="text" class="form-control"
                                                            placeholder="Açıklama giriniz..">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="social-info" role="tabpanel"
                                            aria-labelledby="social-info-tab" data-content="11">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Bizden Nasıl Haberdar Oldunuz?</label>
                                                        <select id="platform" class="form-select">
                                                            <option selected disabled>Seçiniz...</option>
                                                            <option value="Sosyal Medya">Sosyal Medya</option>
                                                            <option value="Web Sitesi">Web Sitesi</option>
                                                            <option value="Diğer">Diğer</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Güçlü Yanlarınızın Ne olduğunu
                                                            Düşünüyorsunuz?</label>
                                                        <input id="skills" type="text" class="form-control"
                                                            placeholder="Güçlü yönlerinizden bahsediniz..">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Katkıda Bulunduğunuz Sosyal
                                                            Projeler</label>
                                                        <input id="social_projects" type="text" class="form-control"
                                                            placeholder=" Sosyal proejelerinizden bahsediniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Hobileriniz</label>
                                                        <input id="hobbies" type="text" class="form-control"
                                                            placeholder="Hobilerinizden bahsediniz..">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">İlgilendiğiniz Spor Dalı (Varsa)</label>
                                                        <input id="sports" type="text" class="form-control"
                                                            placeholder="İlgilendiğiniz spor dallarından bahsediniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Son Okuduğunuz Kitaplar</label>
                                                        <input id="last_books" type="text" class="form-control"
                                                            placeholder="Son okuduğunuz kitaplardan bahsediniz..">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label class="custom-label">Bize Mesajınız</label>
                                                        <input id="message" type="text" class="form-control"
                                                            placeholder="Bize mesajınız..">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="account-info" role="tabpanel"
                                            aria-labelledby="account-info-tab" data-content="12">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label class="custom-label">Banka</label>
                                                        <select id="employment-status" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            @foreach($bankNames as $bank)
                                                                <option value="{{$bank}}">{{$bank}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="iban" class="form-label">IBAN</label>
                                                            <input type="text" class="form-control" id="iban"
                                                                placeholder="IBAN numaranızı giriniz.." maxlength="26">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label class="custom-label">Hesap Numarası</label>
                                                            <input id="account_number" type="text" class="form-control"
                                                                placeholder="Hesap numaranızı giriniz..">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="job-info" role="tabpanel"
                                            aria-labelledby="job-info-tab" data-content="13">
                                            <div class="tab-section">
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label class="custom-label">Düzenli olarak bir kurumda kazanç
                                                            sağlıyor
                                                            mu?</label>
                                                        <select id="is_working" class="form-select">
                                                            <option selected disabled value="seçiniz">Seçiniz..</option>
                                                            <option value="Full-time">Evet, tam zamanlı çalışıyor</option>
                                                            <option value="Part-time">Evet, yarı zamanlı çalışıyor</option>
                                                            <option value="Stajyer">Evet, stajyer olarak çalışıyor</option>
                                                            <option value="Hayır">Hayır</option>
                                                            <option value="Diğer">Diğer</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Kurum Adı</label>
                                                        <input id="job_company" type="text" class="form-control"
                                                            placeholder="Kurum adı giriniz..">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Görev</label>
                                                        <input id="job_rank" type="text" class="form-control"
                                                            placeholder="Görev adı giriniz..">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Sosyal Güvenlik Kurumu</label>
                                                        <select class="form-select" id="job_sgk">
                                                            <option value="SGK">SGK</option>
                                                            <option selected value="SGK">SGK</option>
                                                            <option value="BAĞ-KUR">BAĞ-KUR</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="custom-label">Aylık Net Ücret (TL)</label>
                                                        <input id="job_salary" type="text" class="form-control" value="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="document-info" role="tabpanel"
                                            aria-labelledby="document-info-tab" data-content="14">
                                            <div class="tab-section">
                                                <div class="container">
                                                    <div class="row  mb-4">
                                                        <div class="col-md-6 term-select">
                                                            <label for="termSelect" class="form-label">Dönem Seçiniz</label>
                                                            <div class="col-md-12 form-group d-flex align-items-center">
                                                                <select class="form-select me-2" id="termSelect">
                                                                    @foreach(($periods ?? []) as $pOption)
                                                                        <option value="{{ $pOption->id }}">{{ $pOption->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-primary ms-3"
                                                                    onclick="showDocuments()">Göster</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 term-control-select">
                                                            <label for="termControlSelect" class="form-label">Belge
                                                                Kontrol</label>
                                                            <div class="col-md-12 form-group d-flex align-items-center">
                                                                <select class="form-select me-2" id="termControlSelect">
                                                                    @foreach(($periods ?? []) as $pOption)
                                                                        <option value="{{ $pOption->id }}">{{ $pOption->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-primary ms-3"
                                                                    onclick="showDocumentControl()">Göster</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Belge Görüntüle -->
                                                    <div id="documents" class="row d-none">
                                                        <div class="row">
                                                            <div id="uploadContainer" class="row">
                                                                <div class="row mt-3">
                                                                    <!-- Öğrenci Belgesi -->
                                                                    @foreach($belgeler as $doc)
                                                                        @php
                                                                            // Belgeler içindeki her 'Soru' nesnesinin 'db_key' değerini al
                                                                            $dbKey = $doc->db_key;

                                                                        @endphp
                                                                        <div class="col-md-3 col-sm-6">
                                                                            <div class="upload-card">
                                                                                <div class="documents-title-drag-drop">
                                                                                    <p>
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            width="24" height="24"
                                                                                            viewBox="0 0 24 24" fill="none">
                                                                                            <path
                                                                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                                                                fill="#1A1A1A" />
                                                                                        </svg> {{$doc->title}}
                                                                                    </p>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        viewBox="0 0 24 24" fill="none">
                                                                                        <path
                                                                                            d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                                                                            fill="#1A1A1A" />
                                                                                    </svg>
                                                                                </div>

                                                                                <div class="file-drag-drop-area">
                                                                                    <input data-name="{{$dbKey}}"
                                                                                        data-id="{{$dbKey}}" type="file"
                                                                                        id="{{$dbKey}}" hidden=""
                                                                                        @if($dbKey == 'doc_fotograf' || $dbKey == 'fotograf') accept="image/jpeg, image/png, image/jpg" @endif>
                                                                                    <label for="{{$dbKey}}"
                                                                                        class="file-label d-flex align-items-center justify-content-center">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            width="20" height="20"
                                                                                            viewBox="0 0 20 20" fill="none">
                                                                                            <path
                                                                                                d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z"
                                                                                                fill="#2D3648"></path>
                                                                                            <path
                                                                                                d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z"
                                                                                                fill="#2D3648"></path>
                                                                                            <path
                                                                                                d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z"
                                                                                                fill="#2D3648"></path>
                                                                                            <path
                                                                                                d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z"
                                                                                                fill="#2D3648"></path>
                                                                                        </svg>
                                                                                        <div class="text-container">
                                                                                            <p class="mb-0 text-center">Sürükle
                                                                                                ve Bırak<br>veya <u>Dosya
                                                                                                    Seç</u></p>
                                                                                        </div>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="file-info mt-2">
                                                                                    <p>Desteklenen Belgeler: @if($dbKey == 'doc_fotograf' || $dbKey == 'fotograf') jpeg, png, jpg @else jpg, jpeg, png, PDF, Docx @endif</p>
                                                                                    <p>Max Size: 5 MB, 1 Dosya</p>
                                                                                </div>
                                                                                <div id="{{$doc->db_key}}"
                                                                                    data-id="{{$doc->db_key}}"
                                                                                    class="delete-icon">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="15" height="15"
                                                                                        viewBox="0 0 15 15" fill="none">
                                                                                        <path
                                                                                            d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                                                            fill="#F03000"></path>
                                                                                    </svg>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    @endforeach

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Belge Kontrol -->
                                                    <div id="documentControl" class="row d-none">
                                                        <div class="col-md-12">
                                                            <div class="table table-striped">
                                                                <div class="button-container-doc d-flex mb-3">
                                                                    <button class="btn btn-outline-success"
                                                                        onclick="approveSelected()">Toplu Belge
                                                                        Onayla</button>
                                                                    <button class="btn btn-outline-danger ml-2"
                                                                        onclick="rejectSelected()">Toplu Belge
                                                                        Reddet</button>
                                                                </div>
                                                                <table id="documentControlTable">
                                                                    <thead>

                                                                        <tr>
                                                                            <th><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></th>
                                                                            <th>Belge Adı</th>
                                                                            <th>Belge Durumu</th>
                                                                            <th>Onayla</th>
                                                                            <th>Reddet</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="documentList">
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Öğrenci Belgesi</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Adli Sicil Kaydı</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Vukuatlı Nüfus Kayıt Örneği</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Anne Gelir Belgesi</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Baba Gelir Belgesi</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Aydınlatma Metni/Açık Rıza Formu ve
                                                                                Taahhütname</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Kimlik Belgesi (Ön-Arka)</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Banka Hesap Bilgisi (Öğrencinin Kendi Adına)
                                                                            </td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Fotoğraf</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Transkript</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Ailenin İkamet Adresi ve Diğer Adresi
                                                                                Belgesi</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Karne</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input type="checkbox" class="checkbox"
                                                                                    id="masterCheckbox"></td>
                                                                            <td>Diğer Belgeler</td>
                                                                            <td class="status">Onay Bekliyor</td>
                                                                            <td><button class="btn btn-outline-success"
                                                                                    onclick="approveDocument(this)">Belge
                                                                                    Onayla</button></td>
                                                                            <td><button class="btn btn-outline-danger"
                                                                                    onclick="rejectDocument(this)">Belge
                                                                                    Reddet</button></td>

                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="payment-info" role="tabpanel"
                                            aria-labelledby="payment-info-tab" data-content="15">
                                            <div class="tab-section">
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-hover" id="paymentTable">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox" id="selectAll">
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>T.C Kimlik No..</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Okul Tipi </span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Ad</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Soyad</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Dönem</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>IBAN</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Bursveren</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Burs Ayı</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Ödeme Periyodu</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Ödeme Tutarı</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>

                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Ödeme Tarihi</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="dropdown-sort">
                                                                        <span>Öğrenciye Burs Ödeme Tarihi</span>
                                                                        <button class="btn btn-sm dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton8"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path
                                                                                    d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z"
                                                                                    fill="#1A1A1A" />
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton8">
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'asc')">A'dan
                                                                                    Z'ye</a>
                                                                            </li>
                                                                            <li><a class="dropdown-item" href="#"
                                                                                    onclick="sortTable(8, 'desc')">Z'den
                                                                                    A'ya</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="paymentTableBody">
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Ocak</td>
                                                                <td>1. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.01.2019</td>
                                                                <td>19.01.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Şubat</td>
                                                                <td>2. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.02.2019</td>
                                                                <td>19.02.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Mart</td>
                                                                <td>3. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.03.2019</td>
                                                                <td>19.03.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Nisan</td>
                                                                <td>4. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.04.2019</td>
                                                                <td>19.04.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Mayıs</td>
                                                                <td>5. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.05.2019</td>
                                                                <td>19.05.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Haziran</td>
                                                                <td>6. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.06.2019</td>
                                                                <td>19.06.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Temmuz</td>
                                                                <td>7. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.07.2019</td>
                                                                <td>19.07.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Ağustos</td>
                                                                <td>8. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.08.2019</td>
                                                                <td>19.08.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Eylül</td>
                                                                <td>9. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.09.2019</td>
                                                                <td>19.09.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Ekim</td>
                                                                <td>10. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.10.2019</td>
                                                                <td>19.10.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Kasım</td>
                                                                <td>11. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.11.2019</td>
                                                                <td>19.11.2019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="checkbox"
                                                                        id="masterCheckbox">
                                                                </td>
                                                                <td>12357896521</td>
                                                                <td>Ortaokul</td>
                                                                <td>Canan</td>
                                                                <td>Tan</td>
                                                                <td>2018-2019</td>
                                                                <td>TR62 0001 0032 2000 1000 15 56</td>
                                                                <td>Umut Yeşil</td>
                                                                <td>Aralık</td>
                                                                <td>12. Taksit</td>
                                                                <td>750 TL</td>
                                                                <td>19.12.2019</td>
                                                                <td>19.12.2019</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline"
                                            data-content="17">
                                            <div class="tab-section">
                                                <div class="container mt-3">
                                                    <ul class="timeline-member">
                                                        <li class="timeline-item-member">
                                                            <span class="timeline-icon-member badge-green">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path
                                                                        d="M3 19H21V21H3V19ZM13 5.82843V17H11V5.82843L4.92893 11.8995L3.51472 10.4853L12 2L20.4853 10.4853L19.0711 11.8995L13 5.82843Z"
                                                                        fill="white" />
                                                                </svg>
                                                            </span>
                                                            <div class="timeline-content-member">
                                                                <p>Canan Tan, "Aidat Geçmişi" ve "Adli Sicil Kaydı" isimli 2
                                                                    adet
                                                                    <span>belge</span> yükledi.
                                                                </p>
                                                                <div class="d-flex">
                                                                    <div class="p-2 timeline-content-doc">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="../assets/images/excel.svg" alt="">
                                                                            <div class="ml-2">
                                                                                <span>Aidat Geçmişi</span><br>
                                                                                <small>.xlsx • 5 MB</small>
                                                                            </div>
                                                                            <div
                                                                                class="ml-auto timeline-content-icons d-flex">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none">
                                                                                    <path
                                                                                        d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"
                                                                                        fill="#8C8C8C" />
                                                                                </svg>
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none">
                                                                                    <path
                                                                                        d="M3 19H21V21H3V19ZM13 13.1716L19.0711 7.1005L20.4853 8.51472L12 17L3.51472 8.51472L4.92893 7.1005L11 13.1716V2H13V13.1716Z"
                                                                                        fill="#8C8C8C" />
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="p-2 timeline-content-doc">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="../assets/images/word.svg" alt="">
                                                                            <div class="ml-2">
                                                                                <span>Adli Sicil Kaydı</span><br>
                                                                                <small>.doc • 5 MB</small>
                                                                            </div>
                                                                            <div
                                                                                class="ml-auto timeline-content-icons d-flex">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none">
                                                                                    <path
                                                                                        d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"
                                                                                        fill="#8C8C8C" />
                                                                                </svg>
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none">
                                                                                    <path
                                                                                        d="M3 19H21V21H3V19ZM13 13.1716L19.0711 7.1005L20.4853 8.51472L12 17L3.51472 8.51472L4.92893 7.1005L11 13.1716V2H13V13.1716Z"
                                                                                        fill="#8C8C8C" />
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="timeline-date-member">12.12.2023, 11:59</div>
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item-member">
                                                            <span class="timeline-icon-member badge-purple">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                    fill="none">
                                                                    <circle cx="12" cy="12" r="10" stroke="white"
                                                                        stroke-width="2" />
                                                                    <path d="M9 12l2 2 4-4" stroke="white"
                                                                        stroke-width="2" />
                                                                </svg>
                                                            </span>
                                                            <div class="timeline-content-member">
                                                                <p>Yönetici B, Canan Tan isimli bursiyere bir
                                                                    <span>not</span>
                                                                    ekledi.
                                                                </p>
                                                                <div class="d-flex timeline-content-note">
                                                                    <img src="../assets/images/avatar.svg"
                                                                        class="rounded-circle" alt="Profile" width="40px"
                                                                        height="40px">
                                                                    <div class="p-2">
                                                                        <p><strong>Yönetici B.</strong></p>
                                                                        <p>Lorem ipsum dolor sit amet consectetur. Eros
                                                                            scelerisque
                                                                            semper in laoreet habitasse tellus. Euismod
                                                                            scelerisque
                                                                            facilisis facilisi in ligula feugiat. Mauris
                                                                            turpis
                                                                            ut
                                                                            dui et venenatis bibendum augue sollicitudin
                                                                            ridiculus.
                                                                            Commodo quam semper platea libero quis. Id
                                                                            rutrum
                                                                            ullamcorper viverra varius. Nullam ultricies
                                                                            habitant
                                                                            condimentum proin enim sed nibh sem mauris. Enim
                                                                            dictum
                                                                            ipsum augue arcu. Malesuada eu quam magna
                                                                            condimentum
                                                                            diam tincidunt egestas libero. Auctor quisque
                                                                            turpis
                                                                            accumsan nam ornare.</p>
                                                                    </div>
                                                                </div>
                                                                <div class="timeline-date-member">11.12.2023, 11:59</div>
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item-member">
                                                            <span class="timeline-icon-member badge-yellow">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                    fill="none">
                                                                    <circle cx="12" cy="12" r="10" stroke="white"
                                                                        stroke-width="2" />
                                                                    <path d="M9 12l2 2 4-4" stroke="white"
                                                                        stroke-width="2" />
                                                                </svg>
                                                            </span>
                                                            <div class="timeline-content-member">
                                                                <p>Yönetici B, Canan Tan isimli bursiyerin
                                                                    <span>statüsünü</span> aktif
                                                                    bursiyer olarak belirledi.
                                                                </p>
                                                                <div class="timeline-date-member">10.12.2023, 11:59</div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="transfer-modal-footer d-flex justify-content-end g-3 ">
                        <button type="button" class="btn cancel-button" id="prevStep"
                            onclick="location.href='{{route('adaybursiyerler')}}'">Vazgeç</button>
                        <button style="display: none;" type="button" class="btn  btn-outline-primary next-button"
                            id="prevButton">Önceki</button>
                        <button type="button" class="btn btn-primary next-button" id="nextStep">Sonraki</button>
                        <button style="display: none;" type="button" class="btn  btn-primary next-button"
                            id="completeButton" data-bs-toggle="modal"
                            data-bs-target="#scholarshipCompletionModal">Tamamla</button>
                    </div>
                </div>
            </form>
        </main>
        <!--Modal Alanı-->
        <!-- Öğrenci Ekleme Süreci Başarılı Modalı -->
        <div class="modal fade" id="scholarshipCompletionModal" tabindex="-1"
            aria-labelledby="scholarshipCompletionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29" fill="none">
                            <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A" />
                            <rect x="1" y="1" width="28" height="27" rx="9" stroke="white" stroke-width="2" />
                            <path
                                d="M10.535 13.1693C9.7759 12.4356 8.54519 12.4356 7.78611 13.1693C7.02703 13.9031 7.02703 15.0928 7.78611 15.8266L11.6736 19.5845C12.4327 20.3183 13.6634 20.3183 14.4225 19.5845L22.1975 12.0687C22.9566 11.3349 22.9566 10.1452 22.1975 9.41142C21.4384 8.67764 20.2077 8.67764 19.4486 9.41142L13.048 15.5986L10.535 13.1693Z"
                                fill="white" />
                        </svg>
                        <h5 class="mt-3">Yeni öğrenci ekleme işlemi onaylandı!</h5>
                        <p>Öğrenci e-posta ile bilgilendirilecektir</p>
                        <button type="button" id="modalCloseButton" class="btn btn-primary"
                            data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kardeş Ekle Modal -->
        <div class="modal fade" id="kardesEkleModal" tabindex="-1" aria-labelledby="kardesEkleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <h5 class="modal-title mb-3" id="kardesEkleModalLabel">Kardeş Ekle</h5>
                            <p>Kardeş bilgilerini giriniz.</p>
                            <span>Ekle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
                        </div>
                        <form id="addSiblingForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesAdi" class="form-label">Adı</label>
                                    <input type="text" class="form-control" id="kardesAdi" placeholder="Ad giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesSoyadi" class="form-label">Soyadı</label>
                                    <input type="text" class="form-control" id="kardesSoyadi"
                                        placeholder="Soyad giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesYasi" class="form-label">Yaşı</label>
                                    <input type="number" class="form-control" id="kardesYasi" placeholder="Yaş giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                                    <select class="form-select" id="kardesOgrenimDurumu" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Ortaokul</option>
                                        <option>Lise</option>
                                        <option>Lisans</option>
                                        <option>Yüksek Lisans</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu" class=" form-label">Medeni Durum</label>
                                    <select class="form-select" id="kardesMedeniDurumu" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Bekar</option>
                                        <option>Evli</option>
                                        <option>Boşanmış</option>

                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="kardesMeslegi"
                                        placeholder="Meslek giriniz...">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Ekle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kardeş Düzenle Modal -->
        <div class="modal fade" id="kardesDuzenleModal" tabindex="-1" aria-labelledby="kardesDuzenleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="text-center">
                        <h5 class="modal-title mb-3" id="kardesDuzenleModalLabel">Kardeş Düzenle</h5>
                        <p>Kardeş bilgilerini giriniz.</p>
                        <span>Güncelle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
                    </div>
                    <div class="modal-body">
                        <form id="editSiblingForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesAdi" class="form-label">Adı</label>
                                    <input type="text" class="form-control" id="kardesAdi" placeholder="Ad giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesSoyadi" class="form-label">Soyadı</label>
                                    <input type="text" class="form-control" id="kardesSoyadi"
                                        placeholder="Soyad giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesYasi" class="form-label">Yaşı</label>
                                    <input type="text" class="form-control" id="kardesYasi" placeholder="Yaş giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                                    <select class="form-select" id="kardesOgrenimDurumu" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Ortaokul</option>
                                        <option>Lise</option>
                                        <option selected>Lisans</option>
                                        <option>Yüksek Lisans</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu" class=" form-label">Medeni Durum</label>
                                    <select class="form-select" id="kardesMedeniDurumu" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Bekar</option>
                                        <option selected>Evli</option>
                                        <option>Boşanmış</option>

                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="kardesMeslegi"
                                        placeholder="Meslek giriniz...">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Burs Ekle Modal -->
        <div class="modal fade" id="bursEkleModal" tabindex="-1" aria-labelledby="bursEkleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="text-center">
                        <h5 class="modal-title mb-3" id="bursEkleModalLabel">Burs Ekle</h5>
                        <p>Burs bilgilerini giriniz.</p>
                        <span>Ekle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
                    </div>
                    <div class="modal-body">
                        <form id="addBursForm">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="kurumAdi" class="form-label">Burs Aldığınız Kurumun Adı</label>
                                    <input type="text" class="form-control" id="kurumAdi"
                                        placeholder="Kurum adı giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kurumTuru" class="form-label">Kurum Türü</label>
                                    <select class="form-select" id="kurumTuru" required>
                                        <option selected disabled>Seçiniz...</option>
                                        <option value="Devlet">Devlet</option>
                                        <option value="Özel">Özel</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                                    <input type="text" class="form-control" id="bursMıktarı"
                                        placeholder="Örnek Burs Tutarı: 1000">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Ekle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Burs Düzenle Modal -->
        <div class="modal fade" id="bursDuzenleModal" tabindex="-1" aria-labelledby="bursDuzenleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="text-center">
                        <h5 class="modal-title mb-3" id="bursEkleModalLabel">Burs Düzenle</h5>
                        <p>Burs bilgilerini giriniz.</p>
                        <span>Güncelle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
                    </div>
                    <div class="modal-body">
                        <form id="editBursForm">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="kurumAdi" class="form-label">Burs Aldığınız Kurumun Adı</label>
                                    <input type="text" class="form-control" id="kurumAdi"
                                        placeholder="Kurum adı giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kurumTuru" class="form-label">Kurum Türü</label>
                                    <select class="form-select" id="kurumTuru" required>
                                        <option disabled>Seçiniz...</option>
                                        <option value="Devlet">Devlet</option>
                                        <option value="Özel">Özel</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                                    <input type="text" class="form-control" id="bursMıktarı"
                                        placeholder="Örnek Burs Tutarı: 1000">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakat Oluştur Modalı -->
        <div class="modal fade" id="interviewModal" tabindex="-1" aria-labelledby="interviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="interviewModalLabel">Mülakat Oluştur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="interviewForm">
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
                                <input type="text" class="form-control" id="interviewer" placeholder="Yazınız.." required>
                            </div>
                            <button type="submit" class="btn btn-primary">Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Mülakat Oluştur-->
        <div class="modal fade" id="createInterviewModal" tabindex="-1" aria-labelledby="createInterviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <h5 class="modal-title" id="createInterviewModalLabel">Mülakat Oluştur</h5>
                    <div class="modal-body">
                        <div class="form-container1">
                            <form id="interviewForm">
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
                                    <div class="col-md-6 form-group">
                                        <label for="interviewDate">Mülakat Tarihi</label>
                                        <input type="date" class="form-control inputDate"
                                            onfocus="typeChange(this,'text','date')" id="interviewDate"
                                            placeholder="Tarih seçiniz">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="interviewTime">Mülakat Saati</label>
                                        <input type="time" class="form-control" id="interviewTime">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="interviewType">Mülakat Tipi</label>
                                        <select class="form-select" id="interviewType">
                                            <option selected>Seçiniz</option>
                                            <option value="Çevrim içi">Çevrim içi</option>
                                            <option value="Yüz Yüze">Yüz Yüze</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="interviewer">Mülakatı Yapacak Kişi</label>
                                        <input type="text" class="form-control" id="interviewer" placeholder="Yazınız..">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="meetingLink">Toplantı Linki / Adresi</label>
                                        <input type="text" class="form-control" id="meetingLink" placeholder="Yazınız..">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="interviewDescription">Mülakat Açıklaması</label>
                                        <textarea class="form-control" id="interviewDescription" rows="3"
                                            placeholder="Yazınız.."></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn me-3" id="kaydetVeKapatBtns">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none">
                                            <path
                                                d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z"
                                                fill="#4069E5" />
                                        </svg>
                                        Mülakat Oluştur
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakatı Güncelle Modalı -->
        <div class="modal fade" id="updateInterviewModal" tabindex="-1" aria-labelledby="updateInterviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="modal-title" id="updateInterviewModalLabel">Mülakat Düzenle</h5>
                        <p>Yapmak istediğiniz işlemi seçiniz</p>
                        <div class="d-flex">
                            <button type="button" class="btn btn-primary me-3" id="updateInterviewDetails">Mülakat
                                Bilgilerini
                                Güncelle</button>
                            <button type="button" class="btn btn-primary" id="concludeInterview">Mülakat
                                Sonuçlandır</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Mülakat Bilgileri Güncelle Modal -->
        <div class="modal fade" id="interviewDetailsModal" tabindex="-1" aria-labelledby="interviewDetailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <h5 class="modal-title fw-bold" id="interviewDetailsModalLabel">Mülakat Bilgilerini Güncelle</h5>
                    <div class="modal-body">
                        <div class="form-container1">
                            <p class="title fw-bold text-center">Mülakat bilgilerini giriniz</p>
                            <p class="small text-center">Oluştur butonuna bastığınızda aday otomatik olarak
                                bilgilendirilecektir</p>
                            <form id="interviewForm">
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
                                    <div class="col-md-6 form-group">
                                        <label for="interviewDate">Mülakat Tarihi</label>
                                        <input type="date" class="form-control inputDate"
                                            onfocus="typeChange(this,'text','date')" id="interviewDate"
                                            placeholder="Tarih seçiniz">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="interviewTime">Mülakat Saati</label>
                                        <input type="time" class="form-control" id="interviewTime">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="interviewType">Mülakat Tipi</label>
                                        <select class="form-select" id="interviewType">
                                            <option selected>Seçiniz</option>
                                            <option value="Çevrim içi">Çevrim içi</option>
                                            <option value="Yüz Yüze">Yüz Yüze</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="interviewer">Mülakatı Yapacak Kişi</label>
                                        <input type="text" class="form-control" id="interviewer" placeholder="Yazınız..">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="meetingLink">Toplantı Linki / Adresi</label>
                                        <input type="text" class="form-control" id="meetingLink" placeholder="Yazınız..">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="interviewDescription">Mülakat Açıklaması</label>
                                        <textarea class="form-control" id="interviewDescription" rows="3"
                                            placeholder="Yazınız.."></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn me-3" id="kaydetVeKapatBtns">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none">
                                            <path
                                                d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z"
                                                fill="#4069E5" />
                                        </svg>
                                        Mülakat Oluştur
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakat Sonuçlandır Modalı -->
        <div class="modal fade" id="concludeInterviewModal" tabindex="-1" aria-labelledby="concludeInterviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <h5 class="modal-title fw-bold" id="concludeInterviewModalLabel">Mülakat Sonuçlandır</h5>
                    <div class="modal-body">
                        <form id="concludeInterviewForm">
                            <p class="fw-bold text-center">Mülakat sonuçlarını giriniz</p>
                            <p class="text-center mb-3">Güncelle butonuna bastığınızda aday otomatik olarak
                                bilgilendirilecektir</p>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.75 11.25L11.25 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M11.25 11.25L18.75 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <p>Mülakatın neden silindiğini kısaca açıklayınız.</p>
                        <form id="deleteInterviewForm">
                            <div class="mb-3">
                                <textarea class="form-control" id="deleteReason" rows="3" placeholder="Açıklama giriniz.."
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gönder</button>
                        </form>
                        <p class="mt-3">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu ile bilgilendirilecektir!
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Burs Onaylandı Modali -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" fill="#00875A" />
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" stroke="white" stroke-width="2" />
                            <path
                                d="M10.533 13.8859C9.77395 13.1615 8.54324 13.1615 7.78415 13.8859C7.02507 14.6104 7.02507 15.785 7.78415 16.5095L11.6717 20.2197C12.4307 20.9441 13.6615 20.9441 14.4205 20.2197L22.1955 12.7992C22.9546 12.0748 22.9546 10.9002 22.1955 10.1757C21.4365 9.45127 20.2057 9.45127 19.4467 10.1757L13.0461 16.2844L10.533 13.8859Z"
                                fill="white" />
                        </svg>
                        <h5 class="mt-3">Burs onalayanacak ve öğrenci bursiyerler alanına taşınacaktır.</h5>
                        <span>Onaylıyor musunuz?</span>
                        <p>Aday mesaj ve e-posta yolu ile bilgilendirilecektir.</p>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                        <button type="button" class="btn btn-outline-success" id="confirmbtn" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16658C11.8423 9.16658 13.334 7.67492 13.334 5.83325C13.334 3.99158 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99158 6.66732 5.83325C6.66732 7.67492 8.15898 9.16658 10.0007 9.16658ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z"
                                    fill="#006644" />
                            </svg>
                            Burs Onay
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Başvuru Reddet Modalı -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.75 11.25L11.25 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M11.25 11.25L18.75 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <h5 class="mt-3">Burs başvurusu reddedilecektir.</h5>
                        <p>Onaylıyor musunuz?</p>
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
                        <div class="d-flex">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                            <button type="button" class="btn btn-outline-danger" id="deniedbtn" data-bs-dismiss="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none">
                                    <path
                                        d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z"
                                        fill="#A82200" />
                                </svg>
                                Burs Ret
                            </button>
                        </div>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path
                                d="M15 27.5C8.09644 27.5 2.5 21.9035 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9035 2.5 27.5 8.09644 27.5 15C27.5 21.9035 21.9035 27.5 15 27.5ZM13.75 18.75V21.25H16.25V18.75H13.75ZM13.75 8.75V16.25H16.25V8.75H13.75Z"
                                fill="#636363" />
                        </svg>
                        <h5 class="mt-3">Burs başvurusu iade edilecektir.</h5>
                        <p>Onaylıyor musunuz?</p>
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
                        <div class="d-flex">
                            <button type="button" class="btn btn-outline-secondary me-3"
                                data-bs-dismiss="modal">Vazgeç</button>
                            <button type="button" class="btn btn-outline-dark" id="toReturnbtn" data-bs-dismiss="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none">
                                    <path
                                        d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.4888 14.1666L13.9652 12.6429L15.1437 11.4644L18.6792 14.9999L15.1437 18.5354L13.9652 17.3569L15.4888 15.8333H12.5007V14.1666H15.4888Z"
                                        fill="#1A1A1A" />
                                </svg>
                                Başvuru İade
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Belge Modal -->
        <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentModalLabel">Belge</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe src="../assets/images/pdf.pdf" frameborder="0" style="width: 100%; height: 500px;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- Silme Onay Modali -->
        <div class="modal fade" id="documentDeleteConfirmModal" tabindex="-1"
            aria-labelledby="documentDeleteConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.75 11.25L11.25 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M11.25 11.25L18.75 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <h5 class="modal-title text-center fw-bold mt-3" id="documentDeleteConfirmModalLabel">Belgeyi Sil
                        </h5>
                        <p class="text-center mt-3">Bu belgeyi silmek istediğinizden emin misiniz?</p>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Sil</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakat oluşturulamaz Modal -->
        <div class="modal fade" id="newStudentWarningModal" tabindex="-1" aria-labelledby="newStudentWarningModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newStudentWarningModalLabel">Uyarı</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Öğrenci henüz yeni eklendiği için işlem gerçekleştirilemez.
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tamam</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- reddetme başarılı Modal -->
        <div class="modal fade" id="deniedbtnModal" tabindex="-1" aria-labelledby="deniedbtnModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" fill="#00875A" />
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" stroke="white" stroke-width="2" />
                            <path
                                d="M10.533 13.8859C9.77395 13.1615 8.54324 13.1615 7.78415 13.8859C7.02507 14.6104 7.02507 15.785 7.78415 16.5095L11.6717 20.2197C12.4307 20.9441 13.6615 20.9441 14.4205 20.2197L22.1955 12.7992C22.9546 12.0748 22.9546 10.9002 22.1955 10.1757C21.4365 9.45127 20.2057 9.45127 19.4467 10.1757L13.0461 16.2844L10.533 13.8859Z"
                                fill="white" />
                        </svg>
                        <h5 class="mt-3">Burs başvurusu başarıyla reddedildi!</h5>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onaylama başarılı Modal -->
        <div class="modal fade" id="approvedModal" tabindex="-1" aria-labelledby="approvedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" fill="#00875A" />
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" stroke="white" stroke-width="2" />
                            <path
                                d="M10.533 13.8859C9.77395 13.1615 8.54324 13.1615 7.78415 13.8859C7.02507 14.6104 7.02507 15.785 7.78415 16.5095L11.6717 20.2197C12.4307 20.9441 13.6615 20.9441 14.4205 20.2197L22.1955 12.7992C22.9546 12.0748 22.9546 10.9002 22.1955 10.1757C21.4365 9.45127 20.2057 9.45127 19.4467 10.1757L13.0461 16.2844L10.533 13.8859Z"
                                fill="white" />
                        </svg>
                        <h5 class="mt-3">Burs başvurusu başarıyla onaylandı!</h5>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- İade başarılı Modal -->
        <div class="modal fade" id="toReturnbtnModal" tabindex="-1" aria-labelledby="toReturnbtnModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" fill="#00875A" />
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" stroke="white" stroke-width="2" />
                            <path
                                d="M10.533 13.8859C9.77395 13.1615 8.54324 13.1615 7.78415 13.8859C7.02507 14.6104 7.02507 15.785 7.78415 16.5095L11.6717 20.2197C12.4307 20.9441 13.6615 20.9441 14.4205 20.2197L22.1955 12.7992C22.9546 12.0748 22.9546 10.9002 22.1955 10.1757C21.4365 9.45127 20.2057 9.45127 19.4467 10.1757L13.0461 16.2844L10.533 13.8859Z"
                                fill="white" />
                        </svg>
                        <h5 class="mt-3">Burs başvurusu başarıyla iade edildi!</h5>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.js.toastr')

    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>
        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/direct-buttons.js"></script>
        <script src="{{url('')}}/assets/js/registration.renewal.js"></script>
        <script src="{{url('')}}/assets/js/components/personCard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="{{url('')}}/assets/js/select-type.js"></script>
        <script src="{{url('')}}/assets/js/income.js"></script>
        <script src="{{url('')}}/assets/js/document-control.js"></script>
        <script src="{{url('')}}/assets/js/components/detail-forms.js"></script>

        @include('panel.add-scholarship-manuel.scriptf')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showDocuments();
            });

            function showDocuments() {
                document.getElementById('documents').classList.remove('d-none');
                document.getElementById('documentControl').classList.add('d-none');
            }

            function showDocumentControl() {
                document.getElementById('documents').classList.add('d-none');
                document.getElementById('documentControl').classList.remove('d-none');
            }

            document.getElementById('showDocumentsBtn').addEventListener('click', showDocuments);
            document.getElementById('showDocumentControlBtn').addEventListener('click', showDocumentControl);

        </script>
        <script>

            // Delete icon'a tıklanma olayını dinleyin
            const deleteIcons = document.querySelectorAll('.delete-icon');
            deleteIcons.forEach(icon => {
                icon.addEventListener('click', function (e) {
                    const id = e.currentTarget.getAttribute('data-id');
                    const input = document.querySelector(`input[data-id="${id}"]`);
                    const label = input.nextElementSibling;
                    const textContainer = label.querySelector('.text-container');
                    const svgIcon = label.querySelector('svg');

                    // Input'u temizle
                    input.value = '';

                    // Varsayılan label içeriğini geri yükle
                    textContainer.innerHTML = `<p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>`;
                    svgIcon.style.display = 'block'; // SVG ikonunu tekrar göster
                });
            });
            document.addEventListener("DOMContentLoaded", function () {
                const fileInputs = document.querySelectorAll('input[type="file"]');

                fileInputs.forEach(input => {
                    input.addEventListener('change', function (e) {
                        const file = e.target.files[0];
                        if (file) {
                            const label = e.target.nextElementSibling;
                            const svgIcon = label.querySelector('svg');
                            const textContainer = label.querySelector('.text-container');
                            const id = e.target.getAttribute('data-id'); // input'taki data-id değerini al


                            // Update the label text
                            textContainer.innerHTML = `<div class="file-uploaded-document d-flex justify-content-around"
                        data-bs-toggle="modal" data-bs-target="#documentModal">

                        <div data-id='${id}' class="file-preview" id="deleteButton">
                            <div class="icon-container w-100">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="13" height="13" viewBox="0 0 13 13"
                                    fill="none">
                                    <rect width="12" height="12" rx="6" fill="#00875A" />
                                    <path d="M4.56484 5.90345C4.2359 5.57452 3.70259 5.57452 3.37365 5.90345C3.04472 6.23239 3.04472 6.7657 3.37365 7.09463L5.05824 8.77922C5.38717 9.10815 5.92048 9.10815 6.24942 8.77922L9.61858 5.41005C9.94752 5.08111 9.94752 4.5478 9.61858 4.21887C9.28965 3.88993 8.75634 3.88993 8.4274 4.21887L5.65383 6.99245L4.56484 5.90345Z" fill="white" />
                                </svg>
                            </div>
                        </div>
                    </div>`;

                            // Optionally, you could replace the SVG icon with another if desired
                            svgIcon.style.display = 'none'; // Hide the default icon
                        }
                    });
                });
            });




            function getDistricts(a, districtSelectId) {
                var cityId = a.options[a.selectedIndex].getAttribute('data-id');

                // AJAX çağrısı
                $.ajax({
                    url: '/get-districts/' + cityId,
                    type: 'GET',
                    success: function (data) {
                        var districtSelect = document.getElementById(districtSelectId);
                        districtSelect.innerHTML = ''; // Eski verileri temizle
                        var secinizoption = document.createElement('option');
                        secinizoption.value = '';
                        secinizoption.text = 'Seçiniz';
                        districtSelect.appendChild(secinizoption);
                        // Dönen ilçeleri select içerisine ekleme
                        data.forEach(function (district) {
                            var option = document.createElement('option');
                            option.value = district.isim; // district.id ile değiştirilmiş ID değeri
                            option.text = district.isim; // district.isim ile ilçe ismi
                            districtSelect.appendChild(option);
                        });
                    }
                });
            }

        </script>

    @endsection