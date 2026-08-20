@extends('layouts.master')
@section('title')
    Mezun Öğrenciler
@endsection
@section('page-title')
    Mezun Öğrenciler
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <form action="{{route('active-relation-profile-form')}}" id="basvuruForm" method="post" enctype="multipart/form-data" > @csrf

                <div class=" mt-1">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="button" class="btn btn-outline-primary me-3" id="save-close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z"
                                    fill="#4069E5" />
                            </svg>
                            Kaydet ve Kapat
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="save">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z"
                                    fill="#4069E5" />
                            </svg>
                            Kaydet
                        </button>
                        <a href="{{route('panel-mezun-geri-al-profil',['id'=>$aday->id])}}">
                            <button type="button" class="btn btn-outline-danger me-3" id="denied" data-bs-toggle="modal" data-bs-target="#undoModal">
                                Öğrenciyi Geri Al
                            </button>
                        </a>
                        <button onclick="location.href='{{route('getScholarMailForm',['eposta'=>$aday->infos->email])}}'" type="button" class="btn me-3 btn-outline-info" id="mail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M2.5 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.5C2.03976 17.5 1.66666 17.1269 1.66666 16.6667V3.33333C1.66666 2.8731 2.03976 2.5 2.5 2.5ZM16.6667 6.0316L10.0598 11.9483L3.33333 6.01328V15.8333H16.6667V6.0316ZM3.75955 4.16667L10.0516 9.71833L16.2508 4.16667H3.75955Z"
                                    fill="#8353E2" />
                            </svg>
                            E-Posta
                        </button>
                        <button type="button" class="btn me-3 btn-outline-warning" id="sms" data-tel="{{$aday->infos->tel_no}}" data-name="{{$aday->infos->name}}" data-surname="{{$aday->infos->surname}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path
                                    d="M4.80235 14.1667H16.6667V4.16667H3.33333V15.3209L4.80235 14.1667ZM5.37879 15.8333L1.66667 18.75V3.33333C1.66667 2.8731 2.03977 2.5 2.5 2.5H17.5C17.9603 2.5 18.3333 2.8731 18.3333 3.33333V15C18.3333 15.4602 17.9603 15.8333 17.5 15.8333H5.37879Z"
                                    fill="#FF8B00" />
                            </svg>
                            SMS
                        </button>
                        <button type="button" class="btn btn-outline-primary me-3" id="waste" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Sütunlar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M16.6667 2.5C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5H16.6667ZM9.16667 10.8333H4.16667V15.8333H9.16667V10.8333ZM10.8333 15.8333H15.8333V4.16667H10.8333V15.8333ZM9.16667 4.16667H4.16667V9.16667H9.16667V4.16667Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <a href="{{route('deleteactiverelation',['id'=>$aday->scholar->id])}}">
                            <button type="button" class="btn btn-outline-primary me-3" id="waste">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path
                                        d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                        fill="#4069E5" />
                                </svg>
                            </button>
                        </a>
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
                                    <button class="nav-link custom-nav-link" id="education-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#education-info" type="button" role="tab" aria-controls="place-info"
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
                                    <button class="nav-link custom-nav-link" id="payment-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#payment-info" type="button" role="tab" aria-controls="payment-info"
                                            aria-selected="false" data-target="15">Burs Ödeme Bilgileri</button>
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
                                @php
                                    $fotografPath = $aday->infos->doc_fotograf;

                                @endphp

                                <img width='150' src=" @if($aday->infos->doc_fotograf){{ url($aday->infos->doc_fotograf) }} @else {{url('assets/images/default-profile.svg')}}  @endif " alt="Profile Photo" class="img-fluid">
                            </div>
                            <div class="profile-info">
                                <h6>{{$aday->scholar->name}} {{$aday->scholar->surname}}</h6>
                                <p>Mezun</p>
                                <div class="profile-icons d-flex justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.49996C2.03973 17.5 1.66663 17.1269 1.66663 16.6667V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5ZM16.6666 6.0316L10.0598 11.9483L3.33329 6.01328V15.8333H16.6666V6.0316ZM3.75951 4.16667L10.0515 9.71833L16.2508 4.16667H3.75951Z"
                                            fill="#0052CC" />
                                    </svg>
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
                            </div>
                            <div id="aboutContent">
                                <div class="profile-details">
                                    <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z"
                                                      fill="#00875A" />
                                            </svg>Burs Durumu:</strong> <span id="bursDurumu" class="bursiyerStatusu">Pasif Bursiyer</span></p>
                                    <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z" fill="#0052CC"></path>
                                            </svg>Öğrenci Durumu:</strong> <span class="basvuruDurumu status-box-success">Mezun</span></p>                                    <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M2.50004 5.00004H17.5V15H2.50004V5.00004ZM1.66671 3.33337C1.20647 3.33337 0.833374 3.70647 0.833374 4.16671V15.8334C0.833374 16.2936 1.20647 16.6667 1.66671 16.6667H18.3334C18.7936 16.6667 19.1667 16.2936 19.1667 15.8334V4.16671C19.1667 3.70647 18.7936 3.33337 18.3334 3.33337H1.66671ZM10.8334 6.66671H15.8334V8.33337H10.8334V6.66671ZM15 10H10.8334V11.6667H15V10ZM8.75004 8.33337C8.75004 9.48396 7.8173 10.4167 6.66671 10.4167C5.51612 10.4167 4.58337 9.48396 4.58337 8.33337C4.58337 7.18278 5.51612 6.25004 6.66671 6.25004C7.8173 6.25004 8.75004 7.18278 8.75004 8.33337ZM6.66671 11.25C5.05587 11.25 3.75004 12.5559 3.75004 14.1667H9.58337C9.58337 12.5559 8.27754 11.25 6.66671 11.25Z"
                                                      fill="#FFAB00" />
                                            </svg>Uyruk:</strong> @if(isset($aday->infos->nationality)){{$aday->infos->nationality}} @endif</p>
                                    <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M10 19.7732L4.6967 14.47C1.76777 11.541 1.76777 6.79226 4.6967 3.86333C7.62563 0.934393 12.3743 0.934393 15.3033 3.86333C18.2323 6.79226 18.2323 11.541 15.3033 14.47L10 19.7732ZM14.1248 13.2914C16.4028 11.0134 16.4028 7.31989 14.1248 5.04183C11.8468 2.76378 8.15327 2.76378 5.87521 5.04183C3.59715 7.31989 3.59715 11.0134 5.87521 13.2914L10 17.4162L14.1248 13.2914ZM10 10.8333C9.0795 10.8333 8.33333 10.0871 8.33333 9.16663C8.33333 8.24615 9.0795 7.49996 10 7.49996C10.9205 7.49996 11.6667 8.24615 11.6667 9.16663C11.6667 10.0871 10.9205 10.8333 10 10.8333Z"
                                                      fill="#F03000" />
                                            </svg>Adresi:</strong> @if(isset($aday->infos->address_detail)) {{$aday->infos->address_detail}}@endif</p>
                                    <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M2.49996 2.5H17.5C17.9602 2.5 18.3333 2.8731 18.3333 3.33333V16.6667C18.3333 17.1269 17.9602 17.5 17.5 17.5H2.49996C2.03973 17.5 1.66663 17.1269 1.66663 16.6667V3.33333C1.66663 2.8731 2.03973 2.5 2.49996 2.5ZM16.6666 6.0316L10.0598 11.9483L3.33329 6.01328V15.8333H16.6666V6.0316ZM3.75951 4.16667L10.0515 9.71833L16.2508 4.16667H3.75951Z"
                                                      fill="#4069E5" />
                                            </svg>E-mail:</strong> @if(isset($aday->scholar->email)){{$aday->scholar->email}} @endif</p>
                                    <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4318C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                                      fill="#8353E2" />
                                            </svg>Cep Telefonu:</strong> @if(isset($aday->infos->tel_no)){{$aday->infos->tel_no}} @endif</p>
                                    <p><strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M17.5 16.6667H19.1667V18.3334H0.833374V16.6667H2.50004V2.50002C2.50004 2.03979 2.87314 1.66669 3.33337 1.66669H16.6667C17.127 1.66669 17.5 2.03979 17.5 2.50002V16.6667ZM15.8334 16.6667V3.33335H4.16671V16.6667H15.8334ZM6.66671 9.16669H9.16671V10.8334H6.66671V9.16669ZM6.66671 5.83335H9.16671V7.50002H6.66671V5.83335ZM6.66671 12.5H9.16671V14.1667H6.66671V12.5ZM10.8334 12.5H13.3334V14.1667H10.8334V12.5ZM10.8334 9.16669H13.3334V10.8334H10.8334V9.16669ZM10.8334 5.83335H13.3334V7.50002H10.8334V5.83335Z"
                                                      fill="#00BDD6" />
                                            </svg>Mezuniyet Dönemi:</strong> @if(isset($aday->period->title)){{$aday->period->title}}@endif</p>
                                            <p><strong>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M8.33942 1.7531C7.1714 1.375 5.90172 1.90093 5.34318 2.99418L4.67169 4.30849C4.59191 4.46465 4.46489 4.59166 4.30873 4.67144L2.99442 5.34293C1.90117 5.90147 1.37525 7.17116 1.75334 8.33914L2.20789 9.74331C2.2619 9.91014 2.2619 10.0898 2.20789 10.2566L1.75334 11.6608C1.37525 12.8288 1.90118 14.0985 2.99442 14.657L4.30873 15.3285C4.46489 15.4083 4.59191 15.5353 4.67169 15.6915L5.34318 17.0057C5.90172 18.099 7.17141 18.6249 8.33942 18.2468L9.74359 17.7923C9.91042 17.7383 10.09 17.7383 10.2568 17.7923L11.661 18.2468C12.829 18.6249 14.0988 18.099 14.6573 17.0057L15.3288 15.6915C15.4085 15.5353 15.5355 15.4083 15.6917 15.3285L17.006 14.657C18.0993 14.0985 18.6252 12.8288 18.2471 11.6608L17.7925 10.2566C17.7385 10.0898 17.7385 9.91014 17.7925 9.74331L18.2471 8.33914C18.6252 7.17115 18.0993 5.90147 17.006 5.34293L15.6917 4.67144C15.5355 4.59166 15.4085 4.46464 15.3288 4.30849L14.6573 2.99418C14.0988 1.90093 12.829 1.375 11.661 1.7531L10.2568 2.20764C10.09 2.26165 9.91042 2.26165 9.74359 2.20764L8.33942 1.7531ZM6.82736 3.75244C7.01354 3.38803 7.43677 3.21273 7.8261 3.33875L9.23025 3.7933C9.73075 3.95533 10.2697 3.95533 10.7702 3.7933L12.1743 3.33875C12.5637 3.21273 12.9869 3.38803 13.1731 3.75244L13.8446 5.06676C14.0839 5.53524 14.4649 5.91628 14.9334 6.15563L16.2478 6.82711C16.6122 7.01329 16.7875 7.43652 16.6614 7.82585L16.2069 9.23006C16.0448 9.73056 16.0448 10.2694 16.2069 10.7699L16.6614 12.1741C16.7875 12.5634 16.6122 12.9866 16.2478 13.1728L14.9334 13.8443C14.4649 14.0836 14.0839 14.4647 13.8446 14.9331L13.1731 16.2475C12.9869 16.6119 12.5637 16.7872 12.1743 16.6611L10.7702 16.2066C10.2697 16.0446 9.73075 16.0446 9.23025 16.2066L7.8261 16.6611C7.43677 16.7872 7.01354 16.6119 6.82736 16.2475L6.15588 14.9331C5.91653 14.4647 5.53549 14.0836 5.06701 13.8443L3.75269 13.1728C3.38828 12.9866 3.21297 12.5634 3.339 12.1741L3.79355 10.7699C3.95557 10.2694 3.95557 9.73056 3.79355 9.23006L3.339 7.82585C3.21297 7.43652 3.38828 7.01329 3.75269 6.82711L5.067 6.15563C5.53549 5.91628 5.91653 5.53524 6.15588 5.06676L6.82736 3.75244ZM5.6332 9.79781L9.16875 13.3333L15.0613 7.44077L13.8828 6.26226L9.16875 10.9763L6.81172 8.61923L5.6332 9.79781Z"
                                                            fill="#00875A" />
                                                </svg>
                                                    İşlemi Yapan
                                                </strong> {{$aday->islemi_yapan}}</p>
                                </div>
                            </div>
                            <div id="notesContent" style="display: none;">
                                <div id="notesList">
                                    <!-- Notlar buraya eklenecek -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-container col-md-8">
                        <div class="mt-1">
                            <div class="tab-content" id="myTabContent">
                                <input type="hidden" name="form_id" id="form_id" value="{{$aday->id}}">
                                <input type="hidden" name="period_id" id="period_id" value="{{$aday->period_id}}">
                                <input type="hidden" name="scholar_id" id="scholar_id" value="{{$aday->scholar_id}}">
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
                                                    $classes = ['badge-green', 'badge-purple', 'badge-yellow', 'badge-red'];
                                                @endphp
                                                @foreach($aday->scholar->logs as $log)
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
                    <button type="button" class=" btn cancel-button" id="prevStep">Vazgeç</button>
                    <button style="display: none;" type="button" class="btn  btn-outline-primary next-button"
                            id="prevButton">Önceki</button>
                    <button type="button" class="btn btn-primary next-button" id="nextStep">Sonraki</button>
                    <button style="display: none;" type="button" onclick="submitForm('/panel/Mezunlar')" class="btn  btn-primary next-button"
                            id="completeButton">Tamamla</button>
                </div>
            </div>
            </form>
        </main>
        <!--Modal Alanı-->
        <!-- Mezun Et Onay Modalı -->
        <div class="modal fade" id="graduateConfirmModal" tabindex="-1" aria-labelledby="graduateConfirmModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
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
                            <button type="button" class="btn me-3 text-white" id="graduatebtn" data-bs-dismiss="modal"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none">
                                    <path
                                        d="M10 1.66675L0 7.50008L10 13.3334L18.3333 8.47233V14.5834H20V7.50008L10 1.66675ZM3.33252 11.2422V15.0002C4.85287 17.0242 7.27343 18.3335 9.99983 18.3335C12.7262 18.3335 15.1467 17.0242 16.6671 15.0002L16.6667 11.2428L10.0003 15.1317L3.33252 11.2422Z"
                                        fill="white" />
                                </svg>Mezun Et
                            </button>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" fill="#00875A" />
                            <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" stroke="white" stroke-width="2" />
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
        <div class="modal fade" id="scholarshipCompletionModal" tabindex="-1" aria-labelledby="scholarshipCompletionModalLabel" aria-hidden="true">
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
                        <form>
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
                                    <input type="text" class="form-control" id="kardesOgrenimDurumu"
                                           placeholder="Öğrenim durumu giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu" class="form-label">Medeni Durumu</label>
                                    <input type="text" class="form-control" id="kardesMedeniDurumu"
                                           placeholder="Medeni durum giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="kardesMeslegi"
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
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesAdi" class="form-label">Adı</label>
                                    <input type="text" class="form-control" id="kardesAdi" placeholder="Canan">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesSoyadi" class="form-label">Soyadı</label>
                                    <input type="text" class="form-control" id="kardesSoyadi" placeholder="Tan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesYasi" class="form-label">Yaşı</label>
                                    <input type="text" class="form-control" id="kardesYasi" placeholder="25">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                                    <input type="text" class="form-control" id="kardesOgrenimDurumu"
                                           placeholder="Üniversite">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu" class="form-label">Medeni Durumu</label>
                                    <input type="text" class="form-control" id="kardesMedeniDurumu" placeholder="Bekar">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="kardesMeslegi" placeholder="Öğretmen">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Burs Ekle Modal -->
        <div class="modal fade" id="bursEkleModal" tabindex="-1" aria-labelledby="bursEkleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="burssEkleModalLabel">Burs Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="kurumAdi" class="form-label">Kurum Adı</label>
                                    <input type="text" class="form-control" id="kurumAdi"
                                           placeholder="Kurum adı giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kurumTuru" class="form-label">Kurum Türü</label>
                                    <select class="form-select" id="kurumTuru" required>
                                        <option selected disabled>Seçiniz...</option>
                                        <option>Devlet</option>
                                        <option>Özel</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                                    <input type="text" class="form-control" id="bursMıktarı" placeholder="1000">
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
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="kurumAdi" class="form-label">Kurum Adı</label>
                                    <input type="text" class="form-control" id="kurumAdi" placeholder="GSB">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kurumTuru" class="form-label">Kurum Türü</label>
                                    <select class="form-select" id="kurumTuru" required>
                                        <option disabled>Seçiniz...</option>
                                        <option selected>Devlet</option>
                                        <option>Özel</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                                    <input type="text" class="form-control" id="bursMıktarı" placeholder="1000">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Belge Gosterme Modal -->
        <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentModalLabel">Belge Görüntüleyici</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                    </div>
                    <div class="modal-body">
                        <object id="documentViewer" data="" type="application/pdf" style="width: 100%; height: 500px;">
                            PDF dosyanız burada görüntülenemiyor. Lütfen <a id="pdfDownloadLink" href="#" download>indirerek</a> açın.
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path d="M15 27.5C8.09644 27.5 2.5 21.9035 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9035 2.5 27.5 8.09644 27.5 15C27.5 21.9035 21.9035 27.5 15 27.5ZM13.75 18.75V21.25H16.25V18.75H13.75ZM13.75 8.75V16.25H16.25V8.75H13.75Z" fill="#636363"/>
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
        <div class="modal fade" id="interviewModal" tabindex="-1" aria-labelledby="interviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="interviewModalLabel">Mülakat Oluştur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('aktif-mulakat-olustur')}}" method="post" id="interviewForm"> @csrf
                            <div class="row">
                                <input type="hidden" name="form_id" id="form_id" value="{{$aday->id}}">
                                <input type="hidden" name="form" id="form_id" value="1">
                                <div class="col-md-6 mb-3">
                                    <label for="interviewDate" class="form-label">Mülakat Tarihi</label>
                                    <input name="date" type="date" class="form-control" id="interviewDate"
                                           onclick="document.getElementById('interviewDate').showPicker()" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="interviewTime" class="form-label">Mülakat Saati</label>
                                    <input name="time" type="time" class="form-control" id="interviewTime" required>
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
                                <input type="text" class="form-control" id="interviewer" placeholder="Yazınız.." required>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
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
                                <option >Ret sebebini seçiniz</option>
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
        <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="warningModalLabel">Uyarı Bildirimi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path
                                d="M14 26.5C20.9036 26.5 26.5 20.9036 26.5 14C26.5 7.09644 20.9036 1.5 14 1.5C7.09644 1.5 1.5 7.09644 1.5 14C1.5 20.9036 7.09644 26.5 14 26.5Z"
                                stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-3">Kayıt silinecektir!<br>Onaylıyor musunuz?</p>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                            <button type="button" class="btn btn-primary" id="confirmButton">Onayla</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Uyarı Bildirimi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29" fill="none">
                            <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A" />
                            <rect x="1" y="1" width="28" height="27" rx="9" stroke="white" stroke-width="2" />
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="title">Mülakat bilgilerini giriniz</p>
                        <p class="small">Oluştur butonuna bastığınızda aday otomatik olarak bilgilendirilecektir</p>
                        <form action="{{route('aktif-mulakat-olustur')}}" method="post" id="interviewForm"> @csrf
                            <input type="hidden" name="form_id" id="form_id"  value="{{$aday->id}}">

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
                                    <select name="hour"  class="form-select me-2 " id="interviewHour">
                                        <option selected>Saat</option>
                                    </select>
                                    <select  name="minute" class="form-select" id="interviewMinute">
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yapmak istediğiniz işlemi seçiniz</p>
                        <button type="button" class="btn btn-primary mb-2" id="updateInterviewDetails">Mülakat Bilgilerini
                            Güncelle</button>
                        <button type="button" class="btn btn-secondary" id="concludeInterview">Mülakat Sonuçlandır</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Mülakat Bilgileri Güncelle Modal -->
        <div class="modal fade" id="interviewDetailsModal" tabindex="-1" aria-labelledby="interviewDetailsModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="interviewDetailsModalLabel">Mülakat Bilgilerini Güncelle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <input type="text" class="form-control" id="interviewer" placeholder="Yazınız.." required>
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
                            <textarea class="form-control" id="interviewNote" rows="4"
                                      placeholder="Açıklama giriniz..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary mt-3" id="saveNoteButton">Kaydet</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mülakat Sonuçlandır Modalı -->
        <div class="modal fade" id="concludeInterviewModal" tabindex="-1" aria-labelledby="concludeInterviewModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="concludeInterviewModalLabel">Mülakat Sonuçlandır</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        <div class="modal fade" id="deleteInterviewModal" tabindex="-1" aria-labelledby="deleteInterviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="deleteInterviewModalLabel">Mülakat Başarıyla Silindi!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z" stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18.75 11.25L11.25 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.25 11.25L18.75 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p>Mülakatın neden silindiğini kısaca açıklayınız.</p>
                        <form id="deleteInterviewForm">
                            <div class="mb-3">
                                <textarea class="form-control" id="deleteReason" rows="3" placeholder="Açıklama giriniz.." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gönder</button>
                        </form>
                        <p class="mt-3">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu ile bilgilendirilecektir!</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mezun Et Onay Modalı -->
        <div class="modal fade" id="graduateConfirmModal" tabindex="-1" aria-labelledby="graduateConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z" stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M11.3633 11.2497C11.6572 10.4143 12.2372 9.70987 13.0007 9.26115C13.7642 8.81243 14.6619 8.64841 15.5348 8.79813C16.4076 8.94784 17.1993 9.40164 17.7696 10.0791C18.34 10.7566 18.6521 11.6141 18.6508 12.4997C18.6508 14.9997 14.9008 16.2497 14.9008 16.2497" stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 21.25H15.0125" stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h5 class="mt-3">Bursiyer mezun edilecek ve mezunlar alanına taşınacaktır!</h5>
                        <p>Onaylıyor musunuz?</p>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                        <button type="button" class="btn btn-primary" id="confirmGraduate">Onayla</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mezun Et Başarılı Modalı -->
        <div class="modal fade" id="graduateSuccessModal" tabindex="-1" aria-labelledby="graduateSuccessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29" fill="none">
                            <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A" />
                            <rect x="1" y="1" width="28" height="27" rx="9" stroke="white" stroke-width="2" />
                            <path d="M10.533 13.1696C9.77395 12.4358 8.54324 12.4358 7.78415 13.1696C7.02507 13.9034 7.02507 15.093 7.78415 15.8268L11.6717 19.5847C12.4307 20.3185 13.6615 20.3185 14.4205 19.5847L22.1955 12.0689C22.9546 11.3351 22.9546 10.1454 22.1955 9.41166C21.4365 8.67788 20.2057 8.67788 19.4467 9.41166L13.0461 15.5989L10.533 13.1696Z" fill="white" />
                        </svg>
                        <h5 class="mt-3">Mezun etme işlemi başarılı</h5>
                        <p>Mezun öğrenciniz e-posta ile bilgilendirilecektir!</p>
                        <a href="{{route('tekliMezunEt',['id'=>$aday->scholar->id])}}">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="closeSuccessModal">Kapat</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @include('panel.includes.renew-update-detail-scripts')

    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

        @include('layouts.student.notesjs')
        @include('layouts.student.paymenttablejs')
        @include('includes.js.teklisendsms')
        <script src="{{url('')}}/assets/js/tab-manager.js"></script>
        <script>
            TabManager.init('myTab', 'mezunlar');
        </script>
        <script src="../assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/admin-direct-buttons.js"></script>
        <script src="../assets/js/registration.renewal.js"></script>
        <script src="../assets/js/manuel.js"></script>
        <script src="../assets/js/tables/payment-info.js"></script>
        <script>
            document.getElementById('confirmButton').addEventListener('click', function () {
                var warningModal = bootstrap.Modal.getInstance(document.getElementById('warningModal'));
                warningModal.hide();

                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            });
        </script>

        <script>



            function submitinterviewform(redirectUrl = null) {
                var form_id = $('#form_id').val();
                var date = $('#stepinterviewDate').val();
                var time = $('#stepinterviewTime').val();
                var platform = $('#stepinterviewType').val();
                var person = $('#stepinterviewer').val();
                var address = $('#stepinterviewLocation').val();


                $.ajax({
                    url: '/panel/aktif-mulakat-olustur',
                    type: 'POST',
                    data: {
                        form: '1',
                        form_id : form_id,
                        date : date,
                        time : time,
                        platform : platform,
                        person : person,
                        address : address,
                        _token: '{{ csrf_token() }}' // Laravel'de CSRF koruması için
                    },
                    success: function(response) {
                        // İşlem başarılıysa yönlendirme veya sayfada kalma
                       location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Hatası:", status, error);
                        console.error("Hata Detayları:", xhr.responseText);                        }
                });
            }

            // "Kaydet" butonuna tıklanınca
            $('#save').click(function() {
                submitForm();
            });
          $('#saveinterview').click(function() {
              submitinterviewform();
            });

            // "Kaydet ve Kapat" butonuna tıklanınca
            $('#save-close').click(function() {
                submitForm('/panel/Bursiyerler');
            });
            $('#reload').click(function() {
                location.reload();
            });
        </script>
        <script>



        </script>
     @include('layouts.student.notesjs')
     @include('layouts.student.paymenttablejs')



 @include('panel.active-scholarship-details.scriptf')
            @include('includes.js.sidebar')
        <script>
            function submitForm(redirectUrl = null) {
                // Form verilerini al
                let formData = {};
                var form_id = $('#form_id').val();

                // Tüm input, select ve textarea elemanlarını seç
                document.querySelectorAll(`#basvuruForm input, #basvuruForm select, #basvuruForm textarea`).forEach(input => {
                    formData[input.id] = input.value;
                });
                formData['form_id']= form_id;
                // AJAX isteği
                $.ajax({
                    url: '/panel/Aktif-Bursiyer-Bilgileri-Kaydet',
                    type: 'POST',
                    data: {
                        formData : formData,
                        _token: '{{ csrf_token() }}' // Laravel'de CSRF koruması için

                    },
                    success: function(response) {
                        console.log(response);
                        // İşlem başarılıysa yönlendirme veya sayfada kalma
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        } else {
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Hatası:", status, error);
                        console.error("Hata Detayları:", xhr.responseText);                        }
                });
            }
        </script>
@endsection
