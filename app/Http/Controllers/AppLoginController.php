<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Middleware\CheckCas;
use DB;


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
            $user->redacteur=TRUE;
        if ($user_in_db=="")
            $user->save();
        return json_encode(CheckCas::getAttributes());
    }
}
