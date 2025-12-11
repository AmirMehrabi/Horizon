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
        Schema::create('openstack_instance_networks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Instance relationship
            $table->uuid('instance_id')->index();
            $table->foreign('instance_id')
                  ->references('id')
                  ->on('openstack_instances')
                  ->onDelete('cascade');
            
            // Network relationship
            $table->uuid('network_id')->index();
            $table->foreign('network_id')
                  ->references('id')
                  ->on('openstack_networks')
                  ->onDelete('restrict');
            
            // Subnet relationship (optional)
            $table->uuid('subnet_id')->nullable()->index();
            $table->foreign('subnet_id')
                  ->references('id')
                  ->on('openstack_subnets')
                  ->onDelete('set null');
            
            // IP addresses
            $table->string('fixed_ip', 50)->nullable()->index(); // Assigned fixed IP address
            $table->string('floating_ip', 50)->nullable()->index(); // Floating IP if assigned
            
            // Network priority
            $table->boolean('is_primary')->default(false)->index();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance (using custom short names to avoid MySQL 64-char limit)
            $table->index(['instance_id', 'is_primary'], 'os_inst_net_primary_idx');
            $table->index(['network_id', 'fixed_ip'], 'os_net_fixedip_idx');
            $table->unique(['instance_id', 'network_id'], 'os_inst_net_unique'); // One network per instance
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_instance_networks');
    }
};
