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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donation_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->decimal('amount', 15, 2);
            $table->string('currency')->default('SAR');
            $table->string('status')->default('pending'); // pending, completed, failed, refunded
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_frequency')->nullable(); // monthly, quarterly, yearly
            $table->date('next_recurring_date')->nullable();

            // Gift Donation Fields
            $table->boolean('is_gift')->default(false);
            $table->string('gift_recipient_name')->nullable();
            $table->string('gift_recipient_email')->nullable();
            $table->text('gift_message')->nullable();
            $table->string('gift_occasion')->nullable(); // birthday, wedding, ramadan, eid, etc
            $table->date('gift_delivery_date')->nullable();
            $table->boolean('gift_sent')->default(false);
            $table->timestamp('gift_sent_at')->nullable();

            // Donor Information (for anonymous/guest donations)
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();

            // Metadata
            $table->text('notes')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['project_id', 'status']);
            $table->index('donation_number');
            $table->index('is_gift');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
