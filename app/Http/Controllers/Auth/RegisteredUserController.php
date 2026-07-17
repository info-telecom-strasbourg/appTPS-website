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
use App\Models\Sector;

/**
 *  @group Authentification
 *  
 */
class RegisteredUserController extends Controller
{
    /**
     * Register
     * 
     * Create a new User in the app's database and the BDE's database and send a confirmation e-mail
     * 
     * @unauthenticated
     * @bodyParam password_confirmation string Example: d"5'f4gs98d4f1"'(tg87
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Example: viction
            'user_name' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'unique:users,user_name',
                'unique:bde_bdd.'.env("BDE_DB_DATABASE").'.organizations,user_name'
            ],
            // Example: Doe
            'last_name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            // Example: Jhon
            'first_name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            //See Sector for more details. Example: 2
            'sector' => [
                'required',
                'integer',
                'exists:sectors,id'
            ],
            // Example: viction852@glups.com
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'
            ],
            // Example: 0601020304
            'phone' => [
                'string',
                'min:3',
                'max:10',
                'unique:users,phone'
            ],
            // Example: 2024
            'admission_year' => [
                'integer',
                'min:2000',
                'max:3000'
            ],
            // Example: d"5'f4gs98d4f1"'(tg87
            'password' => [
                'required',
                'confirmed'
            ],
            // Example: 2012-12-12
            'birth_date' => [
                'date',
                'before:today'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }


        try {

            Member::create([
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'contributor' => 0,
                'class' => $request->admission_year,
                'sector' => Sector::find($request->sector)->short_name,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the member (Bde)',
                'error' => $e->getMessage()
            ], 409);
        }

        try {
            $user = User::create([
                'bde_id' => DB::connection('bde_bdd')->table('members')->where('email', '=', $request->email)->first()->id,
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'sector_id' => $request->sector,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'admission_year' => $request->admission_year,
                'password' => Hash::make($request->password),
                'birth_date' => $request->birth_date,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the user (app)',
                'error' => $e->getMessage()
            ], 409);
        }


        $token = $user->createToken('auth_token')->plainTextToken;

        // add the expo token to the user
        $user->expo_token = $request->expo_token;

        event(new Registered($user));

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Availability 
     * 
     *  Check the availability of an authentication information
     * 
     * @unauthenticated
     * @param Request $request
     * 
     * @queryParam email string Example: email@email.com
     * @queryParam user_name string Example: SuperUs3r
     * @queryParam phone string Example: 0601020304
     */
    public function availability(Request $request)
    {
        $query = User::query();

        foreach ($request->all() as $key => $value) {
            $query->orWhere($key, $value);
        }

        if ($query->first()) {
            return response()->json([
                'message' => 'An other user already exist with this value'
            ], 409);
        } else {
            return response()->json([
                'message' => 'This value is available'
            ], 200);
        }
    }
}
