<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //
    private $authors = [
        [
            'name' => 'John Doe',
            'photo' => 'johndoe.jpg',
            'bio' => 'John Doe adalah seorang penulis fiksi ilmiah yang terkenal dengan karyanya yang mendalam dan imajinatif.'
        ],
        [
            'name' => 'Jane Smith',
            'photo' => 'janesmith.jpg',
            'bio' => 'Jane Smith adalah seorang penulis romance yang karyanya sering kali mengangkat tema cinta dan hubungan antar manusia.'
        ],
        [
            'name' => 'Alice Johnson',
            'photo' => 'alicejohnson.jpg',
            'bio' => 'Alice Johnson adalah seorang penulis non-fiksi yang fokus pada topik sejarah dan budaya.'
        ],
        [
            'name' => 'Michael Brown',
            'photo' => 'michaelbrown.jpg',
            'bio' => 'Michael Brown adalah seorang penulis fantasi yang menciptakan dunia-dunia magis yang memukau pembacanya.'
        ],
        [
            'name' => 'Emily Davis',
            'photo' => 'emilydavis.jpg',
            'bio' => 'Emily Davis adalah seorang penulis slice of life yang menggambarkan kehidupan sehari-hari dengan segala lika-likunya.'
        ]
    ];

    // Method untuk mendapatkan semua data author
    public function getAuthors() {
        return $this->authors;
    }
}
