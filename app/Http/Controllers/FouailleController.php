<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fouaille;


class FouailleController extends Controller
{
    public function api(Request $request)
    {
        $key=$request->query('key');
        $last_name=$request->query('last_name');
        $first_name=$request->query('first_name');
        
        if($key==hash('sha256',env('API_KEY').$last_name.$first_name)){

            // Go into BDE database and get the user's last commands
            $fouaille = $this->getLastCommands($request);
            $fouaille = json_decode(json_encode($fouaille), true);
            return $fouaille;
        }
        return 'bad key';
        
    }

    public function getLastCommands(Request $request){
        // $fouaille[] = new Fouaille;

        $user_id_bde = DB::table('users')
            ->select('id_bde')
            ->where('id_unistra', '=', $request->session()->get('cas_user'))
            ->first()
            ->id_bde;

        $last_commands = DB::connection('bde')
            ->table('commandes')
            ->select(
                    'commandes.date', // date of the command
                    'commandes.price', // price of the command
                    'commandes.amount', // quantity of the product
                    'products.name', // name of the product (ex: "meteor")
                    )
            ->join('products', 'products.id', '=', 'commandes.id_product')
            ->join('members', 'members.id', '=', 'commandes.id_member')
            ->where('commandes.id_member', '=', $user_id_bde)
            ->orderBy('commandes.date', 'desc')
            ->limit(2000)
            ->get();

        $current_balance = DB::connection('bde')
            ->table('members')
            ->select('balance')
            ->where('id', '=', $user_id_bde)
            ->first()
            ->balance;
        
        $fouaille['current_balance'] = $current_balance;

        $fouaille['last_commands'] = $last_commands;

        return $fouaille;
    }

    public function fouaille(Request $request){
        $fouaille[] = new Fouaille;
        $fouaille = $this->getLastCommands($request);
        $fouaille = json_decode(json_encode($fouaille), true);
        return view('fouaille', compact('fouaille'));
    }
}
