<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'price',
        'category',      // add
        'unit',          // add
        'description',   // add
        'tag',           // add
        'stock_quantity', // add
        'is_active',
        'is_featured',
        'in_stock',
        'on_sale',
        // keep category_id & brand_id if you re-enable those FK columns later
    ];

    protected $casts = [
        'image'       => 'array',   // since it's json in migration
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'in_stock'    => 'boolean',
        'on_sale'     => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class); // also fixed: brands() → brand()
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}