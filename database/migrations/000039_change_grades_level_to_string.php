<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->string('level')->change();
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->integer('level')->change();
        });
    }
};
