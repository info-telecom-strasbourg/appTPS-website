<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostComment>
 */
class PostCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $post = Post::inRandomOrder()->first();
        $postComments = $post->comments;

        if (!$postComments->isEmpty()){
            $comment_id = $postComments->pluck('id')->random();
            return [
                'body' => $this->faker->text(),
                'post_id' => $post->id,
                'user_id' => User::inRandomOrder()->first()->id,
                'parent_comment_id' => $comment_id
            ];
        }else{
            return [
                'body' => $this->faker->text(),
                'post_id' => $post->id,
                'user_id' => User::inRandomOrder()->first()->id,
            ];
        }
    }
}
