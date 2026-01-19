<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class ViewStokController extends Controller
{
    /**
     * Menampilkan daftar stok produk untuk kasir (hanya lihat)
     */
    public function index(Request $request)
    {
        // 1. Mengambil semua kategori untuk filter dropdown
        $kategori = KategoriProduk::all();

        // 2. Query dasar produk dengan relasi kategori
        $query = Produk::with('kategori');

        // 3. Logika Pencarian (Nama Produk atau Kode Produk)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_produk', 'like', "%" . $keyword . "%")
                  ->orWhere('kode_produk', 'like', "%" . $keyword . "%");
            });
        }

        // 4. Logika Filter Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // 5. Urutkan stok dari yang paling sedikit ke banyak
        $produk = $query->orderBy('stok', 'asc')->get();

        // 6. Arahkan ke file blade yang tadi dibuat
        return view('kasir.viewstok', compact('produk', 'kategori'));
    }
}