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
        Schema::create('openstack_key_pairs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Customer relationship
            $table->uuid('customer_id')->index();
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
            
            // OpenStack identifier (nullable if created locally first)
            $table->string('openstack_id', 255)->nullable()->unique()->index();
            
            // Key pair information
            $table->string('name', 255)->index();
            $table->text('public_key');
            $table->text('private_key')->nullable(); // Only if generated locally
            $table->string('fingerprint', 64)->nullable();
            
            // Region
            $table->string('region', 100)->index();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['customer_id', 'region']);
            $table->unique(['customer_id', 'name', 'region']); // Customer can't have duplicate key names per region
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openstack_key_pairs');
    }
};
