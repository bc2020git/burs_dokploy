<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CacheSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cache')->insert(array (
  0 => 
  array (
    'key' => 'otp_korekenkadir@gmail.com',
    'value' => 'i:1993;',
    'expiration' => 1730555010,
  ),
));
    }
}