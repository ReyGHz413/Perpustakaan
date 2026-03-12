@extends('layouts.app')

@section('title', 'Selamat Datang di Digital Library')

@section('content')
<div class="welcome-wrapper overflow-hidden">
    <section class="hero-section py-5 mb-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="badge px-3 py-2 rounded-pill bg-primary bg-opacity-10 text-primary mb-3 fw-bold border border-primary border-opacity-25">
                        <i class="bi bi-stars me-1"></i> Cara Baru Menjelajahi Dunia
                    </div>
                    <h1 class="display-4 fw-bold mb-4" style="color: var(--dark-blue); line-height: 1.2;">
                        Pinjam Buku Secara <span class="text-gradient">Digital</span> & Tanpa Ribet.
                    </h1>
                    <p class="lead text-muted mb-5">
                        Akses ribuan koleksi buku dari berbagai genre hanya dengan beberapa klik. Tingkatkan literasi Anda kapan saja dan di mana saja.
                    </p>
                    <div class="d-flex gap-3">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary px-4 py-3 rounded-pill fw-bold shadow-sm border-0 transition-all text-white" style="background: var(--primary-grad);">
                                Mulai Sekarang <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-dark px-4 py-3 rounded-pill fw-bold border-2 transition-all">
                                Masuk Akun
                            </a>
                        @else
                            <a href="{{ Auth::user()->role === 'peminjam' ? route('peminjam.dashboard') : route('admin.dashboard') }}" 
                               class="btn btn-primary px-4 py-3 rounded-pill fw-bold shadow-sm border-0 transition-all text-white" style="background: var(--primary-grad);">
                                Buka Dashboard Saya <i class="bi bi-speedometer2 ms-2"></i>
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="position-relative animate-float">
                        <div class="position-absolute top-50 start-50 translate-middle bg-primary rounded-circle opacity-10 blur-xl" style="width: 300px; height: 300px; filter: blur(60px);"></div>
                        
                        <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" class="img-fluid position-relative z-index-1" style="max-height: 400px;">
                            <path fill="rgb(183, 189, 247)" d="M418.9,335.3c-14.7-18.7-34.4-33-56.7-41.2c-2.3-0.8-4.7-1.3-7.1-1.4c-6.2-0.3-12.4,1.8-17.1,5.9l-38.5,33.1 c-14.4,12.4-35.4,12.4-49.8,0l-38.5-33.1c-4.7-4-10.9-6.2-17.1-5.9c-2.4,0.1-4.8,0.6-7.1,1.4c-22.3,8.2-42,22.5-56.7,41.2 c-15.1,19.2-23.3,42.8-23.3,67.2c0,6.1,4.9,11,11,11h318.2c6.1,0,11-4.9,11-11C442.2,378.1,434,354.5,418.9,335.3z"/>
                            <circle fill="rgb(87, 106, 143)" cx="250" cy="180" r="70"/>
                            <rect x="180" y="270" width="140" height="20" rx="10" fill="rgb(87, 106, 143)"/>
                            <path d="M120,420 L380,420 L380,430 C380,441.045695 371.045695,450 360,450 L140,450 C128.954305,450 120,441.045695 120,430 L120,420 Z" fill="#ccc"/>
                            <path d="M250,280 L350,220 L350,320 L250,380 L150,320 L150,220 L250,280 Z" fill="rgba(87, 106, 143, 0.2)"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="row g-4 text-center text-dark">
                <div class="col-md-4">
                    <h2 class="fw-bold mb-1" style="color: var(--dark-blue);">10K+</h2>
                    <p class="text-muted small text-uppercase fw-bold">Koleksi Buku</p>
                </div>
                <div class="col-md-4">
                    <h2 class="fw-bold mb-1" style="color: var(--dark-blue);">5K+</h2>
                    <p class="text-muted small text-uppercase fw-bold">Member Aktif</p>
                </div>
                <div class="col-md-4">
                    <h2 class="fw-bold mb-1" style="color: var(--dark-blue);">24/7</h2>
                    <p class="text-muted small text-uppercase fw-bold">Akses Online</p>
                </div>
            </div>
        </div>
    </section>

    <section class="features-section py-5 mt-5">
        <div class="container text-center mb-5">
            <h2 class="fw-bold" style="color: var(--dark-blue);">Mengapa Memilih Perpus kami?</h2>
            <div class="mx-auto rounded-pill mt-2" style="width: 60px; height: 4px; background: var(--primary-grad);"></div>
        </div>
        <div class="container text-dark">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 text-center transition-all hover-up bg-white text-dark">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 70px; height: 70px;">
                            <i class="bi bi-search fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Pencarian Cepat</h5>
                        <p class="text-muted small">Cari buku berdasarkan judul, penulis, atau kategori dengan sistem filter instan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 text-center transition-all hover-up bg-white text-dark">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 70px; height: 70px;">
                            <i class="bi bi-shield-check fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Peminjaman Aman</h5>
                        <p class="text-muted small">Sistem manajemen peminjaman yang terorganisir dengan notifikasi denda otomatis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 text-center transition-all hover-up bg-white text-dark">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 70px; height: 70px;">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Riwayat Digital</h5>
                        <p class="text-muted small">Simpan semua data riwayat bacaan Anda secara permanen dalam satu dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    :root {
        --dark-blue: rgb(87, 106, 143);
        --light-blue: rgb(183, 189, 247);
        --primary-grad: linear-gradient(135deg, rgb(87, 106, 143) 0%, rgb(183, 189, 247) 100%);
    }

    .text-gradient {
        background: var(--primary-grad);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .hover-up:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }

    .z-index-1 { z-index: 1; }
</style>
@endsection