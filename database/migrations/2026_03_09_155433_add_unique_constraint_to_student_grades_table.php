<?php

    /**
     * Run the migrations.
     */
    use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToStudentGradesTable extends Migration
{
    public function up()
    {
        Schema::table('student_grades', function (Blueprint $table) {
            $table->unique(
                ['student_id', 'academic_subject_id', 'academic_year'],
                'student_subject_year_unique'
            );
        });
    }

    public function down()
    {
        Schema::table('student_grades', function (Blueprint $table) {
            $table->dropUnique('student_subject_year_unique');
        });
    }
}

    
