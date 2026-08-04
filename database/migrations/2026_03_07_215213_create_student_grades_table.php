<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('student_grades', function (Blueprint $table) {
        $table->id();

        $table->foreignId('student_id')->constrained()->cascadeOnDelete();
        $table->foreignId('academic_subject_id')->constrained()->cascadeOnDelete();

        $table->string('academic_year'); // example: 2025/2026
        $table->string('grade_level');   // example: Grade 5

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
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
