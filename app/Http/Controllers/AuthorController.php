<?php

namespace App\Http\Controllers;

// Memanggil model Author dari folder Models
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index() {

        $authors = Author::all(); //Mengambil semua data author dari tabel authors

        // Menampilkan data author dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get all author',
            'data'    => $authors 
        ], 200);
    }
}
