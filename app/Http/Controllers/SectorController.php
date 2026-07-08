<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;

/**
 * @group Other
 * @subgroup Sector
 */
class SectorController extends Controller
{
    /**
     * Sector Index
     * 
     * Fetch all sectors
     * @unauthenticated
     */
    public function index(){
        return response()->json([
            'data' => Sector::all()->map(function ($sector){
                return [
                    'id' => $sector->id,
                    'name' => $sector->name,
                    'short_name' => $sector->short_name,
                ];
            })
        ]);
    }
}
