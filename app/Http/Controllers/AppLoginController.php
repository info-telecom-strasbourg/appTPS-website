<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Middleware\CheckCas;
use Illuminate\Support\Facades\DB;


class AppLoginController extends Controller
{
    /**
     * Get data for login page.
     */
    public function login()
    {
        $user = new User;
        $user->identifiant = CheckCas::getUser();
        $user->nom = CheckCas::getName();
        $user->email = CheckCas::getMail();
        $user_in_db = DB::table('users')
            ->select('identifiant')
            ->WHERE('identifiant', '=', $user->identifiant)
            ->first();
        if (CheckCas::isAdmin())
            $user->redacteur = TRUE;
        if ($user_in_db == "")
            $user->save();
        return response()->json(CheckCas::getAttributes());
        // return json_encode(CheckCas::getAttributes());
    }
}
