@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Form Düzenle
@endsection
@section('local-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <!--Duzenleme form baslangici-->
                <form action="{{route('panel-form-update')}}" method="post"> @csrf
                    <div class="navbar-button-container">



                    <!-- Form Butonlari -->
                    <div class="d-flex flex-wrap">
                        <button type="submit" class="btn btn-outline-primary me-3">Kaydet</button>
                        <a href="{{route('form-sorulari')}}"><button type="button" class="btn btn-outline-danger me-3" >Vazgeç</button></a>
                    </div>
                    <!-- Form Butonlari -->
                </div>
                <div class="mt-3 p-3 border">
                    <div class="card-title"><h3>Form Detayları</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <input name="id" id="id" type="hidden" class="form-control" value="{{$data->id}}">
                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="name" class="custom-label">Form Adı </label>
                                <input name="name" id="name" type="text" class="form-control" value="{{$data->title}}">

                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <!--Duzenleme form sonu-->

                <h3 class="mt-2" > {{$data->title}} Soruları</h3>
                <div class="d-flex flex-wrap">
                    <button type="button" class="btn me-3 text-white" id="graduate" data-bs-toggle="modal"
                            data-bs-target="#createInterviewModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none">
                            <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                        </svg>
                        Yeni Ekle
                    </button>

                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-hover" id="rankTable">
                        <thead>
                        <tr>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Soru Adı</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(3, 'asc', 'numeric')">Büyükten Küçüğe</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(3, 'desc', 'numeric')">Küçükten Büyüğe</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown-sort">
                                    <span>Durum</span>
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(4, 'asc')">A'dan Z'ye</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="sortTable(4, 'desc')">Z'den A'ya</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>Seçenekler</th>
                        </tr>
                        </thead>

                        <tbody id="candidateTableBody">
                            @foreach($sorular as $catsoru)
                                <tr data-id="{{ $catsoru->id }}">
                                    <td>{{$catsoru->name}}</td>
                                    <td> @switch($catsoru->status) @case('Pasif') <span class="status-box-danger">Pasif</span> @break @case('Aktif') <span class="status-box-success">Aktif</span> @break @endswitch  </td>
                                    <td>
                                        <a href="{{ route('panel-soru-detay', ['id' => $catsoru->id]) }}">
                                            <button class="btn edit-candidate-info-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                    <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                                                </svg>
                                            </button>
                                        </a>
                                        <a href="{{ route('panel-form-delete-question', ['id' => $catsoru->id,'form'=>$data->type]) }}">
                                            <button class="btn edit-candidate-info-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z" fill="#4069E5"></path>
                                                </svg>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        <!-- Soru Ekleme formu -->
            <div class="modal modal-lg fade"  id="createInterviewModal" tabindex="-1" aria-labelledby="createInterviewModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createInterviewModalLabel">Yeni Soru Ekle</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form method='post' action='{{route('panel-form-soru-ekle')}}'  id="createInterviewForm"> @csrf
                                <input type="hidden" name="type" value="{{$data->type}}">
                                <div class="col-sm-12 ">
                                    <label for="forms" class="custom-label">Eklenecek Sorular <span style="color: red" >(Birden fazla seçmek için CTRL basılı tutunuz) </span></label>
                                    <select style="z-index: 99"  class="js-exam" name="soru[]" multiple="multiple">
                                        @foreach($olmayansorular as $soru)
                                            <option style="z-index: 99" value="{{$soru->id}}">{{$soru->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button id="createInterviewCreateButton" type="submit"
                                        class="btn btn-primary mt-3">Oluştur</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        @include('includes.js.toastr')

    @endsection
    @section('scripts')
        <!-- App js -->

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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="{{url('')}}/assets/js/tables/candidate.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });



        </script>

    @include('includes.js.sidebar')

@endsection
