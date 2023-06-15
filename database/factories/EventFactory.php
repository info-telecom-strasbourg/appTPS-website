<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
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
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'summary' => $this->faker->paragraph(),
            'location' => $this->faker->address(),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 years'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 years')
        ];
    }
}
