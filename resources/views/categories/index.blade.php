<h2>Danh sách Danh mục</h2>

<a href="{{ route('categories.create') }}">+ Thêm danh mục</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Tên danh mục</th>
        <th>Mô tả</th>
        <th>Hành động</th>
    </tr>

    @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td>
                <a href="{{ route('categories.edit', $category->id) }}">Sửa</a>

                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Xóa</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
