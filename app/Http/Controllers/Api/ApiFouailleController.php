<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Services\FouailleService;


class ApiFouailleController extends Controller
{
    public function show(FouailleService $Fouaille_service, Request $request)
    {
        $key=$request->query('key');
        $last_name=$request->query('last_name');
        $first_name=$request->query('first_name');
        
        if($key==hash('sha256',env('API_KEY').$last_name.$first_name)){

            $fouaille['current_balance'] = $FouailleService->getBalance($request);
            $fouaille['last_commands'] = $FouailleService->getLastCommands($request);

            $fouaille = json_decode(json_encode($fouaille), true);
            return $fouaille;
        }
        return 'bad key';
    }
}
