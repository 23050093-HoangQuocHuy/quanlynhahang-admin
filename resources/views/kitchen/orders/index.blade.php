@extends('layouts.admin')

@section('title', 'Màn hình Bếp')
@section('page-title', 'Màn hình Bếp - Danh sách Món cần chế biến')

@section('content')
<div class="space-y-6">
    @forelse($orderItems->groupBy('order_id') as $orderId => $items)
        @php
            $order = $items->first()['order'];
            $orderStatus = $order->status;
        @endphp
        <div class="bg-white rounded-lg shadow-lg border-2 {{ $orderStatus == 'cooking' ? 'border-blue-500' : 'border-yellow-500' }} p-6">
            <!-- Header Order -->
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Order #{{ $order->id }}</h3>
                    <p class="text-sm text-gray-600">Bàn: {{ $order->table->name }} | Khu vực: {{ $order->table->area }}</p>
                    <p class="text-sm text-gray-500">Thời gian: {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
                <div class="text-right">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($orderStatus == 'pending') bg-yellow-100 text-yellow-800
                        @else bg-blue-100 text-blue-800
                        @endif">
                        {{ $orderStatus == 'pending' ? 'Chờ nấu' : 'Đang nấu' }}
                    </span>
                    @if($orderStatus == 'pending')
                        <form action="{{ route('kitchen.orders.startCooking', $order) }}" method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold">
                                🍳 Bắt đầu nấu
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Danh sách món -->
            <div class="space-y-3">
                @foreach($items as $itemData)
                    @php
                        $food = $itemData['food'];
                        $quantity = $itemData['total_quantity'];
                    @endphp
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg text-gray-900">{{ $food->name }}</h4>
                            <p class="text-sm text-gray-600">Số lượng: <span class="font-bold text-blue-600">{{ $quantity }}</span> phần</p>
                            @if($food->description)
                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($food->description, 100) }}</p>
                            @endif
                        </div>
                        <div class="flex items-center space-x-4">
                            @if($orderStatus == 'cooking')
                                <form action="{{ route('kitchen.orders.completeItem', [$order, $itemData['items']->first()]) }}" method="POST" onsubmit="return confirm('Đánh dấu hoàn thành món này?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                                        ✓ Hoàn thành
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Nút hoàn thành toàn bộ order -->
            @if($orderStatus == 'cooking')
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <form action="{{ route('kitchen.orders.completeOrder', $order) }}" method="POST" onsubmit="return confirm('Đánh dấu toàn bộ order này đã hoàn thành?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-bold text-lg">
                            ✓ Hoàn thành toàn bộ Order
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <p class="text-2xl text-gray-500 mb-4">🎉</p>
            <p class="text-xl font-semibold text-gray-700">Không có món nào cần chế biến</p>
            <p class="text-gray-500 mt-2">Tất cả order đã được xử lý!</p>
        </div>
    @endforelse
</div>

<!-- Auto refresh mỗi 30 giây -->
<script>
setTimeout(function() {
    location.reload();
}, 30000);
</script>
@endsection

