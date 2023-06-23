<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Bde\Organization;
use App\Models\Event;
use App\Models\Category;

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

        if (random_int(0, 1) == 1) {
            $organization_id = Organization::inRandomOrder()->first()->id;
        }else{
            $organization_id = null;
        }

        if (random_int(0, 1) == 1) {
            $event_id = Event::inRandomOrder()->first()->id;
        }else{
            $event_id = null;
        }

        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->text(),
            'user_id' => User::inRandomOrder()->first()->id,
            'organization_id' => $organization_id,
            'event_id' => $event_id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'color' => $this->faker->hexColor(),
        ];
    }
}
