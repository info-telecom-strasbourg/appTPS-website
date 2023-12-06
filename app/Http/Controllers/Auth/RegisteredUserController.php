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

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => [
                'string',
                'min:3',
                'max:30',
                'unique:users,user_name'
            ],
            'last_name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'first_name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'sector' => [
                'required',
                'integer',
                'exists:sectors,id'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'phone' => [
                'string',
                'min:3',
                'max:10',
                'unique:users,phone'
            ],
            'promotion_year' => [
                'integer',
                'min:2000',
                'max:3000'
            ],
            'password' => [
                'required',
                'confirmed'
            ],
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


        try{

            Member::create([
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'contributor' => 0,
                'class' => $request->promotion_year,
                'sector' => Sector::find($request->sector)->short_name,
            ]);

        }catch (\Exception $e){
            return response()->json([
                'message' => 'An error occurred while creating the member (Bde)',
                'error' => $e->getMessage()
            ], 409);
        }

        try{
            $user = User::create([
                'bde_id' => DB::connection('bde_bdd')->table('members')->where('email', '=', $request->email)->first()->id,
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'sector_id' => $request->sector,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'promotion_year' => $request->promotion_year,
                'password' => Hash::make($request->password),
                'birth_date' => $request->birth_date,
            ]);
        } catch (\Exception $e){
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
     * Check if the user take unique values that are already taken by an other user
     *
     * @param Request $request
     */
    public function availability(Request $request){
        $query = User::query();

        foreach ($request->all() as $key => $value){
            $query->orWhere($key, $value);
        }

        if($query->first()){
            return response()->json([
                'message' => 'An other user already exist with this value'
            ], 409);
        }else{
            return response()->json([
                'message' => 'This value is available'
            ], 200);
        }
    }
}
