<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAvatarController extends Controller
{
    public function update(Request $request){
        $validation = Validator::make($request->all(), [
            'avatar' => [
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048'
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $path =$request->file('avatar')->store('avatars');

    }
}
