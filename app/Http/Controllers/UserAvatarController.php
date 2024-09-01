<?php

namespace App\Http\Controllers;

use App\Models\UserAvatar;
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
                'mimes:jpeg,png,jpg,heic',
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

        if ($user->avatar != null) {
            Storage::delete('public/images/avatars/' . $user->avatar->name);
            $user->avatar->delete();
        }

        $avatar = $request->file('avatar');

        $name = $user->id . '_' . time() . '_' . $user->last_name . '_' . $user->first_name . '_' . random_int(0, 1000) . '.' . $avatar->getClientOriginalExtension();

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

    public function storedefault(Request $request){
        $validation = Validator::make($request->all(), [
            'default_link' => [
                'required',
                'string',
                'max:255'
            ],
            'default_name' => [
                'required',
                'string',
                'max:255'
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $user = $request->user();

        if ($user->avatar != null) {
            Storage::delete('public/images/avatars/' . $user->avatar->name);
            $user->avatar->delete();
        }

        $default_link = $request->default_link;
        $default_name = $request->default_name;

        $user->avatar()->create([
            'name' => $default_name,
            'path' => $default_link,
            'size' => null
        ]);

        return response()->json([
            'message' => 'Avatar uploaded successfully',
        ], 200);
    }

    public function default(Request $request)
    {
        return response()->json([
            "default1" => asset('storage/images/avatars/default1.png'),
            "default2" => asset('storage/images/avatars/default2.png'),
            "default3" => asset('storage/images/avatars/default3.png'),
            "default4" => asset('storage/images/avatars/default4.png'),
            "default5" => asset('storage/images/avatars/default5.png'),
            "default6" => asset('storage/images/avatars/default6.png'),
            "default7" => asset('storage/images/avatars/default7.png'),
            "default8" => asset('storage/images/avatars/default8.png'),
            "default9" => asset('storage/images/avatars/default9.png'),
            "default10" => asset('storage/images/avatars/default10.png'),
            "default11" => asset('storage/images/avatars/default11.png'),
            "default12" => asset('storage/images/avatars/default12.png'),
            "default13" => asset('storage/images/avatars/default13.png'),
            "default14" => asset('storage/images/avatars/default14.png'),
            "default15" => asset('storage/images/avatars/default15.png'),
            "default16" => asset('storage/images/avatars/default16.png'),
            "default17" => asset('storage/images/avatars/default17.png'),
            "default18" => asset('storage/images/avatars/default18.png'),
            "default19" => asset('storage/images/avatars/default19.png'),
            "default20" => asset('storage/images/avatars/default20.png'),
            ], 200);
    }
}
