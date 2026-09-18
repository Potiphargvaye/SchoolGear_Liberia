<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();

            $table->string('admission_number')->unique(); // e.g. ADM/2026/00001

            $table->string('applicant_name');
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('parent_phone');

            $table->foreignId('grade_id')->constrained('grades')->restrictOnDelete(); // class applying for

            $table->enum('student_type', ['New', 'Old', 'Transfer'])->default('New');
            $table->string('last_school_attended')->nullable();

            $table->string('image')->nullable();
            $table->string('transcript')->nullable();
            $table->string('recommendation_letter')->nullable();

            $table->date('date_of_admission')->nullable();

            $table->enum('status', ['pending', 'admitted', 'rejected', 'withdrawn'])->default('pending');

            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
