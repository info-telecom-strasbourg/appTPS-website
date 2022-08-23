<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CreateArticleController extends Controller
{
    public function index()
    {
        return view('/create-article');
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
            'fichiers.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
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
}
