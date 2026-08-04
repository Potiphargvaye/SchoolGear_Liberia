<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique(); // Custom ID: EDMOL0001/2025
            $table->string('image')->nullable();
            $table->string('name');
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('parent_phone');
            $table->string('transcript')->nullable();
            $table->string('recommendation_letter')->nullable();
            $table->string('class_applying_for');
            $table->date('date_of_admission');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};