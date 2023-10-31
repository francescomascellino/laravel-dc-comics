<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\PageController;
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

// DA IL NOME 'comics' ALLE ROUTES DEFINITE TRAMITE User\PageController
Route::resource('comics', PageController::class);

Route::resource('admin', AdminController::class);


/* Route::get('/', function () {
    return view('welcome');
}); */

// Route::get('/', [PageController::class, 'comics.index'])->name('index');

Route::get('/', [PageController::class, 'index'])->name('comics');

/*  */

// OLD
/* Route::get('/characters', function () {
    return view('characters');
})->name('characters'); */

// ROUTE CHARACTERS USING PAGE CONTROLLER
Route::get('/characters', [PageController::class, 'characters'])->name('characters');

// OLD NAVBAR ROUTES
Route::get('/movies', function () {
    return view('movies');
})->name('movies');

Route::get('/tv', function () {
    return view('tv');
})->name('tv');

Route::get('/games', function () {
    return view('games');
})->name('games');

Route::get('/collectibles', function () {
    return view('collectibles');
})->name('collectibles');

Route::get('/videos', function () {
    return view('videos');
})->name('videos');

Route::get('/fans', function () {
    return view('fans');
})->name('fans');

Route::get('/news', function () {
    return view('news');
})->name('news');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');
