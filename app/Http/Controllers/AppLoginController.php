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
        $user->id = CheckCas::getUser();
        $user->first_name = explode(' ', CheckCast::getName())[0];
        $user->last_name = explode(' ', CheckCast::getName())[1];
        $user->email = CheckCas::getMail();
        $user_in_db = DB::table('users')
            ->select('id')
            ->WHERE('id', '=', $user->identifiant)
            ->first();
        if (CheckCas::isAdmin())
            $user->redacteur = TRUE;
        if ($user_in_db == "")
            $user->save();
        return response()->json(CheckCas::getAttributes());
        // return json_encode(CheckCas::getAttributes());
    }
}
