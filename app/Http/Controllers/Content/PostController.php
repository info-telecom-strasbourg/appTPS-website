<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
                    'logo_url' => $post->user->avatar->path
                ],
            ]
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
