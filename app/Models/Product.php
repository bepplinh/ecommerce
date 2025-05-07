<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'description',
        'price',
        'category_id',
        'brand_id',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class)->withPivot('stock')->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }
    public function productVariants()
    {
        return $this->hasMany(ProductVariants::class);
    }

    public function getSalePriceAttribute()
    {
        // Kiểm tra xem sản phẩm có chương trình giảm giá hay không
        if ($this->discount) {
            // Nếu loại giảm giá là 'percentage', tính giá khuyến mãi theo tỷ lệ phần trăm
            if ($this->discount->type === 'percentage') {
                return $this->price - ($this->price * $this->discount->value / 100);
            }
            // Nếu loại giảm giá là 'fixed', giảm giá một giá trị cố định
            elseif ($this->discount->type === 'fixed') {
                return $this->price - $this->discount->value;
            }
        }

        // Nếu không có giảm giá, trả về giá gốc
        return $this->price;
    }
}
