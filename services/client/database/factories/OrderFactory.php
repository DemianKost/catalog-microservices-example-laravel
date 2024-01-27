<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
final class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => OrderStatus::DRAFT,
            'weight' => $this->faker->numberBetween(
                int1: 100,
                int2: 10_000,
            ),
            'shipping' => [
                'company' => $this->faker->company(),
                'address' => $this->faker->address(),
            ],
            'billing' => [
                'company' => $this->faker->company(),
                'address' => $this->faker->address(),
            ],
            'client_id' => Client::factory(),
        ];
    }
}
