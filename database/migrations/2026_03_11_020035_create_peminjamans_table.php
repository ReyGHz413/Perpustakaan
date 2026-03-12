<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
    $table->id('peminjamanID'); // Primary Key 
    $table->unsignedBigInteger('userID'); // Relasi ke User 
    $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
    $table->unsignedBigInteger('bukuID'); // Relasi ke Buku 
    $table->foreign('bukuID')->references('bukuID')->on('bukus')->onDelete('cascade');
    $table->date('tanggalPeminjaman'); 
    $table->date('tanggalPengembalian')->nullable(); 
    $table->string('statusPeminjaman', 50); 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
