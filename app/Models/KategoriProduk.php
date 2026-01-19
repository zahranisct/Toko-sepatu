<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';

    protected $fillable = [
        'nama_kategori',
        'kode_kategori', // tambahkan ini
    ];

    public $timestamps = true;

    // Relasi: 1 kategori memiliki banyak produk
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
