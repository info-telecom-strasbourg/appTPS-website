<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
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
        /* $request->validate([
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]); */
        /* if ($request->has('fichier'))
        {
            $postImages = [];
            return $request->fichier;
            foreach ($request->fichier as $image)
            {
                return $image;
                $postImages[] = $this->saveImage($image);
            }
            $post->fichier = json_encode($postImages);
        } */
        $post->updated_at = NULL;
        $post->save();
        return redirect('/create-article')->with('message', 'Enregistré !');
    }

    /**
     * Save an image given by the user in the public storage folder.
     *
     * @param image: the image to be stored
     * @return the path to find the image
     */
    public function saveImage($image)
    {
        $path = Storage::putFile('public/images/articles/', $image, 'public');
        return substr($path, 7);
    }
}
