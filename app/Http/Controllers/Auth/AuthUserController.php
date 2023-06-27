<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class AuthUserController extends Controller
{
    public function login(LoginRequest $request){
        try {
            $request->authenticate();

            $token = $request->user()->createToken('auth_token')->plainTextToken;

            if ($request->user() && ($request->user() instanceof MustVerifyEmail && !$request->user()->hasVerifiedEmail())) {
                return response()->json([
                    'message' => 'Your email address is not verified.',
                    'user' => $request->user(),
                    'token' => $token
                ], 409);
            }

            return response()->json([
                'user' => $request->user(),
                'token' => $token
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                $e->errors()
            ], $e->status);
        }

    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
