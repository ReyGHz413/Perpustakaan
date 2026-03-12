<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; 
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Gate Pengelola (Pintu utama Admin & Petugas)
        Gate::define('access-pengelola', function (User $user) {
            return in_array($user->role, ['administrator', 'petugas']);
        });

        // 2. Gate Admin Saja
        Gate::define('access-admin', function (User $user) {
            return $user->role === 'administrator';
        });

        // 3. Gate Peminjam Saja
        Gate::define('access-peminjam', function (User $user) {
            return $user->role === 'peminjam';
        });
    }
}