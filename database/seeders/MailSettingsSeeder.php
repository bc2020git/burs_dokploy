<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MailSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mail_settings')->insert(array (
  0 => 
  array (
    'id' => 1,
    'type' => 'smtp',
    'is_active' => 0,
    'host' => 'smtp.sendgrid.net',
    'port' => 587,
    'username' => 'apikey',
    'password' => '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',
    'encryption' => 'tls',
    'from_address' => 'burs@sacdd.org.tr',
    'from_name' => 'SACDD BURS',
    'api_key' => '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',
    'created_at' => '2024-10-18 03:02:51',
    'updated_at' => '2025-08-27 16:24:40',
    'useinbox_api_key' => NULL,
  ),
  1 => 
  array (
    'id' => 2,
    'type' => 'sendgrid',
    'is_active' => 1,
    'host' => 'smtp.sendgrid.net',
    'port' => 587,
    'username' => 'apikey',
    'password' => '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',
    'encryption' => 'tls',
    'from_address' => 'burs@sacdd.org.tr',
    'from_name' => 'SACDD BURS',
    'api_key' => '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',
    'created_at' => '2025-06-03 16:52:09',
    'updated_at' => '2025-08-27 16:24:40',
    'useinbox_api_key' => NULL,
  ),
));
    }
}