<?php

namespace Database\Factories;

use App\Models\PostComment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bde\Organization;
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
        $existingComments = PostComment::where('post_id', $post->id)->get();

        $parentCommentId = null;
        if ($existingComments->isNotEmpty() && random_int(1, 4) !== 1) {
            $parentCommentId = $existingComments->random()->id;
        }

        return [
            'body' => $this->faker->text(),
            'post_id' => $post->id,
            'organization_id' => Organization::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'parent_comment_id' => $parentCommentId,
        ];
    }
}
