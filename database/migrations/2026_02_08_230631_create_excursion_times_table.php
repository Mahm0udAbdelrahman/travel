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
        Schema::create('excursion_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('excursion_day_id')->constrained('excursion_days')->cascadeOnDelete();
            $table->time('from_time');
            $table->time('to_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excursion_times');
    }
};
