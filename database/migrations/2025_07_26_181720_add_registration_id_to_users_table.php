<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_registration_id_to_users_table.php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('registration_id')
              ->unique()
              ->after('id')  // Places after ID column
              ->comment('Custom registration ID for login');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('registration_id');
    });
}
    
};

