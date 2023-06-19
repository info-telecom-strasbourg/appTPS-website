<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        $user = $request->user()->get();
        
        $datas = $user->map(function ($item) {
            return [
                'id' => $item->id,
                'last_name' => $item->last_name,
                'first_name' => $item->first_name,
                'user_name' => $item->user_name,
                'email' => $item->email,
                'phone' => $item->phone,
                'user_name' => $item->user_name,
                'bde_id' => $item->bde_id,
                'avatar_url' => $item->getAvatarPath(),
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'email_verified_at' => $item->email_verified_at,
            ];
        });

        return response()->json(['data' => $datas], 200)->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
