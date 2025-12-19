<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'food_id',
        'quantity',
        // nếu trong bảng order_items có cột price thì giữ dòng dưới,
        // nếu không có cột price thì xoá dòng 'price' đi
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

public function food()
{
    return $this->belongsTo(Food::class);
}

}
