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
        Schema::create('backup_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id');
            $table->boolean('enabled')->default(false);
            $table->enum('schedule', ['hourly', 'daily', 'weekly', 'monthly'])->default('daily');
            $table->time('time')->default('02:00');
            $table->unsignedInteger('retention_days')->default(30);
            $table->timestamp('last_backup_at')->nullable();
            $table->enum('last_backup_status', ['success', 'failed', 'pending'])->nullable();
            $table->timestamp('next_backup_at')->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unique('customer_id');
            $table->index(['enabled', 'schedule', 'next_backup_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_settings');
    }
};
