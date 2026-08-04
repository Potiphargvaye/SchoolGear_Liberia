<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicSubject;

class AcademicSubjectSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Subject Lists
        |--------------------------------------------------------------------------
        | Keep these arrays updated whenever you add new subjects.
        | Existing subjects will NOT be duplicated.
        | Existing IDs will NEVER change.
        |--------------------------------------------------------------------------
        */

        $subjects = [

            'kindergarten' => [
                'Bible',
                'English',
                'Reciting ',
                'Phonics',
                'Math',
                'General Science',
                'Social Studies',
                'Spelling',
                'Writing',
                'P.E.',
                'Health Science',
                'Drawing',
                'Reading',
            ],

            'elementary' => [
                'Bible',
                'Mathematics',
                'English',
                'Phonics',
                'Reading',
                'Spelling',
                'General Science',
                'Health Science',
                'Social Studies',
                'Computer',
                'Writing',
                'Drawing',
                'P.E.',
            ],

            'junior' => [
                'Bible',
                'Mathematics',
                'English',
                'Phonics',
                'Literature',
                'Vocabulary',
                'General Science',
                'History',
                'Geography',
                'Civics',
                'Computer',
                'P.E.',
            ],

            'senior' => [
                'Bible',
                'Mathematics',
                'English Lang',
                'Oral English',
                'Literature',
                'Biology',
                'Chemistry',
                'Physics',
                'History',
                'Geography',
                'Government',
                'Economics',
                'Computer',
                'ROTC',
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | Insert New Subjects Only
        |--------------------------------------------------------------------------
        */

        foreach ($subjects as $level => $subjectList) {

            foreach ($subjectList as $subjectName) {

                AcademicSubject::firstOrCreate(
                    [
                        'name'  => $subjectName,
                        'level' => $level,
                    ]
                );

            }

        }
    }
}