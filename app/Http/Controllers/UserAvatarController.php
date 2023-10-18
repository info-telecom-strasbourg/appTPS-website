<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class UserAvatarController extends Controller
{
    function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'avatar' => [
                'required',
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

        $user = $request->user();

        $avatar = $request->file('avatar');

        $stored_path = $avatar->storeAs('public/images/avatars', $avatar->getClientOriginalName());

        $user->avatar()->create([
            'name' => $avatar->getClientOriginalName(),
            'path' => asset('storage/images/avatars/' . $avatar->getClientOriginalName()),
            'size' => $avatar->getSize()
        ]);

        return response()->json([
            'message' => 'Avatar uploaded successfully',
        ], 200);
    }
}
