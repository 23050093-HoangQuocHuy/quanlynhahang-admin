@extends('layouts.admin')

@section('title', 'Chi tiết Order - Thanh toán')
@section('page-title', 'Chi tiết Order #' . $order->id)

@section('content')
<div class="space-y-6">
    <!-- Thông tin Order -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h3>
                <p class="text-sm text-gray-600 mt-2">
                    Bàn: <span class="font-semibold">{{ $order->table->name }}</span> | 
                    Khu vực: <span class="font-semibold">{{ $order->table->area }}</span>
                </p>
                <p class="text-sm text-gray-500">Thời gian: {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">Tổng tiền</p>
                <p class="text-3xl font-bold text-green-600">{{ number_format($order->total_price) }} đ</p>
            </div>
        </div>

        <!-- Danh sách món -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">STT</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên món</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Đơn giá</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->items as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->food->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($item->price) }} đ</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ number_format($item->quantity * $item->price) }} đ
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Tổng cộng:</td>
                        <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900">
                            {{ number_format($order->total_price) }} đ
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Buttons -->
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('cashier.orders.print', $order) }}" target="_blank" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                🖨️ In hóa đơn
            </a>
            <form action="{{ route('cashier.orders.pay', $order) }}" method="POST" onsubmit="return confirm('Xác nhận thanh toán order này?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                    💰 Thanh toán
                </button>
            </form>
            <a href="{{ route('cashier.orders.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Quay lại
            </a>
        </div>
    </div>
</div>
@endsection

