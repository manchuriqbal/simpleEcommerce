<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::truncate();
        Category::truncate();
        Product::truncate();
        Cart::truncate();
        Order::truncate();
        OrderItem::truncate();

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 

        User::factory()->create([
            'name' => 'Admin Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);
        User::factory(9)->create();
        Category::factory(10)->create();
        Product::factory(50)->create();
        Cart::factory(10)->create();
        Order::factory(5)->create();
        OrderItem::factory(20)->create();

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');


    }
}
