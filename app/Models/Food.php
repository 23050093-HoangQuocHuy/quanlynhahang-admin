<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods'; // ✔ đảm bảo đúng bảng

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image_url'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
