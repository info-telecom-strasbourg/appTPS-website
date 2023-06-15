<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreateArticleController;
use App\Http\Controllers\FouailleController;
use App\Http\Controllers\Api\ApiFouailleController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AppLoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CalendarController;


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

Route::get('/', [WelcomeController::class, 'welcome'])->middleware('cas:authenticated');

Route::get('/fouaille', [FouailleController::class, 'show'])->middleware('cas:authenticated');

Route::prefix('/post')->group(function () {
    Route::get('/create', [PostController::class, 'index']);
});

Route::post('/admin-view', [WelcomeController::class, 'toggle_view'])->middleware('cas:admin');

Route::post('/modify-erased-article', [WelcomeController::class, 'erased'])->middleware('cas:authenticated');

Route::get('/app-login', [AppLoginController::class, 'login'])->middleware('cas:student');

Route::get('/users', [UsersController::class, 'users'])->middleware('cas:admin');

Route::post('/update-user', [UsersController::class, 'update'])->name('users.update')->middleware('cas:admin');


Route::post('/send-article', [CreateArticleController::class, 'store'])->name('create-article.store')->middleware('cas:authenticated');

Route::post('/modify-article', [CreateArticleController::class, 'update'])->middleware('cas:authenticated');

//Do not add cas middlware here.
Route::get('/authentication-failed', function () {
    return view('CAS.authenticationFailed');
});

//Do not add cas middleware here.
Route::get('/logout', function () {
    return view('/logout');
});

Route::group(['prefix' => 'logo-manager', 'middleware' => 'cas:admin'], function (){
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/logos', function () {
    return view('logos');
})->middleware('cas:authenticated');

Route::get('/test', [CalendarController::class, 'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
