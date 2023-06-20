<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
            'user_id' => User::InRandomOrder()->first()->id,
            'organization_id' => DB::connection('bde_bdd')->table('organizations')->inRandomOrder()->first()->id,
            'start_date' => $this->faker->dateTimeBetween('now', '+1 years'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 years'),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'summary' => $this->faker->paragraph(),
            'location' => $this->faker->address()
        ];
    }
}
