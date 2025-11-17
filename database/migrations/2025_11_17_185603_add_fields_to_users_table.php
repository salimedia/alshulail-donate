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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('country')->nullable()->after('phone');
            $table->string('city')->nullable()->after('country');
            $table->string('preferred_language')->default('ar')->after('password');
            $table->decimal('total_donated', 15, 2)->default(0)->after('preferred_language');
            $table->integer('donations_count')->default(0)->after('total_donated');
            $table->boolean('is_active')->default(true)->after('donations_count');
            $table->timestamp('last_donation_at')->nullable()->after('is_active');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'country',
                'city',
                'preferred_language',
                'total_donated',
                'donations_count',
                'is_active',
                'last_donation_at'
            ]);
            $table->dropSoftDeletes();
        });
    }
};
