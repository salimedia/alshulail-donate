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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->foreignId('donation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 15, 2);
            $table->string('currency')->default('SAR');
            $table->boolean('is_tax_receipt')->default(false);
            $table->string('pdf_path')->nullable();
            $table->timestamp('issued_at');
            $table->timestamp('emailed_at')->nullable();
            $table->timestamp('downloaded_at')->nullable();
            $table->integer('download_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('receipt_number');
            $table->index(['donation_id', 'user_id']);
            $table->index('issued_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
