<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('periods')->insert(array (
  0 => 
  array (
    'id' => 65,
    'title' => '2025-2026 Güz Dönemi',
    'type' => 0,
    'status' => 1,
    'path' => '2025-2026-guz-donemi',
    'start_time' => '2025-09-01',
    'end_time' => '2025-09-21',
    'created_at' => '2025-08-30 17:32:04',
    'updated_at' => '2025-11-05 18:00:55',
    'is_started' => 0,
    'is_ended' => 0,
  ),
  1 => 
  array (
    'id' => 73,
    'title' => '2025-2026 Güz Dönemi',
    'type' => 1,
    'status' => 0,
    'path' => '2025-2026-guz-donemi',
    'start_time' => '2025-09-10',
    'end_time' => '2025-10-10',
    'created_at' => '2025-09-11 03:52:40',
    'updated_at' => '2026-01-20 13:52:08',
    'is_started' => 0,
    'is_ended' => 0,
  ),
  2 => 
  array (
    'id' => 74,
    'title' => '2025-2026 Güz Dönemi',
    'type' => 1,
    'status' => 0,
    'path' => '2025-2026-guz-donemi',
    'start_time' => '2025-09-10',
    'end_time' => '2025-10-10',
    'created_at' => '2025-09-11 03:56:23',
    'updated_at' => '2026-01-20 13:46:51',
    'is_started' => 0,
    'is_ended' => 0,
  ),
  3 => 
  array (
    'id' => 75,
    'title' => '2025-2026 Bahar Dönemi',
    'type' => 1,
    'status' => 1,
    'path' => '2025-2026-bahar-donemi',
    'start_time' => '2026-01-20',
    'end_time' => '2026-01-30',
    'created_at' => '2026-01-20 13:47:54',
    'updated_at' => '2026-01-20 13:52:08',
    'is_started' => 1,
    'is_ended' => 0,
  ),
));
    }
}