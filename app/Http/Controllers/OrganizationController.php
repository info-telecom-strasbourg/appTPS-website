<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bde\Organization;

use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;

class OrganizationController extends Controller
{
    public function index(){

        $associations = Organization::all()->where('association', '=', 1); // 1 = association

        if ($associations->isEmpty()) {
            $associations_tab = [];
        }else{
            $associations_tab = $associations->map(function ($asso) {
                return [
                    'id' => $asso->id,
                    'short_name' => $asso->short_name,
                    'name' => $asso->name,
                    'logo_url' => $asso->logo->path
                ];
            })->values();
        }


        $clubs = Organization::all()->where('association', '=', 0); // 0 = club

        if ($clubs->isEmpty()) {
            $clubs_tab = [];
        }else{
            $clubs_tab = $clubs->map(function ($club) {
                return [
                    'id' => $club->id,
                    'short_name' => $club->short_name,
                    'name' => $club->name,
                    'logo_url' => $club->logo->path
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
            'logo_url' => $organization->logo->path,
        ];

        $members_tab = $organization->users->map(function ($member) {
            return [
                'id' => $member->id,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'user_name' => $member->user_name,
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

        $meta = [
            'total' => $post->total(),
            'per_page' => $post->perPage(),
            'current_page' => $post->currentPage(),
            'last_page' => $post->lastPage(),
            'first_page_url' => $post->url(1)."&per_page=".$per_page,
            'last_page_url' => $post->url($post->lastPage())."&per_page=".$per_page,
            'next_page_url' => $post->nextPageUrl()."&per_page=".$per_page,
            'prev_page_url' => $post->previousPageUrl()."&per_page=".$per_page,
            'path' => $post->path(),
            'from' => $post->firstItem(),
            'to' => $post->lastItem(),
            'in_page' => $post->count()
        ];


        return response()->json(
            [
                'Asso/club' => $organization_tab,
                'members' => $members_tab,
                'posts' => [
                    'data' => $posts_tab,
                    'meta' => $meta
                    ]
            ]
        )->setEncodingOptions(JSON_PRETTY_PRINT);
    }

}
