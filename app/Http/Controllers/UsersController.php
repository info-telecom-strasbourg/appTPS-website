<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;



class UsersController extends Controller
{
    /**
     * Get data for welcome page.
     */
    public function users()
    {
        $users = DB::select('select * from users');
        $users = json_decode(json_encode($users), true);
        return view('users', compact('users'));
    }

    public function update(Request $request)
    {
        $redacteur = ($request->redacteur == "on") ? 1 : 0;
        DB::table('users')
            ->where('identifiant', $request->identifiant)
            ->update(['redacteur' => $redacteur, 'created_at' => DB::raw('created_at')]);
        return redirect('/users');
    }
}
