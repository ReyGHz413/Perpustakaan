<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. GUEST: Akses sebelum login
Route::middleware('guest')->group(function () {
    // Halaman Landing Page (Website Depan)
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    // Autentikasi
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
});

// Register store (Bisa diakses Guest untuk daftar member, atau Admin untuk tambah petugas)
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// 2. AUTH: Akses setelah login 
Route::middleware(['auth', 'no-cache'])->group(function () {
    
    // Proses Keluar
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- FITUR BERSAMA (Admin, Petugas, Peminjam) ---
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // --- AREA PENGELOLA (Admin & Petugas) ---
    Route::middleware('can:access-pengelola')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Manajemen Buku & Kategori
        Route::get('/admin/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
        Route::post('/kategori', [BukuController::class, 'storeKategori'])->name('kategori.store');

        // Update Status (Proses pengembalian & denda)
        Route::put('/laporan/{id}/status', [LaporanController::class, 'updateStatus'])->name('laporan.update');
        
        // Registrasi Petugas (Khusus Admin)
        Route::get('/admin/register-petugas', [AuthController::class, 'showRegister'])->name('admin.register');
    });

    // --- AREA PEMINJAM (Member) ---
    Route::middleware('can:access-peminjam')->group(function () {
        Route::get('/peminjam/dashboard', [BukuController::class, 'index'])->name('peminjam.dashboard');
        Route::post('/buku/pinjam/{id}', [BukuController::class, 'pinjam'])->name('buku.pinjam');
    });
});