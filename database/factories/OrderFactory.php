<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_amount' => $this->faker->numberBetween(150,3000),
            'status' =>  $this->faker->randomElement(['pending', 'confirmed', 'shipped', 'completed', 'cancelled']),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
