<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_publication_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('grade_id')->constrained('grades')->restrictOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->restrictOnDelete();
            $table->string('slot', 16);
            $table->enum('action', ['published', 'unpublished']);
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('performed_at');
            $table->timestamps();

            $table->index(['school_id', 'grade_id', 'academic_year_id', 'slot'], 'gpa_scope_idx');
            $table->index(['school_id', 'performed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_publication_audits');
    }
};
