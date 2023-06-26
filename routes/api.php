<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FouailleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\Post\PostController;

use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register');

Route::post('/login', [AuthUserController::class, 'login'])
    ->name('login');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

/*Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');*/



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthUserController::class, 'logout'])
        ->name('logout');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::group(['middleware' => ['verified']], function () {

        Route::prefix('user')->group(function () {

            Route::get('/', [UserController::class, 'show']);

            Route::put('/', [UserController::class, 'update']);
        });

        Route::get('/fouaille', [FouailleController::class, 'show'])
            ->name('fouaille.details');

        Route::prefix('event')->group(function () {
            Route::get('/', [EventController::class, 'index']);

            Route::get('/{id}', [EventController::class, 'show']);

            Route::post('/', [EventController::class, 'store']);
        });

    });

});

Route::prefix('organization')->group(function () {
    Route::get('/', [OrganizationController::class, 'index']);

    Route::get('/{id}', [OrganizationController::class, 'show']);
});

Route::prefix('post')->group(function () {
    Route::post('/', [PostController::class, 'store']);

    Route::get('/', [PostController::class, 'index']);
});

Route::get('cas', function (){
    dd(cas()->getConfig());
});
