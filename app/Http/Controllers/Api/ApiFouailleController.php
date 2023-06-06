<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Services\FouailleService;
use App\Http\Controllers\Controller;


class ApiFouailleController extends Controller
{
    public function show(FouailleService $Fouaille_service, Request $request)
    {
        $key=$request->query('key');
        $id_bde=$request->query('id_bde');

        
        if($key==hash('sha256',env('API_KEY').$id_bde)){

            $fouaille['current_balance'] = $Fouaille_service->getBalance($id_bde);
            $fouaille['last_commands'] = $Fouaille_service->getLastCommands($id_bde);

            $fouaille = json_decode(json_encode($fouaille), true);
            return $fouaille;
        }
        return 'bad key';
    }
}
