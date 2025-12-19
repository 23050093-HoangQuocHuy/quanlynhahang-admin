<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'food_id'  => 'required|exists:foods,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::find($request->order_id);
        $food  = Food::find($request->food_id);

        // Kiểm tra món có tồn tại trong order chưa
        $item = OrderItem::where('order_id', $order->id)
            ->where('food_id', $food->id)
            ->first();

        if ($item) {
            // tăng số lượng
            $item->quantity += $request->quantity;
            $item->save();
        } else {
            // tạo mới
            OrderItem::create([
                'order_id' => $order->id,
                'food_id'  => $food->id,
                'quantity' => $request->quantity,
                'price'    => $food->price,
            ]);
        }

        // cập nhật tổng tiền
        $order->total_price = OrderItem::where('order_id', $order->id)
            ->sum(DB::raw('quantity * price'));
        $order->save();

        return back();
    }
}
