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
        Schema::create('customer_verification_codes', function (Blueprint $table) {
            $table->id();
            
            // Phone number being verified
            $table->string('phone_number', 20)->index();
            
            // Verification code (6 digits)
            $table->string('code', 10);
            
            // Code type (registration, login, password_reset, etc.)
            $table->enum('type', ['registration', 'login', 'password_reset'])
                  ->default('registration');
            
            // Verification status
            $table->boolean('verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            
            // Expiration and attempts
            $table->timestamp('expires_at');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->unsignedTinyInteger('max_attempts')->default(3);
            
            // IP and user agent for security
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance and cleanup
            $table->index(['phone_number', 'type', 'verified']);
            $table->index(['expires_at']);
            $table->index(['created_at']);
            
            // Unique constraint to prevent duplicate active codes
            $table->unique(['phone_number', 'type', 'verified'], 'unique_active_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_verification_codes');
    }
};
