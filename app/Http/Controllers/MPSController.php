<?php

namespace App\Http\Controllers;

/**
 * @group Other
 * @subgroup MPS
 */
class MPSController extends Controller
{
    /**
     * Link
     * 
     * Fetch a hadcoded link to the MPS's Nextcloud
     */
    public function index() {
        return response()->json([
            'link' => "https://nextcloud.its-tps.fr/s/zfFkwR6y5wxt5gW",
        ], 200);
    }
}
