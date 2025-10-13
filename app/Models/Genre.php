<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    //Model untuk data genre
    private $genres = [
        [
            'name' => 'Slice of Life',
            'description' => 'Cerita yang menggambarkan kehidupan sehari-hari dengan segala lika-likunya.'
        ],
        [
            'name' => 'Fantasy',
            'description' => 'Cerita yang mengandung unsur-unsur magis, dunia imajinatif, dan makhluk-makhluk fantastis.'
        ],
        [
            'name' => 'Romance',
            'description' => 'Cerita yang berfokus pada hubungan asmara antara karakter utama.'
        ],
        [
            'name' => 'School',
            'description' => 'Cerita yang berlatar belakang kehidupan di sekolah, baik itu sekolah menengah maupun perguruan tinggi.'
        ],
        [
            'name' => 'Non-Fiction',
            'description' => 'Cerita yang berdasarkan fakta nyata dan informasi yang dapat dipercaya.'
        ]
    ];

    // Method untuk mendapatkan semua data genre
    public function getGenres() {
        return $this->genres;
    }
}
