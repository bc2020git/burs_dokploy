<!-- Burs Başvurusu Başarılı Modalı -->
<div class="modal fade" id="scholarshipCompletionModal" tabindex="-1"
     aria-labelledby="scholarshipCompletionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <path d="M7.66406 0.666992C5.80755 0.666992 4.02707 1.40449 2.71431 2.71724C1.40156 4.03 0.664062 5.81048 0.664062 7.66699V14.667C0.664062 15.9557 1.70873 17.0003 2.9974 17.0003C4.28606 17.0003 5.33073 15.9557 5.33073 14.667V7.66699C5.33073 7.04815 5.57656 6.45466 6.01415 6.01708C6.45173 5.57949 7.04522 5.33366 7.66406 5.33366H14.6641C15.9527 5.33366 16.9974 4.28899 16.9974 3.00033C16.9974 1.71166 15.9527 0.666992 14.6641 0.666992H7.66406Z" fill="#2D3648"/>
                        <path d="M33.3307 0.666992C32.0421 0.666992 30.9974 1.71166 30.9974 3.00033C30.9974 4.28899 32.0421 5.33366 33.3307 5.33366H40.3307C40.9496 5.33366 41.5431 5.57949 41.9806 6.01708C42.4182 6.45466 42.6641 7.04815 42.6641 7.66699V14.667C42.6641 15.9557 43.7087 17.0003 44.9974 17.0003C46.2861 17.0003 47.3307 15.9557 47.3307 14.667V7.66699C47.3307 5.81048 46.5932 4.03 45.2805 2.71724C43.9677 1.40449 42.1872 0.666992 40.3307 0.666992H33.3307Z" fill="#2D3648"/>
                        <path d="M5.33073 33.3337C5.33073 32.045 4.28606 31.0003 2.9974 31.0003C1.70873 31.0003 0.664062 32.045 0.664062 33.3337V40.3337C0.664062 42.1902 1.40156 43.9706 2.71431 45.2834C4.02707 46.5962 5.80755 47.3337 7.66406 47.3337H14.6641C15.9527 47.3337 16.9974 46.289 16.9974 45.0003C16.9974 43.7117 15.9527 42.667 14.6641 42.667H7.66406C7.04523 42.667 6.45173 42.4212 6.01415 41.9836C5.57656 41.546 5.33073 40.9525 5.33073 40.3337V33.3337Z" fill="#2D3648"/>
                        <path d="M47.3307 33.3337C47.3307 32.045 46.2861 31.0003 44.9974 31.0003C43.7087 31.0003 42.6641 32.045 42.6641 33.3337V40.3337C42.6641 40.9525 42.4182 41.546 41.9806 41.9836C41.5431 42.4212 40.9496 42.667 40.3307 42.667H33.3307C32.0421 42.667 30.9974 43.7117 30.9974 45.0003C30.9974 46.289 32.0421 47.3337 33.3307 47.3337H40.3307C42.1872 47.3337 43.9677 46.5962 45.2805 45.2834C46.5932 43.9707 47.3307 42.1902 47.3307 40.3337V33.3337Z" fill="#2D3648"/>
                    </svg>
                    <svg class="confirm-icon" xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29" fill="none">
                        <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A"/>
                        <rect x="1" y="1" width="28" height="27" rx="9" stroke="white" stroke-width="2"/>
                        <path d="M10.5369 13.1696C9.77786 12.4358 8.54714 12.4358 7.78806 13.1696C7.02898 13.9034 7.02898 15.093 7.78806 15.8268L11.6756 19.5847C12.4346 20.3185 13.6654 20.3185 14.4244 19.5847L22.1994 12.0689C22.9585 11.3351 22.9585 10.1454 22.1994 9.41166C21.4404 8.67788 20.2096 8.67788 19.4506 9.41166L13.05 15.5989L10.5369 13.1696Z" fill="white"/>
                    </svg>
                </div>
                <h5 class="mt-3">Burs başvurunuzu başarıyla tamamladınız.</h5>
                <p>Süreçle ilgili SMS ve E-posta yolu ile bilgilendirileceksiniz.</p>
                <button type="button" onclick="completeScholarshipApplication();" id="modalCloseButton" class="btn btn-primary"
                        data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
<!-- Kardeş Ekle Modal -->
<div class="modal fade" id="kardesEkleModal" tabindex="-1" aria-labelledby="kardesEkleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
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
                            <input type="number" class="form-control" id="kardesYasi" placeholder="Yaş giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                            <select class="form-select" id="kardesOgrenimDurumu" required>
                                <option  selected disabled>Seçiniz...</option>
                                <option>Okumuyor</option>
                                <option>Okul Öncesi</option>
                                <option>İlkokul</option>
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
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="text-center">
                <h5 class="modal-title mb-3" id="bursEkleModalLabel">Burs Ekle</h5>
                <p>Burs bilgilerini giriniz.</p>
                <span>Ekle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
            </div>
            <div class="modal-body">
                <form id="addBursForm">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kurumAdi" class="form-label">Burs Aldığınız Kurum Adı</label>
                            <input type="text" class="form-control" id="burskurumAdi"
                                   placeholder="Kurum adı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kurumTuru" class="form-label">Kurum Türü</label>
                            <select class="form-select" id="kurumTuru" required>
                                <option selected disabled>Seçiniz...</option>
                                <option value="Devlet">Devlet</option>
                                <option value="Özel">Özel</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                            <input type="text" class="form-control" id="bursMıktarı" placeholder="Örnek Burs Tutarı: 1000">
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
                            <label for="kurumAdi" class="form-label">Burs Aldığınız Kurum Adı</label>
                            <input type="text" class="form-control" id="kurumAdi" placeholder="Kurum adı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kurumTuru" class="form-label">Kurum Türü</label>
                            <select class="form-select" id="kurumTuru" required>
                                <option disabled>Seçiniz...</option>
                                <option value="Devlet">Devlet</option>
                                <option value="Özel">Özel</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                            <input type="text" class="form-control" id="bursMıktarı" placeholder="Örnek Burs Tutarı: 1000">
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
<!--
KVKK Modal
<div class="modal modal-lg fade" id="kvkkModal" tabindex="-1" role="dialog" aria-labelledby="kvkkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center">
                <h5 class="modal-title" id="kvkkModalLabel">KVKK Kuralları</h5>
            </div>
            <div class="modal-body p-5">
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
taahhutname Modal
<div class="modal modal-lg fade" id="taahutnamemodal" tabindex="-1" role="dialog" aria-labelledby="taahutnamemodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center">
                <h5 class="modal-title" id="taahutnamemodalLabel"><div class=" text-center wp-block-group__inner-container">
<h4 class="has-text-align-center"><strong>TAAHHÜTNAME</strong></h4>
<h4 class="has-text-align-center"><strong>SÜREYYA AĞAOĞLU ÇOCUK DOSTLARI DERNEĞİ</strong></h4>
<h4 class="has-text-align-center"><strong>VE</strong></h4>
<h4 class="has-text-align-center"><strong>SÜREYYA AĞAOĞLU EĞİTİM ve ÖĞRETİM VAKFINA</strong> </h4>
</div></h5>
            </div>
            <div class="modal-body text-center p-5">
[{universite}] Üniversitesi [{bolum}] Bölümünde kayıtlı [{ogrenci_no}] numaralı öğrenci [{isim}] olarak,

Burs ve eğitim yardımlarından yararlanabilmek için maddi olanaklarımın yetersiz olduğunu yönünde beyan vermiş bulunduğumu,
Ailemin ve benim gerçek mal varlığı ve gelir durumuna ilişkin belge ve bilgilerin doğruluğunu, bilgilerde herhangi bir değişiklik olması halinde zaman kaybetmeden belgeleriyle birlikte kurumu bilgilendireceğimi,
Eksik, yanlış ve/veya yanıltıcı bilgi verme ya da beyanda bulunmamın tespiti halinde tarafıma yapılan ödemenin tamamının geri ödeneceğini peşinen kabul ettiğimi, aksi halde Vakıf/Dernek tarafından yasal yollara başvurulabileceğini bildiğimi,
Bursun bir öğretim yılı için (9 ay) tahsis edildiğini, Vakıf/Dernek Yönetim Kurulunca burs ödemelerinin aynı öğretim yılı içerisinde hiçbir gerekçe göstermeksizin durdurulabileceğini, bursun ödenmesinin devamlılığının Vakıf/Dernek gelirlerine ve Yönetim Kurulunca saptanan başarı düzeyini sürdürmeme bağlı olduğunu,
Ara dönem ve yeni dönem için talep edilen belgeleri Vakıf/Dernek tarafından bildirilen sürede eksiksiz olarak sisteme yükleyeceğimi,
Vakıf/Dernek tarafından gerekli görülen hallerde başvuru formundaki bilgi ve belgelerin araştırılabileceğini,
Belirli dönemlerde talep edilen başarı belgelerini Vakıf/Derneğe gerekli süre içinde ulaştırmamam, kayıt dondurmam, disiplin cezası almam, hüküm giymem, ilgili yükümlülüklerimi yerine getirmemem halinde bursumun kesileceğini ve gerekirse o tarihe kadar yapılan tüm ödemelerin tahsilatı için yasal yollara başvurularak geri istenebileceğini,
Öğrenim süremin uzaması halinde bursumun kesileceği konusunda bilgi sahibi olduğumu,
Üniversitede öğrenim görürken yeniden sınava girerek yeni bir ana dala devam etmem halinde eski ana daldan kalan süre kadar burs verileceğini,
Yıl kaybetmeden yatay geçiş yapmam halinde bursumun devam edeceğini, yıl veya dönem kaybedersem yatay geçiş öncesindeki süre kadar burs alabileceğimi,
Okul değişikliği, bölüm değişikliği, kayıt dondurma, öğrenime devam edememe, geçici olarak yurtdışına çıkma, adres, telefon, e-mail adresi değişikliği vb. her değişikliği derhal Vakıf/ Derneğe bildireceğimi,
Burs koşullarına aykırı hareket ettiğim takdirde hakkımda yapılacak her türlü işlemin sorumluluğunu aldığımı, böyle bir durumda aldığım toplam burs tutarını tahsis tarihinden itibaren işlemiş yasal faizi ile birlikte Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı/ Süreyya Ağaoğlu Çocuk Dostları Derneği’nin ilk yazılı talebini takiben 7 gün içinde ödeyeceğimi, ödememe halinde her türlü icra, dava masrafları vekalet ücretleri ile işleyecek faizleri ve sair tüm giderlerden sorumlu olacağımı
kabul, beyan ve taahhüt ederim.

Tarih : 30/08/2024

Adı ve Soyadı : [{isim}]

T.C Kimlik No : [{tc_no}]

İmza :

            </div>
             <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
      </div>
        </div>
    </div>
</div>
bursiyer acik riza formu Modal
<div class="modal modal-lg fade" id="bursiyeracikrizamodal" tabindex="-1" role="dialog" aria-labelledby="bursiyeracikrizamodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center">
<h4 class="has-text-align-center"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong><br><strong>Bursiyer Açık Rıza Formu</strong>&nbsp;</h4>
            </div>
            <div class="modal-body text-center p-5">


                                                                    <div class="wp-block-group__inner-container">
</div></div>

<p>İşbu Açık Rıza Formu, 6698 sayılı Kişisel Verilerin Korunması Kanunu [“Kanun”] md.10 uyarınca, veri sorumlusu sıfatıyla Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı [“SAEÖV”] tarafından burs başvurusunda bulunan ve/veya burs başvurusu kabul edilen bursiyerlerin özel nitelikli kişisel verilerinin işlenmesine ilişkin rıza alınmasına ilişkindir.</p>

<p>Vakıf bünyesinde bulunan şahsıma ait her türlü kişisel verinin Kanun ve sair mevzuat kapsamında öngörülen düzenlemelere tâbi olduğunu ve bu hususta Vakıf’ın tarafıma, Kanun kapsamındaki haklarımla ilgili olarak tam ve açık bir bilgilendirme yaptığını kabul ve beyan ederim.&nbsp;</p>

<p>Bu kapsamda, “6698 sayılı Kanun Uyarınca Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı Bursiyer Aydınlatma Metni” içeriğinde açıklandığı üzere, SAEÖV tarafından kişisel verilerin korunması mevzuatı çerçevesinde Kanun ve ikincil mevzuatlarından doğan ve bahse konu mevzuat çerçevesinde kurduğumuz hukuki ilişkideki bursun tarafıma ifa edilmesi kapsamında en iyi hizmeti verebilmek amacıyla, dernek ve/veya vakıf üyeliklerimin ve bedensel engellilik durum ile kimlik görüntüsünün alınması nedeniyle kan grubu gibi sağlık verilerim başta olmak üzere özel nitelikli kişisel verilerimin işlenmesine muvafakat ediyorum.</p>

<p><strong>Tarih:&nbsp;</strong> <span class="add_date">30/08/2024</span></p>

<p><strong>İsim:</strong> <span class="add_name">[{isim}]</span></p>

<p><strong>İmza</strong>: <span class="add_imza_bursiyer">[{imza}]</span></p>
              </div>

            </div>
             <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
      </div>
        </div>
 bursiyer aile bireyleri acik riza formu Modal
<div class="modal modal-lg fade" id="bursiyerailebireyleririzamodal" tabindex="-1" role="dialog" aria-labelledby="bursiyerailebireyleririzamodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-center">
<h4 class="has-text-align-center"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong><br><strong>Bursiyer Açık Rıza Formu</strong>&nbsp;</h4>
            </div>
            <div class="modal-body text-center p-5">


                                                                    <div class="wp-block-group__inner-container">
</div></div>

<p>İşbu Açık Rıza Formu, 6698 sayılı Kişisel Verilerin Korunması Kanunu [“Kanun”] md.10 uyarınca, veri sorumlusu sıfatıyla Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı [“SAEÖV”] tarafından burs başvurusunda bulunan ve/veya burs başvurusu kabul edilen bursiyerlerin özel nitelikli kişisel verilerinin işlenmesine ilişkin rıza alınmasına ilişkindir.</p>

<p>Vakıf bünyesinde bulunan şahsıma ait her türlü kişisel verinin Kanun ve sair mevzuat kapsamında öngörülen düzenlemelere tâbi olduğunu ve bu hususta Vakıf’ın tarafıma, Kanun kapsamındaki haklarımla ilgili olarak tam ve açık bir bilgilendirme yaptığını kabul ve beyan ederim.&nbsp;</p>

<p>Bu kapsamda, “6698 sayılı Kanun Uyarınca Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı Bursiyer Aydınlatma Metni” içeriğinde açıklandığı üzere, SAEÖV tarafından kişisel verilerin korunması mevzuatı çerçevesinde Kanun ve ikincil mevzuatlarından doğan ve bahse konu mevzuat çerçevesinde kurduğumuz hukuki ilişkideki bursun tarafıma ifa edilmesi kapsamında en iyi hizmeti verebilmek amacıyla, dernek ve/veya vakıf üyeliklerimin ve bedensel engellilik durum ile kimlik görüntüsünün alınması nedeniyle kan grubu gibi sağlık verilerim başta olmak üzere özel nitelikli kişisel verilerimin işlenmesine muvafakat ediyorum.</p>

<p><strong>Tarih:&nbsp;</strong> <span class="add_date">30/08/2024</span></p>

<p><strong>İsim:</strong> <span class="add_name">[{isim}]</span></p>

<p><strong>İmza</strong>: <span class="add_imza_bursiyer">[{imza}]</span></p>
              </div>

            </div>
             <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
      </div>
        </div>
-->
