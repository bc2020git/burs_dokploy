@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yönetici Paneli
@endsection
@section('local-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('body')

    @endsection
    @section('content')
        @if(session()->has('error'))
            <script>
                toastr.error("{{ session('error') }}", "Hata!");
            </script>
        @endif

        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="row">
                    <div class="col-12">
                        <div class="overview-section">
                            <div class="category-header">
                                <h5>Kategori  </h5>
                                @if(session()->has('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                                @endif
                                <!--<div class="dropdown dashboard-dropdown">
                                    <button class="btn dropdown-toggle dropdown-button-category" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">

                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Option 1</a></li>
                                    </ul>
                                </div>-->
                            </div>
                            <div class="row mt-3">
                                <!-- Burs Başvuru Durumu -->
                                <div class="col-md-4 ">
                                    <div class="card-overview">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{route('adaybursiyerler')}}"><h6>Aday Bursiyer Başvuru Durumu</h6></a>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 d-flex status-box category-status-box-warning">
                                                <div class="status-box-content-warning">
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M11.6667 11.8767V13.6178C11.1453 13.4336 10.5844 13.3333 10 13.3333C7.23859 13.3333 5.00001 15.5719 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667C10.5755 11.6667 11.134 11.7396 11.6667 11.8767ZM10 10.8333C7.23751 10.8333 5.00001 8.59584 5.00001 5.83334C5.00001 3.07084 7.23751 0.833336 10 0.833336C12.7625 0.833336 15 3.07084 15 5.83334C15 8.59584 12.7625 10.8333 10 10.8333ZM10 9.16667C11.8417 9.16667 13.3333 7.675 13.3333 5.83334C13.3333 3.99167 11.8417 2.5 10 2.5C8.15834 2.5 6.66668 3.99167 6.66668 5.83334C6.66668 7.675 8.15834 9.16667 10 9.16667ZM15.4882 14.1667L13.9645 12.643L15.143 11.4645L18.6785 15L15.143 18.5355L13.9645 17.357L15.4882 15.8333H12.5V14.1667H15.4882Z"
                                                                fill="#FF8B00" />
                                                        </svg> {{$new['bekleyen']}} Aday Bursiyer</p>
                                                </div>
                                                <span class="badge bg-warning">Onay Bekliyor</span>
                                            </div>
                                            <div class="col-md-5 status-box category-status-box-success">
                                                <div class="status-box-content-success ">
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M11.6667 11.8767V13.6178C11.1453 13.4336 10.5844 13.3333 10 13.3333C7.23858 13.3333 5.00001 15.5719 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667C10.5755 11.6667 11.134 11.7396 11.6667 11.8767ZM10 10.8333C7.23751 10.8333 5.00001 8.59584 5.00001 5.83334C5.00001 3.07084 7.23751 0.833336 10 0.833336C12.7625 0.833336 15 3.07084 15 5.83334C15 8.59584 12.7625 10.8333 10 10.8333ZM10 9.16667C11.8417 9.16667 13.3333 7.675 13.3333 5.83334C13.3333 3.99167 11.8417 2.5 10 2.5C8.15834 2.5 6.66668 3.99167 6.66668 5.83334C6.66668 7.675 8.15834 9.16667 10 9.16667ZM14.8274 16.5952L17.7737 13.6489L18.9522 14.8274L14.8274 18.9522L11.8812 16.0059L13.0597 14.8274L14.8274 16.5952Z"
                                                                fill="#00875A" />
                                                        </svg>
                                                        {{$new['onay']}} Aday Bursiyer</p>
                                                </div>
                                                <span class="badge bg-success">Onaylandı</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 status-box category-status-box-secondary">
                                                <div class="status-box-content-secondary">
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M11.6667 11.8767V13.6178C11.1453 13.4336 10.5844 13.3333 10 13.3333C7.23858 13.3333 5.00001 15.5719 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667C10.5755 11.6667 11.134 11.7396 11.6667 11.8767ZM10 10.8333C7.23751 10.8333 5.00001 8.59583 5.00001 5.83333C5.00001 3.07083 7.23751 0.833333 10 0.833333C12.7625 0.833333 15 3.07083 15 5.83333C15 8.59583 12.7625 10.8333 10 10.8333ZM10 9.16667C11.8417 9.16667 13.3333 7.675 13.3333 5.83333C13.3333 3.99167 11.8417 2.5 10 2.5C8.15834 2.5 6.66668 3.99167 6.66668 5.83333C6.66668 7.675 8.15834 9.16667 10 9.16667ZM16.6667 14.1667H19.1667V15.8333H16.6667V18.75L12.5 15L16.6667 11.25V14.1667Z"
                                                                fill="#333333" />
                                                        </svg> {{$new['iade']}} Aday Bursiyer</p>
                                                </div>
                                                <span class="badge bg-secondary">İade Edildi</span>
                                            </div>
                                            <div class="col-md-5 status-box category-status-box-danger">
                                                <div class="status-box-content-danger"> <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M6.66668 5.83333C6.66668 3.99238 8.15906 2.5 10 2.5C11.8409 2.5 13.3333 3.99238 13.3333 5.83333C13.3333 7.67428 11.8409 9.16667 10 9.16667C8.15906 9.16667 6.66668 7.67428 6.66668 5.83333ZM10 0.833333C7.23858 0.833333 5.00001 3.07191 5.00001 5.83333C5.00001 8.59475 7.23858 10.8333 10 10.8333C12.7614 10.8333 15 8.59475 15 5.83333C15 3.07191 12.7614 0.833333 10 0.833333ZM12.5 15C12.5 13.6193 13.6193 12.5 15 12.5C15.3859 12.5 15.7515 12.5875 16.0778 12.7437L12.7437 16.0778C12.5875 15.7515 12.5 15.3859 12.5 15ZM13.9222 17.2563L17.2563 13.9222C17.4125 14.2485 17.5 14.6141 17.5 15C17.5 16.3808 16.3808 17.5 15 17.5C14.6141 17.5 14.2485 17.4125 13.9222 17.2563ZM15 10.8333C12.6988 10.8333 10.8333 12.6988 10.8333 15C10.8333 17.3012 12.6988 19.1667 15 19.1667C17.3012 19.1667 19.1667 17.3012 19.1667 15C19.1667 12.6988 17.3012 10.8333 15 10.8333ZM10 11.6667C10.0703 11.6667 10.1403 11.6677 10.21 11.6699C9.85301 12.1824 9.57618 12.7549 9.39768 13.3693C6.92027 13.6667 5.00001 15.7758 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667Z"
                                                                fill="#F03000" />
                                                        </svg>
                                                        {{$new['red']}} Aday Bursiyer</p></div>
                                                <span class="badge bg-danger">Reddedildi</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Bursiyer Statüsü -->
                                <div class="col-md-4">
                                    <div class="card-overview h-100">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{route('kayityenileme')}}"><h6>Kayıt Yenileme Durumu</h6></a>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 d-flex status-box category-status-box-warning">
                                                <div class="status-box-content-warning">
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M11.6667 11.8767V13.6178C11.1453 13.4336 10.5844 13.3333 10 13.3333C7.23859 13.3333 5.00001 15.5719 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667C10.5755 11.6667 11.134 11.7396 11.6667 11.8767ZM10 10.8333C7.23751 10.8333 5.00001 8.59584 5.00001 5.83334C5.00001 3.07084 7.23751 0.833336 10 0.833336C12.7625 0.833336 15 3.07084 15 5.83334C15 8.59584 12.7625 10.8333 10 10.8333ZM10 9.16667C11.8417 9.16667 13.3333 7.675 13.3333 5.83334C13.3333 3.99167 11.8417 2.5 10 2.5C8.15834 2.5 6.66668 3.99167 6.66668 5.83334C6.66668 7.675 8.15834 9.16667 10 9.16667ZM15.4882 14.1667L13.9645 12.643L15.143 11.4645L18.6785 15L15.143 18.5355L13.9645 17.357L15.4882 15.8333H12.5V14.1667H15.4882Z"
                                                                fill="#FF8B00" />
                                                        </svg> {{$renew['bekleyen']}} Bursiyer</p>
                                                </div>
                                                <span class="badge bg-warning">Onay Bekliyor</span>
                                            </div>
                                            <div class="col-md-5 status-box category-status-box-success">
                                                <div class="status-box-content-success ">
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M11.6667 11.8767V13.6178C11.1453 13.4336 10.5844 13.3333 10 13.3333C7.23858 13.3333 5.00001 15.5719 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667C10.5755 11.6667 11.134 11.7396 11.6667 11.8767ZM10 10.8333C7.23751 10.8333 5.00001 8.59584 5.00001 5.83334C5.00001 3.07084 7.23751 0.833336 10 0.833336C12.7625 0.833336 15 3.07084 15 5.83334C15 8.59584 12.7625 10.8333 10 10.8333ZM10 9.16667C11.8417 9.16667 13.3333 7.675 13.3333 5.83334C13.3333 3.99167 11.8417 2.5 10 2.5C8.15834 2.5 6.66668 3.99167 6.66668 5.83334C6.66668 7.675 8.15834 9.16667 10 9.16667ZM14.8274 16.5952L17.7737 13.6489L18.9522 14.8274L14.8274 18.9522L11.8812 16.0059L13.0597 14.8274L14.8274 16.5952Z"
                                                                fill="#00875A" />
                                                        </svg>
                                                        {{$renew['onay']}} Bursiyer</p>
                                                </div>
                                                <span class="badge bg-success">Onaylandı</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 status-box category-status-box-secondary">
                                                <div class="status-box-content-secondary">
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M11.6667 11.8767V13.6178C11.1453 13.4336 10.5844 13.3333 10 13.3333C7.23858 13.3333 5.00001 15.5719 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667C10.5755 11.6667 11.134 11.7396 11.6667 11.8767ZM10 10.8333C7.23751 10.8333 5.00001 8.59583 5.00001 5.83333C5.00001 3.07083 7.23751 0.833333 10 0.833333C12.7625 0.833333 15 3.07083 15 5.83333C15 8.59583 12.7625 10.8333 10 10.8333ZM10 9.16667C11.8417 9.16667 13.3333 7.675 13.3333 5.83333C13.3333 3.99167 11.8417 2.5 10 2.5C8.15834 2.5 6.66668 3.99167 6.66668 5.83333C6.66668 7.675 8.15834 9.16667 10 9.16667ZM16.6667 14.1667H19.1667V15.8333H16.6667V18.75L12.5 15L16.6667 11.25V14.1667Z"
                                                                fill="#333333" />
                                                        </svg> {{$renew['iade']}} Bursiyer</p>
                                                </div>
                                                <span class="badge bg-secondary">İade Edildi</span>
                                            </div>
                                            <div class="col-md-5 status-box category-status-box-danger">
                                                <div class="status-box-content-danger"> <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M6.66668 5.83333C6.66668 3.99238 8.15906 2.5 10 2.5C11.8409 2.5 13.3333 3.99238 13.3333 5.83333C13.3333 7.67428 11.8409 9.16667 10 9.16667C8.15906 9.16667 6.66668 7.67428 6.66668 5.83333ZM10 0.833333C7.23858 0.833333 5.00001 3.07191 5.00001 5.83333C5.00001 8.59475 7.23858 10.8333 10 10.8333C12.7614 10.8333 15 8.59475 15 5.83333C15 3.07191 12.7614 0.833333 10 0.833333ZM12.5 15C12.5 13.6193 13.6193 12.5 15 12.5C15.3859 12.5 15.7515 12.5875 16.0778 12.7437L12.7437 16.0778C12.5875 15.7515 12.5 15.3859 12.5 15ZM13.9222 17.2563L17.2563 13.9222C17.4125 14.2485 17.5 14.6141 17.5 15C17.5 16.3808 16.3808 17.5 15 17.5C14.6141 17.5 14.2485 17.4125 13.9222 17.2563ZM15 10.8333C12.6988 10.8333 10.8333 12.6988 10.8333 15C10.8333 17.3012 12.6988 19.1667 15 19.1667C17.3012 19.1667 19.1667 17.3012 19.1667 15C19.1667 12.6988 17.3012 10.8333 15 10.8333ZM10 11.6667C10.0703 11.6667 10.1403 11.6677 10.21 11.6699C9.85301 12.1824 9.57618 12.7549 9.39768 13.3693C6.92027 13.6667 5.00001 15.7758 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667Z"
                                                                fill="#F03000" />
                                                        </svg>
                                                        {{$renew['red']}} Bursiyer</p></div>
                                                <span class="badge bg-danger">Reddedildi</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Sistem Durumu -->
                                <div class="col-md-4">
                                    <div class="card-overview">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{route('bursiyerler')}}"><h6>Burs Durumu</h6></a>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 status-box category-status-box-success">
                                                <div class="status-box-content-success ">
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M11.6667 11.8767V13.6178C11.1453 13.4336 10.5844 13.3333 10 13.3333C7.23858 13.3333 5.00001 15.5719 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667C10.5755 11.6667 11.134 11.7396 11.6667 11.8767ZM10 10.8333C7.23751 10.8333 5.00001 8.59584 5.00001 5.83334C5.00001 3.07084 7.23751 0.833336 10 0.833336C12.7625 0.833336 15 3.07084 15 5.83334C15 8.59584 12.7625 10.8333 10 10.8333ZM10 9.16667C11.8417 9.16667 13.3333 7.675 13.3333 5.83334C13.3333 3.99167 11.8417 2.5 10 2.5C8.15834 2.5 6.66668 3.99167 6.66668 5.83334C6.66668 7.675 8.15834 9.16667 10 9.16667ZM14.8274 16.5952L17.7737 13.6489L18.9522 14.8274L14.8274 18.9522L11.8812 16.0059L13.0597 14.8274L14.8274 16.5952Z"
                                                                fill="#00875A" />
                                                        </svg>
                                                        {{$active['aktif']}} Aktif Bursiyer</p>
                                                </div>
                                                <span class="badge bg-success">Aktif</span>
                                            </div>
                                            <div class="col-md-5 status-box category-status-box-danger">
                                                <div class="status-box-content-danger"> <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M6.66668 5.83333C6.66668 3.99238 8.15906 2.5 10 2.5C11.8409 2.5 13.3333 3.99238 13.3333 5.83333C13.3333 7.67428 11.8409 9.16667 10 9.16667C8.15906 9.16667 6.66668 7.67428 6.66668 5.83333ZM10 0.833333C7.23858 0.833333 5.00001 3.07191 5.00001 5.83333C5.00001 8.59475 7.23858 10.8333 10 10.8333C12.7614 10.8333 15 8.59475 15 5.83333C15 3.07191 12.7614 0.833333 10 0.833333ZM12.5 15C12.5 13.6193 13.6193 12.5 15 12.5C15.3859 12.5 15.7515 12.5875 16.0778 12.7437L12.7437 16.0778C12.5875 15.7515 12.5 15.3859 12.5 15ZM13.9222 17.2563L17.2563 13.9222C17.4125 14.2485 17.5 14.6141 17.5 15C17.5 16.3808 16.3808 17.5 15 17.5C14.6141 17.5 14.2485 17.4125 13.9222 17.2563ZM15 10.8333C12.6988 10.8333 10.8333 12.6988 10.8333 15C10.8333 17.3012 12.6988 19.1667 15 19.1667C17.3012 19.1667 19.1667 17.3012 19.1667 15C19.1667 12.6988 17.3012 10.8333 15 10.8333ZM10 11.6667C10.0703 11.6667 10.1403 11.6677 10.21 11.6699C9.85301 12.1824 9.57618 12.7549 9.39768 13.3693C6.92027 13.6667 5.00001 15.7758 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667Z"
                                                                fill="#F03000" />
                                                        </svg>
                                                        {{$active['pasif']}} Pasif Bursiyer</p></div>
                                                <span class="badge bg-danger">Reddedildi</span>
                                            </div>
                                        </div>
                                    <div class="row">
                                        <h6>Bursiyer  Tipi</h6>
                                        <div class="row">
                                            <div class="col-md-5 d-flex status-box category-status-box-warning">
                                                <div class="status-box-content-warning">
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M11.6667 11.8767V13.6178C11.1453 13.4336 10.5844 13.3333 10 13.3333C7.23859 13.3333 5.00001 15.5719 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667C10.5755 11.6667 11.134 11.7396 11.6667 11.8767ZM10 10.8333C7.23751 10.8333 5.00001 8.59584 5.00001 5.83334C5.00001 3.07084 7.23751 0.833336 10 0.833336C12.7625 0.833336 15 3.07084 15 5.83334C15 8.59584 12.7625 10.8333 10 10.8333ZM10 9.16667C11.8417 9.16667 13.3333 7.675 13.3333 5.83334C13.3333 3.99167 11.8417 2.5 10 2.5C8.15834 2.5 6.66668 3.99167 6.66668 5.83334C6.66668 7.675 8.15834 9.16667 10 9.16667ZM15.4882 14.1667L13.9645 12.643L15.143 11.4645L18.6785 15L15.143 18.5355L13.9645 17.357L15.4882 15.8333H12.5V14.1667H15.4882Z"
                                                                fill="#FF8B00" />
                                                        </svg> {{$active['dernek']}} Bursiyer</p>
                                                </div>
                                                <span class="badge bg-warning">Dernek</span>
                                            </div>
                                            <div class="col-md-5 status-box category-status-box-secondary">
                                                <div class="status-box-content-secondary">
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <path
                                                                d="M11.6667 11.8767V13.6178C11.1453 13.4336 10.5844 13.3333 10 13.3333C7.23859 13.3333 5.00001 15.5719 5.00001 18.3333H3.33334C3.33334 14.6514 6.31811 11.6667 10 11.6667C10.5755 11.6667 11.134 11.7396 11.6667 11.8767ZM10 10.8333C7.23751 10.8333 5.00001 8.59584 5.00001 5.83334C5.00001 3.07084 7.23751 0.833336 10 0.833336C12.7625 0.833336 15 3.07084 15 5.83334C15 8.59584 12.7625 10.8333 10 10.8333ZM10 9.16667C11.8417 9.16667 13.3333 7.675 13.3333 5.83334C13.3333 3.99167 11.8417 2.5 10 2.5C8.15834 2.5 6.66668 3.99167 6.66668 5.83334C6.66668 7.675 8.15834 9.16667 10 9.16667ZM15.4882 14.1667L13.9645 12.643L15.143 11.4645L18.6785 15L15.143 18.5355L13.9645 17.357L15.4882 15.8333H12.5V14.1667H15.4882Z"
                                                                fill="#FF8B00" />
                                                        </svg> {{$active['vakif']}} Bursiyer</p>
                                                </div>
                                                <span class="badge bg-secondary">Vakıf</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bursiyer Analizi -->
                     <div class="col-lg-7 col-md-12 mt-4">
                        <div class="overview-section-analys h-100">
                            <div class="category-header">
                                <h5>Bursiyer Şehir Analizi</h5>
                                <div class="dropdown dashboard-dropdown">
                                    <select id="citySelect" class="form-control select2">
                                        @foreach ($allCities as $city)
                                        <option value="{{$city['id']}}">{{$city['text']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="cityAnalysisContent" class="row d-flex mt-3 mb-3 align-items-stretch">
                            @foreach ($topCities as $city => $count)
                            <div class="col-lg-3 col-md-6 col-12 mb-3">
                                <div class="card-overview-analys card-overview-analys-two">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 11C14.7614 11 17 13.2386 17 16V22H15V16C15 14.4023 13.7511 13.0963 12.1763 13.0051L12 13C10.4023 13 9.09634 14.2489 9.00509 15.8237L9 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5.5 14C5.77885 14 6.05009 14.0326 6.3101 14.0942C6.14202 14.594 6.03873 15.122 6.00896 15.6693L6 16L6.0007 16.0856C5.88757 16.0456 5.76821 16.0187 5.64446 16.0069L5.5 16C4.7203 16 4.07955 16.5949 4.00687 17.3555L4 17.5V22H2V17.5C2 15.567 3.567 14 5.5 14ZM18.5 14C20.433 14 22 15.567 22 17.5V22H20V17.5C20 16.7203 19.4051 16.0796 18.6445 16.0069L18.5 16C18.3248 16 18.1566 16.03 18.0003 16.0852L18 16C18 15.3343 17.8916 14.694 17.6915 14.0956C17.9499 14.0326 18.2211 14 18.5 14ZM5.5 8C6.88071 8 8 9.11929 8 10.5C8 11.8807 6.88071 13 5.5 13C4.11929 13 3 11.8807 3 10.5C3 9.11929 4.11929 8 5.5 8ZM18.5 8C19.8807 8 21 9.11929 21 10.5C21 11.8807 19.8807 13 18.5 13C17.1193 13 16 11.8807 16 10.5C16 9.11929 17.1193 8 18.5 8ZM5.5 10C5.22386 10 5 10.2239 5 10.5C5 10.7761 5.22386 11 5.5 11C5.77614 11 6 10.7761 6 10.5C6 10.2239 5.77614 10 5.5 10ZM18.5 10C18.2239 10 18 10.2239 18 10.5C18 10.7761 18.2239 11 18.5 11C18.7761 11 19 10.7761 19 10.5C19 10.2239 18.7761 10 18.5 10ZM12 2C14.2091 2 16 3.79086 16 6C16 8.20914 14.2091 10 12 10C9.79086 10 8 8.20914 8 6C8 3.79086 9.79086 2 12 2ZM12 4C10.8954 4 10 4.89543 10 6C10 7.10457 10.8954 8 12 8C13.1046 8 14 7.10457 14 6C14 4.89543 13.1046 4 12 4Z" fill="#6554C0"/>
                                    </svg>
                                    <h6>{{$count}} Bursiyer</h6>
                                    <p>{{$city}}</p>
                                </div>
                            </div>
                            @endforeach
                            </div>
                            <div id="container" style="width:100%; height:400px;"></div>
                        </div>
                    </div>


                    <!-- Kategori -->
                    <div class="col-lg-5 col-md-12 mt-4">
                        <div class="chart-container h-100">
                            <div class="category-header">
                                <h5>Bursiyer Öğrenim Türü Analizi</h5>
                            </div>
                            <div class="category-bar-container">
                                <div class="category-bar-label">
                                    <span class="category-bar-label-left">İlkokul</span>
                                    <div class="category-bar-label-right">
                                        <span>%</span>
                                        <span>{{$educTypes[0]['ilkokul']}} Bursiyer <svg xmlns="http://www.w3.org/2000/svg" width="10" height="18" viewBox="0 0 10 14" fill="none">
                        <path d="M4.4 13C4.4 13.3314 4.66863 13.6 5 13.6C5.33137 13.6 5.6 13.3314 5.6 13H4.4ZM5.42426 0.575736C5.18995 0.341421 4.81005 0.341421 4.57574 0.575736L0.757359 4.39411C0.523045 4.62843 0.523045 5.00833 0.757359 5.24264C0.991674 5.47696 1.37157 5.47696 1.60589 5.24264L5 1.84853L8.39411 5.24264C8.62843 5.47696 9.00833 5.47696 9.24264 5.24264C9.47696 5.00833 9.47696 4.62843 9.24264 4.39411L5.42426 0.575736ZM5.6 13V1H4.4V13H5.6Z" fill="#4069E5" />
                        </svg></span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar category-bar bg-primary" style="width: {{$educTypes[1]['ilkokul']}}%"></div>
                                </div>
                            </div>
                            <div class="category-bar-container">
                                <div class="category-bar-label">
                                    <span class="category-bar-label-left">Ortaokul</span>
                                    <div class="category-bar-label-right">
                                        <span>%</span>
                                        <span>{{$educTypes[0]['ortaokul']}} Bursiyer <svg xmlns="http://www.w3.org/2000/svg" width="10" height="18"
                                                               viewBox="0 0 10 14" fill="none">
                            <path
                                d="M4.4 13C4.4 13.3314 4.66863 13.6 5 13.6C5.33137 13.6 5.6 13.3314 5.6 13H4.4ZM5.42426 0.575736C5.18995 0.341421 4.81005 0.341421 4.57574 0.575736L0.757359 4.39411C0.523045 4.62843 0.523045 5.00833 0.757359 5.24264C0.991674 5.47696 1.37157 5.47696 1.60589 5.24264L5 1.84853L8.39411 5.24264C8.62843 5.47696 9.00833 5.47696 9.24264 5.24264C9.47696 5.00833 9.47696 4.62843 9.24264 4.39411L5.42426 0.575736ZM5.6 13V1H4.4V13H5.6Z"
                                fill="#4069E5" />
                        </svg>
                    </span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar category-bar bg-info" style="width: {{$educTypes[1]['ortaokul']}}%"></div>
                                </div>
                            </div>
                            <div class="category-bar-container">
                                <div class="category-bar-label">
                                    <span class="category-bar-label-left">Lise</span>
                                    <div class="category-bar-label-right">
                                        <span> %</span>
                                        <span>{{$educTypes[0]['lise']}} Bursiyer <svg xmlns="http://www.w3.org/2000/svg" width="10" height="18"
                                                               viewBox="0 0 10 14" fill="none">
                            <path
                                d="M4.4 13C4.4 13.3314 4.66863 13.6 5 13.6C5.33137 13.6 5.6 13.3314 5.6 13H4.4ZM5.42426 0.575736C5.18995 0.341421 4.81005 0.341421 4.57574 0.575736L0.757359 4.39411C0.523045 4.62843 0.523045 5.00833 0.757359 5.24264C0.991674 5.47696 1.37157 5.47696 1.60589 5.24264L5 1.84853L8.39411 5.24264C8.62843 5.47696 9.00833 5.47696 9.24264 5.24264C9.47696 5.00833 9.47696 4.62843 9.24264 4.39411L5.42426 0.575736ZM5.6 13V1H4.4V13H5.6Z"
                                fill="#4069E5" />
                        </svg>
                    </span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar category-bar bg-success" style="width: {{$educTypes[1]['lise']}}%"></div>
                                </div>
                            </div>
                            <div class="category-bar-container">
                                <div class="category-bar-label">
                                    <span class="category-bar-label-left"> Ön Lisans</span>
                                    <div class="category-bar-label-right">
                                        <span> %</span>
                                        <span>{{$educTypes[0]['onlisans']}} Bursiyer <svg xmlns="http://www.w3.org/2000/svg" width="10" height="18"
                                                               viewBox="0 0 10 14" fill="none">
                            <path
                                d="M4.4 13C4.4 13.3314 4.66863 13.6 5 13.6C5.33137 13.6 5.6 13.3314 5.6 13H4.4ZM5.42426 0.575736C5.18995 0.341421 4.81005 0.341421 4.57574 0.575736L0.757359 4.39411C0.523045 4.62843 0.523045 5.00833 0.757359 5.24264C0.991674 5.47696 1.37157 5.47696 1.60589 5.24264L5 1.84853L8.39411 5.24264C8.62843 5.47696 9.00833 5.47696 9.24264 5.24264C9.47696 5.00833 9.47696 4.62843 9.24264 4.39411L5.42426 0.575736ZM5.6 13V1H4.4V13H5.6Z"
                                fill="#4069E5" />
                        </svg>
                    </span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar category-bar bg-secondary" style="width: {{$educTypes[1]['onlisans']}}%"></div>
                                </div>
                            </div>
                            <div class="category-bar-container">
                                <div class="category-bar-label">
                                    <span class="category-bar-label-left">Lisans</span>
                                    <div class="category-bar-label-right">
                                        <span> %</span>
                                        <span>{{$educTypes[0]['lisans']}} Bursiyer <svg xmlns="http://www.w3.org/2000/svg" width="10" height="18"
                                                               viewBox="0 0 10 14" fill="none">
                            <path
                                d="M4.4 13C4.4 13.3314 4.66863 13.6 5 13.6C5.33137 13.6 5.6 13.3314 5.6 13H4.4ZM5.42426 0.575736C5.18995 0.341421 4.81005 0.341421 4.57574 0.575736L0.757359 4.39411C0.523045 4.62843 0.523045 5.00833 0.757359 5.24264C0.991674 5.47696 1.37157 5.47696 1.60589 5.24264L5 1.84853L8.39411 5.24264C8.62843 5.47696 9.00833 5.47696 9.24264 5.24264C9.47696 5.00833 9.47696 4.62843 9.24264 4.39411L5.42426 0.575736ZM5.6 13V1H4.4V13H5.6Z"
                                fill="#4069E5" />
                        </svg>
                    </span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar category-bar bg-warning" style="width: {{$educTypes[1]['lisans']}}%"></div>
                                </div>
                            </div>
                            <div class="category-bar-container">
                                <div class="category-bar-label">
                                    <span class="category-bar-label-left">Yüksek Lisans</span>
                                    <div class="category-bar-label-right">
                                        <span> %</span>
                                        <span>{{$educTypes[0]['yukseklisans']}} Bursiyer <svg xmlns="http://www.w3.org/2000/svg" width="10" height="18"
                                                               viewBox="0 0 10 14" fill="none">
                            <path
                                d="M4.4 13C4.4 13.3314 4.66863 13.6 5 13.6C5.33137 13.6 5.6 13.3314 5.6 13H4.4ZM5.42426 0.575736C5.18995 0.341421 4.81005 0.341421 4.57574 0.575736L0.757359 4.39411C0.523045 4.62843 0.523045 5.00833 0.757359 5.24264C0.991674 5.47696 1.37157 5.47696 1.60589 5.24264L5 1.84853L8.39411 5.24264C8.62843 5.47696 9.00833 5.47696 9.24264 5.24264C9.47696 5.00833 9.47696 4.62843 9.24264 4.39411L5.42426 0.575736ZM5.6 13V1H4.4V13H5.6Z"
                                fill="#4069E5" />
                        </svg>
                    </span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar category-bar bg-dark" style="width: {{$educTypes[1]['yukseklisans']}}%%"></div>
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
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



        <script src="{{url('public')}}/assets/js/components/modal.js"></script>
        <script src="{{url('public')}}/assets/js/tables/scholar-table.js"></script>
        <script src="{{url('public')}}/assets/js/registration.renewal.js"></script>
        <script>
            $(document).ready(function () {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('showModal') === 'true') {
                    $('#applicationPeriodModal').modal('show');
                }
            });
        </script>
<script>
    $(document).ready(function() {
    $('#citySelect').select2({
        placeholder: 'Şehir Seçiniz',
        data: {!! json_encode($allCities) !!}
    });
    function loadCityAnalysis(city = 'all', limit = 6) {
        $.ajax({
            url: '{{ route("city.statics", ["city" => ":city", "limit" => ":limit"]) }}'.replace(':city', city).replace(':limit', limit),
            method: 'GET',
            success: function(data) {
                let html = '';
                $.each(data, function(city, count) {
                    html += `
                        <div class="col-lg-3 col-md-6 col-12 mb-3">
                            <div class="card-overview-analys card-overview-analys-two">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 11C14.7614 11 17 13.2386 17 16V22H15V16C15 14.4023 13.7511 13.0963 12.1763 13.0051L12 13C10.4023 13 9.09634 14.2489 9.00509 15.8237L9 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5.5 14C5.77885 14 6.05009 14.0326 6.3101 14.0942C6.14202 14.594 6.03873 15.122 6.00896 15.6693L6 16L6.0007 16.0856C5.88757 16.0456 5.76821 16.0187 5.64446 16.0069L5.5 16C4.7203 16 4.07955 16.5949 4.00687 17.3555L4 17.5V22H2V17.5C2 15.567 3.567 14 5.5 14ZM18.5 14C20.433 14 22 15.567 22 17.5V22H20V17.5C20 16.7203 19.4051 16.0796 18.6445 16.0069L18.5 16C18.3248 16 18.1566 16.03 18.0003 16.0852L18 16C18 15.3343 17.8916 14.694 17.6915 14.0956C17.9499 14.0326 18.2211 14 18.5 14ZM5.5 8C6.88071 8 8 9.11929 8 10.5C8 11.8807 6.88071 13 5.5 13C4.11929 13 3 11.8807 3 10.5C3 9.11929 4.11929 8 5.5 8ZM18.5 8C19.8807 8 21 9.11929 21 10.5C21 11.8807 19.8807 13 18.5 13C17.1193 13 16 11.8807 16 10.5C16 9.11929 17.1193 8 18.5 8ZM5.5 10C5.22386 10 5 10.2239 5 10.5C5 10.7761 5.22386 11 5.5 11C5.77614 11 6 10.7761 6 10.5C6 10.2239 5.77614 10 5.5 10ZM18.5 10C18.2239 10 18 10.2239 18 10.5C18 10.7761 18.2239 11 18.5 11C18.7761 11 19 10.7761 19 10.5C19 10.2239 18.7761 10 18.5 10ZM12 2C14.2091 2 16 3.79086 16 6C16 8.20914 14.2091 10 12 10C9.79086 10 8 8.20914 8 6C8 3.79086 9.79086 2 12 2ZM12 4C10.8954 4 10 4.89543 10 6C10 7.10457 10.8954 8 12 8C13.1046 8 14 7.10457 14 6C14 4.89543 13.1046 4 12 4Z" fill="#6554C0"/>
                                </svg>
                                <h6>${count} Bursiyer</h6>
                                <p>${city}</p>
                            </div>
                        </div>
                    `;
                });
                $('#cityAnalysisContent').html(html);
            }
        });
    }

    $('#citySelect').on('change', function() {
        let selectedCity = $(this).val();
        let limit = selectedCity === 'all' ? 1000 : 6;
        loadCityAnalysis(selectedCity, limit);
    });

    // Initial load with all cities
    loadCityAnalysis('all');
});
</script>
                    @include('includes.js.sidebar')

        @endsection
