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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained('hotels', 'id')->cascadeOnDelete();
            $table->string('room_number')->nullable();
            $table->morphs('orderable');
            $table->string('date');
            $table->string('time');
            $table->string('type')->default(\App\Enums\InquiryType::NORMAL->value);
            $table->text('notes')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('order_number')->unique();
            $table->decimal('price', 10, 2);
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
            $table->enum('payment_status', ['pending', 'failed', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
