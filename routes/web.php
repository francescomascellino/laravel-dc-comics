<?php

use App\Http\Controllers\Admin\ComicController;
use App\Http\Controllers\Guests\PageController;
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

// DA L'URi admin/comics ALLE ROUTES DEFINITE TRAMITE Admin\ComicController
Route::resource('admin/comics', ComicController::class);
// UNA RISORSA CI PERMETTE DI DIRIGERE I LINK USANDO AD ESEMPIO: href="{{ route('comics.create') }}", href="{{ route('comics.index') }}" OPPURE  href="{{ route('comics.show', $comic->id) }}"

// USANDO UN VALORE PASSATO NELLA ROUTE E' POSSIBILE CREARE PAGINE DINAMICHE SE IL VALORE CORRISPONDE A UN ELEMENTO DI UN ARRAY.
// IN QUESTO CASO CREIAMO UNA ROUTE /comic_detail/{COMIC} (vedi PageController METODO comic_details)
// https://laravel.com/docs/10.x/routing#generating-urls-to-named-routes
Route::get('comic_details/{comic}', [PageController::class, 'comic_details'])->name('details');

// ROUTES NAVBAR

Route::get('/', [PageController::class, 'welcome'])->name('comics');

// ORIGINAL
/* Route::get('/characters', function () {
    return view('characters');
})->name('characters'); */

// ROUTE CHARACTERS USING PAGE CONTROLLER. INDICA CHE LA ROUTE VIENE GESTITA DAL METODO characters IN Guests\PageController CHE RESTITUISCE LA VIEW 'character' (characters.blade.php)
Route::get('/characters', [PageController::class, 'characters'])->name('characters');

// OLD NAVBAR ROUTES DA INSERIIRE NEL CONTROLLER
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
