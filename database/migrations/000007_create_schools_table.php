<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Identity
            |--------------------------------------------------------------------------
            */
            $table->string('registration_id')->unique();
            $table->string('school_name');
            $table->string('slug')->unique()->nullable();

            /*
            |--------------------------------------------------------------------------
            | Contact Information
            |--------------------------------------------------------------------------
            */
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('logo')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->default('Liberia');
            $table->string('city')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Owner Account (the ONE initial user created with this school)
            |--------------------------------------------------------------------------
            */
            $table->foreignId('owner_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Trial / Subscription (foundation only — no billing logic yet)
            |--------------------------------------------------------------------------
            */
            $table->date('trial_start_date')->nullable();
            $table->date('trial_end_date')->nullable();

            $table->enum('subscription_status', [
                'trial',
                'active',
                'past_due',
                'cancelled',
            ])->default('trial');

            /*
            |--------------------------------------------------------------------------
            | Account Status (separate from billing — used for Disable action)
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [
                'active',
                'disabled',
            ])->default('active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
