<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'kadir@digitalambar.com'],
            [
                'name' => 'kadir',
                'surname' => '',
                'password' => Hash::make('password'),
                'role_id' => 3
            ]
        );
    }
}
