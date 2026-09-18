<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(

            [
                'email' => 'emmmbhs@gmail.com'
            ],

            [

                'registration_id' => 'LIPA/2026/0000',

                'name' => 'Super Administrator',

                'email_verified_at' => now(),

                'password' => Hash::make('edmol123'),

                'image' => null,

                'status' => 'active',

                'last_login_at' => null,

                'remember_token' => Str::random(10),

            ]

        );

        // Prevent duplicate role assignments   
        if (! $admin->hasRole('Super Admin')) {
            $admin->assignRole('Super Admin');
        }
    }
}
