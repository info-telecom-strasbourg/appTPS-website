<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(){
        $validation = Validator::make($request->all(), [
            'title' => 'required|max:50|min:3',
            'excerpt' => 'required|max:255|min:3',
            'body' => 'required|min:3',
            'organization_id' => 'integer|exists:organizations,id',
            'event_id' => 'integer|exists:events,id',
        ]);
    }
}
