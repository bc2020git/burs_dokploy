<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sessions')->insert(array (
  0 => 
  array (
    'id' => 'KH7qbcwrl9ArcyqsMj3JHcLkDbfYbuz9XA6tUwVu',
    'user_id' => 5,
    'ip_address' => '127.0.0.1',
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:149.0) Gecko/20100101 Firefox/149.0',
    'payload' => 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidE03SklMeXIwM1d1MXE3UXNsVjlzNHY0bkFRZFhpT3ZENjlHMlp5SCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ5OiJodHRwczovL2J1cnNzYWNkZC5ob3N0L3BhbmVsL0J1cnMtT2RlbWUtQmlsZ2lsZXJpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTtzOjc6InNpZGViYXIiO2k6Njt9',
    'last_activity' => 1775566622,
  ),
));
    }
}