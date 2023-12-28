<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Subfission\Cas\Facades\Cas;
use Illuminate\Support\Facades\Auth;

class LinkCasController extends Controller
{
    /**
     * This function returns an array with all keys/values returned by the CAS.
     *
     * @return array of attributes.
     */
    public static function getAttributes()
    {
        if (Cas()->isAuthenticated()) {
            return Cas()->getAttributes();
        } else {
            return array();
        }
    }

    public function index(Request $request){
        Cas()->authenticate();
    }

    public function link(Request $request){
        return response()->json($this->getAttributes());
    }
}
