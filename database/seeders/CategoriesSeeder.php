<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Çorba',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ana Yemek',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tatlı',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'İçecek',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
