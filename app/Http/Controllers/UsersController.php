<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;


class UsersController extends Controller
{
    /**
	 * Get data for welcome page.
	 */
    public function users()
    {
        $users = DB::select('select * from users');
        $users = json_decode(json_encode($users), true);
        return view('users', compact('users'));
    }
}
