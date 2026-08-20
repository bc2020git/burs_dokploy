@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
     Versiyonlar
@endsection
@section('local-css')
    <style>
        .actif-badge{
            position: absolute;
            top: 27px;
            right: 0;
        }
    </style>
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')

    <div class="container-fluid ">
                    <div class="d-flex justify-content-between align-items-center flex-wrap buttons">
                        <!-- Sol -->
                        <div class="d-flex flex-wrap mb-2">
                            <button type="button" class="btn me-2 text-white newAddM" id="newAdd"
                                onclick="window.location.href='{{ route('versions.create') }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                                </svg>
                                Yeni
                            </button>
                        </div>
                        <!-- Sag -->
                        <div class="navbar-button-container">
                            <button type="button" class="btn btn-outline-primary" id="reload" data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                                    <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z" fill="#4069E5"></path>
                                </svg>
                            </button>
                        </div>

                </div>
    <table id='membershipTable' class=" mt-3 table ">
        @include('panel.includes.datatable-head')
        <tbody>
            @php $i=1; @endphp
            @foreach ($versions as $version)
                <tr>
                    <td><input type="checkbox" name="versionCheckbox" id="versionCheckbox" data-id="{{ $version->id }}"></td>
                    <td>{{ $version->frontend_version }}</td>
                    <td>{{ $version->frontend_date }}</td>
                    <td>{{ $version->backend_version }}</td>
                    <td>{{ $version->backend_date }}</td>
                    <td class="position-relative">
                        @if($i==1) <span class="badge actif-badge  translate-middle badge rounded-pill bg-success">Aktif</span>  @endif
                        <a href="{{ route('versions.edit', $version->id) }}" ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"></path>
                            </svg></a>
                        <button onclick="location.href= '{{route('versions.delete',['id'=>$version->id])}}' " class="btn  delete-version" data-id="{{ $version->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z" fill="#4069E5"></path>
                            </svg></button>
                    </td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>
            </div>
        </main>


    @endsection
    @section('local-js')
        <!-- App js -->

               <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        @include('panel.settings.versions.scriptf')
        @include('panel.includes.filtreleme')
        @include('includes.js.toastr')

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

        </script>

@endsection

