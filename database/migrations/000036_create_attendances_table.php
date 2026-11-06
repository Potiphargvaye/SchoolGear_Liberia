<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();

            $table->date('date');
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->foreignId('academic_subject_id')->constrained('academic_subjects')->cascadeOnDelete();

            $table->enum('status', ['present', 'absent', 'late']);
            $table->string('remarks')->nullable();

            $table->foreignId('marked_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // One status per student, per day, per period, per subject —
            // matches the school's real workflow of separate roll calls
            // across the day rather than one blanket daily mark.
            $table->unique(['enrollment_id', 'date', 'period_id', 'academic_subject_id'], 'attendances_full_unique');

            $table->index(['school_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
