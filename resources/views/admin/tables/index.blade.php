@extends('layouts.admin')

@section('title', 'Quản lý Bàn')
@section('page-title', 'Sơ đồ Bàn')

@section('content')
@if(auth()->user()->role->name === 'admin')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.tables.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            + Thêm bàn mới
        </a>
    </div>
@endif

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

            @if(auth()->user()->role->name === 'admin')
                <div class="mt-4 flex justify-center space-x-2">
                    <a href="{{ route('admin.tables.edit', $table) }}" class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                        Sửa
                    </a>
                    <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa bàn này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                            Xóa
                        </button>
                    </form>
                </div>
            @elseif(auth()->user()->role->name === 'waiter')
                @php
                    $existingOrder = \App\Models\Order::where('table_id', $table->id)
                        ->whereIn('status', ['pending', 'cooking', 'served'])
                        ->first();
                @endphp
                @if($table->status === 'empty' || !$existingOrder)
                    <div class="mt-4">
                        <a href="{{ route('waiter.orders.create', ['table_id' => $table->id]) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Tạo Order
                        </a>
                    </div>
                @else
                    <div class="mt-4">
                        <a href="{{ route('waiter.orders.show', $existingOrder) }}" class="block w-full text-center px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                            Xem Order
                        </a>
                    </div>
                @endif
            @endif
        </div>
    @empty
        <div class="col-span-full text-center py-12 text-gray-500">
            <p class="text-lg">Chưa có bàn nào.</p>
            @if(auth()->user()->role->name === 'admin')
                <a href="{{ route('admin.tables.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Thêm bàn đầu tiên
                </a>
            @endif
        </div>
    @endforelse
</div>
@endsection

