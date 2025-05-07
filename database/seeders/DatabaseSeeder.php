<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\SizeSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ProductSizeSeeder;



class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            DiscountSeeder::class,
            ProductSeeder::class,
            ProductVariantsSeeder::class,
        ]);
    }
}
