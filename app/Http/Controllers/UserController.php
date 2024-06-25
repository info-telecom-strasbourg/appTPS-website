<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /* *
     * Update the user's different fields (except password)
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_name' => [
                'string',
                'min:3',
                'max:255',
                'unique:users,user_name'
            ],
            'phone' => [
                'string',
                'min:3',
                'max:10',
                'unique:users,phone'
            ],
            'sector' =>  [
                'integer',
                'exists:sectors,id'
            ],
            'promotion_year' => [
                'integer',
                'min:2000',
                'max:3000'
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $user = $request->user();

        $user->update($validation->validated());

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $this->getMe($request)->getData()->data
        ], 200);
    }


    /* *
     * Get the user's different fields
     *
     * @param Request $request
     */
    public function getMe(Request $request)
    {
        $per_page = request()->query('per_page');

        $user = $request->user();

        $posts = $user->posts()->orderByDesc('created_at')->paginate($per_page);

        return response()->json([
            'data' => [
                'id' => $user->id,
                'last_name' => $user->last_name,
                'first_name' => $user->first_name,
                'user_name' => $user->user_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'bde_id' => $user->bde_id,
                'avatar_url' => $user->avatar->path,
                'promotion_year' => $user->promotion_year,
        ],
            'posts' => $user->posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'body' => $post->body,
                    'created_since' => $post->duration,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                    'reaction_count' => $post->reaction->count(),
                    'comment_count' => $post->comments->count(),
                    'media' => $post->media->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'url' => $media->media_url,
                            'type' => $media->mediaType->type,
                        ];
                    }),
                    'author' => [
                        'id' => $post->author->id,
                        'first_name' => $post->author->first_name,
                        'last_name' => $post->author->last_name,
                        'avatar_url' => $post->author->avatar->path,
                    ]
                ];
            })->values(),
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

    public function show($id)
    {
        $per_page = request()->query('per_page');

        $user = User::find($id);

        $posts = $user->posts()->orderByDesc('created_at')->paginate($per_page);

        return response()->json([
            'data' => [
                'id' => $user->id,
                'last_name' => $user->last_name,
                'first_name' => $user->first_name,
                'user_name' => $user->user_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'bde_id' => $user->bde_id,
                'avatar_url' => $user->avatar->path,
                'promotion_year' => $user->promotion_year,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'email_verified_at' => $user->email_verified_at,
                'sector' => $user->sector ? $user->sector->short_name : null,
                'birth_date' => $user->birth_date,
                'unistra_id' => $user->unistra_id,
            ],
            'posts' => [
                'data' => $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'body' => $post->body,
                    'created_since' => $post->duration,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                    'reaction_count' => $post->reaction->count(),
                    'comment_count' => $post->comments->count(),
                    'media' => $post->media->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'url' => $media->media_url,
                            'type' => $media->mediaType->type,
                        ];
                    }),
                    'author' => [
                        'id' => $post->user->id,
                        'name' => $post->user->getFullName(),
                        'avatar_url' => $post->user->avatar->path,
                    ]
                ];})->values(),
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
            ]
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

    public function delete(Request $request){
        $request->user()->delete();

        return response()->json([
            'message' => 'The user has been deleted'
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
