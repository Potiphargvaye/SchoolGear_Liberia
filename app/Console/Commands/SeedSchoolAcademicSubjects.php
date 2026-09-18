<?php

namespace App\Console\Commands;

use App\Models\School;
use Database\Seeders\AcademicSubjectSeeder;
use Illuminate\Console\Command;

class SeedSchoolAcademicSubjects extends Command
{
    protected $signature = 'schoolgear:seed-subjects {school_id : The ID of the school to seed default academic subjects for}';

    protected $description = 'Seed the default academic subject list for a specific school (manual, per-school — no admin UI yet)';

    public function handle(): int
    {
        $schoolId = $this->argument('school_id');

        $school = School::find($schoolId);

        if (! $school) {
            $this->error("No school found with ID {$schoolId}.");
            return self::FAILURE;
        }

        (new AcademicSubjectSeeder())->runForSchool($schoolId);

        $this->info("Default academic subjects seeded for \"{$school->school_name}\" (ID {$schoolId}).");

        return self::SUCCESS;
    }
}
