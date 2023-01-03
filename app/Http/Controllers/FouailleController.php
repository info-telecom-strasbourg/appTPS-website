<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fouaille;

class FouailleController extends Controller
{
    public function fouaille(Request $request){
        // Récupère l'utilisateur connecté
        $user = DB::table('users')->select('nom')->where('identifiant', '=', $request->session()->get('cas_user'))->first();
        $prenom = explode(" ", $user->nom)[0];
        $nom = explode(" ", $user->nom)[1];

        // Va chercher dans la BDD du BDE 
        $fouaille[] = new Fouaille;
        $fouaille = DB::connection('bde')
            ->table('Commande')
            ->select(
                    'date_histo',
                    'new_note',
                    'delta',
                    'type_produit',
                    )
            ->where('nom', '=', $nom)
            ->where('prenom', '=', $prenom)
            ->orderBy('date_histo', 'desc')
            ->limit(20)
            ->get();
        return $fouaille;
    }
}
