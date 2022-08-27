<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Middleware\CheckCas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

        $articles = DB::select('select * from posts order by id desc');
        $articles = json_decode(json_encode($articles), true);

        return view('welcome', compact('articles'));
    }

    public function toggle_view(Request $request)
    {
        $admin_view = ($request->view == "on") ? 1 : 0;
        session()->put('admin_view', $admin_view);
        return redirect('/');
    }

    public function delete(Request $request)
    {
        DB::table('posts')
            ->where('id', $request->id)
            ->update(['supprimé' => 1, 'created_at' => DB::raw('created_at')]);
        return redirect('/');
    }

    public function erased(Request $request)
    {
        if ($request->supprimer == 1) {
            DB::table('posts')
                ->where('id', $request->id)
                ->delete();
            return redirect('/');
        } else if ($request->restaurer == 1) {
            DB::table('posts')
                ->where('id', $request->id)
                ->update(['supprimé' => 0, 'created_at' => DB::raw('created_at')]);
            return redirect('/');
        } else if ($request->modifier == 1) {
            $id = $request->id;
            $modify = json_decode(json_encode(DB::table('posts')->select('*')->where('id', $id)->first()), true);
            return view('create-article', compact('modify', 'id'));
        } else {
            return redirect('/');
        }
    }

    public function available(Request $request)
    {
        if ($request->modifier == 1) {
            $id = $request->id;
            $modify = json_decode(json_encode(DB::table('posts')->select('*')->where('id', $id)->first()), true);
            return view('create-article', compact('modify', 'id'));
        } else if ($request->supprimer == 1) {
            DB::table('posts')
                ->where('id', $request->id)
                ->update(['supprimé' => 1, 'created_at' => DB::raw('created_at')]);
            return redirect('/');
        } else {
            return redirect('/');
        }
    }
}
