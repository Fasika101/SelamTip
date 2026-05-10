<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@selemtip.com')],
            [
                'name'      => 'Super Admin',
                'email'     => env('ADMIN_EMAIL', 'admin@selemtip.com'),
                'password'  => Hash::make(env('ADMIN_PASSWORD', 'Admin@1234')),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );
    }
}
