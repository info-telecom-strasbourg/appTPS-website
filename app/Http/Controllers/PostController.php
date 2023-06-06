<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Post;

class PostController extends Controller
{

    public function delete(Request $request){
        $id_post = $request->input('id');
        Post::update($id_post, [
            'deleted_at' => now(),
            'is_deleted' => 1
        ]);
        return redirect()->route('/');
    }
        
}
