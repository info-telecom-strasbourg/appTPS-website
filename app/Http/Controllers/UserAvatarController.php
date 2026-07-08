<?php

namespace App\Http\Controllers;

use App\Models\UserAvatar;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

/**
 * @group User
 * @subgroup Avatar
 */
class UserAvatarController extends Controller
{
    /**
     * Change Avatar
     * 
     * Upload an image and replace the current user's avatar with it.
     */
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

        if ($user->avatar != null &&  !str_contains($user->name, 'default')) {
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

    /**
     * Change Avatar (no upload)
     * 
     * Take an image URL and replace the current user's avatar with it.
     * 
     * <aside class="warning"> Should only be used with images from <b>Default Avatar</b> !</aside>
     */
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

        if ($user->avatar != null && !str_contains($user->name, 'default')) {
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

    /**
     * Default Avatar
     * 
     * Fetch a hardcoded list of default avatars.
     */
    public function default(Request $request)
    {
        $default_tab = [
            ["name" => "default1", "path" => asset('storage/images/avatars/default1.png')],
            ["name" => "default2", "path" => asset('storage/images/avatars/default2.png')],
            ["name" => "default3", "path" => asset('storage/images/avatars/default3.png')],
            ["name" => "default4", "path" => asset('storage/images/avatars/default4.png')],
            ["name" => "default5", "path" => asset('storage/images/avatars/default5.png')],
            ["name" => "default6", "path" => asset('storage/images/avatars/default6.png')],
            ["name" => "default7", "path" => asset('storage/images/avatars/default7.png')],
            ["name" => "default8", "path" => asset('storage/images/avatars/default8.png')],
            ["name" => "default9", "path" => asset('storage/images/avatars/default9.png')],
            ["name" => "default10", "path" => asset('storage/images/avatars/default10.png')],
            ["name" => "default11", "path" => asset('storage/images/avatars/default11.png')],
            ["name" => "default12", "path" => asset('storage/images/avatars/default12.png')],
            ["name" => "default13", "path" => asset('storage/images/avatars/default13.png')],
            ["name" => "default14", "path" => asset('storage/images/avatars/default14.png')],
            ["name" => "default15", "path" => asset('storage/images/avatars/default15.png')],
            ["name" => "default16", "path" => asset('storage/images/avatars/default16.png')],
            ["name" => "default17", "path" => asset('storage/images/avatars/default17.png')],
            ["name" => "default18", "path" => asset('storage/images/avatars/default18.png')],
            ["name" => "default19", "path" => asset('storage/images/avatars/default19.png')],
            ["name" => "default20", "path" => asset('storage/images/avatars/default20.png')],
        ];

        return response()->json([
            "data" => $default_tab
        ], 200);
    }
}
