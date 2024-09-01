<?php

use App\Http\Controllers\CGUController;
use App\Http\Controllers\Content\CategoryTypeController;
use App\Http\Controllers\Content\MediaController;
use App\Http\Controllers\Content\ReactionController;
use App\Http\Controllers\Content\ReactionTypeController;
use App\Http\Controllers\CrousController;
use App\Http\Controllers\CTSController;
use App\Http\Controllers\LinkCasController;
use App\Http\Controllers\MPSController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UserAvatarController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FouailleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationController;

use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Content\ContentController;
use App\Http\Controllers\Content\EventController;
use App\Http\Controllers\Content\PostController;
use App\Http\Controllers\Content\PostCommentController;
use App\Http\Controllers\Content\CategoryController;

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

            Route::get('/', [UserController::class, 'index'])
            ->name('user.index');

            Route::get('/default', [UserAvatarController::class, 'default'])
                ->name('user.default');

            Route::get('/me', [UserController::class, 'getMe'])
            ->name('user.me');

            Route::get('/{id}', [UserController::class, 'show'])
                ->name('user.show');

            Route::put('/', [UserController::class, 'update'])
            ->name('user.update');

            Route::post('/avatar', [UserAvatarController::class, 'store'])
            ->name('user.avatar.store');

            Route::post('avatar/default', [UserAvatarController::class, 'storedefault'])
                ->name('user.avatar.default');

            Route::delete('/', [UserController::class, 'delete'])
            ->name('user.delete');
        });

        Route::get('cas', [LinkCasController::class, 'index'])
            ->name('cas.index');

        /** =============== Fouaille =============== */

        Route::get('/fouaille', [FouailleController::class, 'show'])
        ->name('fouaille.show');

        Route::get('/fouaille/balance', [FouailleController::class, 'balance'])
            ->name('fouaille.balance');

        /** =============== Catégories =============== */

        Route::get('/categories', [CategoryTypeController::class, 'index'])
            ->name('categories.index');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        /** =============== Event =============== */

        Route::prefix('event')->group(function () {
            Route::get('/', [EventController::class, 'index'])
            ->name('event.index');

            Route::post('/', [EventController::class, 'store'])
                ->name('event.store');

            Route::get('/{id}', [EventController::class, 'show'])
                ->name('event.show');

            Route::get('{id}/delete', [EventController::class, 'delete'])
                ->name('event.delete');
        });

        /** =============== Organisations =============== */

        Route::prefix('organization')->group(function () {
            Route::get('/', [OrganizationController::class, 'index'])
            ->name('organization.index');

            Route::get('/{id}', [OrganizationController::class, 'show'])
            ->name('organization.show');
        });


        /** =============== Posts =============== */

        Route::prefix('post')->group(function () {
            Route::post('/', [PostController::class, 'store'])
            ->name('post.store');

            Route::get('/', [PostController::class, 'index'])
            ->name('post.index');

            Route::get('{id}', [PostController::class, 'show'])
            ->name('post.show');

            Route::get('{id}/delete', [PostController::class, 'delete'])
                ->name('post.delete');

            Route::post('{id}/update', [PostController::class, 'update'])
                ->name('post.update');

            /** =============== Commentaires =============== */

            Route::get('{id}/comment', [PostCommentController::class, 'index'])
            ->name('comment.index');

            Route::post('{id}/comment', [PostCommentController::class, 'store'])
                ->name('comment.store');

            /** =============== Réactions =============== */

            Route::post('{id}/reaction', [ReactionController::class, 'store'])
                ->name('reaction.store');

            Route::get('{id}/reaction', [ReactionController::class, 'index'])
                ->name('reaction.index');

            Route::get('{id}/reactiontype', [ReactionTypeController::class, 'index'])
                ->name('reactiontype.index');

            /** =============== Medias =============== */
            Route::post('{id}/media', [MediaController::class, 'store'])
                ->name('media.store');

            Route::post('{id}/media/destroy', [MediaController::class, 'destroy'])
                ->name('media.destroy');
        });

        /** =============== Contenus =============== */

        Route::post('contents', [ContentController::class, 'store'])
            ->name('contents.store');

        /** =============== CTS =============== */

        Route::get('cts', [CTSController::class, 'index'])
            ->name('cts.index');
        });

        /** =============== MPS =============== */
        Route::get('mps', [MPSController::class, 'index'])
            ->name('mps.index');
});

Route::get('cgu', [CGUController::class, 'index'])
    ->name('cgu.index');
