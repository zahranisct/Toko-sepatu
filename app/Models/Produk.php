<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'kode_produk',
        'model',
        'warna',
        'stok',
        'harga',
    ];

    public function kategori()
    {
        return $this->belongsTo(\App\Models\KategoriProduk::class, 'kategori_id');
    }
}
