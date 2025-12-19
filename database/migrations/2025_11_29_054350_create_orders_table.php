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

            // Khóa ngoại liên kết với bảng restaurant_tables
            $table->unsignedBigInteger('table_id');

            // user_id có thể NULL (không bắt buộc phải có người phục vụ khi tạo order)
            $table->unsignedBigInteger('user_id')->nullable();

            $table->enum('status', ['pending', 'cooking', 'served', 'paid'])->default('pending');

            $table->decimal('total_price', 10, 2)->default(0);

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('table_id')
                  ->references('id')
                  ->on('restaurant_tables')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null'); // Nếu xóa user, order vẫn tồn tại nhưng user_id = null
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
