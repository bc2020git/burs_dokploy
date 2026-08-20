<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert(array (
  0 => 
  array (
    'id' => 3,
    'name' => 'Sistem Yönetici',
    'description' => 'Sistem Ana Yönetici Rolüdür. Tüm izinler açıktır',
    'created_at' => '2024-10-07 22:47:58',
    'updated_at' => '2024-11-28 23:03:38',
  ),
  1 => 
  array (
    'id' => 6,
    'name' => 'Tekil mulakat kisi',
    'description' => 'Adaylara  mülakat  oluşturabilir ve  mülakatını yaptığı aday  formlarını  inceleyebilir',
    'created_at' => '2024-11-25 19:46:10',
    'updated_at' => '2024-11-27 21:29:31',
  ),
  2 => 
  array (
    'id' => 7,
    'name' => 'SACDD Yonetici',
    'description' => 'SACDD YONETICI',
    'created_at' => '2024-12-29 17:14:33',
    'updated_at' => '2025-01-03 23:56:50',
  ),
));
    }
}