<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CategoryStatus;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
final class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->catchPhrase(),
            'status' => CategoryStatus::ACTIVE,
            'description' => $this->faker->paragraph(),
        ];
    }
}
