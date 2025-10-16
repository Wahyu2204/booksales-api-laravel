<?php

namespace App\Http\Controllers;

// Memanggil model Author dari folder Models
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index() {

        $authors = Author::all(); //Mengambil semua data author dari tabel authors

        if ($authors->isEmpty()) { //Cek apakah data buku kosong
            return response()->json([
                'success' => true,
                'message' => 'Author is empty'
            ], 200); //Jika data kosong, kembalikan response dengan pesan "Author is empty"
        }

        // Menampilkan data author dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get all author',
            'data'    => $authors 
        ], 200);
    }

    public function store(Request $request) {
        // 1. Validator
        $Validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'bio'   => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // 2. Check validator error atau tidak
        if ($Validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $Validator->errors()
            ], 422); //Jika ada error, kembalikan response dengan pesan error
        }
        
        // 3. Upload image
        $image = $request->file('photo');
        $image->store('authors', 'public');

        // 4. Insert data
        $author = Author::create([
            'name'  => $request->name,
            'bio'   => $request->bio,
            'photo' => $image->hashName()
        ]);

        // 5. response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully',
            'data'    => $author
        ], 201); //201 = Created
    }
}
