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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->foreignId('donation_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('currency')->default('SAR');
            $table->string('payment_method'); // mada, visa, mastercard, bank_transfer
            $table->string('payment_gateway')->nullable(); // hyperpay, moyasar, tap, etc
            $table->string('status')->default('pending'); // pending, processing, completed, failed, refunded
            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_reference')->nullable();
            $table->text('gateway_response')->nullable();
            $table->decimal('fee_amount', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2);
            $table->string('card_last_four')->nullable();
            $table->string('card_brand')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->text('refund_reason')->nullable();
            $table->timestamps();

            $table->index(['donation_id', 'status']);
            $table->index('transaction_id');
            $table->index('gateway_transaction_id');
            $table->index('payment_method');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
