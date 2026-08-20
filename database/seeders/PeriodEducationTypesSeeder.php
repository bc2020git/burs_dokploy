<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodEducationTypesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('period_education_types')->insert(array (
  0 => 
  array (
    'period_id' => 65,
    'id' => 684,
    'educationType' => 'lise',
    'created_at' => '2025-09-12 20:07:39',
    'updated_at' => '2025-09-12 20:07:39',
  ),
  1 => 
  array (
    'period_id' => 65,
    'id' => 685,
    'educationType' => 'lisans',
    'created_at' => '2025-09-12 20:07:39',
    'updated_at' => '2025-09-12 20:07:39',
  ),
  2 => 
  array (
    'period_id' => 65,
    'id' => 686,
    'educationType' => 'yukseklisans',
    'created_at' => '2025-09-12 20:07:39',
    'updated_at' => '2025-09-12 20:07:39',
  ),
  3 => 
  array (
    'period_id' => 74,
    'id' => 690,
    'educationType' => 'lisans',
    'created_at' => '2025-09-26 14:01:08',
    'updated_at' => '2025-09-26 14:01:08',
  ),
  4 => 
  array (
    'period_id' => 74,
    'id' => 691,
    'educationType' => 'yukseklisans',
    'created_at' => '2025-09-26 14:01:08',
    'updated_at' => '2025-09-26 14:01:08',
  ),
  5 => 
  array (
    'period_id' => 73,
    'id' => 692,
    'educationType' => 'doktora',
    'created_at' => '2025-10-03 02:40:48',
    'updated_at' => '2025-10-03 02:40:48',
  ),
  6 => 
  array (
    'period_id' => 75,
    'id' => 693,
    'educationType' => 'ilkokul',
    'created_at' => '2026-01-20 13:47:54',
    'updated_at' => '2026-01-20 13:47:54',
  ),
  7 => 
  array (
    'period_id' => 75,
    'id' => 694,
    'educationType' => 'ortaokul',
    'created_at' => '2026-01-20 13:47:54',
    'updated_at' => '2026-01-20 13:47:54',
  ),
  8 => 
  array (
    'period_id' => 75,
    'id' => 695,
    'educationType' => 'lise',
    'created_at' => '2026-01-20 13:47:54',
    'updated_at' => '2026-01-20 13:47:54',
  ),
));
    }
}