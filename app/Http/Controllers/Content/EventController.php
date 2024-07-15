<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Bde\Organization;
use App\Models\Event;
use App\Models\Post;
use App\Models\User;
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
        $start_at = $request->query('start_at');
        $organization_id = $request->query('organization_id');

        if ($per_page == null) {
            $per_page = 10;
        }
        if($start_at == null){
            $start_at = now();
        }

        $events = Event::orderBy('start_at',"asc")->where('uploaded_at', '<=', now())->where('start_at', '>=', $start_at)->orWhere(function ($query) {
            $query->where('start_at', '<=',  now()) // OU événements actuellement en cours
            ->where('end_at', '>=', now());
        });;

        if($organization_id){
            $events->Where('organization_id',$organization_id);
        }

        global $previous_date;

        $previous_date = now()->subDays(10);

        $events = $events->paginate($per_page);

        return response()->json([
            'data' => $events->map(function ($event){
                global $previous_date;

                $actual_date = $previous_date;
                $previous_date = $event->start_at;
                return [
                    'id' => $event->id,
                    'post_id' => $event->post_id,
                    'title' => $event->title,
                    'show_date' => $event->getShowDate($actual_date),
                    'date_format' => $event->getEventTiming(),
                    'start_at' => $event->start_at,
                    'end_at' => $event->end_at,
                    'location' => $event->location,
                    'color' => $event->getColor(),
                    'categories' => $event->category->map(function ($category) {
                        return [
                            'name' => $category->categoryType->name,
                        ];
                    }),
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at,
                    'author' => $event->organization ? [
                        'is_organization' => true,
                        'id' => $event->organization->id,
                        'name' => $event->organization->name,
                        'short_name' => $event->organization->short_name,
                        'user_name' => $event->organization->user_name,
                        'logo_url' => $event->organization->getLogoPath()
                    ] : [
                        'is_organization' => false,
                        'id' => $event->user->id,
                        'name' => $event->user->getFullName(),
                        'short_name' => null,
                        'user_name' => $event->user->user_name,
                        'logo_url' => $event->user->avatar->path
                    ],
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
                'date_format' => $event->getEventTiming(),
                'start_at' => $event->start_at,
                'end_at' => $event->end_at,
                'location' => $event->location,
                'color' => $event->getColor(),
                'author' => $event->organization ? [
                    'is_organization' => true,
                    'id' => $event->organization->id,
                    'name' => $event->organization->name,
                    'short_name' => $event->organization->short_name,
                    'user_name' => $event->organization->user_name,
                    'logo_url' => $event->organization->getLogoPath()
                ] : [
                    'is_organization' => false,
                    'id' => $event->user->id,
                    'name' => $event->user->getFullName(),
                    'short_name' => null,
                    'user_name' => $event->user->user_name,
                    'logo_url' => $event->user->avatar->path
                ],
            ]
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

    public function delete(Request $request,$id) : \Illuminate\Http\JsonResponse {
        $user = $request->user();

        $event = Event::where('id', $id)->first();

        if ($event == null) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $asso = $event->organization->id ?? null;

        if ($user->isInOrganization($asso) == false || $user->id != $event->user_id){
            return response()->json([
                'message' => 'You are not authorized to delete this post'
            ], 403);
        }

        $event->delete();

        if ($event->comments->isNotEmpty())
            $event->comments()->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
