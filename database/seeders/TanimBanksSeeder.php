<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanimBanksSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tanim_banks')->insert(array (
  0 => 
  array (
    'id' => 4,
    'name' => 'sd',
    'code' => 123,
    'created_at' => '2024-12-15 21:23:49',
    'updated_at' => '2024-12-15 21:23:49',
  ),
));
    }
}