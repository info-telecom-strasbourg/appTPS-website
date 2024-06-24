<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\MediaType;
use App\Models\Media;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'media_url' => $this->faker->imageUrl(),
            'post_id' => Post::inRandomOrder()->first()->id,
            'media_type_id' => MediaType::inRandomOrder()->first()->id,
        ];
    }
}
