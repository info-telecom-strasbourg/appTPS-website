<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $token): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $credentials = $request->only('email', 'password', 'password_confirmation');
        $credentials['token'] = $token;

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $credentials,
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
/*                    'remember_token' => Str::random(60),*/
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Password not reset'
            ], 404);
        }

        return response()->json([
            'message' => 'Password updated'
        ], 200);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'former_password' => ['required', Rules\Password::defaults()],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }


        if(Hash::check($request->former_password, $request->user()->password)){
            $request->user()->forceFill([
                'password' => Hash::make($request->password),
            ])->save();
        } else {
            return response()->json([
                'message' => 'the password does not match',
            ], 422);
        }

        return response()->json([
            'message' => 'Password updated successfully',
        ], 200);
    }

    public function index(Request $request){
        return view('auth.reset-password');
    }
}
