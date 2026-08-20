@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Form Soru Kategorisi Düzenle
@endsection
@section('local-css')
    <style>
        select>option:checked {
            background-color: var(--blue-600);
            color: ghostwhite;
        }
    </style>
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <!--Duzenleme form baslangici-->
                <form action="{{route('panel-soru-kategori-update')}}" method="post"> @csrf
                    <div class="navbar-button-container">



                    <!-- Form Butonlari -->

                    <!-- Form Butonlari -->
                </div>

                <div class="mt-3 p-3 border">
                    <div class="card-title"><h3>Kategori Detayları</h3></div>
                    <div class="card-body">
                        <div class="row">
                             <div class="col-sm-12 col-md-6 form-group">
                                     <label for="title" class="custom-label">Başlık</label>
                                     <input required name="title" id="title" type="text" class="form-control" value="{{$category->title}}">
                                     <input  name="old_table" id="old_table" type="hidden" class="form-control" value="{{$category->db_table}}">
                                     <input name="id" id="id" type="hidden" class="form-control" value="{{$category->id}}">
                             </div>
                             <div class="col-sm-12 col-md-6 form-group">
                                 <label for="status" class="custom-label">Durumu</label>
                                 <select  required id="status" name="status" class="form-select">
                                     <option @if($category->status == 'Aktif' ) selected @endif value="Aktif">Aktif</option>
                                     <option @if($category->status == 'Pasif' ) selected @endif value="Pasif">Pasif</option>
                                 </select>
                             </div>
                             <div class="col-sm-12 form-group">
                                 <label for="forms" class="custom-label">Gösterilen Formlar <span style="color: red" >(Birden fazla seçmek için CTRL basılı tutunuz) </span></label>
                                 <select required style="min-height: 160px" multiple id="forms" name="forms[]" class="form-select">


                                     <option @foreach(json_decode($category->forms) as $form) @if($form=='ilkokul') selected @endif @endforeach value="ilkokul">İlkokul</option>
                                     <option @foreach(json_decode($category->forms) as $form) @if($form=='ortaokul') selected @endif @endforeach value="ortaokul">Ortaokul</option>
                                     <option @foreach(json_decode($category->forms) as $form) @if($form=='lise') selected @endif @endforeach value="lise">Lise</option>
                                     <option @foreach(json_decode($category->forms) as $form) @if($form=='onlisans') selected @endif @endforeach value="onlisans">Ön lisans</option>
                                     <option @foreach(json_decode($category->forms) as $form) @if($form=='lisans') selected @endif @endforeach value="lisans">Lisans</option>
                                     <option @foreach(json_decode($category->forms) as $form) @if($form=='yukseklisans') selected @endif @endforeach value="yukseklisans">Yükseklisans</option>
                                     <option @foreach(json_decode($category->forms) as $form) @if($form=='doktora') selected @endif @endforeach value="doktora">Doktora</option>
                                 </select>
                             </div>

                        </div>
                    </div>
                </div>
                    <div class="transfer-modal-footer d-flex justify-content-end g-3 ">
                        <button type="submit" class="btn btn-outline-primary me-3">Kaydet</button>
                        <a href="{{route('form-sorulari')}}"><button type="button" class="btn btn-outline-danger me-3" >Vazgeç</button></a>
                    </div>
                </form>
                <!--Duzenleme form sonu-->

                <!--Kategori Soruları-->
                <div class="mt-3 p-3 border">
                    <div class="navbar-button-container">
                        <div class="d-flex flex-wrap">
                            <button type="button" class="btn me-3 text-white" id="graduate" data-bs-toggle="modal"
                                    data-bs-target="#createInterviewModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                                </svg>
                                Yeni
                            </button>

                        </div>
                        <div class="navbar-button-container">
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
                                    <li ><a id="pdfButton" class="dropdown-item" href="#">
                                            <img src="../assets/images/pdf.svg" alt="PDF" width="24" height="24">
                                            PDF olarak aktar
                                        </a></li>
                                    <li><a id="excelexportbtn" class="dropdown-item" href="#">
                                            <img src="../assets/images/excel.svg" alt="Excel" width="24" height="24">
                                            Excel dosyasında aktar
                                        </a></li>
                                    <li><a class="dropdown-item" href="#">
                                            <img src="../assets/images/word.svg" alt="Word" width="24" height="24">
                                            Word dosyasında aktar
                                        </a></li>
                                    <li><a class="dropdown-item" href="#">
                                            <img src="../assets/images/csv.svg" alt="CSV" width="24" height="24">
                                            .csv olarak aktar
                                        </a></li>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-outline-primary" id="waste5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path
                                        d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z"
                                        fill="#4069E5" />
                                </svg>
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="reload" data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                                    <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z" fill="#4069E5"></path>
                                </svg>
                            </button>
                        </div>

                    </div>

                    <h3 class="mt-2" > {{$category->title}} Kategorisi Soruları</h3>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover" id="rankTable">
                            <thead>
                            <tr>
                                <th>
                                    <div class="dropdown-sort">
                                        <span>#</span>
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
                                        <span>Başlık</span>
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
                            @if(isset($category->soru))
                                @foreach($category->soru as $catsoru)
                                    <tr data-id="{{ $catsoru->id }}">
                                        <td>{{$catsoru->siralama}}</td>
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
                                            <a href="{{ route('panel-soru-sil', ['id' => $catsoru->id]) }}">
                                                <button class="btn edit-candidate-info-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM15.0013 6.66699H5.0013V16.667H15.0013V6.66699ZM7.5013 9.16699H9.16797V14.167H7.5013V9.16699ZM10.8346 9.16699H12.5013V14.167H10.8346V9.16699ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z" fill="#4069E5"></path>
                                                    </svg>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

            <div class="modal fade" id="createInterviewModal" tabindex="-1" aria-labelledby="createInterviewModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createInterviewModalLabel">Soru Oluştur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="title">Soru bilgilerini giriniz</p>
                            <form method='post' action='{{route('panel-soru-ekle')}}'  id="createInterviewForm"> @csrf
                                <input type='hidden' id='category_id' name='category_id' value="{{$category->id}}" >
                                <input type='hidden' id='category_title' name='category_title' value="{{$category->title}}" >


                                @include('panel.tanimlar.components.questions.question-datas')
                                <button id="createInterviewCreateButton" type="submit"
                                        class="btn btn-primary mt-3">Oluştur</button>
                            </form>
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
        <link rel="stylesheet" href="https://datatables-cdn.com/buttons/1.7.1/css/buttons.dataTables.min.css">
        <script src="https://datatables-cdn.com/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>

        @include('includes.js.toastr')
        @php $tabloadi='sorus'; @endphp
        @include('includes.js.siralamaDegistir')
        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="{{url('')}}/assets/js/tables/candidate.js"></script>
        <script>
            function divGizle(){
                document.querySelectorAll('.attribute-div').forEach(function(div) {
                    div.classList.add('d-none');
                });

            }
            function anadivGoster(){
                var anadiv = document.getElementById('attributeDiv');

                // 'select' seçildiğinde 'd-none' sınıfını kaldır
                anadiv.classList.remove('d-none');
            }
            document.getElementById('type').addEventListener('change', function() {
                anadivGoster();
                divGizle();
                var selectedValue = this.value;
                var optionDiv = document.getElementById('attributeDiv');

                var inputField = optionDiv.querySelector('input[name="options[]"]');

                if (selectedValue === 'select') {

                    // 'select' seçildiğinde 'd-none' sınıfını kaldır
                    var selectdiv = document.getElementById('optiondiv');
                    selectdiv.classList.remove('d-none');

                }
                if (selectedValue === 'checkbox') {
                    var checkdiv = document.getElementById('checkboxdiv');

                    // 'select' seçildiğinde 'd-none' sınıfını kaldır
                    checkdiv.classList.remove('d-none');
                }

            });
            document.getElementById('checkboxTypeSelect').addEventListener('change', function() {
                var selectedValue = this.value;
                if (selectedValue === 'modal') {
                    // 'select' seçildiğinde 'd-none' sınıfını kaldır
                    var selectdiv = document.getElementById('checkboxModalDiv');
                    selectdiv.classList.remove('d-none');
                    var checkdiv2 = document.getElementById('checkboxLinkDiv');
                    checkdiv2.classList.add('d-none');

                }
                if (selectedValue === 'link') {
                    var checkdiv = document.getElementById('checkboxLinkDiv');
                    checkdiv.classList.remove('d-none');
                    var checkdiv2 = document.getElementById('checkboxModalDiv');
                    checkdiv2.classList.add('d-none');
                }

            });
            document.getElementById('addOptionButton').addEventListener('click', function() {
                // Yeni seçenek inputunu ve silme butonunu içeren row div oluştur
                var newRowDiv = document.createElement('div');
                newRowDiv.className = 'row my-2'; // Row divi ve alt boşluk için 'mb-2' ekledik

                // Input için col-md-10 sınıfını içeren div oluştur
                var inputDiv = document.createElement('div');
                inputDiv.className = 'col-md-10';

                var newInput = document.createElement('input');
                newInput.type = 'text';
                newInput.name = 'options[]';
                newInput.placeholder = 'Seçenek Giriniz';
                newInput.className = 'form-control'; // 'form-control' sınıfını ekle

                // Input'u col-md-10 div'ine ekle
                inputDiv.appendChild(newInput);

                // Silme butonu için col-md-2 sınıfını içeren div oluştur
                var buttonDiv = document.createElement('div');
                buttonDiv.className = 'col-md-2';

                var removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm w-100'; // w-100 ile buton tam genişlikte olur
                removeButton.textContent = 'Sil';

                // Silme butonuna tıklandığında ilgili satırı kaldır
                removeButton.addEventListener('click', function() {
                    newRowDiv.remove();
                });

                // Butonu col-md-2 div'ine ekle
                buttonDiv.appendChild(removeButton);

                // Input ve buton div'lerini row div'e ekle
                newRowDiv.appendChild(inputDiv);
                newRowDiv.appendChild(buttonDiv);

                // Oluşturulan row div'i optionparentdiv'e ekle
                document.getElementById('optionparentdiv').appendChild(newRowDiv);
            });

            // Var olan silme butonları için olay dinleyici
            document.querySelectorAll('.remove-option').forEach(function(button) {
                button.addEventListener('click', function() {
                    this.parentElement.remove();
                });
            });

            $('#reload').click(function(e) {
                location.reload();
            });
        </script>

    @include('includes.js.sidebar')

@endsection
