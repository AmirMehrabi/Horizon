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
        Schema::create('projects', function (Blueprint $table) {
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
            
            // OpenStack identifiers (local-first: nullable initially)
            $table->string('openstack_project_id', 255)->nullable()->unique()->index();
            $table->string('openstack_domain_id', 255)->nullable()->index();
            
            // Project status
            $table->enum('status', [
                'pending',
                'active',
                'suspended',
                'deleted'
            ])->default('pending')->index();
            
            // Sync status
            $table->enum('sync_status', [
                'pending',
                'syncing',
                'synced',
                'error'
            ])->default('pending')->index();
            
            $table->text('sync_error')->nullable();
            $table->timestamp('synced_at')->nullable()->index();
            
            // Region
            $table->string('region', 100)->default('RegionOne')->index();
            
            // Metadata
            $table->json('metadata')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'sync_status']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
