<?php

namespace App\Console\Commands;

use App\Models\School;
use Database\Seeders\FeeCategorySeeder;
use Illuminate\Console\Command;

class SeedSchoolFeeCategories extends Command
{
    protected $signature = 'schoolgear:seed-fee-categories {school_id : The ID of the school to seed default fee categories for}';

    protected $description = 'Seed the default fee categories for a specific school';

    public function handle(): int
    {
        $schoolId = (int) $this->argument('school_id');

        $school = School::find($schoolId);

        if (! $school) {
            $this->error("No school found with ID {$schoolId}.");
            return self::FAILURE;
        }

        (new FeeCategorySeeder())->runForSchool($schoolId);

        $this->info("Default fee categories seeded for \"{$school->school_name}\" (ID {$schoolId}).");

        return self::SUCCESS;
    }
}
