<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes(['register' => false]);

Route::group(['middleware' => ['is-new']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    Route::controller(ShortUrlController::class)->group(function () {
        Route::get('/r/{short_url}', 'redirect')->name('short-url.short-url.redirect');
        Route::group(['prefix' => 'short-url', 'as' => 'short-url.short-url'], function () {
            Route::post('/', 'store')->name('.store');
            Route::get('/{short_url}', 'show')->name('.show');
        });
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::resource('/short-url', ShortUrlController::class, ['except' => ['store', 'show'], 'as' => 'short-url']);
        Route::resource('/user', UserController::class, ['except' => ['edit', 'update'], 'as' => 'user']);
    });
});

Route::group(['middleware' => ['auth']], function () {
    Route::controller(UserController::class)->group(function () {
        Route::group(['prefix' => 'user', 'as' => 'user.user'], function () {
            Route::put('/{user}', 'update')->name('.update');
            Route::get('/{user}/edit', 'edit')->name('.edit');
        });
    });
});
