<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OtpSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('otp_settings')->insert(array (
  0 => 
  array (
    'id' => 1,
    'otp_status' => 0,
    'crm_otp_status' => 0,
    'portal_otp_status' => 0,
    'sms_status' => 0,
    'email_status' => 0,
    'created_at' => '2025-06-03 12:51:33',
    'updated_at' => '2025-09-19 11:15:49',
  ),
));
    }
}