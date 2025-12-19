<?php

namespace App\Http\Controllers\Waiter;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantTable;
use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller quản lý Order cho Waiter
 * Waiter có thể: tạo order, thêm món, cập nhật số lượng, gửi bếp
 */
class OrderController extends Controller
{
    /**
     * Hiển thị danh sách order (hoặc chuyển về sơ đồ bàn)
     */
    public function index()
    {
        // Chuyển về trang chọn bàn
        return redirect()->route('waiter.orders.create');
    }

    /**
     * Hiển thị danh sách bàn để chọn tạo order
     */
    public function create(Request $request)
    {
        $tableId = $request->get('table_id');
        
        // Nếu có table_id, tạo order ngay
        if ($tableId) {
            $table = RestaurantTable::findOrFail($tableId);
            
            // Kiểm tra bàn có order đang chờ không
            $existingOrder = Order::where('table_id', $tableId)
                ->whereIn('status', ['pending', 'cooking', 'served'])
                ->first();
            
            if ($existingOrder) {
                return redirect()->route('waiter.orders.show', $existingOrder)
                    ->with('info', 'Bàn này đang có order. Đang chuyển đến order hiện tại.');
            }
            
            // Tạo order mới
            $order = Order::create([
                'table_id' => $table->id,
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total_price' => 0,
            ]);
            
            // Cập nhật trạng thái bàn
            $table->update(['status' => 'serving']);
            
            return redirect()->route('waiter.orders.show', $order)
                ->with('success', 'Tạo order thành công!');
        }
        
        // Hiển thị danh sách tất cả bàn
        $tables = RestaurantTable::orderBy('area')->orderBy('name')->get();
        
        // Load order đang active cho mỗi bàn
        $tables->load(['orders' => function($query) {
            $query->whereIn('status', ['pending', 'cooking', 'served']);
        }]);
        
        return view('waiter.orders.create', compact('tables'));
    }

    /**
     * Tạo order mới (giữ lại để tương thích)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:restaurant_tables,id',
        ]);

        $table = RestaurantTable::findOrFail($validated['table_id']);

        // Kiểm tra bàn có order đang chờ không
        $existingOrder = Order::where('table_id', $table->id)
            ->whereIn('status', ['pending', 'cooking', 'served'])
            ->first();

        if ($existingOrder) {
            return redirect()->route('waiter.orders.show', $existingOrder)
                ->with('error', 'Bàn này đang có order chưa hoàn thành.');
        }

        // Tạo order mới
        $order = Order::create([
            'table_id' => $table->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => 0,
        ]);

        // Cập nhật trạng thái bàn
        $table->update(['status' => 'serving']);

        return redirect()->route('waiter.orders.show', $order)
            ->with('success', 'Tạo order thành công!');
    }

    /**
     * Hiển thị chi tiết order và form thêm món
     */
    public function show(Order $order)
    {
        $order->load(['items.food', 'table']);
        $categories = Category::with('foods')->get();
        
        return view('waiter.orders.show', compact('order', 'categories'));
    }

    /**
     * Thêm món vào order
     */
    public function addItem(Request $request, Order $order)
    {
        $validated = $request->validate([
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|integer|min:1|max:50',
        ]);

        $food = Food::findOrFail($validated['food_id']);

        // Kiểm tra món đã có trong order chưa
        $existingItem = OrderItem::where('order_id', $order->id)
            ->where('food_id', $food->id)
            ->first();

        if ($existingItem) {
            // Cập nhật số lượng
            $existingItem->increment('quantity', $validated['quantity']);
        } else {
            // Tạo mới
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $food->id,
                'quantity' => $validated['quantity'],
                'price' => $food->price,
            ]);
        }

        // Cập nhật tổng tiền
        $this->updateOrderTotal($order);

        return redirect()->route('waiter.orders.show', $order)
            ->with('success', 'Thêm món thành công!');
    }

    /**
     * Cập nhật số lượng món
     */
    public function updateItem(Request $request, Order $order, OrderItem $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0|max:50',
        ]);

        if ($validated['quantity'] == 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => $validated['quantity']]);
        }

        $this->updateOrderTotal($order);

        return redirect()->route('waiter.orders.show', $order)
            ->with('success', 'Cập nhật số lượng thành công!');
    }

    /**
     * Xóa món khỏi order
     */
    public function removeItem(Order $order, OrderItem $item)
    {
        $item->delete();
        $this->updateOrderTotal($order);

        return redirect()->route('waiter.orders.show', $order)
            ->with('success', 'Xóa món thành công!');
    }

    /**
     * Gửi bếp (chuyển status order thành cooking)
     */
    public function sendToKitchen(Order $order)
    {
        if ($order->items()->count() == 0) {
            return redirect()->route('waiter.orders.show', $order)
                ->with('error', 'Order chưa có món nào.');
        }

        // Chỉ cho phép gửi bếp khi order đang ở trạng thái pending
        if ($order->status !== 'pending') {
            return redirect()->route('waiter.orders.show', $order)
                ->with('error', 'Order này đã được gửi bếp hoặc đang xử lý.');
        }

        $order->update(['status' => 'cooking']);

        return redirect()->route('waiter.orders.show', $order)
            ->with('success', 'Đã gửi bếp! Đầu bếp sẽ nhận được yêu cầu.');
    }

    /**
     * Cập nhật tổng tiền của order
     */
    private function updateOrderTotal(Order $order)
    {
        $total = $order->items()->sum(DB::raw('quantity * price'));
        $order->update(['total_price' => $total]);
    }
}
