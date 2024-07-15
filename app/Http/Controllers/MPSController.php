<?php

namespace App\Http\Controllers;

class MPSController extends Controller
{
    public function index() {
        return response()->json([
            'lien' => env("MPS_URL"),
        ], 200);
    }
}
