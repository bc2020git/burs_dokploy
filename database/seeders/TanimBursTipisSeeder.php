<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanimBursTipisSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tanim_burs_tipis')->insert(array (
  0 => 
  array (
    'id' => 2,
    'burs_tipi' => 'İlkokul Bursu',
    'ogrenim_tipi' => 'ilkokul',
    'created_at' => '2025-01-23 21:52:28',
    'updated_at' => '2026-04-06 21:46:03',
  ),
  1 => 
  array (
    'id' => 3,
    'burs_tipi' => 'Ortaokul Bursu',
    'ogrenim_tipi' => 'ortaokul',
    'created_at' => '2025-01-23 21:52:34',
    'updated_at' => '2026-04-06 21:44:29',
  ),
  2 => 
  array (
    'id' => 4,
    'burs_tipi' => 'Lise Bursu',
    'ogrenim_tipi' => 'lise',
    'created_at' => '2025-01-23 21:52:39',
    'updated_at' => '2026-04-06 21:54:25',
  ),
  3 => 
  array (
    'id' => 5,
    'burs_tipi' => 'Lisans Bursu',
    'ogrenim_tipi' => NULL,
    'created_at' => '2025-01-23 21:52:44',
    'updated_at' => '2025-01-23 21:52:44',
  ),
  4 => 
  array (
    'id' => 6,
    'burs_tipi' => 'Yüksek Lisans Bursu',
    'ogrenim_tipi' => NULL,
    'created_at' => '2025-01-23 21:52:50',
    'updated_at' => '2025-01-23 21:52:50',
  ),
  5 => 
  array (
    'id' => 7,
    'burs_tipi' => 'Lisans Aylin Koloğlu Üstün Başarı Tıp Bursu',
    'ogrenim_tipi' => NULL,
    'created_at' => '2025-01-23 21:53:00',
    'updated_at' => '2025-01-23 21:53:00',
  ),
  6 => 
  array (
    'id' => 8,
    'burs_tipi' => 'Lisans Üstün Başarı Hukuk Bursu',
    'ogrenim_tipi' => NULL,
    'created_at' => '2025-01-23 21:53:06',
    'updated_at' => '2025-01-23 21:53:06',
  ),
  7 => 
  array (
    'id' => 9,
    'burs_tipi' => 'Üstün Başarı Sanat Bursu',
    'ogrenim_tipi' => NULL,
    'created_at' => '2025-01-23 21:53:12',
    'updated_at' => '2025-01-23 21:53:12',
  ),
  8 => 
  array (
    'id' => 10,
    'burs_tipi' => 'Eğitim Yardımı',
    'ogrenim_tipi' => 'tumu',
    'created_at' => '2025-01-23 21:53:16',
    'updated_at' => '2026-03-30 13:51:51',
  ),
  9 => 
  array (
    'id' => 11,
    'burs_tipi' => 'Deprem Bursu',
    'ogrenim_tipi' => 'tumu',
    'created_at' => '2025-01-23 21:53:20',
    'updated_at' => '2026-03-30 13:51:36',
  ),
  10 => 
  array (
    'id' => 18,
    'burs_tipi' => 'İlkokul Bursu 06-04-2026',
    'ogrenim_tipi' => 'ilkokul',
    'created_at' => '2026-04-06 21:59:06',
    'updated_at' => '2026-04-06 21:59:06',
  ),
));
    }
}