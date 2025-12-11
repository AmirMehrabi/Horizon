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
        Schema::create('openstack_flavors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // OpenStack identifier
            $table->string('openstack_id', 255)->unique()->index();
            
            // Basic information
            $table->string('name', 255)->index();
            $table->text('description')->nullable();
            
            // Resource specifications
            $table->unsignedInteger('vcpus')->default(1);
            $table->unsignedInteger('ram')->default(512); // MB
            $table->unsignedInteger('disk')->default(1); // GB
            $table->unsignedInteger('ephemeral_disk')->default(0); // GB
            $table->unsignedInteger('swap')->default(0); // MB
            
            // Availability and visibility
            $table->boolean('is_public')->default(true)->index();
            $table->boolean('is_disabled')->default(false)->index();
            
            // Additional specifications (stored as JSON for flexibility)
            $table->json('extra_specs')->nullable();
            
            // Pricing (local override - can differ from OpenStack)
            $table->decimal('pricing_hourly', 10, 4)->nullable()->index();
            $table->decimal('pricing_monthly', 10, 2)->nullable()->index();
            
            // Region availability
            $table->string('region', 100)->index();
            
            // Sync tracking
            $table->timestamp('synced_at')->nullable()->index();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['is_public', 'is_disabled', 'region']);
            $table->index(['vcpus', 'ram', 'disk']);
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_flavors');
    }
};
