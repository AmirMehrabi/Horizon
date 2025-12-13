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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('wallet_id');
            $table->uuid('customer_id');
            $table->enum('type', ['credit', 'debit'])->comment('credit = money added, debit = money deducted');
            $table->decimal('amount', 15, 2)->comment('Amount in Rials');
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->string('description', 500)->nullable();
            $table->string('reference_type', 100)->nullable()->comment('Model class name (e.g., OpenStackInstance)');
            $table->uuid('reference_id')->nullable()->comment('ID of related model');
            $table->string('payment_method', 100)->nullable()->comment('Payment method used (e.g., test_payment)');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->index(['wallet_id', 'created_at']);
            $table->index(['customer_id', 'created_at']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
