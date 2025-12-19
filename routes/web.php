<?php

use Illuminate\Support\Facades\Route;

// Auth Controllers
use App\Http\Controllers\AuthController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReservationController;

// Waiter Controllers
use App\Http\Controllers\Waiter\OrderController as WaiterOrderController;

// Kitchen Controllers
use App\Http\Controllers\Kitchen\KitchenOrderController;

// Cashier Controllers
use App\Http\Controllers\Cashier\CashierOrderController;

// ============================================
// AUTH ROUTES (Public)
// ============================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// ============================================
// WELCOME PAGE
// ============================================
Route::get('/', function () {
    return view('welcome');
});

// ============================================
// ADMIN ROUTES (Only Admin)
// ============================================
// Redirect /admin → /admin/dashboard
Route::middleware('auth')->get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Dashboard & Management
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Categories Management
        Route::resource('categories', CategoryController::class);
        
        // Foods Management
        Route::resource('foods', FoodController::class);
        
        // Tables Management
        Route::resource('tables', TableController::class);
        
        // Users Management
        Route::resource('users', UserController::class);
        
        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        
        // Reservations Management
        Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::patch('reservations/{id}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
        Route::patch('reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    });

// ============================================
// WAITER ROUTES (Admin + Waiter)
// ============================================
Route::middleware(['auth', 'role:admin,waiter'])
    ->prefix('waiter')
    ->name('waiter.')
    ->group(function () {
        Route::get('orders', [WaiterOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [WaiterOrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [WaiterOrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}', [WaiterOrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/add-item', [WaiterOrderController::class, 'addItem'])->name('orders.addItem');
        Route::patch('orders/{order}/items/{item}', [WaiterOrderController::class, 'updateItem'])->name('orders.updateItem');
        Route::delete('orders/{order}/items/{item}', [WaiterOrderController::class, 'removeItem'])->name('orders.removeItem');
        Route::patch('orders/{order}/send-to-kitchen', [WaiterOrderController::class, 'sendToKitchen'])->name('orders.sendToKitchen');
    });

// ============================================
// KITCHEN ROUTES (Admin + Kitchen)
// ============================================
Route::middleware(['auth', 'role:admin,kitchen'])
    ->prefix('kitchen')
    ->name('kitchen.')
    ->group(function () {
        Route::get('orders', [KitchenOrderController::class, 'index'])->name('orders.index');
        Route::patch('orders/{order}/start-cooking', [KitchenOrderController::class, 'startCooking'])->name('orders.startCooking');
        Route::patch('orders/{order}/complete-order', [KitchenOrderController::class, 'completeOrder'])->name('orders.completeOrder');
        Route::patch('orders/{order}/items/{item}/complete', [KitchenOrderController::class, 'completeItem'])->name('orders.completeItem');
    });

// ============================================
// CASHIER ROUTES (Admin + Cashier)
// ============================================
Route::middleware(['auth', 'role:admin,cashier'])
    ->prefix('cashier')
    ->name('cashier.')
    ->group(function () {
        Route::get('orders', [CashierOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [CashierOrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/print', [CashierOrderController::class, 'print'])->name('orders.print');
        Route::patch('orders/{order}/pay', [CashierOrderController::class, 'pay'])->name('orders.pay');
    });
use App\Http\Controllers\DevPasswordResetController;

Route::get('/dev-reset-password', [DevPasswordResetController::class, 'reset']);
