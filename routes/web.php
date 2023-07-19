<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
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

Route::get('cas', function (){
    $config = Cas()->getConfig();

    dd($config);
});

Route::get('/password-reset/{token}', [NewPasswordController::class, 'index'])
    ->name('password.reset');

Route::post('/password-reset/{token}', [NewPasswordController::class, 'store'])
    ->name('password.reset.store');

