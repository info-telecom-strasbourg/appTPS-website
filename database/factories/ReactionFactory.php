<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Post;    
use App\Models\ReactionType;
use App\Models\PostComment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reaction>
 */
class ReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        if (random_int(0, 1) == 0) {
            return [
                'user_id' => User::inRandomOrder()->first()->id,
                'reaction_type_id' => ReactionType::inRandomOrder()->first()->id,
                'post_id' => Post::inRandomOrder()->first()->id,    
            ];
        }else{
            return [
                'user_id' => User::inRandomOrder()->first()->id,
                'post_comment_id' => PostComment::inRandomOrder()->first()->id,
                'reaction_type_id' => ReactionType::inRandomOrder()->first()->id,
            ];
        }
    }
}
