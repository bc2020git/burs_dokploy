<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanimFormsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tanim_forms')->insert(array (
  0 => 
  array (
    'id' => 1,
    'title' => 'Ilkokul Basvuru Formu',
    'type' => 'ilkokul',
    'status' => 'Aktif',
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '2024-09-14 07:48:53',
  ),
  1 => 
  array (
    'id' => 2,
    'title' => 'Ortaokul Basvuru Formu',
    'type' => 'ortaokul',
    'status' => 'Aktif',
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '2024-09-14 07:48:53',
  ),
  2 => 
  array (
    'id' => 3,
    'title' => 'Lise Basvuru Formu',
    'type' => 'lise',
    'status' => 'Aktif',
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '2024-09-14 07:48:53',
  ),
  3 => 
  array (
    'id' => 4,
    'title' => 'Önlisans Basvuru Formu',
    'type' => 'onlisans',
    'status' => 'Aktif',
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '2024-09-14 07:48:53',
  ),
  4 => 
  array (
    'id' => 5,
    'title' => 'Lisans Basvuru Formu',
    'type' => 'lisans',
    'status' => 'Aktif',
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '2024-09-14 07:48:53',
  ),
  5 => 
  array (
    'id' => 6,
    'title' => 'Yüksek Lisans Basvuru Formu',
    'type' => 'yukseklisans',
    'status' => 'Aktif',
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '2024-09-14 07:48:53',
  ),
  6 => 
  array (
    'id' => 7,
    'title' => 'Doktora Basvuru Formu',
    'type' => 'doktora',
    'status' => 'Aktif',
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '2024-09-14 07:48:53',
  ),
));
    }
}