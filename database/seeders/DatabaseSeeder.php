<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // Tüm tablolar için seedler
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            TablesSeeder::class,
            CategoriesSeeder::class,
            ProductsSeeder::class,
            PaymentMethodsSeeder::class,
            ReservationsSeeder::class,
            OrdersSeeder::class,
            OrderItemsSeeder::class,
            CartsSeeder::class,
            CartItemsSeeder::class,
            PaymentsSeeder::class,
        ]);
    }
}


