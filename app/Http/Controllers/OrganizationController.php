<?php

namespace App\Http\Controllers;

use App\Models\Bde\Organization;
use Illuminate\Http\Request;

/**
 * @group Organization
 */
class OrganizationController extends Controller
{
    /**
     * Organization index
     * 
     * Fetch a list of the differents organizations. Filter by name available
     */
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
                    'user_name' => $club->user_name,
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

    /**
     * Organization Infos
     * 
     * Fetch public data of the specified organization
     */
    public function show($id){
        $per_page = request()->query('per_page');

        $organization = Organization::all()->where('id', '=', $id)->first();

        if ($organization == null) {
            return response()->json(['data' => []])->setEncodingOptions(JSON_PRETTY_PRINT);
        }

        $organization_tab = [
            'id' => $organization->id,
            'short_name' => $organization->short_name,
            'name' => $organization->name,
            'user_name' => $organization->user_name,
            'description' => $organization->description,
            'website_link' => $organization->website_link,
            'facebook_link' => $organization->facebook_link,
            'twitter_link' => $organization->twitter_link,
            'instagram_link' => $organization->instagram_link,
            'discord_link' => $organization->discord_link,
            'email' => $organization->email,
            'logo_url' => $organization->getLogoPath(),
        ];

        $members_tab = $organization->members->map(function ($member) use ($id) {
            return [
                'id' => $member->user->id,
                'role' => $member->getRole($id),
                'first_name' => $member->user->first_name,
                'last_name' => $member->user->last_name,
                'avatar_url' => $member->user->getAvatarPath(),
            ];
        })->values();

        return response()->json(
            [
                'organization' => $organization_tab,
                'members' => $members_tab,
            ]
        )->setEncodingOptions(JSON_PRETTY_PRINT);
    }


}
