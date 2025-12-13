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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id');
            $table->string('type', 50)->index(); // billing, technical, security, support, etc.
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type_icon', 50)->nullable(); // dollar, shield, message, check, info
            $table->boolean('read')->default(false)->index();
            $table->json('metadata')->nullable(); // Additional data
            $table->string('action_url')->nullable(); // URL to navigate when clicked
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->index(['customer_id', 'read']);
            $table->index(['customer_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
