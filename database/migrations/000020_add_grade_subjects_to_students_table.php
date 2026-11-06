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
    Schema::table('students', function (Blueprint $table) {
        $table->unsignedBigInteger('grade_id')->nullable()->after('id');
        $table->json('subjects')->nullable()->after('grade_id');

        // Optional: add foreign key if you want
        $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropForeign(['grade_id']);
        $table->dropColumn(['grade_id', 'subjects']);
    });
}

};
