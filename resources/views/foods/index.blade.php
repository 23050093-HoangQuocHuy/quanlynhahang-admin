<h2>Danh sách Món ăn</h2>

<a href="{{ route('foods.create') }}">+ Thêm món ăn</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Tên</th>
        <th>Danh mục</th>
        <th>Giá</th>
        <th>Hình</th>
        <th>Hành động</th>
    </tr>

    @foreach ($foods as $food)
        <tr>
            <td>{{ $food->name }}</td>
            <td>{{ $food->category->name }}</td>
            <td>{{ $food->price }}</td>
            <td>
                @if(!empty($food->image_url))
                    <img src="{{ $food->image_url }}" width="80" alt="{{ $food->name }}">
                @endif
            </td>
            <td>
                <a href="{{ route('foods.edit', $food->id) }}">Sửa</a>

                <form action="{{ route('foods.destroy', $food->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Xóa</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
