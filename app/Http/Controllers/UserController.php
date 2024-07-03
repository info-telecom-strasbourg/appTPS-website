<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /* *
     * Update the user's different fields (except password)
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_name' => [
                'string',
                'min:3',
                'max:255',
                'unique:users,user_name',
                'unique:bde_bdd.'.env("BDE_DB_DATABASE").'.organizations,user_name'
            ],
            'phone' => [
                'string',
                'min:3',
                'max:10',
                'unique:users,phone'
            ],
            'sector' =>  [
                'integer',
                'exists:sectors,id'
            ],
            'promotion_year' => [
                'integer',
                'min:2000',
                'max:3000'
            ],
            'description' => [
                'string',
                'max:100'
            ],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $user = $request->user();

        $user->update($validation->validated());

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $this->getMe($request)->getData()->data
        ], 200);
    }


    /* *
     * Get the user's different fields
     *
     * @param Request $request
     */
    public function getMe(Request $request)
    {
        $per_page = request()->query('per_page');

        $user = $request->user();

        return response()->json([
            'data' => [
                'id' => $user->id,
                'last_name' => $user->last_name,
                'first_name' => $user->first_name,
                'user_name' => $user->user_name,
                'description' => $user->description,
                'email' => $user->email,
                'phone' => $user->phone,
                'bde_id' => $user->bde_id,
                'avatar_url' => $user->avatar->path,
                'promotion_year' => $user->promotion_year,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'email_verified_at' => $user->email_verified_at,
                'sector' => $user->sector ? $user->sector->short_name : null,
                'birth_date' => $user->birth_date,
            ],
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

    public function show($id)
    {
        $per_page = request()->query('per_page');

        $user = User::find($id);

        $posts = $user->posts()->orderByDesc('created_at')->paginate($per_page);

        return response()->json([
            'data' => [
                'id' => $user->id,
                'last_name' => $user->last_name,
                'first_name' => $user->first_name,
                'user_name' => $user->user_name,
                'description' => $user->description,
                'avatar_url' => $user->avatar->path,
                'promotion_year' => $user->promotion_year,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'sector' => $user->sector ? $user->sector->short_name : null,
                'birth_date' => $user->birth_date,
            ],
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

    public function index()
    {
        $users = User::filter(request(['search']))->get();

        $users_tab = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'short_name' => $user->short_name,
                'name' => $user->name,
                'logo_url' => $user->getLogoPath()
            ];
        })->values();

        return response()->json(['data' => [
            'users' => $users_tab,
        ]])->setEncodingOptions(JSON_PRETTY_PRINT);
    }

    public function delete(Request $request){
        $request->user()->delete();

        return response()->json([
            'message' => 'The user has been deleted'
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
