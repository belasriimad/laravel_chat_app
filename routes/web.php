<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth')->group(function(){
    Route::get('/', function () {
        return view('home');
    });
    Route::post('user/logout', [UserController::class, 'logout'])
    ->name('logout');
});

Route::get('user/register', [UserController::class, 'registerForm'])
    ->name('register');

Route::post('user/register', [UserController::class, 'store'])
    ->name('register');

Route::get('user/login', [UserController::class, 'loginForm'])
    ->name('login');

Route::post('user/login', [UserController::class, 'auth'])
    ->name('login');
