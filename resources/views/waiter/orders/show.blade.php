@extends('layouts.admin')

@section('title', 'Chi tiết Order')
@section('page-title', 'Order cho Bàn ' . $order->table->name)

@section('content')
<div class="space-y-6">
    <!-- Header Order -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Order #{{ $order->id }}</h3>
                <p class="text-sm text-gray-500">Bàn: {{ $order->table->name }} | Khu vực: {{ $order->table->area }}</p>
                <p class="text-sm text-gray-500">Trạng thái: 
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status == 'cooking') bg-blue-100 text-blue-800
                        @elseif($order->status == 'served') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-gray-900">Tổng: {{ number_format($order->total_price) }} đ</p>
            </div>
        </div>
    </div>

    <!-- Form thêm món -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Thêm món</h3>
        <form action="{{ route('waiter.orders.addItem', $order) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Danh mục</label>
                    <select id="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" onchange="filterFoods()">
                        <option value="">Tất cả</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-1">
                    <label for="food_id" class="block text-sm font-medium text-gray-700 mb-2">Món ăn</label>
                    <select id="food_id" name="food_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Chọn món --</option>
                        @foreach($categories as $category)
                            @foreach($category->foods as $food)
                                <option value="{{ $food->id }}" data-category="{{ $category->id }}" data-price="{{ $food->price }}">
                                    {{ $food->name }} - {{ number_format($food->price) }} đ
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-1">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Số lượng</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="50" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                + Thêm món
            </button>
        </form>
    </div>

    <!-- Danh sách món đã gọi -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Danh sách món đã gọi</h3>
        @if($order->items->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên món</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Đơn giá</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thành tiền</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->food->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($item->price) }} đ
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('waiter.orders.updateItem', [$order, $item]) }}" method="POST" class="inline-flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="w-8 h-8 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                        <span class="w-12 text-center">{{ $item->quantity }}</span>
                                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="w-8 h-8 bg-gray-200 rounded hover:bg-gray-300">+</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ number_format($item->quantity * $item->price) }} đ
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('waiter.orders.removeItem', [$order, $item]) }}" method="POST" class="inline" onsubmit="return confirm('Xóa món này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Tổng cộng:</td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900">
                                {{ number_format($order->total_price) }} đ
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($order->status == 'pending')
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('waiter.orders.create') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Quay lại danh sách bàn
                    </a>
                    <form action="{{ route('waiter.orders.sendToKitchen', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold">
                            🍳 Gửi bếp
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('waiter.orders.create') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Quay lại danh sách bàn
                    </a>
                </div>
            @endif
        @else
            <p class="text-center text-gray-500 py-8">Chưa có món nào trong order.</p>
        @endif
    </div>
</div>

<script>
function filterFoods() {
    const categoryId = document.getElementById('category_id').value;
    const foodSelect = document.getElementById('food_id');
    const options = foodSelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            const optionCategory = option.getAttribute('data-category');
            if (!categoryId || optionCategory == categoryId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        }
    });
    
    foodSelect.value = '';
}
</script>
@endsection

