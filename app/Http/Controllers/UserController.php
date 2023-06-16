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
        $user = $request->user();
        return response()->json($user, 200)->setEncodingOptions(JSON_PRETTY_PRINT);
    }
}
