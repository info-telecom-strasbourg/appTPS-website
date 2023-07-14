<?php

namespace App\Http\Controllers\Post;

use App\Models\PostComment;
use App\Notifications\ActivateNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;


class PostController extends Controller
{
    public function store(Request $request){
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

        $user->notify(new ActivateNotification($post));

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
            $data = $post->reactions;

            return [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'date' => $post->created_at->format('Y-m-d H:i:s'),
                'color' => $post->color,
                'author' => $post->organization ? [
                    'is_organization' => true,
                    'id' => $post->organization->id,
                    'name' => $post->organization->name,
                    'short_name' => $post->organization->short_name,
                    'logo_url' => $post->organization->getLogoPath()
                ] : [
                    'is_organization' => false,
                    'id' => $post->user->id,
                    'name' => $post->user->getFullName(),
                    'short_name' => null,
                    'logo_url' => $post->user->getAvatarPath()
                ],
                'medias' => !$post->medias->isEmpty() ? $post->medias->map(function ($media) {
                    return [
                        'type' => $media->mediaType->type,
                        'url' => $media->media
                    ];
                }) : null,
                'reactions' => []
                /*'reactions' => !$post->reactions->isEmpty() ? $post->reactions->map(function ($reaction) {
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
                }) : null*/
            ];
        });

        $meta = [
            'total' => $posts->total(),
            'per_page' => $posts->perPage(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'first_page_url' => $posts->url(1)."&per_page=".$per_page,
            'last_page_url' => $posts->url($posts->lastPage())."&per_page=".$per_page,
            'next_page_url' => $posts->nextPageUrl()."&per_page=".$per_page,
            'prev_page_url' => $posts->previousPageUrl()."&per_page=".$per_page,
            'path' => $posts->path(),
            'from' => $posts->firstItem(),
            'to' => $posts->lastItem()
        ];

        return response()->json([
            'data' => $datas,
            'meta' => $meta
        ], 200);
    }

    public function show($id){
        $post = Post::where('id','=', $id)->first();

        return response()->json([
            'data' => [
                'title' => $post->title,
                'body' => $post->body,
                'date' => $post->date,
                'color' => $post->color,
                'author' => $post->organization ? [
                    'is_organization' => true,
                    'id' => $post->organization->id,
                    'name' => $post->organization->name,
                    'short_name' => $post->organization->short_name,
                    'logo_url' => $post->organization->getLogoPath()
                ] : [
                    'is_organization' => false,
                    'id' => $post->user->id,
                    'name' => $post->user->getFullName(),
                    'short_name' => null,
                    'logo_url' => $post->user->getAvatarPath()
                ],
                'medias' => !$post->medias->isEmpty() ? $post->medias->map(function ($media) {
                    return [
                        'type' => $media->mediaType->type,
                        'url' => $media->media
                    ];
                }) : null
            ]
        ], 200);
    }
}
