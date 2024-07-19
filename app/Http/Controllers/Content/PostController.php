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
        $categoryIds = $request->input('category_id', []);
        $user_name = $request->query('user_name');
        $user_id = $request->query('user_id');
        $asso_id = $request->query('asso_id');
        $search = $request->query('search');

        if ($per_page == null) {
            $per_page = 10;
        }

        $user = User::where('user_name', $user_name)->first();
        $organization = Organization::where('user_name', $user_name)->first();
        $query = Post::where('uploaded_at', '<=', now());

        if ($user) {
            $query->Where('user_id', $user->id);
        }

        if ($organization) {
            $query->Where('organization_id', $organization->id);
        }

        if ($user_id) {
            $query->Where('user_id', $user_id);
        }

        if ($asso_id) {
            $query->Where('organization_id', $asso_id);
        }

        if ($categoryIds && !in_array(1,$categoryIds) && !in_array(null,$categoryIds)){
            $query->category($categoryIds);
        }

        if($search) {
            $query->filter($search);
        }

        $posts = $query->orderBy('uploaded_at', 'desc')->paginate($per_page);

        return response()->json([
            'data' => $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'event_id' => $post->event_id,
                    'body' => $post->body,
                    'uploaded_since' => $post->duration,
                    'uploaded_at' => $post->uploaded_at,
                    'color' => $post->getColor(),
                    'categories' => $post->category->map(function ($category) {
                        return [
                            'name' => $category->categoryType->name,
                        ];
                    }),
                    'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
                    'reaction_count' => $post->reaction->count(),
                    'reaction' => $post->userReactionsType(),
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
                        'logo_url' => $post->organization->getLogoPath() ? $post->organization->getLogoPath() : null
                    ] : [
                        'is_organization' => false,
                        'id' => $post->user->id,
                        'name' => $post->user->getFullName(),
                        'user_name' => $post->user->user_name,
                        'short_name' => null,
                        'logo_url' => $post->user->avatar ? $post->user->avatar->path : null
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

        if ($post == null && $post->uploaded_at <= now()) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $post->id,
                'event_id' => $post->event_id,
                'body' => $post->body,
                'uploaded_since' => $post->duration,
                'uploaded_at' => $post->uploaded_at,
                'color' => $post->getColor(),
                'categories' => $post->category->map(function ($category) {
                    return [
                        'name' => $category->categoryType->name,
                    ];
                }),
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
                'reaction_count' => $post->reaction->count(),
                'reaction' => $post->userReactionsType(),
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
                    'short_name' => $post->organization->short_name,
                    'user_name' => $post->organization->user_name,
                    'logo_url' => $post->organization->getLogoPath() ? $post->organization->getLogoPath() : null
                ] : [
                    'is_organization' => false,
                    'id' => $post->user->id,
                    'name' => $post->user->getFullName(),
                    'short_name' => null,
                    'user_name' => $post->user->user_name,
                    'logo_url' => $post->user->avatar ? $post->user->avatar->path : null
                ],
            ]
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

    public function delete(Request $request,$id) : \Illuminate\Http\JsonResponse {
        $user = $request->user();

        $post = Post::where('id', $id)->first();

        $asso = $post->organization->id ?? null;

        if ($post == null) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        if ($asso) {
            if ($user->isInOrganization($asso) == false){
                return response()->json([
                    'message' => 'You are not authorized to delete this post'
                ], 403);
            }
        }
        else {
            if ($user->id != $post->user_id) {
                return response()->json([
                    'message' => 'You are not authorized to delete this post'
                ], 403);
            }
        }

        $post->delete();

        if ($post->comments->isNotEmpty())
            $post->comments()->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ], 200);
    }

    public function update(Request $request, $id) : \Illuminate\Http\JsonResponse {
        $validated = $request->validate([
            'body' => 'required|string',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id'
        ]);

        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $user = $request->user();
        $asso = $post->organization_id ?? null;

        if ($asso && !$user->isInOrganization($asso)) {
            return response()->json([
                'message' => 'You are not authorized to update this post'
            ], 403);
        } elseif (!$asso && $user->id != $post->user_id) {
            return response()->json([
                'message' => 'You are not authorized to update this post'
            ], 403);
        }

        $post->update($validated);

        return response()->json([
            'message' => 'Post updated successfully',
            'data' => $post
        ], 200);
    }

}
