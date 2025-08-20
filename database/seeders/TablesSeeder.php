<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tables')->insert([
            [
                'name' => 'Bahçe 1',
                'capacity' => 4,
                'floor' => 0,
                'preprice' => 50.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bahçe 2',
                'capacity' => 3,
                'floor' => 0,
                'preprice' => 50.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'İç Salon 1',
                'capacity' => 4,
                'floor' => 1,
                'preprice' => 70.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'İç Salon 2',
                'capacity' => 10,
                'floor' => 1,
                'preprice' => 150.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
