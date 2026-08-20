<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterviewGroupsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('interview_groups')->insert(array (
  0 => 
  array (
    'id' => 21,
    'name' => 'Grup 1',
    'members' => '["13"]',
    'created_at' => '2025-06-19 13:22:40',
    'updated_at' => '2025-11-11 17:57:17',
  ),
  1 => 
  array (
    'id' => 23,
    'name' => 'Grup 2',
    'members' => '["13"]',
    'created_at' => '2025-07-23 15:09:16',
    'updated_at' => '2025-07-23 15:09:16',
  ),
  2 => 
  array (
    'id' => 26,
    'name' => 'deneme mulakat kisisi',
    'members' => '["12"]',
    'created_at' => '2025-08-15 14:02:51',
    'updated_at' => '2025-08-15 14:02:51',
  ),
));
    }
}