<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Các cột cho phép fill.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * Ẩn các cột khi trả JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kiểu dữ liệu của các cột.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Quan hệ: User thuộc về một Role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
