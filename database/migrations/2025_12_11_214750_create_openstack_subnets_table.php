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
        Schema::create('openstack_subnets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // OpenStack identifier
            $table->string('openstack_id', 255)->unique()->index();
            
            // Network relationship
            $table->uuid('network_id')->index();
            $table->foreign('network_id')
                  ->references('id')
                  ->on('openstack_networks')
                  ->onDelete('cascade');
            
            // Basic information
            $table->string('name', 255)->index();
            $table->text('description')->nullable();
            
            // IP configuration
            $table->string('cidr', 50)->index(); // IP range (e.g., 192.168.1.0/24)
            $table->unsignedTinyInteger('ip_version')->default(4)->index(); // 4 or 6
            $table->string('gateway_ip', 50)->nullable();
            
            // DHCP configuration
            $table->boolean('enable_dhcp')->default(true);
            
            // DNS configuration
            $table->json('dns_nameservers')->nullable(); // Array of DNS server IPs
            
            // IP allocation pools
            $table->json('allocation_pools')->nullable(); // Array of {start, end} IP ranges
            
            // Host routes
            $table->json('host_routes')->nullable();
            
            // Region
            $table->string('region', 100)->index();
            
            // Sync tracking
            $table->timestamp('synced_at')->nullable()->index();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['network_id', 'ip_version']);
            $table->index(['region', 'enable_dhcp']);
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_subnets');
    }
};
