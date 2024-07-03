<?php

namespace Database\Factories;

use App\Models\Reaction;
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
        $user = User::inRandomOrder()->first();
        $post = Post::inRandomOrder()->first();
        $reactionType = ReactionType::inRandomOrder()->first();
        $postcomment = PostComment::inRandomOrder()->first();

        // Vérifiez si une réaction de cet utilisateur pour ce post existe déjà
        $existingPostReaction = Reaction::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        // Vérifiez si une réaction de cet utilisateur pour ce commentaire de post existe déjà
        $existingCommentReaction = Reaction::where('user_id', $user->id)
            ->where('post_comment_id', $postcomment->id)
            ->first();

        // Si une réaction existe déjà, retournez un tableau vide
        if ($existingPostReaction || $existingCommentReaction) {
            return [];
        }
        elseif (random_int(0, 1) == 0) {
            return [
                'user_id' => $user->id,
                'reaction_type_id' => $reactionType->id,
                'post_id' => $post->id,
                'post_comment_id' => null,
            ];
        }else{
            return [
                'user_id' => $user->id,
                'reaction_type_id' => $reactionType->id,
                'post_id' => null,
                'post_comment_id' => $postcomment->id,
            ];
        }
    }
}
