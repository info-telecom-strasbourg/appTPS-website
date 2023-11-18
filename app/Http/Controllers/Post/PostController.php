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

    /*
    * Create a new post
    *
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function store(Request $request) : \Illuminate\Http\JsonResponse {

        $validation = Validator::make($request->all(), [
            'title' => [
                'required',
                'min:3',
                'max:50'
            ],
            'body' => [
                'required',
                'min:3',
                'max:4000000000'
            ],
            'organization_id' => [
                'integer',
                'exists:organizations,id'
            ],
            'event_id' => [
                'integer',
                'exists:events,id'
            ],
            'color' => [
                'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i',
                'required'
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        return response()->json([
            'message' => 'Post created',
            'data' => Post::create([
                'title' => $request->title,
                'body' => $request->body,
                'organization_id' => $request->organization_id,
                'event_id' => $request->event_id,
                'user_id' => $request->user()->id,
                'color' => $request->color
            ])
        ], 201);
    }

    /*
    * Show all posts in the database
    *
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(Request $request) : \Illuminate\Http\JsonResponse {
        $per_page = $request->query('per_page');

        if ($per_page == null) {
            $per_page = 10;
        }

        $posts = Post::orderByDesc('created_at')->paginate($per_page);

        return response()->json([
            'data' => $posts
            ->map(function ($post) {
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
                    }) : null
                ];
            }),
            'meta' => [
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
            ]
        ], 200);
    }

    /*
    * Show a specific post
    *
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function show($id) : \Illuminate\Http\JsonResponse {
        $post = Post::where('id','=', $id)->first();

        if ($post == null) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'data' => [
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
                }) : null
            ]
        ], 200);
    }
}
