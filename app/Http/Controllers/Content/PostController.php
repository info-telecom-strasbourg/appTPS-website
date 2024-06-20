<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /*
    * Show all posts in the database
    *
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(Request $request) : \Illuminate\Http\JsonResponse {
        $per_page = $request->query('per_page');
        $category = $request->query('category_id');

        if ($per_page == null) {
            $per_page = 10;
        }

        if ($category != null) {
            $posts = Post::where('category_id', '=', $category)->orderByDesc('created_at')->paginate($per_page);
        } else {
            $posts = Post::orderByDesc('created_at')->paginate($per_page);
        }

        return response()->json([
            'data' => $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'body' => $post->body,
                    'date' => $post->created_at->format('Y-m-d H:i:s'),
                    'color' => $post->color,
                    'category' => $post->category->name,
                    'updated_at' => $post->updated_at,
                    'reaction_count' => $post->reactions->count(),
                    'medias' => $post->medias->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'url' => $media->media_url,
                            'type' => $media->mediaType ? $media->mediaType->name : null,
                        ];
                    }),
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
                        'logo_url' => $post->user->avatar->path
                    ],
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
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
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
                'body' => $post->body,
                'created_since' => $post->duration,
                'color' => $post->color,
                'category' => $post->category->name,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
                'reaction_count' => $post->reactions->count(),
                'medias' => $post->medias->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'url' => $media->media_url,
                        'type' => $media->media_type_id
                    ];
                }),
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
                    'logo_url' => $post->user->avatar->path
                ],
            ]
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

}
