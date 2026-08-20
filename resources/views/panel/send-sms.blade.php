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

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <div class="backdrop" id="backdrop" style="display: none;"></div>
        <main class="main-content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="mt-1">
                        <div class=" main-container">
                            <div class="row mb-3">
                                <div class="col-12 ">
                                    <div class="add-dues-form d-flex justify-content-between">
                                        <label for="recipients" class="form-label ">Alıcı Bursiyerler </label>
                                        <span>Alıcı Sayısı : <span id="memberCountDues">1</span></span>
                                    </div>
                                    <div class="recipient-input">
                                        <select class="js-example-basic-multiple" id="alicilar" name="alicilar[]" multiple="multiple">
                                            @foreach($alici as $a)
                                                <option selected value="{{$a->tel_no}}">{{$a->name}} {{$a->surname}}</option>
                                            @endforeach
                                            <optgroup label="Aktif Bursiyerler">
                                                @foreach($bursiyerler as $bursiyer)
                                                    <option value="{{$bursiyer->tel_no}}">{{$bursiyer->name}} {{$bursiyer->surname}}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Aday Bursiyerler">
                                                @foreach($adaylar as $aday)
                                                    <option value="{{$aday->tel_no}}">{{$aday->name}} {{$aday->surname}}</option>
                                                @endforeach
                                            </optgroup>

                                        </select>
                                        <label for="alicilar">
                                            <svg id="addMemberName" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                                <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 11H7V13H11V17H13V13H17V11H13V7H11V11Z" fill="#0065FF"/>
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <label for="emailSubject" class="form-label">Sms Bilgileri</label>
                            <div class=" main-container">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <textarea id="message" name="message" class="form-control email-body" rows="4" placeholder="SMS içeriğini giriniz..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="transfer-modal-footer g-3 ">
                                <button type="button"   onclick="window.history.back()" class="btn btn-outline-primary" data-bs-dismiss="modal">Vazgeç </button>
                                <button type="button" class="btn btn-primary" id="send-sms-message-button">
                                    Gönder</button>
                            </div>
                        </div>
                    </div>
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
    </script>

        <script src="{{url('public')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('public')}}/assets/js/components/modal.js"></script>
        <script src="{{url('public')}}/assets/js/tables/scholar-table.js"></script>
        <script src="{{url('public')}}/assets/js/registration.renewal.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('showModal') === 'true') {
                    $('#applicationPeriodModal').modal('show');
                }
                $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
            });
        </script>

        <script>
            function sortTable(column, order) {
                const table = document.getElementById("registrationRenewalTable");
                const tbody = table.tBodies[0];
                const rows = Array.from(tbody.querySelectorAll("tr"));

                rows.sort((a, b) => {
                    const cellA = a.cells[column].innerText.toLowerCase();
                    const cellB = b.cells[column].innerText.toLowerCase();

                    if (order === 'asc') {
                        return cellA > cellB ? 1 : cellA < cellB ? -1 : 0;
                    } else {
                        return cellA < cellB ? 1 : cellA > cellB ? -1 : 0;
                    }
                });

                rows.forEach(row => tbody.appendChild(row));
            }
        </script>
                    @include('includes.js.sidebar')

        <script>
            $(document).ready(function() {
                $('#send-sms-message-button').click(function() {
                    // Seçili telefon numaralarını al
                    var selectedNumbers = $('#alicilar').val();
                    var message = $('#message').val();
                    console.log(selectedNumbers,message);
                    if (!selectedNumbers || selectedNumbers.length === 0) {
                        toastr.error('Lütfen en az bir alıcı seçin');
                        return;
                    }

                    if (!message) {
                        toastr.error('Lütfen bir mesaj girin');
                        return;
                    }

                    $.ajax({
                        url: '{{ route("send.bulk.sms") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            phones: selectedNumbers,  // Telefon numaraları array olarak gönderiliyor
                            message: message
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(function() {
                                    window.location.href = '{{ url()->previous() }}';
                                }, 2000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('SMS gönderimi sırasında bir hata oluştu');
                        }
                    });
                });

                // Select2 başlat
                $('.js-example-basic-multiple').select2();

                // Seçili kişileri otomatik olarak ekle
                @if(isset($alici) && count($alici) > 0)
                    var preSelectedNumbers = [];
                    @foreach($alici as $a)
                        preSelectedNumbers.push('{{ $a->tel_no }}');
                    @endforeach
                    $('#alicilar').val(preSelectedNumbers).trigger('change');
                @endif
            });
        </script>

@endsection
