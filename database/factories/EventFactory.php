<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\User;
use App\Models\Bde\Organization;

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

        $start_date = $this->faker->dateTimeBetween('-1 day', '+1 day');

        if (random_int(0, 1) == 1) {
            $organization_id = Organization::inRandomOrder()->first()->id;
        }else{
            $organization_id = null;
        }

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'start_at' => $start_date,
            'end_at' => $this->faker->dateTimeBetween($start_date, $start_date->format('Y-m-d H:i:s').' +1 day'),
            'color' => $this->faker->hexColor(),
            'location' => $this->faker->address(),
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'organization_id' => $organization_id,
        ];
    }
}
