   <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id(); // Unique ID for each grade
            $table->integer('level'); // Grade level (1-12)
            $table->string('section')->nullable(); // Optional: A, B, C if multiple classes
            $table->string('teacher_id')->nullable(); // Homeroom teacher
            $table->timestamps(); // Automatic timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
};