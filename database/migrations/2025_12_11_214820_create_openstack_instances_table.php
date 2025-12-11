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
        Schema::create('openstack_instances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Customer relationship
            $table->uuid('customer_id')->index();
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
            
            // Basic information
            $table->string('name', 255)->index();
            $table->text('description')->nullable();
            
            // OpenStack identifiers
            $table->string('openstack_server_id', 255)->nullable()->unique()->index();
            $table->string('openstack_project_id', 255)->nullable()->index();
            
            // Instance status
            $table->enum('status', [
                'pending',
                'building',
                'active',
                'stopped',
                'paused',
                'suspended',
                'error',
                'deleting',
                'deleted'
            ])->default('pending')->index();
            
            // Resource relationships
            $table->uuid('flavor_id')->index();
            $table->foreign('flavor_id')
                  ->references('id')
                  ->on('openstack_flavors')
                  ->onDelete('restrict');
            
            $table->uuid('image_id')->index();
            $table->foreign('image_id')
                  ->references('id')
                  ->on('openstack_images')
                  ->onDelete('restrict');
            
            $table->uuid('key_pair_id')->nullable()->index();
            $table->foreign('key_pair_id')
                  ->references('id')
                  ->on('openstack_key_pairs')
                  ->onDelete('set null');
            
            // Authentication
            $table->string('root_password_hash')->nullable(); // Encrypted if password-based auth
            
            // Configuration
            $table->text('user_data')->nullable(); // Cloud-init script
            $table->boolean('config_drive')->default(false);
            
            // Location
            $table->string('region', 100)->index();
            $table->string('availability_zone', 100)->nullable()->index();
            
            // Metadata
            $table->json('metadata')->nullable(); // Custom metadata
            
            // Billing configuration
            $table->boolean('auto_billing')->default(true)->index();
            $table->enum('billing_cycle', ['hourly', 'monthly'])->default('hourly')->index();
            $table->decimal('hourly_cost', 10, 4)->nullable(); // Calculated cost per hour
            $table->decimal('monthly_cost', 10, 2)->nullable(); // Calculated cost per month
            $table->timestamp('billing_started_at')->nullable(); // When billing started
            $table->timestamp('last_billed_at')->nullable(); // Last billing timestamp
            
            // IP addresses (cached for quick access)
            $table->json('ip_addresses')->nullable(); // {public: [], private: []}
            
            // Sync tracking
            $table->timestamp('synced_at')->nullable()->index();
            $table->string('last_openstack_status', 50)->nullable(); // Last known OpenStack status
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'region']);
            $table->index(['billing_cycle', 'auto_billing']);
            $table->index(['created_at', 'status']);
            $table->index(['deleted_at']);
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_instances');
    }
};
