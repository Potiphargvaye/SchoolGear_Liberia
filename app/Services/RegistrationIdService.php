<?php

namespace App\Services;

use App\Models\User;

class RegistrationIdService
{
    /**
     * Generate the next unique Student Registration ID.
     *
     * Format: LIPA/STU/{year}/{4-digit sequence} — e.g. LIPA/STU/2026/0001
     *
     * IMPORTANT: This is extracted verbatim from the original logic in
     * RegisteredUserController@store. The algorithm and format are
     * unchanged — only the location has moved, so both Public Registration 
     * and Admin Registration call this single source of truth instead of
     * duplicating the loop.
     */
    public function generate(): string
    {
        $year = now()->year;

        $lastStudent = User::role('Student')
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;

        if (
            $lastStudent &&
            preg_match('/(\d+)$/', $lastStudent->registration_id, $matches)
        ) {
            $nextNumber = (int) $matches[1] + 1;
        }

        do {
            $registrationId =
                'EMMMBHS' .
                $year .
                '/' .
                str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $nextNumber++;
        } while (
            User::where('registration_id', $registrationId)->exists()
        );

        return $registrationId;
    }



    /**
     * Generate the next unique Staff/Owner Registration ID.
     *
     * Format: LIPA/{year}/{3-digit sequence} — e.g. LIPA/2026/001
     *
     * Mirrors the existing logic in Admin\AccessControl\UserController@store.
     * Used for staff accounts, and now also for the initial School Owner
     * account created during School registration (Phase 2).
     */
    public function generateForStaff(): string
    {
        $year = now()->year;

        $lastStaff = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Student');
        })
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;

        if (
            $lastStaff &&
            preg_match('/(\d+)$/', $lastStaff->registration_id, $matches)
        ) {
            $nextNumber = (int) $matches[1] + 1;
        }

        do {
            $registrationId =
                'Staff/EMMMBHS' .
                $year .
                '/' .
                str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            $nextNumber++;
        } while (
            User::where('registration_id', $registrationId)->exists()
        );

        return $registrationId;
    }

    /**
     * Generate the next unique School Registration ID.
     *
     * Format: SGL/{year}/{3-digit sequence} — e.g. SGL/2026/001
     *
     * Same algorithm/convention as generate() and generateForStaff(),
     * applied to the schools table instead of users. Phase 2 addition.
     */
    public function generateForSchool(): string
    {
        $year = now()->year;

        $lastSchool = \App\Models\School::orderByDesc('id')->first();

        $nextNumber = 1;

        if (
            $lastSchool &&
            preg_match('/(\d+)$/', $lastSchool->registration_id, $matches)
        ) {
            $nextNumber = (int) $matches[1] + 1;
        }

        do {
            $registrationId =
                'SGL/' .
                $year .
                '/' .
                str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            $nextNumber++;
        } while (
            \App\Models\School::where('registration_id', $registrationId)->exists()
        );

        return $registrationId;
    }



    /**
     * Generate the next unique Admission Number.
     *
     * Format: ADM/{year}/{5-digit sequence} — e.g. ADM/2026/00001
     *
     * Global, platform-wide sequence, same convention as generateForStaff()
     * and generateForSchool() — admission_number is not used for login,
     * so no per-school scoping constraint applies here.
     */
    public function generateForAdmission(): string
    {
        $year = now()->year;

        $lastAdmission = \App\Models\Admission::orderByDesc('id')->first();

        $nextNumber = 1;

        if (
            $lastAdmission &&
            preg_match('/(\d+)$/', $lastAdmission->admission_number, $matches)
        ) {
            $nextNumber = (int) $matches[1] + 1;
        }

        do {
            $admissionNumber =
                'ADM/' .
                $year .
                '/' .
                str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $nextNumber++;
        } while (
            \App\Models\Admission::where('admission_number', $admissionNumber)->exists()
        );

        return $admissionNumber;
    }
}
