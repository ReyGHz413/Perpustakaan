<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index(Request $request) 
    {
        $kategoris = KategoriBuku::all();
        $query = Buku::with('kategori');

        // Filter Multi-Kategori (Checkbox)
        $kategoriTerpilih = $request->query('kategori');
        if (!empty($kategoriTerpilih)) {
            // Memastikan data selalu dalam bentuk array agar whereIn tidak error
            $query->whereIn('kategoriID', (array)$kategoriTerpilih);
        }

        $bukus = $query->latest()->get();

        // LOGIKA BARU: Cek Role User untuk menentukan View yang ditampilkan
        if (Auth::user()->role === 'peminjam') {
            return view('peminjam.dashboard', compact('bukus', 'kategoris'));
        }

        // Baris 33 yang error tadi:
return view('buku.index', compact('bukus', 'kategoris')); 
// Ganti 'buku.index' di atas dengan nama file blade admin kamu yang benar.
    }

    public function store(Request $request) 
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahunTerbit' => 'required|numeric|digits:4',
            'kategoriID' => 'required'
        ]);

        Buku::create($request->all());
        return back()->with('success', 'Buku baru berhasil ditambahkan!');
    }

    public function pinjam(Request $request, $id) 
{
    $request->validate([
        'tanggalPeminjaman' => 'required|date',
        'tanggalPengembalian' => 'required|date|after:tanggalPeminjaman'
    ]);

    Peminjaman::create([
        'userID'            => Auth::user()->userID,
        'bukuID'            => $id,
        'tanggalPeminjaman' => $request->tanggalPeminjaman,
        'tanggalPengembalian' => $request->tanggalPengembalian, // Simpan rencana kembali
        'statusPeminjaman'  => 'Dipinjam'
    ]);

    return redirect()->route('laporan.index')->with('success', 'Buku berhasil dipinjam!');
}

    public function storeKategori(Request $request) 
    {
        $request->validate([
            'namaKategori' => 'required|unique:kategoribukus,namaKategori'
        ]);

        DB::table('kategoribukus')->insert([
            'namaKategori' => $request->namaKategori,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function destroy($id) 
    {
        // Hapus buku berdasarkan primary key yang benar
        Buku::where('bukuID', $id)->delete();
        return back()->with('success', 'Buku berhasil dihapus dari sistem!');
    }
}