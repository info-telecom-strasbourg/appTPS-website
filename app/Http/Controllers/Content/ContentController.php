<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\CategoryType;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            'title' => [
                'string',
                'max:255',
                'min:3'
            ],
            'body' => [
                'required',
            ],
            'organization_id' => [
                'integer',
                'exists:bde_bdd.'.env("BDE_DB_DATABASE").'.organizations,id',
                'nullable'
            ],
            'start_at' => [
                'date'
            ],
            'end_at' => [
                'date'
            ],
            'uploaded_at' => [
                'date',
                'nullable'
            ],
            'location' => [
                'string',
                'max:255',
                'min:3'
            ],
            'create_event' => [
                'in:0,1'
            ],
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
                        'body' => 'The body field is not allowed when creating a post'
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

            $event = Event::create([
                'title' => $request->title,
                'body' => $request->body,
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
                'body' => $request->body,
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
