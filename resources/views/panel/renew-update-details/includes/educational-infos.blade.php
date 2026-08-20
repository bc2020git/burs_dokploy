@if($aday->infos->educationType == 'seçiniz')
    <div class="tab-pane fade" id="education-info" role="tabpanel"
         aria-labelledby="education-info-tab" data-content="3">
        <div class="tab-section">
            <label class="custom-label">Öğretim Tipi</label><span style="color: red" > * </span>
            <select name="educationType" id="educationType" class="form-select">
                <option selected disabled value="seçiniz">Seçiniz..</option>
                <option value="ilkokul">İlkokul</option>
                <option value="ortaokul">Ortaokul</option>
                <option value="lise">Lise</option>
                <option value="onlisans">Ön lisans</option>
                <option value="lisans">Lisans</option>
                <option value="yukseklisans">Yükseklisans</option>
            </select>
            <div id="ilkokuldiv" class="educdiv d-none">

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Okul Tipi</label>
                        <input id="primary_educ_type" type="text" class="form-control" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Okul Adı</label>
                        <input id="p_school_name" type="text" class="form-control" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Okulun Bulunduğu Şehir</label>
                        <select class="form-select" name="p_school_city" id="p_school_city">
                            @foreach($cities as $city)
                                <option data-id="{{ $city->id }}"  value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Sınıf</label>
                        <input id="class" type="text" class="form-control" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Öğrenci Numarası</label>
                        <input id="student_number" type="text" class="form-control" value="">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Not Ortalaması</label>
                        <input id="grade_avg" type="text" class="form-control" value=" ">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Nakil Yaptı Mı</label>
                        <input id="is_transfered" type="text" class="form-control" value="">
                    </div>
                </div>
            </div>


            <div id="ortaokuldiv" class="educdiv d-none">

                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="schoolType">Okul Tipi</label>
                        <select id="schoolType" class="form-select">
                            <option disabled selected>Ortaokul</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_name">Okul Adı</label>
                        <input  type="text" class="form-control"  @if(isset($aday->infos->m_school_name)) value="{{$aday->infos->m_school_name}}" @endif id="m_school_name"
                                placeholder="Okul adınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                        <select onchange="getDistricts(this,'m_school_district')" id="m_school_city" class="form-select">
                            <option selected disabled>Şehir Seçiniz</option>
                            @foreach($cities as $city)
                                <option data-id="{{ $city->id }}"  @if(isset($aday->infos->m_school_city ) && $aday->infos->m_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                        <select id="m_school_district" class="form-select">
                            @if(isset($aday->infos->m_school_district)) <option value="{{$aday->infos->m_school_district}} ">{{$aday->infos->m_school_district}}</option>@endif
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value="@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}}@endif" type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="class">Sınıfınız</label>
                        <select id="class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option  @selected(isset($aday->infos->class) && $aday->infos->class == '5') value="5">5</option>
                            <option  @selected(isset($aday->infos->class) && $aday->infos->class == '6') value="6">6</option>
                            <option  @selected(isset($aday->infos->class) && $aday->infos->class == '7') value="7">7</option>
                            <option  @selected(isset($aday->infos->class) && $aday->infos->class == '8') value="8">8</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="transferred">Nakil Yaptı mı?</label>
                        <select id="transferred" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Evet') value="Evet">Evet</option>
                            <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Not Ortalaması</label>
                        <input value="@if(isset($aday->infos->student_number)) {{$aday->infos->grade_avg}}@endif" type="text" class="form-control" id="student_number"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
            </div>
            <div id="lisediv" class="educdiv d-none">
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="schoolType">Okul Tipi</label>
                        <select id="schoolType" class="form-select">
                            <option value="Lise">Lise</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="h_school_name">Okul Adı</label>
                        <input type="text" class="form-control" id="h_school_name"
                               placeholder="Okul adınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="h_school_city">Okulun Bulunduğu Şehir</label>
                        <select onchange="getDistricts(this,'h_school_district')" id="h_school_city" class="form-select">
                            @foreach($cities as $city)
                                <option data-id="{{ $city->id }}"  @if(isset($aday->infos->h_school_city ) && $aday->infos->h_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="h_school_district">Okulun Bulunduğu İlçe</label>
                        <select id="h_school_district" class="form-select">
                            <option> </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value=" @if(isset($aday->infos->student_number)) {{$aday->infos->student_number}}@endif"  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="class">Sınıfınız</label>
                        <select id="class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->class) && $aday->infos->class == '9')  value="9">9</option>
                            <option @selected(isset($aday->infos->class) && $aday->infos->class == '10')  value="10">10</option>
                            <option @selected(isset($aday->infos->class) && $aday->infos->class == '11')  value="11">11</option>
                            <option @selected(isset($aday->infos->class) && $aday->infos->class == '12')  value="12">12</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="is_transfered">Nakil Yaptı mı?</label>
                        <select id="is_transfered" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Evet') value="Evet">Evet</option>
                            <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="averageGrade">Not Ortalaması</label>
                        <input @if(isset($aday->infos->grade_avg)) value="{{$aday->infos->grade_avg}}" @endif  type="text" class="form-control" id="averageGrade"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
            </div>
            <div id="onlisansdiv" class="educdiv d-none">

                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_high_school">Bitirdiğiniz Lise</label>
                        <input @if(isset($aday->infos->grade_high_school)) value="{{$aday->infos->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                               placeholder="Lise bilgisi giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                        <input @if(isset($aday->infos->entry_grade_university)) value="{{$aday->infos->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                               placeholder="Puanınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_city">Okulun Bulunduğu Şehir</label>
                        <select id="university_city" class="form-select">
                            @foreach($cities as $city)
                                <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                        <select id="current_university" class="form-select">
                            <option value="">Seçiniz...</option>
                            @foreach($unis as $u)
                                <option data-id='{{$u->id}}' @selected(isset($aday->infos->current_university) && $aday->infos->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_type">Üniversitenin Statüsü</label>
                        <select id="university_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->universityStatus) && $aday->infos->universityStatus == 'Devlet') value="Devlet">Devlet</option>
                            <option @selected(isset($aday->infos->universityStatus) && $aday->infos->universityStatus == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_types"> Öğrenim Türü</label>
                        <select id="university_types" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Örgün') value="Örgün">Örgün</option>
                            <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                            <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                            <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 form-group">
                        <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                            Olacaksınız?</label>
                        <select id="university_class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->oKN3UeDifPTo) && $aday->infos->oKN3UeDifPTo == '1') value="1">1</option>
                            <option @selected(isset($aday->infos->oKN3UeDifPTo) && $aday->infos->oKN3UeDifPTo == '2') value="2">2</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                        <select id="university_educ_time" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '2') value="2">2</option>
                            <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '4') value="4">4</option>
                            <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '6') value="6">6</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value='@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}} @endif'  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agnoSystem">AGNO Sisteminiz</label>
                        <select id="agnoSystem" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                            <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno">AGNO</label>
                        <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                        <select id="university_transfer" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                            <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                            bilgilerinizi yazınız</label>
                        <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                               placeholder="Geçiş bilgilerinizi giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group">
                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                            yazınız</label>
                        <input value="@if(isset($aday->infos->languages)) {{$aday->infos->languages}} @endif" type="text" class="form-control" id="languages">
                    </div>
                </div>
            </div>

            <div id="lisansdiv" class="educdiv d-none">

                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_high_school">Bitirdiğiniz Lise</label>
                        <input @if(isset($aday->infos->grade_high_school)) value="{{$aday->infos->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                               placeholder="Lise bilgisi giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                        <input @if(isset($aday->infos->entry_grade_university)) value="{{$aday->infos->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                               placeholder="Puanınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_city">Okulun Bulunduğu Şehir</label>
                        <select id="university_city" class="form-select">
                            @foreach($cities as $city)
                                <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                        <select id="current_university" class="form-select">
                            <option value="">Seçiniz...</option>
                            @foreach($unis as $u)
                                <option data-id='{{$u->id}}' @selected(isset($aday->infos->current_university) && $aday->infos->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_type">Üniversitenin Statüsü</label>
                        <select id="university_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Devlet') value="Devlet">Devlet</option>
                            <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_types"> Öğrenim Türü</label>
                        <select id="university_types" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Örgün') value="Örgün">Örgün</option>
                            <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                            <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                            <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 form-group">
                        <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                            Olacaksınız?</label>
                        <select id="university_class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '1') value="1">1.Sınıf</option>
                            <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '2') value="2">2.Sınıf</option>
                            <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '3') value="3">3.Sınıf</option>
                            <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '4') value="4">4.Sınıf</option>
                            <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '5') value="5">5.Sınıf</option>
                            <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '6') value="6">6.Sınıf</option>
                            <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                        <select id="university_educ_time" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '2') value="2">2</option>
                            <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '4') value="4">4</option>
                            <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '6') value="6">6</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value='@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}} @endif'  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agnoSystem">AGNO Sisteminiz</label>
                        <select id="agnoSystem" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                            <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno">AGNO</label>
                        <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                        <select id="university_transfer" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                            <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                            bilgilerinizi yazınız</label>
                        <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                               placeholder="Geçiş bilgilerinizi giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group">
                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                            yazınız</label>
                        <input value="@if(isset($aday->infos->languages)) {{$aday->infos->languages}} @endif" type="text" class="form-control" id="languages">
                    </div>
                </div>
            </div>

            <div id="yukseklisansdiv" class=" educdiv d-none">
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_university">Bitirdiğiniz Üniversite</label>
                        <input  @if(isset($aday->infos->grade_university)) value="{{$aday->infos->grade_university}}" @endif type="text" class="form-control" id="grade_university"
                                placeholder="Üniversite bilgisi giriniz...">
                    </div>

                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_departmant">Mezun Olduğunuz Bölüm</label>
                        <input type="text" @if(isset($aday->infos->grade_departmant)) value="{{$aday->infos->grade_departmant}}" @endif class="form-control" id="grade_departmant"
                               placeholder="Puanınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                        <select id="university_city" class="form-select">
                            <option value="">Seçiniz...</option>
                            @foreach($cities as $city)
                                <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="master_university">Yüksek Lisans Yaptığınız Üniversite</label>
                        <select id="master_university" class="form-select">
                            <option value="">Seçiniz...</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="master_departmant">Yüksek Lisans Yaptığınız Bölüm</label>
                        <select id="master_departmant" class="form-select">
                            <option value="">Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="master_field">Yüksek Lisans Yaptığınız Dal</label>
                        <input @if(isset($aday->infos->master_field)) value="{{$aday->infos->master_field}}" @endif type="text" class="form-control" id="master_field"
                               placeholder="Dal bilgisi giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input @if(isset($aday->infos->student_number)) value="{{$aday->infos->student_number}}" @endif  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_class">Yeni Öğretim Yılında Kaçıncı Sınıfta
                            Olacaksınız?</label>
                        <select id="university_class" class="form-select">
                            <option value="">Seçiniz...</option>

                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                        <select id="university_educ_time" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '2') value="2">2</option>
                            <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '4') value="4">4</option>
                            <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '6') value="6">6</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_agno">Mezuniyet AGNO</label>
                        <input   type="text" class="form-control" id="grade_agno"
                                 placeholder="Agno giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno_type">AGNO Sisteminiz</label>
                        <select id="agno_type" class="form-select">
                            <option value="4'lük">4'lük</option>
                            <option  value="100'lük">100'lük</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno">AGNO</label>
                        <input type="text" class="form-control" id="agno"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                        <select id="university_transfer" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option value="Evet">Evet</option>
                            <option value="Hayır">Hayır</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                            bilgilerinizi yazınız</label>
                        <input type="text" class="form-control" id="university_transfer_desc"
                               placeholder="Geçiş bilgilerinizi giriniz...">
                    </div>
                </div>
                <div class="col-md-12 mb-3 form-group">
                    <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                        yazınız</label>
                    <input  type="text" class="form-control" id="languages"
                            placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                </div>
            </div>


        </div>
    </div>
    </div>
@else

    <div class="tab-pane fade" id="education-info" role="tabpanel"
         aria-labelledby="education-info-tab" data-content="3">
        <div class="tab-section">
            <label class="custom-label">Öğretim Tipi</label><span style="color: red" > * (Tip değişikliğinde kaydet kapat) </span>
            <select name="educationType" id="educationType" class="form-select">
                <option selected disabled value="seçiniz">Seçiniz..</option>
                <option @if($aday->infos->educationType =='ilkokul') selected @endif value="ilkokul">İlkokul</option>
                <option @if($aday->infos->educationType =='ortaokul') selected @endif value="ortaokul">Ortaokul</option>
                <option @if($aday->infos->educationType =='lise') selected @endif value="lise">Lise</option>
                <option @if($aday->infos->educationType =='onlisans') selected @endif value="onlisans">Ön lisans</option>
                <option @if($aday->infos->educationType =='lisans') selected @endif value="lisans">Lisans</option>
                <option @if($aday->infos->educationType =='yukseklisans') selected @endif value="yukseklisans">Yükseklisans</option>
                <option @if($aday->infos->educationType =='doktora') selected @endif value="doktora">Doktora</option>
            </select>
            @switch($aday->infos->educationType)

                @case('ilkokul')
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="custom-label">Okul Tipi</label>
                            <select id="primary_educ_type" class="form-select">
                                <option disabled selected>Seçiniz..</option>
                                <option @selected(isset($aday->infos->primary_educ_type) && $aday->infos->primary_educ_type == 'Özel Okul') value="Özel Okul">Özel Okul</option>
                                <option @selected(isset($aday->infos->primary_educ_type) && $aday->infos->primary_educ_type == 'Devlet Okulu') value="Devlet Okulu">Devlet Okulu</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="custom-label">Okul Adı</label>
                            <input id="p_school_name" type="text" class="form-control" value="{{$aday->infos->p_school_name}}">
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 mb-3 form-group">
                            <label for="p_school_city">Okulun Bulunduğu Şehir</label>
                            <select onchange="getDistricts(this,'p_school_district')" id="p_school_city" class="form-select">
                                <option selected disabled>Şehir Seçiniz</option>
                                @foreach($cities as $city)
                                    <option data-id="{{ $city->id }}"  @if(isset($aday->infos->p_school_city ) && $aday->infos->p_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="col-md-6 mb-3 form-group">
                            <label for="p_school_district">Okulun Bulunduğu İlçe</label>
                            <select id="p_school_district" class="form-select">
                                <option selected disabled>İlçe Seçiniz</option>
                                <option selected value="{{$aday->infos->p_school_district}}">{{$aday->infos->p_school_district}}</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="class">Sınıfınız</label>
                            <select id="class" class="form-select">
                                <option selected disabled value="">Seçiniz...</option>
                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '1') value="1">1</option>
                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '2') value="2">2</option>
                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '3') value="3">3</option>
                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '4') value="4">4</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="custom-label">Öğrenci Numarası</label>
                            <input id="student_number" type="text" class="form-control" value="{{$aday->infos->student_number}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="custom-label">Not Ortalaması</label>
                            <input id="grade_avg" type="text" class="form-control" value=" {{$aday->infos->grade_avg}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="transferred">Nakil Yaptı mı?</label>
                            <select id="transferred" class="form-select">
                                <option selected disabled value="">Seçiniz...</option>
                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Evet') value="Evet">Evet</option>
                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                            </select>
                        </div>
                    </div>
                    @break

                @case('ortaokul')
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="schoolType">Okul Tipi</label>
                            <select id="schoolType" class="form-select">
                                <option disabled selected>Seçiniz..</option>
                                <option @selected(isset($aday->infos->middle_educ_type) && $aday->infos->middle_educ_type == 'Özel Okul') value="Özel Okul">Özel Okul</option>
                                <option @selected(isset($aday->infos->middle_educ_type) && $aday->infos->middle_educ_type == 'Devlet Okulu') value="Devlet Okulu">Devlet Okulu</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="m_school_name">Okul Adı</label>
                            <input  type="text" class="form-control"  @if(isset($aday->infos->m_school_name)) value="{{$aday->infos->m_school_name}}" @endif id="m_school_name"
                                    placeholder="Okul adınızı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                            <select onchange="getDistricts(this,'m_school_district')" id="m_school_city" class="form-select">
                                <option selected disabled>Şehir Seçiniz</option>
                                @foreach($cities as $city)
                                    <option data-id="{{ $city->id }}"  @if(isset($aday->infos->m_school_city ) && $aday->infos->m_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                            <select id="m_school_district" class="form-select">
                                @if(isset($aday->infos->m_school_district)) <option value="{{$aday->infos->m_school_district}} ">{{$aday->infos->m_school_district}}</option>@endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="student_number">Öğrenci Numarası</label>
                            <input value="@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}}@endif" type="text" class="form-control" id="student_number"
                                   placeholder="Öğrenci numaranızı giriniz...">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="class">Sınıfınız</label>
                            <select id="class" class="form-select">
                                <option selected disabled value="">Seçiniz...</option>
                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '5') value="5">5</option>
                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '6') value="6">6</option>
                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '7') value="7">7</option>
                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '8') value="8">8</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="transferred">Nakil Yaptı mı?</label>
                            <select id="transferred" class="form-select">
                                <option selected disabled value="">Seçiniz...</option>
                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Evet') value="Evet">Evet</option>
                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="student_number">Not Ortalaması</label>
                            <input value="@if(isset($aday->infos->student_number)) {{$aday->infos->grade_avg}}@endif" type="text" class="form-control" id="student_number"
                                   placeholder="Not ortalamanızı giriniz...">
                        </div>
                    </div>
                    @break
                @case('lise')
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="schoolType">Okul Tipi</label>
                            <select id="schoolType" class="form-select">
                                <option disabled selected>Seçiniz..</option>
                                <option @selected(isset($aday->infos->h_school_type) && $aday->infos->h_school_type == 'Devlet Lisesi') value="Devlet Lisesi">Devlet Lisesi</option>
                                <option @selected(isset($aday->infos->h_school_type) && $aday->infos->h_school_type == 'Özel Lise (Tam burslu)') value="Özel Lise (Tam burslu)">Özel Lise (Tam burslu)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="h_school_name">Okul Adı</label>
                            <input value='{{$aday->infos->h_school_name}}' type="text" class="form-control" id="h_school_name"
                                   placeholder="Okul adınızı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="h_school_city">Okulun Bulunduğu Şehir</label>
                            <select onchange="getDistricts(this,'h_school_district')" id="h_school_city" class="form-select">
                                @foreach($cities as $city)
                                    <option data-id="{{ $city->id }}"  @if(isset($aday->infos->h_school_city ) && $aday->infos->h_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="h_school_district">Okulun Bulunduğu İlçe</label>
                            <select id="h_school_district" class="form-select">
                                <option>{{$aday->infos->h_school_district}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="student_number">Öğrenci Numarası</label>
                            <input value=" @if(isset($aday->infos->student_number)) {{$aday->infos->student_number}}@endif"  type="text" class="form-control" id="student_number"
                                   placeholder="Öğrenci numaranızı giriniz...">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="class">Sınıfınız</label>
                            <select id="class" class="form-select">
                                <option selected disabled value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->class) && $aday->infos->class == '9')  value="9">9</option>
                                <option @selected(isset($aday->infos->class) && $aday->infos->class == '10')  value="10">10</option>
                                <option @selected(isset($aday->infos->class) && $aday->infos->class == '11')  value="11">11</option>
                                <option @selected(isset($aday->infos->class) && $aday->infos->class == '12')  value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="is_transfered">Nakil Yaptı mı?</label>
                            <select id="is_transfered" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Evet') value="Evet">Evet</option>
                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="averageGrade">Not Ortalaması</label>
                            <input @if(isset($aday->infos->grade_avg)) value="{{$aday->infos->grade_avg}}" @endif  type="text" class="form-control" id="averageGrade"
                                   placeholder="Not ortalamanızı giriniz...">
                        </div>
                    </div>
                    @break
                @case('onlisans')
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="grade_high_school">Bitirdiğiniz Lise</label>
                            <input @if(isset($aday->infos->grade_high_school)) value="{{$aday->infos->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                                   placeholder="Lise bilgisi giriniz...">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                            <input @if(isset($aday->infos->entry_grade_university)) value="{{$aday->infos->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                                   placeholder="Puanınızı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_city">Okulun Bulunduğu Şehir</label>
                            <select id="university_city" class="form-select">
                                @foreach($cities as $city)
                                    <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                            <select id="current_university" class="form-select">
                                <option value="">Seçiniz...</option>
                                @foreach($unis as $u)
                                    <option data-id='{{$u->id}}' @selected(isset($aday->infos->current_university) && $aday->infos->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                            <select data-dataset="" class="form-select" name="university_faculty" required="" id="university_faculty">
                                <option>Fakulte Seciniz</option>
                                @if($aday->infos->university_faculty)
                                    <option selected value="{{$aday->infos->university_faculty}}">{{$aday->infos->university_faculty}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                            <select data-dataset="" class="form-select" name="grade_departmant" required="" id="grade_departmant">
                                <option>Bölüm Seciniz</option>
                                @if($aday->infos->grade_departmant)
                                    <option selected value="{{$aday->infos->grade_departmant}}">{{$aday->infos->grade_departmant}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_type">Üniversitenin Statüsü</label>
                            <select id="university_type" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Devlet') value="Devlet">Devlet</option>
                                <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_types"> Öğrenim Türü</label>
                            <select id="university_types" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Örgün') value="Örgün">Örgün</option>
                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="oKN3UeDifPTo">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                Olacaksınız?</label>
                            <select id="oKN3UeDifPTo" class="form-select">
                                <option selected disabled value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->oKN3UeDifPTo) && $aday->infos->oKN3UeDifPTo == '1') value="1">1.Sınıf</option>
                                <option @selected(isset($aday->infos->oKN3UeDifPTo) && $aday->infos->oKN3UeDifPTo == '2') value="2">2.Sınıf</option>
                                <option @selected(isset($aday->infos->oKN3UeDifPTo) && $aday->infos->oKN3UeDifPTo == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                            <select id="university_educ_time" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '1') value="1">1</option>
                                <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '2') value="2">2</option>
                                <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '3') value="3">3</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="student_number">Öğrenci Numarası</label>
                            <input value='@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}} @endif'  type="text" class="form-control" id="student_number"
                                   placeholder="Öğrenci numaranızı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="agnoSystem">AGNO Sisteminiz</label>
                            <select id="agnoSystem" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="agno">AGNO</label>
                            <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                                   placeholder="Not ortalamanızı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                            <select id="university_transfer" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                                <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                bilgilerinizi yazınız</label>
                            <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                   placeholder="Geçiş bilgilerinizi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3 form-group">
                            <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                yazınız</label>
                            <input value="@if(isset($aday->infos->languages)) {{$aday->infos->languages}} @endif" type="text" class="form-control" id="languages">
                        </div>
                    </div>

                    @break
                @case('lisans')
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="grade_high_school">Bitirdiğiniz Lise</label>
                            <input @if(isset($aday->infos->grade_high_school)) value="{{$aday->infos->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                                   placeholder="Lise bilgisi giriniz...">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                            <input @if(isset($aday->infos->entry_grade_university)) value="{{$aday->infos->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                                   placeholder="Puanınızı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_city">Okulun Bulunduğu Şehir</label>
                            <select id="university_city" class="form-select">
                                @foreach($cities as $city)
                                    <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                            <select id="current_university" class="form-select">
                                <option value="">Seçiniz...</option>
                                @foreach($unis as $u)
                                    <option data-id='{{$u->id}}' @selected(isset($aday->infos->current_university) && $aday->infos->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                            <select data-dataset="" class="form-select" name="university_faculty" required="" id="university_faculty">
                                <option>Fakulte Seciniz</option>
                                @if($aday->infos->university_faculty)
                                    <option selected value="{{$aday->infos->university_faculty}}">{{$aday->infos->university_faculty}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                            <select data-dataset="" class="form-select" name="grade_departmant" required="" id="grade_departmant">
                                <option>Bölüm Seciniz</option>
                                @if($aday->infos->grade_departmant)
                                    <option selected value="{{$aday->infos->grade_departmant}}">{{$aday->infos->grade_departmant}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_type">Üniversitenin Statüsü</label>
                            <select id="university_type" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Devlet') value="Devlet">Devlet</option>
                                <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                Olacaksınız?</label>
                            <select id="university_class" class="form-select">
                                <option selected disabled value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '1') value="1">1.Sınıf</option>
                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '2') value="2">2.Sınıf</option>
                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '3') value="3">3.Sınıf</option>
                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '4') value="4">4.Sınıf</option>
                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '5') value="5">5.Sınıf</option>
                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '6') value="6">6.Sınıf</option>
                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                            <select id="university_educ_time" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->departmentYear == '2') value="2">2</option>
                                <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '3') value="3">3</option>
                                <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '4') value="4">4</option>
                                <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '5') value="5">5</option>
                                <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '6') value="6">6</option>
                                <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '7') value="7">7</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="student_number">Öğrenci Numarası</label>
                            <input value='@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}} @endif'  type="text" class="form-control" id="student_number"
                                   placeholder="Öğrenci numaranızı giriniz...">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="agnoSystem">AGNO Sisteminiz</label>
                            <select id="agnoSystem" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="agno">AGNO</label>
                            <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                                   placeholder="Not ortalamanızı giriniz...">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                            <select id="university_transfer" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                                <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                bilgilerinizi yazınız</label>
                            <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                   placeholder="Geçiş bilgilerinizi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3 form-group">
                            <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                yazınız</label>
                            <input value="@if(isset($aday->infos->languages)) {{$aday->infos->languages}} @endif" type="text" class="form-control" id="languages">
                        </div>
                    </div>

                    @break
                @case('yukseklisans')
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="grade_university">Bitirdiğiniz Üniversite</label>
                            <input  @if(isset($aday->infos->grade_university)) value="{{$aday->infos->grade_university}}" @endif type="text" class="form-control" id="grade_university"
                                    placeholder="Üniversite bilgisi giriniz...">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="grade_departmant">Mezun Olduğunuz Bölüm</label>
                            <input type="text" @if(isset($aday->infos->grade_departmant)) value="{{$aday->infos->grade_departmant}}" @endif class="form-control" id="grade_departmant"
                                   placeholder="Puanınızı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                            <select id="university_city" class="form-select">
                                <option value="">Seçiniz...</option>
                                @foreach($cities as $city)
                                    <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="current_university">Yüksek Lisans Yaptığınız Üniversite</label>
                            <select id="current_university" class="form-select">
                                <option value="">Seçiniz...</option>
                                @if(isset($aday->infos->current_university)) <option  selected  value="{{ $aday->infos->current_university }}">{{ $aday->infos->current_university }}</option> @endif

                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 mb-3 form-group">
                            <label for="master_field">Yüksek Lisans Yaptığınız Dal</label>
                            <input @if(isset($aday->infos->master_field)) value="{{$aday->infos->master_field}}" @endif type="text" class="form-control" id="master_field"
                                   placeholder="Dal bilgisi giriniz...">
                        </div>

                        <div class="col-md-6 mb-3 form-group">
                            <label for="student_number">Öğrenci Numarası</label>
                            <input @if(isset($aday->infos->student_number)) value="{{$aday->infos->student_number}}" @endif  type="text" class="form-control" id="student_number"
                                   placeholder="Öğrenci numaranızı giriniz...">
                        </div>


                        <div class="col-md-6 mb-3 form-group">
                            <label for="grade_agno">Mezuniyet AGNO</label>
                            <input  @if(isset($aday->infos->grade_agno)) value="{{$aday->infos->grade_agno}}" @endif type="text" class="form-control" id="grade_agno"
                                    placeholder="Agno giriniz...">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="agno_type">AGNO Sisteminiz</label>
                            <select id="agno_type" class="form-select">
                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="agno">AGNO</label>
                            <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                                   placeholder="Not ortalamanızı giriniz...">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                            <select id="university_transfer" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                                <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                            </select>
                        </div>
                        <div class="col-md-12 mb-3 form-group">
                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                bilgilerinizi yazınız</label>
                            <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                   placeholder="Geçiş bilgilerinizi giriniz...">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                            yazınız</label>
                        <input value="@if(isset($aday->infos->languages)) {{$aday->infos->languages}} @endif" type="text" class="form-control" id="languages"
                               placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                    </div>

                    @break
            @endswitch
        </div>
    </div>
@endif
