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
    Schema::create('restaurant_tables', function (Blueprint $table) {
        $table->id();
        $table->string('name');        // Tên bàn: Bàn 1, Bàn 2...
        $table->string('area')->nullable();   // Khu vực: tầng 1, ngoài trời...
        $table->integer('seats')->default(4); // Số ghế
        $table->enum('status', ['empty', 'serving', 'reserved'])->default('empty');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_tables');
    }
};
