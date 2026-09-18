<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_audits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();

            // Nullable, no FK — same reasoning as grade_audits: the
            // audit trail must survive even if the attendance row it
            // describes is later deleted.
            $table->unsignedBigInteger('attendance_id')->nullable();

            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->foreignId('period_id')->nullable()->constrained('periods')->cascadeOnDelete();
            $table->foreignId('academic_subject_id')->nullable()->constrained('academic_subjects')->cascadeOnDelete();
            $table->date('date');

            $table->enum('action', ['created', 'updated', 'deleted']);
            $table->json('changes')->nullable();

            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('performed_at');

            $table->timestamps();

            $table->index(['school_id', 'enrollment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_audits');
    }
};
