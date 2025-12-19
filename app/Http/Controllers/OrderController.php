<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\RestaurantTable;
use App\Models\Food;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $tables = RestaurantTable::all();
    return view('orders.select_table', compact('tables'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'table_id' => 'required|exists:restaurant_tables,id',
    ]);

    // Tạo order mới
    $order = Order::create([
        'table_id'    => $request->table_id,
        'user_id'     => null,           // sau này gắn auth()->id()
        'status'      => 'pending',
        'total_price' => 0,
    ]);

    // Cập nhật trạng thái bàn
    $table = RestaurantTable::find($request->table_id);
    $table->status = 'serving';
    $table->save();

    // ⚠️ Quan trọng: redirect bằng ID THẬT, không phải '{id}'
    return redirect()->route('orders.edit', $order->id);
    // hoặc: return redirect()->route('orders.edit', ['order' => $order->id]);
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $order = Order::with('items.food')->findOrFail($id);
    $foods = Food::all(); // lấy danh sách món ăn

    return view('orders.edit', compact('order', 'foods'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
{
    $request->validate([
        'food_id' => 'required|exists:foods,id',
    ]);

    // Lấy món ăn
    $food = Food::find($request->food_id);

    // Kiểm tra xem món đã tồn tại trong order chưa
    $item = OrderItem::where('order_id', $order->id)
        ->where('food_id', $food->id)
        ->first();

    if ($item) {
        // Nếu có rồi → tăng số lượng
        $item->quantity += 1;
        $item->price = $food->price;
        $item->save();
    } else {
        // Nếu chưa có → tạo mới
        OrderItem::create([
            'order_id' => $order->id,
            'food_id'  => $food->id,
            'quantity' => 1,
            'price'    => $food->price,
        ]);
    }

    // Cập nhật tổng tiền
    $order->total_price = OrderItem::where('order_id', $order->id)
        ->sum(DB::raw('quantity * price'));
    $order->save();

    return back();
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
