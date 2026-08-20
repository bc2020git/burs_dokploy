@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yönetici Paneli
@endsection
@section('local-css')
    <style>
        .menu-container {
            display: flex;
            flex-wrap: wrap;
        }

        .custom-nav-item {
            margin-right: 10px;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown.show .dropdown-menu {
            display: block;
        }

        .table-check th,
        .table-check td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dcdcdc;
        }

    #pointsList{
        overflow-y: auto;
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">

@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <form action="{{route('new-relation-profile-form')}}" id="basvuruForm" method="post" enctype="multipart/form-data" > @csrf
                <div class=" mt-1">
                    <div class="navbar-button-container">
                        <button type="button" class="btn btn-outline-primary" id="kaydetVeKapatBtn">
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
                        <button type="button" class="btn btn-primary text-white ms-2" data-bs-toggle="modal" data-bs-target="#mulakatAtaModal">
                            Mülakat Ata
                        </button>
                        <button type="button" class="btn btn-outline-success" id="confirm" data-bs-toggle="modal" data-bs-target="#successModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16658C11.8423 9.16658 13.334 7.67492 13.334 5.83325C13.334 3.99158 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99158 6.66732 5.83325C6.66732 7.67492 8.15898 9.16658 10.0007 9.16658ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z"
                                    fill="#006644" />
                            </svg>
                            Burs Onay
                        </button>

                        <button type="button" class="btn btn-outline-danger" id="denied" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z" fill="#A82200"></path>
                            </svg>
                            Burs Ret
                        </button>
                        <button type="button" class="btn btn-outline-dark" id="toReturn" data-bs-toggle="modal"
                                data-bs-target="#missingDocumentModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.4888 14.1666L13.9652 12.6429L15.1437 11.4644L18.6792 14.9999L15.1437 18.5354L13.9652 17.3569L15.4888 15.8333H12.5007V14.1666H15.4888Z"
                                    fill="#1A1A1A" />
                            </svg>
                            Başvuru İade
                        </button>
                        <button type="button" class="btn btn-primary text-white" id="createInterview" data-bs-toggle="modal"
                                data-bs-target="#createInterviewModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7.5013 0.833008V2.49967H12.5013V0.833008H14.168V2.49967H17.5013C17.9616 2.49967 18.3346 2.87277 18.3346 3.33301V16.6663C18.3346 17.1266 17.9616 17.4997 17.5013 17.4997H2.5013C2.04107 17.4997 1.66797 17.1266 1.66797 16.6663V3.33301C1.66797 2.87277 2.04107 2.49967 2.5013 2.49967H5.83464V0.833008H7.5013ZM16.668 9.16634H3.33464V15.833H16.668V9.16634ZM5.83464 4.16634H3.33464V7.49967H16.668V4.16634H14.168V5.83301H12.5013V4.16634H7.5013V5.83301H5.83464V4.16634Z"
                                      fill="white" />
                            </svg>
                            Mülakat Oluştur
                        </button>
                        <x-application-form-modal
                            :candidate="$aday"
                            :siblings="$aday->kardesler"
                            :scholarships="$aday->scholars"
                            :foto_url="$aday->doc_fotograf"
                        />
                        <a href="{{route('getScholarMailForm',['eposta'=>$aday->email])}}">
                        <button type="button" class="btn me-3 btn-outline-info" id="mail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M2.5 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.5C2.03976 17.5 1.66666 17.1269 1.66666 16.6667V3.33333C1.66666 2.8731 2.03976 2.5 2.5 2.5ZM16.6667 6.0316L10.0598 11.9483L3.33333 6.01328V15.8333H16.6667V6.0316ZM3.75955 4.16667L10.0516 9.71833L16.2508 4.16667H3.75955Z"
                                    fill="#8353E2" />
                            </svg>
                            E-Posta
                        </button>
                        </a>
                        <button type="button" class="btn me-3 btn-outline-warning" id="sms" data-tel="{{$aday->tel_no}}" data-name="{{$aday->name}}" data-surname="{{$aday->surname}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M4.80235 14.1667H16.6667V4.16667H3.33333V15.3209L4.80235 14.1667ZM5.37879 15.8333L1.66667 18.75V3.33333C1.66667 2.8731 2.03977 2.5 2.5 2.5H17.5C17.9603 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9603 15.8333 17.5 15.8333H5.37879Z" fill="#FF8B00" />
                            </svg>
                            SMS
                        </button>
                        <a href="{{route('deletenewrelation',['id'=>$aday->id])}}">
                            <button type="button" class="btn btn-outline-primary" id="waste">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path
                                        d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                        fill="#4069E5" />
                                </svg>
                            </button>
                        </a>
                        <button type="button" class="btn btn-outline-primary" id="waste">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M16.6667 2.5C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5H16.6667ZM9.16667 10.8333H4.16667V15.8333H9.16667V10.8333ZM10.8333 15.8333H15.8333V4.16667H10.8333V15.8333ZM9.16667 4.16667H4.16667V9.16667H9.16667V4.16667Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="reload" data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                                <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z" fill="#4069E5"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="scroll">
                                <ul class="nav nav-tabs d-flex flex-nowrap custom-nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link active custom-nav-link" id="general-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#general-info" type="button" role="tab" aria-controls="general-info"
                                                aria-selected="true" data-target="1">Genel Bilgiler</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="personal-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#personal-info" type="button" role="tab"
                                                aria-controls="personal-info" aria-selected="false" data-target="2">Kişisel
                                            Bilgiler</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="education-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#education-info" type="button" role="tab"
                                                aria-controls="education-info" aria-selected="false" data-target="3">Eğitim
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="place-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#place-info" type="button" role="tab" aria-controls="place-info"
                                                aria-selected="false" data-target="4">Kalınan Yer Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="family-address-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#family-address-info" type="button" role="tab"
                                                aria-controls="family-address-info" aria-selected="false" data-target="5">Aile Adres
                                            Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link " id="parent-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#parent-info" type="button" role="tab" aria-controls="parent-info"
                                                aria-selected="false" data-target="6">Ebeveyn Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="sibling-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#sibling-info" type="button" role="tab" aria-controls="sibling-info"
                                                aria-selected="false" data-target="7">Kardeş Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="income-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#income-info" type="button" role="tab" aria-controls="income-info"
                                                aria-selected="false" data-target="8">Gelir Beyanı</button>
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
                                                data-bs-target="#social-info" type="button" role="tab" aria-controls="social-info"
                                                aria-selected="false" data-target="11">Sosyal Bilgileri</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="account-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#account-info" type="button" role="tab" aria-controls="account-info"
                                                aria-selected="false" data-target="12">Hesap Bilgileri</button>
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
                                            Yükleme</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="interview-info-tab" data-bs-toggle="tab"
                                                data-bs-target="#interview-info" type="button" role="tab"
                                                aria-controls="interview-info" aria-selected="false"
                                                data-target="15">Mülakatlar</button>
                                    </li>
                                    <li class="nav-item custom-nav-item" role="presentation">
                                        <button class="nav-link custom-nav-link" id="timeline" data-bs-toggle="tab" data-bs-target="#timeline"
                                                type="button" role="tab" aria-controls="timeline" aria-selected="false"
                                                data-target="16">Zaman Çizelgesi</button>
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
                                        @php $fotografPath = null; $fotografPath = $aday->doc_fotograf;@endphp
                                </div>
                                        <img  src="{{ $fotografPath ? url($fotografPath) : '../../assets/images/default-profile.svg' }}" alt="Profile Photo" class=" rounded-circle personcard-img img-fluid">

                                <div class="profile-info">
                                    <h6>{{$aday->name}} {{$aday->surname}}</h6>
                                    <p>Aday Bursiyer</p>

                                    <div class="profile-icons d-flex justify-content-center">
                                        <a href="{{route('getScholarMailForm',['eposta'=>$aday->email])}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.49996C2.03973 17.5 1.66663 17.1269 1.66663 16.6667V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5ZM16.6666 6.0316L10.0598 11.9483L3.33329 6.01328V15.8333H16.6666V6.0316ZM3.75951 4.16667L10.0515 9.71833L16.2508 4.16667H3.75951Z"
                                                fill="#0052CC" />
                                        </svg>
                                        </a>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M4.80231 14.1667H16.6666V4.16667H3.33329V15.3209L4.80231 14.1667ZM5.37875 15.8333L1.66663 18.75V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9602 15.8333 17.5 15.8333H5.37875Z"
                                                fill="#0052CC" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4317C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                                fill="#0052CC" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="profile-tabs mt-3">
                                    <button class="tab-button" id="aboutButton">Hakkında</button>
                                    <button class="tab-button" id="notesButton">Notlar</button>
                                    @if(Auth::user()->hasPermission('aday-puanlarini-goruntule'))
                                    <button class="tab-button" id="pointsButton">Puanlar</button>
                                    @endif

                                </div>
                                <div id="aboutContent">
                                    <div class="profile-details">
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z"
                                                            fill="#00875A" />
                                                    </svg>Burs Durumu:</strong> <span id="bursDurumu" class="bursiyerStatusu">Aday Bursiyer</span></p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z"
                                                            fill="#0052CC" />
                                                    </svg>Başvuru Durumu:</strong> <span class="basvuruDurumu ">
                                                        @switch($aday->status)
                                                        @case(1) Onay Bekliyor @break
                                                        @case(4) Reddedildi @break
                                                        @case(3) Onaylandı @break
                                                        @case(2) Iade Edildi @break
                                                        @case(5) İadeden Döndü  @break
                                                        @case(0) Devam Ediyor @break
                                                        @endswitch</span></p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M2.50004 5.00004H17.5V15H2.50004V5.00004ZM1.66671 3.33337C1.20647 3.33337 0.833374 3.70647 0.833374 4.16671V15.8334C0.833374 16.2936 1.20647 16.6667 1.66671 16.6667H18.3334C18.7936 16.6667 19.1667 16.2936 19.1667 15.8334V4.16671C19.1667 3.70647 18.7936 3.33337 18.3334 3.33337H1.66671ZM10.8334 6.66671H15.8334V8.33337H10.8334V6.66671ZM15 10H10.8334V11.6667H15V10ZM8.75004 8.33337C8.75004 9.48396 7.8173 10.4167 6.66671 10.4167C5.51612 10.4167 4.58337 9.48396 4.58337 8.33337C4.58337 7.18278 5.51612 6.25004 6.66671 6.25004C7.8173 6.25004 8.75004 7.18278 8.75004 8.33337ZM6.66671 11.25C5.05587 11.25 3.75004 12.5559 3.75004 14.1667H9.58337C9.58337 12.5559 8.27754 11.25 6.66671 11.25Z"
                                                            fill="#FFAB00" />
                                                    </svg>Başvuru Puanı:</strong> {{$aday->totalPoints}}</p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="#8353E2">
                                                        <path d="M2.50004 5.00004H17.5V15H2.50004V5.00004ZM1.66671 3.33337C1.20647 3.33337 0.833374 3.70647 0.833374 4.16671V15.8334C0.833374 16.2936 1.20647 16.6667 1.66671 16.6667H18.3334C18.7936 16.6667 19.1667 16.2936 19.1667 15.8334V4.16671C19.1667 3.70647 18.7936 3.33337 18.3334 3.33337H1.66671ZM10.8334 6.66671H15.8334V8.33337H10.8334V6.66671ZM15 10H10.8334V11.6667H15V10ZM8.75004 8.33337C8.75004 9.48396 7.8173 10.4167 6.66671 10.4167C5.51612 10.4167 4.58337 9.48396 4.58337 8.33337C4.58337 7.18278 5.51612 6.25004 6.66671 6.25004C7.8173 6.25004 8.75004 7.18278 8.75004 8.33337ZM6.66671 11.25C5.05587 11.25 3.75004 12.5559 3.75004 14.1667H9.58337C9.58337 12.5559 8.27754 11.25 6.66671 11.25Z"
                                                            fill="#FFAB00" />
                                                    </svg>Uyruk:</strong> @if(isset($aday->nationality)){{$aday->nationality}} @endif</p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M10 19.7732L4.6967 14.47C1.76777 11.541 1.76777 6.79226 4.6967 3.86333C7.62563 0.934393 12.3743 0.934393 15.3033 3.86333C18.2323 6.79226 18.2323 11.541 15.3033 14.47L10 19.7732ZM14.1248 13.2914C16.4028 11.0134 16.4028 7.31989 14.1248 5.04183C11.8468 2.76378 8.15327 2.76378 5.87521 5.04183C3.59715 7.31989 3.59715 11.0134 5.87521 13.2914L10 17.4162L14.1248 13.2914ZM10 10.8333C9.0795 10.8333 8.33333 10.0871 8.33333 9.16663C8.33333 8.24615 9.0795 7.49996 10 7.49996C10.9205 7.49996 11.6667 8.24615 11.6667 9.16663C11.6667 10.0871 10.9205 10.8333 10 10.8333ZM10 9.16663C8.15898 9.16663 6.66732 10.6583 6.66732 12.5C6.66732 14.3417 8.15898 15.8333 10 15.8333C11.8423 15.8333 13.334 14.3417 13.334 12.5C13.334 10.6583 11.8423 9.16663 10 9.16663ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z"
                                                            fill="#F03000" />
                                                    </svg>Adresi:</strong> @if(isset($aday->address_detail)) {{$aday->address_detail}}@endif</p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.49996C2.03973 17.5 1.66663 17.1269 1.66663 16.6667V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5ZM16.6666 6.0316L10.0598 11.9483L3.33329 6.01328V15.8333H16.6666V6.0316ZM3.75951 4.16667L10.0515 9.71833L16.2508 4.16667H3.75951Z"
                                                            fill="#4069E5" />
                                                    </svg>Email:</strong> @if(isset($aday->email)){{$aday->email}} @endif</p>
                                            <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4317C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                                            fill="#8353E2" />
                                                    </svg>Cep:</strong> @if(isset($aday->tel_no)){{$aday->tel_no}} @endif</p>
                                            <p><strong>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M17.5 16.6667H19.1667V18.3334H0.833374V16.6667H2.50004V2.50002C2.50004 2.03979 2.87314 1.66669 3.33337 1.66669H16.6667C17.127 1.66669 17.5 2.03979 17.5 2.50002V16.6667ZM15.8334 16.6667V3.33335H4.16671V16.6667H15.8334ZM6.66671 9.16669H9.16671V10.8334H6.66671V9.16669ZM6.66671 5.83335H9.16671V7.50002H6.66671V5.83335ZM6.66671 12.5H9.16671V14.1667H6.66671V12.5ZM10.8334 12.5H13.3334V14.1667H10.8334V12.5ZM10.8334 9.16669H13.3334V10.8334H10.8334V9.16669ZM10.8334 5.83335H13.3334V7.50002H10.8334V5.83335Z"
                                                            fill="#00BDD6" />
                                                    </svg>Öğrenim Türü</strong> @if(isset($aday->educationType)){{$aday->educationType}}@endif</p>


                                            <p><strong>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z"
                                                            fill="#00875A" />
                                                </svg>
                                                    İşlemi Yapan
                                                </strong> {{$aday->islemi_yapan}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="notesContent" style="display: none;">
                                    <button class="btn btn-primary mb-3" id="addNoteButton">Not Ekle</button>
                                    <div id="notesList">
                                        <!-- Notlar buraya eklenecek -->
                                        @foreach($aday->notes as $note)
                                            <div class="note d-flex flex-column timeline-content-note">
                                                <div class="d-flex justify-content-between flex-row">
                                                    <h5 class='text-capitalize font-weight-bold' >{{ $note->title }}</h5>
                                                    <p class='text-muted' >{{ $note->created_at->format('d.m.Y') }}</p>
                                                </div>
                                                <p>{{ $note->text }}</p>
                                                <div class="btn btn-danger btn-sm" onclick="location.href='{{route('panel.deleteNote',['id'=>$note->id])}}'">Sil</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @if(Auth::user()->hasPermission('aday-puanlarini-goruntule'))
                                <div id="pointsContent" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center my-3">
                                        <h6>Puan Detayları</h6>
                                        <button type="button" class="btn btn-primary btn-sm" id="recalculatePointsBtn" data-aday-id="{{$aday->id}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M8 0C3.58 0 0 3.58 0 8s3.58 8 8 8c4.42 0 8-3.58 8-8s-3.58-8-8-8zm3.83 4.83l-4.24 4.24-1.77-1.77L4.41 8.71l3.18 3.18 5.66-5.66L11.83 4.83z" fill="white"/>
                                            </svg>
                                             Yeniden Hesapla
                                        </button>
                                    </div>
                                    <div id="pointsList">
                                        @php $toplampuan = 0; @endphp
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Soru</th>
                                                    <th>Cevap</th>
                                                    <th>Puan</th>
                                                    <th>İşlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        @foreach($aday->points as $point)
                                                <tr>
                                                    <td>{{ $point->soru }}</td>
                                                    <td>{{ $point->cevap }}</td>
                                                    <td>{{ $point->puan }}</td>
                                                    <td><div class="btn btn-danger btn-sm" onclick="location.href='{{route('panel.deletePoint',['id'=>$point->id])}}'">Sil</div></td>
                                                </tr>
                                                @php $toplampuan += $point->puan; @endphp
                                        @endforeach
                                                <tr>
                                                    <td></td>
                                                    <td>Toplam Puan</td>
                                                    <td>{{$toplampuan}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <span class="text-danger">Silme işlemi sadece bilgilendirme tablosunu etkiler. Adayın toplam puanını etkilemez. </span>
                                    </div>
                                </div>
                                @endif
                        </div>
                        <div class="form-container col-md-8">
                            <div class="mt-1">
                                <input type="hidden" id="adayId" value="{{$aday->id}}" >
                                <input type="hidden" id="adayid" value="{{$aday->id}}" >
                                <input type="hidden" id="educationType" name='educationType' value="{{$aday->educationType}}" >
                                <div class="tab-content" id="myTabContent">
                                    @include('panel.student-forms.general-infos')
                                    @include('panel.student-forms.personal-infos')
                                    @include('panel.student-forms.educational-infos')
                                    @include('panel.student-forms.housing-infos')
                                    @include('panel.student-forms.family-address-infos')
                                    @include('panel.student-forms.parent-infos')
                                    @include('panel.student-forms.sibling-infos')
                                    @include('panel.student-forms.income-infos')
                                    @include('panel.student-forms.scholars-infos')
                                    @include('panel.student-forms.disabled-infos')
                                    @include('panel.student-forms.social-infos')
                                    @include('panel.student-forms.account-infos')
                                    @include('panel.student-forms.job-infos')
                                    @include('panel.student-forms.documents')
                                    <div class="tab-pane fade" id="interview-info" role="tabpanel"
                                         aria-labelledby="interview-info-tab" data-content="15">
                                        <div class="tab-section">
                                            <div class="form-container1">
                                                <form method="post"  id="interviewFormstep"> @csrf
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label for="interviewDate">Mülakat Tarihi</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control inputDate" id="dob" placeholder="Tarih seçiniz">
                                                                <div class="input-group-append no-border">
                                                                <span class="input-group-text no-border" id="dobIcon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="24" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                                        <path d="M14 4h-1V2.5a.5.5 0 0 0-1 0V4H4V2.5a.5.5 0 0 0-1 0V4H2a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM1 6a1 1 0 0 1 1-1h1v.5a.5.5 0 0 0 1 0V5h8v.5a.5.5 0 0 0 1 0V5h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6zm1 2v5h12V8H2z"/>
                                                                    </svg>
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="interviewTime">Mülakat Saati</label>
                                                            <input type="time" class="form-control" id="stepinterviewTime">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label for="interviewType">Mülakat Tipi</label>
                                                            <select class="form-select" id="stepinterviewType">
                                                                <option selected>Seçiniz</option>
                                                                <option value="Çevrim içi">Çevrim içi</option>
                                                                <option value="Yüz Yüze">Yüz Yüze</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="stepinterviewer">Mülakatı Yapacak Kişi</label>
                                                            <select id="stepinterviewer" name="person" class="form-select" id="interviewer">
                                                                <option selected>Seçiniz</option>
                                                                @foreach($mulakatGruplar as $mulakatGrup)
                                                                    <option value="{{ $mulakatGrup->id }}">{{ $mulakatGrup->name }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label for="stepinterviewLocation">Toplantı Linki /
                                                                Adresi</label>
                                                            <input type="text" class="form-control"
                                                                   id="stepinterviewLocation" placeholder="Yazınız..">
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label for="stepinterviewdetail">Mülakat Açıklaması</label>
                                                            <input type="textarea" class="form-control"
                                                                   id="stepinterviewdetail" placeholder="Yazınız..">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <button type="button" class="btn me-3" id="saveinterview">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                 viewBox="0 0 20 20" fill="none">
                                                                <path
                                                                    d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z"
                                                                    fill="#4069E5" />
                                                            </svg>
                                                            Mülakat Oluştur
                                                        </button>
                                                    </div>



                                                </form>
                                            </div>
                                            <div class="table-container">
                                                <h5 class="mt-5">Mülakat Geçmişi</h5>
                                                <table class="table table-bordered" id="interviewHistoryTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Mülakat Tarihi</th>
                                                        <th>Mülakat Saati</th>
                                                        <th>Mülakat Tipi</th>
                                                        <th>Adres/Link</th>
                                                        <th>Mülakatı Yapan/Yapacak Kişi</th>
                                                        <th>Mülakat Puanı</th>
                                                        <th>Mülakat Sonucu</th>
                                                        <th>İşlemler</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="interviewHistory">
                                                    @foreach($aday->interviews as $interview)
                                                        <tr data-interviewId="{{$interview->id}}">

                                                        <td>{{$interview->interview_date}}</td>
                                                            <td>{{$interview->interview_time}}</td>
                                                            <td>{{$interview->interview_platform}}</td>
                                                            <td>{{$interview->interview_address}}</td>
                                                            <td>{{$interview->group->name}}</td>
                                                            <td>@if($interview->interview_score){{$interview->interview_score}}@else N/A @endif</td>
                                                            <td>@if($interview->interview_result == 'Olumlu') <span class="status-box-success">Olumlu</span> @endif @if($interview->interview_result == 'Olumsuz') <span class="status-box-danger">Olumsuz</span>  @endif @if($interview->interview_result  == 'Planlandı') <span class="status-box-warning">Planlandı</span>  @endif</td>
                                                            <td>
                                                                <a data-date="{{$interview->interview_date}}"
                                                                   data-time="{{$interview->interview_time}}"
                                                                   data-platform="{{$interview->interview_platform}}"
                                                                   data-person="{{$interview->group->name}}"
                                                                   data-person-id="{{$interview->interview_person}}"
                                                                   data-address="{{$interview->interview_address}}"
                                                                   data-id="{{$interview->id}}"
                                                                   class="btn edit-interview-info-btn"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#interviewDetailsModal">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                                                        <path d="M4.5434 11.2552L11.7274 4.07118L10.7257 3.06944L3.54167 10.2535V11.2552H4.5434ZM5.1302 12.6719H2.125V9.66662L10.2248 1.56684C10.5015 1.29022 10.9499 1.29022 11.2265 1.56684L13.23 3.57031C13.5066 3.84693 13.5066 4.29542 13.23 4.57204L5.1302 12.6719ZM2.125 14.0885H14.875V15.5052H2.125V14.0885Z" fill="#4069E5"/>
                                                                    </svg>
                                                                </a>
                                                                <a data-date="{{$interview->interview_date}}" data-id="{{$interview->id}}" href="{{route('deletenewrelation',['id'=>$interview->id])}}" class="btn deleteinterviewbtn" data-bs-toggle="modal" >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                                        <path d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z" fill="#F03000"/>
                                                                    </svg>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
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
                                                        $classes = ['badge-green', 'badge-purple', 'badge-yellow', 'badge-red'];
                                                    @endphp
                                                    @foreach($aday->logs as $log)
                                                        <li class="timeline-item-member">
                                                            @php
                                                                // Rastgele sınıf seçimi
                                                                $randomClass = $classes[array_rand($classes)];
                                                            @endphp
                                                            <span class="timeline-icon-member {{ $randomClass }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                                                    <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2" />
                                                    <path d="M9 12l2 2 4-4" stroke="white" stroke-width="2" />
                                                </svg>
                                            </span>
                                                            <div class="timeline-content-member">
                                                                <p>{{ $log->topTitle }}</p>
                                                                <div class="d-flex timeline-content-note">
                                                                    <div class="p-2">
                                                                        <p><strong>{{ $log->Title }}</strong></p>
                                                                        <p><?=$log->text?></p>                                                                        </div>
                                                                </div>
                                                                <div class="timeline-date-member">{{ $log->created_at }}</div>
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
                        <a href="{{route('adaybursiyerler')}}" type="button" class="btn cancel-button">Vazgeç</a>

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


                @include('panel.candidate-update-details.modals')
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
        @include('includes.js.teklisendsms')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.0.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script src="{{ url('assets/fonts/Roboto-normal.js') }}" ></script>
        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/admin-direct-buttons.js"></script>
        <script src="{{url('')}}/assets/js/registration.renewal.js"></script>
        <script src="{{url('')}}/assets/js/manuel.js"></script>
        <script src="{{url('')}}/assets/js/components/personCard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="{{url('')}}/assets/js/document-control.js"></script>
        <script src="{{url('')}}/assets/js/components/document-show.js"></script>
        <script src="{{url('')}}/assets/js/components/detail-forms.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ url('assets/js/tab-manager.js') }}"></script>
        @include('student.ortakSelectFonksiyonlar')

        <script>
            TabManager.init('myTab', 'adayDetay');

            // Drag & Drop İşlevselliği
            document.addEventListener('DOMContentLoaded', function() {
                initializeDragDrop();
            });

            // Drag & Drop fonksiyonlarını başlat
            function initializeDragDrop() {
                // Tüm file-drag-drop-area alanlarını seç
                const dropAreas = document.querySelectorAll('.file-drag-drop-area');

                dropAreas.forEach(dropArea => {
                    const fileInput = dropArea.querySelector('input[type="file"]');
                    const label = dropArea.querySelector('.file-label');

                    if (!fileInput || !label) return;

                    // Drag olayları için stil değişiklikleri
                    function addHighlight() {
                        label.style.backgroundColor = '#f0f8ff';
                        label.style.borderColor = '#4069E5';
                        label.style.borderStyle = 'dashed';
                    }

                    function removeHighlight() {
                        label.style.backgroundColor = '';
                        label.style.borderColor = '';
                        label.style.borderStyle = '';
                    }

                    // Drag enter - dosya sürüklenmeye başlandığında
                    dropArea.addEventListener('dragenter', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        addHighlight();
                    });

                    // Drag over - dosya üzerinde sürüklenirken
                    dropArea.addEventListener('dragover', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        addHighlight();
                    });

                    // Drag leave - dosya alan dışına çıktığında
                    dropArea.addEventListener('dragleave', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        removeHighlight();
                    });

                    // Drop - dosya bırakıldığında
                    dropArea.addEventListener('drop', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        removeHighlight();

                        const files = e.dataTransfer.files;

                        if (files.length > 0) {
                            const file = files[0];

                            // Dosya tipini kontrol et
                            const acceptedTypes = fileInput.getAttribute('accept');
                            if (acceptedTypes && !isFileTypeAccepted(file, acceptedTypes)) {
                                alert('Bu dosya tipi desteklenmiyor. Lütfen desteklenen dosya tiplerinden birini seçin.');
                                return;
                            }

                            // Dosya boyutunu kontrol et (5MB = 5 * 1024 * 1024 bytes)
                            const maxSize = 5 * 1024 * 1024;
                            if (file.size > maxSize) {
                                alert('Dosya boyutu 5MB\'dan büyük olamaz.');
                                return;
                            }

                            // Dosyayı input alanına ata
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            fileInput.files = dataTransfer.files;

                            // Dosya seçildiğinde change event'ini tetikle
                            const changeEvent = new Event('change', { bubbles: true });
                            fileInput.dispatchEvent(changeEvent);

                            console.log('Dosya başarıyla yüklendi:', file.name);
                        }
                    });

                    // Label'a tıklandığında da aynı işlevi sağla (mevcut işlevsellik korunur)
                    label.addEventListener('click', function(e) {
                        // Varsayılan davranış zaten input'u tetikler
                    });
                });
            }

            // Dosya tipini kontrol eden yardımcı fonksiyon
            function isFileTypeAccepted(file, acceptedTypes) {
                const fileType = file.type;
                const fileName = file.name.toLowerCase();

                // Accept string'ini parçala
                const types = acceptedTypes.split(',').map(type => type.trim());

                for (let type of types) {
                    // MIME type kontrolü
                    if (type.startsWith('.')) {
                        // Dosya uzantısı kontrolü
                        if (fileName.endsWith(type.toLowerCase())) {
                            return true;
                        }
                    } else {
                        // MIME type kontrolü
                        if (fileType === type || fileType.startsWith(type.replace('*', ''))) {
                            return true;
                        }
                    }
                }

                return false;
            }
        </script>


    @include('panel.candidate-update-details.scriptf')
                @include('includes.js.sidebar')
@include('layouts.student.notesjs')
@endsection
