<?php


use App\Http\Controllers\Web\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Web\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Web\Auth\AdminController as AuthAdminController;
use App\Http\Controllers\Web\Auth\UserController as AuthUserController;
use App\Http\Controllers\Web\User\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::auto('/', HomeController::class);


Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthUserController::class, 'get']);
    Route::post('/login', [AuthUserController::class, 'post_login']);
    Route::post('/register', [AuthUserController::class, 'post_register']);
    Route::get('/google', [AuthUserController::class, 'google_redirect']);
    Route::get('/google/callback', [AuthUserController::class, 'google_callback']);

    Route::middleware('auth')->group(function () {
        Route::get('/me', [AuthUserController::class, 'get_me']);
        Route::post('/logout', [AuthUserController::class, 'logout']);
    });
    
});


Route::prefix('admin')->group(function () {
    Route::auto('/', AdminHomeController::class);
    Route::middleware('auth:admin')->group(function () {
        Route::auto('/movie', AdminMovieController::class);
    });

    Route::prefix('auth')->group(function () {
        Route::get('/login', [AuthAdminController::class, 'get_index']);
        Route::post('/login', [AuthAdminController::class, 'post_login']);
        Route::middleware('auth:admin')->group(function () {
            Route::get('/me', [AuthAdminController::class, 'get_me']);
            Route::post('/logout', [AuthAdminController::class, 'logout']);
        });

    });
});
