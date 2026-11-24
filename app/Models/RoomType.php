<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = ['name', 'default_size', 'base_monthly_price', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'base_monthly_price' => 'decimal:2',
    ];
}