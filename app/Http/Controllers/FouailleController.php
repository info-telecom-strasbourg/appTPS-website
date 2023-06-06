<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Fouaille;

use App\Services\FouailleService;


class FouailleController extends Controller
{
    public function show(FouailleService $Fouaille_service){
        $fouaille['current_balance'] = $Fouaille_service->getBalance(session()->get('id_bde'));
        $fouaille['last_commands'] = $Fouaille_service->getLastCommands(session()->get('id_bde'));
        $fouaille = json_decode(json_encode($fouaille), true);
        return view('fouaille', compact('fouaille'));
    }
}
