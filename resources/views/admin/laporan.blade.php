@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-0" style="color: var(--dark-blue);">📋 Laporan Peminjaman</h3>
            <p class="text-muted small mb-0">Pantau aktivitas sirkulasi buku dan manajemen denda secara real-time.</p>
        </div>
        <div class="d-flex gap-2 d-print-none">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary shadow-sm rounded-pill px-4 fw-bold">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
            <button onclick="window.print()" class="btn btn-success shadow-sm rounded-pill px-4 fw-bold">
                <i class="bi bi-printer me-2"></i> Cetak Laporan
            </button>
        </div>
    </div>

    @php
        $totalPinjam = $laporans->count();
        $totalKembali = $laporans->where('statusPeminjaman', 'Dikembalikan')->count();
        $totalAktif = $laporans->where('statusPeminjaman', 'Dipinjam')->count();
        
        $totalDendaTerkumpul = 0;
        foreach($laporans as $l) {
            $deadline = \Carbon\Carbon::parse($l->tanggalPengembalian);
            if ($l->statusPeminjaman == 'Dipinjam' && \Carbon\Carbon::now()->gt($deadline)) {
                $totalDendaTerkumpul += \Carbon\Carbon::now()->diffInDays($deadline) * 2000;
            }
        }
    @endphp

    <div class="row g-3 mb-4 d-print-none">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-white h-100 card-hover" style="background: var(--primary-grad);">
                <div class="small text-uppercase opacity-75 fw-bold">Total Transaksi</div>
                <div class="h2 fw-bold mb-0">{{ $totalPinjam }}</div>
                <i class="bi bi-layers position-absolute end-0 bottom-0 m-3 opacity-25 fs-1"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-white h-100 card-hover" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                <div class="small text-uppercase opacity-75 fw-bold text-dark">Masih Dipinjam</div>
                <div class="h2 fw-bold mb-0 text-dark">{{ $totalAktif }}</div>
                <i class="bi bi-book-half position-absolute end-0 bottom-0 m-3 opacity-25 fs-1 text-dark"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-white h-100 card-hover" style="background: linear-gradient(135deg, #42e695 0%, #3bb2b8 100%);">
                <div class="small text-uppercase opacity-75 fw-bold">Sudah Kembali</div>
                <div class="h2 fw-bold mb-0">{{ $totalKembali }}</div>
                <i class="bi bi-check-circle position-absolute end-0 bottom-0 m-3 opacity-25 fs-1"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-white h-100 card-hover" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5253 100%);">
                <div class="small text-uppercase opacity-75 fw-bold">Estimasi Denda</div>
                <div class="h2 fw-bold mb-0">Rp {{ number_format($totalDendaTerkumpul, 0, ',', '.') }}</div>
                <i class="bi bi-cash-stack position-absolute end-0 bottom-0 m-3 opacity-25 fs-1"></i>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4 d-print-none rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <h6 class="mb-0 fw-bold text-secondary"><i class="bi bi-funnel me-2"></i>Filter Rentang Waktu</h6>
        </div>
        <div class="card-body p-4 pt-0">
            <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted">DARI TANGGAL</label>
                    <div class="input-group border rounded-3 overflow-hidden">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" name="tgl_mulai" class="form-control border-0 shadow-none bg-light" value="{{ request('tgl_mulai') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted">SAMPAI TANGGAL</label>
                    <div class="input-group border rounded-3 overflow-hidden">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-check"></i></span>
                        <input type="date" name="tgl_selesai" class="form-control border-0 shadow-none bg-light" value="{{ request('tgl_selesai') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm fw-bold px-4" style="background: var(--dark-blue); border: none;">
                            <i class="bi bi-search me-1"></i> Cari Data
                        </button>
                        <a href="{{ route('laporan.index') }}" class="btn btn-light border px-3 rounded-3 shadow-sm" title="Reset Filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-none d-print-block mb-5 text-center">
        <h2 class="fw-bold mb-1">LAPORAN PERPUSTAKAAN DIGITAL</h2>
        <p class="text-muted">
            Periode: <strong>{{ request('tgl_mulai') ? \Carbon\Carbon::parse(request('tgl_mulai'))->format('d/m/Y') : 'Awal Koleksi' }}</strong> 
            sampai 
            <strong>{{ request('tgl_selesai') ? \Carbon\Carbon::parse(request('tgl_selesai'))->format('d/m/Y') : 'Hari Ini' }}</strong>
        </p>
        <hr style="border: 2px solid #000; opacity: 1;">
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: var(--dark-blue); color: white;">
                    <tr>
                        <th class="ps-4 py-3 border-0 small text-uppercase fw-bold">Peminjam</th>
                        <th class="py-3 border-0 small text-uppercase fw-bold">Informasi Buku</th>
                        <th class="py-3 border-0 small text-uppercase fw-bold text-center">Tgl Pinjam</th>
                        <th class="py-3 border-0 small text-uppercase fw-bold text-center">Batas Kembali</th>
                        <th class="py-3 border-0 small text-uppercase fw-bold text-center">Denda</th>
                        <th class="py-3 border-0 small text-uppercase fw-bold text-center">Status</th>
                        <th class="pe-4 py-3 border-0 small text-uppercase fw-bold text-center d-print-none">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($laporans as $l)
                    @php
                        $deadline = \Carbon\Carbon::parse($l->tanggalPengembalian);
                        $terlambat = ($l->statusPeminjaman == 'Dipinjam' && \Carbon\Carbon::now()->gt($deadline));
                        $denda = $terlambat ? \Carbon\Carbon::now()->diffInDays($deadline) * 2000 : 0;
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $l->user->namaLengkap }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $l->user->email }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-truncate" style="max-width: 200px;">{{ $l->buku->judul }}</div>
                            <div class="text-muted small">Kode: BK-{{ str_pad($l->buku->bukuID, 4, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="text-center small">{{ \Carbon\Carbon::parse($l->tanggalPeminjaman)->format('d/m/Y') }}</td>
                        <td class="text-center small fw-bold {{ $terlambat ? 'text-danger' : '' }}">{{ $deadline->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @if($denda > 0)
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2">
                                    Rp {{ number_format($denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($l->statusPeminjaman == 'Dipinjam')
                                <span class="badge rounded-pill bg-warning text-dark px-3 border border-warning">
                                    <i class="bi bi-clock-history me-1"></i> Dipinjam
                                </span>
                            @else
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 border border-success">
                                    <i class="bi bi-check2-all me-1"></i> Kembali
                                </span>
                            @endif
                        </td>
                        <td class="d-print-none text-center pe-4">
                            @if($l->statusPeminjaman == 'Dipinjam')
                                <form action="{{ route('laporan.update', $l->peminjamanID) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm fw-bold">
                                        Kembalikan
                                    </button>
                                </form>
                            @else
                                <span class="text-success"><i class="bi bi-shield-check fs-5"></i></span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-search display-4 text-muted d-block mb-3 opacity-25"></i>
                                <h5 class="text-muted">Tidak ada data ditemukan</h5>
                                <p class="small text-muted">Coba sesuaikan filter rentang tanggal Anda.</p>
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
    /* Mengikuti variabel warna dari layout sebelumnya */
    :root {
        --dark-blue: rgb(87, 106, 143);
        --light-blue: rgb(183, 189, 247);
        --primary-grad: linear-gradient(135deg, rgb(87, 106, 143) 0%, rgb(183, 189, 247) 100%);
    }

    .card-hover:hover {
        transform: translateY(-3px);
        transition: all 0.3s ease;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(183, 189, 247, 0.05);
    }

    .badge {
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    @media print {
        @page { size: landscape; margin: 1cm; }
        body { background-color: #fff !important; }
        .navbar, .d-print-none, .btn-logout { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        .table thead { background: #f8f9fa !important; color: #000 !important; border-bottom: 2px solid #000 !important; }
        .badge { border: 1px solid #ddd !important; background: transparent !important; color: #000 !important; }
    }
</style>
@endsection