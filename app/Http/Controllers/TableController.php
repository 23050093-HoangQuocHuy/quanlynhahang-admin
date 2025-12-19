<?php

namespace App\Http\Controllers;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;


class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $tables = RestaurantTable::all();
    return view('tables.index', compact('tables'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('tables.create');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'area' => 'nullable',
        'seats' => 'required|numeric',
        'status' => 'required',
    ]);

    RestaurantTable::create($request->all());

    return redirect()->route('tables.index')->with('success', 'Thêm bàn thành công!');
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
    $table = RestaurantTable::findOrFail($id);
    return view('tables.edit', compact('table'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'seats' => 'required|numeric',
        'status' => 'required',
    ]);

    $table = RestaurantTable::findOrFail($id);
    $table->update($request->all());

    return redirect()->route('tables.index')->with('success', 'Cập nhật bàn thành công!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    RestaurantTable::destroy($id);
    return redirect()->route('tables.index')->with('success', 'Xóa bàn thành công!');
}

}
