<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'payment_method',
        'payment_status',
        'staus',
        'currency',
        'shipping_amount',
        'shipping_method',
        'notes',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
    public function getTotalAmountAttribute()
{
    return $this->orderItems->sum('total_amount');
}


protected $appends = ['total_amount'];
}
