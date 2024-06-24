<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\ReactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReactionTypeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function index() : \Illuminate\Http\JsonResponse {

        $reaction_type = ReactionType::all();

        return response()->json([
            'data' => $reaction_type
                ->map(function ($reaction_type) {
                    return [
                        'id' => $reaction_type->id,
                        'name' => $reaction_type->name,
                    ];
                })
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

}
