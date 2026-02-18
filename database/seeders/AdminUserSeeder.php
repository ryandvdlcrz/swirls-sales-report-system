<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],

            [
                'username' => 'admin',
                'password' => Hash::make(config('app.admin_password', 'admin123')),
                'role' => 'admin',
                'branch_id' => null,
            ]

            );
    }
}
