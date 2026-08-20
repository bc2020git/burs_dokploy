<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('message_templates')->truncate();
        DB::table('message_templates')->insert(array (
  0 => 
  array (
    'id' => 1,
    'title' => 'Aday Onaylandi',
    'slug' => 'aday-onaylandi',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div><font color="#ffffff">Bursa hak kazandığınız için sizi kutlar, kurumumuza gösterdiğiniz ilgiden dolayı teşekkür ederiz.<br><br>Bursiyer bilgi takip sistemimizde sizin için profil sayfası oluşturulmuştur. Profil sayfanıza giriş bilgileriniz burs başvurusu yaptığınızda tarafınıza gönderilen e-postada yer almaktadır. Bursunuzla ilgili tüm bilgiler, daha sonra e-posta adresinize gönderilecektir.<br><br>Yeni eğitim ve öğretim döneminde başarılar dileriz.&nbsp;<br><br>Sevgilerimizle,<br><br><b>Süreyya Ağaoğlu Çocuk Dostları Derneği<br>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</b><br><br></font>',
    'parameters' => '["name","surname"]',
    'created_at' => '2025-07-28 23:06:36',
    'updated_at' => '2025-08-24 00:31:49',
  ),
  1 => 
  array (
    'id' => 2,
    'title' => 'Aday Reddedildi',
    'slug' => 'aday-reddedildi',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Burs başvurunuz olumsuz sonuçlanmıştır.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Eğitim hayatınızda başarılar dileriz.<br><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><b>Açıklama:</b><br>_aciklama_</font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Sevgilerimizle,</span></font></p><font color="#ffffff"><br></font><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-26 02:12:57',
  ),
  2 => 
  array (
    'id' => 3,
    'title' => 'Mülakat Güncellendi Mesajı',
    'slug' => 'mulakat-guncellendi-mesaji',
    'content' => '<p><font color="#ffffff">Sayın&nbsp;_name_&nbsp;_surname_</font></p><p><font color="#ffffff">Mülakat tarihiniz güncellenmiştir. Güncel bilgiler aşağıda verilmektedir.<br></font><font style="background-color: rgb(255, 255, 0);" color="#000000"><b>Lütfen en kısa sürede katılım durumunuzu info@sacdd.org.tr mail üzerinden yazılı olarak bildiriniz.</b></font></p><p><font style="background-color: rgb(255, 255, 0);" color="#000000"><b><br></b></font></p><p><font color="#ffffff">Mülakat Bilgileri:</font></p><p><font color="#ffffff">Mülakat Tarihi:&nbsp;_interview_date_</font></p><p><font color="#ffffff">Mülakat Saati:&nbsp;_interview_time_</font></p><p><font color="#ffffff">Mülakat Tipi:&nbsp;_interview_type_</font></p><p><font color="#ffffff">Mülakat Adresi :&nbsp;_interview_address_</font></p><p><font color="#ffffff"><br></font></p><p><font color="#ffffff">Başvuru sonuçlarının açıklanacağı tarih web sitemizde duyurulacaktır.</font></p><p><font color="#ffffff"><br>Sevgilerimizle.&nbsp;</font></p><p><font color="#ffffff">Süreyya Ağaoğlu Çocuk Dostları Derneği</font></p><p><font color="#ffffff">Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</font></p><p><font color="#ffffff"><br><br></font></p>',
    'parameters' => '["name","surname","interview_date","interview_time","interview_type","interview_address"]',
    'created_at' => '2025-07-29 22:33:55',
    'updated_at' => '2025-08-24 00:28:25',
  ),
  3 => 
  array (
    'id' => 4,
    'title' => 'Mülakat Onaylandı Mesajı',
    'slug' => 'mulakat-onaylandi-mesaji',
    'content' => '<p><font color="#ffffff">Sayın&nbsp;_name_&nbsp;_surname_</font></p><p><font color="#ffffff">Mülakatınız sonucunuz olumludur. Başvurunuzun değerlendirme süreci devam etmektedir.</font></p><font color="#ffffff">Başvuru sonuçlarının açıklanacağı tarih web sitemizde duyurulacaktır.<br><br>Eğitim hayatınızda başarılar dileriz.<br><br>Sevgilerimizle,<br><br>Süreyya Ağaoğlu Çocuk Dostları Derneği<br>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</font><p><font color="#ffffff"><br></font></p>',
    'parameters' => '["name","surname","interview_date","interview_time","interview_type"]',
    'created_at' => '2025-07-29 22:33:55',
    'updated_at' => '2025-08-24 00:30:00',
  ),
  4 => 
  array (
    'id' => 5,
    'title' => 'Aday Iade Mesaji',
    'slug' => 'aday-iade-mesaji',
    'content' => '<div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Burs başvurunuzun değerlendirmeye alınabilmesi için aşağıda belirtilen eksikleri &nbsp;<b> <a href="http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/68822cefe6803900019bf824/673334d8aa2a05760aa84d2f" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/68822cefe6803900019bf824/673334d8aa2a05760aa84d2f&amp;source=gmail&amp;ust=1753923523304000&amp;usg=AOvVaw3JZnTUyEocGBIhAR6PmcmJ">https://burs.sacdd.org.tr/<wbr>student</a> </b>&nbsp;üzerinden giriş yaparak tamamlayınız.</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Sebebi :&nbsp;</strong></span>_sebep_</font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Açıklaması:  &nbsp;&nbsp;&nbsp;</strong></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify"><font color="#ffffff">
                                                                                    _aciklama_<br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Başarılar dileriz.</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span></font>
                                                                                </div>',
    'parameters' => '["name","surname","sebep","aciklama"]',
    'created_at' => '2025-07-30 00:13:24',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  5 => 
  array (
    'id' => 6,
    'title' => 'Mülakat Oluşturuldu Mesajı',
    'slug' => 'mulakat-olusturuldu-mesaji',
    'content' => '<p>

</p><p><font color="#ffffff">Sayın&nbsp;_name_&nbsp;_surname_</font></p><p>

</p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Burs başvurunuz kapsamında mülakat programı oluşturulmuştur.&nbsp;<br>Burs başvurunuzun değerlendirme sürecini tamamlamak amacıyla sizi aşağıda detayları verilen mülakata davet ediyoruz.&nbsp; </span></font><font color="#000000"><span style="font-size: 11pt; font-family: Calibri;"><b><span style="background-color: rgb(255, 255, 0);">Lütfen en kısa sürede katılım durumunuzu info@sacdd.org.tr üzerinden yazılı olarak bildiriniz.</span></b></span></font><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;"><br><br></span></font></p>

<p><font color="#ffffff">Mülakat Bilgileri:</font></p><p><font color="#ffffff">Mülakat Tarihi:&nbsp;_interview_date_</font></p><p><font color="#ffffff">Mülakat Saati:&nbsp;_interview_time_</font></p><p><font color="#ffffff">Mülakat Tipi:&nbsp;_interview_type_</font></p><p><font color="#ffffff">Mülakat Adres/Linki :&nbsp;</font><font color="#efefef">_interview_address_</font></p><p><font color="#ffffff">Başvuru sonuçlarının açıklanacağı tarih web sitemizde duyurulacaktır.<br><br>Sevgilerimizle,<br><br></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Süreyya Ağaoğlu Çocuk Dostları Derneği</span></font></p>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</span></font></p>

<p><font color="#ffffff"><br></font><br></p>',
    'parameters' => '["name","surname","interview_date","interview_time","interview_type","interview_address"]',
    'created_at' => '2025-07-29 22:33:55',
    'updated_at' => '2025-08-24 00:27:01',
  ),
  6 => 
  array (
    'id' => 7,
    'title' => 'Kayıt Yenileme Dönemi Başladı',
    'slug' => 'kayit-yenileme-donemi-basladi',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sevgili Bursiyerimiz,</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff">_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"></span></font>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Bursiyer kayıt</span><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;">
yenileme dönemi açılmıştır. Aşağıda belirtilen tarih aralığında listesi verilen
belgelerinizi&nbsp;</span><b><a href="https://burs.sacdd.org.tr/student" target="_blank">https://burs.sacdd.org.tr/student</a></b><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;">&nbsp; adresi üzerinden güncel tarihli olarak
sisteme ekleyiniz.</span></font></p>

</div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><u><strong>Sistem Giriş Bilgileri:</strong></u></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:inherit"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Kullanıcı Adı:</strong></span>_email_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><br></span></font></div>
<div style="font-family:inherit;text-align:inherit"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Şifre:</strong></span>_password_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><br>Kayıt Yenileme Dönem Açılış: <b>20 Ocak 2026</b><br><br>Kayıt Yenileme Dönem Kapanış: <b>30 Ocak 2026</b><br><br><b>Eklenecek Belgeler :&nbsp; Karne, Öğrenci&nbsp;</b></span></font><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><b>Belgesi</b></span></font><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><b>, Başarı Belgesi ( Belge yükleme adımında Diğer alanına yüklenecek)</b><br>&nbsp;<br><br></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı&nbsp;</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","email","password"]',
    'created_at' => '2025-07-30 00:15:03',
    'updated_at' => '2026-01-20 13:42:53',
  ),
  7 => 
  array (
    'id' => 8,
    'title' => 'Kayıt Yenileme Onaylandı',
    'slug' => 'kayit-yenileme-onaylandi',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;">Kayıt Yenileme Başvurunuz yapılan değerlendirme sonucunda
    </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>olumlu</strong></u></span><span style="font-family: arial, helvetica, sans-serif;"> değerlendirilmiştir. </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>Kayıt  Yenilemeniz Onaylanmıştır.</strong></u></span> <br><span style="font-family: arial, helvetica, sans-serif;">. Başarılarınızın devamını dileriz!...&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname"]',
    'created_at' => '2025-07-30 00:15:16',
    'updated_at' => '2025-07-30 03:52:59',
  ),
  8 => 
  array (
    'id' => 10,
    'title' => 'Kayıt Yenileme İade Edildi',
    'slug' => 'kayit-yenileme-iade-edildi',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Kayit Yenileme başvurunuzun değerlendirilmesi için size iletilen eksikleri &nbsp; <a href="http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/6865a94b3f69a70001cf2958/673334d8aa2a05760aa84d2f" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/6865a94b3f69a70001cf2958/673334d8aa2a05760aa84d2f&amp;source=gmail&amp;ust=1753923693469000&amp;usg=AOvVaw0WnTJULFNkK4NfEriRw9FJ">https://burs.sacdd.org.tr/<wbr>student</a> &nbsp;giriş yaparak işlemlerinizi tamamlamanız gerekmektedir.&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Sebebi :&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Açıklaması:</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong><br></strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","sebep","aciklama"]',
    'created_at' => '2025-07-30 00:15:37',
    'updated_at' => '2025-07-30 04:02:33',
  ),
  9 => 
  array (
    'id' => 11,
    'title' => 'Burs Ödemesi Girildi',
    'slug' => 'burs-odemesi-girildi',
    'content' => '<div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
                                                                                    </span></font></div>
                                                                                <div style="font-family:inherit;text-align:justify"><font color="#ffffff">_burs_ayi_&nbsp;<span style="font-family: arial, helvetica, sans-serif;">ayı bursunuz ödenmiştir.
                                                                                    </span></font>
                                                                                </div>

                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya
                                                                                            Ağaoğlu Çocuk Dostları
                                                                                            Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya
                                                                                            Ağaoğlu Eğitim ve Öğretim
                                                                                            Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>
                                                                                            &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","burs_ayi"]',
    'created_at' => '2025-07-30 00:16:16',
    'updated_at' => '2025-07-30 03:56:17',
  ),
  10 => 
  array (
    'id' => 13,
    'title' => 'Mülakat Reddedildi Mesajı',
    'slug' => 'mulakat-reddedildi-mesaji',
    'content' => '<p><p><font color="#ffffff">Sayın&nbsp;_name_&nbsp;_surname_</font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Burs başvurunuzu</span><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;"> </span><span style="font-size: 11pt; font-family: Calibri;">değerlendirme sürecimiz tamamlanmıştır.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;"><br></span></font></p><font color="#ffffff">Başvurunuz, yüksek akademik başarıya sahip ve eğitim hayatında ekonomik desteğe gereksinim duyan öğrenci burs talepleri arasında yer almaktadır. Başvuruları ön inceleme ve mülakat aşamalarında değerlendirirken burs kontenjanımız dahilinde özenli ve detaylı bir inceleme yaptığımızı bilmenizi isteriz. Ancak diğer birçok başarılı öğrencinin burs başvurusu ile birlikte sizin başvurunuzu da olumlu sonuçlandıramadığımız için üzüntü duymaktayız.</font></p><p><font color="#ffffff"><br></font><p><font color="#ffffff">Kurumumuza gösterdiğiniz ilgi ve güvene çok teşekkür ederiz.</font></p><font color="#ffffff">Eğitim hayatınızda başarılar dileriz.<br>Sevgilerimizle,&nbsp;<br><br>Süreyya Ağaoğlu Çocuk Dostları Derneği<br>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</font></p>',
    'parameters' => '["name","surname","interview_date","interview_time","interview_type"]',
    'created_at' => '2025-07-29 22:33:55',
    'updated_at' => '2025-08-24 00:31:20',
  ),
  11 => 
  array (
    'id' => 14,
    'title' => 'Burs Basvuru Alındı',
    'slug' => 'burs-basvuru-alindi',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_ad_&nbsp;_soyad_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Burs</span><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;"> başvurunuz alınmıştır. Adınıza bir
profil sayfası oluşturulmuştur. Profil sayfanıza giriş bilgileri aşağıda
verilmektedir.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;"><br></span></font></p>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;">Başvuru
değerlendirme süreci iki aşamadan oluşmaktadır. Ön değerlendirme sonucu uygun
görülen adaylar mülakata davet edilmektedir. </span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;"><br></span></font></p>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;">Başvuru değerlendirme dönemi takvimini <b><a href="https://www.sacdd.org.tr" target="_blank">www.sacdd.org.tr</a></b> adresinden takip edebilirsiniz. Takvimde belirtilen sonuç açıklama tarihinde <a href="https://burs.sacdd.org.tr/student" target="_blank">https://burs.sacdd.org.tr/student</a> linki üzerinden profil sayfanıza erişim sağlayarak sonucunuzu öğrenebilirsiniz.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;"><br></span></font></p>



<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;">Profil
sayfasınıza giriş bilgileriniz:</span></font></p>

<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:inherit"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Eposta Adresi:</strong></span>_email_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><br></span></font></div>
<div style="font-family:inherit;text-align:inherit"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Şifre:</strong></span>_password_</font></div>
<div style="font-family:inherit;text-align:justify"><br></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff">Başarılar dileriz.</font></div><div style="font-family:inherit;text-align:justify"><br></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["ad","soyad","password","email"]',
    'created_at' => '2025-07-30 00:18:26',
    'updated_at' => '2025-08-29 03:01:35',
  ),
  12 => 
  array (
    'id' => 15,
    'title' => 'Bursiyerlik İptal',
    'slug' => 'bursiyerlik-iptal',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; line-height: normal; font-family: arial, helvetica, sans-serif;">Bursiyerliğiniz derneğimiz tarafından iptal edilmiştir.&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">Eğitim hayatınızda başarılar dileriz.<br><br></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname"]',
    'created_at' => '2025-07-30 00:30:17',
    'updated_at' => '2025-08-24 00:45:24',
  ),
  13 => 
  array (
    'id' => 16,
    'title' => 'Kayıt Yenileme Reddedildi',
    'slug' => 'kayit-yenileme-reddedildi',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><span class="il"><span class="il">Kayıt Yenileme başvurunuz</span></span> yapılan değerlendirme sonucunda </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>olumsuz</strong></u></span><span style="font-family: arial, helvetica, sans-serif;"> değerlendirilmiş olup, <span class="il"><span class="il">burs</span></span> almaya devam etmeye uygun </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>bulunmadınız</strong></u></span><span style="font-family: arial, helvetica, sans-serif;">. Başarılarınızın devamını dileriz!...&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Sebebi:&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Açıklaması: </strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-07-30 03:45:19',
  ),
  14 => 
  array (
    'id' => 18,
    'title' => 'Şifre Yenileme Mesajı',
    'slug' => 'sifre-yenileme-mesaji',
    'content' => '<p></p><p><font color="#efefef">Sayın&nbsp;_name_&nbsp;_surname_&nbsp;</font></p><font color="#efefef">Bursiyer Bilgi Sistemine giriş için şifre sıfırlama talebiniz üzerine gerekli işlemi gerçekleştirebileceğiniz bilgiler aşağıda verilmektedir.&nbsp;<br><br>Sistem Giriş Bilgileri:<br><br>Sistem Giriş Linki: <a href="https://burs.sacdd.org.tr/student/login" target="_blank">https://burs.sacdd.org.tr/student/login</a><br>Kullanıcı Adı:_email_<br>Şifre:_password_</font><font color="#efefef"><br>&nbsp;<br>Sevgilerimizle,&nbsp;<br><br>Süreyya Ağaoğlu Çocuk Dostları Derneği&nbsp;<br>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</font><p><font color="#efefef"><br></font></p><p></p>',
    'parameters' => '["name","surname","email","password"]',
    'created_at' => '2025-08-28 00:18:26',
    'updated_at' => '2025-08-29 03:01:55',
  ),
  15 => 
  array (
    'id' => 17,
    'title' => 'Mezun Etme Mesajı',
    'slug' => 'mezun-etme-mesaji',
    'content' => '<p style="language:tr;line-height:normal;margin-top:0pt;margin-bottom:0pt;
margin-left:0in;margin-right:0in;text-indent:0in;mso-vertical-align-alt:auto;
mso-line-break-override:none;word-break:normal;punctuation-wrap:hanging"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Sayın&nbsp;</span>_name_ _surname_</font></p>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Bursiyerliğiniz</span><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;"> sona
ermiştir. </span><span style="font-size: 11pt; font-family: Calibri;">Mezuniyetini</span><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;">zi
kutlar başarılarınızın hayat boyu devamını dileriz.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;"><br></span></font></p>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; vertical-align: baseline;">Sevgilerimizle,</span></font></p>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Süreyya Ağaoğlu Çocuk Dostları Derneği</span></font></p>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri;">Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</span></font></p>

<p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in"></p>

<p><br><br><br></p>',
    'parameters' => '[]',
    'created_at' => '2025-08-24 03:10:25',
    'updated_at' => '2025-08-24 03:10:25',
  ),
  16 => 
  array (
    'id' => 19,
    'title' => 'Doğum Günü Mesajı',
    'slug' => 'dogum-gunu-mesaji',
    'content' => '<p>selam&nbsp;_name_ _surname_<br><br>doğum günün kutlu olsun</p>',
    'parameters' => '["name","surname"]',
    'created_at' => '2026-03-30 16:23:21',
    'updated_at' => '2026-03-30 16:23:21',
  ),
  17 => 
  array (
    'id' => 20,
    'title' => 'Aday - Burs İade - Belge Eksikliği',
    'slug' => 'aday-burs-iade-belge-eksikligi',
    'content' => '<div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Burs başvurunuzun değerlendirmeye alınabilmesi için aşağıda belirtilen eksikleri &nbsp;<b> <a href="http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/68822cefe6803900019bf824/673334d8aa2a05760aa84d2f" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/68822cefe6803900019bf824/673334d8aa2a05760aa84d2f&amp;source=gmail&amp;ust=1753923523304000&amp;usg=AOvVaw3JZnTUyEocGBIhAR6PmcmJ">https://burs.sacdd.org.tr/<wbr>student</a> </b>&nbsp;üzerinden giriş yaparak tamamlayınız.</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Sebebi :&nbsp;</strong></span>_sebep_</font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Açıklaması:  &nbsp;&nbsp;&nbsp;</strong></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify"><font color="#ffffff">
                                                                                    _aciklama_<br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Başarılar dileriz.</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span></font>
                                                                                </div>',
    'parameters' => '["name","surname","sebep","aciklama"]',
    'created_at' => '2025-07-30 00:13:24',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  18 => 
  array (
    'id' => 21,
    'title' => 'Kayıt Yenileme - İade - Belge Eksikliği',
    'slug' => 'kayit-yenileme-iade-belge-eksikligi',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Kayit Yenileme başvurunuzun değerlendirilmesi için size iletilen eksikleri &nbsp; <a href="http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/6865a94b3f69a70001cf2958/673334d8aa2a05760aa84d2f" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/6865a94b3f69a70001cf2958/673334d8aa2a05760aa84d2f&amp;source=gmail&amp;ust=1753923693469000&amp;usg=AOvVaw0WnTJULFNkK4NfEriRw9FJ">https://burs.sacdd.org.tr/<wbr>student</a> &nbsp;giriş yaparak işlemlerinizi tamamlamanız gerekmektedir.&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Sebebi :&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Açıklaması:</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong><br></strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","sebep","aciklama"]',
    'created_at' => '2025-07-30 00:15:37',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  19 => 
  array (
    'id' => 22,
    'title' => 'Aday - Burs Red - Geçersiz Başvuru',
    'slug' => 'aday-burs-red-gecersiz-basvuru',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Burs başvurunuz olumsuz sonuçlanmıştır.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Eğitim hayatınızda başarılar dileriz.<br><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><b>Açıklama:</b><br>_aciklama_</font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Sevgilerimizle,</span></font></p><font color="#ffffff"><br></font><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  20 => 
  array (
    'id' => 23,
    'title' => 'Kayıt Yenileme - Red - Geçersiz Başvuru',
    'slug' => 'kayit-yenileme-red-gecersiz-basvuru',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><span class="il"><span class="il">Kayıt Yenileme başvurunuz</span></span> yapılan değerlendirme sonucunda </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>olumsuz</strong></u></span><span style="font-family: arial, helvetica, sans-serif;"> değerlendirilmiş olup, <span class="il"><span class="il">burs</span></span> almaya devam etmeye uygun </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>bulunmadınız</strong></u></span><span style="font-family: arial, helvetica, sans-serif;">. Başarılarınızın devamını dileriz!...&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Sebebi:&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Açıklaması: </strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  21 => 
  array (
    'id' => 24,
    'title' => 'Aday - Burs Red - Eksik Belge',
    'slug' => 'aday-burs-red-eksik-belge',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Burs başvurunuz olumsuz sonuçlanmıştır.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Eğitim hayatınızda başarılar dileriz.<br><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><b>Açıklama:</b><br>_aciklama_</font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Sevgilerimizle,</span></font></p><font color="#ffffff"><br></font><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  22 => 
  array (
    'id' => 25,
    'title' => 'Kayıt Yenileme - Red - Eksik Belge',
    'slug' => 'kayit-yenileme-red-eksik-belge',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><span class="il"><span class="il">Kayıt Yenileme başvurunuz</span></span> yapılan değerlendirme sonucunda </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>olumsuz</strong></u></span><span style="font-family: arial, helvetica, sans-serif;"> değerlendirilmiş olup, <span class="il"><span class="il">burs</span></span> almaya devam etmeye uygun </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>bulunmadınız</strong></u></span><span style="font-family: arial, helvetica, sans-serif;">. Başarılarınızın devamını dileriz!...&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Sebebi:&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Açıklaması: </strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  23 => 
  array (
    'id' => 26,
    'title' => 'Aday - Burs Red - Ön Değerlendirme Olumsuz',
    'slug' => 'aday-burs-red-on-degerlendirme-olumsuz',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Burs başvurunuz olumsuz sonuçlanmıştır.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Eğitim hayatınızda başarılar dileriz.<br><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><b>Açıklama:</b><br>_aciklama_</font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Sevgilerimizle,</span></font></p><font color="#ffffff"><br></font><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  24 => 
  array (
    'id' => 27,
    'title' => 'Kayıt Yenileme - Red - Ön Değerlendirme Olumsuz',
    'slug' => 'kayit-yenileme-red-on-degerlendirme-olumsuz',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><span class="il"><span class="il">Kayıt Yenileme başvurunuz</span></span> yapılan değerlendirme sonucunda </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>olumsuz</strong></u></span><span style="font-family: arial, helvetica, sans-serif;"> değerlendirilmiş olup, <span class="il"><span class="il">burs</span></span> almaya devam etmeye uygun </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>bulunmadınız</strong></u></span><span style="font-family: arial, helvetica, sans-serif;">. Başarılarınızın devamını dileriz!...&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Sebebi:&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Açıklaması: </strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  25 => 
  array (
    'id' => 28,
    'title' => 'Aday - Burs Red - Önceki Mülakat Olumsuz',
    'slug' => 'aday-burs-red-onceki-mulakat-olumsuz',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Burs başvurunuz olumsuz sonuçlanmıştır.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Eğitim hayatınızda başarılar dileriz.<br><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><b>Açıklama:</b><br>_aciklama_</font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Sevgilerimizle,</span></font></p><font color="#ffffff"><br></font><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  26 => 
  array (
    'id' => 29,
    'title' => 'Kayıt Yenileme - Red - Önceki Mülakat Olumsuz',
    'slug' => 'kayit-yenileme-red-onceki-mulakat-olumsuz',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><span class="il"><span class="il">Kayıt Yenileme başvurunuz</span></span> yapılan değerlendirme sonucunda </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>olumsuz</strong></u></span><span style="font-family: arial, helvetica, sans-serif;"> değerlendirilmiş olup, <span class="il"><span class="il">burs</span></span> almaya devam etmeye uygun </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>bulunmadınız</strong></u></span><span style="font-family: arial, helvetica, sans-serif;">. Başarılarınızın devamını dileriz!...&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Sebebi:&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Açıklaması: </strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  27 => 
  array (
    'id' => 30,
    'title' => 'Aday - Burs Red - Diğer',
    'slug' => 'aday-burs-red-diger',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Burs başvurunuz olumsuz sonuçlanmıştır.</span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Eğitim hayatınızda başarılar dileriz.<br><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><b>Açıklama:</b><br>_aciklama_</font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;"><br></span></font></p><p style="language:tr;margin-top:0pt;margin-bottom:0pt;margin-left:0in;
text-indent:0in;direction:ltr;unicode-bidi:embed"><font color="#ffffff"><span style="font-size: 11pt; font-family: Calibri; font-weight: normal; font-style: normal;">Sevgilerimizle,</span></font></p><font color="#ffffff"><br></font><div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  28 => 
  array (
    'id' => 31,
    'title' => 'Kayıt Yenileme - Red - Diğer',
    'slug' => 'kayit-yenileme-red-diger',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><span class="il"><span class="il">Kayıt Yenileme başvurunuz</span></span> yapılan değerlendirme sonucunda </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>olumsuz</strong></u></span><span style="font-family: arial, helvetica, sans-serif;"> değerlendirilmiş olup, <span class="il"><span class="il">burs</span></span> almaya devam etmeye uygun </span><span style="font-family: arial, helvetica, sans-serif;"><u><strong>bulunmadınız</strong></u></span><span style="font-family: arial, helvetica, sans-serif;">. Başarılarınızın devamını dileriz!...&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Sebebi:&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-family: arial, helvetica, sans-serif;"><strong>Ret Açıklaması: </strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","aciklama","sebep"]',
    'created_at' => '2025-07-29 19:40:35',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  29 => 
  array (
    'id' => 32,
    'title' => 'Aday - Burs İade - Bilgi Eksikliği',
    'slug' => 'aday-burs-iade-bilgi-eksikligi',
    'content' => '<div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Burs başvurunuzun değerlendirmeye alınabilmesi için aşağıda belirtilen eksikleri &nbsp;<b> <a href="http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/68822cefe6803900019bf824/673334d8aa2a05760aa84d2f" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/68822cefe6803900019bf824/673334d8aa2a05760aa84d2f&amp;source=gmail&amp;ust=1753923523304000&amp;usg=AOvVaw3JZnTUyEocGBIhAR6PmcmJ">https://burs.sacdd.org.tr/<wbr>student</a> </b>&nbsp;üzerinden giriş yaparak tamamlayınız.</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Sebebi :&nbsp;</strong></span>_sebep_</font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Açıklaması:  &nbsp;&nbsp;&nbsp;</strong></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify"><font color="#ffffff">
                                                                                    _aciklama_<br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Başarılar dileriz.</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span></font>
                                                                                </div>',
    'parameters' => '["name","surname","sebep","aciklama"]',
    'created_at' => '2025-07-30 00:13:24',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  30 => 
  array (
    'id' => 33,
    'title' => 'Kayıt Yenileme - İade - Bilgi Eksikliği',
    'slug' => 'kayit-yenileme-iade-bilgi-eksikligi',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Kayit Yenileme başvurunuzun değerlendirilmesi için size iletilen eksikleri &nbsp; <a href="http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/6865a94b3f69a70001cf2958/673334d8aa2a05760aa84d2f" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/6865a94b3f69a70001cf2958/673334d8aa2a05760aa84d2f&amp;source=gmail&amp;ust=1753923693469000&amp;usg=AOvVaw0WnTJULFNkK4NfEriRw9FJ">https://burs.sacdd.org.tr/<wbr>student</a> &nbsp;giriş yaparak işlemlerinizi tamamlamanız gerekmektedir.&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Sebebi :&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Açıklaması:</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong><br></strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","sebep","aciklama"]',
    'created_at' => '2025-07-30 00:15:37',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  31 => 
  array (
    'id' => 34,
    'title' => 'Aday - Burs İade - Diğer',
    'slug' => 'aday-burs-iade-diger',
    'content' => '<div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Burs başvurunuzun değerlendirmeye alınabilmesi için aşağıda belirtilen eksikleri &nbsp;<b> <a href="http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/68822cefe6803900019bf824/673334d8aa2a05760aa84d2f" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/68822cefe6803900019bf824/673334d8aa2a05760aa84d2f&amp;source=gmail&amp;ust=1753923523304000&amp;usg=AOvVaw3JZnTUyEocGBIhAR6PmcmJ">https://burs.sacdd.org.tr/<wbr>student</a> </b>&nbsp;üzerinden giriş yaparak tamamlayınız.</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Sebebi :&nbsp;</strong></span>_sebep_</font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Açıklaması:  &nbsp;&nbsp;&nbsp;</strong></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify"><font color="#ffffff">
                                                                                    _aciklama_<br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Başarılar dileriz.</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><br></font></div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span></font>
                                                                                </div>
                                                                                <div style="font-family:inherit;text-align:justify">
                                                                                    <font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span></font>
                                                                                </div>',
    'parameters' => '["name","surname","sebep","aciklama"]',
    'created_at' => '2025-07-30 00:13:24',
    'updated_at' => '2025-08-24 00:32:51',
  ),
  32 => 
  array (
    'id' => 35,
    'title' => 'Kayıt Yenileme - İade - Diğer',
    'slug' => 'kayit-yenileme-iade-diger',
    'content' => '<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Sayın&nbsp;</strong></span>_name_&nbsp;_surname_<span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> ;</strong></span><span style="text-align:justify;font-size:14px;font-family:arial,helvetica,sans-serif"><br>
</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Kayit Yenileme başvurunuzun değerlendirilmesi için size iletilen eksikleri &nbsp; <a href="http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/6865a94b3f69a70001cf2958/673334d8aa2a05760aa84d2f" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://notify.track.inclick.email/notify/click/65af9f62f312760001cc96e4/6865a94b3f69a70001cf2958/673334d8aa2a05760aa84d2f&amp;source=gmail&amp;ust=1753923693469000&amp;usg=AOvVaw0WnTJULFNkK4NfEriRw9FJ">https://burs.sacdd.org.tr/<wbr>student</a> &nbsp;giriş yaparak işlemlerinizi tamamlamanız gerekmektedir.&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Sebebi :&nbsp;</strong></span>_sebep_</font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>İade Açıklaması:</strong></span></font></div><div style="font-family:inherit;text-align:justify"><font color="#ffffff">_aciklama_<span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong><br></strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;">Sevgilerimizle,</span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;">&nbsp;</span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><br></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></font></div>
<div style="font-family:inherit;text-align:justify"><font color="#ffffff"><span style="text-align: justify; font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong></span><span style="font-size: 14px; font-family: arial, helvetica, sans-serif;"><strong> &nbsp;</strong></span></font></div>',
    'parameters' => '["name","surname","sebep","aciklama"]',
    'created_at' => '2025-07-30 00:15:37',
    'updated_at' => '2025-08-24 00:32:51',
  ),
));
    }
}