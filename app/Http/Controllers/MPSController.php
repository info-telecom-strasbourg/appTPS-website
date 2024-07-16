<?php

namespace App\Http\Controllers;

class MPSController extends Controller
{
    public function index() {
        return response()->json([
            'link' => "https://nextcloud.its-tps.fr/s/zfFkwR6y5wxt5gW",
        ], 200);
    }
}
