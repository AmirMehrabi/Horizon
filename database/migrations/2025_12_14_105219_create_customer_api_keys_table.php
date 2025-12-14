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
        Schema::create('customer_api_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id')->index();
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
            $table->string('name', 255);
            $table->string('key', 64)->unique()->index();
            $table->json('permissions')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
            
            $table->index(['customer_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_api_keys');
    }
};
