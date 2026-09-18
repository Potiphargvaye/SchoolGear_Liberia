<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_locks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('grade_id')->constrained('grades')->restrictOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnDelete();

            $table->string('semester'); // sem1 or sem2
            $table->boolean('is_locked')->default(false);

            $table->timestamps();

            $table->unique(['school_id', 'grade_id', 'academic_year_id', 'semester'], 'grade_locks_school_grade_year_sem_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_locks');
    }
};
