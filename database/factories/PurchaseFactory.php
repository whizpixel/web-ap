<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Client;
use App\Models\Product;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'client_id' => Client::inRandomOrder()->value('id') ?? Client::factory(),
            'product_id' => Product::inRandomOrder()->value('id') ?? Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'purchased_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'notes' => $this->faker->boolean(25) ? $this->faker->sentence() : null,
        ];
    }
}
