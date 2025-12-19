<h2>Thêm món ăn</h2>

<form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Tên món</label>
    <input type="text" name="name" required>

    <label>Giá</label>
    <input type="number" name="price" required>

    <label>Danh mục</label>
    <select name="category_id">
        @foreach ($categories as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
    </select>

    <label>Hình ảnh</label>
    <input type="file" name="image">

    <label>Mô tả</label>
    <textarea name="description"></textarea>

    <button type="submit">Lưu</button>
</form>
