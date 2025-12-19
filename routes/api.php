<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// =========================
// 1. TEST API
// =========================
Route::get('/test', function () {
    return response()->json([
        'message' => 'API OK',
        'status' => true
    ]);
});

// =========================
// 2. API /user (Laravel default)
// =========================
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// =========================
// 3. FOODS API (Frontend gọi món)
// =========================
use App\Http\Controllers\Api\FoodApiController;
Route::get('/foods', [FoodApiController::class, 'index']);


// =========================
// 4. TABLES API (Frontend đặt bàn)
// =========================
use App\Models\RestaurantTable;

Route::get('/tables', function () {

    // Lấy danh sách bàn: chỉ lấy thông tin cần thiết
    $tables = RestaurantTable::select('id', 'name', 'area', 'seats', 'status')->get();

    return response()->json([
        'success' => true,
        'tables' => $tables
    ]);
});
use App\Http\Controllers\Api\ReservationApiController;

Route::post('/reservations', [ReservationApiController::class, 'store']);
