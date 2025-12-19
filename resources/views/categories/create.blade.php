<h2>Thêm danh mục</h2>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <label>Tên danh mục</label>
    <input type="text" name="name" required>

    <label>Mô tả</label>
    <textarea name="description"></textarea>

    <button type="submit">Lưu</button>
</form>
