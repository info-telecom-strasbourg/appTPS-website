<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreateArticleController;
use App\Http\Controllers\FouailleController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AppLoginController;


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

Route::get('/api', [FouailleController::class, 'api']);

Route::get('/', [WelcomeController::class, 'welcome'])->middleware('cas:authenticated');

Route::get('/app-fouaille', [FouailleController::class, 'app_fouaille'])/* ->middleware('cas:authenticated') */;

Route::get('/fouaille', [FouailleController::class, 'fouaille'])->middleware('cas:authenticated');

Route::get('/articles-hidden-json', [WelcomeController::class, 'app_articles']);

Route::post('/gestion-article', [WelcomeController::class, 'available'])->middleware('cas:authenticated');

Route::post('/admin-view', [WelcomeController::class, 'toggle_view'])->middleware('cas:admin');

Route::post('/modify-erased-article', [WelcomeController::class, 'erased'])->middleware('cas:authenticated');

Route::get('/app-login', [AppLoginController::class, 'login'])->middleware('cas:student');

Route::get('/users', [UsersController::class, 'users'])->middleware('cas:admin');

Route::post('/update-user', [UsersController::class, 'update'])->name('users.update')->middleware('cas:admin');

Route::get('/create-article', [CreateArticleController::class, 'index'])->middleware('cas:authenticated');

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