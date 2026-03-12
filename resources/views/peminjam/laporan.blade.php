@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="container py-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('peminjam.dashboard') }}" class="btn btn-white shadow-sm btn-sm px-3 rounded-pill border">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
        <div class="d-flex gap-2">
            <span class="badge bg-white text-dark border shadow-sm px-3 py-2 rounded-pill fw-normal">
                <i class="bi bi-book me-1 text-primary"></i> Total Pinjaman: <strong>{{ $laporans->count() }}</strong>
            </span>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <h3 class="fw-bold mb-1" style="color: var(--dark-blue);">Riwayat Peminjaman Saya</h3>
            <p class="text-muted small">Pantau status pengembalian buku dan informasi denda Anda di sini.</p>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f8f9fa; color: var(--dark-blue);">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold">Buku yang Dipinjam</th>
                        <th class="py-3 text-uppercase small fw-bold">Waktu Pinjam</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Batas Kembali</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Denda Terkini</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($laporans as $l)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light p-2 rounded-3 me-3 text-primary">
                                    <i class="bi bi-journal-text fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $l->buku->judul }}</div>
                                    <div class="text-muted small" style="font-size: 0.75rem;">ID Pinjam: #{{ $l->peminjamanID ?? '00'.$loop->iteration }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small fw-medium text-dark">{{ \Carbon\Carbon::parse($l->tanggalPeminjaman)->format('d M Y') }}</div>
                        </td>
                        <td class="text-center">
                            <div class="badge bg-light text-dark border fw-normal px-3">
                                {{ \Carbon\Carbon::parse($l->tanggalPengembalian)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="text-center">
                            @php
                                $deadline = \Carbon\Carbon::parse($l->tanggalPengembalian);
                                $hariIni = \Carbon\Carbon::now();
                                $denda = 0;
                                
                                if ($l->statusPeminjaman == 'Dipinjam' && $hariIni->gt($deadline)) {
                                    $selisihHari = $hariIni->diffInDays($deadline);
                                    $denda = $selisihHari * 2000;
                                }
                            @endphp

                            @if($denda > 0)
                                <div class="p-2 rounded-3" style="background-color: #fff5f5; border: 1px solid #feb2b2;">
                                    <div class="text-danger fw-bold small">
                                        Rp {{ number_format($denda, 0, ',', '.') }}
                                    </div>
                                    <div class="text-muted fw-bold" style="font-size: 9px;">Terlambat {{ $selisihHari }} Hari</div>
                                </div>
                            @else
                                <span class="text-success small fw-medium">
                                    <i class="bi bi-check-circle-fill me-1"></i> Rp 0
                                </span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            @if($l->statusPeminjaman == 'Dipinjam')
                                <span class="badge rounded-pill px-3 py-2 bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 fw-bold" style="font-size: 0.7rem;">
                                    <i class="bi bi-hourglass-split me-1"></i> SEDANG DIPINJAM
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2 bg-success bg-opacity-10 text-success border border-success border-opacity-25 fw-bold" style="font-size: 0.7rem;">
                                    <i class="bi bi-check-lg me-1"></i> SUDAH KEMBALI
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="py-4 text-center">
                                <img src="https://illustrations.popsy.co/amber/empty-state.svg" alt="empty" style="width: 180px;" class="mb-4 opacity-75">
                                <h5 class="text-muted fw-bold">Belum Ada Riwayat</h5>
                                <p class="text-muted small mb-4">Anda belum meminjam buku apapun dari koleksi kami.</p>
                                <a href="{{ route('peminjam.dashboard') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold border-0" style="background: var(--primary-grad);">
                                    Jelajahi Buku Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    :root {
        --dark-blue: rgb(87, 106, 143);
        --light-blue: rgb(183, 189, 247);
        --primary-grad: linear-gradient(135deg, rgb(87, 106, 143) 0%, rgb(183, 189, 247) 100%);
    }

    .table thead th {
        font-size: 0.7rem;
        letter-spacing: 1px;
        border: none;
    }

    .table tbody tr {
        transition: all 0.2s;
    }

    .table tbody tr:hover {
        background-color: #fcfcff !important;
    }

    .btn-white:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
    }
</style>
@endsection