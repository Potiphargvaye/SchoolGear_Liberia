<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_locks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnDelete();

            // Null grade_id = lock applies to every grade in the school.
            $table->foreignId('grade_id')->nullable()->constrained('grades')->cascadeOnDelete();

            // Exactly one of these three defines the lock's scope,
            // matching the paper sheet's three natural granularities:
            // a single day, a week, or a whole period/semester.
            $table->enum('lock_type', ['date', 'week', 'semester']);
            $table->date('date')->nullable();          // used when lock_type = 'date'
            $table->date('week_start_date')->nullable(); // used when lock_type = 'week'
            $table->date('week_end_date')->nullable();
            $table->string('semester')->nullable();     // used when lock_type = 'semester' (sem1/sem2)

            $table->boolean('is_locked')->default(true);
            $table->foreignId('locked_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['school_id', 'academic_year_id', 'grade_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_locks');
    }
};
