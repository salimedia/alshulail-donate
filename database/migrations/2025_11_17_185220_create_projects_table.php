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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->string('slug')->unique();
            $table->decimal('target_amount', 15, 2)->default(0);
            $table->decimal('raised_amount', 15, 2)->default(0);
            $table->integer('donors_count')->default(0);
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('status')->default('active'); // active, paused, completed, closed
            $table->string('location_country')->nullable();
            $table->string('location_region')->nullable();
            $table->string('location_city')->nullable();
            $table->integer('expected_beneficiaries_count')->default(0);
            $table->integer('actual_beneficiaries_count')->default(0);
            $table->text('expected_impact_ar')->nullable();
            $table->text('expected_impact_en')->nullable();
            $table->text('achieved_impact_ar')->nullable();
            $table->text('achieved_impact_en')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_urgent')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'is_featured']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
