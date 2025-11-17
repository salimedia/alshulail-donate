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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->morphs('statisticable'); // polymorphic relation
            $table->string('metric_name'); // total_donations, total_beneficiaries, etc
            $table->decimal('value', 20, 2)->default(0);
            $table->string('period')->nullable(); // daily, weekly, monthly, yearly, all-time
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->string('geographical_region')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['statisticable_type', 'statisticable_id']);
            $table->index('metric_name');
            $table->index('period');
            $table->index('country');
            $table->index(['period_start', 'period_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
