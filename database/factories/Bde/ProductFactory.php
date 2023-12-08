<?php

namespace Database\Factories\Bde;

use App\Models\Bde\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'title' => fake()->unique()->slug(),
            'price' => fake()->randomFloat(2, 0, 3),
            'product_type_id' => ProductType::inRandomOrder()->first()->id,
            'color' => fake()->hexColor(),
        ];
    }
}
