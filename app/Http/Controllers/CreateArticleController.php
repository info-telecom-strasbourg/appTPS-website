<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class CreateArticleController extends Controller
{
    public function index()
    {
        if (session()->get('cas_role') == 'étudiant') {
            session()->put('auth_error', "notredactor");
            return redirect("authentication-failed");
        } else {
            return view('create-article');
        }
    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->titre = $request->titre;
        $post->auteur = $request->auteur;
        $post->email = $request->email;
        $post->contenu = $request->contenu;
        $post->asso_club = $request->asso_club;
        $request->validate([
            'titre' => 'min:5|max:250|required',
            'auteur' => 'min:5|max:250|required',
            'email' => 'required',
            'contenu' => 'min:20|max:65000|required',
            'fichiers' => 'array',
            'fichiers.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:131072',
        ]);
        if ($request->has('fichiers')) {
            $postImages = [];
            foreach ($request->fichiers as $image) {
                $path = substr(Storage::putFile('public/images/articles', $image, 'public'), 7);
                $postImages[] = $path;
            }
            $post->fichiers = json_encode($postImages, JSON_UNESCAPED_SLASHES);
        }
        $post->updated_at = NULL;
        $post->save();
        return redirect('/create-article')->with('message', 'Enregistré !');
    }

    public function update(Request $request)
    {
        $request->validate([
            'titre' => 'min:5|max:250|required',
            'auteur' => 'min:5|max:250|required',
            'email' => 'required',
            'contenu' => 'min:20|max:65000|required'
        ]);
        DB::table('posts')->where('id', $request->id)->update([
            'titre' => $request->titre,
            'auteur' => $request->auteur,
            'email' => $request->email,
            'contenu' => $request->contenu,
            'asso_club' => $request->asso_club,
            'supprimé' => 0,
            'created_at' => DB::raw('created_at'),
            'updated_at' => now()
        ]);
        return redirect('/');
    }
}
