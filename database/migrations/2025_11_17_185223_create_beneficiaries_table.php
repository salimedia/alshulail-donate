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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->morphs('beneficiable'); // polymorphic relation (projects, donations)
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->integer('count')->default(1);
            $table->string('type')->nullable(); // orphan, student, family, etc
            $table->string('location_country')->nullable();
            $table->string('location_region')->nullable();
            $table->string('location_city')->nullable();
            $table->text('expected_impact_ar')->nullable();
            $table->text('expected_impact_en')->nullable();
            $table->text('achieved_impact_ar')->nullable();
            $table->text('achieved_impact_en')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['beneficiable_type', 'beneficiable_id']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
