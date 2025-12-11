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
        Schema::create('openstack_instance_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Instance relationship
            $table->uuid('instance_id')->index();
            $table->foreign('instance_id')
                  ->references('id')
                  ->on('openstack_instances')
                  ->onDelete('cascade');
            
            // Event information
            $table->string('event_type', 100)->index(); // created, building, active, stopped, error, etc.
            $table->text('message');
            
            // Event metadata
            $table->json('metadata')->nullable(); // Additional event data
            
            // Source of event
            $table->enum('source', ['local', 'openstack', 'sync', 'user'])->default('local')->index();
            
            // Timestamps
            $table->timestamp('created_at')->index();
            
            // Indexes for performance (using custom short names to avoid MySQL 64-char limit)
            $table->index(['instance_id', 'event_type'], 'os_inst_evt_type_idx');
            $table->index(['instance_id', 'created_at'], 'os_inst_evt_created_idx');
            $table->index(['event_type', 'created_at'], 'os_evt_type_created_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_instance_events');
    }
};
