<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            [
                'name' => 'September 2025/2026',
                'is_active' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'September 2026/2027',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'September 2027/2028',
                'is_active' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($years as $year) {
            AcademicYear::updateOrCreate(
                ['name' => $year['name']],
                $year
            );
        }
    }
}
