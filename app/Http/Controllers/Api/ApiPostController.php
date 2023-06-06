<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Models\Post;



class ApiPostsController extends Controller
{
    public function index(Request $request){
        $key=$request->query('api_key');
        
        if($key==hash('sha256',env('API_KEY'))){
            $posts = Post::all()->sortByDesc('created_at');
            $posts = json_decode(json_encode($posts), true);
            return $posts;
        }
        return 'bad key';
    }
}
