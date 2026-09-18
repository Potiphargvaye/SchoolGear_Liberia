<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();

            // Replaces the old student_id + grade_level + academic_year
            // string trio — enrollment already carries student, grade,
            // academic year, and school context in one place.
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();

            $table->foreignId('academic_subject_id')->constrained('academic_subjects')->cascadeOnDelete();

            // First semester
            $table->integer('period1')->nullable();
            $table->integer('period2')->nullable();
            $table->integer('period3')->nullable();
            $table->integer('exam1')->nullable();

            // Second semester
            $table->integer('period4')->nullable();
            $table->integer('period5')->nullable();
            $table->integer('period6')->nullable();
            $table->integer('exam2')->nullable();

            $table->timestamps();

            $table->unique(['enrollment_id', 'academic_subject_id'], 'student_grades_enrollment_subject_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
