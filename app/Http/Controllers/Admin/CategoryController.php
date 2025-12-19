<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Controller quản lý Danh mục món (Category)
 * Chỉ admin mới được truy cập
 */
class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục
     */
    public function index()
    {
        $categories = Category::withCount('foods')->orderBy('created_at', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Hiển thị form tạo danh mục mới
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Lưu danh mục mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công!');
    }

    /**
     * Hiển thị form sửa danh mục
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Cập nhật danh mục
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Xóa danh mục
     */
    public function destroy(Category $category)
    {
        // Kiểm tra xem danh mục có món ăn không
        if ($category->foods()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục này vì đang có món ăn thuộc danh mục.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}

