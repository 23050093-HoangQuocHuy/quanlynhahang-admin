@extends('layouts.admin')

@section('title', 'Chọn Bàn - Tạo Order')
@section('page-title', 'Chọn Bàn để Tạo Order')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Danh sách Bàn</h3>
        <p class="text-sm text-gray-600 mb-6">Chọn bàn để tạo order mới hoặc xem order đang phục vụ</p>
    </div>

    <!-- Sơ đồ bàn dạng grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($tables as $table)
            @php
                $statusColors = [
                    'empty' => 'bg-green-100 border-green-300 text-green-800',
                    'serving' => 'bg-yellow-100 border-yellow-300 text-yellow-800',
                    'reserved' => 'bg-red-100 border-red-300 text-red-800',
                ];
                $statusLabels = [
                    'empty' => 'Trống',
                    'serving' => 'Đang phục vụ',
                    'reserved' => 'Đã đặt',
                ];
                
                // Kiểm tra bàn có order đang active không
                $activeOrder = $table->orders->first();
            @endphp
            <div class="bg-white rounded-lg shadow-lg border-2 {{ $statusColors[$table->status] }} p-6 hover:shadow-xl transition">
                <div class="text-center">
                    <h3 class="text-xl font-bold mb-2">{{ $table->name }}</h3>
                    <p class="text-sm mb-1">
                        <span class="font-semibold">Khu vực:</span> {{ $table->area }}
                    </p>
                    <p class="text-sm mb-3">
                        <span class="font-semibold">Số ghế:</span> {{ $table->seats }}
                    </p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$table->status] }}">
                        {{ $statusLabels[$table->status] }}
                    </span>
                </div>

                <div class="mt-4">
                    @if($activeOrder)
                        <a href="{{ route('waiter.orders.show', $activeOrder) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-semibold">
                            Xem Order #{{ $activeOrder->id }}
                        </a>
                        <p class="text-xs text-center text-gray-600 mt-2">
                            Trạng thái: 
                            <span class="font-semibold
                                @if($activeOrder->status == 'pending') text-yellow-600
                                @elseif($activeOrder->status == 'cooking') text-blue-600
                                @elseif($activeOrder->status == 'served') text-green-600
                                @endif">
                                {{ ucfirst($activeOrder->status) }}
                            </span>
                        </p>
                    @else
                        <a href="{{ route('waiter.orders.create', ['table_id' => $table->id]) }}" class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition font-semibold">
                            Tạo Order Mới
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="text-lg">Chưa có bàn nào.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
