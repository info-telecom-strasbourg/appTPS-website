<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
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

        // temporary for testing
        $user->id_bde = 1;
        if (session()->get('id_bde') == null)
            session()->put('id_bde', $user->id_bde);

        $user->username = "username";
        if (session()->get('username') == null)
            session()->put('username', $user->username);

        $user->id_unistra = CheckCas::getUser(); // get user id from CAS (unqique id)
        if (session()->get('id_unistra') == null)
            session()->put('id_unistra', $user->id_unistra);

        // get user's first and last name from CAS (name is in format "first_name last_name")
        $user->first_name = explode(' ', CheckCas::getName())[0];
        if (session()->get('first_name') == null)
            session()->put('first_name', $user->first_name);

        $user->last_name = explode(' ', CheckCas::getName())[1];
        if (session()->get('last_name') == null)
            session()->put('last_name', $user->last_name);

        // get user's email from CAS
        $user->email = CheckCas::getMail();
        if (session()->get('email') == null)
            session()->put('email', $user->email);

        // check if current user is registered in database
        $user_in_db = DB::table('users')
            ->select('id_unistra')
            ->WHERE('id_unistra', '=', $user->id_unistra)
            ->first();


        // check if current user is admin in database
        if (CheckCas::isAdmin()){
            $user->redacteur = TRUE;
            if (session()->get('redacteur') == null)
                session()->put('redacteur', $user->redacteur);
        }

        if ($user_in_db == "") // if user is not in database yet (first time he logs in)
            $user->save();

        $articles = Post::all()->sortByDesc('created_at');
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
            ->update(['delete' => 1, 'created_at' => DB::raw('created_at')]);
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
                ->update(['delete' => 0, 'created_at' => DB::raw('created_at')]);
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
                ->update(['delete' => 1, 'created_at' => DB::raw('created_at')]);
            return redirect('/');
        } else {
            return redirect('/');
        }
    }
}
