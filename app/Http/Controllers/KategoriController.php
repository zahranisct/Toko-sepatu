<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('kategori_produk');

        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where('nama_kategori', 'like', "%{$keyword}%");
        }

        $kategori = $query->select('id', 'nama_kategori', 'kode_kategori')->get(); // tambahkan kode_kategori

        return view('admin.kategori.index', [
            'kategori' => $kategori,
            'page_title' => 'Kategori Produk'
        ]);
    }

    public function create()
    {
        return view('admin.kategori.create', [
            'page_title' => 'Tambah Kategori Produk'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'kode_kategori' => 'required|string|max:10|unique:kategori_produk,kode_kategori'
        ]);

        DB::table('kategori_produk')->insert([
            'nama_kategori' => $request->nama_kategori,
            'kode_kategori' => $request->kode_kategori,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = DB::table('kategori_produk')->where('id', $id)->first();

        return view('admin.kategori.edit', [
            'kategori' => $kategori,
            'page_title' => 'Edit Kategori Produk'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'kode_kategori' => 'required|string|max:10|unique:kategori_produk,kode_kategori,' . $id
        ]);

        DB::table('kategori_produk')->where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori,
            'kode_kategori' => $request->kode_kategori,
            'updated_at' => now()
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('kategori_produk')->where('id', $id)->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
