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

// DA IL NOME 'admin' ALLE ROUTES DEFINITE TRAMITE User\AdminController
Route::resource('admin', AdminController::class);
//QUESTO CI PERMETTE DI RIDIRIGERE I LINK USANDO AD ESEMPIO: href="{{ route('admin.create') }}", href="{{ route('admin.index') }}" OPPURE  href="{{ route('comics.show', $comic->id) }}"

// INDICA CHE LA ROUTE '/' CORRISPONDE AL METODO 'index' DI User\PageController
// SE PageController FOSSE SOSTITUITO CON AdminController LA PAGINA INIZIALE SAREBBE LA DASHBOARD DELL'ADMIN CON LA TABELLA
Route::get('/', [PageController::class, 'index'])->name('comics');

/*  */

// ORIGINAL
/* Route::get('/characters', function () {
    return view('characters');
})->name('characters'); */

// ROUTE CHARACTERS USING PAGE CONTROLLER. INDICA CHE LA ROUTE VIENE GESTITA DAL METODO characters IN User\PageController CHE RESTITUISCE LA VIEW 'character' (characters.blade.php)
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
