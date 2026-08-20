@php
use Carbon\Carbon;
@endphp
@extends('layouts.student.master')
@section('title')
    Başvuru Formu
@endsection
@section('page-title')
    Başvuru Formu
@endsection
@section('local-css')

@endsection
@section('body')

@endsection
@section('content')
    <main class="main-content px-3 py-4">
        <div class=" mt-1">
         <div class="table-responsive mt-3">
                <table class="table table-hover" id="studentApplicationTable">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="checkbox" id="selectAll">
                        </th>
                        <th>Fotoğraf</th>
                        <th>
                            <div class="dropdown-sort">
                                <span>Başvuru No.</span>
                                <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="sortTable(2, 'asc')">A'dan Z'ye</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="sortTable(2, 'desc')">Z'den A'ya</a></li>
                                </ul>
                            </div>
                        </th>
                        <th>
                            <div class="dropdown-sort">
                                <span>Ad</span>
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
                        <th>
                            <div class="dropdown-sort">
                                <span>Soyad</span>
                                <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="sortTable(5, 'asc')">A'dan Z'ye</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="sortTable(5, 'desc')">Z'den A'ya</a></li>
                                </ul>
                            </div>
                        </th>
                        <th>
                            <div class="dropdown-sort">
                                <span>Başvuru Durumu</span>
                                <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu" >
                                    <li><a class="dropdown-item" href="#" onclick="sortTable(7, 'asc')">A'dan Z'ye</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="sortTable(7, 'desc')">Z'den A'ya</a></li>
                                </ul>
                            </div>
                        </th>
                        <th>
                            <div class="dropdown-sort">
                                <span>Başvuru Dönemi</span>
                                <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.636 12.9498L17.5858 8L19 9.41422L12.636 15.7782L6.27212 9.41422L7.68632 8L12.636 12.9498Z" fill="#1A1A1A" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'asc', 'status')">Onaylandı</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc', 'status')">Mülakat Bekliyor</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="sortTable(8, 'desc', 'status')">Red Edildi</a></li>
                                </ul>
                            </div>
                        </th>
                        <th>Seçenekler</th>
                    </tr>
                    </thead>
                    <tbody id="studentApplicationTableBody">

                        <tr>
                            <td><input type="checkbox" class="checkbox"></td>
                            @php
                            $form = $forms[0];
                                $fotografPath = null;
                                $fotografPath  = $form->doc_fotograf;
                            @endphp
                            <td>
                                <img width='50' height="50"  src="{{ $fotografPath ? url($fotografPath) : url('/assets/images/default-profile.svg') }}" alt="Profile Photo" class=" rounded-circle px50img img-fluid">
                            </td>
                            <td>{{$form->id}}</td>
                            <td>{{$form->name}}</td>
                            <td>{{$form->surname}}</td>
                            <td> @switch($form->status) @case(4) <span class="status-box-danger">Red Edildi</span> @break @case(3) <span class="status-box-success">Onaylandı</span> @break @case(2) <span class="badge bg-warning">Iade Edildi</span> @break @case(1) <span class="status-box-warning">Onay Bekliyor</span> @break  @case(0) <span class="status-box-warning">Devam Ediyor</span> @endswitch </td>
                            <td>{{$donem}}</td>
                            <td>
                                @php
                                $statusCheck = ($form->status != 1 && $form->status != 3 && $form->status != 4);
                                $periodStatusCheck = $form->period->status == 1;
                                $endTimeCheck = Carbon::parse($form->period->end_time)->greaterThanOrEqualTo(Carbon::now()->startOfDay());
                                $now = Carbon::now();
                                $endTime = Carbon::parse($form->period->end_time);
                                $isIade = $form->status == 2;
                            @endphp
                                <button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#636363"/>
                                    </svg></button>
                                @if(($statusCheck && $periodStatusCheck && $endTimeCheck) || $isIade)
                                    <a href="{{ route('get_scholarship_form', ['tip' => $form->educationType ?? 'default_value']) }}">
                                        <button class="btn edit-application-info-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                                            </svg>
                                        </button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

@endsection
@section('scripts')
    <!-- App js -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Toastr kütüphanesi - jQuery'den sonra yükle -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Toastr ayarları
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Session mesajlarını kontrol et
        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>

    <script src="{{url('')}}/assets/js/components/dashboard-student.js"></script>
    <script src="{{url('')}}/assets/js/components/modal.js"></script>
                @include('includes.js.sidebar')


@endsection
