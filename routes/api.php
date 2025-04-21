<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

#Public

Route::apiResource('books', AuthorController::class);

#Route::apiResource('/api/books/{id}', [BookController::class, '']);

#Route::apiResource('/api/authors', [AuthorController::class, '']);

#Route::apiResource('/api/authors/{id}', [AuthorController::class, '']);

#Route::apiResource('/api/genres', [AuthorController::class, '']);

#Authors

Route::prefix('/author')->middleware('auth:sanctum')->group(function () {

});



#Admin

Route::prefix('/admin')->middleware('auth:sanctum')->group(function () {

});