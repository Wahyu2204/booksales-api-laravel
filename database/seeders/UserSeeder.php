<?php

namespace Database\Seeders;

// Memanggil model User dari folder Models
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::Create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminPassword'),
            'role' => 'admin',
        ]);

        User::Create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('customerPassword'),
            'role' => 'customer',
        ]);
    }
}
