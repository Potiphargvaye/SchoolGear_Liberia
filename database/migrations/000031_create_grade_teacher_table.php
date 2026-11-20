<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_teacher', function (Blueprint $table) {
            $table->id();

            $table->foreignId('grade_id')->constrained('grades')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['grade_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_teacher');
    }
};
