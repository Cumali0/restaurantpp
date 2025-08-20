<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id' => 1, // Çorba
                'description' => 'Ev yapımı mercimek çorbası.',
                'img' => null,
                'price' => 25.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2, // Ana Yemek
                'description' => 'Izgara tavuk, sebzelerle.',
                'img' => null,
                'price' => 60.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3, // Tatlı
                'description' => 'Tatlı baklava, ev yapımı.',
                'img' => null,
                'price' => 30.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4, // İçecek
                'description' => 'Soğuk ayran içecek.',
                'img' => null,
                'price' => 10.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
