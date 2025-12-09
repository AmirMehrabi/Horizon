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
        Schema::create('customers', function (Blueprint $table) {
            // Primary key using UUID
            $table->uuid('id')->primary();
            
            // Personal Information
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('phone_number', 20)->unique()->index();
            $table->string('email', 255)->nullable()->index();
            
            // Company Information
            $table->string('company_name', 255)->nullable();
            
            // Address Information
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->default('US');
            
            // Account Status and Verification
            $table->enum('status', ['pending', 'active', 'inactive', 'suspended'])
                  ->default('pending')
                  ->index();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            
            // Additional Information
            $table->json('preferences')->nullable();
            $table->text('notes')->nullable();
            
            // Authentication
            $table->string('remember_token')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['status', 'phone_verified_at']);
            $table->index(['created_at']);
            $table->index(['deleted_at']);
            
            // Full-text search index for names and company
            $table->fullText(['first_name', 'last_name', 'company_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
