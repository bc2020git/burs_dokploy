<!-- Başvuru Formu Modal -->
<div class="modal fade" id="applicationFormModal" tabindex="-1" aria-labelledby="applicationFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="applicationFormModalLabel">Başvuru Formu</h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-danger" id="downloadPdf">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M16.6673 7.5H13.334V2.5H6.66732V7.5H3.33398L10.0007 14.1667L16.6673 7.5ZM3.33398 15.8333V17.5H16.6673V15.8333H3.33398Z" fill="white"/>
                        </svg>
                        PDF İndir
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
            <div class="modal-body w-100" id="applicationFormContent">
                <div class="container mt-3">
                    <div class="d-flex flex-row">
                        <!-- Genel Bilgiler -->
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between" >
                                <h3>Genel Bilgiler</h3>
                                @php
    $fotografPath = $aday->infos->doc_fotograf;

@endphp
<img width='150' src=" @if($aday->infos->doc_fotograf){{ url($aday->infos->doc_fotograf) }} @else {{url('assets/images/default-profile.svg')}}  @endif " alt="Profile Photo" class="img-fluid rounded-circle">
 </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Adı</label>
                                    <input id="name" type="text" class="form-control" value="{{$aday->scholar->name}}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Soyadı</label>
                                    <input id="surname" type="text" class="form-control" value="{{$aday->scholar->surname}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">TC Kimlik Numarası</label>
                                    <input name="tc_no" id="tc_no" type="text" class="form-control" value="{{$aday->scholar->tc_no}}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label id="email" class="custom-label">E-Posta</label>
                                    <input type="text" class="form-control" value="{{$aday->scholar->email}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Telefon</label>
                                    <input id="tel_no" type="text" class="form-control telinputs"
                                           value="{{$aday->infos->tel_no}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Şube</label>
                                    <input disabled id="sube" type="text" class="form-control" value=" {{$aday->infos->sube}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Bursiyer Tipi</label>
                                    <select id="aday_turu" class="form-select">
                                        <option value="">Seçiniz</option>
                                        <option @if($aday->infos->aday_turu == 'Dernek') selected @endif value="Dernek">Dernek</option>
                                        <option @if($aday->infos->aday_turu == 'Vakıf') selected @endif value="Vakıf">Vakıf</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-check">
                                    <input @if($aday->infos->check_taahhutname == 'on') checked @endif class="form-check-input" type="checkbox" id="check_taahhutname">
                                    <p class="form-check-label mt-1" for="confirmation1"
                                       data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                        <u>Taahhütname'yi</u> okudum, kabul ediyorum
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" @if($aday->infos->check_acikriza == 'on') checked @endif type="checkbox" id="check_acikriza">
                                    <p class="form-check-label mt-1 " for="confirmation2"
                                       data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                        <u>Bursiyer Aile Bireyleri Aydınlatma Metni'ni</u> okudum, anladım.
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" @if($aday->infos->check_acikriza == 'on') checked @endif type="checkbox" id="check_acikriza">
                                    <p class="form-check-label mt-1 " for="confirmation3"
                                       style="cursor: pointer;"
                                       onclick="window.location.href='https://sacdd.org.tr/index.php/burs-fonu/kvkk';">
                                        <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" @if($aday->infos->check_acikriza == 'on') checked @endif type="checkbox" id="check_acikriza">
                                    <p class="form-check-label mt-1 " for="confirmation4"
                                       data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                        <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" @if($aday->infos->check_acikriza == 'on') checked @endif type="checkbox" id="check_acikriza">
                                    <p class="form-check-label mt-1 " for="confirmation5"
                                       data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                        <u>KVKK Kurallarının gereksinimlerini kabul ederim.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" @if($aday->infos->check_acikriza == 'on') checked @endif type="checkbox" id="check_acikriza">
                                    <p class="form-check-label mt-1 " for="confirmation6">
                                        Başvuru formunda beyan ettiğim bilgilerin doğruluğunu ve
                                        gerektiğinde
                                        araştırma yapılmasını kabul ediyorum.
                                    </p>
                                </div>

                            </div>
                            <hr>
                            <!-- Kişisel Bilgiler -->

                            <h3>Kişisel Bilgiler</h3>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="interviewDate">Doğum Tarihi</label>
                                    <div class="input-group">
                                        <input value="{{$aday->infos->b_dob}}" type="text" class="form-control inputDate" id="b_dob" placeholder="Tarih seçiniz">
                                        <div class="input-group-append no-border">
                                                                            <span class="input-group-text no-border" id="b_dobIcon">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="24" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                                                    <path d="M14 4h-1V2.5a.5.5 0 0 0-1 0V4H4V2.5a.5.5 0 0 0-1 0V4H2a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM1 6a1 1 0 0 1 1-1h1v.5a.5.5 0 0 0 1 0V5h8v.5a.5.5 0 0 0 1 0V5h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6zm1 2v5h12V8H2z"/>
                                                                                </svg>
                                                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Doğduğu Şehir</label>
                                    <select id="born_city" class="form-select">
                                        @foreach($cities as $city)
                                            <option @if($aday->infos->born_city == $city->name) selected @endif data-id="{{$city->il_no}}" value="{{$city->name}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Doğduğu İlçe</label>
                                    <select id="born_district" class="form-select">
                                        <option selected  value="{{$aday->infos->born_district}}">{{$aday->infos->born_district}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Nüfusa Kayıtlı Olduğu İl</label>
                                    <select id="registered_city" class="form-select">
                                        @foreach($cities as $city)
                                            <option @if($aday->infos->registered_city == $city->name) selected @endif data-id="{{$city->il_no}}" value="{{$city->name}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Nüfusa Kayıtlı Olduğu İlçe</label>
                                    <select id="registered_district" class="form-select">
                                        <option selected  value="{{$aday->infos->registered_district}}">{{$aday->infos->registered_district}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Cinsiyet</label>
                                    <select id="gender" class="form-select">
                                        <option @if($aday->infos->gender == 'Kadın') selected @endif value="Kadın">Kadın</option>
                                        <option @if($aday->infos->gender == 'Erkek') selected @endif value="Erkek">Erkek</option>
                                        <option @if($aday->infos->gender == 'Belirtmek İstemiyorum') selected @endif value="Belirtmek İstemiyorum">Belirtmek İstemiyorum</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Medeni Durumu</label>
                                    <select id="maritality" class="form-select">
                                        <option @if($aday->infos->maritality == 'Bekar') selected @endif value="Bekar">Bekar</option>
                                        <option  @if($aday->infos->maritality == 'Evli') selected @endif value="Evli">Evli</option>
                                        <option  @if($aday->infos->maritality == 'Boşanmış') selected @endif value="Boşanmış">Boşanmış</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Uyruk</label>
                                    <select id="nationality" class="form-select">
                                        <option @if($aday->infos->nationality == 'Türkiye') selected @endif value="Türkiye">Türkiye</option>
                                        <option @if($aday->infos->nationality == 'Diğer') selected @endif value="Diğer">Diğer</option>
                                    </select>
                                </div>
                            </div>
                            <hr>

                            <!-- Kişisel Bilgiler -->

                            <h3>Eğitim Bilgileri</h3>
                            <div class="row">
                                <div class="form-group">
                                <label class="custom-label">Eğitim Tipi</label>
                                <input id="educationType" type="text" class="form-control" value="{{$aday->infos->educationType}}">
                                @switch($aday->infos->educationType)
                                    @case('ilkokul')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okul Tipi</label>
                                                <input id="primary_educ_type" type="text" class="form-control" value="{{$aday->infos->primary_educ_type}}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okul Adı</label>
                                                <input id="p_school_name" type="text" class="form-control" value="{{$aday->infos->p_school_name}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okulun Bulunduğu Şehir</label>
                                                <select onchange="getDistricts(this,'p_school_district')" id="p_school_city" class="form-select">
                                                    @foreach($cities as $city)
                                                        <option data-id="{{ $city->id }}"  @if(isset($aday->infos->p_school_city ) && $aday->infos->p_school_city == $city->name) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>                    </div>
                                            <div class="col-md-6 mb-3 form-group">
                                                <label for="p_school_district">Okulun Bulunduğu İlçe</label>
                                                <select id="p_school_district" class="form-select">
                                                    @if(isset($aday->infos->p_school_district)) <option value="{{$aday->infos->p_school_district}} ">{{$aday->infos->p_school_district}}</option>@endif
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Sınıf</label>
                                                <input id="class" type="text" class="form-control" value="{{$aday->infos->class}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenci Numarası</label>
                                                <input id="student_number" type="text" class="form-control" value="{{$aday->infos->student_number}}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Not Ortalaması</label>
                                                <input id="grade_avg" type="text" class="form-control" value=" {{$aday->infos->grade_avg}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Nakil Yaptı Mı</label>
                                                <input id="is_transfered" type="text" class="form-control" value="{{$aday->infos->is_transfered}}">
                                            </div>
                                        </div>
                                        @break

                                    @case('ortaokul')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="schoolType">Okul Tipi</label>
                                                <select id="schoolType" class="form-select">
                                                    <option disabled selected>Ortaokul</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="m_school_name">Okul Adı</label>
                                                <input  type="text" class="form-control"  @if(isset($aday->infos->m_school_name)) value="{{$aday->infos->m_school_name}}" @endif id="m_school_name"
                                                        placeholder="Okul adınızı giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                                                <select onchange="getDistricts(this,'m_school_district')" id="m_school_city" class="form-select">
                                                    <option selected disabled>Şehir Seçiniz</option>
                                                    @foreach($cities as $city)
                                                        <option data-id="{{ $city->id }}"  @if(isset($aday->infos->m_school_city ) && $aday->infos->m_school_city == $city->name) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                                                <select id="m_school_district" class="form-select">
                                                    @if(isset($aday->infos->m_school_district)) <option value="{{$aday->infos->m_school_district}} ">{{$aday->infos->m_school_district}}</option>@endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="student_number">Öğrenci Numarası</label>
                                                <input value="@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}}@endif" type="text" class="form-control" id="student_number"
                                                    placeholder="Öğrenci numaranızı giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
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
                                            <div class="col-md-6 mb-3">
                                                <label for="transferred">Nakil Yaptı mı?</label>
                                                <select id="transferred" class="form-select">
                                                    <option selected disabled value="">Seçiniz...</option>
                                                    <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Evet') value="Evet">Evet</option>
                                                    <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="student_number">Not Ortalaması</label>
                                                <input value="@if(isset($aday->infos->student_number)) {{$aday->infos->grade_avg}}@endif" type="text" class="form-control" id="student_number"
                                                    placeholder="Not ortalamanızı giriniz...">
                                            </div>
                                        </div>
                                        @break
                                    @case('lise')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="schoolType">Okul Tipi</label>
                                                <select id="schoolType" class="form-select">
                                                    <option value="Lise">Lise</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="h_school_name">Okul Adı</label>
                                                <input value='{{$aday->infos->h_school_name}}' type="text" class="form-control" id="h_school_name"
                                                    placeholder="Okul adınızı giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="h_school_city">Okulun Bulunduğu Şehir</label>
                                                <select onchange="getDistricts(this,'h_school_district')" id="h_school_city" class="form-select">
                                                    <option value="">Seçiniz</option>
                                                    @foreach($cities as $city)
                                                        <option data-id="{{ $city->id }}"  @if(isset($aday->infos->h_school_city ) && $aday->infos->h_school_city == $city->name) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="h_school_district">Okulun Bulunduğu İlçe</label>
                                                <select id="h_school_district" class="form-select">
                                                    <option>{{$aday->infos->h_school_district}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="student_number">Öğrenci Numarası</label>
                                                <input value=" @if(isset($aday->infos->student_number)) {{$aday->infos->student_number}}@endif"  type="text" class="form-control" id="student_number"
                                                    placeholder="Öğrenci numaranızı giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
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
                                            <div class="col-md-6 mb-3">
                                                <label for="is_transfered">Nakil Yaptı mı?</label>
                                                <select id="is_transfered" class="form-select">
                                                    <option value="">Seçiniz...</option>
                                                    <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Evet') value="Evet">Evet</option>
                                                    <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="averageGrade">Not Ortalaması</label>
                                                <input @if(isset($aday->infos->grade_avg)) value="{{$aday->infos->grade_avg}}" @endif  type="text" class="form-control" id="averageGrade"
                                                    placeholder="Not ortalamanızı giriniz...">
                                            </div>
                                        </div>
                                        @break
                                    @case('onlisans')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="grade_high_school">Bitirdiğiniz Lise</label>
                                                <input @if(isset($aday->infos->grade_high_school)) value="{{$aday->infos->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                                                    placeholder="Lise bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                                                <input @if(isset($aday->infos->entry_grade_university)) value="{{$aday->infos->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                                                    placeholder="Puanınızı giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="university_city">Okulun Bulunduğu Şehir</label>
                                                <select id="university_city" class="form-select">
                                                    @foreach($cities as $city)
                                                        <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                                                <select id="current_university" class="form-select">
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="university_type">Üniversitenin Statüsü</label>
                                                <select id="university_type" class="form-select">
                                                    <option value="">Seçiniz...</option>
                                                    <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Devlet') value="Devlet">Devlet</option>
                                                    <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                                    Olacaksınız?</label>
                                                <select id="university_class" class="form-select">
                                                    <option selected disabled value="">Seçiniz...</option>
                                                    <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '1.Sınıf') value="1.Sınıf">1.Sınıf</option>
                                                    <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '2.Sınıf') value="2.Sınıf">2.Sınıf</option>
                                                    <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '3.Sınıf') value="3.Sınıf">3.Sınıf</option>
                                                    <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '4.Sınıf') value="4.Sınıf">4.Sınıf</option>
                                                    <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '5.Sınıf') value="5.Sınıf">5.Sınıf</option>
                                                    <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '6.Sınıf') value="6.Sınıf">6.Sınıf</option>
                                                    <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                                <select id="university_educ_time" class="form-select">
                                                    <option value="">Seçiniz...</option>
                                                    <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '2') value="2">2</option>
                                                    <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '4') value="4">4</option>
                                                    <option @selected(isset($aday->infos->university_educ_time) && $aday->infos->university_educ_time == '6') value="6">6</option>

                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="student_number">Öğrenci Numarası</label>
                                                <input value='@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}} @endif'  type="text" class="form-control" id="student_number"
                                                    placeholder="Öğrenci numaranızı giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="agno_type">AGNO Sisteminiz</label>
                                                <select id="agno_type" class="form-select">
                                                    <option value="">Seçiniz...</option>
                                                    <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                                                    <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>

                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="agno">AGNO</label>
                                                <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                                                    placeholder="Not ortalamanızı giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                                <select id="university_transfer" class="form-select">
                                                    <option value="">Seçiniz...</option>
                                                    <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                                                    <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                                    bilgilerinizi yazınız</label>
                                                <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                                    placeholder="Geçiş bilgilerinizi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
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
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '2') value="2">2</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '3') value="3">3</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '4') value="4">4</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '5') value="5">5</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '6') value="6">6</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '7') value="7">7</option>
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
                                                <label for="agno_type">AGNO Sisteminiz</label>
                                                <select id="agno_type" class="form-select">
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
                                    @case('yukseklisans')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="grade_university">Bitirdiğiniz Üniversite</label>
                                                <input  @if(isset($aday->infos->grade_university)) value="{{$aday->infos->grade_university}}" @endif type="text" class="form-control" id="grade_university"
                                                        placeholder="Üniversite bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="grade_departmant">Mezun Olduğunuz Bölüm</label>
                                                <input type="text" @if(isset($aday->infos->grade_departmant)) value="{{$aday->infos->grade_departmant}}" @endif class="form-control" id="grade_departmant"
                                                    placeholder="Puanınızı giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                                                <select id="university_city" class="form-select">
                                                    <option value="">Seçiniz...</option>
                                                    @foreach($cities as $city)
                                                        <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
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
                                                <label for="master_field">Yüksek Lisans Yaptığınız Dal</label>
                                                <input @if(isset($aday->infos->master_field)) value="{{$aday->infos->master_field}}" @endif type="text" class="form-control" id="master_field"
                                                    placeholder="Dal bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="student_number">Öğrenci Numarası</label>
                                                <input @if(isset($aday->infos->student_number)) value="{{$aday->infos->student_number}}" @endif  type="text" class="form-control" id="student_number"
                                                    placeholder="Öğrenci numaranızı giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
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
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '2') value="2">2</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '3') value="3">3</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '4') value="4">4</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '5') value="5">5</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '6') value="6">6</option>
                                                    <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '7') value="7">7</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="grade_agno">Mezuniyet AGNO</label>
                                                <input  @if(isset($aday->infos->grade_agno)) value="{{$aday->infos->grade_agno}}" @endif type="text" class="form-control" id="grade_agno"
                                                        placeholder="Agno giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="agno_type">AGNO Sisteminiz</label>
                                                <select id="agno_type" class="form-select">
                                                    <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                                                    <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="agno">AGNO</label>
                                                <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                                                    placeholder="Not ortalamanızı giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                                <select id="university_transfer" class="form-select">
                                                    <option value="">Seçiniz...</option>
                                                    <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                                                    <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                                    bilgilerinizi yazınız</label>
                                                <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                                    placeholder="Geçiş bilgilerinizi giriniz...">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                                yazınız</label>
                                            <input value="@if(isset($aday->infos->languages)) {{$aday->infos->languages}} @endif" type="text" class="form-control" id="languages"
                                                placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                                        </div>

                                        @break
                                @endswitch
                            </div>
                           <hr>
                           <!--  Kalinan Yer  Bilgileri -->
                           <h3>Kalan Yer Bilgileri</h3>
                           <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Barınma Türü</label>
                                <select id="housing_type" class="form-select">
                                    <option @if($aday->infos->housing_type == 'Öğrenci Evi') selected @endif  value="Öğrenci Evi">Öğrenci Evi</option>
                                    <option @if($aday->infos->housing_type == 'Yurt') selected @endif value="Yurt">Yurt</option>
                                    <option @if($aday->infos->housing_type == 'Aile Yanı') selected @endif value="Aile Yanı">Aile Yanı</option>
                                    <option @if($aday->infos->housing_type == 'Misafir') selected @endif value="Misafir">Misafir</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Ödenen Ücret</label>
                                <input id="housing_fee" type="text" class="form-control" value="{{$aday->infos->housing_fee}}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Birlikte Yaşanılan Kişi Sayısı</label>
                                <input id="living_with_count" type="text" class="form-control"
                                       value="{{$aday->infos->living_with_count}}">

                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Kaldığı İl</label>
                                <select id="residing_city" class="form-select">
                                    @foreach($cities as $city)
                                        <option  data-id="{{$city->id}}" @if($aday->infos->residing_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Kaldığı İlçe</label>
                                <select id="residing_district" class="form-select">
                                    <option  selected value="{{$aday->infos->residing_district}}">{{$aday->infos->residing_district}}</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Tam Adres</label>
                                <input id="address_detail" type="text" class="form-control"
                                       value="{{$aday->infos->address_detail}}">
                            </div>
                           </div>

                           <hr>
                           <!--  Aile Adresi Bilgileri -->
                           <h3>Aile Adres Bilgileri</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Yaşadığı İl</label>
                                    <select id="mother_city" class="form-select">
                                        <option value="">Seçiniz</option>
                                        @foreach($cities as $city)
                                            <option  data-id="{{$city->id}}" @if($aday->infos->mother_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Yaşadığı İl</label>
                                    <select id="father_city" class="form-select">
                                        <option value="">Seçiniz</option>
                                        @foreach($cities as $city)
                                            <option  data-id="{{$city->id}}" @if($aday->infos->father_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Yaşadığı İlçe</label>
                                    <select id="mother_district" class="form-select">
                                        <option value="">Seçiniz</option>
                                        <option  selected value="{{$aday->infos->mother_district}}">{{$aday->infos->mother_district}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Yaşadığı İlçe</label>
                                    <select id="father_district" class="form-select">
                                        <option value="">Seçiniz</option>
                                        <option  selected value="{{$aday->infos->father_district}}">{{$aday->infos->father_district}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Açık Adres</label>
                                    <input id="parent_address" type="text" class="form-control"
                                           value="{{$aday->infos->parent_address}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label" for="phone">Aile Cep Telefonu</label>
                                    <br>
                                    <input type="tel" id="parent_mobile" value="{{$aday->infos->parent_mobile}}" class="form-control" placeholder="+90 506 144 5288"
                                           style="width:390px ; ">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Aile Ev Telefonu</label>
                                    <input id="parent_phone" type="text" class="form-control"
                                           value="{{$aday->infos->parent_phone}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Aile E-posta Adresi</label>
                                    <input id="parent_email" type="text" class="form-control"
                                           value="{{$aday->infos->parent_email}}">
                                </div>
                            </div>
                            <div class="urgent">
                                <div class="row">
                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z"
                                                fill="black" />
                                        </svg> Acil Durum Kişisi</p>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Ad</label>
                                        <input type="text" class="form-control " id="emergency_person_name" value="{{$aday->infos->emergency_person_name}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Soyad</label>
                                        <input type="text" class="form-control " id="emergency_person_surname" value="{{$aday->infos->emergency_person_surname}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Yakınlık Derecesi</label>
                                        <input type="text" class="form-control " id="emergency_closeness" value="{{$aday->infos->emergency_closeness}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Cep Telefonu</label>
                                        <input type="text" class="form-control " id='emergency_mobile' value="{{$aday->infos->emergency_mobile}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">E-Posta Adresi</label>
                                        <input type="text" class="form-control " value="">
                                    </div>
                                </div>
                            </div>
                           </div>

                           <hr>
                           <!-- Ebeveyn Bilgileri -->
                           <h3>Ebeveyn Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Anne Baba Birlikte Mi?</label>
                                        <input id="parent_together" type="text" class="form-control" @if(isset($aday->infos->parent_together)) value="{{$aday->infos->parent_together}}" @endif >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Anne  Sağ Mı?</label>
                                        <input id="mother_alive" type="text" class="form-control" @if(isset($aday->infos->mother_alive)) value="{{$aday->infos->mother_alive}}" @endif >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Baba  Sağ Mı?</label>
                                        <input id=" " type="text" class="form-control" @if(isset($aday->infos->C9l7SUqOxSvZ)) value="{{$aday->infos->C9l7SUqOxSvZ}}" @endif >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Anne Ad </label>
                                        <input id="mother_name" type="text" class="form-control" @if(isset($aday->infos->mother_name)) value="{{$aday->infos->mother_name}}" @endif >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Anne Soyad </label>
                                        <input id="mother_name" type="text" class="form-control" @if(isset($aday->infos->mother_surname)) value="{{$aday->infos->mother_surname}}" @endif >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Baba Ad </label>
                                        <input id="father_name" type="text" class="form-control" @if(isset($aday->infos->father_name)) value="{{$aday->infos->father_name}}" @endif >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Baba Soyad </label>
                                        <input id="father_name" type="text" class="form-control" @if(isset($aday->infos->father_surname)) value="{{$aday->infos->father_surname}}" @endif >
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Annenin Mesleği</label>
                                        <input id="mother_job" type="text" class="form-control" @if(isset($aday->infos->mother_job)) value="{{$aday->infos->mother_job}}" @endif >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Babanın Mesleği</label>
                                        <input id="father_job" type="text" class="form-control" @if(isset($aday->infos->father_job)) value="{{$aday->infos->father_job}}" @endif >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Annenin Tahsil Durumu</label>
                                        <input id="mother_educ" type="text" class="form-control" @if(isset($aday->infos->mother_educ)) value="{{$aday->infos->mother_educ}}" @endif >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Babanın Tahsil Durumu</label>
                                        <input id="father_educ" type="text" class="form-control" @if(isset($aday->infos->father_educ)) value="{{$aday->infos->father_educ}}" @endif >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Annenin Bağlı Olduğu Sosyal Güvenlik
                                            Kurumu</label>
                                        <input id="mother_company" type="text" class="form-control" @if(isset($aday->infos->mother_company)) value="{{$aday->infos->mother_company}}" @endif >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Babanın Bağlı Olduğu Sosyal Güvenlik
                                            Kurumu</label>
                                        <input id="father_company" type="text" class="form-control" @if(isset($aday->infos->father_company)) value="{{$aday->infos->father_company}}" @endif >
                                    </div>
                                </div>
                            </div>

                           <hr>
                           <!-- Kardeş Bilgileri -->
                           <h3>Kardeş Bilgileri</h3>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Kardeş Sayısı</label>
                                                <select id="count" class="form-select">
                                                <option value="">Seçiniz</option>
                                                <option @if($aday->infos->count == 1) selected @endif value="1">1</option>
                                                <option @if($aday->infos->count == 2) selected @endif value="2">2</option>
                                                <option @if($aday->infos->count == 3) selected @endif value="3">3</option>
                                                <option @if($aday->infos->count == 4) selected @endif value="4">4</option>
                                                <option @if($aday->infos->count == '5 ve üzeri') selected @endif value="5 ve üzeri">5 ve üzeri</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Kendisi Dahil Okuyan Kardeş Sayısı</label>
                                            <input id="educ_count" type="number" class="form-control" value="{{$aday->infos->educ_count}}">
                                        </div>
                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Adı</th>
                                            <th>Soyadı</th>
                                            <th>Yaşı</th>
                                            <th>Öğrenim Durumu</th>
                                            <th>Medeni Durumu</th>
                                            <th>Mesleği (Çalışıyorsa)</th>
                                            <th>İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($aday->scholar->kardesler as $kardes)
                                            <tr>
                                                <td>{{$kardes->name}}</td>
                                                <td>{{$kardes->surname}}</td>
                                                <td>{{$kardes->age}}</td>
                                                <td>{{$kardes->educ_status}}</td>
                                                <td>{{$kardes->maritality}}</td>
                                                <td>{{$kardes->job}}</td>
                                                <td>
                                                    <button data-id="{{$kardes->id}}" data-name="{{$kardes->name}}" data-surname="{{$kardes->surname}}"  data-age="{{$kardes->age}}" data-educ_statust="{{$kardes->educ_statust}} data-maritality="{{$kardes->maritality}} data-job="{{$kardes->job}}" class="btn edit-member-info-btn editSiblingBtn" type="button"
                                                            class="btn btn-primary mb-3 editSiblingBtn" data-bs-toggle="modal"
                                                            data-bs-target="#kardesDuzenleModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" fill="#4069E5"/>
                                                        </svg></button>
                                                    <a href="{{route('deleteNewScholarSibling',['id'=>$kardes->id])}}"><button class="btn" type="button" class="btn btn-primary mb-3"
                                                                                                                               data-bs-toggle="modal" data-bs-target="#kardesSilModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM9 11V17H11V11H9ZM13 11V17H15V11H13ZM9 4V6H15V4H9Z" fill="#F03000"/>
                                                            </svg></button></a>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                           <hr>
                           <!-- Gelir Bilgileri -->
                           <h3>Gelir Beyanı</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Geçmişini Kim/Kimler
                                        Sağlıyor?</label>
                                    <input id="income_person" type="text" class="form-control" value="{{$aday->infos->income_person}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç
                                        Kişiye
                                        Bakıyor?</label>
                                    <input id="total_person" type="number" class="form-control" value="{{$aday->infos->total_person}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Aylık Net Geliri (TL)</label>
                                    <input id="mother_salary" type="text" class="form-control"
                                           value="{{$aday->infos->mother_salary}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Aylık Net Geliri (TL)</label>
                                    <input id="father_salary" type="text" class="form-control"
                                           value="{{$aday->infos->father_salary}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Diğer Kişilerin Aylık Net Geliri
                                        (TL)</label>
                                    <input id="other_salary" type="text" class="form-control"
                                           value="{{$aday->infos->other_salary}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Başka Geliri Var Mı?</label>
                                    <input id="other_income" type="text" class="form-control" value="{{$aday->infos->other_income}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Yaşamakta Olduğu Ev Türü</label>
                                    <select class="form-select" id="parent_housing_type" required>
                                        <option selected disabled>Seçiniz...</option>
                                       <option @if($aday->infos->parent_housing_type == ' Evi') selected @endif value="Kendi Evi">Kendi Evi</option>
                                       <option @if($aday->infos->parent_housing_type == 'Kiralık') selected @endif value="Kiralık">Kiralık</option>
                                       <option @if($aday->infos->parent_housing_type == 'Misafir') selected @endif value="Misafir">Misafir</option>
                                       <option @if($aday->infos->parent_housing_type == 'Diğer') selected @endif value="Diğer">Diğer</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kira ise Aylık Net Kirası (TL)</label>
                                    <input id="rent_count" type="text" class="form-control" value="{{$aday->infos->rent_count}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="custom-label">Diğer</label>
                                    <input id="other_detail" type="text" class="form-control" value="{{$aday->infos->other_detail}}">
                                </div>
                            </div>
                           </div>
                           <hr>
                           <!-- Diger Burs Bilgileri -->
                           <h3>Diger Burs Bilgileri</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Devlet Bursu Almakta mı ya da Başvurdu
                                        mu?</label>
                                    <select id="government" class="form-select">
                                        <option @if($aday->infos->government == 'Evet') selected @endif  value="Evet">Evet</option>
                                        <option @if($aday->infos->government == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Özel Burs Almakta ya da Başvurdu mu?</label>
                                    <select id="special" class="form-select">
                                        <option @if($aday->infos->special == 'Evet') selected @endif  value="Evet">Evet</option>
                                        <option @if($aday->infos->special == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                    </select>
                                </div>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Burs</th>
                                    <th>Kurum Türü</th>
                                    <th>Kurum Adı</th>
                                    <th> Burs Tutarı</th>
                                    <th>Seçenekler</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($aday->infos->otherScholarships as $sc)
                                    <tr>
                                        <td></td>
                                        <td>{{$sc->company_name}}</td>
                                        <td>{{$sc->company_type}}</td>
                                        <td>{{$sc->count}}</td>
                                        <td>
                                            <button data-editid="{{$sc->id}}" data-kurumadi="{{$sc->company_name}}"  data-kurumturu="{{$sc->company_type}}" data-bursmiktari="{{$sc->count}}" class="btn edit-member-info-btn editBursBtn" type="button"
                                                    class="btn btn-primary mb-3 editBursBtn" data-bs-toggle="modal"
                                                    data-bs-target="#bursDuzenleModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" fill="#4069E5"/>
                                                </svg></button>
                                            <a href="{{route('deleteNewScholarScholarShip',['id'=>$sc->id])}}"><button class="btn" type="button" class="btn btn-primary mb-3"
                                                                                                                       data-bs-toggle="modal" data-bs-target="#kardesSilModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM9 11V17H11V11H9ZM13 11V17H15V11H13ZM9 4V6H15V4H9Z" fill="#F03000"/>
                                                    </svg></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                           </div>
                           <hr>

                           <!-- Engellilik Bilgileri -->
                           <h3>Engel Durumu</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="custom-label">Herhangi Bir Engeliniz Var mı?</label>
                                    <select id="disabled_status" class="form-select">
                                        <option @if($aday->infos->disabled_status == 'Evet') selected @endif  value="Evet">Evet</option>
                                        <option @if($aday->infos->disabled_status == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="custom-label">Engel Durumunu Açıklayınız (Varsa)</label>
                                    <input id="detail" type="text" class="form-control" value="{{$aday->infos->detail}}">
                                </div>
                            </div>
                           </div>
                            <hr>

                            <!-- Sosyal Durum Bilgileri -->
                            <h3>Sosyal Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Bizden Nasıl Haberdar Oldunuz?</label>
                                        <select class="form-select" id="platform" required>
                                            <option selected disabled>Seçiniz...</option>
                                            <option @if($aday->infos->platform == 'Sosyal Medya') selected @endif value="Sosyal Medya">Sosyal Medya</option>
                                            <option @if($aday->infos->platform == 'Web Sitesi') selected @endif value="Web Sitesi">Web Sitesi</option>
                                            <option @if($aday->infos->platform == 'Diğer') selected @endif value="Diğer">Diğer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Güçlü Yanlarınızın Ne olduğunu
                                            Düşünüyorsunuz?</label>
                                        <input id="skills" type="text" class="form-control" value="{{$aday->infos->skills}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Katkıda Bulunduğunuz Sosyal Projeler</label>
                                        <input id="social_projects" type="text" class="form-control"
                                               value="{{$aday->infos->social_projects}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Hobileriniz</label>
                                        <input id="hobbies" type="text" class="form-control" value="{{$aday->infos->hobbies}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">İlgilendiğiniz Spor Dalı (Varsa)</label>
                                        <input id="sports" type="text" class="form-control" value="{{$aday->infos->sports}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Son Okuduğunuz Kitaplar</label>
                                        <input id="last_books" type="text" class="form-control"
                                               value="{{$aday->infos->last_books}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Bize Mesajınız</label>
                                        <input id="message" type="text" class="form-control"
                                               value="{{$aday->infos->message}}">
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- Hesap Bilgileri -->
                            <h3>Hesap Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Banka</label>
                                        <select id="bank_name" class="form-select">
                                            <option @if($aday->infos->bank_name == 'Vakıfbank') selected @endif value="Vakıfbank">Vakıfbank</option>
                                            <option @if($aday->infos->bank_name == 'Ziraat Bankası') selected @endif value="Ziraat Bankası">Ziraat Bankası</option>
                                            <option @if($aday->infos->bank_name == 'İş bankası') selected @endif value="İş bankası">İş bankası</option>
                                            <option @if($aday->infos->bank_name == 'FinansBank') selected @endif value="FinansBank">FinansBank</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="iban" class="form-label">IBAN</label>
                                            <input type="text" class="form-control" id="iban"
                                                   value="{{$aday->infos->iban}}" maxlength="26">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="custom-label">Hesap Numarası</label>
                                            <input id="account_number" type="text" class="form-control"
                                                   value="{{$aday->infos->account_number}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- İş Bilgileri -->
                            <h3>İş Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Düzenli olarak bir kurumda kazanç sağlıyor
                                            mu?</label>
                                        <select id="is_working" class="form-select">
                                            <option @if($aday->infos->is_working == 'Full-time') selected @endif  value="Full-time">Full-time</option>
                                            <option @if($aday->infos->is_working == 'Part-time') selected @endif value="Part-time">Part-time</option>
                                            <option @if($aday->infos->is_working == 'Stajyer') selected @endif value="Stajyer">Stajyer</option>
                                            <option @if($aday->infos->is_working == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                            <option @if($aday->infos->is_working == 'Diğer') selected @endif value="Diğer">Diğer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Kurum Adı</label>
                                        <input id="job_company" type="text" class="form-control" value="{{$aday->infos->job_company}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Görev</label>
                                        <input id="job_rank" type="text" class="form-control" value="{{$aday->infos->job_rank}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Sosyal Güvenlik Kurumu</label>
                                        <input id="job_sgk" type="text" class="form-control" value="{{$aday->infos->job_sgk}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Aylık Net Ücret (TL)</label>
                                        <input id="job_salary" type="text" class="form-control" value="{{$aday->infos->job_salary}}">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
