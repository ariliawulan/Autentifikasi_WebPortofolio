<?php

use App\Http\Controllers\ApiGalleryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GreetController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\GalleryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/info', [InfoController::class, 'index'])->name('info');

Route::get('/greet', [GreetController::class,
'greet'])->name('greet');

Route::get('/galleryapi', [GalleryController::class, 'indexapi']);

Route::get('/getgallery', [ApiGalleryController::class, 'getGallery'])->name('apiGetgallery');
Route::get('/gallery', [ApiGalleryController::class, 'index'])->name('apiListgallery');
Route::get('/creategallery', [ApiGalleryController::class, 'create'])->name('apiCreateGallery');
Route::post('/postGallery', [ApiGalleryController::class, 'postGallery'])->name('apiPostgallery');