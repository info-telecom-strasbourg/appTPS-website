<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fouaille;

class FouailleController extends Controller
{
    public function fouaille(Request $request){
        $user = DB::table('users')->select('nom')->where('identifiant', '=', $request->session()->get('cas_user'))->first();
        $prenom = explode(" ", $user->nom)[0];
        $nom = explode(" ", $user->nom)[1];

        $fouaille[] = new Fouaille;
        $fouaille = DB::connection('bde')
        ->table('Commande')
        ->select('new_note','delta','type_produit','date_histo')
        ->where('nom', '=', $nom)
        ->where('prenom', '=', $prenom)
        ->orderBy('date_histo', 'desc')
        ->limit(20)
        ->get();
        return $fouaille;
    }
}
