<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
    'user_id',
    'kasir_id',
    'kode_transaksi',
    'total_harga',
    'metode_bayar',
    'uang_tunai',
    'kembalian',
    'tanggal_transaksi',
    ];


    public $timestamps = true;

    // Relasi transaksi -> user login
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi transaksi -> kasir yang dipilih
    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'kasir_id');
    }

    // Relasi transaksi -> detail
    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}
