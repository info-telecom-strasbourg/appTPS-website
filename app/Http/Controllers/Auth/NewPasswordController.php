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
     * Handle an incoming new password request from a web form.
     * redirect to the password updated view
     *
     */
    public function store(Request $request, $token) {
        $request->validate([
            'email' => [
                'required',
                'email:exists:users,email'
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8) // the password must be at least 8 characters in length, contain at least one uppercase letter, one lowercase letter, and one number.
                    ->mixedCase()
                    ->numbers()
                    ->letters()
            ],
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
            return view('auth.password-reset', 
            [
                'message' => 'Password not reset',
                'status' => 422
            ]);
        }

        return view('auth.password-reset',
            [
                'message' => 'Password updated successfully',
                'status' => 200
            ]);
    }


    /**
     * Handle an incoming new password request.
     *
     */
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'former_password' => [
                'required', 
                Rules\Password::min(8) // the password must be at least 8 characters in length, contain at least one uppercase letter, one lowercase letter, and one number.
                    ->mixedCase()
                    ->numbers()
                    ->letters()
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8) // the password must be at least 8 characters in length, contain at least one uppercase letter, one lowercase letter, and one number.
                    ->mixedCase()
                    ->numbers()
                    ->letters()
            ]
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

    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request, $token){
        return view(
            'auth.password-reset-form',
             [
                'token' => $token,
                'email' => $request->email
            ]);
    }

    /**
     * Display the password updated view.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function show(){
        return view('auth.password-reset');
    }
}
