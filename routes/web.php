<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';


Route::resource('book', App\Http\Controllers\BookController::class);

Route::resource('collection', App\Http\Controllers\CollectionController::class);

Route::resource('note', App\Http\Controllers\NoteController::class);

Route::resource('commentaire', App\Http\Controllers\CommentaireController::class);