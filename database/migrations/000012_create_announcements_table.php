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
       Schema::create('announcements', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('type')->default('general'); // ['general', 'event', 'payment', 'urgent']
    $table->string('attachment_path')->nullable(); // For file attachments
    $table->boolean('is_pinned')->default(false); // For pinning important announcements
    $table->integer('priority')->default(0); // For sorting (0=normal, 1=important, 2=critical)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
