<?php

use App\Http\Controllers\Auth\NewPasswordController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
})->name("home");

Route::get('cas', function (Request $request){
    dd(cas()->getConfig());
});

Route::get('/password-reset/{token}', [NewPasswordController::class, 'index']);

Route::post('/password-reset/{token}', [NewPasswordController::class, 'store']);
