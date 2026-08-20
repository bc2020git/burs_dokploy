@extends('layouts.master')
@section('title')
    Yönetici Paneli - Mülakatlar
@endsection
@section('page-title')
    Mülakatlar
@endsection
@section('local-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">

        <style>
        .pika-single {
            z-index: 9999 !important;
        }
        #interviewTable  tr:hover {
        background-color: #ddeafe  ;
        }

        .edit-interview-btn {
            background: none;
            border: none;
            padding: 5px;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .edit-interview-btn:hover {
            background-color: #f8f9fa;
        }

        .conclude-interview-btn {
            background: none;
            border: none;
            padding: 5px;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .conclude-interview-btn:hover {
            background-color: #d4edda;
        }

        #interviewNotifyStatusModal .modal-dialog {
            max-width: 560px;
        }

        #interviewNotifyStatusModal .modal-content {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 16px 48px rgba(15, 23, 42, 0.18);
            overflow: hidden;
        }

        #interviewNotifyStatusModal .modal-body {
            padding: 28px;
            width: fit-content;
        }

        #interviewNotifyStatusBody .notify-result-message {
            width: 100%;
            max-width: 100%;
            margin: 0;
            border-radius: 10px;
            word-break: break-word;
        }

        .notify-result-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 18px;
            text-align: left;
        }

        .notify-result-item {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 10px 12px;
            background: #f8fafc;
        }

        .notify-result-label {
            display: block;
            color: #6c757d;
            font-size: 12px;
            line-height: 1.2;
        }

        .notify-result-value {
            display: block;
            color: #212529;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.25;
            margin-top: 4px;
        }

        .notify-result-help {
            color: #6c757d;
            font-size: 12px;
            margin-top: 12px;
        }

        @media (max-width: 575.98px) {
            .notify-result-grid {
                grid-template-columns: 1fr;
            }
        }

    </style>

@endsection

@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
                    <div class="d-flex">
                        <button type="button" class="btn me-3 text-white" id="createInterview" data-bs-toggle="modal"
                                data-bs-target="#createInterviewModal">
                            Mülakat Oluştur
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                            </svg>
                        </button>
                        <button type="button" class="btn me-3 text-white" id="updateInterview" >Mülakatı Güncelle
                        </button>
                    </div>
                    <div class="btn-toolbar  mb-md-0">
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-primary me-3" id="notifyInterviewGroup">
                                Mülakat Grubuna Bildir
                            </button>
                            <button type="button" class="btn btn-sm me-3" id="search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
                                    <path
                                        d="M15.0258 13.8474L18.5948 17.4163L17.4163 18.5948L13.8473 15.0259C12.5641 16.0526 10.9367 16.6667 9.16667 16.6667C5.02667 16.6667 1.66667 13.3067 1.66667 9.16675C1.66667 5.02675 5.02667 1.66675 9.16667 1.66675C13.3067 1.66675 16.6667 5.02675 16.6667 9.16675C16.6667 10.9367 16.0525 12.5642 15.0258 13.8474ZM13.3539 13.2291C14.3729 12.1789 15 10.7464 15 9.16675C15 5.94383 12.3896 3.33341 9.16667 3.33341C5.94376 3.33341 3.33334 5.94383 3.33334 9.16675C3.33334 12.3897 5.94376 15.0001 9.16667 15.0001C10.7463 15.0001 12.1788 14.373 13.229 13.354L13.3539 13.2291Z"
                                        fill="#0065FF" />
                                </svg>
                            </button>
                            <div class="navbar-search-container">
                                <input type="text" id="navbar-search-input" class="form-control" placeholder="Ara...">
                            </div>
                        </div>
                        <div class="dropdown-export">
                            <button type="button" class="btn me-3" id="export" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
                                    <path
                                        d="M3.33334 15.8333H16.6667V10H18.3333V16.6667C18.3333 17.1269 17.9603 17.5 17.5 17.5H2.50001C2.03977 17.5 1.66667 17.1269 1.66667 16.6667V10H3.33334V15.8333ZM10.8333 7.5V13.3333H9.16667V7.5H5.00001L10 2.5L15 7.5H10.8333Z"
                                        fill="#0065FF" />
                                </svg>
                                Dışa Aktar
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8"
                                     fill="none">
                                    <path
                                        d="M6.63602 4.94978L11.5858 0L13 1.41422L6.63602 7.77818L0.272121 1.41422L1.68632 0L6.63602 4.94978Z"
                                        fill="#0065FF" />
                                </svg>
                            </button>
                            <ul class="dropdown-menu " id="export-menu" aria-labelledby="export">
                                <li id="pdfButton" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/pdf.svg" alt="PDF" width="24" height="24">
                                        PDF olarak aktar
                                    </a></li>
                                <li id="excelButton" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/excel.svg" alt="Excel" width="24" height="24">
                                        Excel dosyasında aktar
                                    </a></li>
                                <li id="wordExport" ><a class="dropdown-item" href="#">
                                        <img src="../assets/images/word.svg" alt="Word" width="24" height="24">
                                        Word dosyasında aktar
                                    </a></li>
                                <li id="csvButton"><a class="dropdown-item" href="#">
                                        <img src="../assets/images/csv.svg" alt="CSV" width="24" height="24">
                                        .csv olarak aktar
                                    </a></li>
                            </ul>
                        </div>
                        <div class="dropdown-columns">
                            <button type="button" class="btn btn-primary me-3" id="column" data-bs-toggle="dropdown"
                                    aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="left" title="Sütunlar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
                                    <path
                                        d="M9.16667 4.16667H4.16667V15.8333H9.16667V4.16667ZM10.8333 4.16667V15.8333H15.8333V4.16667H10.8333ZM3.33333 2.5H16.6667C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5Z"
                                        fill="#0065FF" />
                                </svg>
                            </button>
                            @php $docColumns = ['doc_ogrenciBelgesi','doc_adlisicilkaydi','doc_nufuskayitornegi','doc_annegelirbelgesi','doc_babagelirbelgesi','doc_taahhutname','doc_kimlik','doc_bankahesap','doc_transkript','doc_ikametgah','doc_Karne','doc_Diger']; @endphp
                            <div class="dropdown-menu" id="colvis-menu"  aria-labelledby="column">
                                @foreach($columns as $column)
                                <div class="form-check">
                                    <input class="form-check-input column-visibility"
                                           type="checkbox"
                                           id="{{ $column['name'] }}Checkbox"
                                           data-column="{{ $column['name'] }}"
                                           @if(!in_array($column['name'], $docColumns)) checked @endif>
                                    <label class="form-check-label" for="{{ $column['name'] }}Checkbox">
                                        {{ $column['title'] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>                        <button type="button" class="btn btn-outline-primary me-3" id="waste"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Sil">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                    fill="#4069E5" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="reload"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                                <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z"  fill="#4069E5" ></path>
                            </svg>
                        </button>
                    </div>
                </div>



                <div class="form-container1">
                    <div class="mt-1">
                        <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link active" id="waiting-interview-tab" data-bs-toggle="tab"
                                     data-bs-target="#waiting-interview" type="button" role="tab"
                                     aria-controls="waiting-interview" aria-selected="true" data-target="1">Bekleyen
                                     Mülakatlar</button>
                             </li>
                              <li class="nav-item" role="presentation">
                                 <button class="nav-link" id="completed-interview-tab" data-bs-toggle="tab"
                                     data-bs-target="#completed-interview" type="button" role="tab"
                                     aria-controls="completed-interview" aria-selected="false" data-target="2">Tamamlanan
                                     Mülakatlar</button>
                             </li>

                         </ul> -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="waiting-interview" role="tabpanel"
                                 aria-labelledby="waiting-interview-tab" data-content="1">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover" id="interviewTable">
                                        @include('panel.includes.datatable-head-guncel')

                                        <tbody id="interviewTableBody">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!--Modal Alanı-->
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
                        <p class="title">Mülakat bilgilerini giriniz.</p>
                        <p class="small">Oluştur butonuna bastığınızda aday otomatik olarak bilgilendirilecektir.</p>
                        <form id="createInterviewForm" action="{{route('createInterviewToNew')}}" method="post"> @csrf
                            <input type="hidden" name="mulakatform" value="1">
                            <div class="mb-3 ">
                                <label for="modalinterviewType">Aday Bursiyer</label>
                                <select name="tc_no" class="form-select select2" id="modalinterviewType">
                                    @foreach($adaylar as $aday)
                                        <option value="{{$aday->tc_no}}">{{$aday->name}} {{$aday->surname}}  - {{$aday->tc_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="interviewDate">Mülakat Tarihi</label>
                                    <input name="date" type="text" class="form-control " id="interviewDate" placeholder="GG-AA-YYYY">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="interviewTime">Mülakat Saati</label>
                                    <input name="time" type="time" class="form-control" id="interviewTime">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="interviewType">Mülakat Tipi</label>
                                    <select name="type" class="form-select" id="interviewType">
                                        <option selected>Seçiniz…</option>
                                        <option value="Çevrim içi">Çevrim içi</option>
                                        <option value="Yüz Yüze">Yüz Yüze</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="interviewer">Mülakatı Yapacak Kişi</label>
                                    <select name="person" class="form-select" id="interviewer">
                                        <option selected disabled>Seçiniz…</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="meetingLink">Toplantı Linki / Adresi</label>
                                    <input name="address" type="text" class="form-control" id="meetingLink" placeholder="Yazınız...">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="interviewDescription">Mülakat Açıklaması</label>
                                    <textarea name="detail" class="form-control" id="interviewDescription" rows="3" placeholder="Yazınız..."></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn me-3" id="createInterviewCreateButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z" fill="#4069E5" />
                                </svg>
                                Mülakat Oluştur
                            </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Uyarı Modalı - Hiç Seçim Yapılmadığında -->
<div class="modal fade" id="interviewWarningModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5>Uyarı</h5>
                <p>Lütfen en  az bir mülakat seçiniz.</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
            </div>
        </div>
    </div>
</div>

<!-- Uyarı Modalı - Birden Fazla Seçim Yapıldığında -->
<div class="modal fade" id="multipleSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5>Uyarı</h5>
                <p>Lütfen sadece bir mülakat seçiniz.</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
            </div>
        </div>
    </div>
</div>

<!-- Mülakat Grubu Bildirimi Durum Modalı -->
<div class="modal fade" id="interviewNotifyStatusModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 id="interviewNotifyStatusTitle">Mülakat Grubu Bildirimi</h5>
                <div id="interviewNotifyStatusBody" class="mt-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Yükleniyor...</span>
                    </div>
                    <p class="mt-3 mb-0">İşlem devam ediyor...</p>
                </div>
                <button type="button" class="btn btn-primary mt-3 d-none" id="interviewNotifyStatusClose" data-bs-dismiss="modal">Kapat</button>
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
    @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Toastr ayarları
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };
        </script>
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
         <!-- Toastr kütüphanesi - jQuery'den sonra yükle -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/tr.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

        <script>
            $(document).ready(function(){
                // Pikaday initialization for create form
                // Ortak Pikaday ayarları
                const pikadayConfig = {
                    format: 'DD-MM-YYYY',
                    toString(date, format) {
                        const day = date.getDate().toString().padStart(2, '0');
                        const month = (date.getMonth() + 1).toString().padStart(2, '0');
                        const year = date.getFullYear();
                        return `${day}-${month}-${year}`;
                    },
                    parse(dateString, format) {
                        const parts = dateString.split('-');
                        return new Date(parts[2], parts[1] - 1, parts[0]);
                    },
                    i18n: {
                        previousMonth: 'Önceki Ay',
                        nextMonth: 'Sonraki Ay',
                        months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                        weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                        weekdaysShort: ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt']
                    }
                };

                // Pikaday initialization for create form
                const createDatePicker = new Pikaday({
                    ...pikadayConfig,
                    field: document.getElementById('interviewDate')
                });

                // Pikaday initialization for edit form
                const editDatePicker = new Pikaday({
                    ...pikadayConfig,
                    field: document.getElementById('editeditinterviewDate')
                });



                // AJAX başarılı olduğunda tarihi formatla
                $(document).ajaxSuccess(function(event, xhr, settings) {
                    if (settings.url === '/panel/Mulakat-bilgi') {
                        const response = xhr.responseJSON;
                        if (response && response.data && response.data.interview_date) {
                            $('#editeditinterviewDate').val(formatDateToDMY(response.data.interview_date));
                        }
                    }
                });
            });
             // Tarihi d-m-Y formatına çeviren yardımcı fonksiyon
             function formatDateToDMY(dateStr) {
                    if (!dateStr) return '';
                    const date = new Date(dateStr);
                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();
                    return `${day}-${month}-${year}`;
                }
        </script>

        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        @include('panel.interview.scriptf')

        @include('includes.js.sendsms')


            <script>
                $(document).ready(function() {
                    $('.select2').select2({
                    theme: 'bootstrap-5',
                    language: 'tr',
                    width: '100%',
                    placeholder: 'Aday Bursiyer Seçiniz',
                    allowClear: true
                });

                // Modal içinde select2 düzeltmesi
                $('.modal').on('shown.bs.modal', function () {
                    $('.select2').select2({
                        dropdownParent: $(this)
                    });
                });
                                const table= $('#interviewTable').DataTable();
                    // Tablo satırına çift tıklama olayı
                    $('.redirect-row').on('dblclick', function() {
                        const candidateId = $(this).data('id'); // Satırdan aday ID'sini al
                        const url = "{{ route('panel-aktif-bursiyer-incele', ['id' => ':id']) }}".replace(':id', candidateId);
                        window.location.href = url; // İlgili sayfaya yönlendir
                    });
                });
            </script>
            <script>
                function sortTable(column, order) {
                    const table = document.getElementById("graduateTable");
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
<script>
    $(document).ready(function() {
    // Event delegasyonu kullanarak tüm sayfalardaki düzenle butonları için listener ekle
    $('#interviewTable').on('click', '.edit-interview-btn', function(e) {
        e.stopPropagation();
        const id = $(this).data('id');
        window.location.href = `/panel/Mulakatlar/${id}/duzenle`;
    });

    // Diğer event listener'lar için de delegasyon kullanalım
    $('#interviewTable').on('click', 'input[name="userCheckbox"]', function(e) {
        e.stopPropagation();
    });



    // Mülakatı Güncelle butonu için (Top bar)
    $('#updateInterview').on('click', function() {
        const checkboxes = $('input[name="userCheckbox"]:checked');

        if (checkboxes.length === 0) {
            $('#interviewWarningModal').modal('show');
            return;
        }

        if (checkboxes.length > 1) {
            $('#multipleSelectionModal').modal('show');
            return;
        }

        // Seçili mülakatın ID'sini al
        const selectedId = checkboxes.first().data('id');

        // Yeni edit sayfasına yönlendir
        window.location.href = `/panel/Mulakatlar/${selectedId}/duzenle`;
    });
    });
        document.addEventListener('DOMContentLoaded', function() {
        // Tüm satırlar için click event listener ekle
        document.querySelectorAll('.interview-row').forEach(row => {
            row.addEventListener('click', function() {
                const adayId = this.getAttribute('data-aday-id');
                window.location.href = `/panel/Aday-Bursiyer-Incele/${adayId}`;
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function () {


        function getBadgeClass(status) {
            switch (status) {
                case 'Planlandı':
                    return ' status-box-success';
                case 'Planlama Bekliyor':
                    return ' status-box-warning ';
                case 'Mülakat Rededildi':
                    return ' status-box-danger';
                default:
                    return '';
            }
        }


        $('#pdfButton').on('click', function() {
            table.button('.buttons-pdf').trigger();
        });

        $('#excelButton').on('click', function() {
            table.button('.buttons-excel').trigger();
        });
        $('#search').on('click', function() {
            $('#interviewTable_filter label').toggleClass('d-none');
        });

        $('#notifyInterviewGroup').on('click', function() {
            const selectedIds = $('input[name="userCheckbox"]:checked').map(function() {
                return $(this).data('id');
            }).get();

            if (selectedIds.length === 0) {
                $('#interviewWarningModal').modal('show');
                return;
            }

            const button = $(this);
            const modalEl = document.getElementById('interviewNotifyStatusModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

            button.prop('disabled', true);
            setInterviewNotifyModalLoading();
            modal.show();

            $.ajax({
                url: '{{ route('mulakatlar.gruba-bildir') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: selectedIds
                },
                success: function(response) {
                    setInterviewNotifyModalResult(response, false);
                    if (typeof table !== 'undefined' && table.ajax) {
                        table.ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON || {
                        message: 'İşlem sırasında beklenmeyen bir hata oluştu.',
                        sent_count: 0,
                        failed_count: 1,
                        skipped_count: 0,
                        updated_interview_count: 0,
                        errors: [xhr.responseText || 'Sunucu yanıtı alınamadı.']
                    };
                    setInterviewNotifyModalResult(response, true);
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });
    });

    function setInterviewNotifyModalLoading() {
        $('#interviewNotifyStatusTitle').text('Mülakat Grubu Bildirimi');
        $('#interviewNotifyStatusClose').addClass('d-none');
        $('#interviewNotifyStatusBody').html(`
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Yükleniyor...</span>
            </div>
            <p class="mt-3 mb-0">İşlem devam ediyor...</p>
        `);
    }

    function setInterviewNotifyModalResult(response, isError) {
        const errors = Array.isArray(response.errors) ? response.errors : [];
        const errorHtml = errors.length
            ? `<div class="alert alert-warning notify-result-message text-start mt-3 mb-0">
                <strong>Detaylar:</strong>
                <ul class="mb-0 mt-2">${errors.slice(0, 5).map(error => `<li>${escapeHtml(error)}</li>`).join('')}</ul>
                ${errors.length > 5 ? `<div class="mt-2">+${errors.length - 5} ek detay daha var.</div>` : ''}
            </div>`
            : '';

        $('#interviewNotifyStatusTitle').text(isError ? 'Bildirim Gönderilemedi' : 'Bildirim Sonucu');
        $('#interviewNotifyStatusClose').removeClass('d-none');
        $('#interviewNotifyStatusBody').html(`
            <div class="alert ${isError ? 'alert-danger' : 'alert-success'} notify-result-message">
                ${escapeHtml(response.message || (isError ? 'İşlem başarısız.' : 'İşlem tamamlandı.'))}
            </div>
            <div class="notify-result-grid">
                <div class="notify-result-item">
                    <span class="notify-result-label">Seçilen mülakat</span>
                    <span class="notify-result-value">${escapeHtml(response.selected_count ?? 0)}</span>
                </div>
                <div class="notify-result-item">
                    <span class="notify-result-label">Gönderilen mail</span>
                    <span class="notify-result-value">${escapeHtml(response.sent_count ?? 0)}</span>
                </div>
                <div class="notify-result-item">
                    <span class="notify-result-label">Bildirim işaretlenen mülakat</span>
                    <span class="notify-result-value">${escapeHtml(response.updated_interview_count ?? 0)}</span>
                </div>
                <div class="notify-result-item">
                    <span class="notify-result-label">Atlanan / hatalı</span>
                    <span class="notify-result-value">${escapeHtml(response.skipped_count ?? 0)} / ${escapeHtml(response.failed_count ?? 0)}</span>
                </div>
            </div>
            <div class="notify-result-help">
                “Bildirim işaretlenen mülakat”, gönderimden sonra listede <strong>Bildirim Gönderildi Mi</strong> alanı <strong>Evet</strong> yapılan kayıt sayısıdır.
            </div>
            ${errorHtml}
        `);
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Satır tıklama olayı
    // $('#interviewTable tbody').on('click', 'tr', function () {
    //     window.location.href = "/admin/scholarship-application-list-documents.html";
    // });





    $(document).ready(function() {
            function islemIcinDiziGonder(islemid) {
                // Tüm checkbox'ları seç
                const selectedIds = [];
                const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                // Her bir işaretli checkbox'ın 'data-id' değerini al
                checkboxes.forEach(checkbox => {
                    const userId = checkbox.getAttribute('data-id');
                    if (userId) {
                        selectedIds.push(userId);
                    }
                });
                console.log(selectedIds.length);
                // İşlem ID'sini belirle
                const islemId = islemid;


                $.ajax({
                    url: '/delete-interviews',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds,
                        islemId: islemId,
                    },
                    success: function(response) {
                if (typeof toastr !== 'undefined' && typeof $ !== 'undefined') {
                    toastr.success('İşlem Başarılı');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    // Fallback olarak alert kullan
                    alert('İşlem Başarılı');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {
                toastr.error( 'İşlem Başarısız');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
                });
            }

        $('#waste').on('click', function() {
            islemIcinDiziGonder(1);
        });
        $('#updateInterview').on('click', function() {
            const updateInterviewModal = new bootstrap.Modal(document.getElementById('updateInterviewModal'));

            const checkboxes = document.querySelectorAll("#interviewTable tbody .checkbox");
            let checkedCount = 0;

            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    checkedCount++;
                }
            });

            if (checkedCount === 0) {
                interviewWarningModal.show();
            } else if (checkedCount === 1) {
                updateInterviewModal.show();
            } else {
                multipleSelectionModal.show();
            }
        });

        $('#csvButton').on('click', function() {
            table.button('.buttons-csv').trigger();
        });
        $('#reload').on('click', function() {
            location.reload();
        });
    });
    document.querySelectorAll('.edit-interview-info-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Butonun data attribute'lerinden bilgileri alıyoruz
            const id = this.getAttribute('data-id');
            const date = this.getAttribute('data-date');
            const time = this.getAttribute('data-time');
            const platform = this.getAttribute('data-platform');
            const person = this.getAttribute('data-person');
            const address = this.getAttribute('data-address');

            // Modal içindeki form alanlarını güncelliyoruz
            document.getElementById('mulakatid').value = id;
            document.getElementById('editeditinterviewDate').value = formatDate(date); // Tarihi formatlıyoruz
            document.getElementById('editinterviewTime').value = time;
            document.getElementById('editinterviewType').value = platform;

            // Mülakat grubu seçimini güncelle
            const interviewerSelect = document.getElementById('editinterviewer');
            const options = interviewerSelect.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].text === person) {
                    options[i].selected = true;
                    break;
                }
            }

            document.getElementById('editinterview_address').value = address;
        });
    });

    // Tarih formatını düzeltmek için yardımcı fonksiyon
    function formatDate(dateString) {
        const date = new Date(dateString);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
    </script>
        <script>
            function sortTable(column, order) {
                const table = document.getElementById("interviewTable");
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
<script !src="">



            document.addEventListener('DOMContentLoaded', function () {
                const updateInterviewBtn = document.getElementById('updateInterview');
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                const updateInterviewModal = new bootstrap.Modal(document.getElementById('updateInterviewModal'));
                const multipleSelectionModal = new bootstrap.Modal(document.getElementById('multipleSelectionModal')); // Birden fazla seçim için modal

                document.querySelectorAll('.edit-options-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const id = row.getAttribute('data-id');

                        // AJAX ile mülakat bilgilerini getir
                        $.ajax({
                            url: '/panel/Mulakat-bilgi',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            success: function(response) {
                                // Form alanlarını doldur
                                document.getElementById('mulakatid').value = response.data.id;
                                document.getElementById('editeditinterviewDate').value = response.data.interview_date;
                                document.getElementById('editinterviewTime').value = response.data.interview_time;
                                document.getElementById('editinterviewType').value = response.data.interview_platform;

                                // Mülakat grubu seçimini güncelle
                                const interviewerSelect = document.getElementById('editinterviewer');
                                Array.from(interviewerSelect.options).forEach(option => {
                                    if (option.text === response.data.interview_person) {
                                        option.selected = true;
                                    }
                                });

                                document.getElementById('editinterview_address').value = response.data.interview_address;

                                // Modalı göster
                                interviewDetailsModal.show();
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Hatası:", error);
                                }
                            });
                            });
                });
                updateInterviewBtn.addEventListener('click', function () {
                    const checkboxes = document.querySelectorAll("#interviewTable tbody .user-checkbox");
                    let checkedCount = 0;

                    checkboxes.forEach(function (checkbox) {
                        if (checkbox.checked) {
                            checkedCount++;
                        }
                    });

                    if (checkedCount === 0) {
                        interviewWarningModal.show();
                    } else if (checkedCount === 1) {
                        updateInterviewModal.show();
                    } else {
                        multipleSelectionModal.show();
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('updateInterviewDetails').addEventListener('click', function () {
                    $('#updateInterviewModal').modal('hide');
                    function getinterview() {
                        // Seçili checkbox'ları bul
                        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
                        if (selectedCheckboxes.length > 0) {
                            // İlk seçili checkbox
                            const firstCheckbox = selectedCheckboxes[0];
                            // data-id özniteliğini al
                            var dataId = firstCheckbox.getAttribute('data-id');
                            document.getElementById('mulakatid2').value = dataId;
                            document.getElementById('mulakatid').value = dataId;
                        }
                        $.ajax({
                            url: '/panel/Mulakat-bilgi',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: dataId,
                            },
                                                        success: function(response) {
                                console.log('AJAX Response:', response);
                                console.log('Interview Date:', response.data.interview_date);

                                const id = response.data.id;
                                const date = response.data.interview_date;
                                const time = response.data.interview_time;
                                const platform = response.data.interview_platform;
                                const person = response.data.interview_person;
                                const score = response.data.interview_score;
                                const result = response.data.interview_result;
                                const address = response.data.interview_address;

                                // Modal içindeki form alanlarını güncelliyoruz
                                document.getElementById('mulakatid2').value = id;
                                document.getElementById('mulakatid').value = id;

                                // Tarih formatlaması
                                if (date) {
                                    console.log('Original Date:', date);
                                    const [day, month, year] = date.split('-');
                                    const formattedDate = `${day}-${month}-${year}`;
                                    $('#editeditinterviewDate').val(formattedDate);

                                    // Pikaday'e tarihi set et
                                    const dateObj = new Date(year, month - 1, day);
                                    editDatePicker.setDate(dateObj, true);
                                } else {
                                    console.log('No Date Provided');
                                    $('#editeditinterviewDate').val('');
                                    editDatePicker.setDate(null);
                                }

                                document.getElementById('editinterviewTime').value = time;
                                document.getElementById('editinterviewType').value = platform;
                                document.getElementById('editinterviewer').value = person;
                                document.getElementById('endinterviewScore').value = score;
                                document.getElementById('endinterviewResult').value = result;
                                document.getElementById('editinterview_address').value = address;
                                console.log('Veriler gönderildi:', response);
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Hatası:", status, error);
                                console.error("Hata Detayları:", xhr.responseText);
                            }
                        });
                    }

                    getinterview();

                    $('#interviewDetailsModal').modal('show');
                });

                document.getElementById('concludeInterview').addEventListener('click', function () {
                    const checkboxes = $('input[name="userCheckbox"]:checked');

                    if (checkboxes.length > 1) {
                        $('#multipleSelectionModal').modal('show');
                        return;
                    }

                    // Seçili mülakatın ID'sini al
                    const selectedId = checkboxes.first().data('id');

                    // ID'yi form'a set et
                    $('#mulakatid2').val(selectedId);

                    // AJAX ile mülakat bilgilerini getir
                    $.ajax({
                        url: '/panel/Mulakat-bilgi',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: selectedId
                        },
                        success: function(response) {
                            // Form alanlarını doldur
                            $('#mulakatid2').val(response.data.id);
                            $('#endinterviewScore').val(response.data.interview_score);
                            $('#endinterviewResult').val(response.data.interview_result);

                            // Modalları değiştir
                            $('#updateInterviewModal').modal('hide');
                            $('#concludeInterviewModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Hatası:", error);
                        }
                    });
                });

                // İşlemler sütunundaki sonuçlandır butonu için event listener (event delegation kullanarak)
                $('#interviewTable').on('click', '.conclude-interview-btn', function(e) {
                    e.stopPropagation();

                    // Butonun data-id değerini al
                    const interviewId = $(this).data('id');

                    // ID'yi form'a set et
                    $('#mulakatid2').val(interviewId);

                    // AJAX ile mülakat bilgilerini getir
                    $.ajax({
                        url: '/panel/Mulakat-bilgi',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: interviewId
                        },
                        success: function(response) {
                            if (response.data) {
                                // Form alanlarını doldur
                                $('#mulakatid2').val(response.data.id);
                                $('#endinterviewScore').val(response.data.interview_score);
                                $('#endinterviewResult').val(response.data.interview_result);

                                // Modalı göster
                                $('#concludeInterviewModal').modal('show');
                            } else {
                                console.error("Mülakat bilgileri alınamadı");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Hatası:", error);
                        }
                    });
                });

                document.getElementById('interviewDetailsForm').addEventListener('submit', function (e) {
                    // Form submit işlemleri burada yapılabilir.
                    alert('Mülakat bilgileri güncellendi!');
                    $('#interviewDetailsModal').modal('hide');
                });

                document.getElementById('concludeInterviewForm').addEventListener('submit', function (e) {
                    const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                    // Form submit işlemleri burada yapılabilir.
                    alert('Mülakat sonuçları güncellendi!');
                    $('#concludeInterviewModal').modal('hide');
                });
            });
            document.addEventListener('DOMContentLoaded', function () {
                // Modal kapatıldığında backdrop'u temizle
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.addEventListener('hidden.bs.modal', function () {
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }
                    });
                });
            });
</script>
@include('includes.js.sidebar')

@endsection
