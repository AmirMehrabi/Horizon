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
        Schema::create('backup_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id');
            $table->uuid('instance_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('openstack_snapshot_id')->nullable()->index();
            $table->string('openstack_server_id')->nullable()->index();
            $table->enum('type', ['manual', 'automated'])->default('manual');
            $table->enum('status', ['creating', 'available', 'error', 'deleting', 'deleted'])->default('creating');
            $table->unsignedBigInteger('size')->nullable()->comment('Size in bytes');
            $table->string('size_unit', 10)->default('GB');
            $table->timestamp('completed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('instance_id')->references('id')->on('openstack_instances')->onDelete('set null');
            $table->index(['customer_id', 'status']);
            $table->index(['instance_id', 'status']);
            $table->index(['created_at', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_snapshots');
    }
};
