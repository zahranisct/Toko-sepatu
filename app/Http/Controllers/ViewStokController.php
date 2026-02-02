<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class ViewStokController extends Controller
{
//hanya melihat stok//
    public function index(Request $request)
    {
        $kategori = KategoriProduk::all();
        $query = Produk::with('kategori');
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_produk', 'like', "%" . $keyword . "%")
                  ->orWhere('kode_produk', 'like', "%" . $keyword . "%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $produk = $query->orderBy('stok', 'asc')->get();

        return view('kasir.viewstok', compact('produk', 'kategori'));
    }
}