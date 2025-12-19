@extends('layouts.admin')

@section('title', 'Thêm Món ăn')
@section('page-title', 'Thêm Món ăn mới')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.foods.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Tên món -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên món ăn <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="Ví dụ: Phở Bò, Bún Chả..."
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Danh mục -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Danh mục <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="category_id" 
                        name="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Giá -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Giá bán (VNĐ) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        value="{{ old('price') }}"
                        min="0"
                        step="1000"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror"
                        placeholder="Ví dụ: 50000"
                        required
                    >
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Mô tả
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                        placeholder="Mô tả về món ăn..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL ảnh -->
                <div>
                    <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                        Đường dẫn ảnh (URL)
                    </label>
                    <input 
                        type="text" 
                        id="image_url" 
                        name="image_url" 
                        value="{{ old('image_url') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_url') border-red-500 @enderror"
                        placeholder="https://example.com/image.jpg"
                    >
                    <p class="mt-1 text-sm text-gray-500">Ví dụ: https://example.com/image.jpg</p>
                    @error('image_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="previewImg" src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.foods.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
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

<script>
// Preview ảnh từ URL
document.getElementById('image_url').addEventListener('input', function(e) {
    const url = e.target.value;
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (url && url.startsWith('http')) {
        previewImg.src = url;
        preview.classList.remove('hidden');
        previewImg.onerror = function() {
            preview.classList.add('hidden');
        };
    } else {
        preview.classList.add('hidden');
    }
});
</script>
@endsection
