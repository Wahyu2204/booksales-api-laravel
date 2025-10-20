<?php

namespace Database\Seeders;

// Memanggil model Author dari folder Models
use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'John Doe',
            'photo' => 'johndoe.jpg',
            'bio' => 'John Doe adalah seorang penulis fiksi ilmiah yang terkenal dengan karyanya yang mendalam dan imajinatif.'
        ]);

        Author::create([
            'name' => 'Jane Smith',
            'photo' => 'janesmith.jpg',
            'bio' => 'Jane Smith adalah seorang penulis romance yang karyanya sering kali mengangkat tema cinta dan hubungan antar manusia.'
        ]);

        Author::create([
            'name' => 'Alice Johnson',
            'photo' => 'alicejohnson.jpg',
            'bio' => 'Alice Johnson adalah seorang penulis non-fiksi yang fokus pada topik sejarah dan budaya.'
        ]);

        Author::create([
            'name' => 'Michael Brown',
            'photo' => 'michaelbrown.jpg',
            'bio' => 'Michael Brown adalah seorang penulis fantasi yang menciptakan dunia-dunia magis yang memukau pembacanya.'
        ]);

        Author::create([
            'name' => 'Emily Davis',
            'photo' => 'emilydavis.jpg',
            'bio' => 'Emily Davis adalah seorang penulis slice of life yang menggambarkan kehidupan sehari-hari dengan segala lika-likunya.'
        ]);
    }
}
