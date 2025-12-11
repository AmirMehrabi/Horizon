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
        Schema::create('openstack_instance_security_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Instance relationship
            $table->uuid('instance_id')->index();
            $table->foreign('instance_id')
                  ->references('id')
                  ->on('openstack_instances')
                  ->onDelete('cascade');
            
            // Security group relationship
            $table->uuid('security_group_id')->index();
            $table->foreign('security_group_id')
                  ->references('id')
                  ->on('openstack_security_groups')
                  ->onDelete('restrict');
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance (using custom short names to avoid MySQL 64-char limit)
            $table->index(['instance_id', 'security_group_id'], 'os_inst_secgrp_idx');
            $table->unique(['instance_id', 'security_group_id'], 'os_inst_secgrp_unique'); // Prevent duplicate assignments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_instance_security_groups');
    }
};
