<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                'required',
                'string'
            ],
            'organization_id' => [
                'integer'
            ],
            'category_id' => [
                'required',
                'integer'
            ],
            'start_at' => [
                'date'
            ],
            'end_at' => [
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


        // check if the user is in the organization
        if(!$request->user()->isInOrganization($request->organization_id)){
            return response()->json([
                'message' => 'You are not in the organization'
            ], 403);
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
        if($request->create_event == 1 && $request->create_post == null){
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

        return response()->json([
            'data' => [
                'organizations' => $user->organizations()->get()->map(function ($organization) {
                    return [
                        'id' => $organization->id,
                        'name' => $organization->name,
                        'role' => $organization->pivot->role
                    ];
                }),
                'categories' => Category::all()->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name
                    ];
                })
            ]
        ], 200);
    }
}
