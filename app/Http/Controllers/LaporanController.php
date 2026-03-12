<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap input filter tanggal
        $tglMulai = $request->tgl_mulai;
        $tglSelesai = $request->tgl_selesai;

        // 2. Query dasar dengan relasi
        $query = Peminjaman::with(['user', 'buku']);

        // 3. Filter berdasarkan Role
        if (Auth::user()->role === 'peminjam') {
            // Peminjam hanya bisa melihat riwayat miliknya sendiri
            $query->where('userID', Auth::user()->userID);
        }

        // 4. Logika Filter Tanggal (untuk laporan admin/petugas)
        if ($tglMulai && $tglSelesai) {
            $query->whereBetween('tanggalPeminjaman', [$tglMulai, $tglSelesai]);
        }

        // 5. Eksekusi data terbaru
        $laporans = $query->latest('tanggalPeminjaman')->get();

        // 6. Return view berdasarkan role
        if (Auth::user()->role === 'peminjam') {
            return view('peminjam.laporan', compact('laporans'));
        }

        return view('admin.laporan', compact('laporans'));
    }

    /**
     * Fungsi update status (saat buku dikembalikan)
     * Admin/Petugas mengklik tombol "Selesai"
     */
    public function updateStatus(Request $request, $id)
    {
        // Cari data berdasarkan primary key peminjamanID
        $peminjaman = Peminjaman::where('peminjamanID', $id)->firstOrFail();
        
        // Cek denda saat ini (Opsional: jika ingin menyimpan nominal denda permanen di DB)
        // $dendaFinal = 0;
        // $deadline = Carbon::parse($peminjaman->tanggalPengembalian);
        // if (now()->gt($deadline)) {
        //     $dendaFinal = now()->diffInDays($deadline) * 2000;
        // }

        $peminjaman->update([
            'statusPeminjaman' => 'Dikembalikan',
            'tanggalPengembalian' => now(), // Tanggal pengembalian aktual saat tombol ditekan
            // 'denda' => $dendaFinal // Jika kolom denda tersedia di tabel peminjaman
        ]);

        return back()->with('success', 'Buku telah dikembalikan. Status berhasil diperbarui!');
    }
}