<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Order cho Bàn {{ $order->table->name }}</title>
</head>
<body>

<h2>Order cho {{ $order->table->name }}</h2>

<h3>Thêm món ăn</h3>

<form action="{{ route('order_items.store') }}" method="POST">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">

    <select name="food_id">
        @foreach ($foods as $food)
            <option value="{{ $food->id }}">
                {{ $food->name }} - {{ number_format($food->price) }} VND
            </option>
        @endforeach
    </select>

    <input type="number" name="quantity" value="1" min="1">

    <button type="submit">Thêm món</button>
</form>

<hr>

<h3>Món đã gọi</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Tên món</th>
        <th>Số lượng</th>
        <th>Đơn giá</th>
        <th>Tổng</th>
    </tr>

    @foreach ($order->items as $item)
        <tr>
            <td>{{ $item->food->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price) }} VND</td>
            <td>{{ number_format($item->quantity * $item->price) }} VND</td>
        </tr>
    @endforeach
</table>

<br>

<h3>Tổng cộng: {{ number_format($order->total_price) }} VND</h3>

</body>
</html>
