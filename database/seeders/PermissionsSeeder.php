<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permissions')->insert(array (
  0 => 
  array (
    'id' => 2,
    'name' => 'aday-durum-degis',
    'category' => 'Aday Bursiyerler',
    'description' => 'Aday Durumlarını Değiştirebilir',
    'created_at' => '2024-10-07 23:24:03',
    'updated_at' => '2024-11-07 09:54:58',
  ),
  1 => 
  array (
    'id' => 3,
    'name' => 'bursiyer-bilgileri-degis',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Aday ve bursiyer bilgilerini değiştirebilir',
    'created_at' => '2024-10-08 22:51:54',
    'updated_at' => '2024-11-07 09:33:24',
  ),
  2 => 
  array (
    'id' => 5,
    'name' => 'aday-bursiyer-ekleme',
    'category' => 'Aday Bursiyerler',
    'description' => 'Aday bursiyer ekleyebilir',
    'created_at' => '2024-10-09 01:44:22',
    'updated_at' => '2024-11-07 09:33:28',
  ),
  3 => 
  array (
    'id' => 6,
    'name' => 'aktif-bursiyer-ekleme',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Aktif bursiyer ekleyebilir',
    'created_at' => '2024-10-09 01:47:55',
    'updated_at' => '2024-11-07 09:33:34',
  ),
  4 => 
  array (
    'id' => 7,
    'name' => 'ky-bursiyer-ekleme',
    'category' => 'Kayıt Yenileme İşlemleri',
    'description' => 'Kayıt yenileme bursiyeri ekleyebilir',
    'created_at' => '2024-10-09 01:48:23',
    'updated_at' => '2024-11-07 09:33:42',
  ),
  5 => 
  array (
    'id' => 8,
    'name' => 'belge-durum-degis',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Bursiyer belge durumlarını değiştirebilir',
    'created_at' => '2024-10-09 01:49:01',
    'updated_at' => '2024-11-07 09:34:04',
  ),
  6 => 
  array (
    'id' => 9,
    'name' => 'add-note',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Bursiyer notu ekleyebilir',
    'created_at' => '2024-10-09 01:49:42',
    'updated_at' => '2024-11-07 09:34:11',
  ),
  7 => 
  array (
    'id' => 10,
    'name' => 'burs-odeme-guncelle',
    'category' => 'Burs Ödeme Bilgileri',
    'description' => 'Burs ödeme bilgilerini güncelleyebilir',
    'created_at' => '2024-10-09 01:50:39',
    'updated_at' => '2024-11-07 09:34:16',
  ),
  8 => 
  array (
    'id' => 11,
    'name' => 'burs-odeme-ekle',
    'category' => 'Burs Ödeme Bilgileri',
    'description' => 'Burs ödeme bilgisi ekleyebilir',
    'created_at' => '2024-10-09 01:51:01',
    'updated_at' => '2024-11-07 09:34:21',
  ),
  9 => 
  array (
    'id' => 12,
    'name' => 'aday-toplu-islem',
    'category' => 'Aday Bursiyerler',
    'description' => 'Aday bursiyerler tablosundan işlem yapabilir',
    'created_at' => '2024-10-09 01:51:49',
    'updated_at' => '2024-10-29 15:25:53',
  ),
  10 => 
  array (
    'id' => 13,
    'name' => 'mezun-toplu-islem',
    'category' => 'Mezunlar',
    'description' => 'Mezunlar tablosundan işlem yapabilir',
    'created_at' => '2024-10-09 01:52:18',
    'updated_at' => '2024-11-07 09:34:30',
  ),
  11 => 
  array (
    'id' => 14,
    'name' => 'ky-toplu-islem',
    'category' => 'Kayıt Yenileme İşlemleri',
    'description' => 'Kayıt yenileme tablosundan işlem yapabilir',
    'created_at' => '2024-10-09 01:52:55',
    'updated_at' => '2024-11-07 09:34:36',
  ),
  12 => 
  array (
    'id' => 15,
    'name' => 'aktif-toplu-islem',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Bursiyerler tablosundan işlem yapabilir',
    'created_at' => '2024-10-09 01:53:32',
    'updated_at' => '2024-11-07 09:34:43',
  ),
  13 => 
  array (
    'id' => 16,
    'name' => 'aday-reddet',
    'category' => 'Aday Bursiyerler',
    'description' => 'Adayları reddedebilir',
    'created_at' => '2024-10-09 01:54:06',
    'updated_at' => '2024-10-29 15:26:00',
  ),
  14 => 
  array (
    'id' => 17,
    'name' => 'ky-reddet',
    'category' => 'Kayıt Yenileme İşlemleri',
    'description' => 'Kayıt yenileme başvurularını reddedebilir',
    'created_at' => '2024-10-09 01:54:27',
    'updated_at' => '2024-11-07 09:34:50',
  ),
  15 => 
  array (
    'id' => 18,
    'name' => 'ky-iade',
    'category' => 'Kayıt Yenileme İşlemleri',
    'description' => 'Kayıt yenileme başvurularını iade edebilir',
    'created_at' => '2024-10-09 01:54:54',
    'updated_at' => '2024-11-07 09:34:59',
  ),
  16 => 
  array (
    'id' => 19,
    'name' => 'mulakat-olustur',
    'category' => 'Mülakat İşlemleri',
    'description' => 'Mülakat oluşturabilir',
    'created_at' => '2024-10-09 01:55:22',
    'updated_at' => '2024-11-07 09:35:06',
  ),
  17 => 
  array (
    'id' => 20,
    'name' => 'mulakat-sil',
    'category' => 'Mülakat İşlemleri',
    'description' => 'Mülakat silebilir',
    'created_at' => '2024-10-09 01:55:57',
    'updated_at' => '2024-11-07 09:35:13',
  ),
  18 => 
  array (
    'id' => 21,
    'name' => 'basvuru-aday-bilgileri-kaydet',
    'category' => 'Aday Bursiyerler',
    'description' => 'Aday bursiyer bilgilerini güncelleyebilir',
    'created_at' => '2024-10-09 01:57:03',
    'updated_at' => '2024-11-07 09:35:19',
  ),
  19 => 
  array (
    'id' => 22,
    'name' => 'aktif-bursiyer-bilgileri-kaydet',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Bursiyer bilgilerini güncelleyebilir',
    'created_at' => '2024-10-09 01:57:26',
    'updated_at' => '2024-11-07 09:35:31',
  ),
  20 => 
  array (
    'id' => 23,
    'name' => 'kayit-donemi-olustur',
    'category' => 'Tanımlar',
    'description' => 'Yeni dönem oluşturabilir',
    'created_at' => '2024-10-09 01:57:54',
    'updated_at' => '2024-11-07 09:35:58',
  ),
  21 => 
  array (
    'id' => 24,
    'name' => 'aday-sil',
    'category' => 'Aday Bursiyerler',
    'description' => 'Aday Bursiyerleri silebilir',
    'created_at' => '2024-10-09 01:59:02',
    'updated_at' => '2024-10-29 15:26:06',
  ),
  22 => 
  array (
    'id' => 25,
    'name' => 'bursiyer-sil',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Bursiyerleri silebilir',
    'created_at' => '2024-10-09 02:00:38',
    'updated_at' => '2024-11-07 09:36:06',
  ),
  23 => 
  array (
    'id' => 26,
    'name' => 'ky-sil',
    'category' => 'Kayıt Yenileme İşlemleri',
    'description' => 'Kayıt Yenilemeleri silebilir',
    'created_at' => '2024-10-09 02:01:04',
    'updated_at' => '2024-11-07 09:36:11',
  ),
  24 => 
  array (
    'id' => 27,
    'name' => 'mulakat-duzenle',
    'category' => 'Mülakat İşlemleri',
    'description' => 'Mülakatlari güncelleyebilir / sonuçlandırabilir',
    'created_at' => '2024-10-09 02:02:05',
    'updated_at' => '2024-11-07 09:36:16',
  ),
  25 => 
  array (
    'id' => 28,
    'name' => 'il-yonet',
    'category' => 'Tanımlar',
    'description' => 'İlleri yönetebilir',
    'created_at' => '2024-10-09 02:02:52',
    'updated_at' => '2024-11-07 09:36:22',
  ),
  26 => 
  array (
    'id' => 29,
    'name' => 'ilce-yonet',
    'category' => 'Tanımlar',
    'description' => 'İlçeleri yönetebilir',
    'created_at' => '2024-10-09 02:03:34',
    'updated_at' => '2024-11-07 09:36:29',
  ),
  27 => 
  array (
    'id' => 30,
    'name' => 'banka-yonet',
    'category' => 'Tanımlar',
    'description' => 'Bankaları Yönetebilir',
    'created_at' => '2024-10-09 02:04:02',
    'updated_at' => '2024-11-07 09:36:33',
  ),
  28 => 
  array (
    'id' => 31,
    'name' => 'universite-yonet',
    'category' => 'Tanımlar',
    'description' => 'Üniversiteleri yönetebilir',
    'created_at' => '2024-10-09 02:04:26',
    'updated_at' => '2024-11-07 09:36:37',
  ),
  29 => 
  array (
    'id' => 32,
    'name' => 'fakulte-yonet',
    'category' => 'Tanımlar',
    'description' => 'Fakülteleri yönetebilir',
    'created_at' => '2024-10-09 02:04:51',
    'updated_at' => '2024-11-07 09:36:41',
  ),
  30 => 
  array (
    'id' => 33,
    'name' => 'bolum-yonet',
    'category' => 'Tanımlar',
    'description' => 'Bölümleri yönetebilir',
    'created_at' => '2024-10-09 02:05:11',
    'updated_at' => '2024-11-07 09:36:45',
  ),
  31 => 
  array (
    'id' => 34,
    'name' => 'mail-gonder',
    'category' => 'Ayarlar',
    'description' => 'Mail Gönderebilir',
    'created_at' => '2024-10-09 02:06:57',
    'updated_at' => '2024-11-07 09:36:53',
  ),
  32 => 
  array (
    'id' => 35,
    'name' => 'form-soru-yonet',
    'category' => 'Tanımlar',
    'description' => 'Form Sorularını yönetebilir',
    'created_at' => '2024-10-09 02:07:47',
    'updated_at' => '2024-11-07 09:37:02',
  ),
  33 => 
  array (
    'id' => 36,
    'name' => 'kullanici-yonet',
    'category' => 'Ayarlar',
    'description' => 'Kullanıcıları Yönetebilir',
    'created_at' => '2024-10-09 18:17:19',
    'updated_at' => '2024-11-07 09:37:09',
  ),
  34 => 
  array (
    'id' => 37,
    'name' => 'yetki-yonet',
    'category' => 'Ayarlar',
    'description' => 'Yetkileri Yönetebilir',
    'created_at' => '2024-10-09 18:17:54',
    'updated_at' => '2024-11-07 09:37:13',
  ),
  35 => 
  array (
    'id' => 38,
    'name' => 'rol-yonet',
    'category' => 'Ayarlar',
    'description' => 'Rolleri Yönetebilir',
    'created_at' => '2024-10-09 18:18:43',
    'updated_at' => '2024-11-07 09:37:17',
  ),
  36 => 
  array (
    'id' => 40,
    'name' => 'kayit-yenileme-detay',
    'category' => 'Kayıt Yenileme İşlemleri',
    'description' => 'Kayıt Yenileme Bursiyerlerini Yönetebilir',
    'created_at' => '2024-10-16 13:57:45',
    'updated_at' => '2024-11-07 09:37:26',
  ),
  37 => 
  array (
    'id' => 41,
    'name' => 'kayit-yenileme-sonuclandir',
    'category' => 'Kayıt Yenileme İşlemleri',
    'description' => 'Kayıt Yenileme Başvurularını Sonuçlandırabilir',
    'created_at' => '2024-10-16 13:59:52',
    'updated_at' => '2024-11-07 09:37:31',
  ),
  38 => 
  array (
    'id' => 45,
    'name' => 'mulakat-yonet',
    'category' => 'Mülakat İşlemleri',
    'description' => 'Mülakatları yönetebilir',
    'created_at' => '2024-11-04 10:27:54',
    'updated_at' => '2024-11-07 09:46:09',
  ),
  39 => 
  array (
    'id' => 46,
    'name' => 'aday-basvurularini-listele',
    'category' => 'Aday Bursiyerler',
    'description' => 'Aday Başvurularını Listeleyebilir',
    'created_at' => '2024-11-07 09:42:59',
    'updated_at' => '2024-11-07 09:42:59',
  ),
  40 => 
  array (
    'id' => 47,
    'name' => 'aday-basvurularini-incele',
    'category' => 'Aday Bursiyerler',
    'description' => 'Aday Başvurularını İnceyebilir',
    'created_at' => '2024-11-07 09:43:50',
    'updated_at' => '2025-07-14 13:28:47',
  ),
  41 => 
  array (
    'id' => 48,
    'name' => 'aktif-bursiyer-incele',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Aktif Bursiyerleri İnceleyebilir',
    'created_at' => '2024-11-07 09:45:16',
    'updated_at' => '2024-11-07 09:45:16',
  ),
  42 => 
  array (
    'id' => 49,
    'name' => 'kayit-yenileme-listele',
    'category' => 'Aday Bursiyerler',
    'description' => 'Kayıt Yenileme Başvurularını Listeleyebilir',
    'created_at' => '2024-11-07 09:46:58',
    'updated_at' => '2024-11-07 09:46:58',
  ),
  43 => 
  array (
    'id' => 50,
    'name' => 'kayit-yenileme-baslat',
    'category' => 'Kayıt Yenileme İşlemleri',
    'description' => 'Kayıt Yenileme Dönemi Başlatabilir',
    'created_at' => '2024-11-07 09:47:50',
    'updated_at' => '2024-11-07 09:47:50',
  ),
  44 => 
  array (
    'id' => 51,
    'name' => 'aktif-bursiyer-listele',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Bursiyerleri Listeleyebilir',
    'created_at' => '2024-11-07 09:48:17',
    'updated_at' => '2024-11-07 09:48:17',
  ),
  45 => 
  array (
    'id' => 52,
    'name' => 'mezun-listele',
    'category' => 'Mezunlar',
    'description' => 'Mezunlar tablosunu listeleyebilir',
    'created_at' => '2024-11-07 09:49:16',
    'updated_at' => '2024-11-07 09:49:16',
  ),
  46 => 
  array (
    'id' => 53,
    'name' => 'burs-odeme-listele',
    'category' => 'Burs Ödeme Bilgileri',
    'description' => 'Burs Ödeme Bilgisini Listeyebilir',
    'created_at' => '2024-11-07 09:49:51',
    'updated_at' => '2024-11-07 09:50:12',
  ),
  47 => 
  array (
    'id' => 54,
    'name' => 'burs-taksiti-ekle',
    'category' => 'Burs Ödeme Bilgileri',
    'description' => 'Burs Taksiti Ekleyebilir',
    'created_at' => '2024-11-07 09:51:51',
    'updated_at' => '2024-11-07 09:51:51',
  ),
  48 => 
  array (
    'id' => 55,
    'name' => 'donem-yonetimi-yonet',
    'category' => 'Tanımlar',
    'description' => 'Dönem Yönetimi Sayfasını Açabilir',
    'created_at' => '2024-11-07 09:53:18',
    'updated_at' => '2024-11-07 09:53:18',
  ),
  49 => 
  array (
    'id' => 56,
    'name' => 'donem-yonetimi-guncelle',
    'category' => 'Tanımlar',
    'description' => 'Dönem Yönetimi Bilgilerini Güncelleyebilir',
    'created_at' => '2024-11-07 09:54:05',
    'updated_at' => '2024-11-07 09:54:05',
  ),
  50 => 
  array (
    'id' => 57,
    'name' => 'mezun-incele',
    'category' => 'Mezunlar',
    'description' => 'Mezun Bilgilerini İnceleyebilir',
    'created_at' => '2024-11-07 09:56:59',
    'updated_at' => '2024-11-07 09:56:59',
  ),
  51 => 
  array (
    'id' => 58,
    'name' => 'mezun-geri-al',
    'category' => 'Mezunlar',
    'description' => 'Mezun Öğrencileri Geri Bursiyer Yapabilir',
    'created_at' => '2024-11-07 09:57:29',
    'updated_at' => '2024-11-07 09:57:29',
  ),
  52 => 
  array (
    'id' => 59,
    'name' => 'mezun-et',
    'category' => 'Mezunlar',
    'description' => 'Bursiyerleri Mezun Edebilir',
    'created_at' => '2024-11-07 09:57:58',
    'updated_at' => '2024-11-07 09:57:58',
  ),
  53 => 
  array (
    'id' => 60,
    'name' => 'bursiyer-iptal',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Bursiyerlerin Bursiyerliğini İptal Edebilir',
    'created_at' => '2024-11-07 09:58:40',
    'updated_at' => '2024-11-07 09:58:40',
  ),
  54 => 
  array (
    'id' => 61,
    'name' => 'aday-ekle',
    'category' => 'Aday Bursiyerler',
    'description' => 'Panelden Aday Ekleyebilir',
    'created_at' => '2024-11-07 09:59:05',
    'updated_at' => '2024-11-07 09:59:05',
  ),
  55 => 
  array (
    'id' => 62,
    'name' => 'bursiyer-ekle',
    'category' => 'Bursiyer İşlemleri',
    'description' => 'Aktif Bursiyer Ekleyebilir',
    'created_at' => '2024-11-07 09:59:59',
    'updated_at' => '2024-11-07 09:59:59',
  ),
  56 => 
  array (
    'id' => 63,
    'name' => 'mezun-ekle',
    'category' => 'Mezunlar',
    'description' => 'Mezun Ekleyebilir',
    'created_at' => '2024-11-07 10:00:21',
    'updated_at' => '2024-11-07 10:00:21',
  ),
  57 => 
  array (
    'id' => 64,
    'name' => 'kayit-yenileme-ekle',
    'category' => 'Kayıt Yenileme İşlemleri',
    'description' => 'Panelden Kayıt Yenileme Ekleyebilir',
    'created_at' => '2024-11-07 10:00:39',
    'updated_at' => '2024-11-07 10:00:39',
  ),
  58 => 
  array (
    'id' => 65,
    'name' => 'basvuru-form-yonet',
    'category' => 'Tanımlar',
    'description' => 'Başvuru Formlarını Yönetebilir',
    'created_at' => '2024-11-07 10:30:58',
    'updated_at' => '2024-11-07 10:30:58',
  ),
  59 => 
  array (
    'id' => 66,
    'name' => 'mail-ayarlari-yonet',
    'category' => 'Ayarlar',
    'description' => 'Mail Ayarlarını Yönetebilir',
    'created_at' => '2024-11-07 10:31:38',
    'updated_at' => '2024-11-07 10:31:38',
  ),
  60 => 
  array (
    'id' => 67,
    'name' => 'mulakat-grup-yonet',
    'category' => 'Tanımlar',
    'description' => 'Mulakat Gruplarını Yönetebilir',
    'created_at' => '2024-11-09 15:11:15',
    'updated_at' => '2024-11-09 15:12:15',
  ),
  61 => 
  array (
    'id' => 68,
    'name' => 'tanim-sekme-goruntule',
    'category' => 'Tanımlar',
    'description' => 'Tanımlar sekmesini menüde görüntüleyebilir',
    'created_at' => '2024-11-09 18:23:20',
    'updated_at' => '2024-11-09 18:23:20',
  ),
  62 => 
  array (
    'id' => 70,
    'name' => 'sms-ayarlari-yonet',
    'category' => 'Ayarlar',
    'description' => 'Sms  ayarlarını yönetebilir',
    'created_at' => '2024-12-06 18:27:18',
    'updated_at' => '2024-12-06 18:27:18',
  ),
  63 => 
  array (
    'id' => 71,
    'name' => 'tum-mulakatlar',
    'category' => 'Mülakat İşlemleri',
    'description' => 'Tüm mülakatları görüntüleyebilir.',
    'created_at' => '2024-12-29 17:17:41',
    'updated_at' => '2024-12-29 17:17:41',
  ),
  64 => 
  array (
    'id' => 72,
    'name' => 'ayarlar-versiyonlar',
    'category' => 'Ayarlar',
    'description' => 'Versiyonlari Goruntuler',
    'created_at' => '2025-01-15 11:55:12',
    'updated_at' => '2025-01-15 11:55:12',
  ),
  65 => 
  array (
    'id' => 73,
    'name' => 'data-import',
    'category' => 'Ayarlar',
    'description' => 'Data ımport yapabilir',
    'created_at' => '2025-01-20 23:26:30',
    'updated_at' => '2025-01-20 23:26:30',
  ),
  66 => 
  array (
    'id' => 74,
    'name' => 'burs-tipi-yonet',
    'category' => 'Burs Ödeme Bilgileri',
    'description' => 'Burs ödeme bilgileri düzenleme formunda burs tipini güncelleyebilir',
    'created_at' => '2025-03-04 10:25:11',
    'updated_at' => '2026-03-30 11:05:17',
  ),
  67 => 
  array (
    'id' => 75,
    'name' => 'sebepleri-yonet',
    'category' => 'Tanımlar',
    'description' => 'Sebepleri yönetebilir',
    'created_at' => '2025-03-27 23:21:05',
    'updated_at' => '2025-03-27 23:21:05',
  ),
  68 => 
  array (
    'id' => 76,
    'name' => 'otp_settings',
    'category' => 'Ayarlar',
    'description' => 'Otp ayarını açıp kapatabilir',
    'created_at' => '2025-06-03 16:51:56',
    'updated_at' => '2025-06-03 16:51:56',
  ),
  69 => 
  array (
    'id' => 77,
    'name' => 'mesaj-sablonlarini-yonet',
    'category' => 'Tanımlar',
    'description' => 'Mesaj Sablonlarını Yonet',
    'created_at' => '2025-07-30 20:41:17',
    'updated_at' => '2025-07-30 20:41:17',
  ),
  70 => 
  array (
    'id' => 78,
    'name' => 'aday-puanlarini-goruntule',
    'category' => 'Aday Bursiyerler',
    'description' => 'Puan tabinda aday puanlarini goruntuleyebilir',
    'created_at' => '2025-08-20 02:05:33',
    'updated_at' => '2025-08-20 02:05:33',
  ),
));
    }
}