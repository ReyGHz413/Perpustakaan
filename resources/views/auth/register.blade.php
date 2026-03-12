@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-7 col-lg-6">
        @if(Auth::check() && Auth::user()->role === 'administrator')
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm shadow-sm rounded-pill px-3 border">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        @endif

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="p-4 text-center text-white" style="background: var(--primary-grad);">
                <i class="bi bi-person-plus-fill fs-1 mb-2"></i>
                <h4 class="fw-bold mb-1">
                    {{ Auth::check() && Auth::user()->role === 'administrator' ? 'Pendaftaran Petugas' : 'Registrasi Anggota' }}
                </h4>
                <p class="small opacity-75 mb-0">Isi formulir di bawah ini dengan data yang valid</p>
            </div>

            <div class="card-body p-4 p-md-5">
                @if($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm small py-2">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-at"></i></span>
                                <input type="text" name="username" class="form-control bg-light border-0 shadow-none" placeholder="user123" value="{{ old('username') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">EMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-0 shadow-none" placeholder="nama@email.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label small fw-bold text-muted">NAMA LENGKAP</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                                <input type="text" name="namaLengkap" class="form-control bg-light border-0 shadow-none" placeholder="Masukkan nama lengkap Anda" value="{{ old('namaLengkap') }}" required>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label small fw-bold text-muted">ALAMAT</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt"></i></span>
                                <textarea name="alamat" class="form-control bg-light border-0 shadow-none" rows="2" placeholder="Alamat lengkap saat ini..." required>{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label small fw-bold text-muted">PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-0 shadow-none" placeholder="••••••••" required>
                            </div>
                        </div>

                        @if(Auth::check() && Auth::user()->role === 'administrator')
                            <div class="col-12 mt-4 p-3 rounded-3 border border-primary border-opacity-25" style="background-color: rgba(183, 189, 247, 0.05);">
                                <label class="form-label fw-bold text-primary small"><i class="bi bi-shield-lock me-1"></i> ROLE AKSES PETUGAS</label>
                                <select name="role" class="form-select border-0 shadow-none bg-white">
                                    <option value="petugas">Petugas Perpustakaan</option>
                                    <option value="administrator">Administrator (Full Access)</option>
                                </select>
                                <div class="form-text mt-1 italic small text-muted">Pilih wewenang akses untuk akun baru ini.</div>
                            </div>
                        @else
                            <input type="hidden" name="role" value="peminjam">
                        @endif
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm rounded-3 border-0 mt-5 transition-all" 
                            style="background: var(--primary-grad);">
                        {{ Auth::check() && Auth::user()->role === 'administrator' ? 'Daftarkan Akun Petugas' : 'Daftar Sekarang' }}
                    </button>
                </form>

                @guest
                <div class="mt-4 pt-3 border-top text-center">
                    <p class="small text-muted mb-0">Sudah memiliki akun anggota? 
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: var(--dark-blue);">Login Sekarang</a>
                    </p>
                </div>
                @endguest
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --dark-blue: rgb(87, 106, 143);
        --light-blue: rgb(183, 189, 247);
        --primary-grad: linear-gradient(135deg, rgb(87, 106, 143) 0%, rgb(183, 189, 247) 100%);
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(87, 106, 143, 0.1) !important;
        border: 1px solid var(--light-blue) !important;
    }

    .input-group-text {
        color: var(--dark-blue);
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .transition-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(87, 106, 143, 0.3) !important;
        opacity: 0.95;
    }
</style>
@endsection