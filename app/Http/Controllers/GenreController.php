<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index() {

        $genres = Genre::all(); //Mengambil semua data genre dari tabel genres

        if ($genres->isEmpty()) { //Cek apakah data buku kosong
            return response()->json([
                'success' => true,
                'message' => 'Genre is empty'
            ], 200); //Jika data kosong, kembalikan response dengan pesan "Book is empty"
        }

        // Menampilkan data genre dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get all genre',
            'data'    => $genres  
        ], 200);
    }

    public function store(Request $request) {
        // 1. Validator
        $Validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // 2. Check validator error atau tidak
        if ($Validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $Validator->errors()
            ], 422); //Jika ada error, kembalikan response dengan pesan error
        }
        
        // 3. Upload image (Tidak ada upload image untuk genre)

        // 4. Insert data
        $genre = Genre::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        // 5. response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully',
            'data'    => $genre
        ], 201); //201 = Created
    }

    public function show($id) {
        $genre = Genre::find($id); //Mencari data buku berdasarkan id

        if (!$genre) { //Cek apakah data buku ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Genre not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "genre not found"
        }

        // Menampilkan data genre dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get genre by id',
            'data'    => $genre
        ], 200);
    }

    public function update(Request $request, string $id) {
        // 1. Mencari data Genre
        $genre = Genre::find($id);

        if (!$genre) { //Cek apakah data buku ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Genre not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Genre not found"
        }

        // 2. Validator
        $Validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $Validator->errors()
            ], 422); //Jika ada error, kembalikan response dengan pesan error
        }

        // 3. Siapkan data untuk diupdate
        $data = [
            'name'        => $request->name,
            'description' => $request->description
        ];

        // 4. Handle image (upload dan delete jika ada)

        // 5. Update data
        $genre->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully',
            'data'    => $genre
        ], 200);
    }

    public function destroy(string $id) {
        $genre = Genre::find($id); //Mencari data buku berdasarkan id

        if (!$genre) { //Cek apakah data buku ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Genre not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Genre not found"
        }

        // Menghapus data buku
        $genre->delete();

        // Menampilkan response dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Resource deleted successfully'
        ], 200);
    }
}
