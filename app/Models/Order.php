<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'table_id',
        'user_id',
        'status',
        'total_price',
        'paid_at'
    ];

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   public function items()
{
    return $this->hasMany(OrderItem::class);
}

}
