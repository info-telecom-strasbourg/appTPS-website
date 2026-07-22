<?php

namespace App\Http\Controllers;

use App\Models\CategoryType;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * @group User
 */
class UserController extends Controller
{

    /**
     * Update Current User
     * 
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
            'admission_year' => [
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


    /**
     * 
     * Current User Infos
     * 
     * Fetch all of the current user's data
     *
     * @param Request $request
     */
    public function getMe(Request $request)
    {
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
                'avatar_url' => $user->getAvatarPath(),
                'admission_year' => $user->admission_year,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'email_verified_at' => $user->email_verified_at,
                'sector' => $user->sector ? $user->sector->short_name : null,
                'sector_id' => $user->sector_id,
                'birth_date' => $user->birth_date,
            ],
            'organizations' => $user->organizations()->get()->map(function ($organization) {
                return [
                    'id' => $organization->id,
                    'name' => $organization->name,
                    'role' => $organization->pivot->role,
                    'logo_url' => $organization->getLogoPath()
                ];
            }),
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

    /**
     * User Infos
     * 
     * Fetch public data of specified user
     * 
     */
    public function show($id)
    {
        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $user->id,
                'last_name' => $user->last_name,
                'first_name' => $user->first_name,
                'user_name' => $user->user_name,
                'description' => $user->description,
                'avatar_url' => $user->getAvatarPath(),
                'admission_year' => $user->admission_year,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'sector' => $user->sector ? $user->sector->short_name : null,
                'birth_date' => $user->birth_date,
            ],
            'organizations' => $user->organizations()->get()->map(function ($organization) {
                return [
                    'id' => $organization->id,
                    'name' => $organization->name,
                    'role' => $organization->pivot->role,
                    'logo_url' => $organization->getLogoPath()
                ];
            }),
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

    /**
     * Users Index
     * 
     * Fetch a paginated list of users
     *
     * @queryParam per_page int Number of elements per page. Example: 10
     * @queryParam search string Text to search in Users's last_name/first_name/user_name No-example
     * @queryParam page int Page number. Example: 1
     */
    public function index()
    {
        $per_page = request()->query('per_page');

        if($per_page == null){
            $per_page = 10;
        }

        $users = User::filter(request(['search']))->paginate($per_page);

        $users_tab = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'user_name' => $user->user_name,
                'name' => $user->name,
                'logo_url' => $user->getAvatarPath()
            ];
        })->values();

        return response()->json(['data' => [
            'users' => $users_tab,
            'meta' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'first_page_url' => $users->url(1)."&per_page=".$per_page,
                'last_page_url' => $users->url($users->lastPage())."&per_page=".$per_page,
                'next_page_url' => $users->nextPageUrl()."&per_page=".$per_page,
                'prev_page_url' => $users->previousPageUrl()."&per_page=".$per_page,
                'path' => $users->path(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ]
        ]])->setEncodingOptions(JSON_PRETTY_PRINT);
    }

    /**
     * Delete Current User
     * 
     * Remove the user from de main database
     */
    public function delete(Request $request){
        $request->user()->delete();

        return response()->json([
            'message' => 'The user has been deleted'
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
