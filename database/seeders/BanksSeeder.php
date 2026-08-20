<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('banks')->insert(array (
  0 => 
  array (
    'id' => 1,
    'bank_name' => 'banka adı',
    'bank_code' => 8,
    'created_at' => '0000-00-00 00:00:00',
    'updated_at' => '2025-01-31 09:15:40',
  ),
  1 => 
  array (
    'id' => 2,
    'bank_name' => 'yeni banka 2',
    'bank_code' => 887,
    'created_at' => '2025-02-06 07:48:16',
    'updated_at' => '2025-02-06 07:48:16',
  ),
  2 => 
  array (
    'id' => 3,
    'bank_name' => 'demo banka3',
    'bank_code' => 3443434,
    'created_at' => '2025-02-08 15:51:25',
    'updated_at' => '2025-02-08 15:51:25',
  ),
  3 => 
  array (
    'id' => 4,
    'bank_name' => 'asdasdasdasdad',
    'bank_code' => 23232322,
    'created_at' => '2025-02-24 04:19:13',
    'updated_at' => '2025-02-24 04:19:13',
  ),
));
    }
}