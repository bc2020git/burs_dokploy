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
                <div id="application-form-middle">
                    <h2>Kayıt Yenileme Formu</h2>
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
                            <div class="step-content active" id="step-1" data-content="1">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="bursiyerAdi" class="form-label">Adı</label>
                                        <input type="text" class="form-control" id="bursiyerAdi" value="Ahsen" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="bursiyerSoyadi" class="form-label">Soyadı</label>
                                        <input type="text" class="form-control" id="bursiyerSoyadi" value="Soyad"
                                               readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
                                        <input type="text" class="form-control" id="bursiyerTcNo" value="12345678989"
                                               readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="bursiyerPosta" class="form-label">E-posta</label>
                                        <input type="email" class="form-control" id="bursiyerPosta"
                                               placeholder="ahsen@ahsen.com" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="bursiyerSube" class="form-label">Şube</label>
                                        <input type="text" class="form-control" id="bursiyerSube"
                                               value="Şube ataması sistem tarafından yapılacaktır." readonly>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirmation1">
                                    <p class="form-check-label mt-1" for="confirmation1">
                                        Vermiş olduğum cevapların doğru olduğunu kabul ve taahhüt ederim.
                                    </p>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirmation2">
                                    <p class="form-check-label mt-1 " for="confirmation2" data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                        <u>KVKK Kurallarının gereksinimlerini kabul ederim.</u>
                                    </p>
                                </div>
                            </div>
                            <div class="step-content" id="step-2" data-content="2">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="birthDate" class="form-label">Doğum Tarihi</label>
                                        <input type="text" class="form-control" id="birthDate" value="06.06.2000"
                                               readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="birthCity">Doğduğu Şehir</label>
                                        <input type="text" class="form-control" id="birthCity" value="Ankara"
                                               readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="birthDistrict">Doğduğu İlçe</label>
                                        <input type="text" class="form-control" id="birthDistrict" value="Mamak"
                                               readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="registeredCity">Nüfusa Kayıtlı Olduğu İl</label>
                                        <select id="registeredCity" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="registeredDistrict">Nüfusa Kayıtlı Olduğu İlçe</label>
                                        <select id="registeredDistrict" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="gender">Cinsiyet</label>
                                        <select id="gender" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="maritalStatus">Medeni Durum</label>
                                        <select id="maritalStatus" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nationality" class="form-label">Uyruk</label>
                                        <input type="text" class="form-control" id="nationality" value="Türkiye"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="step-content" id="step-3" data-content="3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="schoolType">Okul Tipi</label>
                                        <input type="text" class="form-control" id="schoolType" value="İlkokul"
                                               readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="schoolName">Okul Adı</label>
                                        <input type="text" class="form-control" id="schoolName"
                                               placeholder="B Okulu">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="schoolCity">Okulun Bulunduğu Şehir</label>
                                        <select id="schoolCity" class="form-select">
                                            <option selected value="">Ankara</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="schoolDistrict">Okulun Bulunduğu Şehir</label>
                                        <select id="schoolDistrict" class="form-select">
                                            <option selected value="">Keçiören</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input type="text" class="form-control" id="studentNumber"
                                               placeholder="190205034">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="grade">Sınıfınız</label>
                                        <select id="grade" class="form-select">
                                            <option value="">11/D</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="transferred">Nakil Yaptı mı?</label>
                                        <select id="transferred" class="form-select">
                                            <option disabled value="">Seçiniz...</option>
                                            <option selected value="">Evet</option>
                                            <option value="">Hayır</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="averageGrade">Not Ortalaması</label>
                                        <input type="text" class="form-control" id="averageGrade"
                                               placeholder="88.8">
                                    </div>
                                </div>
                            </div>

                            <div class="step-content" id="step-4" data-content="4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="housingType">Barınma Türü</label>
                                        <select id="housingType" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="housingFee">Ödenen Ücret</label>
                                        <input type="text" class="form-control" id="housingFee"
                                               placeholder="Ödenen ücret bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="livingWithCount">Birlikte Yaşanılan Kişi Sayısı</label>
                                        <input type="text" class="form-control" id="livingWithCount"
                                               placeholder="Kişi sayısı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="residingCity">Kaldığı İl</label>
                                        <select id="residingCity" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="residingDistrict">Kaldığı İlçe</label>
                                        <select id="residingDistrict" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="addressDetail">Açık Adres</label>
                                        <input type="text" class="form-control" id="addressDetail"
                                               placeholder="Adres bilgisi giriniz...">
                                    </div>
                                </div>
                            </div>

                            <div class="step-content" id="step-5" data-content="5">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="motherCity">Annenin Yaşadığı İl</label>
                                        <select id="motherCity" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fatherCity">Babanın Yaşadığı İl</label>
                                        <select id="fatherCity" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="motherDistrict">Annenin Yaşadığı İlçe</label>
                                        <select id="motherDistrict" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fatherDistrict">Babanın Yaşadığı İlçe</label>
                                        <select id="fatherDistrict" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="address">Açık Adres</label>
                                        <input type="text" id="address" class="form-control"
                                               placeholder="Adres bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="parentMobile">Ailenin Cep Telefonu</label>
                                        <input type="text" id="parentMobile" class="form-control"
                                               placeholder="Telefon numarası giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="parentHomePhone">Ailenin Ev Telefonu</label>
                                        <input type="text" id="parentHomePhone" class="form-control"
                                               placeholder="Telefon numarası giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="parentEmail">Ailenin E-posta Adresi</label>
                                        <input type="email" id="parentEmail" class="form-control"
                                               placeholder="E-posta adresi giriniz...">
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
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="adSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="adSoyad"
                                                       placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="telefon" class="form-label">Telefon</label>
                                                <input type="text" class="form-control" id="telefon"
                                                       placeholder="Telefon numarası giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="yakınlıkDerecesi" class="form-label">Yakınlık
                                                    Derecesi</label>
                                                <input type="text" class="form-control" id="yakınlıkDerecesi"
                                                       placeholder="Yakınlık derecesi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-content" id="step-6" data-content="6">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="anneBabaBirlikte" class="form-label">Anne Baba Birlikte mi?</label>
                                        <select class="form-select" id="anneBabaBirlikte" required>
                                            <option selected disabled>Seçiniz...</option>
                                            <option value="Evet">Evet</option>
                                            <option value="Hayır">Hayır</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="anneBabaSag" class="form-label">Anne Baba Sağ mı?</label>
                                        <select class="form-select" id="anneBabaSag" required>
                                            <option selected disabled>Seçiniz...</option>
                                            <option value="Evet">Evet</option>
                                            <option value="Hayır">Hayır</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="babaAdSoyad" class="form-label">Baba Ad Soyad</label>
                                        <input type="text" class="form-control" id="babaAdSoyad"
                                               placeholder="Ad soyad giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="anneAdSoyad" class="form-label">Anne Ad Soyad</label>
                                        <input type="text" class="form-control" id="anneAdSoyad"
                                               placeholder="Ad soyad giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="babaninMeslegi" class="form-label">Babanın Mesleği</label>
                                        <input type="text" class="form-control" id="babaninMeslegi"
                                               placeholder="Meslek bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="anneninMeslegi" class="form-label">Annenin Mesleği</label>
                                        <input type="text" class="form-control" id="anneninMeslegi"
                                               placeholder="Meslek bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="babaninTahsilDurumu" class="form-label">Babanın Tahsil
                                            Durumu</label>
                                        <input type="text" class="form-control" id="babaninTahsilDurumu"
                                               placeholder="Tahsil durumu giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="anneninTahsilDurumu" class="form-label">Annenin Tahsil
                                            Durumu</label>
                                        <input type="text" class="form-control" id="anneninTahsilDurumu"
                                               placeholder="Tahsil durumu giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="babaninSosyalGuvenlik" class="form-label">Babanın Bağlı Olduğu
                                            Sosyal Güvenlik
                                            Kurumu</label>
                                        <input type="text" class="form-control" id="babaninSosyalGuvenlik"
                                               placeholder="Kurum bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="anneninSosyalGuvenlik" class="form-label">Annenin Bağlı Olduğu
                                            Sosyal Güvenlik
                                            Kurumu</label>
                                        <input type="text" class="form-control" id="anneninSosyalGuvenlik"
                                               placeholder="Kurum bilgisi giriniz...">
                                    </div>
                                </div>
                            </div>
                            <div class="step-content" id="step-7" data-content="7">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="kardesSayisi" class="form-label">Kardeş Sayısı (Siz Dahil)</label>
                                        <input type="text" class="form-control" id="kardesSayisi"
                                               placeholder="Kardeş bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="okuyanKardesSayisi" class="form-label">Okuyan Kardeş Sayısı (Siz
                                            Dahil)</label>
                                        <input type="text" class="form-control" id="okuyanKardesSayisi"
                                               placeholder="Okuyan kardeş bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button id="addButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                            data-bs-target="#kardesEkleModal"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M9.16797 9.1665V4.1665H10.8346V9.1665H15.8346V10.8332H10.8346V15.8332H9.16797V10.8332H4.16797V9.1665H9.16797Z" fill="#4069E5"/>
                                        </svg> Kardeş Ekle</button>
                                </div>

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
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
                                    </tbody>
                                </table>
                            </div>
                            <div class="step-content" id="step-8" data-content="8">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="mainIncomeProvider">Ailenizin Geçimini Kim/Kimler Sağlıyor</label>
                                        <input type="text" class="form-control" id="mainIncomeProvider"
                                               placeholder="Kişi bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="totalDependents">Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye
                                            Bakıyor?</label>
                                        <input type="text" class="form-control" id="totalDependents"
                                               placeholder="Kişi bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fatherIncome">Babanın Aylık Net Geliri (TL)</label>
                                        <input type="text" class="form-control" id="fatherIncome"
                                               placeholder="Gelir bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="motherIncome">Annenin Aylık Net Geliri (TL)</label>
                                        <input type="text" class="form-control" id="motherIncome"
                                               placeholder="Gelir bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="otherIncome">Diğer kişilerin Aylık Net Geliri (TL)</label>
                                        <input type="text" class="form-control" id="otherIncome"
                                               placeholder="Kişi bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="additionalIncome">Ailenin Başka Geliri Var mı? (Kira vb.)</label>
                                        <input type="text" class="form-control" id="additionalIncome"
                                               placeholder="Gelir bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="housingType">Ailenin yaşamakta olduğu ev türü?</label>
                                        <select id="housingType" class="form-select">
                                            <option value="">Seçiniz...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="rentAmount">Kira ise* Aylık Net Kirası (TL)</label>
                                        <input type="text" class="form-control" id="rentAmount"
                                               placeholder="Kişi bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="additionalInfo">Diğer İse* Açıklama</label>
                                        <input type="text" class="form-control" id="additionalInfo"
                                               placeholder="Açıklama giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="loanInfo">Kredi borcu ödüyor musunuz? Ödüyorsanız tutarı ile
                                            birlikte yazınız</label>
                                        <input type="text" class="form-control" id="loanInfo"
                                               placeholder="Açıklama giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="employmentInfo">Herhangi bir işte çalışıyor musunuz? Evet ise
                                            çalışma şekliniz ve aylık geliriniz belirtiniz</label>
                                        <input type="text" class="form-control" id="employmentInfo"
                                               placeholder="Açıklama giriniz...">
                                    </div>
                                </div>

                            </div>
                            <div class="step-content" id="step-9" data-content="9">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="devletBursu" class="form-label">Devlet Bursu Almakta mı ya da
                                            Başvurdu
                                            mu?</label>
                                        <input type="text" class="form-control" id="devletBursu"
                                               placeholder="Kişi bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="ozelBurs" class="form-label">Özel Burs Almakta mı ya da Başvurdu
                                            mu?</label>
                                        <input type="text" class="form-control" id="ozelBurs"
                                               placeholder="Kişi bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button id="addButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                            data-bs-target="#bursEkleModal"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M9.16797 9.1665V4.1665H10.8346V9.1665H15.8346V10.8332H10.8346V15.8332H9.16797V10.8332H4.16797V9.1665H9.16797Z" fill="#4069E5"/>
                                        </svg> Burs Ekle</button>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Burs</th>
                                        <th>Kurum Türü</th>
                                        <th>Kurum Adı</th>
                                        <th> Burs Tutarı</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4">Toplam</td>
                                        <td>0</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="step-content" id="step-10" data-content="10">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="engelDurumu" class="form-label">Herhangi bir engel durumunuz var
                                            mı?</label>
                                        <select class="form-select" id="engelDurumu" required>
                                            <option selected disabled>Seçiniz...</option>
                                            <option value="Evet">Evet</option>
                                            <option value="Hayır">Hayır</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="engelAciklama" class="form-label">Engel durumunu açıklayınız
                                            (varsa)</label>
                                        <input type="text" class="form-control" id="engelAciklama"
                                               placeholder="Açıklama giriniz...">
                                    </div>
                                </div>
                            </div>
                            <div class="step-content" id="step-11" data-content="11">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="haberKaynak" class="form-label">Bizden Nasıl Haberdar
                                            Oldunuz?</label>
                                        <input type="text" class="form-control" id="haberKaynak"
                                               placeholder="Açıklama giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="gucluYanlar" class="form-label">Güçlü Yanlarınızın Neler Olduğunu
                                            Düşünüyorsunuz?</label>
                                        <input type="text" class="form-control" id="gucluYanlar"
                                               placeholder="Güçlü yan giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sosyalProjeler" class="form-label">Katkıda Bulunduğunuz Sosyal
                                            Projeler</label>
                                        <input type="text" class="form-control" id="sosyalProjeler"
                                               placeholder="Proje bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="hobiler" class="form-label">Hobileriniz</label>
                                        <input type="text" class="form-control" id="hobiler"
                                               placeholder="Hobi bilgisi giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sporDali" class="form-label">İlgilendiğiniz Spor Dalı
                                            (Varsa)</label>
                                        <input type="text" class="form-control" id="sporDali"
                                               placeholder="Spor dalı bilgisi giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kitaplar" class="form-label">Son Okuduğunuz Kitaplar</label>
                                        <input type="text" class="form-control" id="kitaplar"
                                               placeholder="Kitap adı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="mesaj" class="form-label">Bize Mesajınız</label>
                                        <textarea class="form-control" id="mesaj" rows="3"
                                                  placeholder="Mesajınızı giriniz..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="step-content" id="step-12" data-content="12">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="bankaAdi" class="form-label">Banka</label>
                                        <input type="text" class="form-control" id="bankaAdi"
                                               placeholder="Banka adı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="bankaKodu" class="form-label">Banka Kodu</label>
                                        <input type="text" class="form-control" id="bankaKodu"
                                               placeholder="Banka kodu giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="subeAdi" class="form-label">Şube</label>
                                        <input type="text" class="form-control" id="subeAdi"
                                               placeholder="Şube adı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="subeKodu" class="form-label">Şube Kodu</label>
                                        <input type="text" class="form-control" id="subeKodu"
                                               placeholder="Şube kodu giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="iban" class="form-label">IBAN</label>
                                        <input type="text" class="form-control" id="iban" placeholder="IBAN giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="hesapNumarasi" class="form-label">Hesap Numarası</label>
                                        <input type="text" class="form-control" id="hesapNumarasi"
                                               placeholder="Hesap numarası giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <p class="text-muted">! Banka hesabı öğrenci adına açılmış olmalıdır.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="step-content" id="step-13" data-content="13">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="employment-status">Düzenli olarak bir kurumda kazanç sağlıyor
                                                    mu?</label>
                                                <select id="is_working" class="form-select">
                                                <option value="" disabled selected>Seçiniz...</option>
                                                <option value="Full-time">Full-time</option>
                                                <option value="Part-time">Part-time</option>
                                                <option value="Stajyer">Stajyer</option>
                                                <option value="Hayır">Hayır</option>
                                                <option value="Diğer">Diğer</option>
                                            </select>
                                        </div>
                                        <div id="employment-details" class="hidden">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="kurumAdi" class="form-label">Kurum Adı</label>
                                                    <input type="text" class="form-control" id="kurumAdi"
                                                           placeholder="Kurum adı giriniz...">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="gorev" class="form-label">Görev</label>
                                                    <input type="text" class="form-control" id="gorev"
                                                           placeholder="Görev giriniz...">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="social-security">Sosyal Güvenlik Kurumu</label>
                                                    <select id="social-security" class="form-select">
                                                        <option value="" selected>Seçiniz...</option>
                                                        <option value="SGK">SGK</option>
                                                        <option value="ssk">SGK</option>
                                                        <option value="bagkur">BAĞ-KUR</option>
                                                        <option value="none">Yok</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="aylikKazanc" class="form-label">Aylık Net Kazanç (TL)</label>
                                                    <input type="text" class="form-control" id="aylikKazanc"
                                                           placeholder="Görev giriniz...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-content" id="step-14" data-content="14">
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"/>
                                                    </svg> Öğrenci Belgesi
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"/>
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area-upload">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <div class="file-preview d-flex justify-content-between">
                                                        <div class="icon-container ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                                <path d="M3.16602 0.666748C2.50297 0.666748 1.86709 0.93014 1.39825 1.39898C0.929408 1.86782 0.666016 2.50371 0.666016 3.16675V5.66675C0.666016 6.12698 1.03911 6.50008 1.49935 6.50008C1.95959 6.50008 2.33268 6.12698 2.33268 5.66675V3.16675C2.33268 2.94573 2.42048 2.73377 2.57676 2.57749C2.73304 2.42121 2.945 2.33341 3.16602 2.33341H5.66601C6.12625 2.33341 6.49935 1.96032 6.49935 1.50008C6.49935 1.03984 6.12625 0.666748 5.66601 0.666748H3.16602Z" fill="#2D3648"/>
                                                                <path d="M12.3327 0.666748C11.8724 0.666748 11.4993 1.03984 11.4993 1.50008C11.4993 1.96032 11.8724 2.33341 12.3327 2.33341H14.8327C15.0537 2.33341 15.2657 2.42121 15.4219 2.57749C15.5782 2.73377 15.666 2.94573 15.666 3.16675V5.66675C15.666 6.12698 16.0391 6.50008 16.4993 6.50008C16.9596 6.50008 17.3327 6.12698 17.3327 5.66675V3.16675C17.3327 2.50371 17.0693 1.86782 16.6004 1.39898C16.1316 0.93014 15.4957 0.666748 14.8327 0.666748H12.3327Z" fill="#2D3648"/>
                                                                <path d="M2.33268 12.3334C2.33268 11.8732 1.95959 11.5001 1.49935 11.5001C1.03911 11.5001 0.666016 11.8732 0.666016 12.3334V14.8334C0.666016 15.4965 0.929408 16.1323 1.39825 16.6012C1.86709 17.07 2.50297 17.3334 3.16602 17.3334H5.66601C6.12625 17.3334 6.49935 16.9603 6.49935 16.5001C6.49935 16.0398 6.12625 15.6667 5.66601 15.6667H3.16602C2.945 15.6667 2.73304 15.5789 2.57676 15.4227C2.42048 15.2664 2.33268 15.0544 2.33268 14.8334V12.3334Z" fill="#2D3648"/>
                                                                <path d="M17.3327 12.3334C17.3327 11.8732 16.9596 11.5001 16.4993 11.5001C16.0391 11.5001 15.666 11.8732 15.666 12.3334V14.8334C15.666 15.0544 15.5782 15.2664 15.4219 15.4227C15.2657 15.5789 15.0537 15.6667 14.8327 15.6667H12.3327C11.8724 15.6667 11.4993 16.0398 11.4993 16.5001C11.4993 16.9603 11.8724 17.3334 12.3327 17.3334H14.8327C15.4957 17.3334 16.1316 17.07 16.6004 16.6012C17.0693 16.1323 17.3327 15.4965 17.3327 14.8334V12.3334Z" fill="#2D3648"/>
                                                            </svg>
                                                            <svg class="confirm-icon-sm" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                                                <rect width="12" height="12" rx="6" fill="#00875A"/>
                                                                <path d="M4.56484 5.90345C4.2359 5.57452 3.70259 5.57452 3.37365 5.90345C3.04472 6.23239 3.04472 6.7657 3.37365 7.09463L5.05824 8.77922C5.38717 9.10815 5.92048 9.10815 6.24942 8.77922L9.61858 5.41005C9.94752 5.08111 9.94752 4.5478 9.61858 4.21887C9.28965 3.88993 8.75634 3.88993 8.4274 4.21887L5.65383 6.99245L4.56484 5.90345Z" fill="white"/>
                                                            </svg>
                                                        </div>
                                                        <span class="file-name">ogrencibel.pdf</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z" fill="#F03000"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Adli Sicil Kaydı
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Vukuatlı Nüfus Kayıt Örneği
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Anne Gelir Belgesi
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Baba Gelir Belgesi
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Aydınlatma Metni /
                                                    Açık Rıza Formu ve
                                                    Taahhütname
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Kimlik Belgesi (Ön-Arka)
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Banka Hesap Bilgisi
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Fotoğraf
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Transkript
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Aile İkamet Adresi
                                                    ve Diğer Adres Belgesi
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Karne
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-card">
                                            <div class="documents-title-drag-drop">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                            fill="#1A1A1A" />
                                                    </svg> Diğer
                                                </p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A" />
                                                </svg>
                                            </div>
                                            <div class="file-drag-drop-area">
                                                <input type="file" id="file-upload" hidden>
                                                <label for="file-upload" class="file-label d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                                    </svg>
                                                    <div class="text-container">
                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="file-info mt-2">
                                                <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                                <p>Max Size: 25 MB, 1 Dosya</p>
                                            </div>
                                            <div class="delete-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path
                                                        d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z"
                                                        fill="#F03000" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        <!-- Kayıt Yenileme Başarılı Modalı -->
        <div class="modal fade" id="scholarshipCompletionModal" tabindex="-1"
             aria-labelledby="scholarshipCompletionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M3.16602 0.666748C2.50297 0.666748 1.86709 0.93014 1.39825 1.39898C0.929408 1.86782 0.666016 2.50371 0.666016 3.16675V5.66675C0.666016 6.12698 1.03911 6.50008 1.49935 6.50008C1.95959 6.50008 2.33268 6.12698 2.33268 5.66675V3.16675C2.33268 2.94573 2.42048 2.73377 2.57676 2.57749C2.73304 2.42121 2.945 2.33341 3.16602 2.33341H5.66601C6.12625 2.33341 6.49935 1.96032 6.49935 1.50008C6.49935 1.03984 6.12625 0.666748 5.66601 0.666748H3.16602Z" fill="#2D3648"/>
                                <path d="M12.3327 0.666748C11.8724 0.666748 11.4993 1.03984 11.4993 1.50008C11.4993 1.96032 11.8724 2.33341 12.3327 2.33341H14.8327C15.0537 2.33341 15.2657 2.42121 15.4219 2.57749C15.5782 2.73377 15.666 2.94573 15.666 3.16675V5.66675C15.666 6.12698 16.0391 6.50008 16.4993 6.50008C16.9596 6.50008 17.3327 6.12698 17.3327 5.66675V3.16675C17.3327 2.50371 17.0693 1.86782 16.6004 1.39898C16.1316 0.93014 15.4957 0.666748 14.8327 0.666748H12.3327Z" fill="#2D3648"/>
                                <path d="M2.33268 12.3334C2.33268 11.8732 1.95959 11.5001 1.49935 11.5001C1.03911 11.5001 0.666016 11.8732 0.666016 12.3334V14.8334C0.666016 15.4965 0.929408 16.1323 1.39825 16.6012C1.86709 17.07 2.50297 17.3334 3.16602 17.3334H5.66601C6.12625 17.3334 6.49935 16.9603 6.49935 16.5001C6.49935 16.0398 6.12625 15.6667 5.66601 15.6667H3.16602C2.945 15.6667 2.73304 15.5789 2.57676 15.4227C2.42048 15.2664 2.33268 15.0544 2.33268 14.8334V12.3334Z" fill="#2D3648"/>
                                <path d="M17.3327 12.3334C17.3327 11.8732 16.9596 11.5001 16.4993 11.5001C16.0391 11.5001 15.666 11.8732 15.666 12.3334V14.8334C15.666 15.0544 15.5782 15.2664 15.4219 15.4227C15.2657 15.5789 15.0537 15.6667 14.8327 15.6667H12.3327C11.8724 15.6667 11.4993 16.0398 11.4993 16.5001C11.4993 16.9603 11.8724 17.3334 12.3327 17.3334H14.8327C15.4957 17.3334 16.1316 17.07 16.6004 16.6012C17.0693 16.1323 17.3327 15.4965 17.3327 14.8334V12.3334Z" fill="#2D3648"/>
                            </svg>
                            <svg class="confirm-icon" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                <rect width="12" height="12" rx="6" fill="#00875A"/>
                                <path d="M4.56484 5.90345C4.2359 5.57452 3.70259 5.57452 3.37365 5.90345C3.04472 6.23239 3.04472 6.7657 3.37365 7.09463L5.05824 8.77922C5.38717 9.10815 5.92048 9.10815 6.24942 8.77922L9.61858 5.41005C9.94752 5.08111 9.94752 4.5478 9.61858 4.21887C9.28965 3.88993 8.75634 3.88993 8.4274 4.21887L5.65383 6.99245L4.56484 5.90345Z" fill="white"/>
                            </svg>
                        </div>
                        <h5 class="mt-3">Kayıt yenilemeyi başarıyla tamamladınız.</h5>
                        <p>Süreçle ilgili SMS ve E-posta yolu ile bilgilendirileceksiniz.</p>
                        <button type="button" id="modalCloseButton" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kardeş Ekle Modal -->
        <div class="modal fade" id="kardesEkleModal" tabindex="-1" aria-labelledby="kardesEkleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <h5 class="modal-title mb-3" id="kardesEkleModalLabel">Kardeş Ekle</h5>
                            <p>Kardeş bilgilerini giriniz.</p>
                            <span>Ekle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
                        </div>
                        <form id="addSiblingForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesAdi" class="form-label">Adı</label>
                                    <input type="text" class="form-control" id="kardesAdi" placeholder="Ad giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesSoyadi" class="form-label">Soyadı</label>
                                    <input type="text" class="form-control" id="kardesSoyadi"
                                           placeholder="Soyad giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesYasi" class="form-label">Yaşı</label>
                                    <input type="text" class="form-control" id="kardesYasi" placeholder="Yaş giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                                    <select class="form-select" id="kardesOgrenimDurumu" required>
                                        <option  selected disabled>Seçiniz...</option>
                                        <option>Ortaokul</option>
                                        <option >Lise</option>
                                        <option>Lisans</option>
                                        <option>Yüksek Lisans</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu class="form-label">Medeni Durum</label>
                                    <select class="form-select" id="kardesMedeniDurumu" required>
                                        <option selected disabled>Seçiniz...</option>
                                        <option>Bekar</option>
                                        <option >Evli</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="kardesMeslegi"
                                           placeholder="Meslek giriniz...">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Ekle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kardeş Düzenle Modal -->
        <div class="modal fade" id="kardesDuzenleModal" tabindex="-1" aria-labelledby="kardesDuzenleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="text-center">
                        <h5 class="modal-title mb-3" id="kardesDuzenleModalLabel">Kardeş Düzenle</h5>
                        <p>Kardeş bilgilerini giriniz.</p>
                        <span>Güncelle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
                    </div>
                    <div class="modal-body">
                        <form id="editSiblingForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesAdi" class="form-label">Adı</label>
                                    <input type="text" class="form-control" id="kardesAdi" placeholder="Ad giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesSoyadi" class="form-label">Soyadı</label>
                                    <input type="text" class="form-control" id="kardesSoyadi"
                                           placeholder="Soyad giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesYasi" class="form-label">Yaşı</label>
                                    <input type="text" class="form-control" id="kardesYasi" placeholder="Yaş giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                                    <select class="form-select" id="kardesOgrenimDurumu" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Ortaokul</option>
                                        <option >Lise</option>
                                        <option selected>Lisans</option>
                                        <option>Yüksek Lisans</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu class="form-label">Medeni Durum</label>
                                    <select class="form-select" id="kardesMedeniDurumu" required>
                                        <option disabled>Seçiniz...</option>
                                        <option>Bekar</option>
                                        <option selected >Evli</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="kardesMeslegi"
                                           placeholder="Meslek giriniz...">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Burs Ekle Modal -->
        <div class="modal fade" id="bursEkleModal" tabindex="-1" aria-labelledby="bursEkleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="text-center">
                        <h5 class="modal-title mb-3" id="bursEkleModalLabel">Burs Ekle</h5>
                        <p>Burs bilgilerini giriniz.</p>
                        <span>Ekle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
                    </div>
                    <div class="modal-body">
                        <form id="addBursForm">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="kurumAdi" class="form-label">Kurum Adı</label>
                                    <input type="text" class="form-control" id="kurumAdi"
                                           placeholder="Kurum adı giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kurumTuru" class="form-label">Kurum Türü</label>
                                    <select class="form-select" id="kurumTuru" required>
                                        <option selected disabled>Seçiniz...</option>
                                        <option>Devlet</option>
                                        <option>Özel</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                                    <input type="text" class="form-control" id="bursMıktarı" placeholder="1000">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Ekle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Burs Düzenle Modal -->
        <div class="modal fade" id="bursDuzenleModal" tabindex="-1" aria-labelledby="bursDuzenleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="text-center">
                        <h5 class="modal-title mb-3" id="bursEkleModalLabel">Burs Düzenle</h5>
                        <p>Burs bilgilerini giriniz.</p>
                        <span>Güncelle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
                    </div>
                    <div class="modal-body">
                        <form id="editBursForm">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="kurumAdi" class="form-label">Kurum Adı</label>
                                    <input type="text" class="form-control" id="kurumAdi" placeholder="GSB">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kurumTuru" class="form-label">Kurum Türü</label>
                                    <select class="form-select" id="kurumTuru" required>
                                        <option disabled>Seçiniz...</option>
                                        <option selected>Devlet</option>
                                        <option>Özel</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                                    <input type="text" class="form-control" id="bursMıktarı" placeholder="1000">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--KVKK Modal -->
        <div class="modal fade" id="kvkkModal" tabindex="-1" role="dialog" aria-labelledby="kvkkModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-center">
                        <h5 class="modal-title" id="kvkkModalLabel">KVKK Kuralları</h5>
                    </div>
                    <div class="modal-body">
                        ÇEREZLERE DAİR AYDINLATMA METNİ
                        Bu metin, 6698 sayılı Kişisel Verilerin Korunması Kanunu’nun (Kanun) 10’uncu maddesi ile
                        Aydınlatma Yükümlülüğünün Yerine Getirilmesinde Uyulacak Usul ve Esaslar Hakkında
                        Tebliğ kapsamında veri sorumlusu sıfatıyla Kişisel Verileri Koruma Kurumu tarafından
                        (Nasuh Akar Mahallesi 1407. Sok. No:4, 06520 Çankaya/Ankara) tarafından hazırlanmıştır.
                        Bu Çerez Aydınlatma Metni’nin amacı, internet sitemizde kullanılan çerezlerin cihazınıza
                        yerleştirilmesi aracılığıyla otomatik yolla elde edilen kişisel verilerin işlenmesine ilişkin
                        olarak, hangi amaçlarla hangi tür çerezleri kullandığımız, hukuki sebebi ve haklarınız
                        hakkında sizlere bilgi vermektir.
                        İnternet sitemizde yalnızca hizmetin sağlanması için kesinlikle gerekli olarak birinci taraf
                        oturum ve kalıcı çerezler kullanılmaktadır.
                        Çerez Çeşitleri
                        Kullanım süresine göre çerez çeşitleri: Oturum çerezi, oturumun sürekliliğinin sağlanması

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>

 @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="{{url('public')}}/assets/js/components/dashboard-student.js"></script>
        <script src="{{url('public')}}/assets/js/components/student-button.js"></script>


@endsection
