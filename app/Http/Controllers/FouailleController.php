<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\isEmpty;

class FouailleController extends Controller
{
    public function show($id)
    {
        // return response()->json(
        //     HTTP::withToken(
        //         Client::where('name', 'insidepsbs')
        //         ->first()
        //         ->getFouailleToken()
        //     )
        //     ->acceptJson()
        //     ->get(env('FOUAILLE_APP_URL').'/api/fouaille/'.$id)
        //     ->json()
        // )->setEncodingOptions(JSON_PRETTY_PRINT);
        return response()->json(
            HTTP::acceptJson()
            ->get(env('FOUAILLE_APP_URL').'/api/fouaille/'.$id)
            ->json()
        )->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
