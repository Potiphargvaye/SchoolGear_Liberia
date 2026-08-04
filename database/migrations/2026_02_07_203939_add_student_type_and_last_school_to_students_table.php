<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->enum('student_type', ['New', 'Old'])->default('New')->after('date_of_admission');
            $table->string('last_school_attended')->nullable()->after('student_type');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['student_type', 'last_school_attended']);
        });
    }
};
