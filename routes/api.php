<?php

use App\Http\Controllers\CGUController;
use App\Http\Controllers\CrousController;
use App\Http\Controllers\CTSController;
use App\Http\Controllers\LinkCasController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UserAvatarController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FouailleController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Content\ContentController;
use App\Http\Controllers\Content\EventController;
use App\Http\Controllers\Content\PostController;

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


/** =============== Authentification =============== */

Route::prefix('register')->group(function (){
    Route::post('/', [RegisteredUserController::class, 'store'])
        ->name('register');

    Route::get('availability', [RegisteredUserController::class, 'availability'])
    ->name('register.availability');
});

Route::post('/login', [AuthUserController::class, 'login'])
    ->middleware(['throttle:6,1'])
    ->name('login');

/** =============== Password verification =============== */

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed'])
    ->name('verification.verify');

/** =============== Forgot password =============== */

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.forgot.send');

/** =============== Open api =============== */

Route::get('sector', [SectorController::class, 'index'])
    ->name('sector.index');

Route::get('crous', [CrousController::class, 'index'])
    ->name('crous.index');


    /** =============== Route protected by sanctum =============== */

    Route::group(['middleware' => ['auth:sanctum']], function () {

        /** =============== Authentification =============== */

    Route::post('/logout', [AuthUserController::class, 'logout'])
    ->name('logout');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->name('verification.send');

    /** =============== Cas link =============== */


    /** =============== Route allowed for verified users (email verification) =============== */

    Route::group(['middleware' => ['verified']], function () {

        Route::get('/check', function () {
            return response()->json([
                'message' => 'You are connected and verified'
            ], 200);
        })->name('check');


        Route::put('/password', [NewPasswordController::class, 'update'])
        ->name('password.update');

        /** =============== User =============== */

        Route::prefix('user')->group(function () {

            Route::get('/me', [UserController::class, 'getMe'])
            ->name('user.me');

            Route::put('/', [UserController::class, 'update'])
            ->name('user.update');

            Route::post('/avatar', [UserAvatarController::class, 'store'])
            ->name('user.avatar.store');

            Route::delete('/', [UserController::class, 'delete'])
            ->name('user.delete');
        });

        /** =============== Fouaille =============== */

        Route::get('/fouaille', [FouailleController::class, 'show'])
        ->name('fouaille.show');


        /** =============== Event =============== */

        Route::prefix('event')->group(function () {
            Route::get('/', [EventController::class, 'index'])
            ->name('event.index');

            Route::get('/{id}', [EventController::class, 'show'])
            ->name('event.show');

            Route::post('/', [EventController::class, 'store'])
            ->name('event.store');
        });


        /** =============== Posts =============== */

        Route::prefix('post')->group(function () {
            Route::post('/', [PostController::class, 'store'])
            ->name('post.store');

            Route::get('/', [PostController::class, 'index'])
            ->name('post.index');

            Route::get('{id}', [PostController::class, 'show'])
            ->name('post.show');
        });

        Route::get('contents/create', [ContentController::class, 'create'])
            ->name('contents.create');

        Route::post('contents', [ContentController::class, 'store'])
            ->name('contents.store');

        /** =============== CTS =============== */

        Route::get('cts', [CTSController::class, 'index'])
            ->name('cts.index');
    });
});


Route::get('cas', [LinkCasController::class, 'index'])
    ->name('cas.index');

Route::get('cgu', [CGUController::class, 'index'])
    ->name('cgu.index');
