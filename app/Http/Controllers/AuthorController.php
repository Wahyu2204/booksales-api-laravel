<?php

namespace App\Http\Controllers;

// Memanggil model Author dari folder Models
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index() {

        $authors = Author::all(); //Mengambil semua data author dari tabel authors

        return view('author', ['authors' => $authors]); //Mengirim data author ke view author.blade.php
    }
}
