<?php

namespace Database\Seeders;

use App\Models\FeeCategory;
use Illuminate\Database\Seeder;

class FeeCategorySeeder extends Seeder
{
    /**
     * Fee categories are school-scoped now, so this no longer runs
     * blindly. Use: php artisan schoolgear:seed-fee-categories {school_id}
     */
    public function run(): void
    {
        $this->command?->warn(
            'FeeCategorySeeder now requires a school. Run: php artisan schoolgear:seed-fee-categories {school_id}'
        );
    }

    /**
     * Starting set only. Admins can add more later from
     * Admin > Fee Categories without touching code.
     */
    public function runForSchool(int $schoolId): void
    {
        $categories = [
            ['name' => 'Registration Fees', 'code' => 'registration'],
            ['name' => 'Tuition Fees', 'code' => 'tuition'],
            ['name' => 'P.E.', 'code' => 'pe'],
            ['name' => 'Track Suit', 'code' => 'track_suit'],
            ['name' => 'ID Card', 'code' => 'id_card'],
            ['name' => 'Badge', 'code' => 'badge'],
            ['name' => 'Breakage', 'code' => 'breakage'],
            ['name' => 'Activities', 'code' => 'activities'],
            ['name' => 'Gala Day', 'code' => 'gala_day'],
            ['name' => 'Computer Fees', 'code' => 'computer'],
            ['name' => 'Science Lab Coat', 'code' => 'lab_coat'],
            ['name' => 'Science Lab Fees', 'code' => 'lab_fee'],
            ['name' => 'Neck Tie', 'code' => 'neck_tie'],
            ['name' => 'Color House Shirt', 'code' => 'house_shirt'],
            ['name' => 'Senior Class T. Shirt', 'code' => 'senior_shirt'],
            ['name' => 'First Aid', 'code' => 'first_aid'],
            ['name' => 'Compulsory Study Class', 'code' => 'study_class'],
            ['name' => 'Compulsory Saturday Class', 'code' => 'saturday_class'],
        ];

        foreach ($categories as $index => $category) {
            FeeCategory::updateOrCreate(
                ['school_id' => $schoolId, 'code' => $category['code']],
                [
                    'name' => $category['name'],
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }
}
