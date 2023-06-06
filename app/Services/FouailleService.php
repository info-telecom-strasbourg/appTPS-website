<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FouailleService
{
    public function getLastCommands(Request $request){
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

        return $last_commands;
    }

    public function getBalance(Request $request){
        $user_id_bde = DB::table('users')
            ->select('id_bde')
            ->where('id_unistra', '=', $request->session()->get('cas_user'))
            ->first()
            ->id_bde;

        $current_balance = DB::connection('bde')
        ->table('members')
        ->select('balance')
        ->where('id', '=', $user_id_bde)
        ->first()
        ->balance;

        return $current_balance;
    }
}