<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    // Beritahu Laravel nama tabel yang benar sesuai .sql kamu
    protected $table = 'bukus'; 
    protected $primaryKey = 'bukuID';

    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahunTerbit', 'kategoriID'];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategoriID', 'kategoriID');
    }
}