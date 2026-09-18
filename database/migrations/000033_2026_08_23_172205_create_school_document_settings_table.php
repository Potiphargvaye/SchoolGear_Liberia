<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_document_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')->unique()->constrained('schools')->cascadeOnDelete();

            // Identity overrides — fall back to schools.school_name / schools.logo when null
            $table->string('document_name')->nullable();
            $table->string('address')->nullable();
            $table->string('po_box')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('school_number')->nullable();
            $table->string('email')->nullable();
            $table->string('logo_path')->nullable();

            // Footer block 
            $table->string('footer_location_label')->default('Our Location');
            $table->text('footer_location')->nullable();
            $table->string('footer_call_label')->default('Call Us');
            $table->text('footer_call')->nullable();
            $table->string('footer_email_label')->default('Email');
            $table->text('footer_email')->nullable();
            $table->text('footer_note')->nullable();

            // Per-document-type titles/captions — {"receipt": "...", "statement": "...", ...}
            $table->json('document_settings')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_document_settings');
    }
};
