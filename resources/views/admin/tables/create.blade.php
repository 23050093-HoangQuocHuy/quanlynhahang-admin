@extends('layouts.admin')

@section('title', 'Thêm Bàn')
@section('page-title', 'Thêm Bàn mới')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Tên bàn -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên bàn <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="Ví dụ: Bàn 1, Bàn VIP 1..."
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Khu vực -->
                <div>
                    <label for="area" class="block text-sm font-medium text-gray-700 mb-2">
                        Khu vực <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="area" 
                        name="area" 
                        value="{{ old('area') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('area') border-red-500 @enderror"
                        placeholder="Ví dụ: Tầng 1, Khu VIP, Ngoài trời..."
                        required
                    >
                    @error('area')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Số ghế -->
                <div>
                    <label for="seats" class="block text-sm font-medium text-gray-700 mb-2">
                        Số ghế <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="seats" 
                        name="seats" 
                        value="{{ old('seats') }}"
                        min="1"
                        max="20"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('seats') border-red-500 @enderror"
                        required
                    >
                    @error('seats')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trạng thái -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Trạng thái <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="status" 
                        name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                        required
                    >
                        <option value="empty" {{ old('status') == 'empty' ? 'selected' : '' }}>Trống</option>
                        <option value="serving" {{ old('status') == 'serving' ? 'selected' : '' }}>Đang phục vụ</option>
                        <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Đã đặt</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.tables.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Hủy
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Lưu
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

