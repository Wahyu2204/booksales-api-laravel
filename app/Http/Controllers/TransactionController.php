<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index() {
        
        $transactions = Transaction::with('user', 'book') -> get(); //Mengambil semua data transaksi dari tabel transactions

        if ($transactions->isEmpty()) { //Cek apakah data transaksi kosong
            return response()->json([
                'success' => true,
                'message' => 'Transaction is empty'
            ], 200); //Jika data kosong, kembalikan response dengan pesan "Transaction is empty"
        }

        // Menampilkan data transaksi dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get all transactions',
            'data'    => $transactions
        ], 200);
    }

    public function store (Request $request) {

        // 1. Validator dan Cek validator
        $validator = Validator::make($request->all(), [
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data'  => $validator->errors()
            ], 422); //Jika ada error, kembalikan response dengan pesan error
        }

        // 2. generate orderNumber -> unique
        $uniqueCode = "ORD-" . strtoupper(uniqid());

        // 3. Ambil user yang sedang login dan cek login (apakah ada data user?)
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401); //Jika tidak ada data user, kembalikan response dengan pesan "Unauthenticated"
        }

        // 4. Mencari data buku dari request
        $book = Book::find($request->book_id);

        // 5. Cek stok buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock tidak mencukupi',
            ], 400); //Jika stok tidak mencukupi, kembalikan response dengan pesan "Insufficient stock"
        }

        // 6. Hitung total harga = price * quantity
        $totalAmount = $book->price * $request->quantity;

        // Gunakan DB Transaction untuk 'store' juga agar aman
        try {
            $transaction = DB::transaction(function () use ($book, $request, $uniqueCode, $user, $totalAmount) {
                
                // 7. Kurangi stok buku (update)
                $book->stock -= $request->quantity;
                $book->save();

                // 8. Simpan data transaksi
                $newTransaction = Transaction::create([
                    'order_number'  => $uniqueCode,
                    'customer_id'   => $user->id,
                    'book_id'       => $request->book_id,
                    'quantity'      => $request->quantity,
                    'total_amount'  => $totalAmount
                ]);

                return $newTransaction;
            });

            // 9. Kembalikan response dalam bentuk json
            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data'    => $transaction
            ], 201);

        } catch (\Exception $e) {
            // Jika terjadi error saat transaksi
            return response()->json([
                'success' => false,
                'message' => 'Transaction failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id) {
        $transactions = Transaction::with('user', 'book')->find($id); //Mencari data transaksi berdasarkan id

        if (!$transactions) { //Cek apakah data transaksi ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Book not found"
        }

        // Menampilkan data genre dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Get transaction by id',
            'data'    => $transactions
        ], 200);
    }

    public function update(Request $request, string $id) {

        // 1. Validator dan Cek validator
        $validator = Validator::make($request->all(), [
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data'  => $validator->errors()
            ], 422); //Jika ada error, kembalikan response dengan pesan error
        }

        // 2. Ambil user yang sedang login dan cek login (apakah ada data user?)
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401); //Jika tidak ada data user, kembalikan response dengan pesan "Unauthenticated"
        }

        // 3. Gunakan DB Transaction
        try {
            // Mulai transaction, $updatedTransaction akan diisi jika sukses
            $updatedTransaction = DB::transaction(function () use ($request, $id) {

                // 4. Cari transaksi di dalam transaction (gunakan lockForUpdate)
                $transaction = Transaction::lockForUpdate()->find($id);

                if (!$transaction) {
                    // Gunakan exception untuk me-rollback transaction
                    throw new \Exception('Transaction not found'); 
                }

                // 5. Kembalikan stok buku lama
                $oldBook = Book::lockForUpdate()->find($transaction->book_id);
                if ($oldBook) {
                    $oldBook->stock += $transaction->quantity; // Ini sudah benar berkat perbaikan di store
                    $oldBook->save();
                }

                // 6. Mencari data buku baru dari request
                $newBook = Book::lockForUpdate()->find($request->book_id);

                // 7. Cek stok buku baru
                if ($newBook->stock < $request->quantity) {
                    // Stok tidak cukup, batalkan semua (rollback)
                    throw new \Exception('Stock tidak mencukupi');
                }

                // 8. Hitung total harga baru
                $totalAmount = $newBook->price * $request->quantity;

                // 9. Kurangi stok buku baru
                $newBook->stock -= $request->quantity;
                $newBook->save();

                // 10. Update data transaksi
                $transaction->update([
                    'book_id'      => $request->book_id,
                    'quantity'     => $request->quantity,
                    'total_amount' => $totalAmount
                ]);
                
                // Load relasi terbaru
                $transaction->load('user', 'book');

                return $transaction; // Kembalikan data transaksi yang sudah di-update
            });

            // 11. Jika transaction sukses
            return response()->json([
                'success' => true,
                'message' => 'Transaction updated successfully',
                'data'    => $updatedTransaction
            ], 200);

        } catch (\Exception $e) {
            // 12. Tangani jika ada error (misal 'Stock tidak mencukupi' atau 'Transaction not found')
            $errorCode = $e->getMessage() === 'Transaction not found' ? 404 : 400;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $errorCode);
        }
    }

    public function destroy($id) {
        $transactions = Transaction::find($id); //Mencari data transaksi berdasarkan id

        if (!$transactions) { //Cek apakah data transaksi ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404); //Jika data tidak ditemukan, kembalikan response dengan pesan "Book not found"
        }

        $transactions->delete(); //Menghapus data transaksi

        // Menampilkan response dalam bentuk json
        return response()->json([
            'success' => true,
            'message' => 'Resource deleted successfully'
        ], 200);
    }
}
