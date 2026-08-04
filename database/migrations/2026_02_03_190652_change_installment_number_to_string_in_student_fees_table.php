<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('student_fees', function (Blueprint $table) {
            $table->string('installment_number')
                  ->default('1st installment')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('student_fees', function (Blueprint $table) {
            $table->integer('installment_number')
                  ->default(1)
                  ->change();
        });
    }
};
