<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Reaction;
use App\Models\ReactionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : \Illuminate\Http\JsonResponse {

        $validation = Validator::make($request->all(), [
            'post_id' => 'nullable|exists:posts,id',
            'post_comment_id' => 'nullable|exists:post_comments,id',
            'reaction_type_id' => 'required|exists:reaction_types,id',
        ]);

        if ($validation->fails() || ($request->post_id == null && $request->post_comment_id == null) || ($request->post_id != null && $request->post_comment_id != null)) {
            return response()->json([
                'message' =>  'The given data was invalid.',
                'errors' => $validation->errors()
            ], 422);
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
                ], 201);
            } else {
                // Si aucune réaction existante ne correspond à l'ID de l'utilisateur et à l'ID du post, créer une nouvelle réaction
                if ($request->post_id != null) {
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
                ],201);
            }
        }
    }
    public function index($id) : \Illuminate\Http\JsonResponse {

        // Récupérer toutes les réactions avec leurs types et utilisateurs associés
        $reactions = Reaction::with('reactionType','user')
            ->where('post_id', $id)
            ->get();

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
                        'avatar' => $reaction->user->avatar->path,
                    ];
                })
            ];
        });

        return response()->json([
            'data' => $data->values(),
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

}
