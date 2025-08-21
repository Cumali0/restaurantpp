<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role_id' => 1,
                'name' => 'Admin',
                'surname' => 'User',
                'email' => 'admin@restaurant.com',
                'phone' => '5550000001',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 2,
                'name' => 'John',
                'surname' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '5550000002',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
