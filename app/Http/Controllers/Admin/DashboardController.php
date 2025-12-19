<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Food;
use App\Models\Category;
use App\Models\RestaurantTable;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller quản lý Dashboard Admin
 */
class DashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard
     */
    public function index()
    {
        // Thống kê tổng quan
        $stats = [
            'total_orders' => Order::count(),
            'total_foods' => Food::count(),
            'total_categories' => Category::count(),
            'total_tables' => RestaurantTable::count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('status', 'paid')
                ->sum('total_price'),
            'pending_orders' => Order::whereIn('status', ['pending', 'cooking'])->count(),
            'active_tables' => RestaurantTable::whereIn('status', ['serving', 'reserved'])->count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
        ];

        // Top món ăn bán chạy (7 ngày gần nhất)
        $topFoods = DB::table('order_items')
            ->join('foods', 'order_items.food_id', '=', 'foods.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->where('orders.created_at', '>=', now()->subDays(7))
            ->select('foods.name', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'))
            ->groupBy('foods.id', 'foods.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Doanh thu theo ngày (7 ngày gần nhất)
        $revenueByDay = Order::where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $pendingReservations = Reservation::where('status', 'pending')->count();

        return view('admin.dashboard', compact('stats', 'topFoods', 'revenueByDay', 'pendingReservations'));
    }
}

