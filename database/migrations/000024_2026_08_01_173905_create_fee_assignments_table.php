<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_assignments', function (Blueprint $table) {
            $table->id();

            // Tenant scope — every fee assignment belongs to exactly one
            // school. Stored directly (not just derived through enrollment)
            // so every query in this module can filter by school_id alone,
            // same pattern as every other multi-tenant table in the app.
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();

            // Links directly to the student's enrollment
            $table->foreignId('enrollment_id')
                ->constrained('enrollments')
                ->cascadeOnDelete();

            $table->foreignId('fee_category_id')->constrained('fee_categories')->restrictOnDelete();

            // Free-text but validated in the app layer (e.g. "2026/2027") —
            // no dedicated Academic Year table exists in this system.
            $table->string('academic_year');

            // Decoupled from the category now — purely a sequence label
            // ("1st installment", "2nd installment", etc.), nullable for
            // one-off fees that aren't installment-based.
            $table->string('installment_number')->nullable();

            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->text('remarks')->nullable();

            // Recalculated by FeeAssignment::recalculateStatus() whenever a
            // payment is created/updated/deleted — never hand-set by the UI.
            $table->enum('status', ['pending', 'partial', 'paid', 'overdue'])->default('pending');

            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_assignments');
    }
};
