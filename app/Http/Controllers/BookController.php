<?php

namespace App\Http\Controllers;

// Memanggil model Book dari folder Models
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {

        $data = new Book(); //Membuat onjek dari model Book
        $books = $data->getBooks(); //Mengakses method getBooks dari model Book

        return view('books', ['books' => $books]); //Mengirim data buku ke view books.blade.php
    }
}
