<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nickname' => ['string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['string', 'max:255'],
            'redactor' => ['integer'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'nickname' => $request->nickname,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'redactor' => $request->redactor,
            'password' => Hash::make($request->password),
            'avatar' => $request->avatar
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // event(new Registered($user));

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }
}
