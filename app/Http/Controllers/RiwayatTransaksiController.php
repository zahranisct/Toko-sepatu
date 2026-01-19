<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class RiwayatTransaksiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inisialisasi query dengan relasi
        $query = Transaksi::with(['user', 'kasir'])->orderBy('tanggal_transaksi', 'DESC');

        // 2. Filter Pencarian Kode Transaksi (Jika ada input search)
        if ($request->has('search') && $request->search != '') {
            $query->where('kode_transaksi', 'like', '%' . $request->search . '%');
        }

        // 3. Filter Rentang Tanggal (Gunakan nama yang sinkron dengan Blade: tgl_mulai)
        if ($request->tgl_mulai && $request->tgl_selesai) {
            $query->whereBetween('tanggal_transaksi', [
                $request->tgl_mulai . ' 00:00:00',
                $request->tgl_selesai . ' 23:59:59'
            ]);
        } elseif ($request->tgl_mulai) {
            $query->whereDate('tanggal_transaksi', '>=', $request->tgl_mulai);
        } elseif ($request->tgl_selesai) {
            $query->whereDate('tanggal_transaksi', '<=', $request->tgl_selesai);
        }

        // 4. Ambil data dengan pagination agar tidak berat, sertakan appends agar filter tidak hilang saat pindah halaman
        $transaksi = $query->paginate(10)->appends($request->all());

        return view('transaksi.riwayat', compact('transaksi'));
    }

    public function detail($id)
    {
        $transaksi = Transaksi::with(['user', 'kasir'])->findOrFail($id);
        $detail = DetailTransaksi::with('produk')->where('transaksi_id', $id)->get();

        return view('transaksi.detail', compact('transaksi', 'detail'));
    }
}