<?php

namespace App\Http\Controllers;

use App\Models\UserAvatar;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Closure;

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
     * 
     * @response status=201 {"message":"Avatar uploaded successfully"}
     * @response status=422 {"message":"Validation failed","errors":{"avatar":["The avatar field must be an image.","The avatar field must be a file of type: jpeg, png, jpg, heic."]}}
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
        $disk = config('avatar.disk');
        $directory = config('avatar.directory');

        // s'il y a deja un avatar
        if ($user->avatar != null)
        {
            // si l'avatar n'est pas un avatar par defaut
            if (!$user->avatar->is_default) {
                $path = Str::finish($directory, '/') . $user->avatar->name;
                Storage::disk($disk)->delete($path);
            }

            $user->avatar->delete();
        }

        $avatar = $request->file('avatar');

        // creation d'un nom unique pour l'avatar
        $name = $user->id . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();

        $avatar->storeAs($directory, $name, $disk); // enregistrement de l'image sur le serveur

        $user->avatar()->create([
            'name' => $name,
            'is_default' => false,
            'size' => $avatar->getSize()
        ]);

        return response()->json([
            'message' => 'Avatar uploaded successfully',
        ], 201);
    }

    /**
     * Change Avatar (default)
     * 
     * Set a default avatar as the current user's avatar.
     * 
     * <aside class="notice"> Will only work with names from <b>Default Avatars</b>.</aside>
     * 
     * @response status=200 {"message":"Avatar set successfully"}
     * @response status=422 {"message":"Validation failed","errors":{"name":["name must be an existing default avatar's  name."]}}
     */
    public function storedefault(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                // validation rule, qui check si le nom fait partie des choix possibles
                function (string $attribute, mixed $value, Closure $fail) {
                    $default_directory = config('avatar.defaults_directory');
                    $disk = config('avatar.disk');

                    $filename = basename($value);
                    $filePath = $default_directory . '/' . $filename;

                    if ($filename != $value || ($filename != basename(config('avatar.fallback_image')) && !Storage::disk($disk)->exists($filePath))) {
                        $fail($attribute . ' must be an existing default avatar\'s  name.');
                    }
                },
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $user = $request->user();
        $disk = config('avatar.disk');
        $directory = config('avatar.directory');

        // s'il y a deja un avatar
        if ($user->avatar != null)
        {
            // si l'avatar n'est pas un avatar par defaut
            if (!$user->avatar->is_default) {
                $path = Str::finish($directory, '/') . $user->avatar->name;
                Storage::disk($disk)->delete($path);
            }

            $user->avatar->delete();
        }

        $name = $request->name;

        //si l'image souhaitée n'est pas l'image de fallback
        if ($name != basename(config('avatar.fallback_image'))) {
            $user->avatar()->create([
                'name' => $name,
                'is_default' => true,
                'size' => null
            ]);
        }

        return response()->json([
            'message' => 'Avatar set successfully',
        ], 200);
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
