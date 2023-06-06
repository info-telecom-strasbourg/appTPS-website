<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Services\FouailleService;


class ApiFouailleController extends Controller
{
    public function show(FouailleService $Fouaille_service, Request $request)
    {
        $key=$request->query('api_key');
        $last_name=$request->query('id_user');
        
        if($key==hash('sha256',env('API_KEY').$id_user)){

            $fouaille['current_balance'] = $FouailleService->getBalance($request);
            $fouaille['last_commands'] = $FouailleService->getLastCommands($request);

            $fouaille = json_decode(json_encode($fouaille), true);
            return $fouaille;
        }
        return 'bad key';
    }
}
