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
        Schema::create('excursions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_excursion_id')->constrained('category_excursions')->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->json('name');
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->json('description');
            $table->string('price');
            $table->string('hours');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excursions');
    }
};
