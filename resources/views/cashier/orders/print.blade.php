<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn #{{ $order->id }}</title>
    <style>
        @media print {
            body { margin: 0; padding: 20px; }
            .no-print { display: none; }
            @page { margin: 0.5cm; }
        }
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ In hóa đơn
        </button>
        <a href="{{ route('cashier.orders.show', $order) }}" style="margin-left: 10px; padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;">
            Quay lại
        </a>
    </div>

    <div class="header">
        <h1>🍽️ NHÀ HÀNG</h1>
        <p>Hóa đơn thanh toán</p>
    </div>

    <div class="info">
        <p><strong>Mã hóa đơn:</strong> #{{ $order->id }}</p>
        <p><strong>Bàn:</strong> {{ $order->table->name }} - {{ $order->table->area }}</p>
        <p><strong>Ngày:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
        @if($order->user)
            <p><strong>Nhân viên:</strong> {{ $order->user->name }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên món</th>
                <th>Đơn giá</th>
                <th>SL</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->food->name }}</td>
                    <td>{{ number_format($item->price) }} đ</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->quantity * $item->price) }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Tổng cộng: <span style="font-size: 24px;">{{ number_format($order->total_price) }} đ</span></p>
    </div>

    <div class="footer">
        <p>Cảm ơn quý khách!</p>
        <p>Hẹn gặp lại</p>
    </div>
</body>
</html>

