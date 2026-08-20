<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoruKategorisSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('soru_kategoris')->insert(array (
  0 => 
  array (
    'id' => 1,
    'title' => 'Genel Bilgiler',
    'siralama' => 1,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '0000-00-00 00:00:00',
  ),
  1 => 
  array (
    'id' => 2,
    'title' => 'Kişisel Bilgiler',
    'siralama' => 2,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '2024-09-01 20:07:50',
  ),
  2 => 
  array (
    'id' => 7,
    'title' => 'Eğitim Bilgileri',
    'siralama' => 3,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:40:32',
    'updated_at' => '2024-09-04 08:06:38',
  ),
  3 => 
  array (
    'id' => 8,
    'title' => 'Kalınan Yer Bilgileri',
    'siralama' => 4,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:42:04',
    'updated_at' => '2024-09-04 08:09:39',
  ),
  4 => 
  array (
    'id' => 9,
    'title' => 'Aile Adres Bilgileri',
    'siralama' => 6,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-04 08:10:23',
  ),
  5 => 
  array (
    'id' => 10,
    'title' => 'Ebeveyn Bilgileri
',
    'siralama' => 5,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-04 08:10:23',
  ),
  6 => 
  array (
    'id' => 11,
    'title' => 'Kardeş Bilgileri
',
    'siralama' => 7,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-04 08:10:23',
  ),
  7 => 
  array (
    'id' => 12,
    'title' => 'Gelir Beyanı
',
    'siralama' => 8,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-04 08:10:23',
  ),
  8 => 
  array (
    'id' => 13,
    'title' => 'Diğer Burslar

',
    'siralama' => 9,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-04 08:10:23',
  ),
  9 => 
  array (
    'id' => 14,
    'title' => 'Engel Durumu

',
    'siralama' => 10,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-04 08:10:23',
  ),
  10 => 
  array (
    'id' => 15,
    'title' => 'Sosyal Bilgiler',
    'siralama' => 11,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-04 08:10:23',
  ),
  11 => 
  array (
    'id' => 16,
    'title' => 'Hesap Bilgileri',
    'siralama' => 12,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-04 08:10:23',
  ),
  12 => 
  array (
    'id' => 17,
    'title' => 'İş Bilgileri',
    'siralama' => 13,
    'status' => 'Aktif',
    'forms' => '["onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-14 10:43:40',
  ),
  13 => 
  array (
    'id' => 18,
    'title' => 'Belge Yükleme',
    'siralama' => 14,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2024-09-04 07:43:28',
    'updated_at' => '2024-09-04 08:10:23',
  ),
  14 => 
  array (
    'id' => 21,
    'title' => 'Belge Onayı',
    'siralama' => 15,
    'status' => 'Aktif',
    'forms' => '["ilkokul","ortaokul","lise","onlisans","lisans","yukseklisans","doktora"]',
    'created_at' => '2025-05-12 00:45:15',
    'updated_at' => '2025-05-12 00:45:15',
  ),
  15 => 
  array (
    'id' => 22,
    'title' => 'burs deneme',
    'siralama' => 16,
    'status' => 'Pasif',
    'forms' => '["ilkokul"]',
    'created_at' => '2025-08-13 17:08:52',
    'updated_at' => '2025-08-13 17:16:36',
  ),
));
    }
}