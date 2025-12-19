@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Tổng quan')

@section('content')

<style>
    .reservation-view-btn:hover {
        background: #4e73df !important;
        color: #fff !important;
    }
</style>

{{-- ==== DASHBOARD ROYAL STYLE ==== --}}
<div class="space-y-8">

    {{-- ======================== --}}
    {{-- THÔNG BÁO ĐẶT BÀN MỚI --}}
    {{-- ======================== --}}
    @if($pendingReservations > 0)
        <div class="alert alert-warning d-flex justify-content-between align-items-center">
            
            <span>
                Bạn có {{ $pendingReservations }} yêu cầu đặt bàn mới đang chờ xử lý
            </span>

            <a href="{{ route('admin.reservations.index') }}"
               class="btn btn-sm reservation-view-btn"
               style="
                   background: #fff;
                   border: 1px solid #4e73df;
                   color: #4e73df;
                   border-radius: 12px;
                   padding: 5px 14px;
                   font-weight: 600;
                   display: flex;
                   align-items: center;
                   gap: 6px;
               ">
               <i class="bi bi-lightning-charge-fill"></i> Xem ngay
            </a>

        </div>
    @endif

    {{-- ======================== --}}
    {{-- 4 THẺ THỐNG KÊ CHÍNH --}}
    {{-- ======================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Tổng đơn hàng -->
    <div class="bg-white rounded-xl shadow p-6 border border-gray-200 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Tổng đơn hàng</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_orders']) }}</p>
            </div>

            <!-- ICON mới: Shopping Bag -->
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 7V6a3 3 0 016 0v1m-6 0h6m-6 0H4a1 1 0 00-1 1v2m14-3h2a1 1 0 011 1v2m-16 0h16m-16 0v9a2 2 0 002 2h12a2 2 0 002-2v-9" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Doanh thu hôm nay -->
    <div class="bg-white rounded-xl shadow p-6 border border-gray-200 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Doanh thu hôm nay</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['today_revenue']) }} đ</p>
            </div>

            <!-- ICON mới: Coins -->
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8c-3.314 0-6 1.343-6 3s2.686 3 6 3 6-1.343 6-3-2.686-3-6-3zm0 6c-3.314 0-6 1.343-6 3s2.686 3 6 3 6-1.343 6-3-2.686-3-6-3z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Đơn chờ xử lý -->
    <div class="bg-white rounded-xl shadow p-6 border border-gray-200 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Đơn chờ xử lý</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['pending_orders']) }}</p>
            </div>

            <!-- ICON mới: Clock -->
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-yellow-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Bàn đang dùng -->
    <div class="bg-white rounded-xl shadow p-6 border border-gray-200 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Bàn đang dùng</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['active_tables']) }}</p>
            </div>

            <!-- ICON mới: Dining Table -->
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 10h18M7 21v-11h10v11M9 3v4m6-4v4" />
                </svg>
            </div>
        </div>
    </div>

</div>



    {{-- ======================== --}}
    {{-- 2 BẢNG DỮ LIỆU --}}
    {{-- ======================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- TOP MÓN ĂN --}}
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Top món ăn bán chạy (7 ngày)
            </h3>

            @if($topFoods->count() > 0)
                <div class="space-y-3">
                    @foreach($topFoods as $food)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">{{ $food->name }}</p>
                                <p class="text-sm text-gray-500">Đã bán: {{ $food->total_quantity }} phần</p>
                            </div>

                            <p class="font-semibold text-green-600">
                                {{ number_format($food->total_revenue) }} đ
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Chưa có dữ liệu</p>
            @endif
        </div>

        {{-- DOANH THU 7 NGÀY --}}
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Doanh thu 7 ngày gần nhất
            </h3>

            @if($revenueByDay->count() > 0)
                <div class="space-y-4">
                    @foreach($revenueByDay as $day)
                        <div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $day->orders_count }} đơn
                                    </p>
                                </div>

                                <p class="font-semibold text-blue-600">
                                    {{ number_format($day->revenue) }} đ
                                </p>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full"
                                     style="width: {{ ($day->revenue / $revenueByDay->max('revenue')) * 100 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Chưa có dữ liệu</p>
            @endif
        </div>

    </div>


    {{-- ======================== --}}
    {{-- 3 THẺ TỔNG QUAN NHỎ --}}
    {{-- ======================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Tổng món ăn --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <p class="text-sm font-medium text-gray-600">Tổng món ăn</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_foods']) }}</p>
        </div>

        {{-- Danh mục --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <p class="text-sm font-medium text-gray-600">Danh mục</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_categories']) }}</p>
        </div>

        {{-- Tổng bàn --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <p class="text-sm font-medium text-gray-600">Tổng bàn</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_tables']) }}</p>
        </div>

    </div>

</div>

@endsection
