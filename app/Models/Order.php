<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status'];

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
}
