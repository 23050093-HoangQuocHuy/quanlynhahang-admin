<?php

namespace App\Http\Controllers;
use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $foods = Food::with('category')->get();
    return view('foods.index', compact('foods'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $categories = Category::all();
    return view('foods.create', compact('categories'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'category_id' => 'required',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $data = $request->all();

    // xử lý upload ảnh
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/foods'), $filename);
        $data['image'] = $filename;
    }

    Food::create($data);

    return redirect()->route('foods.index')->with('success', 'Thêm món ăn thành công!');
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
    $food = Food::findOrFail($id);
    $categories = Category::all();
    return view('foods.edit', compact('food', 'categories'));
}


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'category_id' => 'required',
    ]);

    $food = Food::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/foods'), $filename);
        $data['image'] = $filename;
    }

    $food->update($data);

    return redirect()->route('foods.index')->with('success', 'Cập nhật món ăn thành công!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    Food::destroy($id);
    return redirect()->route('foods.index')->with('success', 'Xóa món ăn thành công!');
}

}
