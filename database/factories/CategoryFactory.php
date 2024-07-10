<?php

namespace Database\Factories;

use App\Models\CategoryType;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoryType>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $allPostsAssigned = false;
        static $postIdsAssigned = [];

        $post_id = null;
        $event_id = null;

        if (!$allPostsAssigned) {
            $post_id = Post::whereNotIn('id', array_keys($postIdsAssigned))->inRandomOrder()->first()->id;
            $postIdsAssigned[$post_id] = true;

            if (count($postIdsAssigned) >= Post::count()) {
                $allPostsAssigned = true;
            }
        } else {
            if (random_int(0, 1) == 0) {
                $post_id = Post::inRandomOrder()->first()->id;
            } else {
                $event_id = Event::inRandomOrder()->first()->id;
            }
        }

        return [
            'post_id' => $post_id,
            'event_id' => $event_id,
            'category_type_id' => CategoryType::inRandomOrder()->where('id','!=',1)->first()->id,
        ];
    }
}
