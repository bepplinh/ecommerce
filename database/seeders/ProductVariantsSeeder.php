<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductVariantsSeeder extends Seeder
{
    public function run()
    {
        // Assuming you have at least one product, color, and size in the database
        $products = \App\Models\Product::all();
        $colors = \App\Models\Color::all();
        $sizes = \App\Models\Size::all();

        foreach ($products as $product) {
            // Select only 3 random colors for each product
            $selectedColors = $colors->random(3);

            // Select only 2 random sizes for each product
            $selectedSizes = $sizes->random(2);

            foreach ($selectedColors as $color) {
                foreach ($selectedSizes as $size) {
                    DB::table('product_variants')->insert([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'size_id' => $size->id,
                        'stock' => rand(1, 100), // Random stock for demonstration
                        'price' => rand(1000, 5000) / 100, // Random price between 10.00 and 50.00
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
