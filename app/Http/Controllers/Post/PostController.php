<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Model\Post;

class PostController extends Controller
{
    public function store(){
        $validation = Validator::make($request->all(), [
            'title' => 'required|max:50|min:3',
            'body' => 'required|min:3',
            'organization_id' => 'integer|exists:organizations,id',
            'event_id' => 'integer|exists:events,id',
            'category_id' => 'integer|exists:categories,id',
            'color' => 'string|max:7|min:7'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $user = $request->user();

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'organization_id' => $request->organization_id,
            'event_id' => $request->event_id,
            'category_id' => $request->category_id,
            'user_id' => $user->id,
            'color' => $request->color
        ]);

        return response()->json([
            'message' => 'Post created',
            'data' => $post
        ], 201);
    }

    public function index(Request $request){
        $per_page = $request->query('per_page');

        if ($per_page == null) {
            $per_page = 10;
        }

        $posts = Post::orderByDesc('created_at')->paginate($per_page);

        return response()->json([
            'data' => $posts
        ], 200);
    }
}
