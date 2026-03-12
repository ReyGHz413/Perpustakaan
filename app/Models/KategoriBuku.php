<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    // Sesuaikan dengan nama di database: kategoribukus
    protected $table = 'kategoribukus'; 
    protected $primaryKey = 'kategoriID';

    protected $fillable = ['namaKategori'];
}