<?php

namespace App\Http\Controllers;

// Memanggil model Book dari folder Models
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

    public function show($id) {
        $book = Book::find($id); //Mencari data buku berdasarkan id

        if (!$book) { //Cek apakah data buku ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Book not found"
        }

        // Menampilkan data genre dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get book by id',
            'data'    => $book
        ], 200);
    }

    public function update(Request $request, string $id) {
        // 1. Mencari data buku
        $book = Book::find($id);

        if (!$book) { //Cek apakah data buku ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Book not found"
        }

        // 2. Validator
        $Validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genre_id'    => 'required|exists:genres,id',
            'author_id'   => 'required|exists:authors,id'
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $Validator->errors()
            ], 422); //Jika ada error, kembalikan response dengan pesan error
        }

        // 3. Siapkan data untuk diupdate
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'genre_id'    => $request->genre_id,
            'author_id'   => $request->author_id
        ];

        // 4. Handle image (upload dan delete jika ada)
        if ($request->hasFile('cover_photo')) {
            // Hapus file gambar lama jika ada
            if ($book->cover_photo) {
                Storage::disk('public')->delete('books/' . $book->cover_photo);
            }

            // Upload file gambar baru
            $image = $request->file('cover_photo');
            $image->store('books', 'public');
            $data['cover_photo'] = $image->hashName();
        }

        // 5. Update data
        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully',
            'data'    => $book
        ], 200);
    }

    public function destroy(string $id) {
        $book = Book::find($id); //Mencari data buku berdasarkan id

        if (!$book) { //Cek apakah data buku ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Book not found"
        }

        if ($book->cover_photo) {
            // Menghapus file gambar dari storage
            Storage::disk('public')->delete('books/' . $book->cover_photo);
        }

        // Menghapus data buku
        $book->delete();

        // Menampilkan response dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Resource deleted successfully'
        ], 200);
    }
}
