<h2>Chọn bàn để tạo Order</h2>

@foreach ($tables as $table)
    <a href="{{ route('orders.store', ['table_id' => $table->id]) }}"
       onclick="event.preventDefault(); document.getElementById('form-{{ $table->id }}').submit();"
       style="display:inline-block; padding:20px; margin:10px; background:#3498db; color:white; border-radius:10px; text-align:center;">
        {{ $table->name }}
    </a>

    <form id="form-{{ $table->id }}" action="{{ route('orders.store') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="table_id" value="{{ $table->id }}">
    </form>
@endforeach
