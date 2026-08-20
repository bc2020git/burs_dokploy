@extends('layouts.student.master-without-nav')
@section('title')
@endsection
@section('page-title')
@endsection
@section('body')

    @endsection
    @section('content')
        <div class="main main-expand">
            <nav class="navbar px-4 py-3">
                <form action="#" class="d-none d-sm-inline-block">
                    <div class="input-group input-group-navbar">
                        <span>Burs Başvurusu</span>
                    </div>
                </form>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <button class="btn border-2" data-bs-toggle="tooltip" data-bs-placement="left" title="Bildirimler">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M16.668 14.1667H18.3346V15.8334H1.66797V14.1667H3.33464V8.33335C3.33464 4.65145 6.3194 1.66669 10.0013 1.66669C13.6832 1.66669 16.668 4.65145 16.668 8.33335V14.1667ZM15.0013 14.1667V8.33335C15.0013 5.57193 12.7627 3.33335 10.0013 3.33335C7.23988 3.33335 5.0013 5.57193 5.0013 8.33335V14.1667H15.0013ZM7.5013 17.5H12.5013V19.1667H7.5013V17.5Z" fill="#1A1A1A"></path>
                            </svg>
                        </button>
                        <button class="btn border-2" data-bs-toggle="tooltip" data-bs-placement="left" title="Tercihler">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M5.14356 15C5.48675 14.029 6.41279 13.3334 7.5013 13.3334C8.5898 13.3334 9.51589 14.029 9.85905 15H18.3346V16.6667H9.85905C9.51589 17.6377 8.5898 18.3334 7.5013 18.3334C6.41279 18.3334 5.48675 17.6377 5.14356 16.6667H1.66797V15H5.14356ZM10.1436 9.16669C10.4867 8.1957 11.4128 7.50002 12.5013 7.50002C13.5898 7.50002 14.5159 8.1957 14.8591 9.16669H18.3346V10.8334H14.8591C14.5159 11.8044 13.5898 12.5 12.5013 12.5C11.4128 12.5 10.4867 11.8044 10.1436 10.8334H1.66797V9.16669H10.1436ZM5.14356 3.33335C5.48675 2.36236 6.41279 1.66669 7.5013 1.66669C8.5898 1.66669 9.51589 2.36236 9.85905 3.33335H18.3346V5.00002H9.85905C9.51589 5.97101 8.5898 6.66669 7.5013 6.66669C6.41279 6.66669 5.48675 5.97101 5.14356 5.00002H1.66797V3.33335H5.14356ZM7.5013 5.00002C7.96154 5.00002 8.33464 4.62692 8.33464 4.16669C8.33464 3.70645 7.96154 3.33335 7.5013 3.33335C7.04107 3.33335 6.66797 3.70645 6.66797 4.16669C6.66797 4.62692 7.04107 5.00002 7.5013 5.00002ZM12.5013 10.8334C12.9616 10.8334 13.3346 10.4603 13.3346 10C13.3346 9.53977 12.9616 9.16669 12.5013 9.16669C12.0411 9.16669 11.668 9.53977 11.668 10C11.668 10.4603 12.0411 10.8334 12.5013 10.8334ZM7.5013 16.6667C7.96154 16.6667 8.33464 16.2936 8.33464 15.8334C8.33464 15.3731 7.96154 15 7.5013 15C7.04107 15 6.66797 15.3731 6.66797 15.8334C6.66797 16.2936 7.04107 16.6667 7.5013 16.6667Z" fill="#1A1A1A"></path>
                            </svg>
                        </button>
                    </ul>
                </div>
            </nav>
            <div class=" container-application-form">
                <div class=" selection-screen">
                    <h2>Öğrenim Tipi Seçimi</h2>
                    <label for="educationType">Öğrenim Tipi*</label>
                    <form action="{{route('burs-basvur-tipi-getir')}}" method="post">@csrf
                        <select  required name="educationType" id="educationType">
                            <option value="" selected="">Öğrenim tipinizi seçiniz...</option>
                            <option value="ilk">İlkokul</option>
                            <option value="orta">Ortaokul</option>
                            <option value="lise">Lise</option>
                            <option value="Ön lisans">Ön lisans</option>
                            <option value="lisans">Lisans</option>
                            <option value="yüksek">Yüksek Lisans</option>
                        </select>
                        <div class="button-direct mt-4">
                            <button id="cancelButton">Vazgeç</button>
                            <button type="submit" id="continueButton">Devam</button>
                        </div>
                    </form>
                </div>

                <!--<div id="ilkScreen" class="screen hidden">
                    <div id="application-form-primary">
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
                                    <div class="step-text">Belge Yükleme</div>
                                </div>
                            </div>
                            <form>
                                <div class="step-content show active" id="step-1" data-content="1">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerAdi" class="form-label">Adı</label>
                                            <input type="text" class="form-control" id="bursiyerAdi" value="Ahsen" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSoyadi" class="form-label">Soyadı</label>
                                            <input type="text" class="form-control" id="bursiyerSoyadi" value="Soyad" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
                                            <input type="text" class="form-control" id="bursiyerTcNo" value="12345678989" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerPosta" class="form-label">E-posta</label>
                                            <input type="email" class="form-control" id="bursiyerPosta" value="ahsen@ahsen.com" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSube" class="form-label">Şube</label>
                                            <input type="text" class="form-control" id="bursiyerSube" value="Şube ataması sistem tarafından yapılacaktır." readonly="">
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation1" checked="">
                                        <label class="form-check-label" for="confirmation1">
                                            Vermiş olduğum cevapların doğru olduğunu kabul ve taahhüt ederim.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation2" checked="">
                                        <label class="form-check-label" for="confirmation2">
                                            KVKK Kurallarının gereksinimlerini kabul ederim.
                                        </label>
                                    </div>
                                </div>
                                <div class="step-content" id="step-2" data-content="2">
                                    <div class="row">
                                        <label for="day">Doğum Tarihi</label>
                                        <div class="col-md-1 mb-3">
                                            <select id="day" class="form-select">
                                                <option value="">Gün seç...</option>
                                                <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="month" class="form-select">
                                                <option value="">Ay seç...</option>
                                                <option value="1">Ocak</option><option value="2">Şubat</option><option value="3">Mart</option><option value="4">Nisan</option><option value="5">Mayıs</option><option value="6">Haziran</option><option value="7">Temmuz</option><option value="8">Ağustos</option><option value="9">Eylül</option><option value="10">Ekim</option><option value="11">Kasım</option><option value="12">Aralık</option></select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="year" class="form-select">
                                                <option value="">Yıl seç...</option>
                                                <option value="2024">2024</option><option value="2023">2023</option><option value="2022">2022</option><option value="2021">2021</option><option value="2020">2020</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option><option value="1904">1904</option><option value="1903">1903</option><option value="1902">1902</option><option value="1901">1901</option><option value="1900">1900</option></select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="birthCity">Doğduğu Şehir</label>
                                            <select id="birthCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="birthDistrict">Doğduğu İlçe</label>
                                            <select id="birthDistrict" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="registeredCity">Nüfusa Kayıtlı Olduğu İl</label>
                                            <select id="registeredCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="İstanbul">İstanbul</option><option value="Ankara">Ankara</option><option value="İzmir">İzmir</option><option value="Bursa">Bursa</option><option value="Antalya">Antalya</option></select>
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
                                                <option value="Erkek">Erkek</option><option value="Kadın">Kadın</option><option value="Diğer">Diğer</option></select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="maritalStatus">Medeni Durum</label>
                                            <select id="maritalStatus" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="Bekar">Bekar</option><option value="Evli">Evli</option><option value="Boşanmış">Boşanmış</option><option value="Dul">Dul</option></select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nationality" class="form-label">Uyruk</label>
                                            <input type="text" class="form-control" id="nationality" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-3" data-content="3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolType">Okul Tipi</label>
                                            <select id="schoolType" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="İlkokul">İlkokul</option><option value="Ortaokul">Ortaokul</option><option value="Lise">Lise</option><option value="Üniversite">Üniversite</option></select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolName">Okul Adı</label>
                                            <input type="text" class="form-control" id="schoolName" placeholder="Okul adınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolCity">Okulun Bulunduğu Şehir</label>
                                            <select id="schoolCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="İstanbul">İstanbul</option><option value="Ankara">Ankara</option><option value="İzmir">İzmir</option><option value="Bursa">Bursa</option><option value="Antalya">Antalya</option></select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="grade">Sınıfınız</label>
                                            <select id="grade" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="1. Sınıf">1. Sınıf</option><option value="2. Sınıf">2. Sınıf</option><option value="3. Sınıf">3. Sınıf</option><option value="4. Sınıf">4. Sınıf</option><option value="5. Sınıf">5. Sınıf</option><option value="6. Sınıf">6. Sınıf</option><option value="7. Sınıf">7. Sınıf</option><option value="8. Sınıf">8. Sınıf</option><option value="9. Sınıf">9. Sınıf</option><option value="10. Sınıf">10. Sınıf</option><option value="11. Sınıf">11. Sınıf</option><option value="12. Sınıf">12. Sınıf</option></select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="studentNumber">Öğrenci Numarası</label>
                                            <input type="text" class="form-control" id="studentNumber" placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="averageGrade">Not Ortalaması</label>
                                            <input type="text" class="form-control" id="averageGrade" placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="transferred">Nakil Yaptı mı?</label>
                                            <select id="transferred" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="Evet">Evet</option><option value="Hayır">Hayır</option></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-4" data-content="4">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="housingType">Barınma Türü</label>
                                            <select id="housingType" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="Ev">Ev</option><option value="Yurt">Yurt</option><option value="Aile Yanı">Aile Yanı</option><option value="Arkadaş Yanı">Arkadaş Yanı</option><option value="Kira">Kira</option></select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="housingFee">Ödenen Ücret</label>
                                            <input type="text" class="form-control" id="housingFee" placeholder="Ödenen ücret bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="livingWithCount">Birlikte Yaşanılan Kişi Sayısı</label>
                                            <input type="text" class="form-control" id="livingWithCount" placeholder="Kişi sayısı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="residingCity">Kaldığı İl</label>
                                            <select id="residingCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="İstanbul">İstanbul</option><option value="Ankara">Ankara</option><option value="İzmir">İzmir</option><option value="Bursa">Bursa</option><option value="Antalya">Antalya</option></select>
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
                                            <input type="text" class="form-control" id="addressDetail" placeholder="Adres bilgisi giriniz...">
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
                                                <option value="İstanbul">İstanbul</option><option value="Ankara">Ankara</option><option value="İzmir">İzmir</option><option value="Bursa">Bursa</option><option value="Antalya">Antalya</option></select>
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
                                            <input type="text" id="address" class="form-control" placeholder="Adres bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentMobile">Ailenin Cep Telefonu</label>
                                            <input type="text" id="parentMobile" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="parentHomePhone">Ailenin Ev Telefonu</label>
                                            <input type="text" id="parentHomePhone" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentEmail">Ailenin E-posta Adresi</label>
                                            <input type="email" id="parentEmail" class="form-control" placeholder="E-posta adresi giriniz...">
                                        </div>
                                    </div>
                                    <div class="urgent">
                                        <div class="row">
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z" fill="black"></path>
                                                </svg> Acil Durum Kişisi</p>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="adSoyad" class="form-label">Adı Soyadı</label>
                                                    <input type="text" class="form-control" id="adSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="telefon" class="form-label">Telefon</label>
                                                    <input type="text" class="form-control" id="telefon" placeholder="Telefon numarası giriniz...">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="yakınlıkDerecesi" class="form-label">Yakınlık
                                                        Derecesi</label>
                                                    <input type="text" class="form-control" id="yakınlıkDerecesi" placeholder="Yakınlık derecesi giriniz...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-6" data-content="6">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaBirlikte" class="form-label">Anne Baba Birlikte mi?</label>
                                            <select class="form-select" id="anneBabaBirlikte" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaSag" class="form-label">Anne Baba Sağ mı?</label>
                                            <select class="form-select" id="anneBabaSag" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
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
                                            <input type="text" class="form-control" id="babaninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninMeslegi" class="form-label">Annenin Mesleği</label>
                                            <input type="text" class="form-control" id="anneninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninTahsilDurumu" class="form-label">Babanın Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="babaninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninTahsilDurumu" class="form-label">Annenin Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="anneninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninSosyalGuvenlik" class="form-label">Babanın Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="babaninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninSosyalGuvenlik" class="form-label">Annenin Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="anneninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-7" data-content="7">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="kardesSayisi" class="form-label">Kardeş Sayısı (Siz Dahil)</label>
                                            <input type="text" class="form-control" id="kardesSayisi" placeholder="Kardeş bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="okuyanKardesSayisi" class="form-label">Okuyan Kardeş Sayısı (Siz
                                                Dahil)</label>
                                            <input type="text" class="form-control" id="okuyanKardesSayisi" placeholder="Okuyan kardeş bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 1. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 2. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-8" data-content="8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="gecimiSaglayanKisiler" class="form-label">Ailenin Geçimini
                                                Kim/Kimler
                                                sağlıyor?</label>
                                            <input type="text" class="form-control" id="gecimiSaglayanKisiler" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="saglayanKisilerToplam" class="form-label">Gelir Sağlayan
                                                Kişi/Kişiler Toplam Kaç
                                                Kişiye Bakıyor?</label>
                                            <input type="text" class="form-control" id="saglayanKisilerToplam" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninGeliri" class="form-label">Babanın Aylık Net Geliri
                                                (TL)</label>
                                            <input type="text" class="form-control" id="babaninGeliri" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninGeliri" class="form-label">Annenin Aylık Net Geliri
                                                (TL)</label>
                                            <input type="text" class="form-control" id="anneninGeliri" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="digerKisilerinGeliri" class="form-label">Diğer kişilerin Aylık Net
                                                Geliri
                                                (TL)</label>
                                            <input type="text" class="form-control" id="digerKisilerinGeliri" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="baskaGelir" class="form-label">Ailenin Başka Geliri Var mı? (Kira
                                                vb.)</label>
                                            <input type="text" class="form-control" id="baskaGelir" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="evTuru" class="form-label">Ailenin yaşamakta olduğu ev türü?</label>
                                            <select class="form-select" id="evTuru" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
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
                                            <input type="text" class="form-control" id="digerAciklama" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-9" data-content="9">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="devletBursu" class="form-label">Devlet Bursu Almakta mı ya da
                                                Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="devletBursu" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ozelBurs" class="form-label">Özel Burs Almakta mı ya da Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="ozelBurs" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursKurum" class="form-label">Burs Aldığı Kurum Adı</label>
                                            <input type="text" class="form-control" id="bursKurum" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursMiktari" class="form-label">Aldığı Burs Miktarı</label>
                                            <input type="text" class="form-control" id="bursMiktari" placeholder="Burs miktarı giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-10" data-content="10">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelDurumu" class="form-label">Herhangi bir engel durumunuz var
                                                mı?</label>
                                            <select class="form-select" id="engelDurumu" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelAciklama" class="form-label">Engel durumunu açıklayınız
                                                (varsa)</label>
                                            <input type="text" class="form-control" id="engelAciklama" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-11" data-content="11">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="haberKaynak" class="form-label">Bizden Nasıl Haberdar
                                                Oldunuz?</label>
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
                                            <label for="sosyalProjeler" class="form-label">Katkıda Bulunduğunuz Sosyal
                                                Projeler</label>
                                            <input type="text" class="form-control" id="sosyalProjeler" placeholder="Proje bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hobiler" class="form-label">Hobileriniz</label>
                                            <input type="text" class="form-control" id="hobiler" placeholder="Hobi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sporDali" class="form-label">İlgilendiğiniz Spor Dalı
                                                (Varsa)</label>
                                            <input type="text" class="form-control" id="sporDali" placeholder="Spor dalı bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kitaplar" class="form-label">Son Okuduğunuz Kitaplar</label>
                                            <input type="text" class="form-control" id="kitaplar" placeholder="Kitap adı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="mesaj" class="form-label">Bize Mesajınız</label>
                                            <textarea class="form-control" id="mesaj" rows="3" placeholder="Mesajınızı giriniz..."></textarea>
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
                                            <input type="text" class="form-control" id="hesapNumarasi" placeholder="Hesap numarası giriniz...">
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
                                        <div class="col-md-4">
                                            <div class="upload-card">
                                                <div class="documents-title-drag-drop">
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Öğrenci Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Adli Sicil Kaydı
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Vukuatlı Nufüs Kayıt Örneği
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Anne Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Baba Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Aile Mali Durum (Tapu, Araç vs.)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Engelli Raporu (Varsa)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Mektup
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Kimlik Belgesi (Ön ve Arka)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                    </div>
                </div>
                <div id="ortaScreen" class="screen hidden">
                    <div id="application-form-middle1">
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
                                    <div class="step-text">Belge Yükleme</div>
                                </div>
                            </div>
                            <form>
                                <div class="step-content show active" id="step-1" data-content="1">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerAdi" class="form-label">Adı</label>
                                            <input type="text" class="form-control" id="bursiyerAdi" value="Ahsen" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSoyadi" class="form-label">Soyadı</label>
                                            <input type="text" class="form-control" id="bursiyerSoyadi" value="Soyad" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
                                            <input type="text" class="form-control" id="bursiyerTcNo" value="12345678989" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerPosta" class="form-label">E-posta</label>
                                            <input type="email" class="form-control" id="bursiyerPosta" value="ahsen@ahsen.com" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSube" class="form-label">Şube</label>
                                            <input type="text" class="form-control" id="bursiyerSube" value="Şube ataması sistem tarafından yapılacaktır." readonly="">
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation1" checked="">
                                        <label class="form-check-label" for="confirmation1">
                                            Vermiş olduğum cevapların doğru olduğunu kabul ve taahhüt ederim.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation2" checked="">
                                        <label class="form-check-label" for="confirmation2">
                                            KVKK Kurallarının gereksinimlerini kabul ederim.
                                        </label>
                                    </div>
                                </div>
                                <div class="step-content" id="step-2" data-content="2">
                                    <div class="row">
                                        <label for="day">Doğum Tarihi</label>
                                        <div class="col-md-1 mb-3">
                                            <select id="day" class="form-select">
                                                <option value="">Gün seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="month" class="form-select">
                                                <option value="">Ay seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="year" class="form-select">
                                                <option value="">Yıl seç...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="birthCity">Doğduğu Şehir</label>
                                            <select id="birthCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="birthDistrict">Doğduğu İlçe</label>
                                            <select id="birthDistrict" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
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
                                            <input type="text" class="form-control" id="nationality" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-3" data-content="3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolType">Okul Tipi</label>
                                            <select id="schoolType" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolName">Okul Adı</label>
                                            <input type="text" class="form-control" id="schoolName" placeholder="Okul adınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolCity">Okulun Bulunduğu Şehir</label>
                                            <select id="schoolCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="grade">Sınıfınız</label>
                                            <select id="grade" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="studentNumber">Öğrenci Numarası</label>
                                            <input type="text" class="form-control" id="studentNumber" placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="averageGrade">Not Ortalaması</label>
                                            <input type="text" class="form-control" id="averageGrade" placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="transferred">Nakil Yaptı mı?</label>
                                            <select id="transferred" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
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
                                            <input type="text" class="form-control" id="housingFee" placeholder="Ödenen ücret bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="livingWithCount">Birlikte Yaşanılan Kişi Sayısı</label>
                                            <input type="text" class="form-control" id="livingWithCount" placeholder="Kişi sayısı giriniz...">
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
                                            <input type="text" class="form-control" id="addressDetail" placeholder="Adres bilgisi giriniz...">
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
                                            <input type="text" id="address" class="form-control" placeholder="Adres bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentMobile">Ailenin Cep Telefonu</label>
                                            <input type="text" id="parentMobile" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="parentHomePhone">Ailenin Ev Telefonu</label>
                                            <input type="text" id="parentHomePhone" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentEmail">Ailenin E-posta Adresi</label>
                                            <input type="email" id="parentEmail" class="form-control" placeholder="E-posta adresi giriniz...">
                                        </div>
                                    </div>
                                    <div class="urgent">
                                        <div class="row">
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z" fill="black"></path>
                                                </svg> Acil Durum Kişisi</p>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="adSoyad" class="form-label">Adı Soyadı</label>
                                                    <input type="text" class="form-control" id="adSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="telefon" class="form-label">Telefon</label>
                                                    <input type="text" class="form-control" id="telefon" placeholder="Telefon numarası giriniz...">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="yakınlıkDerecesi" class="form-label">Yakınlık
                                                        Derecesi</label>
                                                    <input type="text" class="form-control" id="yakınlıkDerecesi" placeholder="Yakınlık derecesi giriniz...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-6" data-content="6">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaBirlikte" class="form-label">Anne Baba Birlikte mi?</label>
                                            <select class="form-select" id="anneBabaBirlikte" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaSag" class="form-label">Anne Baba Sağ mı?</label>
                                            <select class="form-select" id="anneBabaSag" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
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
                                            <input type="text" class="form-control" id="babaninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninMeslegi" class="form-label">Annenin Mesleği</label>
                                            <input type="text" class="form-control" id="anneninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninTahsilDurumu" class="form-label">Babanın Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="babaninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninTahsilDurumu" class="form-label">Annenin Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="anneninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninSosyalGuvenlik" class="form-label">Babanın Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="babaninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninSosyalGuvenlik" class="form-label">Annenin Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="anneninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-7" data-content="7">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="kardesSayisi" class="form-label">Kardeş Sayısı (Siz Dahil)</label>
                                            <input type="text" class="form-control" id="kardesSayisi" placeholder="Kardeş bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="okuyanKardesSayisi" class="form-label">Okuyan Kardeş Sayısı (Siz
                                                Dahil)</label>
                                            <input type="text" class="form-control" id="okuyanKardesSayisi" placeholder="Okuyan kardeş bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 1. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 2. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-8" data-content="8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="mainIncomeProvider">Ailenin Geçimini Kim/Kimler sağlıyor?</label>
                                            <input type="text" class="form-control" id="mainIncomeProvider" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="totalDependents">Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye
                                                Bakıyor?</label>
                                            <input type="text" class="form-control" id="totalDependents" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fatherIncome">Babanın Aylık Net Geliri (TL)</label>
                                            <input type="text" class="form-control" id="fatherIncome" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="motherIncome">Annenin Aylık Net Geliri (TL)</label>
                                            <input type="text" class="form-control" id="motherIncome" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="otherIncome">Diğer kişilerin Aylık Net Geliri (TL)</label>
                                            <input type="text" class="form-control" id="otherIncome" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="additionalIncome">Ailenin Başka Geliri Var mı? (Kira vb.)</label>
                                            <input type="text" class="form-control" id="additionalIncome" placeholder="Gelir bilgisi giriniz...">
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
                                            <input type="text" class="form-control" id="rentAmount" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="additionalInfo">Diğer İse* Açıklama</label>
                                            <input type="text" class="form-control" id="additionalInfo" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="loanInfo">Kredi borcu ödüyor musunuz? Ödüyorsanız tutarı ile
                                                birlikte yazınız</label>
                                            <input type="text" class="form-control" id="loanInfo" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="employmentInfo">Herhangi bir işte çalışıyor musunuz? Evet ise
                                                çalışma şekliniz ve aylık geliriniz belirtiniz</label>
                                            <input type="text" class="form-control" id="employmentInfo" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>

                                </div>
                                <div class="step-content" id="step-9" data-content="9">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="devletBursu" class="form-label">Devlet Bursu Almakta mı ya da
                                                Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="devletBursu" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ozelBurs" class="form-label">Özel Burs Almakta mı ya da Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="ozelBurs" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursKurum" class="form-label">Burs Aldığı Kurum Adı</label>
                                            <input type="text" class="form-control" id="bursKurum" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursMiktari" class="form-label">Aldığı Burs Miktarı</label>
                                            <input type="text" class="form-control" id="bursMiktari" placeholder="Burs miktarı giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-10" data-content="10">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelDurumu" class="form-label">Herhangi bir engel durumunuz var
                                                mı?</label>
                                            <select class="form-select" id="engelDurumu" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelAciklama" class="form-label">Engel durumunu açıklayınız
                                                (varsa)</label>
                                            <input type="text" class="form-control" id="engelAciklama" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-11" data-content="11">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="haberKaynak" class="form-label">Bizden Nasıl Haberdar
                                                Oldunuz?</label>
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
                                            <label for="sosyalProjeler" class="form-label">Katkıda Bulunduğunuz Sosyal
                                                Projeler</label>
                                            <input type="text" class="form-control" id="sosyalProjeler" placeholder="Proje bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hobiler" class="form-label">Hobileriniz</label>
                                            <input type="text" class="form-control" id="hobiler" placeholder="Hobi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sporDali" class="form-label">İlgilendiğiniz Spor Dalı
                                                (Varsa)</label>
                                            <input type="text" class="form-control" id="sporDali" placeholder="Spor dalı bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kitaplar" class="form-label">Son Okuduğunuz Kitaplar</label>
                                            <input type="text" class="form-control" id="kitaplar" placeholder="Kitap adı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="mesaj" class="form-label">Bize Mesajınız</label>
                                            <textarea class="form-control" id="mesaj" rows="3" placeholder="Mesajınızı giriniz..."></textarea>
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
                                            <input type="text" class="form-control" id="hesapNumarasi" placeholder="Hesap numarası giriniz...">
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
                                        <div class="col-md-4">
                                            <div class="upload-card">
                                                <div class="documents-title-drag-drop">
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Öğrenci Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Adli Sicil Kaydı
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Vukuatlı Nufüs Kayıt Örneği
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Anne Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Baba Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Aile Mali Durum (Tapu, Araç vs.)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Engelli Raporu (Varsa)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Mektup
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Kimlik Belgesi (Ön ve Arka)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                    </div>
                </div>
                <div id="liseScreen" class="screen hidden">
                    <div id="application-form-high">
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
                                    <div class="step-text">Belge Yükleme</div>
                                </div>
                            </div>
                            <form>
                                <div class="step-content show active" id="step-1" data-content="1">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerAdi" class="form-label">Adı</label>
                                            <input type="text" class="form-control" id="bursiyerAdi" value="Ahsen" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSoyadi" class="form-label">Soyadı</label>
                                            <input type="text" class="form-control" id="bursiyerSoyadi" value="Soyad" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
                                            <input type="text" class="form-control" id="bursiyerTcNo" value="12345678989" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerPosta" class="form-label">E-posta</label>
                                            <input type="email" class="form-control" id="bursiyerPosta" value="ahsen@ahsen.com" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSube" class="form-label">Şube</label>
                                            <input type="text" class="form-control" id="bursiyerSube" value="Şube ataması sistem tarafından yapılacaktır." readonly="">
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation1" checked="">
                                        <label class="form-check-label" for="confirmation1">
                                            Vermiş olduğum cevapların doğru olduğunu kabul ve taahhüt ederim.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation2" checked="">
                                        <label class="form-check-label" for="confirmation2">
                                            KVKK Kurallarının gereksinimlerini kabul ederim.
                                        </label>
                                    </div>
                                </div>
                                <div class="step-content" id="step-2" data-content="2">
                                    <div class="row">
                                        <label for="day">Doğum Tarihi</label>
                                        <div class="col-md-1 mb-3">
                                            <select id="day" class="form-select">
                                                <option value="">Gün seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="month" class="form-select">
                                                <option value="">Ay seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="year" class="form-select">
                                                <option value="">Yıl seç...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="birthCity">Doğduğu Şehir</label>
                                            <select id="birthCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="birthDistrict">Doğduğu İlçe</label>
                                            <select id="birthDistrict" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
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
                                            <input type="text" class="form-control" id="nationality" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-3" data-content="3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolType">Okul Tipi</label>
                                            <select id="schoolType" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolName">Mezun Olunan Okul Adı</label>
                                            <input type="text" class="form-control" id="schoolName" placeholder="Okul adınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="currentSchool">Okulun Bulunduğu Şehir</label>
                                            <select id="currentSchool" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="point">Giriş Puanınız</label>
                                            <input type="text" class="form-control" id="point" placeholder="Giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolCity">Okulun Bulunduğu Şehir</label>
                                            <select id="schoolCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="grade">Sınıfınız</label>
                                            <select id="grade" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="studentNumber">Öğrenci Numarası</label>
                                            <input type="text" class="form-control" id="studentNumber" placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="averageGrade">Son Öğretim Dönemindeki Not Ortalaması</label>
                                            <input type="text" class="form-control" id="averageGrade" placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="transferred">Nakil Yaptı mı?</label>
                                            <select id="transferred" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
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
                                            <input type="text" class="form-control" id="housingFee" placeholder="Ödenen ücret bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="livingWithCount">Birlikte Yaşanılan Kişi Sayısı</label>
                                            <input type="text" class="form-control" id="livingWithCount" placeholder="Kişi sayısı giriniz...">
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
                                            <input type="text" class="form-control" id="addressDetail" placeholder="Adres bilgisi giriniz...">
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
                                            <input type="text" id="address" class="form-control" placeholder="Adres bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentMobile">Ailenin Cep Telefonu</label>
                                            <input type="text" id="parentMobile" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="parentHomePhone">Ailenin Ev Telefonu</label>
                                            <input type="text" id="parentHomePhone" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentEmail">Ailenin E-posta Adresi</label>
                                            <input type="email" id="parentEmail" class="form-control" placeholder="E-posta adresi giriniz...">
                                        </div>
                                    </div>
                                    <div class="urgent">
                                        <div class="row">
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z" fill="black"></path>
                                                </svg> Acil Durum Kişisi</p>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="adSoyad" class="form-label">Adı Soyadı</label>
                                                    <input type="text" class="form-control" id="adSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="telefon" class="form-label">Telefon</label>
                                                    <input type="text" class="form-control" id="telefon" placeholder="Telefon numarası giriniz...">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="yakınlıkDerecesi" class="form-label">Yakınlık
                                                        Derecesi</label>
                                                    <input type="text" class="form-control" id="yakınlıkDerecesi" placeholder="Yakınlık derecesi giriniz...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-6" data-content="6">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaBirlikte" class="form-label">Anne Baba Birlikte mi?</label>
                                            <select class="form-select" id="anneBabaBirlikte" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaSag" class="form-label">Anne Baba Sağ mı?</label>
                                            <select class="form-select" id="anneBabaSag" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
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
                                            <input type="text" class="form-control" id="babaninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninMeslegi" class="form-label">Annenin Mesleği</label>
                                            <input type="text" class="form-control" id="anneninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninTahsilDurumu" class="form-label">Babanın Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="babaninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninTahsilDurumu" class="form-label">Annenin Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="anneninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninSosyalGuvenlik" class="form-label">Babanın Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="babaninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninSosyalGuvenlik" class="form-label">Annenin Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="anneninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-7" data-content="7">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="kardesSayisi" class="form-label">Kardeş Sayısı (Siz Dahil)</label>
                                            <input type="text" class="form-control" id="kardesSayisi" placeholder="Kardeş bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="okuyanKardesSayisi" class="form-label">Okuyan Kardeş Sayısı (Siz
                                                Dahil)</label>
                                            <input type="text" class="form-control" id="okuyanKardesSayisi" placeholder="Okuyan kardeş bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 1. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 2. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-8" data-content="8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="gecimiSaglayanKisiler" class="form-label">Ailenin Geçimini
                                                Kim/Kimler
                                                sağlıyor?</label>
                                            <input type="text" class="form-control" id="gecimiSaglayanKisiler" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="saglayanKisilerToplam" class="form-label">Gelir Sağlayan
                                                Kişi/Kişiler Toplam Kaç
                                                Kişiye Bakıyor?</label>
                                            <input type="text" class="form-control" id="saglayanKisilerToplam" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninGeliri" class="form-label">Babanın Aylık Net Geliri
                                                (TL)</label>
                                            <input type="text" class="form-control" id="babaninGeliri" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninGeliri" class="form-label">Annenin Aylık Net Geliri
                                                (TL)</label>
                                            <input type="text" class="form-control" id="anneninGeliri" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="digerKisilerinGeliri" class="form-label">Diğer kişilerin Aylık Net
                                                Geliri
                                                (TL)</label>
                                            <input type="text" class="form-control" id="digerKisilerinGeliri" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="baskaGelir" class="form-label">Ailenin Başka Geliri Var mı? (Kira
                                                vb.)</label>
                                            <input type="text" class="form-control" id="baskaGelir" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="evTuru" class="form-label">Ailenin yaşamakta olduğu ev türü?</label>
                                            <select class="form-select" id="evTuru" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
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
                                            <input type="text" class="form-control" id="digerAciklama" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-9" data-content="9">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="devletBursu" class="form-label">Devlet Bursu Almakta mı ya da
                                                Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="devletBursu" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ozelBurs" class="form-label">Özel Burs Almakta mı ya da Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="ozelBurs" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursKurum" class="form-label">Burs Aldığı Kurum Adı</label>
                                            <input type="text" class="form-control" id="bursKurum" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursMiktari" class="form-label">Aldığı Burs Miktarı</label>
                                            <input type="text" class="form-control" id="bursMiktari" placeholder="Burs miktarı giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-10" data-content="10">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelDurumu" class="form-label">Herhangi bir engel durumunuz var
                                                mı?</label>
                                            <select class="form-select" id="engelDurumu" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelAciklama" class="form-label">Engel durumunu açıklayınız
                                                (varsa)</label>
                                            <input type="text" class="form-control" id="engelAciklama" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-11" data-content="11">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="haberKaynak" class="form-label">Bizden Nasıl Haberdar
                                                Oldunuz?</label>
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
                                            <label for="sosyalProjeler" class="form-label">Katkıda Bulunduğunuz Sosyal
                                                Projeler</label>
                                            <input type="text" class="form-control" id="sosyalProjeler" placeholder="Proje bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hobiler" class="form-label">Hobileriniz</label>
                                            <input type="text" class="form-control" id="hobiler" placeholder="Hobi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sporDali" class="form-label">İlgilendiğiniz Spor Dalı
                                                (Varsa)</label>
                                            <input type="text" class="form-control" id="sporDali" placeholder="Spor dalı bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kitaplar" class="form-label">Son Okuduğunuz Kitaplar</label>
                                            <input type="text" class="form-control" id="kitaplar" placeholder="Kitap adı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="mesaj" class="form-label">Bize Mesajınız</label>
                                            <textarea class="form-control" id="mesaj" rows="3" placeholder="Mesajınızı giriniz..."></textarea>
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
                                            <input type="text" class="form-control" id="hesapNumarasi" placeholder="Hesap numarası giriniz...">
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
                                        <div class="col-md-4">
                                            <div class="upload-card">
                                                <div class="documents-title-drag-drop">
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Öğrenci Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Adli Sicil Kaydı
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Vukuatlı Nufüs Kayıt Örneği
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Anne Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Baba Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Aile Mali Durum (Tapu, Araç vs.)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Engelli Raporu (Varsa)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Mektup
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Kimlik Belgesi (Ön ve Arka)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                    </div>
                </div>
                <div id="önlisansScreen" class="screen hidden">
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
                                    <div class="step-text">Belge Yükleme</div>
                                </div>
                            </div>
                            <form>
                                <div class="step-content show active" id="step-1" data-content="1">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerAdi" class="form-label">Adı</label>
                                            <input type="text" class="form-control" id="bursiyerAdi" value="Ahsen" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSoyadi" class="form-label">Soyadı</label>
                                            <input type="text" class="form-control" id="bursiyerSoyadi" value="Soyad" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
                                            <input type="text" class="form-control" id="bursiyerTcNo" value="12345678989" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerPosta" class="form-label">E-posta</label>
                                            <input type="email" class="form-control" id="bursiyerPosta" value="ahsen@ahsen.com" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSube" class="form-label">Şube</label>
                                            <input type="text" class="form-control" id="bursiyerSube" value="Şube ataması sistem tarafından yapılacaktır." readonly="">
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation1" checked="">
                                        <label class="form-check-label" for="confirmation1">
                                            Vermiş olduğum cevapların doğru olduğunu kabul ve taahhüt ederim.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation2" checked="">
                                        <label class="form-check-label" for="confirmation2">
                                            KVKK Kurallarının gereksinimlerini kabul ederim.
                                        </label>
                                    </div>
                                </div>
                                <div class="step-content" id="step-2" data-content="2">
                                    <div class="row">
                                        <label for="day">Doğum Tarihi</label>
                                        <div class="col-md-1 mb-3">
                                            <select id="day" class="form-select">
                                                <option value="">Gün seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="month" class="form-select">
                                                <option value="">Ay seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="year" class="form-select">
                                                <option value="">Yıl seç...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="birthCity">Doğduğu Şehir</label>
                                            <select id="birthCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="birthDistrict">Doğduğu İlçe</label>
                                            <select id="birthDistrict" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
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
                                            <input type="text" class="form-control" id="nationality" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-3" data-content="3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="reportedHighSchool">Bitirdiğiniz Lise</label>
                                            <input type="text" class="form-control" id="reportedHighSchool" placeholder="Lise bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="universityEntranceScore">Üniversiteye Giriş Puanınız</label>
                                            <input type="text" class="form-control" id="universityEntranceScore" placeholder="Puanınızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="continuingUniversity">Öğrenime Devam Ettiğiniz Üniversite</label>
                                            <input type="text" class="form-control" id="continuingUniversity" placeholder="Okul adı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="universityStatus">Üniversitenin Statüsü</label>
                                            <select id="universityStatus" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="schoolCity">Okulun Bulunduğu Şehir</label>
                                            <select id="schoolCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="educationYear">.... - .... Öğretim Yılında Kaçıncı Sınıfta
                                                Olacaksınız?</label>
                                            <select id="educationYear" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="studentNumber">Öğrenci Numarası</label>
                                            <input type="text" class="form-control" id="studentNumber" placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="agnoSystem">AGNO Sisteminiz</label>
                                            <select id="agnoSystem" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="agno">AGNO</label>
                                            <input type="text" class="form-control" id="agno" placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                            <select id="university_transfer" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                                bilgilerinizi yazınız</label>
                                            <input type="text" class="form-control" id="university_transfer_desc" placeholder="Geçiş bilgilerinizi giriniz...">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                                yazınız</label>
                                            <input type="text" class="form-control" id="languages" placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
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
                                            <input type="text" class="form-control" id="housingFee" placeholder="Ödenen ücret bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="livingWithCount">Birlikte Yaşanılan Kişi Sayısı</label>
                                            <input type="text" class="form-control" id="livingWithCount" placeholder="Kişi sayısı giriniz...">
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
                                            <input type="text" class="form-control" id="addressDetail" placeholder="Adres bilgisi giriniz...">
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
                                            <input type="text" id="address" class="form-control" placeholder="Adres bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentMobile">Ailenin Cep Telefonu</label>
                                            <input type="text" id="parentMobile" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="parentHomePhone">Ailenin Ev Telefonu</label>
                                            <input type="text" id="parentHomePhone" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentEmail">Ailenin E-posta Adresi</label>
                                            <input type="email" id="parentEmail" class="form-control" placeholder="E-posta adresi giriniz...">
                                        </div>
                                    </div>
                                    <div class="urgent">
                                        <div class="row">
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z" fill="black"></path>
                                                </svg> Acil Durum Kişisi</p>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="adSoyad" class="form-label">Adı Soyadı</label>
                                                    <input type="text" class="form-control" id="adSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="telefon" class="form-label">Telefon</label>
                                                    <input type="text" class="form-control" id="telefon" placeholder="Telefon numarası giriniz...">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="yakınlıkDerecesi" class="form-label">Yakınlık
                                                        Derecesi</label>
                                                    <input type="text" class="form-control" id="yakınlıkDerecesi" placeholder="Yakınlık derecesi giriniz...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-6" data-content="6">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaBirlikte" class="form-label">Anne Baba Birlikte mi?</label>
                                            <select class="form-select" id="anneBabaBirlikte" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaSag" class="form-label">Anne Baba Sağ mı?</label>
                                            <select class="form-select" id="anneBabaSag" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
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
                                            <input type="text" class="form-control" id="babaninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninMeslegi" class="form-label">Annenin Mesleği</label>
                                            <input type="text" class="form-control" id="anneninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninTahsilDurumu" class="form-label">Babanın Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="babaninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninTahsilDurumu" class="form-label">Annenin Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="anneninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninSosyalGuvenlik" class="form-label">Babanın Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="babaninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninSosyalGuvenlik" class="form-label">Annenin Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="anneninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-7" data-content="7">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="kardesSayisi" class="form-label">Kardeş Sayısı (Siz Dahil)</label>
                                            <input type="text" class="form-control" id="kardesSayisi" placeholder="Kardeş bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="okuyanKardesSayisi" class="form-label">Okuyan Kardeş Sayısı (Siz
                                                Dahil)</label>
                                            <input type="text" class="form-control" id="okuyanKardesSayisi" placeholder="Okuyan kardeş bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 1. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 2. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-8" data-content="8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="gecimiSaglayanKisiler" class="form-label">Ailenin Geçimini
                                                Kim/Kimler
                                                sağlıyor?</label>
                                            <input type="text" class="form-control" id="gecimiSaglayanKisiler" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="saglayanKisilerToplam" class="form-label">Gelir Sağlayan
                                                Kişi/Kişiler Toplam Kaç
                                                Kişiye Bakıyor?</label>
                                            <input type="text" class="form-control" id="saglayanKisilerToplam" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninGeliri" class="form-label">Babanın Aylık Net Geliri
                                                (TL)</label>
                                            <input type="text" class="form-control" id="babaninGeliri" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninGeliri" class="form-label">Annenin Aylık Net Geliri
                                                (TL)</label>
                                            <input type="text" class="form-control" id="anneninGeliri" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="digerKisilerinGeliri" class="form-label">Diğer kişilerin Aylık Net
                                                Geliri
                                                (TL)</label>
                                            <input type="text" class="form-control" id="digerKisilerinGeliri" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="baskaGelir" class="form-label">Ailenin Başka Geliri Var mı? (Kira
                                                vb.)</label>
                                            <input type="text" class="form-control" id="baskaGelir" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="evTuru" class="form-label">Ailenin yaşamakta olduğu ev türü?</label>
                                            <select class="form-select" id="evTuru" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
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
                                            <input type="text" class="form-control" id="digerAciklama" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-9" data-content="9">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="devletBursu" class="form-label">Devlet Bursu Almakta mı ya da
                                                Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="devletBursu" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ozelBurs" class="form-label">Özel Burs Almakta mı ya da Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="ozelBurs" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursKurum" class="form-label">Burs Aldığı Kurum Adı</label>
                                            <input type="text" class="form-control" id="bursKurum" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursMiktari" class="form-label">Aldığı Burs Miktarı</label>
                                            <input type="text" class="form-control" id="bursMiktari" placeholder="Burs miktarı giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-10" data-content="10">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelDurumu" class="form-label">Herhangi bir engel durumunuz var
                                                mı?</label>
                                            <select class="form-select" id="engelDurumu" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelAciklama" class="form-label">Engel durumunu açıklayınız
                                                (varsa)</label>
                                            <input type="text" class="form-control" id="engelAciklama" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-11" data-content="11">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="haberKaynak" class="form-label">Bizden Nasıl Haberdar
                                                Oldunuz?</label>
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
                                            <label for="sosyalProjeler" class="form-label">Katkıda Bulunduğunuz Sosyal
                                                Projeler</label>
                                            <input type="text" class="form-control" id="sosyalProjeler" placeholder="Proje bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hobiler" class="form-label">Hobileriniz</label>
                                            <input type="text" class="form-control" id="hobiler" placeholder="Hobi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sporDali" class="form-label">İlgilendiğiniz Spor Dalı
                                                (Varsa)</label>
                                            <input type="text" class="form-control" id="sporDali" placeholder="Spor dalı bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kitaplar" class="form-label">Son Okuduğunuz Kitaplar</label>
                                            <input type="text" class="form-control" id="kitaplar" placeholder="Kitap adı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="mesaj" class="form-label">Bize Mesajınız</label>
                                            <textarea class="form-control" id="mesaj" rows="3" placeholder="Mesajınızı giriniz..."></textarea>
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
                                            <input type="text" class="form-control" id="hesapNumarasi" placeholder="Hesap numarası giriniz...">
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
                                        <div class="col-md-4">
                                            <div class="upload-card">
                                                <div class="documents-title-drag-drop">
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Öğrenci Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Adli Sicil Kaydı
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Vukuatlı Nufüs Kayıt Örneği
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Anne Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Baba Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Aile Mali Durum (Tapu, Araç vs.)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Engelli Raporu (Varsa)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Mektup
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Kimlik Belgesi (Ön ve Arka)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                    </div>
                </div>
                <div id="lisansScreen" class="screen hidden">
                    <div id="application-form-degree">
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
                                    <div class="step-text">Belge Yükleme</div>
                                </div>
                            </div>
                            <form>
                                <div class="step-content show active" id="step-1" data-content="1">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerAdi" class="form-label">Adı</label>
                                            <input type="text" class="form-control" id="bursiyerAdi" value="Ahsen" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSoyadi" class="form-label">Soyadı</label>
                                            <input type="text" class="form-control" id="bursiyerSoyadi" value="Soyad" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
                                            <input type="text" class="form-control" id="bursiyerTcNo" value="12345678989" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerPosta" class="form-label">E-posta</label>
                                            <input type="email" class="form-control" id="bursiyerPosta" value="ahsen@ahsen.com" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSube" class="form-label">Şube</label>
                                            <input type="text" class="form-control" id="bursiyerSube" value="Şube ataması sistem tarafından yapılacaktır." readonly="">
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation1" checked="">
                                        <label class="form-check-label" for="confirmation1">
                                            Vermiş olduğum cevapların doğru olduğunu kabul ve taahhüt ederim.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation2" checked="">
                                        <label class="form-check-label" for="confirmation2">
                                            KVKK Kurallarının gereksinimlerini kabul ederim.
                                        </label>
                                    </div>
                                </div>
                                <div class="step-content" id="step-2" data-content="2">
                                    <div class="row">
                                        <label for="day">Doğum Tarihi</label>
                                        <div class="col-md-1 mb-3">
                                            <select id="day" class="form-select">
                                                <option value="">Gün seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="month" class="form-select">
                                                <option value="">Ay seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="year" class="form-select">
                                                <option value="">Yıl seç...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="birthCity">Doğduğu Şehir</label>
                                            <select id="birthCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="birthDistrict">Doğduğu İlçe</label>
                                            <select id="birthDistrict" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
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
                                            <input type="text" class="form-control" id="nationality" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-3" data-content="3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="highSchool">Bitirdiğiniz Lise</label>
                                            <input type="text" class="form-control" id="highSchool" placeholder="Lise bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="universityEntranceScore">Üniversiteye Giriş Puanınız</label>
                                            <input type="text" class="form-control" id="universityEntranceScore" placeholder="Puanınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="university">Öğrenime Devam Ettiğiniz Üniversite</label>
                                            <select id="university" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="universityStatus">Üniversitenin Statüsü</label>
                                            <select id="universityStatus" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="universityCity">Okulun Bulunduğu Şehir</label>
                                            <select id="universityCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="department">Fakülte / Bölüm</label>
                                            <input type="text" class="form-control" id="department" placeholder="Bölüm bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="educationType">Öğretim Türü</label>
                                            <select id="educationType" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="year">..... - ...... Öğretim Yılda Kaçıncı Sınıfta
                                                Olacaksınız?</label>
                                            <select id="year" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="studyDuration">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor?
                                                (Hazırlık Dahil)</label>
                                            <select id="studyDuration" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="studentNumber">Öğrenci Numarası</label>
                                            <input type="text" class="form-control" id="studentNumber" placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="agnoSystem">AGNO Sisteminiz</label>
                                            <select id="agnoSystem" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="agno">AGNO</label>
                                            <input type="text" class="form-control" id="agno" placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="verticalTransfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                            <select id="verticalTransfer" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="transferDetails">Yatay/Dikey geçiş yaptıysanız* geçiş
                                                bilgileriniz</label>
                                            <input type="text" class="form-control" id="transferDetails" placeholder="Geçiş bilgilerinizi giriniz...">
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
                                            <input type="text" class="form-control" id="housingFee" placeholder="Ödenen ücret bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="livingWithCount">Birlikte Yaşanılan Kişi Sayısı</label>
                                            <input type="text" class="form-control" id="livingWithCount" placeholder="Kişi sayısı giriniz...">
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
                                            <input type="text" class="form-control" id="addressDetail" placeholder="Adres bilgisi giriniz...">
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
                                            <input type="text" id="address" class="form-control" placeholder="Adres bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentMobile">Ailenin Cep Telefonu</label>
                                            <input type="text" id="parentMobile" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="parentHomePhone">Ailenin Ev Telefonu</label>
                                            <input type="text" id="parentHomePhone" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentEmail">Ailenin E-posta Adresi</label>
                                            <input type="email" id="parentEmail" class="form-control" placeholder="E-posta adresi giriniz...">
                                        </div>
                                    </div>
                                    <div class="urgent">
                                        <div class="row">
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z" fill="black"></path>
                                                </svg> Acil Durum Kişisi</p>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="adSoyad" class="form-label">Adı Soyadı</label>
                                                    <input type="text" class="form-control" id="adSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="telefon" class="form-label">Telefon</label>
                                                    <input type="text" class="form-control" id="telefon" placeholder="Telefon numarası giriniz...">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="yakınlıkDerecesi" class="form-label">Yakınlık
                                                        Derecesi</label>
                                                    <input type="text" class="form-control" id="yakınlıkDerecesi" placeholder="Yakınlık derecesi giriniz...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-6" data-content="6">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaBirlikte" class="form-label">Anne Baba Birlikte mi?</label>
                                            <select class="form-select" id="anneBabaBirlikte" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaSag" class="form-label">Anne Baba Sağ mı?</label>
                                            <select class="form-select" id="anneBabaSag" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
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
                                            <input type="text" class="form-control" id="babaninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninMeslegi" class="form-label">Annenin Mesleği</label>
                                            <input type="text" class="form-control" id="anneninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninTahsilDurumu" class="form-label">Babanın Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="babaninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninTahsilDurumu" class="form-label">Annenin Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="anneninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninSosyalGuvenlik" class="form-label">Babanın Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="babaninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninSosyalGuvenlik" class="form-label">Annenin Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="anneninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-7" data-content="7">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="kardesSayisi" class="form-label">Kardeş Sayısı (Siz Dahil)</label>
                                            <input type="text" class="form-control" id="kardesSayisi" placeholder="Kardeş bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="okuyanKardesSayisi" class="form-label">Okuyan Kardeş Sayısı (Siz
                                                Dahil)</label>
                                            <input type="text" class="form-control" id="okuyanKardesSayisi" placeholder="Okuyan kardeş bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 1. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 2. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-8" data-content="8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="mainIncomeProvider">Ailenin Geçimini Kim/Kimler sağlıyor?</label>
                                            <input type="text" class="form-control" id="mainIncomeProvider" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="totalDependents">Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye
                                                Bakıyor?</label>
                                            <input type="text" class="form-control" id="totalDependents" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fatherIncome">Babanın Aylık Net Geliri (TL)</label>
                                            <input type="text" class="form-control" id="fatherIncome" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="motherIncome">Annenin Aylık Net Geliri (TL)</label>
                                            <input type="text" class="form-control" id="motherIncome" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="otherIncome">Diğer kişilerin Aylık Net Geliri (TL)</label>
                                            <input type="text" class="form-control" id="otherIncome" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="additionalIncome">Ailenin Başka Geliri Var mı? (Kira vb.)</label>
                                            <input type="text" class="form-control" id="additionalIncome" placeholder="Gelir bilgisi giriniz...">
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
                                            <input type="text" class="form-control" id="rentAmount" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="additionalInfo">Diğer İse* Açıklama</label>
                                            <input type="text" class="form-control" id="additionalInfo" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="loanInfo">Kredi borcu ödüyor musunuz? Ödüyorsanız tutarı ile
                                                birlikte yazınız</label>
                                            <input type="text" class="form-control" id="loanInfo" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="employmentInfo">Herhangi bir işte çalışıyor musunuz? Evet ise
                                                çalışma şekliniz ve aylık geliriniz belirtiniz</label>
                                            <input type="text" class="form-control" id="employmentInfo" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>

                                </div>
                                <div class="step-content" id="step-9" data-content="9">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="devletBursu" class="form-label">Devlet Bursu Almakta mı ya da
                                                Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="devletBursu" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ozelBurs" class="form-label">Özel Burs Almakta mı ya da Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="ozelBurs" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursKurum" class="form-label">Burs Aldığı Kurum Adı</label>
                                            <input type="text" class="form-control" id="bursKurum" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursMiktari" class="form-label">Aldığı Burs Miktarı</label>
                                            <input type="text" class="form-control" id="bursMiktari" placeholder="Burs miktarı giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-10" data-content="10">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelDurumu" class="form-label">Herhangi bir engel durumunuz var
                                                mı?</label>
                                            <select class="form-select" id="engelDurumu" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelAciklama" class="form-label">Engel durumunu açıklayınız
                                                (varsa)</label>
                                            <input type="text" class="form-control" id="engelAciklama" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-11" data-content="11">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="haberKaynak" class="form-label">Bizden Nasıl Haberdar
                                                Oldunuz?</label>
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
                                            <label for="sosyalProjeler" class="form-label">Katkıda Bulunduğunuz Sosyal
                                                Projeler</label>
                                            <input type="text" class="form-control" id="sosyalProjeler" placeholder="Proje bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hobiler" class="form-label">Hobileriniz</label>
                                            <input type="text" class="form-control" id="hobiler" placeholder="Hobi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sporDali" class="form-label">İlgilendiğiniz Spor Dalı
                                                (Varsa)</label>
                                            <input type="text" class="form-control" id="sporDali" placeholder="Spor dalı bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kitaplar" class="form-label">Son Okuduğunuz Kitaplar</label>
                                            <input type="text" class="form-control" id="kitaplar" placeholder="Kitap adı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="mesaj" class="form-label">Bize Mesajınız</label>
                                            <textarea class="form-control" id="mesaj" rows="3" placeholder="Mesajınızı giriniz..."></textarea>
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
                                            <input type="text" class="form-control" id="hesapNumarasi" placeholder="Hesap numarası giriniz...">
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
                                        <div class="col-md-4">
                                            <div class="upload-card">
                                                <div class="documents-title-drag-drop">
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Öğrenci Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Adli Sicil Kaydı
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Vukuatlı Nufüs Kayıt Örneği
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Anne Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Baba Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Aile Mali Durum (Tapu, Araç vs.)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Engelli Raporu (Varsa)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Mektup
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Kimlik Belgesi (Ön ve Arka)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                    </div>
                </div>
                <div id="yuksekScreen" class="screen hidden">
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
                                    <div class="step-text">Belge Yükleme</div>
                                </div>
                            </div>
                            <form>
                                <div class="step-content show active" id="step-1" data-content="1">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerAdi" class="form-label">Adı</label>
                                            <input type="text" class="form-control" id="bursiyerAdi" value="Ahsen" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSoyadi" class="form-label">Soyadı</label>
                                            <input type="text" class="form-control" id="bursiyerSoyadi" value="Soyad" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
                                            <input type="text" class="form-control" id="bursiyerTcNo" value="12345678989" readonly="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerPosta" class="form-label">E-posta</label>
                                            <input type="email" class="form-control" id="bursiyerPosta" value="ahsen@ahsen.com" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursiyerSube" class="form-label">Şube</label>
                                            <input type="text" class="form-control" id="bursiyerSube" value="Şube ataması sistem tarafından yapılacaktır." readonly="">
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation1" checked="">
                                        <label class="form-check-label" for="confirmation1">
                                            Vermiş olduğum cevapların doğru olduğunu kabul ve taahhüt ederim.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmation2" checked="">
                                        <label class="form-check-label" for="confirmation2">
                                            KVKK Kurallarının gereksinimlerini kabul ederim.
                                        </label>
                                    </div>
                                </div>
                                <div class="step-content" id="step-2" data-content="2">
                                    <div class="row">
                                        <label for="day">Doğum Tarihi</label>
                                        <div class="col-md-1 mb-3">
                                            <select id="day" class="form-select">
                                                <option value="">Gün seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="month" class="form-select">
                                                <option value="">Ay seç...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <select id="year" class="form-select">
                                                <option value="">Yıl seç...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="birthCity">Doğduğu Şehir</label>
                                            <select id="birthCity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="birthDistrict">Doğduğu İlçe</label>
                                            <select id="birthDistrict" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
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
                                            <input type="text" class="form-control" id="nationality" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-3" data-content="3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="highSchool">Bitirdiğiniz Üniversite</label>
                                            <input type="text" class="form-control" id="highSchool" placeholder="Üniversite bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="graduate">Mezun Olduğunuz Üniversite</label>
                                            <select id="graduate" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="masterUniversityCity">Üniversitenin Bulunduğu Şehir</label>
                                            <select id="masterUniversityCity" class="form-select">
                                                <option value="">Seçiniz...</option>
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
                                            <label for="masterUniversityDepartment">Yüksek Lisans Yaptığınız Bölüm</label>
                                            <select id="masterUniversityDepartment" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="masterUniversityBranch">Yüksek Lisans Yaptığınız Dal</label>
                                            <select id="masterUniversityBranch" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="educationType">Öğretim Türü</label>
                                            <select id="educationType" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="year">..... - ...... Öğretim Yılda Kaçıncı Sınıfta
                                                Olacaksınız?</label>
                                            <select id="year" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="studyDuration">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor?
                                                (Hazırlık Dahil)</label>
                                            <select id="studyDuration" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="studentNumber">Öğrenci Numarası</label>
                                            <input type="text" class="form-control" id="studentNumber" placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="agnoSystem">AGNO Sisteminiz</label>
                                            <select id="agnoSystem" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="agno">AGNO</label>
                                            <input type="text" class="form-control" id="agno" placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="verticalTransfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                            <select id="verticalTransfer" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="transferDetails">Yatay/Dikey geçiş yaptıysanız* geçiş
                                                bilgileriniz</label>
                                            <input type="text" class="form-control" id="transferDetails" placeholder="Geçiş bilgilerinizi giriniz...">
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
                                            <input type="text" class="form-control" id="housingFee" placeholder="Ödenen ücret bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="livingWithCount">Birlikte Yaşanılan Kişi Sayısı</label>
                                            <input type="text" class="form-control" id="livingWithCount" placeholder="Kişi sayısı giriniz...">
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
                                            <input type="text" class="form-control" id="addressDetail" placeholder="Adres bilgisi giriniz...">
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
                                            <input type="text" id="address" class="form-control" placeholder="Adres bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentMobile">Ailenin Cep Telefonu</label>
                                            <input type="text" id="parentMobile" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="parentHomePhone">Ailenin Ev Telefonu</label>
                                            <input type="text" id="parentHomePhone" class="form-control" placeholder="Telefon numarası giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="parentEmail">Ailenin E-posta Adresi</label>
                                            <input type="email" id="parentEmail" class="form-control" placeholder="E-posta adresi giriniz...">
                                        </div>
                                    </div>
                                    <div class="urgent">
                                        <div class="row">
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z" fill="black"></path>
                                                </svg> Acil Durum Kişisi</p>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="adSoyad" class="form-label">Adı Soyadı</label>
                                                    <input type="text" class="form-control" id="adSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="telefon" class="form-label">Telefon</label>
                                                    <input type="text" class="form-control" id="telefon" placeholder="Telefon numarası giriniz...">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="yakınlıkDerecesi" class="form-label">Yakınlık
                                                        Derecesi</label>
                                                    <input type="text" class="form-control" id="yakınlıkDerecesi" placeholder="Yakınlık derecesi giriniz...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-6" data-content="6">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaBirlikte" class="form-label">Anne Baba Birlikte mi?</label>
                                            <select class="form-select" id="anneBabaBirlikte" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneBabaSag" class="form-label">Anne Baba Sağ mı?</label>
                                            <select class="form-select" id="anneBabaSag" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
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
                                            <input type="text" class="form-control" id="babaninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninMeslegi" class="form-label">Annenin Mesleği</label>
                                            <input type="text" class="form-control" id="anneninMeslegi" placeholder="Meslek bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninTahsilDurumu" class="form-label">Babanın Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="babaninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninTahsilDurumu" class="form-label">Annenin Tahsil
                                                Durumu</label>
                                            <input type="text" class="form-control" id="anneninTahsilDurumu" placeholder="Tahsil durumu giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="babaninSosyalGuvenlik" class="form-label">Babanın Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="babaninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="anneninSosyalGuvenlik" class="form-label">Annenin Bağlı Olduğu
                                                Sosyal Güvenlik
                                                Kurumu</label>
                                            <input type="text" class="form-control" id="anneninSosyalGuvenlik" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-7" data-content="7">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="kardesSayisi" class="form-label">Kardeş Sayısı (Siz Dahil)</label>
                                            <input type="text" class="form-control" id="kardesSayisi" placeholder="Kardeş bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="okuyanKardesSayisi" class="form-label">Okuyan Kardeş Sayısı (Siz
                                                Dahil)</label>
                                            <input type="text" class="form-control" id="okuyanKardesSayisi" placeholder="Okuyan kardeş bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 1. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sibling-info">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label"><i class="bi bi-person-fill"></i> 2. Kardeş
                                                    bilgileri</label>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesAdSoyad" class="form-label">Adı Soyadı</label>
                                                <input type="text" class="form-control" id="kardesAdSoyad" placeholder="Ad soyad bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesYas" class="form-label">Yaşı</label>
                                                <input type="text" class="form-control" id="kardesYas" placeholder="Yaş bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesOgrenim" class="form-label">Öğrenim Durumu</label>
                                                <input type="text" class="form-control" id="kardesOgrenim" placeholder="Öğrenim bilgisi giriniz...">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kardesMedeniDurum" class="form-label">Medeni Durum</label>
                                                <input type="text" class="form-control" id="kardesMedeniDurum" placeholder="Medeni durum bilgisi giriniz...">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="kardesMeslek" class="form-label">Mesleği (Çalışıyorsa)</label>
                                                <input type="text" class="form-control" id="kardesMeslek" placeholder="Meslek bilgisi giriniz...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-8" data-content="8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="mainIncomeProvider">Ailenin Geçimini Kim/Kimler sağlıyor?</label>
                                            <input type="text" class="form-control" id="mainIncomeProvider" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="totalDependents">Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye
                                                Bakıyor?</label>
                                            <input type="text" class="form-control" id="totalDependents" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fatherIncome">Babanın Aylık Net Geliri (TL)</label>
                                            <input type="text" class="form-control" id="fatherIncome" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="motherIncome">Annenin Aylık Net Geliri (TL)</label>
                                            <input type="text" class="form-control" id="motherIncome" placeholder="Gelir bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="otherIncome">Diğer kişilerin Aylık Net Geliri (TL)</label>
                                            <input type="text" class="form-control" id="otherIncome" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="additionalIncome">Ailenin Başka Geliri Var mı? (Kira vb.)</label>
                                            <input type="text" class="form-control" id="additionalIncome" placeholder="Gelir bilgisi giriniz...">
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
                                            <input type="text" class="form-control" id="rentAmount" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="additionalInfo">Diğer İse* Açıklama</label>
                                            <input type="text" class="form-control" id="additionalInfo" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="loanInfo">Kredi borcu ödüyor musunuz? Ödüyorsanız tutarı ile
                                                birlikte yazınız</label>
                                            <input type="text" class="form-control" id="loanInfo" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="employmentInfo">Herhangi bir işte çalışıyor musunuz? Evet ise
                                                çalışma şekliniz ve aylık geliriniz belirtiniz</label>
                                            <input type="text" class="form-control" id="employmentInfo" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>

                                </div>
                                <div class="step-content" id="step-9" data-content="9">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="devletBursu" class="form-label">Devlet Bursu Almakta mı ya da
                                                Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="devletBursu" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ozelBurs" class="form-label">Özel Burs Almakta mı ya da Başvurdu
                                                mu?</label>
                                            <input type="text" class="form-control" id="ozelBurs" placeholder="Kişi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bursKurum" class="form-label">Burs Aldığı Kurum Adı</label>
                                            <input type="text" class="form-control" id="bursKurum" placeholder="Kurum bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bursMiktari" class="form-label">Aldığı Burs Miktarı</label>
                                            <input type="text" class="form-control" id="bursMiktari" placeholder="Burs miktarı giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-10" data-content="10">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelDurumu" class="form-label">Herhangi bir engel durumunuz var
                                                mı?</label>
                                            <select class="form-select" id="engelDurumu" required="">
                                                <option selected="" disabled="">Seçiniz...</option>
                                                <option value="Evet">Evet</option>
                                                <option value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="engelAciklama" class="form-label">Engel durumunu açıklayınız
                                                (varsa)</label>
                                            <input type="text" class="form-control" id="engelAciklama" placeholder="Açıklama giriniz...">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-content" id="step-11" data-content="11">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="haberKaynak" class="form-label">Bizden Nasıl Haberdar
                                                Oldunuz?</label>
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
                                            <label for="sosyalProjeler" class="form-label">Katkıda Bulunduğunuz Sosyal
                                                Projeler</label>
                                            <input type="text" class="form-control" id="sosyalProjeler" placeholder="Proje bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hobiler" class="form-label">Hobileriniz</label>
                                            <input type="text" class="form-control" id="hobiler" placeholder="Hobi bilgisi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sporDali" class="form-label">İlgilendiğiniz Spor Dalı
                                                (Varsa)</label>
                                            <input type="text" class="form-control" id="sporDali" placeholder="Spor dalı bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kitaplar" class="form-label">Son Okuduğunuz Kitaplar</label>
                                            <input type="text" class="form-control" id="kitaplar" placeholder="Kitap adı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="mesaj" class="form-label">Bize Mesajınız</label>
                                            <textarea class="form-control" id="mesaj" rows="3" placeholder="Mesajınızı giriniz..."></textarea>
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
                                            <input type="text" class="form-control" id="hesapNumarasi" placeholder="Hesap numarası giriniz...">
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
                                        <div class="col-md-4">
                                            <div class="upload-card">
                                                <div class="documents-title-drag-drop">
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Öğrenci Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Adli Sicil Kaydı
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Vukuatlı Nufüs Kayıt Örneği
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Anne Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Baba Gelir Belgesi
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Aile Mali Durum (Tapu, Araç vs.)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Engelli Raporu (Varsa)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Mektup
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                        </svg> Kimlik Belgesi (Ön ve Arka)
                                                    </p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                    </svg>
                                                </div>
                                                <div class="file-drag-drop-area">
                                                    <input type="file" id="file-upload" hidden="">
                                                    <label for="file-upload" class="file-label">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM13 12H16L12 8L8 12H11V16H13V12Z" fill="#0065FF"></path>
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
                    </div>
                </div>
            </div>
             <div class="transfer-modal-footer d-flex justify-content-end g-3">
                <button type="button" class="btn cancel-button" id="prevStep">Vazgeç</button>
                <button style="display: none;" type="button" class="btn btn-outline-primary next-button" id="prevButton">Önceki</button>
                <button type="button" class="btn btn-primary next-button" id="nextStep">Sonraki</button>
                <button style="display: none;" type="button" class="btn btn-primary next-button" id="completeButton">Tamamla</button>
            </div>
        </div>-->
        <!-- Modal Alanı -->
        <!-- Burs Başvurusu Başarılı Modalı -->
        <div class="modal fade" id="scholarshipCompletionModal" tabindex="-1"
             aria-labelledby="scholarshipCompletionModalLabel" aria-hidden="true">
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
                        <h5 class="mt-3">Burs başvurunuzu başarıyla tamamladınız.</h5>
                        <p>Süreçle ilgili SMS ve E-posta yolu ile bilgilendirileceksiniz.</p>
                        <button type="button" id="modalCloseButton" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
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
        <script src="{{url('public')}}/assets/js/student-applications.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const employmentStatus = document.getElementById("employment-status");
                const employmentDetails = document.getElementById("employment-details");

                employmentStatus.addEventListener("change", function () {
                    if (this.value === "full-time" || this.value === "part-time" || this.value === "intern") {
                        employmentDetails.classList.remove("hidden");
                    } else {
                        employmentDetails.classList.add("hidden");
                    }
                });
            });
        </script>
                        @include('includes.js.sidebar')

@endsection
