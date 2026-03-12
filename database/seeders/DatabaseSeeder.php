<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat 1 akun Administrator sesuai kolom di perpus.sql
        User::create([
            'username' => 'admin_perpus',
            'password' => Hash::make('admin123'), // Password yang dienkripsi
            'email' => 'admin@gmail.com',
            'namaLengkap' => 'Administrator Utama',
            'alamat' => 'Jl. Perpustakaan No. 1, Jakarta',
            'role' => 'administrator', // Role sesuai enum
        ]);
    }
}
