<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Menentukan nama tabel yang digunakan oleh model Book
    protected $table = 'books'; // Nama tabel

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'title', 
        'description', 
        'price', 
        'stock', 
        'cover_photo',
        'genre_id',
        'author_id'
    ];
}
