<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;
    protected $table = 'kasir';
    protected $fillable = [
        'user_id',
        'nama_kasir',
        'nomor_hp',
        'alamat',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kasir_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}