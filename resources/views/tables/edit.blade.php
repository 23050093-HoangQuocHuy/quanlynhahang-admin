<h2>Thêm Bàn ăn</h2>

<form action="{{ route('tables.store') }}" method="POST">
    @csrf

    <label>Tên bàn</label>
    <input type="text" name="name" required>

    <label>Khu vực</label>
    <input type="text" name="area">

    <label>Số ghế</label>
    <input type="number" name="seats" value="4" required>

    <label>Trạng thái</label>
    <select name="status">
        <option value="empty">Trống</option>
        <option value="serving">Đang phục vụ</option>
        <option value="reserved">Đã đặt trước</option>
    </select>

    <button type="submit">Lưu</button>
</form>
