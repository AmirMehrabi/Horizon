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
        Schema::create('openstack_security_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // OpenStack identifier
            $table->string('openstack_id', 255)->unique()->index();
            
            // Basic information
            $table->string('name', 255)->index();
            $table->text('description')->nullable();
            
            // Security group rules (stored as JSON array)
            // Each rule contains: direction, protocol, port_range_min, port_range_max, remote_ip_prefix, etc.
            $table->json('rules')->nullable();
            
            // Region
            $table->string('region', 100)->index();
            
            // Sync tracking
            $table->timestamp('synced_at')->nullable()->index();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['region', 'name']);
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_security_groups');
    }
};
