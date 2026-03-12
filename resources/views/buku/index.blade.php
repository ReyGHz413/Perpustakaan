@extends('layouts.app')

@section('title', 'Koleksi Buku')

@section('content')
<div class="container py-4">
    <div class="mb-4 d-print-none">
        <a href="{{ Auth::user()->role === 'peminjam' ? route('peminjam.dashboard') : route('admin.dashboard') }}" 
           class="btn btn-white shadow-sm btn-sm px-3 rounded-pill border">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h3 class="fw-bold mb-0" style="color: var(--dark-blue);">
                <i class="bi bi-bookmarks-fill me-2"></i>Koleksi Pustaka
            </h3>
            <p class="text-muted small mb-0">Kelola dan jelajahi seluruh koleksi buku digital secara real-time.</p>
        </div>
        @can('access-pengelola')
        <div class="col-md-6 text-md-end mt-3 mt-md-0 d-print-none">
            <button class="btn btn-outline-primary shadow-sm rounded-pill px-4 me-2 border-2 fw-bold" data-bs-toggle="modal" data-bs-target="#categoryModal">
                <i class="bi bi-tags me-1"></i> + Kategori
            </button>
            <button class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold" style="background: var(--primary-grad); border: none;" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg me-1"></i> + Tambah Buku
            </button>
        </div>
        @endcan
    </div>

    <div class="row g-3 mb-4 d-print-none align-items-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-2">
                    <form action="{{ route('buku.index') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-funnel"></i></span>
                            <select name="kategori" class="form-select border-0 shadow-none bg-white">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->kategoriID }}" {{ request('kategori') == $k->kategoriID ? 'selected' : '' }}>
                                        {{ $k->namaKategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark px-4 rounded-3 shadow-sm fw-bold" style="background: var(--dark-blue);">Filter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-end">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-0 py-2 small border-0 shadow-sm rounded-3" role="alert" style="background-color: #f0fff4; color: #27ae60;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden shadow-hover transition-all">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f8f9fa; color: var(--dark-blue);">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold">Detail Koleksi</th>
                        <th class="py-3 text-uppercase small fw-bold">Penerbitan</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Kategori</th>
                        <th class="py-3 text-uppercase small fw-bold text-center d-print-none">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($bukus as $b)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-buku me-3 bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" 
                                     style="width: 45px; height: 55px; border: 1px dashed var(--light-blue);">
                                    <i class="bi bi-book-half fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-6">{{ $b->judul }}</div>
                                    <div class="text-muted small"><i class="bi bi-person-pencil me-1"></i>{{ $b->penulis }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark small">{{ $b->penerbit }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Tahun Terbit: {{ $b->tahunTerbit }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill px-3 py-2 fw-medium" 
                                  style="background-color: rgba(183, 189, 247, 0.15); color: var(--dark-blue); border: 1px solid rgba(87, 106, 143, 0.1);">
                                {{ $b->kategori->namaKategori ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="text-center d-print-none pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                @can('access-peminjam')
                                    <form action="{{ route('buku.pinjam', $b->bukuID) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm border-0 fw-bold" 
                                                style="background: linear-gradient(135deg, #42e695 0%, #3bb2b8 100%);"
                                                onclick="return confirm('Konfirmasi peminjaman buku: {{ $b->judul }}?')">
                                            <i class="bi bi-plus-circle me-1"></i> Pinjam
                                        </button>
                                    </form>
                                @endcan

                                @can('access-pengelola')
                                    <form action="{{ route('buku.destroy', $b->bukuID) }}" method="POST" onsubmit="return confirm('Hapus buku ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border rounded-circle shadow-sm" style="width: 32px; height: 32px; padding: 0;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-inboxes display-1 text-muted opacity-25 d-block mb-3"></i>
                                <h5 class="text-muted fw-light">Koleksi masih kosong atau tidak ditemukan.</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@can('access-pengelola')
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('buku.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            @csrf
            <div class="modal-header border-0 text-white p-4" style="background: var(--primary-grad);">
                <h5 class="fw-bold mb-0"><i class="bi bi-book me-2"></i>Tambah Koleksi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">JUDUL BUKU</label>
                    <input type="text" name="judul" class="form-control border-0 bg-light py-2" placeholder="Contoh: Laskar Pelangi" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">PENULIS</label>
                        <input type="text" name="penulis" class="form-control border-0 bg-light py-2" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">PENERBIT</label>
                        <input type="text" name="penerbit" class="form-control border-0 bg-light py-2" required>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">TAHUN TERBIT</label>
                        <input type="number" name="tahunTerbit" class="form-control border-0 bg-light py-2" min="1900" max="{{ date('Y') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">KATEGORI</label>
                        <select name="kategoriID" class="form-select border-0 bg-light py-2" required>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->kategoriID }}">{{ $k->namaKategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm border-0" style="background: var(--dark-blue);">
                    Simpan Ke Koleksi <i class="bi bi-save ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form action="{{ route('kategori.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            @csrf
            <div class="modal-header border-0 text-white p-3" style="background: var(--dark-blue);">
                <h6 class="fw-bold mb-0"><i class="bi bi-tags me-2"></i>Kategori Baru</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <label class="form-label small fw-bold text-muted">NAMA KATEGORI</label>
                <input type="text" name="namaKategori" class="form-control border-0 bg-light py-2 px-3 mb-2" placeholder="Misal: Fiksi" required>
            </div>
            <div class="modal-footer border-0 p-3 pt-0">
                <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill shadow-sm border-0" style="background: var(--primary-grad);">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endcan

<style>
    :root {
        --dark-blue: rgb(87, 106, 143);
        --light-blue: rgb(183, 189, 247);
        --primary-grad: linear-gradient(135deg, rgb(87, 106, 143) 0%, rgb(183, 189, 247) 100%);
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .shadow-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }

    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: none;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(87, 106, 143, 0.1) !important;
        border: 1px solid var(--light-blue) !important;
    }
</style>
@endsection