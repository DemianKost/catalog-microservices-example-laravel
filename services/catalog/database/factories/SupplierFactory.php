<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
final class SupplierFactory extends Factory
{
    protected $model = Supplier::class;
    
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'website' => $this->faker->url(),
            'email' => $this->faker->email(),
            'reference' => $this->faker->imei(),
        ];
    }
}
