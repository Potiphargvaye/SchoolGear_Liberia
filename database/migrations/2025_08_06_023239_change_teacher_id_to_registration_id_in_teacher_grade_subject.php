<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // In the migration file
public function up()
{
    Schema::table('teacher_grade_subject', function (Blueprint $table) {
        $table->string('teacher_registration_id', 20)->after('teacher_id'); // Adjust length as needed
    });

    // Migrate existing data
    DB::statement('
        UPDATE teacher_grade_subject tgs
        JOIN users u ON tgs.teacher_id = u.id
        SET tgs.teacher_registration_id = u.registration_id
    ');

    Schema::table('teacher_grade_subject', function (Blueprint $table) {
        $table->dropForeign(['teacher_id']); // Remove foreign key first
        $table->dropColumn('teacher_id');
        $table->renameColumn('teacher_registration_id', 'teacher_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_grade_subject', function (Blueprint $table) {
            //
        });
    }
};
