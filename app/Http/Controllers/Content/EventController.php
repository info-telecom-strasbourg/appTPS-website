<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

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


        if(isset($request->start_at)){
            $events = Event::orderBy('start_at',"asc")->Where('start_at', '>=', $request->start_at)->paginate($per_page);
        } else {
            $events = Event::orderBy('start_at',"asc")->paginate($per_page);
        }


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
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at,
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
                        'logo_url' => $event->user->avatar->path
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
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
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
                    'logo_url' => $event->user->avatar->path
                ]
            ]
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
