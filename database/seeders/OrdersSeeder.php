<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'reservation_id' => 1,
                'total_price' => 100.00,
                'status' => 'pending',
                'order_time' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reservation_id' => 2,
                'total_price' => 250.00,
                'status' => 'pending',
                'order_time' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
