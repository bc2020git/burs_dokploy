@extends('layouts.student.master')
@section('title')
    Kayıt Yenileme Formu
@endsection
@section('page-title')
    Kayıt Yenileme Formu
@endsection
@section('body')

    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div id="application-form-associate">
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
                                <input type="hidden">
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
                                        <label for="educationYear">{{$aday->period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                            Olacaksınız?</label>
                                        <select id="educationYear" class="form-select">
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
        <div class="transfer-modal-footer d-flex justify-content-end g-3">
            <button type="button" class="btn cancel-button" id="prevStep">Vazgeç</button>
            <button style="display: none;" type="button" class="btn btn-outline-primary next-button" id="prevButton">Önceki</button>
            <button type="button" class="btn btn-primary next-button" id="nextStep">Sonraki</button>
            <button style="display: none;" type="button" class="btn btn-primary next-button" id="completeButton">Tamamla</button>
        </div>
        <!--Modal Alanı-->
        @include('student.kayityenileme.layouts.modals')

    @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="{{ url('assets/js/student-tab-manager.js') }}"></script>
        <script>
            // scriptF.blade.php içindeki çakışan adım yönetimi kodunu devre dışı bırakıp
            // sadece StudentTabManager kullanacağımızı belirtiyoruz
            window.useOnlyStudentTabManager = true;

            document.addEventListener('DOMContentLoaded', function() {
                const pageName = 'kayityenileme'+{{ $scholarid ?? 'associate' }};
                StudentTabManager.init('application-form-associate', pageName);
            });
        </script>
        <script src="../../assets/js/components/dashboard-student.js"></script>
        <script src="../../assets/js/components/student-buttons2.js"></script>
        @include('student.kayityenileme.layouts.scriptF')


@endsection
