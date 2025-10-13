<?php

use Illuminate\Support\Facades\Route;

// Manggil controller dari folder Http/Controllers
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;

Route::get('/', function () {
    return view('welcome');
});

// Manggil BookController dari file BookController.php
Route::get ('/books', [BookController::class, 'index']);

// Manggil GenreController dari file GenreController.php
Route::get ('/genres', [GenreController::class, 'index']);

// Manggil AuthorController dari file AuthorController.php
Route::get ('/authors', [AuthorController::class, 'index']);