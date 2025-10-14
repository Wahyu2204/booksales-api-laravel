<?php

namespace App\Http\Controllers;

// Memanggil model Book dari folder Models
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {

        $books = Book::all(); //Mengambil semua data buku dari tabel books
        
        return view('books', ['books' => $books]); //Mengirim data buku ke view books.blade.php
    }
}
