<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Simulasi data buku
    private $books = [
        [
            'title' => 'Pulang',
            'description' => 'Petualangan seorang pemuda yang kembali ke desa kelahirannya.',
            'price' => 40000,
            'stock' => 15,
            'cover_photo' => 'pulang.jpg',
            'genre_id' => 1,
            'author_id' => 1
        ],
        [
            'title' => 'Sebuah Seni Untuk Bersikap Bodo Amat',
            'description' => 'Buku yang membahas tentang kehidupan dan filosofi hidup seseorang.',
            'price' => 25000,
            'stock' => 5,
            'cover_photo' => 'sebuah_seni.jpg',
            'genre_id' => 2,
            'author_id' => 2
        ],
        [
            'title' => 'Naruto',
            'description' => 'Buku yang membahas tentang jalan ninja seseorang.',
            'price' => 30000,
            'stock' => 10,
            'cover_photo' => 'naruto.jpg',
            'genre_id' => 3,
            'author_id' => 3
        ],
        [
            'title' => 'Seporsi Mie Ayam Sebelum Mati',
            'description' => 'Sebuah permintaan terakhir yang sederhana.',
            'price' => 80000,
            'stock' => 10,
            'cover_photo' => 'mie_ayam.jpg',
            'genre_id' => 3,
            'author_id' => 3
        ],
        [
            'title' => 'The Psychology of Money',
            'description' => 'Kesuksesan dalam mengelola keuangan.',
            'price' => 30000,
            'stock' => 10,
            'cover_photo' => 'naruto.jpg',
            'genre_id' => 3,
            'author_id' => 3
        ]
    ];

    // Method untuk mendapatkan semua data buku
    public function getBooks() {
        return $this->books;
    }
}
