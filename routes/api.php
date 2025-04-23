<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

#Public zone

Route::apiResource('books', BookController::class)
    ->except([
        'store',
        'update',
        'destroy'
    ]);

Route::apiResource('authors', AuthorController::class)
    ->except([
        'store',
        'update',
        'destroy'
    ]);

Route::apiResource('genres', GenreController::class)
    ->except([
        'store',
        'update',
        'destroy'
    ]);

Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth:sanctum');

#Authors zone

Route::prefix('author')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('books', BookController::class)->parameters([
            'books' => 'book'
        ]);;
        Route::apiResource('authors', AuthorController::class);
    });

//Route::prefix('author')
//    ->middleware(['auth:sanctum', 'role:author'])
//    ->group(function () {
//        Route::apiResource('books', BookController::class)->parameters([
//            'books' => 'book'
//        ]);;
//        Route::apiResource('authors', AuthorController::class);
//    });

//Route::prefix('author')
//    ->group(function () {
//        Route::apiResource('books', BookController::class)->parameters([
//            'books' => 'book'
//        ]);
//        Route::apiResource('authors', AuthorController::class);
//    });


#Admin zone

//Route::prefix('admin')
//    ->middleware(['auth:sanctum', 'role:admin'])
//    ->group(function () {
//        Route::apiResource('books', AdminBookController::class);
//        Route::apiResource('authors', AdminAuthorController::class);
//        Route::apiResource('genres', AdminGenreController::class);
//    });