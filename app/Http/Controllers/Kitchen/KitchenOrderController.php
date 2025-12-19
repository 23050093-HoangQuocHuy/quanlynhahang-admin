<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller quản lý Order cho Kitchen
 * Kitchen có thể: xem danh sách món cần nấu, đánh dấu bắt đầu nấu, hoàn thành
 */
class KitchenOrderController extends Controller
{
    /**
     * Hiển thị danh sách món cần chế biến
     */
    public function index()
    {
        // Lấy tất cả order items từ các order đang cooking hoặc pending
        $orderItems = OrderItem::with(['order.table', 'food'])
            ->whereHas('order', function($query) {
                $query->whereIn('status', ['pending', 'cooking']);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function($item) {
                // Nhóm theo order_id và food_id để hiển thị tổng số lượng
                return $item->order_id . '_' . $item->food_id;
            })
            ->map(function($group) {
                $first = $group->first();
                return [
                    'order_id' => $first->order_id,
                    'order' => $first->order,
                    'food' => $first->food,
                    'total_quantity' => $group->sum('quantity'),
                    'created_at' => $first->created_at,
                    'items' => $group,
                ];
            })
            ->sortBy('created_at')
            ->values();

        return view('kitchen.orders.index', compact('orderItems'));
    }

    /**
     * Đánh dấu bắt đầu nấu (chuyển order status thành cooking)
     */
    public function startCooking(Order $order)
    {
        if ($order->status === 'pending') {
            $order->update(['status' => 'cooking']);
        }

        return redirect()->route('kitchen.orders.index')
            ->with('success', 'Đã bắt đầu nấu order #' . $order->id);
    }

    /**
     * Đánh dấu hoàn thành món (có thể đánh dấu từng món hoặc toàn bộ order)
     */
    public function completeItem(Request $request, Order $order, OrderItem $item = null)
    {
        // Nếu đánh dấu hoàn thành từng món, có thể xóa item đó
        // Hoặc đánh dấu toàn bộ order hoàn thành
        if ($item) {
            // Đánh dấu hoàn thành 1 món cụ thể (xóa item)
            $item->delete();
            
            // Kiểm tra xem order còn món nào không
            if ($order->items()->count() == 0) {
                $order->update(['status' => 'served']);
            }
        } else {
            // Đánh dấu toàn bộ order hoàn thành
            $order->update(['status' => 'served']);
        }

        return redirect()->route('kitchen.orders.index')
            ->with('success', 'Đã hoàn thành!');
    }

    /**
     * Đánh dấu toàn bộ order hoàn thành
     */
    public function completeOrder(Order $order)
    {
        $order->update(['status' => 'served']);

        return redirect()->route('kitchen.orders.index')
            ->with('success', 'Đã hoàn thành order #' . $order->id);
    }
}

