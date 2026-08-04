<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
// database/seeders/SubjectSeeder.php
public function run()
{
    $subjects = [
        ['name' => 'Math', 'code' => 'MATH'],
        ['name' => 'English', 'code' => 'ENG'],
        ['name' => 'Biology', 'code' => 'BIO'],
        ['name' => 'Physics', 'code' => 'PHY'],
        ['name' => 'Chemistry', 'code' => 'CHEM'],
        ['name' => 'History', 'code' => 'HIST'],
        ['name' => 'Geography', 'code' => 'GEO'],
        ['name' => 'Science', 'code' => 'SCNC'],
    ];

    foreach ($subjects as $subject) {
        \App\Models\Subject::create($subject);
    }
}

}
