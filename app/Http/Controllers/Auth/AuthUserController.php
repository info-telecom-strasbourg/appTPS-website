<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthUserController extends Controller
{
    public function login(LoginRequest $request){
        try {
            $request->authenticate();

            if (!$request->user()->tokenCan('auth_token')) {
                $request->user()->tokens()->delete();
                $token = $request->user()->createToken('auth_token')->plainTextToken;
            } else {
                $token = $request->user()->tokens()->where('name', 'auth_token')->first()->plainTextToken;
            }

            return response()->json([
                'user' => $request->user(),
                'token' => $token
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
