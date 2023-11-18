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

        if ($user->avatar->name != 'default.png') {
            Storage::delete('public/images/avatars/' . $user->avatar->name);
            $user->avatar->delete();
        }

        $avatar = $request->file('avatar');

        $name = $user->id . '_' . time() . '_' . $avatar->getClientOriginalName();

        $stored_path = $avatar->storeAs('public/images/avatars', $name);

        $user->avatar()->create([
            'name' => $name,
            'path' => asset('storage/images/avatars/' . $name),
            'size' => $avatar->getSize()
        ]);

        return response()->json([
            'message' => 'Avatar uploaded successfully',
        ], 200);
    }
}