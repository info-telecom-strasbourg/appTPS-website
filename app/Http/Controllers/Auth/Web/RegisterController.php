<?php

namespace App\Http\Controllers\Auth\Web;

use App\Models\Bde\Member;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Sector;

class RegisterController extends Controller
{



    public function index()
    {
        return view('auth.register',
            [
                'sectors' => Sector::all()->map(function ($sector){
                    return [
                        'id' => $sector->id,
                        'name' => $sector->name,
                        'short_name' => $sector->short_name,
                    ];
                })
            ]
        );
    }

    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            'user_name' => [
                'string',
                'nullable',
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
                'nullable',
                'string',
                'min:3',
                'max:10',
                'unique:users,phone'
            ],
            'promotion_year' => [
                'nullable',
                'integer',
                'min:2000',
                'max:3000'
            ],
            'password' => [
                'required',
                'confirmed'
            ],
            'birth_date' => [
                'required',
                'date',
                'before:today'
            ],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        try{

            Member::create([
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'contributor' => 0,
                'class' => $request->promotion_year,
                'birth_date' => $request->birth_date,
                'sector' => Sector::find($request->sector)->short_name,
            ]);

        }catch (\Exception $e){
            return view('auth.register-fail',[
                'message' => 'An error occurred while creating the member (bde)',
                'error' => $e->getMessage()
            ]);
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
            return view('auth.register-fail',[
                'message' => 'An error occurred while creating the user (app)',
                'error' => $e->getMessage()
            ]);
        }


        $token = $user->createToken('auth_token')->plainTextToken;

        // add the expo token to the user
        $user->expo_token = $request->expo_token;

        event(new Registered($user));

        return view('auth.register-success', [
            'name' => $request->first_name,
            'email' => $request->email,
        ]);
    }
}
