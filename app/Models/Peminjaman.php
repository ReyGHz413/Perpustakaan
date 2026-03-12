<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    protected $primaryKey = 'peminjamanID';
    
    protected $fillable = [
        'userID', 'bukuID', 'tanggalPeminjaman', 'tanggalPengembalian', 'statusPeminjaman'
    ];

    // Relasi ke User
    public function user() {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    // Relasi ke Buku
    public function buku() {
        return $this->belongsTo(Buku::class, 'bukuID', 'bukuID');
    }

    // App\Models\Peminjaman.php

public function hitungDenda()
{
    // Jika sudah dikembalikan, denda berhenti dihitung (atau Anda bisa simpan nilai denda tetap di DB)
    if ($this->statusPeminjaman == 'Dikembalikan') return 0;

    $tglDeadline = \Carbon\Carbon::parse($this->tanggalPengembalian);
    $tglSekarang = \Carbon\Carbon::now();

    if ($tglSekarang->gt($tglDeadline)) {
        $selisihHari = $tglSekarang->diffInDays($tglDeadline);
        return $selisihHari * 2000; // Rp 2.000 per hari
    }

    return 0;
}
}