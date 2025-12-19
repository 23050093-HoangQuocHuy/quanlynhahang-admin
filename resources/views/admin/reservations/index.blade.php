@extends('layouts.admin')

@section('title', 'Quản lý Đặt bàn')
@section('page-title', 'Quản lý Đặt bàn')

@section('content')

@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Danh sách Đặt bàn</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ tên</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SĐT</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số khách</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giờ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bàn</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ghi chú</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($reservations as $reservation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $reservation->fullname }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $reservation->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $reservation->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $reservation->guests }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $reservation->time }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($reservation->table)
                                {{ $reservation->table->name }}
                            @else
                                <span class="text-red-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div class="max-w-xs truncate" title="{{ $reservation->notes }}">
                                {{ $reservation->notes ?? 'Không có' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'Chờ xử lý',
                                    'confirmed' => 'Đã xác nhận',
                                    'rejected' => 'Đã từ chối',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$reservation->status ?? 'pending'] }}">
                                {{ $statusLabels[$reservation->status ?? 'pending'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            @if(($reservation->status ?? 'pending') === 'pending')
                                <form action="{{ route('admin.reservations.confirm', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition"
                                            onclick="return confirm('Bạn có chắc muốn xác nhận đặt bàn này?');">
                                        Xác nhận
                                    </button>
                                </form>
                                <form action="{{ route('admin.reservations.reject', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                                            onclick="return confirm('Bạn có chắc muốn từ chối đặt bàn này?');">
                                        Từ chối
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400">Đã xử lý</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-6 py-4 text-center text-gray-500">Chưa có đặt bàn nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

