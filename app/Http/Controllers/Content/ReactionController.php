<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Reaction;
use App\Models\ReactionType;
use Illuminate\Http\Request;
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
            'user_id' => 'required|exists:users,id',
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

        if ($request->post_id != null) {
            $reaction = Reaction::create([
                'user_id' => $request->user_id,
                'post_id' => $request->post_id,
                'reaction_type_id' => $request->reaction_type_id,
            ]);
        } else {
            $reaction = Reaction::create([
                'user_id' => $request->user_id,
                'post_comment_id' => $request->post_comment_id,
                'reaction_type_id' => $request->reaction_type_id,
            ]);
        }

        return response()->json([
            'message' => 'Réaction créée avec succès !',
            'reaction' => $reaction,
        ]);
    }

    public function index($id) : \Illuminate\Http\JsonResponse {

        $reactions = Reaction::where('post_id',$id)->join('reaction_types','reactions.reaction_type_id','=','reaction_types.id')->select('reaction_types.name',ReactionType::raw('count(*) as total'))->get();

        if ($reactions == 0) {
            return response()->json([
                'message' => 'Pas de réactions trouvées.'
            ], 404);
        }

        return response()->json([
            'data' => $reactions
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

}
