<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariants extends Model
{
    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_variant_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_variant_id');
    }
}
