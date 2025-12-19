<h2>Danh sách Bàn</h2>
<a href="{{ route('tables.create') }}">+ Thêm bàn</a>

<style>
    .table-box {
        width: 150px;
        height: 120px;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        cursor: pointer;
        margin: 10px;
        color: white;
        font-size: 20px;
    }
    .empty { background: #1abc9c; }
    .serving { background: #e74c3c; }
    .reserved { background: #f1c40f; }
</style>

<div style="display:flex; flex-wrap:wrap;">
    @foreach ($tables as $t)
        <div class="table-box {{ $t->status }}">
            {{ $t->name }}
        </div>
    @endforeach
</div>
