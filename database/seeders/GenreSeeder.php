<?php

namespace Database\Seeders;

// Memanggil model Genre dari folder Models
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    // Run the database seeds.
    public function run(): void
    {
        Genre::create([
            'name' => 'Slice of Life',
            'description' => 'Cerita yang menggambarkan kehidupan sehari-hari dengan segala lika-likunya.'
        ]);

        Genre::create([
            'name' => 'Fantasy',
            'description' => 'Cerita yang mengandung unsur-unsur magis, dunia imajinatif, dan makhluk-makhluk fantastis.'
        ]);

        Genre::create([
            'name' => 'Romance',
            'description' => 'Cerita yang berfokus pada hubungan asmara antara karakter utama.'
        ]);

        Genre::create([
            'name' => 'School',
            'description' => 'Cerita yang berlatar belakang kehidupan di sekolah, baik itu sekolah menengah maupun perguruan tinggi.'
        ]);

        Genre::create([
            'name' => 'Non-Fiction',
            'description' => 'Cerita yang berdasarkan fakta nyata dan informasi yang dapat dipercaya.'
        ]);
    }
}
