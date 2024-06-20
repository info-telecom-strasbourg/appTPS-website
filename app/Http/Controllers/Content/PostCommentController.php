<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string|min:3, max:4000000000',
            'parent_comment_id' => 'nullable|exists:post_comments,id',
            'organization_id' => 'nullable|exists:bde_bdd.bdedatapsbs.organizations,id',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' =>  'The given data was invalid.',
                'errors' => $validation->errors()
            ], 422);
        }

        // Create a new comment
        $comment = PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => $request->user()->id,
            'organization_id' => $request->organization_id,
            'parent_comment_id' => $request->parent_comment_id,
            'body' => $request->body,
        ]);

        // Return a response
        return response()->json([
            'message' => 'Commentaire créé avec succès ! ',
            'comment' => $comment,
        ]);
    }

    public function index(Request $request,$id) : \Illuminate\Http\JsonResponse {

        $per_page = $request->query('per_page');

        $parent_id = $request->query('parent_id');

        if ($per_page == null) {
            $per_page = 3;
        }

        $totalcomments = PostComment::where('post_id',$id)->count();

        $comments = PostComment::orderByDesc('created_at')->where('post_id',$id)->where('parent_comment_id',$parent_id)->paginate($per_page);

        if ($comments->isEmpty()) {
            return response()->json([
                'message' => 'Pas de commentaires'
            ], 404);
        }

        return response()->json([
            'data' => $comments
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'post_id' => $comment->post_id,
                    'user_id' => $comment->user_id,
                    'created_since' => $comment->duration,
                    'parent_comment_id' => $comment->parent_comment_id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'),
                    'author' => $comment->organization ? [
                        'is_organization' => true,
                        'id' => $comment->organization->id,
                        'name' => $comment->organization->name,
                        'short_name' => $comment->organization->short_name,
                        'logo_url' => $comment->organization->getLogoPath()
                    ] : [
                        'is_organization' => false,
                        'id' => $comment->user->id,
                        'name' => $comment->user->getFullName(),
                        'short_name' => null,
                        'logo_url' => $comment->user->avatar->path
                    ],
                ];
            }),
            'meta' => [
                'total' => $totalcomments,
                'nb_total_voisins' => $comments->total(),
                'per_page' => $comments->perPage(),
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'first_page_url' => $comments->url(1)."&per_page=".$per_page,
                'last_page_url' => $comments->url($comments->lastPage())."&per_page=".$per_page,
                'next_page_url' => $comments->nextPageUrl()."&per_page=".$per_page,
                'prev_page_url' => $comments->previousPageUrl()."&per_page=".$per_page,
                'path' => $comments->path(),
                'from' => $comments->firstItem(),
                'to' => $comments->lastItem(),
                'in_page' => $comments->count()
            ]
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
