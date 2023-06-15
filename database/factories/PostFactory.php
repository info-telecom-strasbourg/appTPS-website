<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'organization_id' => 1,
            'event_id' => 1,
            'title' => $this->faker->sentence(),
            'excerpt' => $this->faker->paragraph(),
            'body' => $this->faker->paragraph(),
            'image_url' => $this->faker->imageUrl()
        ];
    }
}
