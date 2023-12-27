<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Support\Facades\Http;

class ContentController extends Controller
{
    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                'max:30',
                'min:3',
            ],
            'body' => [
                'string',
                'max:4000000',
                'min:3'
            ],
            'color' => [
                'string'
            ],
            'organization_id' => [
                'integer',
                'exists:organizations,id'
            ],
            'start_at' => [
                'required',
                'date'
            ],
            'end_at' => [
                'required',
                'date'
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
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        // Create only a post
        if($request->create_event == 0 && $request->create_post == 1){
            $post = Post::create([
                'title' => $request->title,
                'body' => $request->body,
                'color' => $request->color,
                'organization_id' => $request->organization_id,
                'user_id' => $request->user()->id
            ]);

            return response()->json([
                'message' => 'Post created',
                'data' => $post
            ], 201);
        }

        // Create only an event
        if($request->create_event == 1 && $request->create_post == 0){
            $event = Event::create([
                'title' => $request->title,
                'body' => $request->body,
                'color' => $request->color,
                'organization_id' => $request->organization_id,
                'user_id' => $request->user()->id,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'location' => $request->location
            ]);

            return response()->json([
                'message' => 'Event created',
                'data' => $event
            ], 201);
        }

        // Create both an post attached to an event

        if($request->create_event == 1 && $request->create_post == 1){
            $event = Event::create([
                'title' => $request->title,
                'body' => $request->body,
                'color' => $request->color,
                'organization_id' => $request->organization_id,
                'user_id' => $request->user()->id,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'location' => $request->location
            ]);

            $post = Post::create([
                'title' => $request->title,
                'body' => $request->body,
                'color' => $request->color,
                'organization_id' => $request->organization_id,
                'user_id' => $request->user()->id,
                'event_id' => $event->id
            ]);

            return response()->json([
                'message' => 'Event and post created',
                'data' => [
                    'event' => $event,
                    'post' => $post
                ]
            ], 201);
        }

        return response()->json([
            'message' => 'Nothing created'
        ], 400);
    }

    public function create(){
        $user = request()->user();

        if($user->organizations() == null) {
            return response()->json([
                'data' => []
            ], 200);
        }

        return response()->json([
            'data' => $user->organizations()->get()->map(function ($organization) {
                return [
                    'id' => $organization->id,
                    'name' => $organization->name,
                    'role' => $organization->pivot->role
                ];
            })
        ], 200);
    }
}
