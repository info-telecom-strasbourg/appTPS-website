<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FouailleController extends Controller
{

    public function show($id)
    {


        $datas = json_decode(file_get_contents("https://fouaille.bde-tps.fr/api/fouaille/".$id),
            true);
        return response()->json($datas)->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
