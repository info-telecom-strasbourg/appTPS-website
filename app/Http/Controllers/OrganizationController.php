<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bde\Organization;

class OrganizationController extends Controller
{
    public function index(){
        $associations = Organization::select('id', 'acronym', 'name', 'logo')->where('association', '=', 1)->get();
        $associations_tab = $associations->map(function ($asso) {
            return [
                'id' => $asso->id,
                'acronym' => $asso->acronym,
                'name' => $asso->name,
                'logo_url' => $asso->getLogoPath()
            ];
        })->values();

        $clubs = Organization::select('id', 'acronym', 'name', 'logo')->where('association', '=', 0)->get();
        $clubs_tab = $clubs->map(function ($club) {
            return [
                'id' => $club->id,
                'acronym' => $club->acronym,
                'name' => $club->name,
                'logo_url' => $club->getLogoPath()
            ];
        })->values();

        return response()->json(['data' => [
            'associations' => $associations_tab,
            'clubs' => $clubs_tab
        ]])->setEncodingOptions(JSON_PRETTY_PRINT);
    }

    public function show($id){
        $organization = Organization::find($id);
        if ($organization->website_link != null
        || $organization->facebook_link != null
        || $organization->twitter_link != null
        || $organization->instagram_link != null
        || $organization->discord_link != null){
            $links = [
                'website_link' => $organization->website_link,
                'facebook_link' => $organization->facebook_link,
                'twitter_link' => $organization->twitter_link,
                'instagram_link' => $organization->instagram_link,
                'discord_link' => $organization->discord_link
            ];
        }else{
            $links = null;
        }

        $organization_tab = [
                'short_name' => $organization->short_name,
                'name' => $organization->name,
                'description' => $organization->description,
                'links' => $links,
                'logo_url' => $organization->getLogoPath(),
            ];
        return response()->json(['data' => $organization_tab])->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
