@if($aday->educationType == 'seçiniz')
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
                        <select id="primary_educ_type" class="form-select">
                            <option disabled selected>Seçiniz..</option>
                            <option value="Özel Okul">Özel Okul</option>
                            <option value="Devlet Okulu">Devlet Okulu</option>
                        </select>
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
                                <option data-id="{{ $city->name }}"  value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Sınıf</label>
                        <select id="class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option  @selected(isset($aday->class) && $aday->class == '1') value="1">1</option>
                            <option  @selected(isset($aday->class) && $aday->class == '2') value="2">2</option>
                            <option  @selected(isset($aday->class) && $aday->class == '3') value="3">3</option>
                            <option  @selected(isset($aday->class) && $aday->class == '4') value="4">4</option>
                        </select>
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
                        <input  type="text" class="form-control"  @if(isset($aday->m_school_name)) value="{{$aday->m_school_name}}" @endif id="m_school_name"
                                placeholder="Okul adınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                        <select onchange="getDistricts(this,'m_school_district')" id="m_school_city" class="form-select">
                            <option selected disabled>Şehir Seçiniz</option>
                            @foreach($cities as $city)
                                <option data-id="{{ $city->name }}"  @if(isset($aday->m_school_city ) && $aday->m_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                        <select id="m_school_district" class="form-select">
                            @if(isset($aday->m_school_district)) <option value="{{$aday->m_school_district}} ">{{$aday->m_school_district}}</option>@endif
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value="@if(isset($aday->student_number)) {{$aday->student_number}}@endif" type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="class">Sınıfınız</label>
                        <select id="class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option  @selected(isset($aday->class) && $aday->class == '5') value="5">5</option>
                            <option  @selected(isset($aday->class) && $aday->class == '6') value="6">6</option>
                            <option  @selected(isset($aday->class) && $aday->class == '7') value="7">7</option>
                            <option  @selected(isset($aday->class) && $aday->class == '8') value="8">8</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="transferred">Nakil Yaptı mı?</label>
                        <select id="transferred" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Evet') value="Evet">Evet</option>
                            <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Not Ortalaması</label>
                        <input value="@if(isset($aday->student_number)) {{$aday->grade_avg}}@endif" type="text" class="form-control" id="student_number"
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
                                <option data-id="{{ $city->name }}"  @if(isset($aday->h_school_city ) && $aday->h_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
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
                        <input value=" @if(isset($aday->student_number)) {{$aday->student_number}}@endif"  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="class">Sınıfınız</label>
                        <select id="class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option @selected(isset($aday->class) && $aday->class == '9')  value="9">9</option>
                            <option @selected(isset($aday->class) && $aday->class == '10')  value="10">10</option>
                            <option @selected(isset($aday->class) && $aday->class == '11')  value="11">11</option>
                            <option @selected(isset($aday->class) && $aday->class == '12')  value="12">12</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="is_transfered">Nakil Yaptı mı?</label>
                        <select id="is_transfered" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Evet') value="Evet">Evet</option>
                            <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="averageGrade">Not Ortalaması</label>
                        <input @if(isset($aday->grade_avg)) value="{{$aday->grade_avg}}" @endif  type="text" class="form-control" id="averageGrade"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
            </div>
            <div id="onlisansdiv" class="educdiv d-none">

                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_high_school">Bitirdiğiniz Lise</label>
                        <input @if(isset($aday->grade_high_school)) value="{{$aday->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                               placeholder="Lise bilgisi giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                        <input @if(isset($aday->entry_grade_university)) value="{{$aday->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                               placeholder="Puanınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_city">Okulun Bulunduğu Şehir</label>
                        <select id="university_city" class="form-select">
                            @foreach($cities as $city)
                                <option data-id="{{ $city->name }}"  @if( isset($aday->university_city) && $aday->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                        <select id="current_university" class="form-select">
                            <option value="">Seçiniz...</option>
                            @foreach($unis as $u)
                                <option data-id='{{$u->id}}' @selected(isset($aday->current_university) && $aday->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_type">Üniversitenin Statüsü</label>
                        <select id="university_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_type) && $aday->university_type == 'Devlet') value="Devlet">Devlet</option>
                            <option @selected(isset($aday->university_type) && $aday->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_types"> Öğrenim Türü</label>
                        <select id="university_types" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Örgün') value="Örgün">Örgün</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 form-group">
                        <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                            Olacaksınız?</label>
                        <select id="university_class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '1.Sınıf') value="1.Sınıf">1.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '2.Sınıf') value="2.Sınıf">2.Sınıf</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                        <select id="university_educ_time" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '2') value="2">2</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '3') value="3">3</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '4') value="4">4</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '5') value="5">5</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '6') value="6">6</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value='@if(isset($aday->student_number)) {{$aday->student_number}} @endif'  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno_type">AGNO Sisteminiz</label>
                        <select id="agno_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "4'lük") value="4'lük">4'lük</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "100'lük") value="100'lük">100'lük</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno">AGNO</label>
                        <input value="@if(isset($aday->agno)) {{$aday->agno}} @endif" type="text" class="form-control" id="agno"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                        <select id="university_transfer" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option value="Evet" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Evet')>Evet</option>
                            <option value="Hayır" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Hayır')>Hayır</option>

                        </select>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                            bilgilerinizi yazınız</label>
                        <input value="@if(isset($aday->university_transfer_desc)) {{$aday->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                               placeholder="Geçiş bilgilerinizi giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group">
                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                            yazınız</label>
                        <input value="@if(isset($aday->languages)) {{$aday->languages}} @endif" type="text" class="form-control" id="languages">
                    </div>
                </div>
            </div>

            <div id="lisansdiv" class="educdiv d-none">

                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_high_school">Bitirdiğiniz Lise</label>
                        <input @if(isset($aday->grade_high_school)) value="{{$aday->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                               placeholder="Lise bilgisi giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                        <input @if(isset($aday->entry_grade_university)) value="{{$aday->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                               placeholder="Puanınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_city">Okulun Bulunduğu Şehir</label>
                        <select id="university_city" class="form-select">
                            @foreach($cities as $city)
                                    <option data-id="{{ $city->name }}"  @if( isset($aday->university_city) && $aday->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                        <select id="current_university" class="form-select">
                            <option value="">Seçiniz...</option>
                            @foreach($unis as $u)
                                <option data-id='{{$u->id}}' @selected(isset($aday->current_university) && $aday->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_type">Üniversitenin Statüsü</label>
                        <select id="university_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_type) && $aday->university_type == 'Devlet') value="Devlet">Devlet</option>
                            <option @selected(isset($aday->university_type) && $aday->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_types"> Öğrenim Türü</label>
                        <select id="university_types" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Örgün') value="Örgün">Örgün</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 form-group">
                        <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                            Olacaksınız?</label>
                        <select id="university_class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '1') value="1">1.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '2') value="2">2.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '3') value="3">3.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '4') value="4">4.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '5') value="5">5.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '6') value="6">6.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                        <select id="university_educ_time" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '2') value="2">2</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '3') value="3">3</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '4') value="4">4</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '5') value="5">5</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '6') value="6">6</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '7') value="7">7</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value='@if(isset($aday->student_number)) {{$aday->student_number}} @endif'  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno_type">AGNO Sisteminiz</label>
                        <select id="agno_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "4'lük") value="4'lük">4'lük</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "100'lük") value="100'lük">100'lük</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno">AGNO</label>
                        <input value="@if(isset($aday->agno)) {{$aday->agno}} @endif" type="text" class="form-control" id="agno"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="is_transfered">Yatay/Dikey Geçiş Yaptı mı?</label>
                        <select id="is_transfered" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option value="Evet" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Evet')>Evet</option>
                            <option value="Hayır" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Hayır')>Hayır</option>

                        </select>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                            bilgilerinizi yazınız</label>
                        <input value="@if(isset($aday->university_transfer_desc)) {{$aday->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                               placeholder="Geçiş bilgilerinizi giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group">
                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                            yazınız</label>
                        <input value="@if(isset($aday->languages)) {{$aday->languages}} @endif" type="text" class="form-control" id="languages">
                    </div>
                </div>
            </div>

                <div id="yukseklisansdiv" class=" educdiv d-none">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="grade_university">Bitirdiğiniz Üniversite</label>
                            <input  @if(isset($aday->grade_university)) value="{{$aday->grade_university}}" @endif type="text" class="form-control" id="grade_university"
                                    placeholder="Üniversite bilgisi giriniz...">
                        </div>

                        <div class="col-md-6 mb-3 form-group">
                            <label for="grade_departmant">Mezun Olduğunuz Bölüm</label>
                            <input type="text" @if(isset($aday->department)) value="{{$aday->department}}" @endif class="form-control" id="grade_departmant"
                                   placeholder="Puanınızı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                            <select id="university_city" class="form-select">
                                <option value="">Seçiniz...</option>
                                @foreach($cities as $city)
                                    <option data-id="{{ $city->name }}"  @if( isset($aday->university_city) && $aday->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
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
                            <input @if(isset($aday->master_field)) value="{{$aday->master_field}}" @endif type="text" class="form-control" id="master_field"
                                   placeholder="Dal bilgisi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="student_number">Öğrenci Numarası</label>
                            <input @if(isset($aday->student_number)) value="{{$aday->student_number}}" @endif  type="text" class="form-control" id="student_number"
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
                                <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '2') value="2">2</option>
                                <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '3') value="3">3</option>
                                <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '4') value="4">4</option>
                                <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '5') value="5">5</option>
                                <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '6') value="6">6</option>
                                <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '7') value="7">7</option>

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
                                <option value="">Seçiniz...</option>
                                <option @selected(isset($aday->agno_type) && $aday->agno_type == "4'lük") value="4'lük">4'lük</option>
                                <option @selected(isset($aday->agno_type) && $aday->agno_type == "100'lük") value="100'lük">100'lük</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="agno">AGNO</label>
                            <input value="@if(isset($aday->agno)) {{$aday->agno}} @endif" type="text" class="form-control" id="agno"
                                   placeholder="Not ortalamanızı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                            <select id="university_transfer" class="form-select">
                                <option value="">Seçiniz...</option>
                                <option value="Evet" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Evet')>Evet</option>
                                <option value="Hayır" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Hayır')>Hayır</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3 form-group">
                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                bilgilerinizi yazınız</label>
                            <input value="@if(isset($aday->university_transfer_desc)) {{$aday->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                   placeholder="Geçiş bilgilerinizi giriniz...">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                            yazınız</label>
                        <input value="@if(isset($aday->languages)) {{$aday->languages}} @endif" type="text" class="form-control" id="languages"
                                placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                    </div>
                </div>


            </div>
        </div>
@else

<div class="tab-pane fade" id="education-info" role="tabpanel"
     aria-labelledby="education-info-tab" data-content="3">
    <div class="tab-section">
        <label class="custom-label">Öğretim Tipi</label><span style="color: red" > * (Tip değişikliğinde kaydet kapat) </span>
        <select name="educationType" onchange="educationTypeChange()" id="educationType" class="form-select">
            <option selected disabled value="seçiniz">Seçiniz..</option>
            <option @if($aday->educationType =='ilkokul') selected @endif value="ilkokul">İlkokul</option>
            <option @if($aday->educationType =='ortaokul') selected @endif value="ortaokul">Ortaokul</option>
            <option @if($aday->educationType =='lise') selected @endif value="lise">Lise</option>
            <option @if($aday->educationType =='onlisans') selected @endif value="onlisans">Ön lisans</option>
            <option @if($aday->educationType =='lisans') selected @endif value="lisans">Lisans</option>
            <option @if($aday->educationType =='yukseklisans') selected @endif value="yukseklisans">Yükseklisans</option>
            <option @if($aday->educationType =='doktora') selected @endif value="doktora">Doktora</option>
        </select>
        @switch($aday->educationType)

            @case('ilkokul')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Okul Tipi</label>
                        <select id="primary_educ_type" class="form-select">
                            <option disabled selected>Seçiniz..</option>
                            <option @selected(isset($aday->primary_educ_type) && $aday->primary_educ_type == 'Özel Okul') value="Özel Okul">Özel Okul</option>
                            <option @selected(isset($aday->primary_educ_type) && $aday->primary_educ_type == 'Devlet Okulu') value="Devlet Okulu">Devlet Okulu</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Okul Adı</label>
                        <input id="p_school_name" type="text" class="form-control" value="{{$aday->p_school_name}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                        <select onchange="getDistricts(this,'p_school_district')" id="p_school_city" class="form-select">
                            <option selected disabled>Şehir Seçiniz</option>
                            @foreach($cities as $city)
                                <option data-id="{{ $city->name }}"  @if(isset($aday->p_school_city ) && $aday->p_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                        <select id="p_school_district" class="form-select">
                            @if(isset($aday->p_school_district)) <option value="{{$aday->p_school_district}} ">{{$aday->p_school_district}}</option>@endif
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Sınıf</label>
                        <select id="class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option  @selected(isset($aday->class) && $aday->class == '1') value="1">1</option>
                            <option  @selected(isset($aday->class) && $aday->class == '2') value="2">2</option>
                            <option  @selected(isset($aday->class) && $aday->class == '3') value="3">3</option>
                            <option  @selected(isset($aday->class) && $aday->class == '4') value="4">4</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Öğrenci Numarası</label>
                        <input id="student_number" type="text" class="form-control" value="{{$aday->student_number}}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Not Ortalaması</label>
                        <input id="grade_avg" type="text" class="form-control" value=" {{$aday->grade_avg}}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-label">Nakil Yaptı Mı</label>
                        <input id="is_transfered" type="text" class="form-control" value="{{$aday->is_transfered}}">
                    </div>
                </div>
                @break

            @case('ortaokul')
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="schoolType">Okul Tipi</label>
                        <select id="middle_educ_type" class="form-select">
                            <option disabled selected>Seçiniz..</option>
                            <option @selected(isset($aday->middle_educ_type) && $aday->middle_educ_type == 'Özel Okul') value="Özel Okul">Özel Okul</option>
                            <option @selected(isset($aday->middle_educ_type) && $aday->middle_educ_type == 'Devlet Okulu') value="Devlet Okulu">Devlet Okulu</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_name">Okul Adı</label>
                        <input  type="text" class="form-control"  @if(isset($aday->m_school_name)) value="{{$aday->m_school_name}}" @endif id="m_school_name"
                                placeholder="Okul adınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                        <select onchange="getDistricts(this,'m_school_district')" id="m_school_city" class="form-select">
                            <option selected disabled>Şehir Seçiniz</option>
                            @foreach($cities as $city)
                                <option data-id="{{ $city->name }}"  @if(isset($aday->m_school_city ) && $aday->m_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                        <select id="m_school_district" class="form-select">
                            @if(isset($aday->m_school_district)) <option value="{{$aday->m_school_district}} ">{{$aday->m_school_district}}</option>@endif
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value="@if(isset($aday->student_number)) {{$aday->student_number}}@endif" type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="class">Sınıfınız</label>
                        <select id="class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option  @selected(isset($aday->class) && $aday->class == '5') value="5">5</option>
                            <option  @selected(isset($aday->class) && $aday->class == '6') value="6">6</option>
                            <option  @selected(isset($aday->class) && $aday->class == '7') value="7">7</option>
                            <option  @selected(isset($aday->class) && $aday->class == '8') value="8">8</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="transferred">Nakil Yaptı mı?</label>
                        <select id="transferred" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Evet') value="Evet">Evet</option>
                            <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Not Ortalaması</label>
                        <input value="@if(isset($aday->student_number)) {{$aday->grade_avg}}@endif" type="text" class="form-control" id="student_number"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
                @break
            @case('lise')
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="h_school_type">Okul Tipi</label>
                        <select id="h_school_type" class="form-select">
                            <option disabled selected>Seçiniz..</option>
                            <option @selected(isset($aday->h_school_type) && $aday->h_school_type == 'Devlet Lisesi') value="Devlet Lisesi">Devlet Lisesi</option>
                            <option @selected(isset($aday->h_school_type) && $aday->h_school_type == 'Özel Lise (Tam burslu)') value="Özel Lise (Tam burslu)">Özel Lise (Tam burslu)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="h_school_name">Okul Adı</label>
                        <input value='{{$aday->h_school_name}}' type="text" class="form-control" id="h_school_name"
                               placeholder="Okul adınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="h_school_city">Okulun Bulunduğu Şehir</label>
                        <select onchange="getDistricts(this,'h_school_district')" id="h_school_city" class="form-select">
                            @foreach($cities as $city)
                                <option data-id="{{ $city->name }}"  @if(isset($aday->h_school_city ) && $aday->h_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="h_school_district">Okulun Bulunduğu İlçe</label>
                        <select id="h_school_district" class="form-select">
                            <option>{{$aday->h_school_district}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value=" @if(isset($aday->student_number)) {{$aday->student_number}}@endif"  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="class">Sınıfınız</label>
                        <select id="class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option @selected(isset($aday->class) && $aday->class == '9')  value="9">9</option>
                            <option @selected(isset($aday->class) && $aday->class == '10')  value="10">10</option>
                            <option @selected(isset($aday->class) && $aday->class == '11')  value="11">11</option>
                            <option @selected(isset($aday->class) && $aday->class == '12')  value="12">12</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="is_transfered">Nakil Yaptı mı?</label>
                        <select id="is_transfered" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Evet') value="Evet">Evet</option>
                            <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                        </select>
                    </div>
<div class="col-md-6 mb-3 form-group">
                        <label for="grade_avg">Not Ortalaması</label>
                        <input @if(isset($aday->grade_avg)) value="{{$aday->grade_avg}}" @endif  type="text" class="form-control" id="grade_avg"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
                @break
            @case('onlisans')
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_high_school">Bitirdiğiniz Lise</label>
                        <input @if(isset($aday->grade_high_school)) value="{{$aday->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                               placeholder="Lise bilgisi giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                        <input @if(isset($aday->entry_grade_university)) value="{{$aday->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                               placeholder="Puanınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_city">Okulun Bulunduğu Şehir</label>
                        <select id="university_city" class="form-select">
                            @foreach($cities as $city)
                                <option data-id="{{ $city->name }}"  @if( isset($aday->university_city) && $aday->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                        <select id="current_university" class="form-select">
                            <option value="">Seçiniz...</option>
                            @foreach($unis as $u)
                                <option data-id='{{$u->id}}' @selected(isset($aday->current_university) && $aday->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                        <select data-dataset="" class="form-select" name="university_faculty" required="" id="university_faculty">
                            <option>Fakulte Seciniz</option>
                            @if($aday->university_faculty)
                                <option selected value="{{$aday->university_faculty}}">{{$aday->university_faculty}}</option>
                            @endif
                            </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                        <select data-dataset="" class="form-select" name="departmant" required="" id="grade_departmant">
                            <option>Bölüm Seciniz</option>
                            @if($aday->grade_departmant)
                                <option selected value="{{$aday->grade_departmant}}">{{$aday->grade_departmant}}</option>
                            @endif
                            </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_type">Üniversitenin Statüsü</label>
                        <select id="university_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_type) && $aday->university_type == 'Devlet') value="Devlet">Devlet</option>
                            <option @selected(isset($aday->university_type) && $aday->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_types"> Öğrenim Türü</label>
                        <select id="university_types" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Örgün') value="Örgün">Örgün</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                            Olacaksınız?</label>
                        <select id="oKN3UeDifPTo" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option @selected(isset($aday->oKN3UeDifPTo) && $aday->oKN3UeDifPTo  == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                            <option @selected(isset($aday->oKN3UeDifPTo) && $aday->oKN3UeDifPTo  == '1') value="1">1.Sınıf</option>
                            <option @selected(isset($aday->oKN3UeDifPTo) && $aday->oKN3UeDifPTo  == '2') value="2">2.Sınıf</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                        <select id="university_educ_time" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '2') value="2">2</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '3') value="3">3</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '4') value="4">4</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '5') value="5">5</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '6') value="6">6</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '7') value="7">7</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value='@if(isset($aday->student_number)) {{$aday->student_number}} @endif'  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno_type">AGNO Sisteminiz</label>
                        <select id="agno_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "4'lük") value="4'lük">4'lük</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "100'lük") value="100'lük">100'lük</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno">AGNO</label>
                        <input value="@if(isset($aday->agno)) {{$aday->agno}} @endif" type="text" class="form-control" id="agno"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                        <select id="university_transfer" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option value="Evet" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Evet')>Evet</option>
                            <option value="Hayır" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Hayır')>Hayır</option>

                        </select>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                            bilgilerinizi yazınız</label>
                        <input value="@if(isset($aday->university_transfer_desc)) {{$aday->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                               placeholder="Geçiş bilgilerinizi giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group">
                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                            yazınız</label>
                        <input value="@if(isset($aday->languages)) {{$aday->languages}} @endif" type="text" class="form-control" id="languages">
                    </div>
                </div>

                @break
            @case('lisans')
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_high_school">Bitirdiğiniz Lise</label>
                        <input @if(isset($aday->grade_high_school)) value="{{$aday->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                               placeholder="Lise bilgisi giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                        <input @if(isset($aday->entry_grade_university)) value="{{$aday->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                               placeholder="Puanınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_city">Okulun Bulunduğu Şehir</label>
                        <select id="university_city" class="form-select">
                            @foreach($cities as $city)
                                <option data-id="{{ $city->name }}"  @if( isset($aday->university_city) && $aday->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                        <select id="current_university" class="form-select">
                            <option value="">Seçiniz...</option>
                            @foreach($unis as $u)
                                <option data-id='{{$u->id}}' @selected(isset($aday->current_university) && $aday->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                        <select data-dataset="" class="form-select" name="university_faculty" required="" id="university_faculty">
                            <option>Fakulte Seciniz</option>
                            @if($aday->university_faculty)
                                <option selected value="{{$aday->university_faculty}}">{{$aday->university_faculty}}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                        <select data-dataset="" class="form-select" name="grade_departmant" required="" id="grade_departmant">
                            <option>Bölüm Seciniz</option>
                            @if($aday->grade_departmant)
                                <option selected value="{{$aday->grade_departmant}}">{{$aday->grade_departmant}}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_type">Üniversitenin Statüsü</label>
                        <select id="university_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_type) && $aday->university_type == 'Devlet') value="Devlet">Devlet</option>
                            <option @selected(isset($aday->university_type) && $aday->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_types"> Öğrenim Türü</label>
                        <select id="university_types" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Örgün') value="Örgün">Örgün</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                            <option @selected(isset($aday->university_types) && $aday->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                            Olacaksınız?</label>
                        <select id="university_class" class="form-select">
                            <option selected disabled value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '1') value="1">1.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '2') value="2">2.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '3') value="3">3.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '4') value="4">4.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '5') value="5">5.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == '6') value="6">6.Sınıf</option>
                            <option @selected(isset($aday->university_class) && $aday->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                        <select id="university_educ_time" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '2') value="2">2</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '3') value="3">3</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '4') value="4">4</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '5') value="5">5</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '6') value="6">6</option>
                            <option @selected(isset($aday->university_educ_time) && $aday->university_educ_time == '7') value="7">7</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input value='@if(isset($aday->student_number)) {{$aday->student_number}} @endif'  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno_type">AGNO Sisteminiz</label>
                        <select id="agno_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "4'lük") value="4'lük">4'lük</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "100'lük") value="100'lük">100'lük</option>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno">AGNO</label>
                        <input value="@if(isset($aday->agno)) {{$aday->agno}} @endif" type="text" class="form-control" id="agno"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                        <select id="university_transfer" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option value="Evet" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Evet')>Evet</option>
                            <option value="Hayır" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Hayır')>Hayır</option>

                        </select>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                            bilgilerinizi yazınız</label>
                        <input value="@if(isset($aday->university_transfer_desc)) {{$aday->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                               placeholder="Geçiş bilgilerinizi giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group">
                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                            yazınız</label>
                        <input value="@if(isset($aday->languages)) {{$aday->languages}} @endif" type="text" class="form-control" id="languages">
                    </div>
                </div>

                @break
            @case('yukseklisans')
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_university">Bitirdiğiniz Üniversite</label>
                        <input  @if(isset($aday->grade_university)) value="{{$aday->grade_university}}" @endif type="text" class="form-control" id="grade_university"
                                placeholder="Üniversite bilgisi giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_departmant">Mezun Olduğunuz Bölüm</label>
                        <input type="text" @if(isset($aday->grade_departmant)) value="{{$aday->grade_departmant}}" @endif class="form-control" id="grade_departmant"
                               placeholder="Puanınızı giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                        <select id="university_city" class="form-select">
                            <option value="">Seçiniz...</option>
                            @foreach($cities as $city)
                                <option data-id="{{ $city->name }}"  @if( isset($aday->university_city) && $aday->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="current_university">Yüksek Lisans Yaptığınız Üniversite</label>
                        <select id="current_university" class="form-select">
                            <option @if(isset($aday->current_university)) value="{{$aday->current_university}}" @endif> {{$aday->current_university}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6 mb-3 form-group">
                        <label for="master_field">Yüksek Lisans Yaptığınız Dal</label>
                        <input @if(isset($aday->master_field)) value="{{$aday->master_field}}" @endif type="text" class="form-control" id="master_field"
                               placeholder="Dal bilgisi giriniz...">
                    </div>

                    <div class="col-md-6 mb-3 form-group">
                        <label for="student_number">Öğrenci Numarası</label>
                        <input @if(isset($aday->student_number)) value="{{$aday->student_number}}" @endif  type="text" class="form-control" id="student_number"
                               placeholder="Öğrenci numaranızı giriniz...">
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-6 mb-3 form-group">
                        <label for="grade_agno">Mezuniyet AGNO</label>
                        <input  @if(isset($aday->grade_agno)) value="{{$aday->grade_agno}}" @endif type="text" class="form-control" id="grade_agno"
                                placeholder="Agno giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno_type">AGNO Sisteminiz</label>
                        <select id="agno_type" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "4'lük") value="4'lük">4'lük</option>
                            <option @selected(isset($aday->agno_type) && $aday->agno_type == "100'lük") value="100'lük">100'lük</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="agno">AGNO</label>
                        <input value="@if(isset($aday->agno)) {{$aday->agno}} @endif" type="text" class="form-control" id="agno"
                               placeholder="Not ortalamanızı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                        <select id="university_transfer" class="form-select">
                            <option value="">Seçiniz...</option>
                            <option value="Evet" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Evet')>Evet</option>
                            <option value="Hayır" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Hayır')>Hayır</option>

                        </select>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                            bilgilerinizi yazınız</label>
                        <input value="@if(isset($aday->university_transfer_desc)) {{$aday->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                               placeholder="Geçiş bilgilerinizi giriniz...">
                    </div>
                </div>
                <div class="col-md-12 mb-3 form-group">
                    <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                        yazınız</label>
                    <input value="@if(isset($aday->languages)) {{$aday->languages}} @endif" type="text" class="form-control" id="languages"
                           placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                </div>

                @break
        @endswitch
    </div>
</div>
@endif
