<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Subfission\Cas\Facades\Cas;

class LinkCasController extends Controller
{
    public function index(Request $request){
        Cas()->authenticate();
    }
}
