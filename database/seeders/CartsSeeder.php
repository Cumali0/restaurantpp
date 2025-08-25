<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('carts')->insert([
            [

                'reservation_id' => 1, // Bu artık carts tablosunda olmalı
                'order_id' => 1,
                'token' => Str::uuid(), // Rastgele token oluşturmak için
                'total_price' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reservation_id' => 1,
                'order_id' => 2,
                'token' => Str::uuid(),
                'total_price' => 250.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
