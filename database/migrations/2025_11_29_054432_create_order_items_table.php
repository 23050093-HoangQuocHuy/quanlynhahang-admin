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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại liên kết order
            $table->unsignedBigInteger('order_id');

            // Khóa ngoại liên kết món ăn
            $table->unsignedBigInteger('food_id');

            // Số lượng
            $table->integer('quantity')->default(1);

            // Giá món tại thời điểm order (rất quan trọng)
            $table->decimal('price', 10, 2)->default(0);

            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');

            $table->foreign('food_id')
                  ->references('id')
                  ->on('foods')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
