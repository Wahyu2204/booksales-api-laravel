<?php

use Illuminate\Support\Facades\Route;

// Manggil controller dari folder Http/Controllers
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;

Route::get('/', function () {
    return view('welcome');
});

