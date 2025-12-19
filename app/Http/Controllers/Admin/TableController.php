<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

/**
 * Controller quản lý Bàn (RestaurantTable)
 * Admin có toàn quyền quản lý
 * Waiter chỉ được xem sơ đồ bàn
 */
class TableController extends Controller
{
    /**
     * Hiển thị sơ đồ bàn (dạng grid)
     * Admin và Waiter đều có thể xem
     */
    public function index()
    {
        $tables = RestaurantTable::orderBy('area')->orderBy('name')->get();
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Hiển thị form tạo bàn mới
     */
    public function create()
    {
        return view('admin.tables.create');
    }

    /**
     * Lưu bàn mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:restaurant_tables,name',
            'area' => 'required|string|max:255',
            'seats' => 'required|integer|min:1|max:20',
            'status' => 'required|in:empty,serving,reserved',
        ], [
            'name.required' => 'Tên bàn không được để trống.',
            'name.unique' => 'Tên bàn đã tồn tại.',
            'area.required' => 'Khu vực không được để trống.',
            'seats.required' => 'Số ghế không được để trống.',
            'seats.integer' => 'Số ghế phải là số nguyên.',
            'seats.min' => 'Số ghế phải lớn hơn 0.',
            'seats.max' => 'Số ghế không được vượt quá 20.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        RestaurantTable::create($validated);

        return redirect()->route('admin.tables.index')
            ->with('success', 'Thêm bàn thành công!');
    }

    /**
     * Hiển thị form sửa bàn
     */
    public function edit(RestaurantTable $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    /**
     * Cập nhật bàn
     */
    public function update(Request $request, RestaurantTable $table)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:restaurant_tables,name,' . $table->id,
            'area' => 'required|string|max:255',
            'seats' => 'required|integer|min:1|max:20',
            'status' => 'required|in:empty,serving,reserved',
        ], [
            'name.required' => 'Tên bàn không được để trống.',
            'name.unique' => 'Tên bàn đã tồn tại.',
            'area.required' => 'Khu vực không được để trống.',
            'seats.required' => 'Số ghế không được để trống.',
            'seats.integer' => 'Số ghế phải là số nguyên.',
            'seats.min' => 'Số ghế phải lớn hơn 0.',
            'seats.max' => 'Số ghế không được vượt quá 20.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        $table->update($validated);

        return redirect()->route('admin.tables.index')
            ->with('success', 'Cập nhật bàn thành công!');
    }

    /**
     * Xóa bàn
     */
    public function destroy(RestaurantTable $table)
    {
        // Kiểm tra xem bàn có đang được sử dụng không
        if ($table->orders()->whereIn('status', ['pending', 'cooking', 'served'])->exists()) {
            return redirect()->route('admin.tables.index')
                ->with('error', 'Không thể xóa bàn này vì đang có đơn hàng chưa hoàn thành.');
        }

        $table->delete();

        return redirect()->route('admin.tables.index')
            ->with('success', 'Xóa bàn thành công!');
    }
}

