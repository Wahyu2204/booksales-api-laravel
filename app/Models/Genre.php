<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    // Menentukan nama tabel yang digunakan oleh model Genre
    protected $table = 'genres'; // Nama tabel

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'name', 
        'description'
    ];
}
