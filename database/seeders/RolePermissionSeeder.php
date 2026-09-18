<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions before running
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */
        $superAdmin = Role::findByName('Super Admin', 'web');
        $superAdmin->syncPermissions(
            Permission::pluck('name')->toArray()
        );

        /*
        |--------------------------------------------------------------------------
        | Administrator  
        |--------------------------------------------------------------------------
        */
        $admin = Role::findByName('Administrator', 'web');
        $admin->syncPermissions([
            // General & Dashboard
            'view dashboard',

            // Users Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',

            // Students Management
            'view students',
            'create students',
            'edit students',
            'delete students',
            'manage students',
            'view student details',

            // Categories, Courses & Lessons
            'manage categories',
            'view courses',
            'view lessons',
            'create lessons',
            'edit lessons',
            'delete lessons',

            // Enrollments
            'view enrollments',
            'approve enrollments',
            'reject enrollments',

            // Assignments, Quizzes & Grades
            'create assignments',
            'grade assignments',
            'create quizzes',
            'manage quizzes',
            'assign grades',
            'enter student grades',
            'edit student grades',
            'lock & unlock grade submission',
            'manage grade assignments',

            // Fees & Receipts
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
            'view academic reports',
            'manage attendance',


            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'manage roles',

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
        ]);

        /*
        |--------------------------------------------------------------------------
        | Teacher
        |--------------------------------------------------------------------------
        */
        $teacher = Role::findByName('Teacher', 'web');
        $teacher->syncPermissions([
            'view dashboard',
            'view students',
            'view courses',
            'view lessons',
            'create lessons',
            'edit lessons',
            'view enrollments',
            'create assignments',
            'grade assignments',
            'create quizzes',
            'manage announcements',
            'view reports',
            'view report',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Student
        |--------------------------------------------------------------------------
        */
        Role::findByName('Student', 'web')->syncPermissions([]);

        /*
        |--------------------------------------------------------------------------
        | HR
        |--------------------------------------------------------------------------
        */
        Role::findByName('HR', 'web')->syncPermissions([
            'view dashboard',
            'view users',
            'create users',
            'edit users',
            'view reports',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Finance
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | Registrar
        |--------------------------------------------------------------------------
        */
        Role::findByName('Registrar', 'web')->syncPermissions([
            'view dashboard',
            'view students',
            'create students',
            'edit students',
            'view enrollments',
            'approve enrollments',
        ]);
    }
}
