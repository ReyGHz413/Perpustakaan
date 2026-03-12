<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'administrator' || $user->role === 'petugas') {
                return redirect()->intended(route('admin.dashboard'));
            } 
            
            return redirect()->intended(route('peminjam.dashboard'));
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])->withInput();
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'username'    => 'required|unique:users,username',
            'password'    => 'required|min:5',
            'email'       => 'required|email|unique:users,email',
            'namaLengkap' => 'required',
            'alamat'      => 'required',
            'role'        => 'required|in:administrator,petugas,peminjam', 
        ]);

        // Cek admin sebelum create user agar tidak kehilangan context auth
        $isAdmin = Auth::check() && Auth::user()->role === 'administrator';

        User::create([
            'username'    => $request->username,
            'password'    => Hash::make($request->password),
            'email'       => $request->email,
            'namaLengkap' => $request->namaLengkap,
            'alamat'      => $request->alamat,
            'role'        => $request->role,
        ]);

        if ($isAdmin) {
            return redirect()->route('admin.dashboard')->with('success', 'Akun ' . $request->role . ' berhasil dibuat!');
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}