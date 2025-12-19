@extends('layouts.admin')

@section('title', 'Báo cáo Doanh thu')
@section('page-title', 'Báo cáo Doanh thu')

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Lọc báo cáo</h3>
        <form method="GET" action="{{ route('admin.reports.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Từ ngày</label>
                    <input 
                        type="date" 
                        id="date_from" 
                        name="date_from" 
                        value="{{ $dateFrom }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Đến ngày</label>
                    <input 
                        type="date" 
                        id="date_to" 
                        name="date_to" 
                        value="{{ $dateTo }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lọc nhanh</label>
                    <select name="quick_filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="">-- Chọn --</option>
                        <option value="today">Hôm nay</option>
                        <option value="this_month">Tháng này</option>
                        <option value="this_year">Năm nay</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Xem báo cáo
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tổng số đơn đã thanh toán</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($revenueStats->total_orders ?? 0) }}</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-3xl">📦</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tổng doanh thu</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($revenueStats->total_revenue ?? 0) }} đ</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                    <span class="text-3xl">💰</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Foods -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top món ăn bán chạy</h3>
        @if($topFoods->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">STT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên món</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số lần gọi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($topFoods as $index => $food)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $food->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        {{ number_format($food->total_quantity) }} phần
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                    {{ number_format($food->total_revenue) }} đ
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-500 py-8">Chưa có dữ liệu trong khoảng thời gian này.</p>
        @endif
    </div>

    <!-- Revenue by Day -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Doanh thu theo ngày</h3>
        @if($revenueByDay->count() > 0)
            <div class="space-y-3">
                @foreach($revenueByDay as $day)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $day->orders_count }} đơn</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-green-600">{{ number_format($day->revenue) }} đ</p>
                        </div>
                        <div class="w-64 ml-4">
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-500 h-3 rounded-full" style="width: {{ ($day->revenue / $revenueByDay->max('revenue')) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 py-8">Chưa có dữ liệu trong khoảng thời gian này.</p>
        @endif
    </div>
</div>
@endsection

