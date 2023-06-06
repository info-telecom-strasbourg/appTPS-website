<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fouaille;

use App\Services\FouailleService;


class FouailleController extends Controller
{
    public function show(FouailleService $FouailleService, Request $request){
        $fouaille['current_balance'] = $FouailleService->getBalance($request);
        $fouaille['last_commands'] = $FouailleService->getLastCommands($request);
        $fouaille = json_decode(json_encode($fouaille), true);
        return view('fouaille', compact('fouaille'));
    }
}
