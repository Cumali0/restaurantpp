<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'order_id' => 1, // İlk sipariş
                'table_id' => 1, // Bahçe 1
                'payment_method_id' => 1, // Nakit
                'amount_price' => 100.00,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2, // İkinci sipariş
                'table_id' => 3, // İç Salon 1
                'payment_method_id' => 2, // Kredi Kartı
                'amount_price' => 250.00,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
