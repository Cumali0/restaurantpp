<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 1, // İlk sipariş
                'product_id' => 1, // Mercimek çorbası
                'quantity' => 2,
                'price' => 25.00,
                'total_price' => 50.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 1,
                'product_id' => 2, // Izgara tavuk
                'quantity' => 1,
                'price' => 60.00,
                'total_price' => 60.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2, // İkinci sipariş
                'product_id' => 3, // Baklava
                'quantity' => 3,
                'price' => 30.00,
                'total_price' => 90.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
