<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            // Change teacher_id to reference registration_id
            $table->string('teacher_id')->nullable()->change();
            
            // Add subjects column (stores subjects for the class)
            $table->json('subjects')->nullable();
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id')->nullable()->change();
            $table->dropColumn('subjects');
        });
    }
};