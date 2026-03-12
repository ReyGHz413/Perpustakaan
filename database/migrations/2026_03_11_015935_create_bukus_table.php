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
        Schema::create('bukus', function (Blueprint $table) {
    $table->id('bukuID'); // Primary Key 
    $table->string('judul', 255); 
    $table->string('penulis', 255); 
    $table->string('penerbit', 255); 
    $table->integer('tahunTerbit'); // Diperbaiki: hanya integer tanpa parameter tambahan 
    
    // Relasi ke tabel kategoribuku
    $table->unsignedBigInteger('kategoriID'); 
    // Pastikan nama tabel di references() adalah 'kategoribukus' atau 'kategoribuku' sesuai yang Anda buat nanti
    $table->foreign('kategoriID')->references('kategoriID')->on('kategoribukus')->onDelete('cascade'); 
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
