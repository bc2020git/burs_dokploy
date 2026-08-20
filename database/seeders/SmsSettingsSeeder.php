<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmsSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sms_settings')->insert(array (
  0 => 
  array (
    'id' => 1,
    'provider' => 'netgsm',
    'username' => '8503058943',
    'password' => 'V3-X4V94',
    'header' => 'SACDD',
    'balance' => '0.00',
    'is_active' => 1,
    'last_balance_check' => '2024-11-24 00:14:20',
    'api_key' => NULL,
    'secret_key' => NULL,
    'created_at' => '2024-11-24 00:14:20',
    'updated_at' => '2024-12-06 18:56:32',
  ),
));
    }
}