<?php

namespace App\Http\Controllers;

// Memanggil model Author dari folder Models
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index() {

        $data = new Author(); //Membuat onjek dari model Author
        $authors = $data->getAuthors(); //Mengakses method getAuthors dari model Author

        return view('author', ['authors' => $authors]); //Mengirim data author ke view author.blade.php
    }
}
