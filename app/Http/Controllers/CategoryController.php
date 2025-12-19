<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $categories = Category::all();
    return view('categories.index', compact('categories'));
}

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    return view('categories.create');
}


    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'description' => 'nullable'
    ]);

    Category::create($request->all());

    return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
 public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('categories.edit', compact('category'));
}


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
    ]);

    $category = Category::findOrFail($id);
    $category->update($request->all());

    return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
}


    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    Category::destroy($id);
    return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
}

}
