<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'color_id',
        'image_path',
        'is_main',
    ];
    
    public function productVariant()
    {
        return $this->belongsTo(ProductVariants::class);
    }


    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
