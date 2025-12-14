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
        Schema::create('customer_activity_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id')->index();
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
            $table->string('action', 255);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('device', 255)->nullable();
            $table->enum('status', ['success', 'failed'])->default('success');
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['customer_id', 'created_at']);
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_activity_logs');
    }
};
