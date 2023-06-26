<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;


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

        $datas = $posts->map(function ($post) {
            return [
                'title' => $post->title,
                'body' => $post->body,
                'date' => $post->created_at->format('Y-m-d H:i:s'),
                'color' => $post->color,
                'author' => $post->user ? [
                    'id' => $post->user->id,
                    'last_name' => $post->user->last_name,
                    'first_name' => $post->user->first_name,
                    'user_name' => $post->user->user_name,
                    'avatar_url' => $post->user->getAvatarPath()
                ] : null,
                'medias' => !$post->medias->isEmpty() ? $post->medias->map(function ($media) {
                    return [
                        'type' => $media->mediaType->type,
                        'url' => $media->media
                    ];
                }) : null,
                'organization' => $post->organization ? [
                    'id' => $post->organization->id,
                    'name' => $post->organization->name,
                    'short_name' => $post->organization->short_name,
                    'logo_url' => $post->organization->getLogoPath()
                ] : null,
                'reactions' => !$post->reactions->isEmpty() ? $post->reactions->map(function ($reaction) {
                    return [
                        'icon' => $reaction->reactionType->icon,
                        'user' => [
                            'id' => $reaction->user->id,
                            'last_name' => $reaction->user->last_name,
                            'first_name' => $reaction->user->first_name,
                            'user_name' => $reaction->user->user_name,
                            'avatar_url' => $reaction->user->getAvatarPath()
                        ]
                    ];
                }) : null,
            ];
        });

        return response()->json([
            'data' => $datas
        ], 200);
    }
}
