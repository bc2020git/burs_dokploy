<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permission_categories')->insert(array (
  0 => 
  array (
    'id' => 1,
    'title' => 'Aday Bursiyerler',
    'created_at' => '2024-10-16 17:05:34',
    'updated_at' => '2024-10-16 17:05:34',
  ),
  1 => 
  array (
    'id' => 2,
    'title' => 'Mülakat İşlemleri',
    'created_at' => '2024-11-07 09:31:48',
    'updated_at' => '2024-11-07 09:31:48',
  ),
  2 => 
  array (
    'id' => 3,
    'title' => 'Kayıt Yenileme İşlemleri',
    'created_at' => '2024-11-07 09:32:21',
    'updated_at' => '2024-11-07 09:32:21',
  ),
  3 => 
  array (
    'id' => 4,
    'title' => 'Bursiyer İşlemleri',
    'created_at' => '2024-11-07 09:32:27',
    'updated_at' => '2024-11-07 09:32:27',
  ),
  4 => 
  array (
    'id' => 5,
    'title' => 'Burs Ödeme Bilgileri',
    'created_at' => '2024-11-07 09:32:40',
    'updated_at' => '2024-11-07 09:32:40',
  ),
  5 => 
  array (
    'id' => 6,
    'title' => 'Mezunlar',
    'created_at' => '2024-11-07 09:32:48',
    'updated_at' => '2024-11-07 09:32:48',
  ),
  6 => 
  array (
    'id' => 8,
    'title' => 'Tanımlar',
    'created_at' => '2024-11-07 09:33:00',
    'updated_at' => '2024-11-07 09:33:00',
  ),
  7 => 
  array (
    'id' => 9,
    'title' => 'Ayarlar',
    'created_at' => '2024-11-07 09:33:54',
    'updated_at' => '2024-11-07 09:33:54',
  ),
));
    }
}