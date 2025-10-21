<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Manggil controller dari folder Http/Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\TransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ----------------------------------------------------------------
// Route untuk Login, Register, Logout
//-----------------------------------------------------------------

Route::post ('/register', [AuthController::class, 'register']);
Route::post ('/login', [AuthController::class, 'login']);
Route::post ('/logout', [AuthController::class, 'logout']) -> middleware('auth:api');

// ----------------------------------------------------------------
// Route untuk Authentication
//-----------------------------------------------------------------

Route::middleware(['auth:api'])->group(function () {

    Route::apiResource('/transactions', TransactionController::class) -> only(['store', 'update' , 'show']); //api.php

    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('/books', BookController::class) -> only(['store', 'update', 'destroy']);
        Route::apiResource('/genres', GenreController::class) -> only(['store', 'update', 'destroy']);
        Route::apiResource('/authors', AuthorController::class) -> only(['store', 'update', 'destroy']);
        Route::apiResource('/transactions', TransactionController::class) -> only(['index', 'destroy']);
    });
});

// ----------------------------------------------------------------
// Route untuk Before Auth Middleware
//-----------------------------------------------------------------

// Memakai Route Native
// Manggil BookController dari file BookController.php
// Route::get ('/books', [BookController::class, 'index']);
// Route::post ('/books', [BookController::class, 'store']);
// Route::get ('/books/{id}', [BookController::class, 'show']);
// Route::post ('/books/{id}', [BookController::class, 'update']);
// Route::delete('/books/{id}', [BookController::class, 'destroy']);

// Memakai Route Resource
// Route::Resource('/books', BookController::class); //web.php
Route::apiResource('/books', BookController::class) -> only(['index', 'show']); //api.php

// Manggil GenreController dari file GenreController.php
// Route::get ('/genres', [GenreController::class, 'index']);
// Route::get ('/genres/{id}', [GenreController::class, 'show']);
// Route::post ('/genres', [GenreController::class, 'store']);
// Route::post ('/genres/{id}', [GenreController::class, 'update']);
// Route::delete('/genres/{id}', [GenreController::class, 'destroy']);

// Memakai Route Resource
// Route::Resource('/genres', GenreController::class); //web.php
Route::apiResource('/genres', GenreController::class) -> only(['index', 'show']); //api.php

// Manggil AuthorController dari file AuthorController.php
// Route::get ('/authors', [AuthorController::class, 'index']);
// Route::get ('/authors/{id}', [AuthorController::class, 'show']);
// Route::post ('/authors', [AuthorController::class, 'store']);
// Route::post ('/authors/{id}', [AuthorController::class, 'update']);
// Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);

// Memakai Route Resource
// Route::Resource('/authors', AuthorController::class); //web.php
Route::apiResource('/authors', AuthorController::class) -> only(['index', 'show']); //api.php

// Manggil TransactionController dari file TransactionController.php
// Route::apiResource('/transactions', TransactionController::class); //api.php