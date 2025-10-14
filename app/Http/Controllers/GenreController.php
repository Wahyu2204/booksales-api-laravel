<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index() {

        $genres = Genre::all(); //Mengambil semua data genre dari tabel genres

        return view('genres', ['genres' => $genres]); //Mengirim data genre ke view genres.blade.php
    }
}
