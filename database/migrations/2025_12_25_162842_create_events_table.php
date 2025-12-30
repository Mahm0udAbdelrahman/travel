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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_event_id')->constrained('category_events')->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->json('name');
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->string('date');
            $table->json('description');
            $table->string('price');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
