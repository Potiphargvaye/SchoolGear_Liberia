<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_audits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();

            // Kept independent of student_grades.id (nullable, no FK
            // constraint) so the audit trail survives even after the
            // underlying grade row is deleted (StudentGradeController
            // deletes a grade entirely once all period/exam fields are
            // cleared) — enrollment_id + academic_subject_id are enough
            // to identify what the audit entry was about.
            $table->unsignedBigInteger('student_grade_id')->nullable();

            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->foreignId('academic_subject_id')->constrained('academic_subjects')->cascadeOnDelete();

            $table->enum('action', ['created', 'updated', 'deleted']);

            // Snapshot of what changed — e.g. {"period1": [null, 85], "exam1": [70, 78]}
            $table->json('changes')->nullable();

            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('performed_at');

            $table->timestamps();

            $table->index(['school_id', 'enrollment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_audits');
    }
};
