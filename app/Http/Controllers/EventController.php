<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bde\Organization;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Event;

class EventController extends Controller
{

    /**
     * Create a new event
     *
     * @param Request $request
     */
    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                'max:30',
                'min:3',
            ],
            'description' => [
                'string',
                'max:4000000',
                'min:3'
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
            'organization_id' => [
                'integer',
                'exists:organizations,id'
            ],
            'color' => [
                'string',
                'max:7',
                'min:7'
            ]
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
            'location' => $request->location,
            'color' => $request->color
        ]);

        return response()->json([
            'message' => 'Event created',
            'data' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start_at' => $event->start_at,
                'end_at' => $event->end_at,
                'location' => $event->location,
                'color' => $event->color,
                'author' => $event->organization ? [
                'is_organization' => true,
                'id' => $event->organization->id,
                'name' => $event->organization->name,
                'short_name' => $event->organization->short_name,
                'logo_url' => $event->organization->getLogoPath()
                ] : [
                'is_organization' => false,
                'id' => $event->user->id,
                'name' => $event->user->getFullName(),
                'short_name' => null,
                'logo_url' => $event->user->getAvatarPath()
                ]
            ]
        ], 201);
    }


    /**
     * Get all events in the calendar
     *
     * @param Request $request
     */
    public function index(Request $request){

        $per_page = $request->query('per_page');

        if ($per_page == null) {
            $per_page = 10;
        }

        $events = Event::orderByDesc('start_at')->paginate($per_page);

        return response()->json([
            'data' => $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'start_at' => $event->start_at,
                    'end_at' => $event->end_at,
                    'location' => $event->location,
                    'color' => $event->color,
                    'author' => $event->organization ? [
                        'is_organization' => true,
                        'id' => $event->organization->id,
                        'name' => $event->organization->name,
                        'short_name' => $event->organization->short_name,
                        'logo_url' => $event->organization->getLogoPath()
                    ] : [
                        'is_organization' => false,
                        'id' => $event->user->id,
                        'name' => $event->user->getFullName(),
                        'short_name' => null,
                        'logo_url' => $event->user->getAvatarPath()
                    ]
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

    /**
     * Get a specific event
     *
     * @param Request $request
     * @param int $id
     */
    public function show(Request $request, $id){
        $event = Event::find($id);

        if ($event == null) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start_at' => $event->start_at,
                'end_at' => $event->end_at,
                'location' => $event->location,
                'color' => $event->color,
                'author' => $event->organization ? [
                    'is_organization' => true,
                    'id' => $event->organization->id,
                    'name' => $event->organization->name,
                    'short_name' => $event->organization->short_name,
                    'logo_url' => $event->organization->getLogoPath()
                ] : [
                    'is_organization' => false,
                    'id' => $event->user->id,
                    'name' => $event->user->getFullName(),
                    'short_name' => null,
                    'logo_url' => $event->user->getAvatarPath()
                ]
            ]
        ], 200);
    }
}
