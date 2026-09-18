<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicSubject;

class AcademicSubjectSeeder extends Seeder
{
    /**
     * Default seeder entry — no longer runs automatically for "the"
     * platform, since subjects are now school-scoped. Kept only to avoid
     * breaking `php artisan db:seed` if this class is referenced in
     * DatabaseSeeder; it intentionally does nothing without a school.
     * Use `php artisan schoolgear:seed-subjects {school_id}` instead.
     */
    public function run(): void
    {
        $this->command?->warn(
            'AcademicSubjectSeeder now requires a school. Run: php artisan schoolgear:seed-subjects {school_id}'
        );
    }

    /**
     * The actual seeding logic, scoped to one school. Called by the
     * schoolgear:seed-subjects artisan command.
     */
    public function runForSchool(int $schoolId): void
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
        | Insert New Subjects Only, Scoped To This School
        |--------------------------------------------------------------------------
        */

        foreach ($subjects as $level => $subjectList) {

            foreach ($subjectList as $subjectName) {

                AcademicSubject::firstOrCreate([
                    'school_id' => $schoolId,
                    'name' => $subjectName,
                    'level' => $level,
                ]);
            }
        }
    }
}
