<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\GalleryController;


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

Route::get('/', function () {
    return view('auth.dashboard');
});

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/users', 'users')->name('users');
    Route::put('/user/update/{id}', 'update')->name('update');
    Route::get('/user/edit/{id}', 'usersEdit')->name('edit');
});

Route::controller(GalleryController::class)->group(function() {
    Route::resource('gallery', GalleryController::class);
    Route::get('/create', 'create')->name('create');
    Route::delete('delete/{id}', 'destroy')->name('destroy');
    Route::get('edit/{id}', 'edit')->name('edit');
    Route::get('/store', 'store')->name('store');
});


