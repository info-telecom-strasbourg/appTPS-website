<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\Web\RegisterController;
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
    return view("welcome");
    // return ['Laravel' => app()->version()];
})->name("home");

Route::get('cas', function (){
    $config = Cas()->getConfig();

    dd($config);
});

Route::get('/password-reset/{token}', [NewPasswordController::class, 'index'])
    ->name('password.reset');

Route::post('/password-reset/{token}', [NewPasswordController::class, 'store'])
    ->name('password.reset.store');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

Route::get('/register', [RegisterController::class, 'index'])
    ->name('register.index');

