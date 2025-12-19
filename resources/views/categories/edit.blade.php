<h2>Sửa danh mục</h2>

<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Tên danh mục</label>
    <input type="text" name="name" value="{{ $category->name }}" required>

    <label>Mô tả</label>
    <textarea name="description">{{ $category->description }}</textarea>

    <button type="submit">Cập nhật</button>
</form>
