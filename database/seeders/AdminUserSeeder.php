<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'registration_id' => 'EDMOL/1994',
            'email' => 'emmmbhs@gmail.com', // Fixed: removed duplicate email field
            'email_verified_at' => now(),
            'password' => Hash::make('edmol1994'), // Added missing password field
            'remember_token' => Str::random(10),
            'role' => 'admin',
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
} 