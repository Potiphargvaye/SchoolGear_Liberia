<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Platform-level table: deliberately NO school_id.
     * Requesters are prospective schools, not tenants yet, so these rows are
     * only ever managed by the Platform/Super Admin (school_id === null).
     */
    public function up(): void
    {
        Schema::create('demo_requests', function (Blueprint $table) {
            $table->id();

            // Who is asking
            $table->string('full_name', 120);
            $table->string('email', 150);
            $table->string('whatsapp_number', 30);

            // Which school
            $table->string('school_name', 150);
            $table->string('city', 100);
            $table->string('school_category', 20);   // primary | secondary
            $table->string('school_address', 255);

            // When they would like the session
            $table->date('preferred_date');
            $table->string('preferred_time', 5);      // slot key, e.g. "09:00"
            $table->text('message')->nullable();

            // Pipeline (managed by the platform admin)
            $table->string('status', 20)->default('pending')->index();
            $table->text('admin_notes')->nullable();
            $table->timestamp('status_changed_at')->nullable();

            $table->timestamps();

            $table->index('preferred_date');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_requests');
    }
};
