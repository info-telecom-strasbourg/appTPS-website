<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bde\Member;
use App\Models\User;
use http\Env\Response;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

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
            'user_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['string', 'max:255'],
            'promotion_year' => ['string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 401);
        }

        Member::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'contributor' => 0,
            'class' => $request->promotion_year
        ]);

        $user = User::create([
            'bde_id' => DB::connection('bde_bdd')->table('members')->where('email', '=', $request->email)->first()->id,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'promotion_year' => $request->promotion_year,
            'password' => Hash::make($request->password)
        ]);


        $token = $user->createToken('auth_token')->plainTextToken;

        event(new Registered($user));

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function availability(Request $request){
        $query = User::query();

        foreach ($request->all() as $key => $value){
            $query->orWhere($key, $value);
        }

        if($query->first()){
            return response()->json([
                'message' => 'Utilisateur déjà existant'
            ], 409);
        }else{
            return response()->json([
                'message' => 'Aucun utilisateur existant avec ces valeurs'
            ], 200);
        }
    }
}
