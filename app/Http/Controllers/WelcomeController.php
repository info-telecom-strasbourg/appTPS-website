<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Middleware\CheckCas;
use Illuminate\Support\Facades\DB;


class WelcomeController extends Controller
{
    /**
     * Get data for welcome page.
     */
    public function welcome()
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

        $articles = DB::select('select * from posts');
        $articles = json_decode(json_encode($articles), true);

        return view('welcome', compact('articles'));
    }
}
