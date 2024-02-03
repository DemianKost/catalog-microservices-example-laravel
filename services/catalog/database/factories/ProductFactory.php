<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
final class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'status' => ProductStatus::IN_STOCK,
            'description' => $this->faker->paragraph(),
            'price' => $price = $this->faker->numberBetween(
                int1: 1_000,
                int2: 10_000
            ),
            'cost' => $cost = round(
                num: ($price / 100) * 65,
            ),
            'weight' => $this->faker->numberBetween(
                int1: 1_000,
                int2: 5_000,
            ),
            'stock' => $this->faker->numberBetween(
                int1: 10,
                int2: 50,
            ),
            'dimensions' => [
                'height' => $size = $this->faker->numberBetween(
                    int1: 100,
                    int2: 1_000,
                ) * $cost,
                'width' => $size,
                'depth' => $size,
            ],
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'warehouse_id' => Warehouse::factory(),
        ];
    }
}
