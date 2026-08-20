<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SebepsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sebeps')->insert(array (
  0 => 
  array (
    'id' => 1,
    'type' => 'İade',
    'text' => 'Belge Eksikliği',
    'created_at' => '2025-03-27 10:49:37',
    'updated_at' => '2025-06-04 10:34:54',
    'deleted_at' => NULL,
  ),
  1 => 
  array (
    'id' => 2,
    'type' => 'Red',
    'text' => 'Red Sebebi 1',
    'created_at' => '2025-03-27 07:56:16',
    'updated_at' => '2025-03-27 08:38:09',
    'deleted_at' => '2025-03-27 08:38:09',
  ),
  2 => 
  array (
    'id' => 3,
    'type' => 'Red',
    'text' => 'Geçersiz Başvuru',
    'created_at' => '2025-03-27 07:56:45',
    'updated_at' => '2025-05-11 20:34:48',
    'deleted_at' => NULL,
  ),
  3 => 
  array (
    'id' => 4,
    'type' => 'Red',
    'text' => 'Eksik Belge',
    'created_at' => '2025-03-27 07:57:11',
    'updated_at' => '2025-05-11 20:35:00',
    'deleted_at' => NULL,
  ),
  4 => 
  array (
    'id' => 5,
    'type' => 'Red',
    'text' => 'Ön Değerlendirme Olumsuz',
    'created_at' => '2025-03-27 07:57:25',
    'updated_at' => '2025-05-11 20:35:10',
    'deleted_at' => NULL,
  ),
  5 => 
  array (
    'id' => 6,
    'type' => 'İade',
    'text' => 'Başvuru iade ettim çünkü öyle',
    'created_at' => '2025-03-27 07:57:55',
    'updated_at' => '2025-06-04 10:35:00',
    'deleted_at' => '2025-06-04 10:35:00',
  ),
  6 => 
  array (
    'id' => 7,
    'type' => 'Red',
    'text' => 'Önceki Mülakat Olumsuz',
    'created_at' => '2025-03-27 11:42:01',
    'updated_at' => '2025-05-11 20:35:18',
    'deleted_at' => NULL,
  ),
  7 => 
  array (
    'id' => 8,
    'type' => 'Red',
    'text' => 'Diğer',
    'created_at' => '2025-05-11 20:35:27',
    'updated_at' => '2025-05-11 20:35:27',
    'deleted_at' => NULL,
  ),
  8 => 
  array (
    'id' => 9,
    'type' => 'İade',
    'text' => 'Bilgi Eksikliği',
    'created_at' => '2025-06-04 11:58:58',
    'updated_at' => '2025-06-04 11:58:58',
    'deleted_at' => NULL,
  ),
  9 => 
  array (
    'id' => 10,
    'type' => 'İade',
    'text' => 'Diğer',
    'created_at' => '2025-07-01 21:10:34',
    'updated_at' => '2025-07-01 21:10:34',
    'deleted_at' => NULL,
  ),
));
    }
}