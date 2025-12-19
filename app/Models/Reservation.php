<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'fullname', 'phone', 'email',
        'guests', 'date', 'time',
        'table_id', 'notes', 'status',
    ];

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }
}
