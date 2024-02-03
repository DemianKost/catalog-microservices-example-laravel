<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\WarehouseStatus;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
final class WarehouseFactory extends Factory
{
    protected $model = Warehouse::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city() . ' Something',
            'manager' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'status' => WarehouseStatus::ONLINE,
            'address' => explode(',', $this->faker->address() ),
        ];
    }
}
