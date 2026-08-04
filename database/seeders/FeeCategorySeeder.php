<?php

namespace Database\Seeders;

use App\Models\FeeCategory;
use Illuminate\Database\Seeder;

class FeeCategorySeeder extends Seeder
{
    /**
     * These are just the starting set — new categories can be added later
     * from Admin > Fee Categories without touching any code.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Registration', 'code' => 'registration'],
            ['name' => 'Tuition', 'code' => 'tuition'],
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
                ['code' => $category['code']],
                [
                    'name' => $category['name'],
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }
}
