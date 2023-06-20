<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Event;

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
            'user_id' => User::InRandomOrder()->first()->id,
            'organization_id' => DB::connection('bde_bdd')->table('organizations')->inRandomOrder()->first()->id,
            'event_id' => Event::InRandomOrder()->first()->id,
            'title' => $this->faker->sentence(),
            'excerpt' => $this->faker->paragraph(),
            'body' => $this->faker->paragraph(),
            'image_url' => $this->faker->imageUrl(),
        ];
    }
}
