<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    protected $fillable = [
        'name',
        'area',
        'seats',
        'status'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }

    /**
     * Lấy order đang active (pending, cooking, served)
     */
    public function activeOrder()
    {
        return $this->hasOne(Order::class, 'table_id')
            ->whereIn('status', ['pending', 'cooking', 'served']);
    }
}
