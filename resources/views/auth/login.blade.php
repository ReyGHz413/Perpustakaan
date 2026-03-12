@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center align-items-center min-vh-100" style="margin-top: -50px;">
    <div class="col-md-4">
        <div class="mb-4">
            <a href="{{ route('welcome') }}" class="text-decoration-none text-muted small fw-bold hover-back">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>

        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center shadow-sm mb-3" 
                 style="width: 80px; height: 80px; background: var(--primary-grad); border-radius: 20px;">
                <i class="bi bi-book-half text-white fs-1"></i>
            </div>
            <h3 class="fw-bold" style="color: var(--dark-blue);">Selamat Datang</h3>
            <p class="text-muted">Silakan masuk untuk mengakses koleksi digital</p>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show small border-0 shadow-sm" role="alert" style="background-color: #fff5f5; color: #c0392b;">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success small border-0 shadow-sm" style="background-color: #f0fff4; color: #27ae60;">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="username" class="form-control bg-light border-0 shadow-none py-2" 
                                   placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <label class="form-label small fw-bold text-muted text-uppercase">Password</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-0 shadow-none py-2" 
                                   placeholder="••••••••" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm rounded-3 border-0 mt-2" 
                            style="background: var(--primary-grad);">
                        Masuk Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="mt-4 pt-3 border-top text-center">
                    <p class="text-muted small mb-0">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: var(--dark-blue);">
                            Daftar Anggota Baru
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <small class="text-muted">&copy; {{ date('Y') }} PerpusDigital Team. All rights reserved.</small>
        </div>
    </div>
</div>

<style>
    :root {
        --dark-blue: rgb(87, 106, 143);
        --light-blue: rgb(183, 189, 247);
        --primary-grad: linear-gradient(135deg, rgb(87, 106, 143) 0%, rgb(183, 189, 247) 100%);
    }

    body {
        background-color: #f8f9fa;
    }

    .hover-back {
        transition: all 0.3s ease;
    }

    .hover-back:hover {
        color: var(--dark-blue) !important;
        padding-left: 5px;
    }

    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(87, 106, 143, 0.1) !important;
        border: 1px solid var(--light-blue) !important;
    }

    .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        transition: all 0.2s;
    }
</style>
@endsection