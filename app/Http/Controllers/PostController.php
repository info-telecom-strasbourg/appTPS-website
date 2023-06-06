<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Post;

class PostController extends Controller
{

    public function softDelete(Request $request){
        $id_post = $request->input('id');
        Post::update($id_post, [
            'deleted_at' => now(),
            'is_deleted' => 1
        ]);
        return redirect()->route('/');
    }

        
    public function erased(Request $request){
        $id_post = $request->input('id');
        $delete = $request->input('delete');
        $restore = $request->input('restore');
        $modifification = $request->input('modify');

        if ($delete == 1){
            Post::delete($id_post);
        } else if ($restore == 1) {
            Post::update($id_post, [
                'deleted_at' => null,
                'is_deleted' => 0
            ]);
        } else if ($modifification == 1) {
            $modify = json_decode(json_encode(Post::find($id_post)->first(), true));
            Post::update($id_post, [
                'title' => $title,
                'content' => $content
            ]);

            return view('create-article', compact('modify', 'id'));
        }

        return redirect()->route('/');
    }
}
