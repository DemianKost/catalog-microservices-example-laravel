<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
final class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product' => $this->faker->uuid(),
            'quantity' => $this->faker->numberBetween(
                int1: 1,
                int2: 10
            ),
            'price' => $this->faker->numberBetween(
                int1: 100,
                int2: 10_000,
            ),
            'discount' => $this->faker->numberBetween(
                int1: 1,
                int2: 100
            ),
            'order_id' => Order::factory(),
        ];
    }
}
