<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_subjects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->nullable()->constrained('schools')->cascadeOnDelete();

            $table->string('name');
            $table->enum('level', ['kindergarten', 'elementary', 'junior', 'senior']);

            $table->timestamps();

            // Unique per school + level — "Bible" can exist once per level
            // per school, matching the existing seeder shape (one row per
            // level, not one global row shared across levels).
            $table->unique(['school_id', 'name', 'level'], 'academic_subjects_school_name_level_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_subjects');
    }
};
