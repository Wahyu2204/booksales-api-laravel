<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index() {

        $data = new Genre(); //Membuat onjek dari model Genre
        $genres = $data->getGenres(); //Mengakses method getGenres dari model Genre

        return view('genres', ['genres' => $genres]); //Mengirim data genre ke view genres.blade.php
    }
}
