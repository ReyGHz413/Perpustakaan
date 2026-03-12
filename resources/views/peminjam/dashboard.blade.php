@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

@section('content')
<div class="row g-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-body p-4 p-md-5" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-1" style="color: var(--dark-blue);">Halo, {{ Auth::user()->namaLengkap }}! 👋</h2>
                        <p class="text-muted fs-5 mb-0">Temukan ribuan ilmu melalui koleksi buku digital kami.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('laporan.index') }}" class="btn btn-white shadow-sm rounded-pill px-4 border py-2 transition-all">
                            <i class="bi bi-clock-history me-2 text-primary"></i> Riwayat Pinjam
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="bi bi-journal-bookmark-fill text-primary fs-4"></i>
                    </div>
                    <h5 class="fw-bold mb-0">E-Library Collection</h5>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Informasi Buku</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Kategori</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Penerbit & Tahun</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bukus as $b)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $b->judul }}</div>
                                <div class="text-muted small"><i class="bi bi-pencil-square me-1"></i>{{ $b->penulis }}</div>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 fw-medium" 
                                      style="background: rgba(183, 189, 247, 0.2); color: var(--dark-blue);">
                                    {{ $b->kategori->namaKategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td>
                                <div class="small fw-bold">{{ $b->penerbit }}</div>
                                <div class="text-muted small">{{ $b->tahunTerbit }}</div>
                            </td>
                            <td class="text-center">
                                <button type="button" 
                                        class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm fw-bold border-0" 
                                        style="background: var(--primary-grad);"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalPinjam{{ $b->bukuID }}">
                                    Pinjam
                                </button>

                                <div class="modal fade" id="modalPinjam{{ $b->bukuID }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <form action="{{ route('buku.pinjam', $b->bukuID) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-0 bg-light p-4">
                                                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-calendar-check me-2 text-primary"></i>Konfirmasi Pinjam</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4 text-start">
                                                    <div class="alert alert-info border-0 rounded-3 small mb-4">
                                                        <i class="bi bi-info-circle-fill me-2"></i> Anda akan meminjam buku <strong>"{{ $b->judul }}"</strong>.
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold text-muted text-uppercase">Tanggal Mulai Pinjam</label>
                                                        <input type="date" name="tanggalPeminjaman" class="form-control border-0 bg-light py-2" 
                                                               value="{{ date('Y-m-d') }}" readonly>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label small fw-bold text-muted text-uppercase">Batas Pengembalian</label>
                                                        <input type="date" name="tanggalPengembalian" class="form-control border-0 bg-light py-2 fw-bold text-primary" 
                                                               value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                                                    </div>
                                                    <p class="text-danger mb-0" style="font-size: 0.75rem;">* Mohon kembalikan tepat waktu untuk menghindari denda.</p>
                                                </div>
                                                <div class="modal-footer border-0 p-4 pt-0">
                                                    <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold border-0 shadow-sm" style="background: var(--dark-blue);">
                                                        Ya, Pinjam Sekarang
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-journal-x display-1 text-muted opacity-25 d-block mb-3"></i>
                                <h6 class="text-muted fw-light">Belum ada koleksi buku yang tersedia.</h6>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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

    .transition-all {
        transition: all 0.2s ease-in-out;
    }

    .transition-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }

    .table thead th {
        font-size: 0.7rem;
        letter-spacing: 0.05rem;
    }

    .form-control:focus {
        box-shadow: none;
        border: 1px solid var(--light-blue);
        background-color: #fff !important;
    }
</style>
@endsection