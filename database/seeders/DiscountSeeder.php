<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        Discount::create([
            'name' => 'Season Sale',
            'type' => 'percentage',
            'value' => 20.00,
            'start_at' => now()->subDays(10),  // 10 ngày trước
            'end_at' => now()->addDays(10),    // 10 ngày từ nay
            'status' => 'active',
        ]);

        Discount::create([
            'name' => 'Black Friday Discount',
            'type' => 'fixed',
            'value' => 50000,
            'start_at' => now()->subDays(5),
            'end_at' => now()->addDays(5),
            'status' => 'active',
        ]);

        Discount::create([
            'name' => 'Summer Discount',
            'type' => 'percentage',
            'value' => 10.00,
            'start_at' => now()->addDays(5),
            'end_at' => now()->addDays(25),
            'status' => 'inactive',  // Discount chưa hoạt động
        ]);

        Discount::create([
            'name' => 'Clearance Sale',
            'type' => 'fixed',
            'value' => 100.00,
            'start_at' => now()->subDays(20),
            'end_at' => now()->subDays(5),
            'status' => 'inactive',  // Discount đã hết hạn
        ]);
    }
}
