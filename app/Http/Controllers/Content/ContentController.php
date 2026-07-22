<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\CategoryType;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Event/Post Common
 */
class ContentController extends Controller
{
    /**
     * New Event/Post
     * 
     * Create a Post, an Event or both, and associate them together
     * 
     * At least one of 'create_event' or 'create_post' should be set to '1'
     */
    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            // Required for Event Example: my Event !
            'title' => [
                'string',
                'max:255',
                'min:3'
            ],
            // Required for Post Example: Hello this is my Post linked to an Event!
            'body' => [
                'string',
                'min:3'
            ],
            // Optional for Post/Event Example: 3
            'organization_id' => [
                'integer',
                'exists:bde_bdd.'.env("BDE_DB_DATABASE").'.organizations,id',
                'nullable'
            ],
            // Optional for Event Example: 2026-07-08T18:24:53
            'start_at' => [
                'date'
            ],
            // Optional for Event Example: 2026-07-08T19:24:53
            'end_at' => [
                'date'
            ],
            // Optional for Post/Event
            'uploaded_at' => [
                'date',
                'nullable'
            ],
            // Optional for Event Example: 7 golden street, Eldorado
            'location' => [
                'string',
                'max:255',
                'min:3'
            ],
            // Example: 1
            'create_event' => [
                'in:0,1'
            ],
            // Example: 1
            'create_post' => [
                'in:0,1'
            ],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        // check if the user is in the organization
        if(!$request->user()->isInOrganization($request->organization_id) && $request->organization_id != null){
            return response()->json([
                'message' => 'You are not in the organization'
            ], 403);
        }

        if ($request->uploaded_at == null || $request->uploaded_at <= now()) {
            $uploaded_at = now();
        }
        else{
            $uploaded_at = $request->uploaded_at;
        }

        // Create only a post
        if($request->create_event == null && $request->create_post == 1){

            if ($request->body == null) {
                return response()->json([
                    'message' => 'Validation failed',
                    'error' => [
                        'body' => 'The body field is required when creating a post'
                    ]
                ], 422);
            }

            $post = Post::create([
                'body' => $request->body,
                'organization_id' => $request->organization_id,
                'uploaded_at' => $uploaded_at,
                'user_id' => $request->user()->id,
            ]);

            return response()->json([
                'message' => 'Post created',
                'data' => $post
            ], 201);
        }

        // Create only an event
        if($request->create_event == 1 && $request->create_post == null && $request->organization_id != null){

            if ($request->start_at == null || $request->end_at == null) {
                return response()->json([
                    'message' => 'Validation failed',
                    'error' => 'vous devez spécifier une date de début et de fin pour l\'événement'
                ], 422);
            }

            if ($request->title == null) {
                return response()->json([
                    'message' => 'Validation failed',
                    'error' => 'vous devez spécifier un titre pour l\'événement'
                ], 422);
            }

            $event = Event::create([
                'title' => $request->title,
                'organization_id' => $request->organization_id,
                'user_id' => $request->user()->id,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'uploaded_at' => $uploaded_at,
                'location' => $request->location,
            ]);

            return response()->json([
                'message' => 'Event created',
                'data' => $event
            ], 201);
        }

        // Create both an post attached to an event
        if($request->create_event == 1 && $request->create_post == 1 && $request->organization_id != null){

            if ($request->start_at == null || $request->end_at == null) {
                return response()->json([
                    'message' => 'Validation failed',
                    'error' => 'vous devez spécifier une date de début et de fin pour l\'événement'
                ], 422);
            }

            $event = Event::create([
                'title' => $request->title,
                'organization_id' => $request->organization_id,
                'user_id' => $request->user()->id,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'uploaded_at' => $uploaded_at,
                'location' => $request->location,
            ]);

            $post = Post::create([
                'body' => $request->body,
                'organization_id' => $request->organization_id,
                'uploaded_at' => $uploaded_at,
                'user_id' => $request->user()->id,
                'event_id' => $event->id,
            ]);

            $event->post_id = $post->id;
            $event->save();

            return response()->json([
                'message' => 'Event and post created',
                'data' => [
                    'event' => $event,
                    'post' => $post
                ]
            ], 201);
        }

        if ($request->organization_id == null) {
            return response()->json([
                'message' => 'Vous devez etre dans une association pour créer un event'
            ], 422);
        }

        return response()->json([
            'message' => 'Nothing created'
        ], 400);
    }

}
