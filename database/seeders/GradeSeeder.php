<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            'K-3',
            'K-4',
            'K-5',
            'Grade 1',
            'Grade 2',
            'Grade 3',
            'Grade 4',
            'Grade 5',
            'Grade 6',
            'Grade 7',
            'Grade 8',
            'Grade 9',
            'Grade 10',
            'Grade 11',
            'Grade 12',
        ];

        foreach ($grades as $level) {
            Grade::firstOrCreate([
                'level' => $level,
                'section' => null,
            ]);
        }
        $this->command->info('Grades K-G to Grade 12 seeded successfully!');
    }
}
