<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Controller quản lý Món ăn (Food)
 * Chỉ admin mới được quản lý (tạo/sửa/xóa)
 */
class FoodController extends Controller
{
    /**
     * Hiển thị danh sách món ăn
     */
    public function index(Request $request)
    {
        $query = Food::with('category');

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $foods = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::all();

        return view('admin.foods.index', compact('foods', 'categories'));
    }

    /**
     * Hiển thị form tạo món ăn mới
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.foods.create', compact('categories'));
    }

    /**
     * Lưu món ăn mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
        ], [
            'name.required' => 'Tên món ăn không được để trống.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'price.required' => 'Giá món ăn không được để trống.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'image_url.url' => 'Đường dẫn ảnh phải là URL hợp lệ.',
        ]);

        Food::create($validated);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Thêm món ăn thành công!');
    }

    /**
     * Hiển thị form sửa món ăn
     */
    public function edit(Food $food)
    {
        $categories = Category::all();
        return view('admin.foods.edit', compact('food', 'categories'));
    }

    /**
     * Cập nhật món ăn
     */
    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
        ], [
            'name.required' => 'Tên món ăn không được để trống.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'price.required' => 'Giá món ăn không được để trống.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'image_url.url' => 'Đường dẫn ảnh phải là URL hợp lệ.',
        ]);

        // Nếu image_url để trống, giữ nguyên ảnh cũ
        if (empty($validated['image_url'])) {
            unset($validated['image_url']);
        }

        $food->update($validated);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Cập nhật món ăn thành công!');
    }

    /**
     * Xóa món ăn
     */
    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->route('admin.foods.index')
            ->with('success', 'Xóa món ăn thành công!');
    }
}
