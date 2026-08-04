<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Students
            'view students',
            'manage students',
            'view student details',
            'edit students',
            'delete students',
            'manage grade assignments',  
            // Fees
            'view fees',
            'view fee details',
            'manage fees',
            'edit fees',
            'delete fees',
            'generate receipts',

            // Academic
            'assign grades',

            // Users
            'manage users',

            // Announcements
            'manage announcements',

            // Reports (future)
            'view academic reports',
            'manage attendance',

            // System
            
            'view dashboard',
            // <-- CHANGE: Added permission to allow editing grades
             'enter student grades',
              'edit student grades', 
              'lock & unlock grade submission',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }
    }  
}