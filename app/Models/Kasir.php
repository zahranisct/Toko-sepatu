<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit sesuai database kamu
    protected $table = 'kasir';

    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'user_id',     // Foreign key ke tabel user
        'nama_kasir',
        'nomor_hp',
        'alamat',
        'status',
    ];

    /**
     * Relasi ke tabel User (One-to-One / BelongsTo)
     * Kasir ini terhubung ke satu akun login di tabel User
     */
    public function user()
    {
        // Parameter: NamaModel, foreign_key_di_tabel_kasir, owner_key_di_tabel_user
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke tabel Transaksi (One-to-Many)
     * Satu kasir bisa menangani banyak transaksi
     */
    public function transaksi()
    {
        // Sesuaikan 'kasir_id' dengan nama kolom di tabel transaksi kamu
        return $this->hasMany(Transaksi::class, 'kasir_id');
    }

    /**
     * Scope untuk mempermudah pencarian kasir yang aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}