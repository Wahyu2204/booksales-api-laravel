<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Manggil controller dari folder Http/Controllers
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Memakai Route Native
// Manggil BookController dari file BookController.php
// Route::get ('/books', [BookController::class, 'index']);
// Route::post ('/books', [BookController::class, 'store']);
// Route::get ('/books/{id}', [BookController::class, 'show']);
// Route::post ('/books/{id}', [BookController::class, 'update']);
// Route::delete('/books/{id}', [BookController::class, 'destroy']);

// Memakai Route Resource
// Route::Resource('/books', BookController::class); //web.php
Route::apiResource('/books', BookController::class); //api.php

// Manggil GenreController dari file GenreController.php
// Route::get ('/genres', [GenreController::class, 'index']);
// Route::get ('/genres/{id}', [GenreController::class, 'show']);
// Route::post ('/genres', [GenreController::class, 'store']);
// Route::post ('/genres/{id}', [GenreController::class, 'update']);
// Route::delete('/genres/{id}', [GenreController::class, 'destroy']);

// Memakai Route Resource
// Route::Resource('/genres', GenreController::class); //web.php
Route::apiResource('/genres', GenreController::class); //api.php

// Manggil AuthorController dari file AuthorController.php
// Route::get ('/authors', [AuthorController::class, 'index']);
// Route::get ('/authors/{id}', [AuthorController::class, 'show']);
// Route::post ('/authors', [AuthorController::class, 'store']);
// Route::post ('/authors/{id}', [AuthorController::class, 'update']);
// Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);

// Memakai Route Resource
// Route::Resource('/authors', AuthorController::class); //web.php
Route::apiResource('/authors', AuthorController::class); //api.php