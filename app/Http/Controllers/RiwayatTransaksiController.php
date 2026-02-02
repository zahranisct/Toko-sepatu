<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;

class RiwayatTransaksiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inisialisasi query dasar
        $query = Transaksi::with(['user', 'kasir'])->orderBy('tanggal_transaksi', 'DESC');

        // 2. Filter Bulan (Prioritas Utama)
        if ($request->filled('bulan')) {
            $tahun = date('Y', strtotime($request->bulan));
            $bulan = date('m', strtotime($request->bulan));

            $query->whereMonth('tanggal_transaksi', $bulan)
                  ->whereYear('tanggal_transaksi', $tahun);
        } 
        // 3. Filter Tanggal Manual (Hanya jika bulan kosong)
        elseif ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tanggal_transaksi', [
                $request->tgl_mulai . ' 00:00:00',
                $request->tgl_selesai . ' 23:59:59'
            ]);
        }

        // 4. Filter Pencarian Kode
        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'like', '%' . $request->search . '%');
        }

        // 5. Pagination
        $transaksi = $query->paginate(10)->appends($request->all());

        // PERBAIKAN: Path view disesuaikan dengan folder kasir/transaksi/
        return view('kasir.transaksi.riwayat', compact('transaksi'));
    }

    public function detail($id)
    {
        $transaksi = Transaksi::with(['user', 'kasir'])->findOrFail($id);
        $detail = DetailTransaksi::with('produk')->where('transaksi_id', $id)->get();

        // PERBAIKAN: Path view disesuaikan (Pastikan file detail.blade.php ada di folder tersebut)
        return view('kasir.transaksi.detail', compact('transaksi', 'detail'));
    }
}