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
        Schema::create('openstack_networks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // OpenStack identifier
            $table->string('openstack_id', 255)->unique()->index();
            
            // Basic information
            $table->string('name', 255)->index();
            $table->text('description')->nullable();
            
            // Network status
            $table->string('status', 50)->index(); // ACTIVE, DOWN, BUILD, ERROR, etc.
            $table->boolean('admin_state_up')->default(true);
            $table->boolean('shared')->default(false)->index();
            $table->boolean('external')->default(false)->index(); // Is external/public network
            
            // Provider network information
            $table->string('provider_network_type', 50)->nullable(); // flat, vlan, vxlan, gre, local, etc.
            $table->unsignedInteger('provider_segmentation_id')->nullable(); // VLAN ID, VXLAN VNI, etc.
            $table->string('provider_physical_network', 255)->nullable();
            
            // Router external
            $table->boolean('router_external')->default(false)->index();
            
            // Availability zones
            $table->json('availability_zones')->nullable();
            
            // Subnets (array of subnet IDs)
            $table->json('subnets')->nullable();
            
            // Region
            $table->string('region', 100)->index();
            
            // Sync tracking
            $table->timestamp('synced_at')->nullable()->index();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status', 'external', 'shared', 'region']);
            $table->index(['router_external', 'external']);
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_networks');
    }
};
