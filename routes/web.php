<?php

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

Route::resource('comics', PageController::class);

/* Route::get('/', function () {
    return view('welcome');
}); */




// Route::get('/', [PageController::class, 'comics.index'])->name('index');
Route::get('/', [PageController::class, 'index'])->name('index');