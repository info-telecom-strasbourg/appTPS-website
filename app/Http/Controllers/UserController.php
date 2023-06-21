<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_name' => 'string|min:3|max:255|unique:users',
            'phone' => 'string|max:255|regex:/^[0-9]{10,}$/',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $user = $request->user();

        $updatedUser = $validation->validated();

        $user->update([
            'user_name' => $request->user_name,
            'phone' => $request->phone
        ]);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
            ], 200);
    }

    public function show(Request $request)
    {
        $user = $request->user();


        $organization = DB::connection('bde_bdd')
        ->table('organizations')
        ->select(
            'organizations.name',
            'organizations.acronym',
            'organization_members.role',
        )
        ->join('organization_members', 'organization_members.organization_id', '=', 'organizations.id')
        ->where('organization_members.member_id', '=', $user->bde_id)->get();

        $organization_tab = $organization->map(function ($item) {
            return [
                'name' => $item->name,
                'acronym' => $item->acronym,
                'role' => $item->role,
            ];
        })->values();

        return response()->json(['data' => [
            'id' => $user->id,
            'last_name' => $user->last_name,
            'first_name' => $user->first_name,
            'user_name' => $user->user_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'user_name' => $user->user_name,
            'bde_id' => $user->bde_id,
            'avatar_url' => $user->getAvatarPath(),
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'email_verified_at' => $user->email_verified_at,
            'organization' => $organization_tab
            ]
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
