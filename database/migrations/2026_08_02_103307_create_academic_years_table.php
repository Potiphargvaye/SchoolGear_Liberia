<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')
                ->nullable()
                ->constrained('schools')
                ->cascadeOnDelete();

            $table->string('name');

            $table->boolean('is_active')->default(false);

            $table->integer('sort_order')->default(0);

            $table->timestamps();

            // Unique per school, not globally — School A and School B can
            // both have a "2026/2027" academic year without colliding.
            $table->unique(['school_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};
