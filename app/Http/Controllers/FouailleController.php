<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fouaille;


class FouailleController extends Controller
{
    public function api(Request $request)
    {
        //https://app.its-tps.fr/api?nom=chenu&prenom=gatien&key=245513a52b24c98b3137ef73c81dcebe0862fd9614b654f863c03ae20a44d23c
        $APIkey = "(n7m4w'3k+#k'8BA[#&z0H'A+d.4H";
        $nom=$request->query('nom');
        $prenom=$request->query('prenom');
        $key=$request->query('key');
        
        if($key==hash('sha256',env('API_KEY').$nom.$prenom)){

            // Va chercher dans la BDD du BDE 
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
                ->limit(2000)
                ->get();
            $fouaille = json_decode(json_encode($fouaille), true);
            return $fouaille;
        }
        return 'bad key';
        
    }
    public function app_fouaille(Request $request){
        // Récupère l'utilisateur connecté
        $user = DB::table('users')->select('nom')->where('identifiant', '=', $request->session()->get('cas_user'))->first();
        $prenom = explode(" ", $user->nom)[0];
        $nom = explode(" ", $user->nom)[1];
        if (count(explode(" ", $user->nom)) > 2)
            $nom .= " " . explode(" ", $user->nom)[2];

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
            ->limit(2000)
            ->get();
        return $fouaille;
    }

    public function fouaille(Request $request){
        // Récupère l'utilisateur connecté
        $user = DB::table('users')->select('nom')->where('identifiant', '=', $request->session()->get('cas_user'))->first();
        $prenom = explode(" ", $user->nom)[0];
        $nom = explode(" ", $user->nom)[1];
        if (count(explode(" ", $user->nom)) > 2)
            $nom .= " " . explode(" ", $user->nom)[2];

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
            ->limit(2000)
            ->get();
        $fouaille = json_decode(json_encode($fouaille), true);
        return view('fouaille', compact('fouaille'));
    }
}
