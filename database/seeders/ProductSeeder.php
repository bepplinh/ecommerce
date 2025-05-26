<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Size; 
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('vi_VN');
        $sizes = Size::all();

        // Danh sách tên sản phẩm mẫu
        $productNames = [
            'Áo Sơ Mi Nam', 'Áo Sơ Mi Nữ', 'Quần Jean Nam', 'Quần Jean Nữ',
            'Giày Thể Thao', 'Giày Cao Gót', 'Áo Khoác Nam', 'Áo Khoác Nữ',
            'Dây Chuyền Nữ', 'Bóp Ví Nam', 'Đầm Nữ', 'Váy Nữ'
        ];

        for ($i = 0; $i < 50; $i++) {
            $name = $faker->randomElement($productNames) . ' ' . strtoupper(Str::random(4)) . ' ' . ($i+1);
            $category_id = rand(1, 6);
            $brand_id = rand(1, 8);

            Product::create([
                'name' => $name,
                'code' => strtoupper(Str::random(8)),
                'description' => $faker->sentence,
                'price' => rand(100000, 2000000),
                'category_id' => $category_id,
                'brand_id' => $brand_id,
                'status' => collect(['active', 'inactive'])->random(),
            ]);
        }
    }
}
