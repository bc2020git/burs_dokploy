@extends('layouts.student.master')
@section('title')
    Başvuru Formu
@endsection
@section('page-title')
    Başvuru Formu
@endsection
@section('body')

    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div id="application-form-master">
                    <h2>Başvuru Formu</h2>
                    <div class="main-content-manuel">
                        <div class="step-container">
                            <div class="step-item active" data-target="1">
                                <div class="step-number">1</div>
                                <div class="step-text">Genel Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="2">
                                <div class="step-number">2</div>
                                <div class="step-text">Kişisel Bilgiler</div>
                            </div>
                            <div class="step-item" data-target="3">
                                <div class="step-number">3</div>
                                <div class="step-text">Eğitim Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="4">
                                <div class="step-number">4</div>
                                <div class="step-text">Kalınan Yer Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="5">
                                <div class="step-number">5</div>
                                <div class="step-text">Aile Adres Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="6">
                                <div class="step-number">6</div>
                                <div class="step-text">Ebeveyn Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="7">
                                <div class="step-number">7</div>
                                <div class="step-text">Kardeş Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="8">
                                <div class="step-number">8</div>
                                <div class="step-text">Gelir Beyanı</div>
                            </div>
                            <div class="step-item" data-target="9">
                                <div class="step-number">9</div>
                                <div class="step-text">Diğer Burslar</div>
                            </div>
                            <div class="step-item" data-target="10">
                                <div class="step-number">10</div>
                                <div class="step-text">Engel Durumu</div>
                            </div>
                            <div class="step-item" data-target="11">
                                <div class="step-number">11</div>
                                <div class="step-text">Sosyal Bilgiler</div>
                            </div>
                            <div class="step-item" data-target="12">
                                <div class="step-number">12</div>
                                <div class="step-text">Hesap Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="13">
                                <div class="step-number">13</div>
                                <div class="step-text">İş Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="14">
                                <div class="step-number">14</div>
                                <div class="step-text">Belge Yükleme</div>
                            </div>
                        </div>
                        <form>
                            @include('student.layouts.general-infos')
                            @include('student.layouts.personal-infos')
                            <div class="step-content" id="step-3" data-content="3">
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
                                        <select onchange="getylunis(this,'masterUniversity');" id="university_city" class="form-select">
                                            <option selected disabled > Sehir Seciniz</option>
                                            @foreach($unicities as $city)
                                                <option data-id="{{ $city->sehir }}"  @if( isset($aday->educinfo->university_city) && $aday->educinfo->university_city == $city->isim) selected @endif value="{{$city->sehir}}">{{$city->sehir}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="masterUniversity">Yüksek Lisans Yaptığınız Üniversite</label>
                                        <select class='form-select' onchange="getFaculties(this,'faculty');" name='masterUniversity' id='masterUniversity'>
                                               <option selected disabled> Şehir Seçiniz...</option>
                                               @foreach($ylisansunis as $uni)
                                                <option value="{{$uni->universite_adi_yuk}}">{{$uni->universite_adi_yuk}}</option>
                                               @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="masterDepartment">Yüksek Lisans Yaptığınız Bölüm</label>
                                         <input @if(isset($aday->educinfo->masterDepartment)) value="{{$aday->educinfo->masterDepartment}}" @endif type="text" class="form-control" id="masterDepartment"
                                               placeholder="Bölüm bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="masterBranch">Yüksek Lisans Yaptığınız Dal</label>
                                        <select class='form-select' id='masterBranch'>
                                            <option disabled selected>Dal seciniz</option>
                                            <option @if(isset($aday->educinfo->master_field) && $aday->educinfo->master_field == 'Hukuk ve Kadın'  ) selected @endif  value="Hukuk ve Kadın" >Hukuk ve Kadın</option>
                                            <option @if(isset($aday->educinfo->master_field) && $aday->educinfo->master_field == 'Çocuk Hakları') selected @endif  value="Çocuk Hakları" >Çocuk Hakları</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input @if(isset($aday->educinfo->master_field)) value="{{$aday->educinfo->master_field}}" @endif  type="text" class="form-control" id="studentNumber"
                                               placeholder="Öğrenci numaranızı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="educationYear"> {{$aday->period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                            Olacaksınız?</label>
                                        <select id="educationYear" class="form-select">
                                            <option disabled selected > Seçiniz</option>
                                            <option @if( isset($aday->educinfo->educationYear) && $aday->educinfo->educationYear == 1) selected @endif value='1'>1</option>
                                            <option @if( isset($aday->educinfo->educationYear) && $aday->educinfo->educationYear == 2) selected @endif value='2'>2</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="departmentYear">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                        <select id="departmentYear" class="form-select">
                                            <option disabled selected > Seçiniz</option>
                                            <option @if( isset($aday->educinfo->departmentYear) && $aday->educinfo->departmentYear == 1) selected @endif value='1'>1</option>
                                            <option @if( isset($aday->educinfo->departmentYear) && $aday->educinfo->departmentYear == 2) selected @endif value='2'>2</option>                                        </select>
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
                                </div>
                            </div>
                            @include('student.layouts.housing-infos')
                            @include('student.layouts.familyAddress-infos')
                            @include('student.layouts.parent-infos')
                            @include('student.layouts.sibling-infos')
                            <div class="step-content" id="step-8" data-content="8">
                                    @include('student.layouts.income-infos')
                                @include('student.layouts.highincome-infos')
                            </div>
                            @include('student.layouts.otherscholarships-infos')
                            @include('student.layouts.obstacled-infos')
                            @include('student.layouts.social-infos')
                            @include('student.layouts.bank-infos')
                            @include('student.layouts.job-infos')
                            @include('student.layouts.documents-infos')
                        </form>
                    </div>
                </div>
            </div>
        </main>
        </div>
        <div class="transfer-modal-footer d-flex justify-content-end g-3">
            <button type="button" class="btn cancel-button" id="prevStep">Vazgeç</button>
            <button style="display: none;" type="button" class="btn btn-outline-primary next-button" id="prevButton">Önceki</button>
            <button type="button" class="btn btn-primary next-button" id="nextStep">Sonraki</button>
            <button style="display: none;" type="button" class="btn btn-primary next-button" id="completeButton">Tamamla</button>
        </div>
        </div>

        <!--Modal Alanı-->
        @include('student.layouts.modals')

    @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="../../assets/js/components/dashboard-student.js"></script>
        <script src="../../assets/js/components/student-buttons2.js"></script>
        @include('student.layouts.scriptF')
                @include('includes.js.sidebar')

@endsection
