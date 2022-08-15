<?php

namespace Database\Factories;

use App\Models\OrderStatuses;
use App\Models\Payments;
use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'user_id' => User::inRandomOrder()->first()->id,
            'order_status_id' => OrderStatuses::inRandomOrder()->first()->id,
            'payment_id' => Payments::inRandomOrder()->first()->id,
            'uuid' => Str::uuid(),
            'products' =>  json_encode([array('product' => Products::inRandomOrder()->first()->uuid, 'quantity' => rand(1, 4)), array('product' => Products::inRandomOrder()->first()->uuid, 'quantity' => rand(1, 4)), array('product' => Products::inRandomOrder()->first()->uuid, 'quantity' => rand(1, 4))]),
            'address' =>  json_encode(['billing' => fake()->address(), 'shipping' => fake()->address()]),
            'delivery_fee' => fake()->randomFloat(2, 50, 500),
            'amount' => fake()->randomFloat(2, 80, 1000),
            'shipped_at' => fake()->dateTime('now'),
        ];
    }
}
