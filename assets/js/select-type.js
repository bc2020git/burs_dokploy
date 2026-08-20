document.addEventListener('DOMContentLoaded', function () {
    const okulTipiSelect = document.getElementById('okul-tipi');
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
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="okulAdiIlkokul">İlkokulunuzun Adı</label>
                    <input type="text" class="form-control" id="okulAdiIlkokul" placeholder="Okul adınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="okulunSehriIlkokul">İlkokulunuzun Bulunduğu Şehir</label>
                    <input type="text" class="form-control" id="okulunSehriIlkokul" placeholder="Okulun bulunduğu şehri giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="okulunIlcesiIlkokul">İlkokulunuzun Bulunduğu İlçe</label>
                    <input type="text" class="form-control" id="okulunIlcesiIlkokul" placeholder="Okulun bulunduğu ilçeyi giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="sinifinizIlkokul">Sınıfınız</label>
                    <input type="text" class="form-control" id="sinifinizIlkokul" placeholder="Sınıfınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ogrNoIlkokul">Öğrenci Numarası</label>
                    <input type="text" class="form-control" id="ogrNoIlkokul" placeholder="Öğrenci numaranızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="nakilIlkokul">Nakil Yaptı Mı?</label>
                    <input type="text" class="form-control" id="nakilIlkokul" placeholder="Evet/Hayır">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="notOrtIlkokul">Not Ortalaması</label>
                    <input type="text" class="form-control" id="notOrtIlkokul" placeholder="Not ortalaması giriniz...">
                </div>
            </div>
        `;
    }

    function addOrtaokulSorulari(container) {
        container.innerHTML = `
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ilkokulAdiOrtaokul">İlkokulunuzun Adı</label>
                    <input type="text" class="form-control" id="okulAdiOrtaokul" placeholder="Okul adınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ilkokulunSehriOrtaokul">İlkokulunuzun Bulunduğu Şehir</label>
                    <input type="text" class="form-control" id="okulunSehriOrtaokul" placeholder="Okulun bulunduğu şehri giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ilkokulunIlcesiOrtaokul">İlkokulunuzun Bulunduğu İlçe</label>
                    <input type="text" class="form-control" id="okulunIlcesiOrtaokul" placeholder="Okulun bulunduğu ilçeyi giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="okulAdiOrtaokul">Ortaokulunuzun Adı</label>
                    <input type="text" class="form-control" id="okulAdiOrtaokul" placeholder="Okul adınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="okulunSehriOrtaokul">Ortaokulunuzun Bulunduğu Şehir</label>
                    <input type="text" class="form-control" id="okulunSehriOrtaokul" placeholder="Okulun bulunduğu şehri giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="okulunIlcesiOrtaokul">Ortaokulunuzun Bulunduğu İlçe</label>
                    <input type="text" class="form-control" id="okulunIlcesiOrtaokul" placeholder="Okulun bulunduğu ilçeyi giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="sinifinizOrtaokul">Sınıfınız</label>
                    <input type="text" class="form-control" id="sinifinizOrtaokul" placeholder="Sınıfınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ogrNoOrtaokul">Öğrenci Numarası</label>
                    <input type="text" class="form-control" id="ogrNoOrtaokul" placeholder="Öğrenci numaranızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="nakilOrtaokul">Nakil Yaptı Mı?</label>
                    <input type="text" class="form-control" id="nakilOrtaokul" placeholder="Evet/Hayır">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="notOrtOrtaokul">Not Ortalaması</label>
                    <input type="text" class="form-control" id="notOrtOrtaokul" placeholder="Not ortalaması giriniz...">
                </div>
            </div>
        `;
    }

    function addLiseSorulari(container) {
        container.innerHTML = `
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="okulAdiLise">Lisenizin Adı</label>
                    <input type="text" class="form-control" id="okulAdiLise" placeholder="Okul adınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="okulunSehriLise">Lisenizin Bulunduğu Şehir</label>
                    <input type="text" class="form-control" id="okulunSehriLise" placeholder="Okulun bulunduğu şehri giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="okulunIlcesiLise">Lisenizin Bulunduğu İlçe</label>
                    <input type="text" class="form-control" id="okulunIlcesiLise" placeholder="Okulun bulunduğu ilçeyi giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="sinifinizLise">Sınıfınız</label>
                    <input type="text" class="form-control" id="sinifinizLise" placeholder="Sınıfınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ogrNoLise">Öğrenci Numarası</label>
                    <input type="text" class="form-control" id="ogrNoLise" placeholder="Öğrenci numaranızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="nakilLise">Nakil Yaptı Mı?</label>
                    <input type="text" class="form-control" id="nakilLise" placeholder="Evet/Hayır">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="notOrtLise">Not Ortalaması</label>
                    <input type="text" class="form-control" id="notOrtLise" placeholder="Not ortalaması giriniz...">
                </div>
            </div>
        `;
    }

    function addOnlisansSorulari(container) {
        container.innerHTML = `
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniGirisTarihiOnLisans">Üniversiteye Giriş Tarihi</label>
                    <input type="date" class="form-control" id="üniGirisTarihiOnLisans" placeholder="Giriş tarihinizi giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniSehirOnLisans">Üniversitenin Bulunduğu Şehir</label>
                    <input type="text" class="form-control" id="üniSehirOnLisans" placeholder="Üniversitenin bulunduğu şehri giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniFakulteOnLisans">Fakülte</label>
                    <input type="text" class="form-control" id="üniFakulteOnLisans" placeholder="Fakültenizi giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniBolumOnLisans">Bölüm</label>
                    <input type="text" class="form-control" id="üniBolumOnLisans" placeholder="Bölümünüzü giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="sinifOnLisans">Sınıfınız</label>
                    <input type="text" class="form-control" id="sinifOnLisans" placeholder="Sınıfınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ogrNoOnLisans">Öğrenci Numarası</label>
                    <input type="text" class="form-control" id="ogrNoOnLisans" placeholder="Öğrenci numaranızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="bitenLiseOnLisans">Bitirdiğiniz Lise</label>
                    <input type="text" class="form-control" id="bitenLiseOnLisans" placeholder="Bitirdiğiniz lisenin adınız giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniGirisPuanıOnLisans">Üniversiteye Giriş Puanınız</label>
                    <input type="text" class="form-control" id="uniGirisPuanıOnLisans" placeholder="Giriş puanınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniAdiOnLisans">Öğrenime Devam Ettiğiniz Üniversite</label>
                    <input type="text" class="form-control" id="uniAdiOnLisans" placeholder="Öğrenime devam ettiğiniz üniversite adını giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniTurOnLisans">Üniversite Türü</label>
                    <input type="text" class="form-control" id="uniTurOnLisans" placeholder="Üniversite türünü giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="egitimSenesiOnLisans">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                    <input type="text" class="form-control" id="egitimSenesiOnLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="agnoSistemOnLisans">AGNO Sisteminiz</label>
                    <input type="text" class="form-control" id="agnoSistemOnLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="agnoOnLisans">AGNO</label>
                    <input type="text" class="form-control" id="agnoOnLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="gecisYaptiMiOnLisans">Yatay-Dikey Geçiş Yaptı Mı?</label>
                    <input type="text" class="form-control" id="gecisYaptiMiOnLisans" placeholder="Evet/Hayır">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="gecisBilgileriOnLisans">Yatay-Dikey Geçiş Yaptıysanız Geçiş Bilgileri</label>
                    <input type="text" class="form-control" id="gecisBilgileriOnLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-12 form-group">
                    <label class="custom-label" for="dilBilgileriOnLisans">Bildiğiniz Diller Nelerdir Seviyeleri ile birlikte yazınız</label>
                    <input type="text" class="form-control" id="dilBilgileriOnLisans" placeholder="Giriniz...">
                </div>
            </div>
        `;
    }

    function addLisansSorulari(container) {
        container.innerHTML = `
             <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniGirisTarihiLisans">Üniversiteye Giriş Tarihi</label>
                    <input type="date" class="form-control" id="üniGirisTarihiLisans" placeholder="Giriş tarihinizi giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniSehirLisans">Üniversitenin Bulunduğu Şehir</label>
                    <input type="text" class="form-control" id="üniSehirLisans" placeholder="Üniversitenin bulunduğu şehri giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniFakulteLisans">Fakülte</label>
                    <input type="text" class="form-control" id="üniFakulteLisans" placeholder="Fakültenizi giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniBolumLisans">Bölüm</label>
                    <input type="text" class="form-control" id="üniBolumLisans" placeholder="Bölümünüzü giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="sinifLisans">Sınıfınız</label>
                    <input type="text" class="form-control" id="sinifLisans" placeholder="Sınıfınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ogrNoLisans">Öğrenci Numarası</label>
                    <input type="text" class="form-control" id="ogrNoLisans" placeholder="Öğrenci numaranızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="bitenLiseLisans">Bitirdiğiniz Lise</label>
                    <input type="text" class="form-control" id="bitenLiseLisans" placeholder="Bitirdiğiniz lisenin adınız giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniGirisPuanıLisans">Üniversiteye Giriş Puanınız</label>
                    <input type="text" class="form-control" id="uniGirisPuanıLisans" placeholder="Giriş puanınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniAdiLisans">Öğrenime Devam Ettiğiniz Üniversite</label>
                    <input type="text" class="form-control" id="uniAdiLisans" placeholder="Öğrenime devam ettiğiniz üniversite adını giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniTurLisans">Üniversite Türü</label>
                    <input type="text" class="form-control" id="uniTurLisans" placeholder="Üniversite türünü giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="egitimSenesiLisans">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                    <input type="text" class="form-control" id="egitimSenesiLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="agnoSistemLisans">AGNO Sisteminiz</label>
                    <input type="text" class="form-control" id="agnoSistemLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="agnoLisans">AGNO</label>
                    <input type="text" class="form-control" id="agnoLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="gecisYaptiMiLisans">Yatay-Dikey Geçiş Yaptı Mı?</label>
                    <input type="text" class="form-control" id="gecisYaptiMiLisans" placeholder="Evet/Hayır">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="gecisBilgileriLisans">Yatay-Dikey Geçiş Yaptıysanız Geçiş Bilgileri</label>
                    <input type="text" class="form-control" id="gecisBilgileriLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="gecisBilgileriLisans">Yatay-Dikey Geçiş Yaptıysanız Geçiş Bilgileri</label>
                    <input type="text" class="form-control" id="gecisBilgileriLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-12 form-group">
                    <label class="custom-label" for="dilBilgileriLisans">Bildiğiniz Diller Nelerdir Seviyeleri ile birlikte yazınız</label>
                    <input type="text" class="form-control" id="dilBilgileriLisans" placeholder="Giriniz...">
                </div>
            </div>
        `;
    }

    function addYuksekLisansSorulari(container) {
        container.innerHTML = `
             <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniSehirYuksekLisans">Üniversitenin Bulunduğu Şehir</label>
                    <input type="text" class="form-control" id="üniSehirYuksekLisans" placeholder="Üniversitenin bulunduğu şehri giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="sinifYuksekLisans">Sınıfınız</label>
                    <input type="text" class="form-control" id="sinifYuksekLisans" placeholder="Sınıfınızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ogrNoYuksekLisans">Öğrenci Numarası</label>
                    <input type="text" class="form-control" id="ogrNoYuksekLisans" placeholder="Öğrenci numaranızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="mezunUniAdiYuksekLisans">Mezun Olduğunuz Üniversite</label>
                    <input type="text" class="form-control" id="mezunUniAdiYuksekLisans" placeholder="Mezun olduğunuz üniversitenin adınız giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="mezunBolumAdiYuksekLisans">Mezun Olduğunuz Bölüm</label>
                    <input type="text" class="form-control" id="mezunBolumAdiYuksekLisans" placeholder="Mezun olduğunuz bölümün adınız giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="agnoSistemYuksekLisans">AGNO Sisteminiz</label>
                    <input type="text" class="form-control" id="agnoSistemYuksekLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="mezuniyetAgnoYuksekLisans">Mezuniyet AGNO</label>
                    <input type="text" class="form-control" id="mezuniyetAgnoYuksekLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniAdiYuksekLisans">Yüksek Lisans Yaptığınız Üniversite</label>
                    <input type="text" class="form-control" id="uniAdiYuksekLisans" placeholder="Öğrenime devam ettiğiniz üniversite adını giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniEnstitüYuksekLisans">Yüksek Lisans Yaptığınız Enstitü</label>
                    <input type="text" class="form-control" id="uniEnstitüYuksekLisans" placeholder="Enstitü adını giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniBolumYuksekLisans">Yüksek Lisans Yaptığınız Bölüm</label>
                    <input type="text" class="form-control" id="uniBolumYuksekLisans" placeholder="Bölüm adını giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniDalYuksekLisans">Yüksek Lisans Yaptığınız Dal</label>
                    <input type="text" class="form-control" id="uniDalYuksekLisans" placeholder="Dal adını giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniTurYuksekLisans">Üniversite Türü</label>
                    <input type="text" class="form-control" id="uniTurYuksekLisans" placeholder="Üniversite türünü giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="egitimSenesiYuksekLisans">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                    <input type="text" class="form-control" id="egitimSenesiYuksekLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="gecisYaptiMiYuksekLisans">Yatay-Dikey Geçiş Yaptı Mı?</label>
                    <input type="text" class="form-control" id="gecisYaptiMiYuksekLisans" placeholder="Evet/Hayır">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="gecisBilgileriYuksekLisans">Yatay-Dikey Geçiş Yaptıysanız Geçiş Bilgileri</label>
                    <input type="text" class="form-control" id="gecisBilgileriYuksekLisans" placeholder="Giriniz...">
                </div>
                <div class="col-md-12 form-group">
                    <label class="custom-label" for="dilBilgileriYuksekLisans">Bildiğiniz Diller Nelerdir Seviyeleri ile birlikte yazınız</label>
                    <input type="text" class="form-control" id="dilBilgileriYuksekLisans" placeholder="Giriniz...">
                </div>
            </div>
        `;
    }

    function addDoktoraSorulari(container) {
        container.innerHTML = `
             <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="üniSehirDoktora">Üniversitenin Bulunduğu Şehir</label>
                    <input type="text" class="form-control" id="üniSehirDoktora" placeholder="Üniversitenin bulunduğu şehri giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="ogrNoDoktora">Öğrenci Numarası</label>
                    <input type="text" class="form-control" id="ogrNoDoktora" placeholder="Öğrenci numaranızı giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="mezunUniAdiDoktora">Mezun Olduğunuz Üniversite</label>
                    <input type="text" class="form-control" id="mezunUniAdiDoktora" placeholder="Mezun olduğunuz üniversitenin adınız giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="mezunBolumAdiDoktora">Mezun Olduğunuz Bölüm</label>
                    <input type="text" class="form-control" id="mezunBolumAdiDoktora" placeholder="Mezun olduğunuz bölümün adınız giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="mezuniyetAgnoDoktora">Mezuniyet AGNO</label>
                    <input type="text" class="form-control" id="mezuniyetAgnoDoktora" placeholder="Giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniTurDoktora">Üniversite Türü</label>
                    <input type="text" class="form-control" id="uniTurDoktora" placeholder="Üniversite türünü giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniAdiDoktora">Doktora Yaptığınız Üniversite</label>
                    <input type="text" class="form-control" id="uniAdiDoktora" placeholder="Öğrenime devam ettiğiniz üniversite adını giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniBolumDoktora">Doktora Yaptığınız Bölüm</label>
                    <input type="text" class="form-control" id="uniBolumDoktora" placeholder="Bölüm adını giriniz...">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label" for="uniDalDoktora">Doktora Yaptığınız Dal</label>
                    <input type="text" class="form-control" id="uniDalDoktora" placeholder="Dal adını giriniz...">
                </div>
                <div class="col-md-12 form-group">
                    <label class="custom-label" for="dilBilgileriDoktora">Bildiğiniz Diller Nelerdir Seviyeleri ile birlikte yazınız</label>
                    <input type="text" class="form-control" id="dilBilgileriDoktora" placeholder="Giriniz...">
                </div>
            </div>
        `;
    }
});
