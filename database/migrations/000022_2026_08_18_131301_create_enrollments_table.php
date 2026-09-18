<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('admission_id')->nullable()->constrained('admissions')->nullOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->foreignId('grade_id')->constrained('grades')->restrictOnDelete(); // current class
            $table->foreignId('academic_year_id')->constrained('academic_years')->restrictOnDelete(); // current year

            $table->enum('status', [
                'active',
                'graduated',
                'transferred',
                'dropped_out',
                'suspended',
                'expelled',
            ])->default('active');

            $table->timestamp('graduated_at')->nullable();

            $table->timestamp('transferred_at')->nullable();
            $table->text('transferred_reason')->nullable();

            $table->timestamp('dropped_out_at')->nullable();
            $table->text('dropped_out_reason')->nullable();

            $table->timestamp('suspended_at')->nullable();
            $table->text('suspended_reason')->nullable();

            $table->timestamp('expelled_at')->nullable();
            $table->text('expelled_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
