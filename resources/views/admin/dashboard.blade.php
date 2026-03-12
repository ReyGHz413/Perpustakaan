@extends('layouts.app')

@section('title', 'Dashboard Pengelola')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-left: 5px solid #198754;">
                <strong><i class="bi bi-check-circle-fill me-2"></i>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm card-custom mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-1" style="color: var(--dark-blue);">Selamat Datang, {{ Auth::user()->namaLengkap }}!</h2>
                        <p class="text-muted mb-0">Kelola perpustakaan dengan mudah melalui panel kendali Anda.</p>
                    </div>
                    <div class="col-md-4 text-md-end d-none d-md-block">
                        <div class="p-2 px-3 bg-light rounded-pill d-inline-block border">
                            <i class="bi bi-calendar3 me-2 text-primary"></i>
                            <span class="fw-bold text-secondary small">{{ date('l, d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm card-custom card-hover overflow-hidden">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <div class="mb-3 mx-auto shadow-sm d-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; background: var(--primary-grad); border-radius: 15px;">
                             <i class="bi bi-journal-plus text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Pendataan Buku</h5>
                        <p class="text-muted small px-3">Kelola database buku, kategori, hingga pemantauan stok secara realtime.</p>
                        <a href="{{ route('buku.index') }}" class="btn mt-auto fw-bold text-white shadow-sm" 
                           style="background: var(--dark-blue); border-radius: 10px;">Buka Kelola</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm card-custom card-hover overflow-hidden">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <div class="mb-3 mx-auto shadow-sm d-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, #42e695 0%, #3bb2b8 100%); border-radius: 15px;">
                             <i class="bi bi-file-earmark-bar-graph text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Generate Laporan</h5>
                        <p class="text-muted small px-3">Cetak dan tinjau laporan riwayat peminjaman buku periode bulanan.</p>
                        <a href="{{ route('laporan.index') }}" class="btn mt-auto fw-bold text-white shadow-sm" 
                           style="background: #3bb2b8; border-radius: 10px;">Lihat Laporan</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                @if(Auth::user()->role === 'administrator')
                <div class="card h-100 border-0 shadow-sm card-custom card-hover overflow-hidden">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <div class="mb-3 mx-auto shadow-sm d-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); border-radius: 15px;">
                             <i class="bi bi-person-plus text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Registrasi Petugas</h5>
                        <p class="text-muted small px-3">Wewenang Admin: Daftarkan akun baru untuk petugas atau administrator.</p>
                        <a href="{{ route('admin.register') }}" class="btn mt-auto fw-bold text-white shadow-sm" 
                           style="background: #fda085; border-radius: 10px;">Tambah Petugas</a>
                    </div>
                </div>
                @else
                <div class="card h-100 border-0 shadow-sm card-custom bg-light opacity-75">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                        <i class="bi bi-lock-fill text-secondary mb-3 fs-1"></i>
                        <h5 class="text-secondary fw-bold">Akses Terbatas</h5>
                        <p class="small text-muted px-2">Fitur registrasi hanya dapat diakses oleh Administrator utama.</p>
                        <button class="btn btn-secondary btn-sm mt-auto disabled rounded-pill">Petugas Mode</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection