<?php

namespace App\Http\Controllers;

// Memanggil model Book dari folder Models
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index() {

        $books = Book::all(); //Mengambil semua data buku dari tabel books

        if ($books->isEmpty()) { //Cek apakah data buku kosong
            return response()->json([
                'success' => true,
                'message' => 'Book is empty'
            ], 200); //Jika data kosong, kembalikan response dengan pesan "Book is empty"
        }
        
        // Menampilkan data genre dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get all book',
            'data'    => $books
        ], 200);
    }

    public function store(Request $request) {
        // 1. Validator
        $Validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genre_id'    => 'required|exists:genres,id',
            'author_id'   => 'required|exists:authors,id'
        ]);

        // 2. Check validator error atau tidak
        if ($Validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $Validator->errors()
            ], 422); //Jika ada error, kembalikan response dengan pesan error
        }
        
        // 3. Upload image
        $image = $request->file('cover_photo');
        $image->store('books', 'public');

        // 4. Insert data
        $book = Book::create([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'cover_photo' => $image->hashName(),
            'genre_id'    => $request->genre_id,
            'author_id'   => $request->author_id
        ]);

        // 5. response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully',
            'data'    => $book
        ], 201); //201 = Created
    }
}
