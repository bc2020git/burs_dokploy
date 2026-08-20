@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Form Sorusu Düzenle
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
                <form action="{{route('panel-soru-update')}}" method="post"> @csrf
                    <div class="navbar-button-container">



                    <!-- Form Butonlari -->
                    <div class="d-flex flex-wrap">
                    </div>
                    <!-- Form Butonlari -->
                </div>
                <div class="mt-3 p-3 border">
                    <div class="card-title"><h3>Soru Detayları</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <input name="id" id="id" type="hidden" class="form-control" value="{{$soru->id}}">

                            <input type='hidden' id='category_id' name='category_id' value="{{$soru->category_id}}" >
                            <input type='hidden' id='category_title' name='category_title' value="{{$soru->category_title}}" >
                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="category_id" class="custom-label">Kategori</label>
                                <select required id="category_id" name="category_id" class="form-select">
                                    @foreach($categories as $category)
                                        <option @if(isset($soru->category->id) && $soru->category_id==$category->id) selected @endif value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="name" class="custom-label">Soru Adı <span style="color: red" > (Yönetici sayfasında görüntülenecek olan ad) </span></label>
                                <input name="name" id="name" type="text" class="form-control" value="{{$soru->name}}">
                            </div>

                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="title" class="custom-label">Soru Başlığı <span style="color: red" > (Başvuru formunda görüntülenecek olan metin) </span></label>
                                <input name="title" id="title" type="text" class="form-control" value="{{$soru->title}}">

                            </div>

                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="required" class="custom-label">Zorunluluk</label>
                                <select required id="required" name="required" class="form-select">
                                    <option @if($soru->required=='Zorunlu') selected @endif value="Zorunlu">Zorunlu</option>
                                    <option @if($soru->required=='Opsiyonel') selected @endif value="Opsiyonel">Zorunlu Değil</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="status" class="custom-label">Aktif Mi?</label>
                                <select required id="status" name="status" class="form-select">
                                    <option @if($soru->status=='Aktif') selected @endif value="Aktif">Aktif</option>
                                    <option @if($soru->status=='Pasif') selected @endif value="Pasif">Pasif</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="disabled" class="custom-label">Doldurulabilir Mi?</label>
                                <select required id="disabled" name="disabled" class="form-select">
                                    <option @if($soru->disabled=='notdisabled') selected @endif value="notdisabled">Evet</option>
                                    <option @if($soru->disabled=='disabled') selected @endif value="disabled">Hayır</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 form-group @if($soru->type!='number') d-none @endif" id="has_conditions_div">
                                <label for="has_conditions" class="custom-label">Koşul Var mı?</label>
                                <select id="has_conditions" name="has_conditions" class="form-select">
                                    <option @if(!$soru->has_conditions) selected @endif value="">Hayır</option>
                                    <option @if($soru->has_conditions) selected @endif value="on">Evet</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="db_key" class="custom-label">Veritabanı Anahtarı </label>
                                <input disabled name="db_key" id="db_key" type="text" class="form-control" value="{{$soru->db_key}}">

                            </div>
                            <div class="col-sm-12 col-md-6 form-group">
                                <label for="type" class="custom-label">Soru Tipi</label>
                                <select required id="type"  name="type" class="form-select">
                                    <option @if($soru->type=='text') selected @endif value="text">Metin</option>
                                    <option @if($soru->type=='date') selected @endif value="date">Tarih</option>
                                    <option @if($soru->type=='number') selected @endif value="number">Numara</option>
                                    <option @if($soru->type=='email') selected @endif value="email">Eposta</option>
                                    <option @if($soru->type=='select') selected @endif value="select">Seçenek</option>
                                    <option @if($soru->type=='checkbox') selected @endif value="checkbox">Kutucuk</option>
                                    <option @if($soru->type=='tel') selected @endif value="tel">Telefon</option>
                                    <option @if($soru->type=='homephone') selected @endif value="homephone">Ev Telefonu</option>
                                    <option @if($soru->type=='file') selected @endif value="file">Dosya</option>
                                    <option @if($soru->type=='modal') selected @endif value="modal">Modal</option>
                                    <option @if($soru->type=='redirect') selected @endif value="redirect">Yönlendirme Linki</option>
                                </select>
                            </div>

                            <!-- Koşul ve Form Seçim Alanları Yan Yana -->
                            <div class="row">
                                 <!-- Gösterilen Formlar -->
                                 <div class="col-sm-12 col-md-6">
                                    <div class="border p-3 mb-3">
                                        <h4 class="mb-3">Gösterilen Formlar</h4>
                                        <div class="form-group">
                                            <p class="text-danger mb-2">(Birden fazla seçmek için CTRL basılı tutunuz)</p>
                                            <select required style="min-height: 160px" multiple id="forms" name="forms[]" class="form-select">
                                                <option @foreach(json_decode($soru->form_type) as $form) @if($form=='ilkokul') selected @endif @endforeach value="ilkokul">İlkokul</option>
                                                <option @foreach(json_decode($soru->form_type) as $form) @if($form=='ortaokul') selected @endif @endforeach value="ortaokul">Ortaokul</option>
                                                <option @foreach(json_decode($soru->form_type) as $form) @if($form=='lise') selected @endif @endforeach value="lise">Lise</option>
                                                <option @foreach(json_decode($soru->form_type) as $form) @if($form=='onlisans') selected @endif @endforeach value="onlisans">Ön lisans</option>
                                                <option @foreach(json_decode($soru->form_type) as $form) @if($form=='lisans') selected @endif @endforeach value="lisans">Lisans</option>
                                                <option @foreach(json_decode($soru->form_type) as $form) @if($form=='yukseklisans') selected @endif @endforeach value="yukseklisans">Yükseklisans</option>
                                                <option @foreach(json_decode($soru->form_type) as $form) @if($form=='doktora') selected @endif @endforeach value="doktora">Doktora</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Koşul Detayları -->
                                <div class="col-sm-12 col-md-6">
                                    <div class="border p-3 mb-3 @if($soru->type!='number' || !$soru->has_conditions) d-none @endif" id="conditionsdiv">
                                        <h4 class="mb-3">Koşul Detayları</h4>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <button type="button" id="addConditionButton" class="btn btn-primary">Koşul Ekle</button>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-hover" id="conditionTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Operatör</th>
                                                            <th>Değer</th>
                                                            <th>İşlem</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="conditionTableBody">
                                                        @php
                                                            $conditions = json_decode($soru->conditions, true) ?? [];
                                                        @endphp
                                                        @foreach($conditions as $index => $condition)
                                                            <tr>
                                                                <td>
                                                                    <select class="form-select" name="condition_operator[{{ $index }}]">
                                                                        <option value="">Seçiniz</option>
                                                                        <option @if($condition['operator'] == '<') selected @endif value="<">Küçüktür (<)</option>
                                                                        <option @if($condition['operator'] == '>') selected @endif value=">">Büyüktür (>)</option>
                                                                        <option @if($condition['operator'] == '<=') selected @endif value="<=">Küçük Eşittir (<=)</option>
                                                                        <option @if($condition['operator'] == '>=') selected @endif value=">=">Büyük Eşittir (>=)</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="number" step="0.01" min="0" max="100000" name="condition_value[{{ $index }}]" value="{{ $condition['value'] }}" placeholder="Değer Giriniz">
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-sm btn-danger remove-condition">Sil</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!-- Puanlama Aralıkları -->
                            <div class="col-sm-12 form-group">
                                <div class="row border p-3 mb-3 @if($soru->type!='number') d-none @endif" id="scoringdiv">
                                    <h3 class="my-2">Puanlama Aralıkları</h3>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button type="button" id="addScoringRangeButton" class="btn btn-primary mb-2">Aralık Ekle</button>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="table-responsive mt-3">
                                                <table class="table table-hover" id="scoringRangeTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Minimum Değer</th>
                                                        <th>Maksimum Değer</th>
                                                        <th>Puan</th>
                                                        <th>İşlem</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="scoringRangeTableBody">
                                                    @php
                                                        $scoringRanges = json_decode($soru->scoring_ranges, true) ?? [];
                                                    @endphp
                                                    @foreach($scoringRanges as $index => $range)
                                                        <tr>
                                                            <td>
                                                                <input class="form-control" type="number" step="0.01" name="range_min[{{ $index }}]" value="{{ $range['min'] ?? '' }}" placeholder="Minimum (boş = sınırsız)">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" step="0.01" name="range_max[{{ $index }}]" value="{{ $range['max'] ?? '' }}" placeholder="Maksimum (boş = sınırsız)">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" name="range_points[{{ $index }}]" value="{{ $range['points'] ?? 0 }}" placeholder="Puan">
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-md btn-danger remove-scoring-range">Sil</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Seçenek Detayları -->
                            <div class="col-sm-12 form-group">
                                <div id="optiondiv" class="select-options">
                                    <div class="row border p-3 @if($soru->type!='select') d-none @endif" id="selectdiv">
                                        <h3 class="my-2">Seçenek Detayları</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="dataset" class="form-label">Verí Kumesi</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select id="dataset" name="dataset" class="form-select">
                                                    <option>Seçiniz</option>
                                                    <option @if($soru->dataset=='Univercities') selected @endif value="Univercities">Üniversiteler</option>
                                                    <option @if($soru->dataset=='Cities') selected @endif value="Cities">Şehirler</option>
                                                    <option @if($soru->dataset=='Banks') selected @endif value="Banks">Bankalar</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row py-2">
                                            @php
                                            $options = json_decode($soru->options, true);
                                            $options = is_array($options) ? array_values(array_filter($options, function($value) { return !is_null($value) && $value !== ''; })) : [];

                                            $points = json_decode($soru->points, true);
                                            $points = is_array($points) ? array_values(array_filter($points, function($value) { return !is_null($value); })) : [];

                                            $contradictory = json_decode($soru->is_contradictory, true);
                                            $contradictory = is_array($contradictory) ? array_values(array_filter($contradictory, function($value) { return !is_null($value); })) : [];
                                        @endphp

                                            <div class="col-md-3">
                                                <button type="button" id="addOptionButton" class="btn btn-primary mb-2">Seçenek Ekle</button>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-hover" id="candidateTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Soru Adı</th>
                                                            <th>Puan</th>
                                                            <th>Başvuru Yapamaz</th>
                                                            <th>İşlem</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="candidateTableBody">

                                                        @foreach($options as $index => $option)
                                                            <tr>
                                                                <td>
                                                                    <input class="form-control" type="text" name="option[{{ $index }}]" value="{{ $option }}" placeholder="Seçenek Giriniz" onchange="this.setAttribute('value', this.value)">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="number" name="point[{{ $index }}]" value="{{ $points[$index] ?? 0 }}" placeholder="Puan Giriniz" onchange="this.setAttribute('value', this.value)">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input class="form-check-input" type="checkbox" name="is_contradictory[{{ $index }}]" value="1" {{ isset($contradictory[$index]) && $contradictory[$index] == 1 ? 'checked' : '' }}>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-md remove-option btn-danger">Sil</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border p-3 @if($soru->type!='checkbox') d-none @endif" id="checkboxdiv">
                                        <h3>Kutucuk Detayları</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal İçerik Alanı -->
                            <div class="col-sm-12 form-group">
                                <div id="modaldiv" class="modal-content-area @if($soru->type!='modal') d-none @endif">
                                    <div class="row border p-3">
                                        <h3>Modal Detayları</h3>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="modalTitle">Modal Başlığı</label>
                                                <input type="text" class="form-control" id="modalTitle" name="modal_title" value="{{ $soru->modal_title }}" placeholder="Modal başlığını giriniz">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="modalContent">Modal İçeriği</label>
                                                <textarea class="form-control" id="modalContent" name="modal_content" rows="5">{{ $soru->modal_content }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Yönlendirme Link Alanı -->
                            <div class="col-sm-12 form-group">
                                <div id="redirectdiv" class="redirect-content-area @if($soru->type!='redirect') d-none @endif">
                                    <div class="row border p-3">
                                        <h3>Yönlendirme Detayları</h3>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="redirectUrl">Yönlendirme URL</label>
                                                <input type="text" class="form-control" id="redirectUrl" name="redirect_url" value="{{ $soru->redirect_url }}" placeholder="URL giriniz">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/modal.js"></script>
        <script src="{{url('')}}/assets/js/tables/candidate.js"></script>
        <script>
            document.getElementById('type').addEventListener('change', function() {
                var selectedValue = this.value;

                // Tüm içerik alanlarını gizle
                document.querySelectorAll('#optiondiv > div, #modaldiv, #redirectdiv').forEach(function(div) {
                    div.classList.add('d-none');
                });

                // Puanlama aralığı ve koşul alanlarını gizle
                document.getElementById('scoringdiv').classList.add('d-none');
                document.getElementById('has_conditions_div').classList.add('d-none');
                document.getElementById('conditionsdiv').classList.add('d-none');

                // Seçilen tipe göre ilgili alanı göster
                if (selectedValue === 'select') {
                    document.getElementById('selectdiv').classList.remove('d-none');
                } else if (selectedValue === 'checkbox') {
                    document.getElementById('checkboxdiv').classList.remove('d-none');
                } else if (selectedValue === 'modal') {
                    document.getElementById('modaldiv').classList.remove('d-none');
                    // Modal seçildiğinde options ve points dizilerini temizle
                    document.getElementById('candidateTableBody').innerHTML = '';
                } else if (selectedValue === 'redirect') {
                    document.getElementById('redirectdiv').classList.remove('d-none');
                    // Yönlendirme seçildiğinde options ve points dizilerini temizle
                    document.getElementById('candidateTableBody').innerHTML = '';
                } else if (selectedValue === 'number') {
                    document.getElementById('scoringdiv').classList.remove('d-none');
                    document.getElementById('has_conditions_div').classList.remove('d-none');
                }
            });

            // Koşul var mı seçeneği değiştiğinde
            document.getElementById('has_conditions').addEventListener('change', function() {
                var conditionsDiv = document.getElementById('conditionsdiv');
                conditionsDiv.classList.toggle('d-none', this.value !== 'on');
            });

            // Koşul ekleme butonu
            document.getElementById('addConditionButton').addEventListener('click', function() {
                var conditionTableBody = document.getElementById('conditionTableBody');
                var rowCount = conditionTableBody.rows.length;

                var newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <select class="form-select" name="condition_operator[${rowCount}]">
                            <option value="">Seçiniz</option>
                            <option value="<">Küçüktür (<)</option>
                            <option value=">">Büyüktür (>)</option>
                            <option value="<=">Küçük Eşittir (<=)</option>
                            <option value=">=">Büyük Eşittir (>=)</option>
                        </select>
                    </td>
                    <td>
                        <input class="form-control" type="number" step="0.01" min="0" max="100000" name="condition_value[${rowCount}]" placeholder="Değer Giriniz">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-condition">Sil</button>
                    </td>
                `;

                conditionTableBody.appendChild(newRow);

                // Input alanına değer girildiğinde kontrol et
                var input = newRow.querySelector('input[type="number"]');
                input.addEventListener('input', function() {
                    var value = parseFloat(this.value);

                });
            });

            // Koşul silme butonu (event delegation)
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-condition')) {
                    e.target.closest('tr').remove();
                }
            });

            // Seçenek ekleme butonu
            document.getElementById('addOptionButton').addEventListener('click', function() {
                var candidateTableBody = document.getElementById('candidateTableBody');
                var rowCount = candidateTableBody.rows.length;

                var newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <input class="form-control" type="text" name="option[${rowCount}]" value="" placeholder="Seçenek Giriniz" onchange="this.setAttribute('value', this.value)">
                    </td>
                    <td>
                        <input class="form-control" type="number" name="point[${rowCount}]" value="0" placeholder="Puan Giriniz" onchange="this.setAttribute('value', this.value)">
                    </td>
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" name="is_contradictory[${rowCount}]" value="1">
                    </td>
                    <td>
                        <button type="button" class="btn btn-md btn-danger remove-option">Sil</button>
                    </td>
                `;

                candidateTableBody.appendChild(newRow);

                // Input değerlerini değiştiğinde value attribute'unu güncelle
                var inputs = newRow.querySelectorAll('input[type="text"], input[type="number"]');
                inputs.forEach(function(input) {
                    input.addEventListener('input', function() {
                        this.setAttribute('value', this.value);
                    });
                });
            });

            // Seçenek silme butonu (event delegation)
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-option')) {
                    e.target.closest('tr').remove();
                }
            });

            // Puanlama aralığı ekleme butonu
            document.getElementById('addScoringRangeButton').addEventListener('click', function() {
                var scoringRangeTableBody = document.getElementById('scoringRangeTableBody');
                var rowCount = scoringRangeTableBody.rows.length;

                var newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <input class="form-control" type="number" step="0.01" name="range_min[${rowCount}]" placeholder="Minimum (boş = sınırsız)">
                    </td>
                    <td>
                        <input class="form-control" type="number" step="0.01" name="range_max[${rowCount}]" placeholder="Maksimum (boş = sınırsız)">
                    </td>
                    <td>
                        <input class="form-control" type="number" name="range_points[${rowCount}]" value="0" placeholder="Puan">
                    </td>
                    <td>
                        <button type="button" class="btn btn-md btn-danger remove-scoring-range">Sil</button>
                    </td>
                `;

                scoringRangeTableBody.appendChild(newRow);
            });

            // Puanlama aralığı silme butonu (event delegation)
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-scoring-range')) {
                    e.target.closest('tr').remove();
                }
            });

            // Sayfa yüklendiğinde mevcut durumu kontrol et
            document.addEventListener('DOMContentLoaded', function() {
                var typeElement = document.getElementById('type');
                var hasConditionsElement = document.getElementById('has_conditions');

                // Soru tipine göre ilgili alanları göster/gizle
                if (typeElement.value === 'select') {
                    document.getElementById('selectdiv').classList.remove('d-none');
                } else if (typeElement.value === 'checkbox') {
                    document.getElementById('checkboxdiv').classList.remove('d-none');
                } else if (typeElement.value === 'number') {
                    document.getElementById('scoringdiv').classList.remove('d-none');
                } else if (typeElement.value === 'modal') {
                    document.getElementById('modaldiv').classList.remove('d-none');
                } else if (typeElement.value === 'redirect') {
                    document.getElementById('redirectdiv').classList.remove('d-none');
                }

                // Koşul alanını kontrol et
                if (typeElement.value === 'number') {
                    document.getElementById('has_conditions_div').classList.remove('d-none');
                    if (hasConditionsElement.value === 'on') {
                        document.getElementById('conditionsdiv').classList.remove('d-none');
                    }
                }
            });

            // Form submit öncesi kontrol
            document.querySelector('form').addEventListener('submit', function(e) {
                var type = document.getElementById('type').value;

                if (type === 'modal') {
                    e.preventDefault();
                    var modalTitle = document.getElementById('modalTitle').value;
                    var modalContent = document.getElementById('modalContent').value;

                    // Modal başlığını options[0] olarak ayarla
                    var titleInput = document.createElement('input');
                    titleInput.type = 'hidden';
                    titleInput.name = 'option[0]';
                    titleInput.value = modalTitle;
                    this.appendChild(titleInput);

                    // Modal içeriğini options[1] olarak ayarla
                    var contentInput = document.createElement('input');
                    contentInput.type = 'hidden';
                    contentInput.name = 'option[1]';
                    contentInput.value = modalContent;
                    this.appendChild(contentInput);

                    this.submit();
                } else if (type === 'redirect') {
                    e.preventDefault();
                    var redirectText = document.getElementById('redirectText').value;
                    var redirectUrl = document.getElementById('redirectUrl').value;
                    // Yönlendirme bilgilerini options[0] ve options[1] olarak ayarla
                    var textInput = document.createElement('input');
                    textInput.type = 'hidden';
                    textInput.name = 'option[0]';
                    textInput.value = redirectText;
                    this.appendChild(textInput);

                    var urlInput = document.createElement('input');
                    urlInput.type = 'hidden';
                    urlInput.name = 'option[1]';
                    urlInput.value = redirectUrl;
                    this.appendChild(urlInput);
                    this.submit();
                }
            });

        </script>

    @include('includes.js.sidebar')

@endsection
