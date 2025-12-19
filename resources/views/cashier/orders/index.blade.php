@extends('layouts.admin')

@section('title', 'Màn hình Thu ngân')
@section('page-title', 'Màn hình Thu ngân - Danh sách Bàn cần thanh toán')

@section('content')
<div class="space-y-6">
    @forelse($orders as $order)
        <div class="bg-white rounded-lg shadow-lg border-2 border-green-500 p-6 hover:shadow-xl transition">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Order #{{ $order->id }}</h3>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p><span class="font-semibold">Bàn:</span> {{ $order->table->name }} | <span class="font-semibold">Khu vực:</span> {{ $order->table->area }}</p>
                        <p><span class="font-semibold">Thời gian:</span> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                        <p><span class="font-semibold">Số món:</span> {{ $order->items->count() }} món</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-green-600 mb-4">{{ number_format($order->total_price) }} đ</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('cashier.orders.show', $order) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Xem chi tiết
                        </a>
                        <a href="{{ route('cashier.orders.print', $order) }}" target="_blank" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            In hóa đơn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <p class="text-2xl text-gray-500 mb-4">💰</p>
            <p class="text-xl font-semibold text-gray-700">Không có bàn nào cần thanh toán</p>
            <p class="text-gray-500 mt-2">Tất cả order đã được thanh toán!</p>
        </div>
    @endforelse
</div>
@endsection

