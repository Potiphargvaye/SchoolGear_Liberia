<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fee_categories', function (Blueprint $table) {
            $table->foreignId('school_id')
                ->nullable()
                ->after('id')
                ->constrained('schools')
                ->cascadeOnDelete();

            // Drop the old platform-wide unique constraint on code.
            $table->dropUnique('fee_categories_code_unique');
        });

        Schema::table('fee_categories', function (Blueprint $table) {
            // Code is now unique per school, not globally — School A and
            // School B can each have a "tuition" category without colliding.
            // (MySQL treats NULL school_id as distinct per row, so any
            // legacy/unassigned rows are unaffected by this constraint.)
            $table->unique(['school_id', 'code'], 'fee_categories_school_code_unique');
        });
    }

    public function down(): void
    {
        Schema::table('fee_categories', function (Blueprint $table) {
            $table->dropUnique('fee_categories_school_code_unique');
            $table->dropConstrainedForeignId('school_id');
            $table->unique('code', 'fee_categories_code_unique');
        });
    }
};
