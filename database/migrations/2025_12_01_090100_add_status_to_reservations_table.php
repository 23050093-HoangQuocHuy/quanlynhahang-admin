<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Chỉ thêm cột nếu chưa tồn tại
            if (!Schema::hasColumn('reservations', 'status')) {
                $table->enum('status', ['pending', 'confirmed', 'rejected'])
                      ->default('pending')
                      ->after('notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Chỉ xóa cột nếu đã tồn tại
            if (Schema::hasColumn('reservations', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
