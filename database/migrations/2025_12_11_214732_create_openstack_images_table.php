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
        Schema::create('openstack_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // OpenStack identifier
            $table->string('openstack_id', 255)->unique()->index();
            
            // Basic information
            $table->string('name', 255)->index();
            $table->text('description')->nullable();
            
            // Image properties
            $table->string('status', 50)->index(); // active, queued, saving, deleted, etc.
            $table->enum('visibility', ['public', 'private', 'shared', 'community'])->default('private')->index();
            $table->string('disk_format', 50)->nullable(); // qcow2, raw, iso, vhd, vmdk, etc.
            $table->string('container_format', 50)->nullable(); // bare, ovf, aki, ari, ami, etc.
            
            // Resource requirements
            $table->unsignedInteger('min_disk')->nullable(); // GB
            $table->unsignedInteger('min_ram')->nullable(); // MB
            $table->unsignedBigInteger('size')->nullable(); // Bytes
            
            // Image metadata
            $table->string('checksum', 64)->nullable();
            $table->string('owner_id', 255)->nullable()->index(); // OpenStack project ID
            
            // Additional metadata (stored as JSON)
            $table->json('metadata')->nullable();
            
            // Region
            $table->string('region', 100)->index();
            
            // Sync tracking
            $table->timestamp('synced_at')->nullable()->index();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status', 'visibility', 'region']);
            $table->index(['owner_id', 'visibility']);
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_images');
    }
};
