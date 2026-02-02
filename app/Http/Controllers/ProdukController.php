<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\KategoriProduk;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        if ($request->filled('keyword')) {
            $query->where('nama_produk', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $produk = $query->orderBy('nama_produk')->get();
        $kategori = KategoriProduk::orderBy('nama_kategori')->get();

        return view('admin.produk.index', compact('produk', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriProduk::all();
        return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produk,id',
            'model' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $validated['kode_produk'] = $this->generateKodeProduk($validated['kategori_id'], $validated['model'], $validated['warna']);

        Produk::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $kategori = KategoriProduk::all();
        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produk,id',
            'model' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $validated['kode_produk'] = $this->generateKodeProduk($validated['kategori_id'], $validated['model'], $validated['warna']);

        $produk->update($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function generateKodeProduk($kategori_id, $model, $warna)
    {
        $kategori = KategoriProduk::find($kategori_id);
        $kategori_prefix = strtoupper($kategori->kode_kategori ?? substr($kategori->nama_kategori, 0, 3)); // Pakai kode_kategori jika ada
        $model_prefix = strtoupper(substr($model, 0, 3));
        $warna_prefix = strtoupper(substr($warna, 0, 3));

        $kode = $kategori_prefix . '-' . $model_prefix . '-' . $warna_prefix;

        $count = Produk::where('kode_produk', 'like', $kode . '%')->count();
        if ($count > 0) {
            $kode .= '-' . ($count + 1);
        }

        return $kode;
    }
}
