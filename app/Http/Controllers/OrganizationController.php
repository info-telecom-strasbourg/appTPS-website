<?php

namespace App\Http\Controllers;

use App\Models\Bde\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(){

        $organization = Organization::filter(request(['search']))->get();

        $associations = $organization->where('association', '=', 1); // 1 = association

        if ($associations->isEmpty()) {
            $associations_tab = [];
        }else{
            $associations_tab = $associations->map(function ($asso) {
                return [
                    'id' => $asso->id,
                    'short_name' => $asso->short_name,
                    'name' => $asso->name,
                    'logo_url' => $asso->getLogoPath()
                ];
            })->values();
        }


        $clubs = $organization->where('association', '=', 0); // 0 = club

        if ($clubs->isEmpty()) {
            $clubs_tab = [];
        }else{
            $clubs_tab = $clubs->map(function ($club) {
                return [
                    'id' => $club->id,
                    'short_name' => $club->short_name,
                    'name' => $club->name,
                    'logo_url' => $club->getLogoPath()
                ];
            })->values();
        }


        return response()->json(['data' => [
            'associations' => $associations_tab,
            'clubs' => $clubs_tab,
        ]])->setEncodingOptions(JSON_PRETTY_PRINT);
    }

    public function show($id){
        $per_page = request()->query('per_page');

        $organization = Organization::all()->where('id', '=', $id)->first();

        if ($organization == null) {
            return response()->json(['data' => []])->setEncodingOptions(JSON_PRETTY_PRINT);
        }

        $organization_tab = [
            'short_name' => $organization->short_name,
            'name' => $organization->name,
            'description' => $organization->description,
            'website_link' => $organization->website_link,
            'facebook_link' => $organization->facebook_link,
            'twitter_link' => $organization->twitter_link,
            'instagram_link' => $organization->instagram_link,
            'discord_link' => $organization->discord_link,
            'email' => $organization->email,
            'logo_url' => $organization->getLogoPath(),
        ];

        $members_tab = $organization->users->map(function ($member) {
            return [
                'id' => $member->id,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'avatar_url' => $member->avatar->path,
            ];
        })->values();

        $posts_tab = $organization->posts->map(function ($post) {
            return [
                'id' => $post->id,
                'body' => $post->body,
                'created_since' => $post->duration,
                'color' => $post->color,
                'category' => $post->category->name,
                'reaction_count' => $post->reaction->count(),
                'comment_count' => $post->comments->count(),
                'medias' => $post->media->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'url' => $media->media_url,
                        'type' => $media->mediaType->type,
                    ];
                }),
                'author' => $post->organization ? [
                    'is_organization' => true,
                    'id' => $post->organization->id,
                    'name' => $post->organization->name,
                    'short_name' => $post->organization->short_name,
                    'logo_url' => $post->organization->getLogoPath()
                ] : [
                    'is_organization' => false,
                    'id' => $post->user->id,
                    'name' => $post->user->getFullName(),
                    'short_name' => null,
                    'logo_url' => $post->user->avatar->path
                ],
            ];
        })->values();

        $posts = $organization->posts()->orderByDesc('created_at')->paginate($per_page);

        $meta = [
            'total' => $posts->total(),
            'per_page' => $posts->perPage(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'first_page_url' => $posts->url(1)."&per_page=".$per_page,
            'last_page_url' => $posts->url($posts->lastPage())."&per_page=".$per_page,
            'next_page_url' => $posts->nextPageUrl()."&per_page=".$per_page,
            'prev_page_url' => $posts->previousPageUrl()."&per_page=".$per_page,
            'path' => $posts->path(),
            'from' => $posts->firstItem(),
            'to' => $posts->lastItem(),
            'in_page' => $posts->count()
        ];


        return response()->json(
            [
                'organization' => $organization_tab,
                'members' => $members_tab,
                'posts' => [
                    'data' => $posts_tab,
                    'meta' => $meta
                    ]
            ]
        )->setEncodingOptions(JSON_PRETTY_PRINT);
    }


}
