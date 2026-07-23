<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Post
 * @subgroup Comments
 */
class PostCommentController extends Controller
{
    /**
     * New Comment
     * 
     * Create a new Comment for the specified Post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response status=201 { "comment": { "body": "test comment", "created_at": "2026-07-22T12:26:41.000000Z", "id": 274, "organization_id": null, "parent_comment_id": "271", "post_id": "1", "updated_at": "2026-07-22T12:26:41.000000Z", "user_id": 110 }, "message": "Commentaire créé avec succès ! " }
     * @response status=404 { "message": "Post not found" }
     * @response status=422 { "errors": { "parent_comment_id": [ "The selected parent comment id is invalid.", "The selected parent comment does not belong to the specified post." ] }, "message": "The given data was invalid." }
     */
    public function store(Request $request, $id)
    {

        $validation = Validator::make($request->all(), [
            // The content of the comment Example: This is a comment 
            'body' => 'required|string|min:3, max:4000000000',
            // If specified, the new comment will be marked as a reply to this one No-example
            'parent_comment_id' => [
                'nullable',
                'exists:post_comments,id',
                'int',
                function ($attribute, $value, $fail) use ($id) {
                    if ($value && PostComment::where('id', $value)->where('post_id', $id)->doesntExist()) {
                        $fail('The selected parent comment does not belong to the specified post.');
                    }
                },
            ],
            // No-example
            'organization_id' => 'nullable|exists:bde_bdd.'.env("BDE_DB_DATABASE").'.organizations,id',
        ]);

        $post = Post::find($id);

        if ($post == null) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        if ($validation->fails()) {
            return response()->json([
                'message' =>  'The given data was invalid.',
                'errors' => $validation->errors()
            ], 422);
        }

        // Create a new comment
        $comment = PostComment::create([
            'post_id' => $id,
            'user_id' => $request->user()->id,
            'organization_id' => $request->organization_id,
            'parent_comment_id' => $request->parent_comment_id,
            'body' => $request->body,
        ]);

        // Return a response
        return response()->json([
            'message' => 'Commentaire créé avec succès ! ',
            'comment' => $comment,
        ],201);
    }

    /**
     * Comment Index
     * 
     * Fetch a paginated Comment's list for the specified Post
     * 
     * @queryParam per_page int Number of elements per page. Example: 3
     * @queryParam parent_comment_id int The ID of the parent comment No-example
     * @queryParam page int Page number. Example: 2
     */
    public function index(Request $request,$id) : \Illuminate\Http\JsonResponse {

        $per_page = $request->query('per_page');

        $parent_comment_id = $request->query('parent_comment_id');

        if ($per_page == null) {
            $per_page = 3;
        }

        $totalcomments = PostComment::where('post_id',$id)->count();

        $user = $request->user();

        $comments = PostComment::orderByDesc('created_at')->where('post_id',$id)->where('parent_comment_id',$parent_comment_id)->paginate($per_page);

        return response()->json([
            'data' => $comments
            ->map(function ($comment) use ($user){
                return [
                    'id' => $comment->id,
                    'post_id' => $comment->post_id,
                    'user_id' => $comment->user_id,
                    'created_since' => $comment->duration,
                    'parent_comment_id' => $comment->parent_comment_id,
                    'body' => $comment->body,
                    'children_count'=> $comment->childrenscount(),
                    'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'),
                    'reaction_count' => $comment->reaction->count(),
                    'reaction' => $comment->userReactionsType(),
                    'author' => $comment->organization ? [
                        'user_is_author' => $user->isInOrganization($comment->organization->id),
                        'is_organization' => true,
                        'id' => $comment->organization->id,
                        'name' => $comment->organization->name,
                        'user_name' => $comment->organization->user_name,
                        'short_name' => $comment->organization->short_name,
                        'logo_url' => $comment->organization->getLogoPath()
                    ] : [
                        'user_is_author' => $comment->user_id == $user->id,
                        'is_organization' => false,
                        'id' => $comment->user->id,
                        'name' => $comment->user->getFullName(),
                        'user_name' => $comment->user->user_name,
                        'short_name' => null,
                        'logo_url' => $comment->user->getAvatarPath()
                    ],
                ];
            }),
            'meta' => [
                'total' => $totalcomments,
                'total_same_parent_id' => $comments->total(),
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

    /**
     * Update Comment
     * 
     * Update the specified Comment's text
     * 
     * @urlparam id integer required The ID of the comment.
     * 
     * @response status=200 {"message":"Comment updated successfully","data":{"id":255,"body":"Ceci est un commentaire !","user_id":1,"organization_id":null,"post_id":2,"parent_comment_id":null,"created_at":"2026-07-20T14:37:32.000000Z","updated_at":"2026-07-21T09:09:22.000000Z","deleted_at":null}}
     * @response status=403 {"message":"You are not authorized to update this comment"}
     * @response status=404 {"message":"Comment not found"}
     * @response status=422 {"message":"The given data was invalid.","errors":{"body":["The body field must be at least 3 characters."]}}
     */
    public function update(Request $request, $id)
    {

        $validation = Validator::make($request->all(), [
            // The content of the comment Example: This is an updated comment
            'body' => 'required|string|min:3, max:4000000000',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' =>  'The given data was invalid.',
                'errors' => $validation->errors()
            ], 422);
        }

        $comment = PostComment::find($id);

        if (! $comment)
        {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        if ($comment->user_id != $request->user()->id)
        {
            return response()->json([
                'message' => 'You are not authorized to update this comment'
            ], 403);
        }

        $comment->update(
            $validation->validated()
        );

        return response()->json([
            'message' => 'Comment updated successfully',
            'data' => $comment
        ], 200);
    }

    /**
     * Delete Comment
     * 
     * Remove the specified Comment from the database,
     * 
     * @urlparam id integer required The ID of the comment.
     * 
     * @response status=200 {"message":"Comment deleted successfully"}
     * @response status=403 {"message":"You are not authorized to delete this comment"}
     * @response status=404 {"message":"Comment not found"}
     */
    public function delete(Request $request, $id)
    {
        $comment = PostComment::find($id);

        if (! $comment)
        {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        $asso = $comment->organization_id ?? null;
        // si pas auteur et si pas dans l'orga (si il y en a une)
        if ($comment->user_id != $request->user()->id && (!$asso || !$request->user()->isInOrganization($asso)))
        {
            return response()->json([
                'message' => 'You are not authorized to delete this comment'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ], 200);
    }

}
