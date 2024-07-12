<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CategoryType;
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

        $start_date = $this->faker->dateTimeBetween('-1 day', '+14 day');

        $fake_date = $this->faker->dateTimeBetween('-30 day', '+0 day');

        return [
            'title' => $this->faker->sentence(),
            'start_at' => $start_date,
            'end_at' => $this->faker->dateTimeBetween($start_date, $start_date->format('Y-m-d H:i:s').' +2 day'),
            'location' => $this->faker->address(),
            'uploaded_at' => $fake_date,
            'user_id' => User::inRandomOrder()->first()->id,
            'organization_id' => Organization::inRandomOrder()->first()->id,
            'created_at' => $fake_date,
        ];
    }
}
