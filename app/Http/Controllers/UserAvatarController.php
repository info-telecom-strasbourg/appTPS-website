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

        if ($user->avatar != null &&  !str_contains($user->avatar->name, 'default')) {
            Storage::delete('public/images/avatars/' . $user->avatar->name);
            $user->avatar->delete();
        }

        $avatar = $request->file('avatar');

        $name = $user->id . '_' . time() . '_' . $user->last_name . '_' . $user->first_name . '_' . random_int(0, 1000) . '.' . $avatar->getClientOriginalExtension();

        $avatar->storeAs('public/images/avatars', $name);

        $user->avatar()->create([
            'name' => $name,
            'path' => asset('storage/images/avatars/' . $name),
            'size' => $avatar->getSize()
        ]);

        return response()->json([
            'message' => 'Avatar uploaded successfully',
        ], 201);
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

        if ($user->avatar != null && !str_contains($user->avatar->name, 'default')) {
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
        ], 201);
    }

    /**
     * Default Avatars
     * 
     * Fetch a list of default avatars found in 'avatar.defaults_directory'.
     */
    public function default()
    {
        $disk = config('avatar.disk');
        $directory = config('avatar.defaults_directory');

        // tous les fichiers dans le dossier default
        $files = Storage::disk($disk)->files($directory);

        $avatars = array_map(function ($file) use ($disk) {
            return [
                'name' => basename($file),
                'path' => Storage::disk($disk)->url($file),
            ];
        }, $files);

        // ajoute fallback_image
        $fallback = config('avatar.fallback_image');
        $avatars[] = [
            'name' => basename($fallback),
            'path' => asset($fallback), // asset() car est dans public/
        ];

        return response()->json([
            "data" => $avatars
        ], 200)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }
}
