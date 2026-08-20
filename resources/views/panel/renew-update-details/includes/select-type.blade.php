<script>


document.addEventListener('DOMContentLoaded', function () {
const okulTipiSelect = document.getElementById('educationType');
const ortaogretimTipiContainer = document.getElementById('ortaogretimTipiContainer');
const ortaogretimTipiSelect = document.getElementById('ortaogretimTipi');
const yuksekogretimTipiContainer = document.getElementById('yuksekogretimTipiContainer');
const yuksekogretimTipiSelect = document.getElementById('yuksekogretimTipi');
const dinamikSorularContainer = document.getElementById('dinamik-sorular');

okulTipiSelect.addEventListener('change', function () {
const selectedValue = this.value;
dinamikSorularContainer.innerHTML = '';

if (selectedValue === 'ortaogretim') {
ortaogretimTipiContainer.style.display = 'block';
yuksekogretimTipiContainer.style.display = 'none';
} else if (selectedValue === 'yuksekogretim') {
yuksekogretimTipiContainer.style.display = 'block';
ortaogretimTipiContainer.style.display = 'none';
} else {
ortaogretimTipiContainer.style.display = 'none';
yuksekogretimTipiContainer.style.display = 'none';
}
});

ortaogretimTipiSelect.addEventListener('change', function () {
const selectedValue = this.value;
dinamikSorularContainer.innerHTML = '';

if (selectedValue === 'ilkokul') {
addIlkokulSorulari(dinamikSorularContainer);
} else if (selectedValue === 'ortaokul') {
addOrtaokulSorulari(dinamikSorularContainer);
} else if (selectedValue === 'lise') {
addLiseSorulari(dinamikSorularContainer);
}
});

yuksekogretimTipiSelect.addEventListener('change', function () {
const selectedValue = this.value;
dinamikSorularContainer.innerHTML = '';

if (selectedValue === 'Ön lisans') {
addOnlisansSorulari(dinamikSorularContainer);
} else if (selectedValue === 'lisans') {
addLisansSorulari(dinamikSorularContainer);
} else if (selectedValue === 'yükseklisans') {
addYuksekLisansSorulari(dinamikSorularContainer);
} else if (selectedValue === 'doktora') {
addDoktoraSorulari(dinamikSorularContainer);
}
});

function addIlkokulSorulari(container) {
container.innerHTML = `
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="schoolName">Okul Adı</label>
        <input type="text" class="form-control" @if(isset($aday->educinfo->p_school_name)) value="{{$aday->educinfo->p_school_name}}" @endif  id="schoolName"
               placeholder="Okul adınızı giriniz...">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="schoolCity">Okulun Bulunduğu Şehir</label>
        <select onchange="getDistricts(this,'p_school_district')" id="p_school_city" class="form-select">
            <option selected disabled>Şehir Seçiniz</option>
            @foreach($cities as $city)
                <option data-id="{{ $city->id }}"  @if(isset($aday->educinfo->p_school_city) && $aday->educinfo->p_school_city == $city->isim) selected @endif id='p_school_city' value="{{$city->isim}}">{{$city->isim}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="p_school_district">Okulun Bulunduğu İlçe</label>
        <select id="p_school_district" class="form-select">
            <option @if(isset($aday->educinfo->p_school_district)) value="{{$aday->educinfo->p_school_district}}">{{$aday->educinfo->p_school_district}} @endif </option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="studentNumber">Öğrenci Numarası</label>
        <input value=" @if(isset($aday->educinfo->student_number)) {{$aday->educinfo->student_number}}@endif"  type="text" class="form-control" id="studentNumber"
               placeholder="Öğrenci numaranızı giriniz...">
    </div>
    <div class="col-md-6 mb-3">
        <label for="grade">Sınıfınız</label>
        <select id="grade" class="form-select">
            <option selected disabled value="">Seçiniz...</option>
            <option  @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '1') value="1">1</option>
            <option  @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '2') value="2">2</option>
            <option  @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '3') value="3">3</option>
            <option  @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '4') value="4">4</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="transferred">Nakil Yaptı mı?</label>
        <select id="transferred" class="form-select">
            <option selected disabled value="">Seçiniz...</option>
            <option  @selected(isset($aday->educinfo->is_transfered) && $aday->educinfo->is_transfered == 'Evet') value="Evet">Evet</option>
            <option  @selected(isset($aday->educinfo->is_transfered) && $aday->educinfo->is_transfered == 'Hayır') value="Hayır">Hayır</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="averageGrade">Not Ortalaması</label>
        <input @if(isset($aday->educinfo->grade_avg)) value="{{$aday->educinfo->grade_avg}}" @endif  type="text" class="form-control" id="averageGrade"
               placeholder="Not ortalamanızı giriniz...">
    </div>
</div>
`;
}

function addOrtaokulSorulari(container) {
container.innerHTML = `
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="mschoolName">Okul Adı</label>
        <input type="text" class="form-control"  @if(isset($aday->educinfo->m_school_name)) value="{{$aday->educinfo->m_school_name}}" @endif id="mschoolName"
               placeholder="Okul adınızı giriniz...">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="schoolCity">Okulun Bulunduğu Şehir</label>
        <select onchange="getDistricts(this,'m_school_district')" id="m_school_city" class="form-select">
            <option selected disabled>Şehir Seçiniz</option>
            @foreach($cities as $city)
                <option id='m_school_city' data-id="{{ $city->id }}">{{$city->isim}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="m_school_district">Okulun Bulunduğu İlçe</label>
        <select id="m_school_district" class="form-select">
            @if(isset($aday->educinfo->m_school_district)) <option value="{{$aday->educinfo->m_school_district}} ">{{$aday->educinfo->m_school_district}}</option>@endif
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="studentNumber">Öğrenci Numarası</label>
        <input value="@if(isset($aday->educinfo->student_number)) {{$aday->educinfo->student_number}}@endif" type="text" class="form-control" id="studentNumber"
               placeholder="Öğrenci numaranızı giriniz...">
    </div>
    <div class="col-md-6 mb-3">
        <label for="grade">Sınıfınız</label>
        <select id="grade" class="form-select">
            <option selected disabled value="">Seçiniz...</option>
            <option   value="5">5</option>
            <option   value="6">6</option>
            <option   value="7">7</option>
            <option   value="8">8</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="transferred">Nakil Yaptı mı?</label>
        <select id="transferred" class="form-select">
            <option selected disabled value="">Seçiniz...</option>
            <option  value="Evet">Evet</option>
            <option  value="Hayır">Hayır</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="averageGrade">Not Ortalaması</label>
        <input value="@if(isset($aday->educinfo->student_number)) {{$aday->educinfo->grade_avg}}@endif" type="text" class="form-control" id="averageGrade"
               placeholder="Not ortalamanızı giriniz...">
    </div>
</div>
`;
}

function addLiseSorulari(container) {
container.innerHTML = `
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="schoolName">Okul Adı</label>
                                        <input type="text" class="form-control" id="hschoolName"
                                               placeholder="Okul adınızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="hschoolCity">Okulun Bulunduğu Şehir</label>
                                        <select onchange="getDistricts(this,'h_school_district')" id="h_school_city" class="form-select">
                                            @foreach($cities as $city)
<option data-id="{{ $city->id }}"  @if(isset($aday->educinfo->h_school_city ) && $aday->educinfo->m_school_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                                            @endforeach
</select>
</div>
<div class="col-md-6 mb-3">
<label for="h_school_district">Okulun Bulunduğu İlçe</label>
<select id="h_school_district" class="form-select">
    <option @if(isset($aday->educinfo->h_school_district)) value="{{$aday->educinfo->h_school_district}}">{{$aday->educinfo->h_school_district}} @endif </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input value=" @if(isset($aday->educinfo->student_number)) {{$aday->educinfo->student_number}}@endif"  type="text" class="form-control" id="studentNumber"
                                               placeholder="Öğrenci numaranızı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="class">Sınıfınız</label>
                                        <select id="class" class="form-select">
                                            <option selected disabled value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '9')  value="9">9</option>
                                            <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '10')  value="10">10</option>
                                            <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '11')  value="11">11</option>
                                            <option @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '12')  value="12">12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="transferred">Nakil Yaptı mı?</label>
                                        <select id="transferred" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option  @selected(isset($aday->educinfo->is_transfered) && $aday->educinfo->is_transfered == 'Evet') value="Evet">Evet</option>
                                            <option  @selected(isset($aday->educinfo->is_transfered) && $aday->educinfo->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="averageGrade">Not Ortalaması</label>
                                        <input @if(isset($aday->educinfo->grade_avg)) value="{{$aday->educinfo->grade_avg}}" @endif  type="text" class="form-control" id="averageGrade"
                                               placeholder="Not ortalamanızı giriniz...">
                                    </div>
                                </div>
`;
}

function addOnlisansSorulari(container) {
container.innerHTML = `
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="reportedHighSchool">Bitirdiğiniz Lise</label>
                                        <input @if(isset($aday->educinfo->grade_high_school)) value="{{$aday->educinfo->grade_high_school}}"  @endif type="text" class="form-control" id="reportedHighSchool"
                                               placeholder="Lise bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="universityEntranceScore">Üniversiteye Giriş Puanınız</label>
                                        <input @if(isset($aday->educinfo->entry_grade_university)) value="{{$aday->educinfo->entry_grade_university}}"  @endif type="text" class="form-control" id="universityEntranceScore"
                                               placeholder="Puanınızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="continuingUniversity">Öğrenime Devam Ettiğiniz Üniversite</label>
                                        <input @if(isset($aday->educinfo->current_university)) value="{{$aday->educinfo->current_university}}"  @endif type="text" class="form-control" id="continuingUniversity"
                                               placeholder="Okul adı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                                        <input @if(isset($aday->educinfo->university_faculty)) value="{{$aday->educinfo->university_faculty}}"  @endif type="text" class="form-control" id="university_faculty"
                                               placeholder="Okul adı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                                        <input @if(isset($aday->educinfo->grade_departmant)) value="{{$aday->educinfo->grade_departmant}}"  @endif type="text" class="form-control" id="grade_departmant"
                                               placeholder="Okul adı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="universityStatus">Üniversitenin Statüsü</label>
                                        <select id="universityStatus" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->university_type) && $aday->educinfo->university_type == 'Devlet') value="Devlet">Devlet</option>
                                            <option @selected(isset($aday->educinfo->university_type) && $aday->educinfo->university_type == 'Özel') value="Özel">Özel</option>
                                            <option @selected(isset($aday->educinfo->university_type) && $aday->educinfo->university_type == 'Vakıf') value="Vakıf">Vakıf</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="schoolCity">Okulun Bulunduğu Şehir</label>
                                        <select id="schoolCity" class="form-select">
                                            @foreach($cities as $city)
<option data-id="{{ $city->id }}"  @if( isset($aday->educinfo->university_city) && $aday->educinfo->university_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                                            @endforeach
</select>
</div>
<div class="col-md-6 mb-3">
<label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                            Olacaksınız?</label>
                                        <select id="educationYear" class="form-select">
                                            <option selected disabled value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->university_class) && $aday->educinfo->university_class == '1.Sınıf') value="1.Sınıf">1.Sınıf</option>
                                            <option @selected(isset($aday->educinfo->university_class) && $aday->educinfo->university_class == '2.Sınıf') value="2.Sınıf">2.Sınıf</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input value='@if(isset($aday->educinfo->student_number)) {{$aday->educinfo->student_number}} @endif'  type="text" class="form-control" id="studentNumber"
                                               placeholder="Öğrenci numaranızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="agnoSystem">AGNO Sisteminiz</label>
                                        <select id="agnoSystem" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "4'lük") value="4'lük">4'lük</option>
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "100'lük") value="100'lük">100'lük</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="agno">AGNO</label>
                                        <input value="@if(isset($aday->educinfo->agno)) {{$aday->educinfo->agno}} @endif" type="text" class="form-control" id="agno"
                                               placeholder="Not ortalamanızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                        <select id="university_transfer" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option value="Evet" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Evet')>Evet</option>
                                            <option value="Hayır" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Hayır')>Hayır</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                            bilgilerinizi yazınız</label>
                                        <input value="@if(isset($aday->educinfo->university_transfer_desc)) {{$aday->educinfo->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                               placeholder="Geçiş bilgilerinizi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                            yazınız</label>
                                        <input value="@if(isset($aday->educinfo->languages)) {{$aday->educinfo->languages}} @endif" type="text" class="form-control" id="languages">
                                    </div>
                                </div>`;
}

function addLisansSorulari(container) {
container.innerHTML = `
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="reportedHighSchool">Bitirdiğiniz Lise</label>
                                        <input @if(isset($aday->educinfo->grade_high_school)) value="{{$aday->educinfo->grade_high_school}}"  @endif type="text" class="form-control" id="reportedHighSchool"
                                               placeholder="Lise bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="universityEntranceScore">Üniversiteye Giriş Puanınız</label>
                                        <input @if(isset($aday->educinfo->entry_grade_university)) value="{{$aday->educinfo->entry_grade_university}}"  @endif type="text" class="form-control" id="universityEntranceScore"
                                               placeholder="Puanınızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="continuingUniversity">Öğrenime Devam Ettiğiniz Üniversite</label>
                                        <input @if(isset($aday->educinfo->current_university)) value="{{$aday->educinfo->current_university}}"  @endif type="text" class="form-control" id="continuingUniversity"
                                               placeholder="Okul adı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                                        <input @if(isset($aday->educinfo->university_faculty)) value="{{$aday->educinfo->university_faculty}}"  @endif type="text" class="form-control" id="university_faculty"
                                               placeholder="Okul adı giriniz...">
                                    </div>
                                                                        <div class="col-md-6 mb-3">
                                        <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                                        <input @if(isset($aday->educinfo->grade_departmant)) value="{{$aday->educinfo->grade_departmant}}"  @endif type="text" class="form-control" id="grade_departmant"
                                               placeholder="Okul adı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="universityStatus">Üniversitenin Statüsü</label>
                                        <select id="universityStatus" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->university_type) && $aday->educinfo->university_type == 'Devlet') value="Devlet">Devlet</option>
                                            <option @selected(isset($aday->educinfo->university_type) && $aday->educinfo->university_type == 'Özel') value="Özel">Özel</option>
                                            <option @selected(isset($aday->educinfo->university_type) && $aday->educinfo->university_type == 'Vakıf') value="Vakıf">Vakıf</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_city">Okulun Bulunduğu Şehir</label>
                                        <select id="university_city" class="form-select">
                                            @foreach($cities as $city)
<option data-id="{{ $city->id }}"  @if( isset($aday->educinfo->university_city) && $aday->educinfo->university_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                                            @endforeach
</select>
</div>
<div class="col-md-6 mb-3">
<label for="department">Fakülte/Bölüm</label>
<select id="department" class="form-select">
    <option value="">Seçiniz...</option>
</select>
</div>
</div>
<div class="row">
<div class="col-md-6 mb-3">
<label for="class">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                            Olacaksınız?</label>
                                        <select id="class" class="form-select">
                                            <option selected disabled value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->university_class) && $aday->educinfo->university_class == '1.Sınıf') value="1.Sınıf">1.Sınıf</option>
                                            <option @selected(isset($aday->educinfo->university_class) && $aday->educinfo->university_class == '2.Sınıf') value="2.Sınıf">2.Sınıf</option>
                                            <option @selected(isset($aday->educinfo->university_class) && $aday->educinfo->university_class == '3.Sınıf') value="3.Sınıf">3.Sınıf</option>
                                            <option @selected(isset($aday->educinfo->university_class) && $aday->educinfo->university_class == '4.Sınıf') value="4.Sınıf">4.Sınıf</option>
                                            <option @selected(isset($aday->educinfo->university_class) && $aday->educinfo->university_class == '5.Sınıf') value="5.Sınıf">5.Sınıf</option>
                                            <option @selected(isset($aday->educinfo->university_class) && $aday->educinfo->university_class == '6.Sınıf') value="6.Sınıf">6.Sınıf</option>
                                            <option @selected(isset($aday->educinfo->university_class) && $aday->educinfo->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="departmentYear">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                        <select id="departmentYear" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '2') value="2">2</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '3') value="3">3</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '4') value="4">4</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '5') value="5">5</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '6') value="6">6</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '7') value="7">7</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input value='@if(isset($aday->educinfo->student_number)) {{$aday->educinfo->student_number}} @endif'  type="text" class="form-control" id="studentNumber"
                                               placeholder="Öğrenci numaranızı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="agnoSystem">AGNO Sisteminiz</label>
                                        <select id="agnoSystem" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "4'lük") value="4'lük">4'lük</option>
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "100'lük") value="100'lük">100'lük</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="agno">AGNO</label>
                                        <input value="@if(isset($aday->educinfo->agno)) {{$aday->educinfo->agno}} @endif" type="text" class="form-control" id="agno"
                                               placeholder="Not ortalamanızı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                        <select id="university_transfer" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option value="Evet" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Evet')>Evet</option>
                                            <option value="Hayır" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Hayır')>Hayır</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                            bilgilerinizi yazınız</label>
                                        <input value="@if(isset($aday->educinfo->university_transfer_desc)) {{$aday->educinfo->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                               placeholder="Geçiş bilgilerinizi giriniz...">
                                    </div>
                                </div>
                                <div class="col-md-                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="reportedUniversity">Bitirdiğiniz Üniversite</label>
                                        <input  @if(isset($aday->educinfo->grade_university)) value="{{$aday->educinfo->grade_university}}" @endif type="text" class="form-control" id="reportedUniversity"
                                               placeholder="Üniversite bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="graduateUniversity">Mezun Olduğunuz Bölüm</label>
                                        <input type="text" @if(isset($aday->educinfo->grade_departmant)) value="{{$aday->educinfo->grade_departmant}}" @endif class="form-control" id="graduateUniversity"
                                               placeholder="Puanınızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                                        <select id="university_city" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            @foreach($cities as $city)
<option data-id="{{ $city->id }}"  @if( isset($aday->educinfo->university_city) && $aday->educinfo->university_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                                            @endforeach
</select>
</div>
<div class="col-md-6 mb-3">
<label for="masterUniversity">Yüksek Lisans Yaptığınız Üniversite</label>
<select id="masterUniversity" class="form-select">
    <option value="">Seçiniz...</option>
</select>
</div>
</div>
<div class="row">
<div class="col-md-6 mb-3">
<label for="masterDepartment">Yüksek Lisans Yaptığınız Bölüm</label>
<select id="masterDepartment" class="form-select">
    <option value="">Seçiniz...</option>
</select>
</div>
<div class="col-md-6 mb-3">
<label for="masterBranch">Yüksek Lisans Yaptığınız Dal</label>
<input @if(isset($aday->educinfo->master_field)) value="{{$aday->educinfo->master_field}}" @endif type="text" class="form-control" id="masterBranch"
                                               placeholder="Dal bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input @if(isset($aday->educinfo->master_field)) value="{{$aday->educinfo->master_field}}" @endif  type="text" class="form-control" id="studentNumber"
                                               placeholder="Öğrenci numaranızı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="educationYear"> Öğretim Yılında Kaçıncı Sınıfta
                                            Olacaksınız?</label>
                                        <select id="educationYear" class="form-select">
                                            <option value="">Seçiniz...</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="departmentYear">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                        <select id="departmentYear" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '2') value="2">2</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '3') value="3">3</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '4') value="4">4</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '5') value="5">5</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '6') value="6">6</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '7') value="7">7</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="graduateAgno">Mezuniyet AGNO</label>
                                        <input  @if(isset($aday->educinfo->grade_agno)) value="{{$aday->educinfo->grade_agno}}" @endif type="text" class="form-control" id="graduateAgno"
                                               placeholder="Agno giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="agnoSystem">AGNO Sisteminiz</label>
                                        <select id="agnoSystem" class="form-select">
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "4'lük") value="4'lük">4'lük</option>
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "100'lük") value="100'lük">100'lük</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="agno">AGNO</label>
                                        <input value="@if(isset($aday->educinfo->agno)) {{$aday->educinfo->agno}} @endif" type="text" class="form-control" id="agno"
                                               placeholder="Not ortalamanızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                        <select id="university_transfer" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option value="Evet" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Evet')>Evet</option>
                                            <option value="Hayır" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Hayır')>Hayır</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                            bilgilerinizi yazınız</label>
                                        <input value="@if(isset($aday->educinfo->university_transfer_desc)) {{$aday->educinfo->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                               placeholder="Geçiş bilgilerinizi giriniz...">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                        yazınız</label>
                                    <input value="@if(isset($aday->educinfo->languages)) {{$aday->educinfo->languages}} @endif" type="text" class="form-control" id="languages"
                                           placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                                </div>                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="reportedUniversity">Bitirdiğiniz Üniversite</label>
                                        <input  @if(isset($aday->educinfo->grade_university)) value="{{$aday->educinfo->grade_university}}" @endif type="text" class="form-control" id="reportedUniversity"
                                               placeholder="Üniversite bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="graduateUniversity">Mezun Olduğunuz Bölüm</label>
                                        <input type="text" @if(isset($aday->educinfo->grade_departmant)) value="{{$aday->educinfo->grade_departmant}}" @endif class="form-control" id="graduateUniversity"
                                               placeholder="Puanınızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                                        <select id="university_city" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            @foreach($cities as $city)
<option data-id="{{ $city->id }}"  @if( isset($aday->educinfo->university_city) && $aday->educinfo->university_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                                            @endforeach
</select>
</div>
<div class="col-md-6 mb-3">
<label for="masterUniversity">Yüksek Lisans Yaptığınız Üniversite</label>
<select id="masterUniversity" class="form-select">
    <option value="">Seçiniz...</option>
</select>
</div>
</div>
<div class="row">
<div class="col-md-6 mb-3">
<label for="masterDepartment">Yüksek Lisans Yaptığınız Bölüm</label>
<select id="masterDepartment" class="form-select">
    <option value="">Seçiniz...</option>
</select>
</div>
<div class="col-md-6 mb-3">
<label for="masterBranch">Yüksek Lisans Yaptığınız Dal</label>
<input @if(isset($aday->educinfo->master_field)) value="{{$aday->educinfo->master_field}}" @endif type="text" class="form-control" id="masterBranch"
                                               placeholder="Dal bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input @if(isset($aday->educinfo->master_field)) value="{{$aday->educinfo->master_field}}" @endif  type="text" class="form-control" id="studentNumber"
                                               placeholder="Öğrenci numaranızı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="educationYear"> Öğretim Yılında Kaçıncı Sınıfta
                                            Olacaksınız?</label>
                                        <select id="educationYear" class="form-select">
                                            <option value="">Seçiniz...</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="departmentYear">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                        <select id="departmentYear" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '2') value="2">2</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '3') value="3">3</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '4') value="4">4</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '5') value="5">5</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '6') value="6">6</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '7') value="7">7</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="graduateAgno">Mezuniyet AGNO</label>
                                        <input  @if(isset($aday->educinfo->grade_agno)) value="{{$aday->educinfo->grade_agno}}" @endif type="text" class="form-control" id="graduateAgno"
                                               placeholder="Agno giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="agnoSystem">AGNO Sisteminiz</label>
                                        <select id="agnoSystem" class="form-select">
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "4'lük") value="4'lük">4'lük</option>
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "100'lük") value="100'lük">100'lük</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="agno">AGNO</label>
                                        <input value="@if(isset($aday->educinfo->agno)) {{$aday->educinfo->agno}} @endif" type="text" class="form-control" id="agno"
                                               placeholder="Not ortalamanızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                        <select id="university_transfer" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option value="Evet" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Evet')>Evet</option>
                                            <option value="Hayır" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Hayır')>Hayır</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                            bilgilerinizi yazınız</label>
                                        <input value="@if(isset($aday->educinfo->university_transfer_desc)) {{$aday->educinfo->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                               placeholder="Geçiş bilgilerinizi giriniz...">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                        yazınız</label>
                                    <input value="@if(isset($aday->educinfo->languages)) {{$aday->educinfo->languages}} @endif" type="text" class="form-control" id="languages"
                                           placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                                </div>12 mb-3">
                                    <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                        yazınız</label>
                                    <input value="@if(isset($aday->educinfo->languages)) {{$aday->educinfo->languages}} @endif" type="text" class="form-control" id="languages"
                                           placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                                </div>`;
}

function addYuksekLisansSorulari(container) {
container.innerHTML = `
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="reportedUniversity">Bitirdiğiniz Üniversite</label>
                                        <input  @if(isset($aday->educinfo->grade_university)) value="{{$aday->educinfo->grade_university}}" @endif type="text" class="form-control" id="reportedUniversity"
                                               placeholder="Üniversite bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="graduateUniversity">Mezun Olduğunuz Bölüm</label>
                                        <input type="text" @if(isset($aday->educinfo->grade_departmant)) value="{{$aday->educinfo->grade_departmant}}" @endif class="form-control" id="graduateUniversity"
                                               placeholder="Puanınızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                                        <select id="university_city" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            @foreach($cities as $city)
<option data-id="{{ $city->id }}"  @if( isset($aday->educinfo->university_city) && $aday->educinfo->university_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                                            @endforeach
</select>
</div>
<div class="col-md-6 mb-3">
<label for="masterUniversity">Yüksek Lisans Yaptığınız Üniversite</label>
<select id="masterUniversity" class="form-select">
    <option value="">Seçiniz...</option>
</select>
</div>
</div>
<div class="row">
<div class="col-md-6 mb-3">
<label for="masterDepartment">Yüksek Lisans Yaptığınız Bölüm</label>
<select id="masterDepartment" class="form-select">
    <option value="">Seçiniz...</option>
</select>
</div>
<div class="col-md-6 mb-3">
<label for="masterBranch">Yüksek Lisans Yaptığınız Dal</label>
<input @if(isset($aday->educinfo->master_field)) value="{{$aday->educinfo->master_field}}" @endif type="text" class="form-control" id="masterBranch"
                                               placeholder="Dal bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input @if(isset($aday->educinfo->master_field)) value="{{$aday->educinfo->master_field}}" @endif  type="text" class="form-control" id="studentNumber"
                                               placeholder="Öğrenci numaranızı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="educationYear"> Öğretim Yılında Kaçıncı Sınıfta
                                            Olacaksınız?</label>
                                        <select id="educationYear" class="form-select">
                                            <option value="">Seçiniz...</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="departmentYear">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                        <select id="departmentYear" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '2') value="2">2</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '3') value="3">3</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '4') value="4">4</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '5') value="5">5</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '6') value="6">6</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '7') value="7">7</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="graduateAgno">Mezuniyet AGNO</label>
                                        <input  @if(isset($aday->educinfo->grade_agno)) value="{{$aday->educinfo->grade_agno}}" @endif type="text" class="form-control" id="graduateAgno"
                                               placeholder="Agno giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="agnoSystem">AGNO Sisteminiz</label>
                                        <select id="agnoSystem" class="form-select">
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "4'lük") value="4'lük">4'lük</option>
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "100'lük") value="100'lük">100'lük</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="agno">AGNO</label>
                                        <input value="@if(isset($aday->educinfo->agno)) {{$aday->educinfo->agno}} @endif" type="text" class="form-control" id="agno"
                                               placeholder="Not ortalamanızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                        <select id="university_transfer" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option value="Evet" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Evet')>Evet</option>
                                            <option value="Hayır" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Hayır')>Hayır</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                            bilgilerinizi yazınız</label>
                                        <input value="@if(isset($aday->educinfo->university_transfer_desc)) {{$aday->educinfo->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                               placeholder="Geçiş bilgilerinizi giriniz...">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                        yazınız</label>
                                    <input value="@if(isset($aday->educinfo->languages)) {{$aday->educinfo->languages}} @endif" type="text" class="form-control" id="languages"
                                           placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                                </div>`;
}

function addDoktoraSorulari(container) {
container.innerHTML = `
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="reportedUniversity">Bitirdiğiniz Üniversite</label>
                                        <input  @if(isset($aday->educinfo->grade_university)) value="{{$aday->educinfo->grade_university}}" @endif type="text" class="form-control" id="reportedUniversity"
                                               placeholder="Üniversite bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="graduateUniversity">Mezun Olduğunuz Bölüm</label>
                                        <input type="text" @if(isset($aday->educinfo->grade_departmant)) value="{{$aday->educinfo->grade_departmant}}" @endif class="form-control" id="graduateUniversity"
                                               placeholder="Puanınızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                                        <select id="university_city" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            @foreach($cities as $city)
<option data-id="{{ $city->id }}"  @if( isset($aday->educinfo->university_city) && $aday->educinfo->university_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                                            @endforeach
</select>
</div>
<div class="col-md-6 mb-3">
<label for="masterUniversity">Yüksek Lisans Yaptığınız Üniversite</label>
<select id="masterUniversity" class="form-select">
    <option value="">Seçiniz...</option>
</select>
</div>
</div>
<div class="row">
<div class="col-md-6 mb-3">
<label for="masterDepartment">Yüksek Lisans Yaptığınız Bölüm</label>
<select id="masterDepartment" class="form-select">
    <option value="">Seçiniz...</option>
</select>
</div>
<div class="col-md-6 mb-3">
<label for="masterBranch">Yüksek Lisans Yaptığınız Dal</label>
<input @if(isset($aday->educinfo->master_field)) value="{{$aday->educinfo->master_field}}" @endif type="text" class="form-control" id="masterBranch"
                                               placeholder="Dal bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input @if(isset($aday->educinfo->master_field)) value="{{$aday->educinfo->master_field}}" @endif  type="text" class="form-control" id="studentNumber"
                                               placeholder="Öğrenci numaranızı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="educationYear"> Öğretim Yılında Kaçıncı Sınıfta
                                            Olacaksınız?</label>
                                        <select id="educationYear" class="form-select">
                                            <option value="">Seçiniz...</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="departmentYear">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                        <select id="departmentYear" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '2') value="2">2</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '3') value="3">3</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '4') value="4">4</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '5') value="5">5</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '6') value="6">6</option>
                                            <option @selected(isset($aday->educinfo->university_educ_time) && $aday->educinfo->university_educ_time == '7') value="7">7</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="graduateAgno">Mezuniyet AGNO</label>
                                        <input  @if(isset($aday->educinfo->grade_agno)) value="{{$aday->educinfo->grade_agno}}" @endif type="text" class="form-control" id="graduateAgno"
                                               placeholder="Agno giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="agnoSystem">AGNO Sisteminiz</label>
                                        <select id="agnoSystem" class="form-select">
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "4'lük") value="4'lük">4'lük</option>
                                            <option @selected(isset($aday->educinfo->agno_type) && $aday->educinfo->agno_type == "100'lük") value="100'lük">100'lük</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="agno">AGNO</label>
                                        <input value="@if(isset($aday->educinfo->agno)) {{$aday->educinfo->agno}} @endif" type="text" class="form-control" id="agno"
                                               placeholder="Not ortalamanızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                        <select id="university_transfer" class="form-select">
                                            <option value="">Seçiniz...</option>
                                            <option value="Evet" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Evet')>Evet</option>
                                            <option value="Hayır" @selected(isset($aday->educinfo->university_transfer) && $aday->educinfo->university_transfer == 'Hayır')>Hayır</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                            bilgilerinizi yazınız</label>
                                        <input value="@if(isset($aday->educinfo->university_transfer_desc)) {{$aday->educinfo->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                               placeholder="Geçiş bilgilerinizi giriniz...">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                        yazınız</label>
                                    <input value="@if(isset($aday->educinfo->languages)) {{$aday->educinfo->languages}} @endif" type="text" class="form-control" id="languages"
                                           placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                                </div>`;
}
});
</script>
