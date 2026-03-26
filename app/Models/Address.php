<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'order_id',
        'firstName',
        'last_name',
        'phone_number',
        'street_address',
        'city',
        'state',
        'zip_code',
    ];

    // Define the relationship with the Order model
    public function orders()
    {
        return $this->belongsTo(Order::class);
    }

    public function fullName()
    {
        $fullName = $this->firstName.' '.$this->last_name;

        return $fullName;
    }
}
