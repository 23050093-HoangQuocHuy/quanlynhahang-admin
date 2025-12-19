<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;

class FoodApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Food::all()
        ]);
    }
}
