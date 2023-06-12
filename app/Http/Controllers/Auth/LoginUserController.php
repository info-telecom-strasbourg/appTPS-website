<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class LoginUserController extends Controller
{
    public function authenticate(LoginRequest $request){
        try {
            $request->authenticate();

            return response()->json([
                'user' => $request->user(),
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }
}
