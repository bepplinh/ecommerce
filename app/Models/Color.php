<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name',
        'hex_code',
    ];

    public function productVariants()
    {
        return $this->hasMany(ProductVariants::class);
    }


    public function sizes()
    {
        return $this->hasManyThrough(Size::class, ProductVariants::class);
    }
}
