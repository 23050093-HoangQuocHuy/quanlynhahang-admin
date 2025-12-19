<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller quản lý Báo cáo
 * Chỉ admin mới được xem
 */
class ReportController extends Controller
{
    /**
     * Hiển thị trang báo cáo
     */
    public function index(Request $request)
    {
        // Xử lý filter thời gian
        $dateFrom = $request->get('date_from', now()->startOfDay()->toDateString());
        $dateTo = $request->get('date_to', now()->endOfDay()->toDateString());

        // Quick filter
        if ($request->has('quick_filter')) {
            switch ($request->quick_filter) {
                case 'today':
                    $dateFrom = now()->startOfDay()->toDateString();
                    $dateTo = now()->endOfDay()->toDateString();
                    break;
                case 'this_month':
                    $dateFrom = now()->startOfMonth()->toDateString();
                    $dateTo = now()->endOfMonth()->toDateString();
                    break;
                case 'this_year':
                    $dateFrom = now()->startOfYear()->toDateString();
                    $dateTo = now()->endOfYear()->toDateString();
                    break;
            }
        }

        // Thống kê doanh thu
        $revenueStats = Order::where('status', 'paid')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->select(
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->first();

        // Top món ăn bán chạy
        $topFoods = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('foods', 'order_items.food_id', '=', 'foods.id')
            ->where('orders.status', 'paid')
            ->whereBetween('orders.created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->select(
                'foods.id',
                'foods.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('foods.id', 'foods.name')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        // Doanh thu theo ngày (trong khoảng thời gian)
        $revenueByDay = Order::where('status', 'paid')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.index', compact(
            'revenueStats',
            'topFoods',
            'revenueByDay',
            'dateFrom',
            'dateTo'
        ));
    }
}

