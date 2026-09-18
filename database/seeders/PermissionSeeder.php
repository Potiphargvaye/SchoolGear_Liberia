<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions before seeding
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Dashboard
            'view dashboard',

            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',

            // Students
            'view students',
            'create students',
            'edit students',
            'delete students',
            'manage students',
            'view student details',

            // Courses & Lessons
            'view courses',
            'manage categories',
            'view lessons',
            'create lessons',
            'edit lessons',
            'delete lessons',

            // Enrollments
            'view enrollments',
            'approve enrollments',
            'reject enrollments',

            // Assignments, Quizzes & Academic
            'create assignments',
            'grade assignments',
            'manage grade assignments',
            'create quizzes',
            'manage quizzes',
            'assign grades',
            'enter student grades',
            'edit student grades',
            'lock & unlock grade submission',

            // Fees & Finance
            'view fees',
            'view fee details',
            'manage fees',
            'edit fees',
            'delete fees',
            'generate receipts',

            // Announcements & Certificates
            'manage announcements',
            'issue certificates',

            // Reports & Attendance
            'view reports',
            'view report',
            'view academic reports',
            'manage attendance',

            // Settings, Roles & Permissions
            'manage settings',


            /*
    |--------------------------------------------------------------------------
    | Roles
    |---------------------------------  -----------------------------------------
    */

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'manage roles',


            'view schools',
            'create schools',
            'edit schools',
            'delete schools',

            /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'manage permissions',






        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
