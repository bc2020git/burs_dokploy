@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yönetici Paneli
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
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
                            <input type="text" class="form-control" id="bursiyerSoyadi" value="Soyad" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
                            <input type="text" class="form-control" id="bursiyerTcNo" value="12345678989" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bursiyerPosta" class="form-label">E-posta</label>
                            <input type="email" class="form-control" id="bursiyerPosta" placeholder="ahsen@ahsen.com">
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
                        <label class="form-check-label" for="confirmation1">
                            Vermiş olduğum cevapların doğru olduğunu kabul ve taahhüt ederim.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirmation2">
                        <label class="form-check-label" for="confirmation2">
                            KVKK Kurallarının gereksinimlerini kabul ederim.
                        </label>
                    </div>
                </div>
                <div class="step-content" id="step-2" data-content="2">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="dogumTarihi" class="form-label">Doğum Tarihi</label>
                            <input type="text" class="form-control" id="dogumTarihi" value="06.06.2000" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dogumSehri" class="form-label">Doğduğu Şehir</label>
                            <input type="text" class="form-control" id="dogumSehri" value="Amasya" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dogumIlce" class="form-label">Doğduğu İlçe</label>
                            <input type="text" class="form-control" id="dogumIlce" value="Taşova" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nufusIl" class="form-label">Nüfusa Kayıtlı Olduğu İl</label>
                            <select class="form-select" id="nufusIl" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nufusIlce" class="form-label">Nüfusa Kayıtlı Olduğu İlçe</label>
                            <select class="form-select" id="nufusIlce" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cinsiyet" class="form-label">Cinsiyet</label>
                            <select class="form-select" id="cinsiyet" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="medeniHal" class="form-label">Medeni Durum</label>
                            <select class="form-select" id="medeniHal" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="uyruk" class="form-label">Uyruk</label>
                            <input type="text" class="form-control" id="uyruk" value="Türk" readonly>
                        </div>
                    </div>
                </div>
                <div class="step-content" id="step-3" data-content="3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="okulTipi" class="form-label">Okul Tipi</label>
                            <input type="text" class="form-control" id="okulTipi" value="İlkokul" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="okulAd" class="form-label">Okul Adı </label>
                            <input type="text" class="form-control" id="okulAd" placeholder="Alpaslan İlkokulu">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="okulIl" class="form-label">Okulun Bulunduğu Şehir</label>
                            <select class="form-select" id="okulIl" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sinif" class="form-label">Sınıfınız </label>
                            <input type="text" class="form-control" id="sinif" placeholder="8-A">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ogrenciNo" class="form-label">Öğrenci Numarası</label>
                            <input type="text" class="form-control" id="ogrenciNo" placeholder="23454511">
                        </div>
                        <div class="col-md-6">
                            <label for="notOrtalamasi" class="form-label">Not Ortalaması</label>
                            <input type="text" class="form-control" id="notOrtalamasi" placeholder="89.7">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nakilMi" class="form-label">Nakil Yaptı Mı?</label>
                            <select class="form-select" id="nakilMi" required>
                                <option disabled>Seçiniz...</option>
                                <option selected>Hayır</option>
                                <option>Evet</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="step-content" id="step-4" data-content="4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="barinmaTuru" class="form-label">Barınma Türü</label>
                            <select class="form-select" id="barinmaTuru" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="odenenUcret" class="form-label">Ödenen Ücret</label>
                            <input type="text" class="form-control" id="odenenUcret"
                                   placeholder="Ödenen ücret bilgisi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kisiSayisi" class="form-label">Birlikte Yaşanılan Kişi Sayısı</label>
                            <input type="text" class="form-control" id="kisiSayisi"
                                   placeholder="Kişi sayısı giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kaldiğiIl" class="form-label">Kaldığı İl</label>
                            <select class="form-select" id="kaldigiIl" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kaldigiIlce" class="form-label">Kaldığı İlçe</label>
                            <select class="form-select" id="kaldigiIlce" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="acikAdres" class="form-label">Açık Adres</label>
                            <input type="text" class="form-control" id="acikAdres"
                                   placeholder="Adres bilgisi giriniz...">
                        </div>
                    </div>
                </div>
                <div class="step-content" id="step-5" data-content="5">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="anneninIl" class="form-label">Annenin Yaşadığı İl</label>
                            <select class="form-select" id="anneninIl" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="babaninIl" class="form-label">Babanın Yaşadığı İl</label>
                            <select class="form-select" id="babaninIl" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="anneninIlce" class="form-label">Annenin Yaşadığı İlçe</label>
                            <select class="form-select" id="anneninIlce" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="babaninIlce" class="form-label">Babanın Yaşadığı İlçe</label>
                            <select class="form-select" id="babaninIlce" required>
                                <option selected disabled>Seçiniz...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="acikAdres" class="form-label">Açık Adres</label>
                            <input type="text" class="form-control" id="acikAdres"
                                   placeholder="Adres bilgisi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="evTelefonu" class="form-label">Ailenin Ev Telefonu</label>
                            <input type="text" class="form-control" id="evTelefonu"
                                   placeholder="Telefon numarası giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cepTelefonu" class="form-label">Ailenin Cep Telefonu</label>
                            <input type="text" class="form-control" id="cepTelefonu"
                                   placeholder="Telefon numarası giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Ailenin E-posta Adresi</label>
                            <input type="email" class="form-control" id="email" placeholder="E-posta adresi giriniz...">
                        </div>
                    </div>
                    <div class="urgent">
                        <div class="row">
                            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
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
                                    <label for="yakınlıkDerecesi" class="form-label">Yakınlık Derecesi</label>
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
                            <input type="text" class="form-control" id="babaAdSoyad" placeholder="Ad soyad giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="anneAdSoyad" class="form-label">Anne Ad Soyad</label>
                            <input type="text" class="form-control" id="anneAdSoyad" placeholder="Ad soyad giriniz...">
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
                            <label for="babaninTahsilDurumu" class="form-label">Babanın Tahsil Durumu</label>
                            <input type="text" class="form-control" id="babaninTahsilDurumu"
                                   placeholder="Tahsil durumu giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="anneninTahsilDurumu" class="form-label">Annenin Tahsil Durumu</label>
                            <input type="text" class="form-control" id="anneninTahsilDurumu"
                                   placeholder="Tahsil durumu giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="babaninSosyalGuvenlik" class="form-label">Babanın Bağlı Olduğu Sosyal Güvenlik
                                Kurumu</label>
                            <input type="text" class="form-control" id="babaninSosyalGuvenlik"
                                   placeholder="Kurum bilgisi giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="anneninSosyalGuvenlik" class="form-label">Annenin Bağlı Olduğu Sosyal Güvenlik
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
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#kardesEkleModal"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                   height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M9.16797 9.16663V4.16663H10.8346V9.16663H15.8346V10.8333H10.8346V15.8333H9.16797V10.8333H4.16797V9.16663H9.16797Z"
                                fill="#FFF" />
                        </svg> Kardeş Ekle</button>

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
                        <tr>
                            <td>1</td>
                            <td>Canan</td>
                            <td>Tan</td>
                            <td>11</td>
                            <td>Hazırlık Sınıfı</td>
                            <td>Bekar</td>
                            <td>Tamirci</td>
                            <td>
                                <button class="btn edit-member-info-btn" type="button"
                                        class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#kardesDuzenleModal"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z"
                                            fill="black" />
                                    </svg></button>
                                <button class="btn" type="button" class="btn btn-primary mb-3"
                                        data-bs-toggle="modal" data-bs-target="#kardesSilModal"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM9 11V17H11V11H9ZM13 11V17H15V11H13ZM9 4V6H15V4H9Z"
                                            fill="black" />
                                    </svg></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="step-content" id="step-8" data-content="8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gecimiSaglayanKisiler" class="form-label">Ailenin Geçimini Kim/Kimler
                                sağlıyor?</label>
                            <input type="text" class="form-control" id="gecimiSaglayanKisiler"
                                   placeholder="Kişi bilgisi giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="saglayanKisilerToplam" class="form-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç
                                Kişiye Bakıyor?</label>
                            <input type="text" class="form-control" id="saglayanKisilerToplam"
                                   placeholder="Kişi bilgisi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="babaninGeliri" class="form-label">Babanın Aylık Net Geliri (TL)</label>
                            <input type="text" class="form-control" id="babaninGeliri"
                                   placeholder="Gelir bilgisi giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="anneninGeliri" class="form-label">Annenin Aylık Net Geliri (TL)</label>
                            <input type="text" class="form-control" id="anneninGeliri"
                                   placeholder="Gelir bilgisi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="digerKisilerinGeliri" class="form-label">Diğer kişilerin Aylık Net Geliri
                                (TL)</label>
                            <input type="text" class="form-control" id="digerKisilerinGeliri"
                                   placeholder="Kişi bilgisi giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="baskaGelir" class="form-label">Ailenin Başka Geliri Var mı? (Kira vb.)</label>
                            <input type="text" class="form-control" id="baskaGelir"
                                   placeholder="Gelir bilgisi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="evTuru" class="form-label">Ailenin yaşamakta olduğu ev türü?</label>
                            <select class="form-select" id="evTuru" required>
                                <option selected disabled>Seçiniz...</option>
                                <option value="Kendi Evi">Kendi Evi</option>
                                <option value="Kiralık">Kiralık</option>
                                <option value="Misafir">Misafir</option>
                                <option value="Diğer">Diğer</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kira" class="form-label">Kira ise* Aylık Net Kirası (TL)</label>
                            <input type="text" class="form-control" id="kira" placeholder="Kişi bilgisi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="digerAciklama" class="form-label">Diğer ise* Açıklama</label>
                            <input type="text" class="form-control" id="digerAciklama"
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
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#bursEkleModal"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M9.16797 9.16663V4.16663H10.8346V9.16663H15.8346V10.8333H10.8346V15.8333H9.16797V10.8333H4.16797V9.16663H9.16797Z"
                                fill="#FFF" />
                        </svg> Burs Ekle</button>

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
                        <tr>
                            <td>1</td>
                            <td>Devlet</td>
                            <td>GSB</td>
                            <td>1000</td>
                            <td>
                                <button class="btn edit-member-info-btn" type="button"
                                        class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#bursDuzenleModal"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z"
                                            fill="black" />
                                    </svg></button>
                                <button class="btn" type="button" class="btn btn-primary mb-3"
                                        data-bs-toggle="modal" data-bs-target="#kardesSilModal"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM9 11V17H11V11H9ZM13 11V17H15V11H13ZM9 4V6H15V4H9Z"
                                            fill="black" />
                                    </svg></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="step-content" id="step-10" data-content="10">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="engelDurumu" class="form-label">Herhangi bir engel durumunuz var mı?</label>
                            <select class="form-select" id="engelDurumu" required>
                                <option selected disabled>Seçiniz...</option>
                                <option value="Evet">Evet</option>
                                <option value="Hayır">Hayır</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="engelAciklama" class="form-label">Engel durumunu açıklayınız (varsa)</label>
                            <input type="text" class="form-control" id="engelAciklama"
                                   placeholder="Açıklama giriniz...">
                        </div>
                    </div>
                </div>
                <div class="step-content" id="step-11" data-content="11">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="haberKaynak" class="form-label">Bizden Nasıl Haberdar Oldunuz?</label>
                            <input type="text" class="form-control" id="haberKaynak" placeholder="Açıklama giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gucluYanlar" class="form-label">Güçlü Yanlarınızın Neler Olduğunu
                                Düşünüyorsunuz?</label>
                            <input type="text" class="form-control" id="gucluYanlar" placeholder="Güçlü yan giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sosyalProjeler" class="form-label">Katkıda Bulunduğunuz Sosyal Projeler</label>
                            <input type="text" class="form-control" id="sosyalProjeler"
                                   placeholder="Proje bilgisi giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hobiler" class="form-label">Hobileriniz</label>
                            <input type="text" class="form-control" id="hobiler" placeholder="Hobi bilgisi giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sporDali" class="form-label">İlgilendiğiniz Spor Dalı (Varsa)</label>
                            <input type="text" class="form-control" id="sporDali"
                                   placeholder="Spor dalı bilgisi giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kitaplar" class="form-label">Son Okuduğunuz Kitaplar</label>
                            <input type="text" class="form-control" id="kitaplar" placeholder="Kitap adı giriniz...">
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
                            <input type="text" class="form-control" id="bankaAdi" placeholder="Banka adı giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bankaKodu" class="form-label">Banka Kodu</label>
                            <input type="text" class="form-control" id="bankaKodu" placeholder="Banka kodu giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="subeAdi" class="form-label">Şube</label>
                            <input type="text" class="form-control" id="subeAdi" placeholder="Şube adı giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="subeKodu" class="form-label">Şube Kodu</label>
                            <input type="text" class="form-control" id="subeKodu" placeholder="Şube kodu giriniz...">
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
                                <select id="employment-status" class="form-select">
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
                                            <option value="sgk">SGK</option>
                                            <option value="ssk">SGK</option>
                                            <option value="bagkur">BAĞ-KUR</option>
                                            <option value="none">Yok</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="aylikKazanc" class="form-label">Aylık Net Kazanç
                                            (TL)</label>
                                        <input type="text" class="form-control" id="aylikKazanc"
                                               placeholder="Görev giriniz...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="step-content" id="step-14" data-content="14">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="upload-card">
                                <div class="documents-title-drag-drop">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                fill="#1A1A1A" />
                                        </svg> Öğrenci Belgesi
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </div>
                                <div class="file-drag-drop-area">
                                    <input type="file" id="file-upload" hidden>
                                    <label for="file-upload" class="file-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"
                                                fill="#0065FF" />
                                        </svg>
                                        <span>Sürükle ve Bırak veya Dosya Seç</span>
                                    </label>
                                </div>
                                <div class="file-info mt-2">
                                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                    <p>Max Size: 25 MB, 1 Dosya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="upload-card">
                                <div class="documents-title-drag-drop">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                fill="#1A1A1A" />
                                        </svg> Adli Sicil Kaydı
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </div>
                                <div class="file-drag-drop-area">
                                    <input type="file" id="file-upload" hidden>
                                    <label for="file-upload" class="file-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"
                                                fill="#0065FF" />
                                        </svg>
                                        <span>Sürükle ve Bırak veya Dosya Seç</span>
                                    </label>
                                </div>
                                <div class="file-info mt-2">
                                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                    <p>Max Size: 25 MB, 1 Dosya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="upload-card">
                                <div class="documents-title-drag-drop">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                fill="#1A1A1A" />
                                        </svg> Vukuatlı Nufüs Kayıt Örneği
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </div>
                                <div class="file-drag-drop-area">
                                    <input type="file" id="file-upload" hidden>
                                    <label for="file-upload" class="file-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"
                                                fill="#0065FF" />
                                        </svg>
                                        <span>Sürükle ve Bırak veya Dosya Seç</span>
                                    </label>
                                </div>
                                <div class="file-info mt-2">
                                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                    <p>Max Size: 25 MB, 1 Dosya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="upload-card">
                                <div class="documents-title-drag-drop">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                fill="#1A1A1A" />
                                        </svg> Anne Gelir Belgesi
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </div>
                                <div class="file-drag-drop-area">
                                    <input type="file" id="file-upload" hidden>
                                    <label for="file-upload" class="file-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"
                                                fill="#0065FF" />
                                        </svg>
                                        <span>Sürükle ve Bırak veya Dosya Seç</span>
                                    </label>
                                </div>
                                <div class="file-info mt-2">
                                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                    <p>Max Size: 25 MB, 1 Dosya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="upload-card">
                                <div class="documents-title-drag-drop">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                fill="#1A1A1A" />
                                        </svg> Baba Gelir Belgesi
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </div>
                                <div class="file-drag-drop-area">
                                    <input type="file" id="file-upload" hidden>
                                    <label for="file-upload" class="file-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"
                                                fill="#0065FF" />
                                        </svg>
                                        <span>Sürükle ve Bırak veya Dosya Seç</span>
                                    </label>
                                </div>
                                <div class="file-info mt-2">
                                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                    <p>Max Size: 25 MB, 1 Dosya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="upload-card">
                                <div class="documents-title-drag-drop">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                fill="#1A1A1A" />
                                        </svg> Aile Mali Durum (Tapu, Araç vs.)
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </div>
                                <div class="file-drag-drop-area">
                                    <input type="file" id="file-upload" hidden>
                                    <label for="file-upload" class="file-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"
                                                fill="#0065FF" />
                                        </svg>
                                        <span>Sürükle ve Bırak veya Dosya Seç</span>
                                    </label>
                                </div>
                                <div class="file-info mt-2">
                                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                    <p>Max Size: 25 MB, 1 Dosya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="upload-card">
                                <div class="documents-title-drag-drop">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                fill="#1A1A1A" />
                                        </svg> Engelli Raporu (Varsa)
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </div>
                                <div class="file-drag-drop-area">
                                    <input type="file" id="file-upload" hidden>
                                    <label for="file-upload" class="file-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"
                                                fill="#0065FF" />
                                        </svg>
                                        <span>Sürükle ve Bırak veya Dosya Seç</span>
                                    </label>
                                </div>
                                <div class="file-info mt-2">
                                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                    <p>Max Size: 25 MB, 1 Dosya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="upload-card">
                                <div class="documents-title-drag-drop">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                fill="#1A1A1A" />
                                        </svg> Mektup
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </div>
                                <div class="file-drag-drop-area">
                                    <input type="file" id="file-upload" hidden>
                                    <label for="file-upload" class="file-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"
                                                fill="#0065FF" />
                                        </svg>
                                        <span>Sürükle ve Bırak veya Dosya Seç</span>
                                    </label>
                                </div>
                                <div class="file-info mt-2">
                                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                    <p>Max Size: 25 MB, 1 Dosya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="upload-card">
                                <div class="documents-title-drag-drop">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z"
                                                fill="#1A1A1A" />
                                        </svg> Kimlik Belgesi (Ön ve Arka)
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"
                                              fill="#1A1A1A" />
                                    </svg>
                                </div>
                                <div class="file-drag-drop-area">
                                    <input type="file" id="file-upload" hidden>
                                    <label for="file-upload" class="file-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z"
                                                fill="#0065FF" />
                                        </svg>
                                        <span>Sürükle ve Bırak veya Dosya Seç</span>
                                    </label>
                                </div>
                                <div class="file-info mt-2">
                                    <p>Desteklenen Belgeler: jpg, jpeg, png, PDF</p>
                                    <p>Max Size: 25 MB, 1 Dosya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="transfer-modal-footer d-flex justify-content-end g-3 ">
            <button type="button" class=" btn cancel-button" id="prevStep">Vazgeç</button>
            <button style="display: none;" type="button" class="btn  btn-outline-primary next-button"
                    id="prevButton">Önceki</button>
            <button type="button" class="btn btn-primary next-button" id="nextStep">Sonraki</button>
            <button style="display: none;" type="button" class="btn  btn-primary next-button"
                    id="completeButton">Tamamla</button>
        </div>
        <div class="modal fade" id="scholarshipCompletionModal" tabindex="-1" aria-labelledby="scholarshipCompletionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29" fill="none">
                            <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A" />
                            <rect x="1" y="1" width="28" height="27" rx="9" stroke="white" stroke-width="2" />
                            <path
                                d="M10.535 13.1693C9.7759 12.4356 8.54519 12.4356 7.78611 13.1693C7.02703 13.9031 7.02703 15.0928 7.78611 15.8266L11.6736 19.5845C12.4327 20.3183 13.6634 20.3183 14.4225 19.5845L22.1975 12.0687C22.9566 11.3349 22.9566 10.1452 22.1975 9.41142C21.4384 8.67764 20.2077 8.67764 19.4486 9.41142L13.048 15.5986L10.535 13.1693Z"
                                fill="white" />
                        </svg>
                        <h5 class="mt-3">Kayıt yenileme bilgileriniz başarıyla alındı!</h5>
                        <p>Süreçle ilgili SMS ve E-posta yolu ile bilgilendirileceksiniz.</p>
                        <button type="button" id="modalCloseButton" class="btn btn-primary"
                                data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kardeş Ekle Modal -->
        <div class="modal fade" id="kardesEkleModal" tabindex="-1" aria-labelledby="kardesEkleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kardesEkleModalLabel">Kardeş Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
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
                                    <input type="text" class="form-control" id="kardesOgrenimDurumu"
                                           placeholder="Öğrenim durumu giriniz...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu" class="form-label">Medeni Durumu</label>
                                    <input type="text" class="form-control" id="kardesMedeniDurumu"
                                           placeholder="Medeni durum giriniz...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="kardesMeslegi"
                                           placeholder="Meslek giriniz...">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Ekle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kardeş Düzenle Modal -->
        <div class="modal fade" id="kardesDuzenleModal" tabindex="-1" aria-labelledby="kardesDuzenleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kardesDuzenleModalLabel">Kardeş Bilgileri Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesAdi" class="form-label">Adı</label>
                                    <input type="text" class="form-control" id="kardesAdi" placeholder="Canan">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesSoyadi" class="form-label">Soyadı</label>
                                    <input type="text" class="form-control" id="kardesSoyadi" placeholder="Tan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesYasi" class="form-label">Yaşı</label>
                                    <input type="text" class="form-control" id="kardesYasi" placeholder="25">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                                    <input type="text" class="form-control" id="kardesOgrenimDurumu"
                                           placeholder="Üniversite">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMedeniDurumu" class="form-label">Medeni Durumu</label>
                                    <input type="text" class="form-control" id="kardesMedeniDurumu" placeholder="Bekar">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                                    <input type="text" class="form-control" id="kardesMeslegi" placeholder="Öğretmen">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Burs Ekle Modal -->
        <div class="modal fade" id="bursEkleModal" tabindex="-1" aria-labelledby="bursEkleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="burssEkleModalLabel">Burs Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
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
                            <button type="submit" class="btn btn-primary">Ekle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Burs Düzenle Modal -->
        <div class="modal fade" id="bursDuzenleModal" tabindex="-1" aria-labelledby="bursDuzenleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="burssDuzenleModalLabel">Burs Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
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
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
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


        <script src="{{url('public')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('public')}}/assets/js/components/modal.js"></script>
        <script src="{{url('public')}}/assets/js/registration.renewal.js"></script>
        <script src="{{url('public')}}/assets/js/manuel.js"></script>

            @include('includes.js.sidebar')
@endsection
