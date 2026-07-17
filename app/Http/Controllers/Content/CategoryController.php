<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Event/Post Common
 * @subgroup Category
 */
class CategoryController extends Controller
{
    /**
     * Define Post/Event's Categories.
     * 
     * Create an association between categories and an Event/Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : \Illuminate\Http\JsonResponse {
        // Validation des données reçues
        $validation = Validator::make($request->all(),[
            // Example: 1
            'post_id' => 'nullable|exists:posts,id',
            'event_id' => 'nullable|exists:events,id',
            'category_ids' => 'required|array',
            // Example: 1
            'category_ids.*' => 'exists:category_types,id'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        if ($request->post_id == null && $request->event_id == null) {
            return response()->json([
                'message' => 'Veuillez fournir un post_id ou un event_id.'
            ], 422);
        }

        $post_id = $request->post_id;
        $event_id = $request->event_id;

        $categories = array_map(
            function ($category) use ($post_id,$event_id) {
                return
                    Category::create([
                        'post_id' => $post_id,
                        'event_id' => $event_id,
                        'category_type_id' => $category
                    ]);
            },
            $request->category_ids,
        );

        return response()->json([
            'message' => 'Catégories associées avec succès au post.',
            'data' => $categories
        ], 201);
    }
}
