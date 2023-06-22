<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bde\Organization;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
 
use App\Models\Event;

class EventController extends Controller
{
    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'max:10000',
            'start_at' => 'date',
            'end_at' => 'date',
            'summary' => 'max:255',
            'location' => 'max:255',
            'organization_id' => 'integer|exists:organizations,id',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $user = $request->user();

        $event = Event::create([
            'user_id' => $user->id,
            'organization_id' => $request->organization_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'summary' => $request->summary,
            'location' => $request->location,
        ]);

        return response()->json([
            'message' => 'Event created',
            'event' => $event
        ], 201);
    }



    public function index(Request $request){
        
        $per_page = $request->query('per_page');

        if ($per_page == null) {
            $per_page = 10;
        }

        $events = Event::orderByDesc('start_at')->paginate($per_page);

        return response()->json([
            'data' => $events->map(function ($event) {
                $user = [
                    'last_name' => $event->user->last_name,
                    'first_name' => $event->user->first_name,
                    'user_name' => $event->user->user_name,
                    'avatar_url' => $event->user->getAvatarPath()
                ];
        
                if ($event->organization_id != null){
        
                    $data = Organization::find($event->organization_id)->first();

                    $organization = [
                        'name' => $data->name,
                        'acronym' => $data->acronym,
                        'logo' => $data->logo
                    ];
                }else{
                    $organization = null;
                }

                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'start_at' => $event->start_at,
                    'end_at' => $event->end_at,
                    'summary' => $event->summary,
                    'location' => $event->location,
                    'organization' => $organization,
                    'user' => $user
                ];
            }),
            'meta' => [
                'total' => $events->total(),
                'per_page' => $events->perPage(),
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage(),
                'first_page_url' => $events->url(1)."&per_page=".$per_page,
                'last_page_url' => $events->url($events->lastPage())."&per_page=".$per_page,
                'next_page_url' => $events->nextPageUrl()."&per_page=".$per_page,
                'prev_page_url' => $events->previousPageUrl()."&per_page=".$per_page,
                'path' => $events->path(),
                'from' => $events->firstItem(),
                'to' => $events->lastItem()
            ]
        ], 200);
    }


    public function show(Request $request, $id){
        $event = Event::find($id);

        if ($event == null) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        $user = [
            'last_name' => $event->user->last_name,
            'first_name' => $event->user->first_name,
            'user_name' => $event->user->user_name,
            'avatar_url' => $event->user->getAvatarPath()
        ];

        if ($event->organization_id != null){

            $data = Organization::find($event->organization_id)->first();

            $organization = [
                'name' => $data->name,
                'acronym' => $data->acronym,
                'logo' => $data->logo
            ];
        }else{
            $organization = null;
        }

        return response()->json([
            'data' => [
                'title' => $event->title,
                'description' => $event->description,
                'start_at' => $event->start_at,
                'end_at' => $event->end_at,
                'summary' => $event->summary,
                'location' => $event->location,
                'organization' => $organization,
                'user' => $user
            ]
        ], 200);
    }
}
