<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


#Public

Route::get('/books', [AuthorController::class, '']);

Route::get('/books/{$id}', [BookController::class, '']);

Route::get('/authors', [AuthorController::class, '']);

Route::get('/authors/books', [AuthorController::class, '']);

Route::get('/genres', [AuthorController::class, '']);

#Authors

Route::prefix('/author')->middleware(['auth:sanctum', 'author'])->group(function () {

});



#Admin

Route::prefix('/admin')->middleware(['auth:sanctum', 'admin'])->group(function () {

});
