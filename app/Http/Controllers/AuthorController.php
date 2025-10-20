<?php

namespace App\Http\Controllers;

// Memanggil model Author dari folder Models
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

    public function show($id) {
        $author = Author::find($id); //Mencari data buku berdasarkan id

        if (!$author) { //Cek apakah data buku ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Author not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Book not found"
        }

        // Menampilkan data genre dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get Author by id',
            'data'    => $author
        ], 200);
    }

    public function update(Request $request, string $id) {
        // 1. Mencari data Author
        $author = Author::find($id);

        if (!$author) { //Cek apakah data buku ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Author not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Book not found"
        }

        // 2. Validator
        $Validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'bio'   => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $Validator->errors()
            ], 422); //Jika ada error, kembalikan response dengan pesan error
        }

        // 3. Siapkan data untuk diupdate
        $data = [
            'name'  => $request->name,
            'bio'   => $request->bio,
        ];

        // 4. Handle image (upload dan delete jika ada)
        if ($request->hasFile('photo')) {
            // Hapus file gambar lama jika ada
            if ($author->photo) {
                Storage::disk('public')->delete('authors/' . $author->photo);
            }

            // Upload file gambar baru
            $image = $request->file('photo');
            $image->store('authors', 'public');
            $data['photo'] = $image->hashName();
        }

        // 5. Update data
        $author->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully',
            'data'    => $author
        ], 200);
    }

    public function destroy(string $id) {
        $author = Author::find($id); //Mencari data buku berdasarkan id

        if (!$author) { //Cek apakah data buku ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Author not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Book not found"
        }

        if ($author->photo) {
            // Menghapus file gambar dari storage
            Storage::disk('public')->delete('authors/' . $author->photo);
        }

        // Menghapus data buku
        $author->delete();

        // Menampilkan response dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Resource deleted successfully'
        ], 200);
    }
}
