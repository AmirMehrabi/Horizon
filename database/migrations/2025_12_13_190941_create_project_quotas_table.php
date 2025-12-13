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
        Schema::create('project_quotas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Project relationship
            $table->uuid('project_id')->unique()->index();
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('cascade');
            
            // Compute quotas
            $table->unsignedInteger('instances')->default(20)->comment('Maximum number of instances');
            $table->unsignedInteger('cores')->default(100)->comment('Maximum number of vCPUs');
            $table->unsignedInteger('ram')->default(204800)->comment('Maximum RAM in MB');
            
            // Storage quotas
            $table->unsignedInteger('volumes')->default(50)->comment('Maximum number of volumes');
            $table->unsignedBigInteger('gigabytes')->default(2048)->comment('Maximum storage in GB');
            $table->unsignedInteger('snapshots')->default(50)->comment('Maximum number of snapshots');
            
            // Network quotas
            $table->unsignedInteger('floating_ips')->default(50)->comment('Maximum number of floating IPs');
            $table->unsignedInteger('networks')->default(10)->comment('Maximum number of networks');
            $table->unsignedInteger('subnets')->default(20)->comment('Maximum number of subnets');
            $table->unsignedInteger('routers')->default(5)->comment('Maximum number of routers');
            $table->unsignedInteger('security_groups')->default(20)->comment('Maximum number of security groups');
            $table->unsignedInteger('security_group_rules')->default(100)->comment('Maximum number of security group rules');
            
            // Load balancer quotas (if applicable)
            $table->unsignedInteger('load_balancers')->default(5)->nullable();
            $table->unsignedInteger('listeners')->default(10)->nullable();
            $table->unsignedInteger('pools')->default(10)->nullable();
            
            // Sync tracking
            $table->timestamp('synced_at')->nullable()->index();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index(['project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_quotas');
    }
};
