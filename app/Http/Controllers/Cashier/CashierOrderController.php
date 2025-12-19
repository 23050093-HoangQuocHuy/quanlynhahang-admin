<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

/**
 * Controller quản lý Order cho Cashier
 * Cashier có thể: xem danh sách bàn cần thanh toán, xem chi tiết order, in hóa đơn, thanh toán
 */
class CashierOrderController extends Controller
{
    /**
     * Hiển thị danh sách bàn cần thanh toán
     */
    public function index()
    {
        // Lấy các order có status served (đã phục vụ xong, chờ thanh toán)
        $orders = Order::with(['table', 'items.food'])
            ->where('status', 'served')
            ->orderBy('created_at', 'desc')
            ->get();

        // Nhóm theo bàn
        $tablesWithOrders = RestaurantTable::whereIn('id', $orders->pluck('table_id'))
            ->with(['orders' => function($query) {
                $query->where('status', 'served');
            }])
            ->get();

        return view('cashier.orders.index', compact('orders', 'tablesWithOrders'));
    }

    /**
     * Hiển thị chi tiết order để thanh toán
     */
    public function show(Order $order)
    {
        $order->load(['items.food', 'table']);
        
        return view('cashier.orders.show', compact('order'));
    }

    /**
     * In hóa đơn (view in-friendly)
     */
    public function print(Order $order)
    {
        $order->load(['items.food', 'table', 'user']);
        
        return view('cashier.orders.print', compact('order'));
    }

    /**
     * Xử lý thanh toán
     */
    public function pay(Order $order)
    {
        if ($order->status !== 'served') {
            return redirect()->route('cashier.orders.index')
                ->with('error', 'Order này chưa sẵn sàng thanh toán.');
        }

        // Cập nhật trạng thái order
        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // Cập nhật trạng thái bàn về empty
        $order->table->update(['status' => 'empty']);

        return redirect()->route('cashier.orders.index')
            ->with('success', 'Thanh toán thành công cho order #' . $order->id);
    }
}

