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
        Schema::create('openstack_sync_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Sync job information
            $table->enum('resource_type', [
                'instances',
                'flavors',
                'images',
                'networks',
                'subnets',
                'security_groups',
                'all'
            ])->index();
            
            // Job status
            $table->enum('status', [
                'pending',
                'running',
                'completed',
                'failed',
                'cancelled'
            ])->default('pending')->index();
            
            // Timing
            $table->timestamp('started_at')->nullable()->index();
            $table->timestamp('completed_at')->nullable()->index();
            
            // Results
            $table->unsignedInteger('records_synced')->default(0);
            $table->unsignedInteger('records_created')->default(0);
            $table->unsignedInteger('records_updated')->default(0);
            $table->unsignedInteger('records_deleted')->default(0);
            $table->unsignedInteger('errors_count')->default(0);
            
            // Error tracking
            $table->json('errors')->nullable(); // Array of error messages
            $table->text('error_message')->nullable(); // Main error message
            
            // Additional metadata
            $table->json('metadata')->nullable(); // Additional sync information
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['resource_type', 'status']);
            $table->index(['status', 'started_at']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_sync_jobs');
    }
};
