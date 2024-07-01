<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Bde\Organization;
use App\Models\Post;
use App\Models\Media;
use App\Models\User;
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
        $category_id = $request->query('category_id');
        $user_name = $request->query('user_name');
        $user_id = $request->query('user_id');
        $asso_id = $request->query('asso_id');

        if ($per_page == null) {
            $per_page = 10;
        }

        $user = User::where('user_name', $user_name)->first();
        $organization = Organization::where('user_name', $user_name)->first();

        $query = Post::query();

        if ($user) {
            $query->orWhere('user_id', $user->id);
        }

        if ($organization) {
            $query->orWhere('organization_id', $organization->id);
        }

        if ($user_id) {
            $query->orWhere('user_id', $user_id);
        }

        if ($asso_id) {
            $query->orWhere('organization_id', $asso_id);
        }

        if ($category_id && $category_id != 1) {
            $query->where('category_id', $category_id);
        }

        $posts = $query->paginate($per_page);

        return response()->json([
            'data' => $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'body' => $post->body,
                    'uploaded_since' => $post->duration,
                    'uploaded_at' => $post->uploaded_at,
                    'color' => $post->color,
                    'category' => $post->category->name,
                    'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
                    'reaction_count' => $post->reaction->count(),
                    'comment_count' => $post->comments->count(),
                    'medias' => $post->media->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'url' => $media->media_url,
                            'type' => $media->mediaType->type,
                        ];
                    }),
                    'author' => $post->organization ? [
                        'is_organization' => true,
                        'id' => $post->organization->id,
                        'name' => $post->organization->name,
                        'user_name' => $post->organization->user_name,
                        'short_name' => $post->organization->short_name,
                        'logo_url' => $post->organization->getLogoPath()
                    ] : [
                        'is_organization' => false,
                        'id' => $post->user->id,
                        'name' => $post->user->getFullName(),
                        'user_name' => $post->user->user_name,
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
                'uploaded_since' => $post->duration,
                'uploaded_at' => $post->uploaded_at,
                'color' => $post->color,
                'category' => $post->category->name,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
                'reaction_count' => $post->reaction->count(),
                'medias' => $post->media->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'url' => $media->media_url,
                        'type' => $media->mediaType->type,
                    ];
                }),
                'author' => $post->organization ? [
                    'is_organization' => true,
                    'id' => $post->organization->id,
                    'name' => $post->organization->name,
                    'short_name' => $post->organization->short_name,
                    'user_name' => $post->organization->user_name,
                    'logo_url' => $post->organization->getLogoPath()
                ] : [
                    'is_organization' => false,
                    'id' => $post->user->id,
                    'name' => $post->user->getFullName(),
                    'short_name' => null,
                    'user_name' => $post->user->user_name,
                    'logo_url' => $post->user->avatar->path
                ],
            ]
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

}
