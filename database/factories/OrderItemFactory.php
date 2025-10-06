<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(1,10),
            'price' => $this->faker->numberBetween(50,500),
            'product_id' =>Product::inRandomOrder()->first()->id,
            'order_id' => Order::inRandomOrder()->first()->id,
        ];
    }
}
