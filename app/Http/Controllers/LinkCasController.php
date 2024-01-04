<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Subfission\Cas\Facades\Cas;
use Illuminate\Support\Facades\Auth;

class LinkCasController extends Controller
{    
    public function index(Request $request){
        if (Cas()->isAuthenticated()) {
            $user = $request->user();
            $user->unistra_id = Cas()->getAttributes()['uid'];
            $user->update();
            $cas_infos = Cas()->getAttributes();
            return view('cas', compact('cas_infos'));
        } else {
            Cas()->authenticate();
            return "ok";
        }
    }
}
