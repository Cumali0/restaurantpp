<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reservations')->insert([
            [
                'user_id' => 2, // John Doe
                'table_id' => 1, // Bahçe 1
                'name' => 'John',
                'surname' => 'Doe',
                'phone' => '5551234567',
                'email' => 'john@example.com',
                'datetime' => now()->addDays(1)->setHour(18)->setMinute(0),
                'end_datetime' => now()->addDays(1)->setHour(20)->setMinute(0),
                'people' => 2,
                'message' => 'Arkadaşlarla yemek.',
                'status' => 'pending',
                'preorder_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'table_id' => 3, // İç Salon 1
                'name' => 'John',
                'surname' => 'Doe',
                'phone' => '5551234567',
                'email' => 'john@example.com',
                'datetime' => now()->addDays(2)->setHour(19)->setMinute(0),
                'end_datetime' => now()->addDays(2)->setHour(21)->setMinute(0),
                'people' => 4,
                'message' => 'Aile yemeği.',
                'status' => 'reserved',
                'preorder_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
