<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fouaille;

use App\Services\FouailleService;


class FouailleController extends Controller
{
    public function show(FouailleService $Fouaille_service, Request $request){
        $fouaille['current_balance'] = $Fouaille_service->getBalance($request);
        $fouaille['last_commands'] = $Fouaille_service->getLastCommands($request);
        $fouaille = json_decode(json_encode($fouaille), true);
        return view('fouaille', compact('fouaille'));
    }
}
