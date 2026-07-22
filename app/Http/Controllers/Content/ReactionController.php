<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Reaction;
use App\Models\ReactionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @group Post
 * @subgroup Reaction
 */
class ReactionController extends Controller
{
    /**
     * New Reaction
     * 
     * Handle a new Reaction request for the specified Post or Comment.
     * Can lead to either a creation, a modification or a deletion of a reaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @response status=422 {"message":"The given data was invalid.","errors":{"post_id":["The post id field prohibits post comment id from being present."],"post_comment_id":["The post comment id field prohibits post id from being present."]}}
     */
    public function store(Request $request ) : \Illuminate\Http\JsonResponse {

        $validation = Validator::make($request->all(), [
            // Example: 1
            'post_id' => ['nullable','integer','required_without:post_comment_id','prohibits:post_comment_id','exists:posts,id'],
            // No-example
            'post_comment_id' => ['nullable','integer','required_without:post_id','prohibits:post_id','exists:post_comments,id'],
            // Example: 2
            'reaction_type_id' => ['required','integer','exists:reaction_types,id'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' =>  'The given data was invalid.',
                'errors' => $validation->errors()
            ], 422);
        }

        if ($request->post_comment_id) {
            $comment = PostComment::where('id', $request->post_comment_id)->first();
        }
        else {
            $comment = null;
            $post = Post::where('id', $request->post_id)->first();
        }


        // Vérifier si l'utilisateur a déjà réagi au post avec le même type de réaction
        $existingReaction = Reaction::where('user_id', $request->user()->id)
            ->where('post_id', $request->post_id)
            ->Where('post_comment_id', $request->post_comment_id)
            ->where('reaction_type_id', $request->reaction_type_id)
            ->first();

        if ($existingReaction) {
            // Si une telle réaction existe, la supprimer
            $existingReaction->delete();

            return response()->json([
                'message' => 'Réaction suprimée avec succès !' ,
                'data' => $comment ? [
                    'is_comment' => true,
                    'reaction' => $comment->userReactionsType(),
                    'reaction_count' => $comment->reaction->count()
                ] : [
                    'is_comment' => false,
                    'reaction' => $post->userReactionsType(),
                    'reaction_count' => $post->reaction->count()
                ]
            ], 205);
        } else {
            // Sinon, mettre à jour la réaction existante avec le nouveau type de réaction
            $existingReaction = Reaction::where('user_id',  $request->user()->id)
                ->where('post_id', $request->post_id)
                ->Where('post_comment_id', $request->post_comment_id)
                ->first();

            if ($existingReaction) {
                $existingReaction->reaction_type_id = $request->reaction_type_id;
                $existingReaction->save();

                return response()->json([
                    'message' => 'La réaction a été mise à jour.',
                    'reaction' => $existingReaction,
                    'data' => $comment ? [
                        'is_comment' => true,
                        'reaction' => $comment->userReactionsType(),
                        'reaction_count' => $comment->reaction->count()
                    ] : [
                        'is_comment' => false,
                        'reaction' => $post->userReactionsType(),
                        'reaction_count' => $post->reaction->count()
                    ]
                ], 200);
            } else {
                // Si aucune réaction existante ne correspond à l'ID de l'utilisateur et à l'ID du post, créer une nouvelle réaction
                if ($comment == null) {
                    $reaction = Reaction::create([
                        'user_id' =>  $request->user()->id,
                        'post_id' => $request->post_id,
                        'reaction_type_id' => $request->reaction_type_id,
                    ]);
                } else {
                    $reaction = Reaction::create([
                        'user_id' =>  $request->user()->id,
                        'post_comment_id' => $request->post_comment_id,
                        'reaction_type_id' => $request->reaction_type_id,
                    ]);
                }

                return response()->json([
                    'message' => 'Réaction créée avec succès !',
                    'reaction' => $reaction,
                    'data' => $comment ? [
                        'is_comment' => true,
                        'reaction' => $comment->userReactionsType(),
                        'reaction_count' => $comment->reaction->count()
                    ] : [
                        'is_comment' => false,
                        'reaction' => $post->userReactionsType(),
                        'reaction_count' => $post->reaction->count()
                    ]
                ],201);
            }
        }
    }

    /**
     * Reaction Index
     * 
     * Fetch a summary list of all reactions to a Post or a Comment
     * 
     * @response status=200 {"data": [{"reaction_type_id": 2,"reaction_type": "like","icon": "\ud83d\udc4d","total": 1,"users": [{"id": 1,"name": "Fabien pr\u00e9galdini","avatar": null }]}]}
     * @response status=422 {"message":"The given data was invalid.","errors":{"post_id":["The post id field prohibits post comment id from being present."],"post_comment_id":["The post comment id field prohibits post id from being present."]}}
     */
    public function index(Request $request) : \Illuminate\Http\JsonResponse {

        $validation = Validator::make($request->all(), [
            // Example: 1
            'post_id' => ['nullable','integer','required_without:post_comment_id','prohibits:post_comment_id','exists:posts,id'],
            // No-example
            'post_comment_id' => ['nullable','integer','required_without:post_id','prohibits:post_id','exists:post_comments,id'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' =>  'The given data was invalid.',
                'errors' => $validation->errors()
            ], 422);
        }

        // Récupérer toutes les réactions avec leurs types et utilisateurs associés
        $query = Reaction::with('reactionType', 'user');
        if ($request->post_id) {
            $query->where('post_id', $request->post_id);
        } else {
            $query->where('post_comment_id', $request->post_comment_id);
        }
        $reactions = $query->get();

        // Regrouper les réactions par type de réaction
        $groupedReactions = $reactions->groupBy('reaction_type_id');

        // Transformer les données pour chaque type de réaction
        $data = $groupedReactions->map(function ($reactions, $reactionTypeId) {
            return [
                'reaction_type_id' => $reactionTypeId,
                'reaction_type' => $reactions->first()->reactionType->name,
                'icon' => $reactions->first()->reactionType->icon,
                'total' => $reactions->count(),
                'users' => $reactions->map(function ($reaction) {
                    return [
                        'id' => $reaction->user->id,
                        'name' => $reaction->user->getFullName(),
                        'avatar' => $reaction->user->getAvatarPath(),
                    ];
                })
            ];
        });

        return response()->json([
            'data' => $data->values(),
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

}
