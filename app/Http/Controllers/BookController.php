<?php

namespace App\Http\Controllers;

// Memanggil model Book dari folder Models
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {

        $books = Book::all(); //Mengambil semua data buku dari tabel books
        
        // Menampilkan data genre dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get all book',
            'data'    => $books
        ], 200);
    }
}
