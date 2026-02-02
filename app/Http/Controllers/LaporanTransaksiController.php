<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getLaporanData($request);
        return view('admin.laporan_transaksi', $data);
    }

    public function cetak(Request $request)
    {
        $data = $this->getLaporanData($request);
        return view('admin.cetak_laporan', $data);
    }

    private function getLaporanData(Request $request)
    {
        $tgl_mulai = $request->get('tgl_mulai');
        $tgl_selesai = $request->get('tgl_selesai');
        $bulan_pilihan = $request->get('bulan');

        if ($bulan_pilihan) {
            $start = Carbon::parse($bulan_pilihan)->startOfMonth();
            $end = Carbon::parse($bulan_pilihan)->endOfMonth();

            $tgl_mulai = $start->format('Y-m-d');
            $tgl_selesai = $end->format('Y-m-d');
        } elseif ($tgl_mulai && $tgl_selesai) {

            $start = Carbon::parse($tgl_mulai)->startOfDay();
            $end = Carbon::parse($tgl_selesai)->endOfDay();
        } else {

            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        }

        $transaksi = Transaksi::with(['kasir', 'detail.produk'])
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->get();

        $trx_ids = $transaksi->pluck('id');

        $detail_transaksi = DetailTransaksi::with('produk.kategori')
            ->whereIn('transaksi_id', $trx_ids)
            ->get();

        $total_pendapatan = $transaksi->sum('total_harga');
        $total_produk_terjual = $detail_transaksi->sum('qty');
        $total_transaksi = $transaksi->count();

        $produk_terlaris = DetailTransaksi::select('produk_id')
            ->whereIn('transaksi_id', $trx_ids)
            ->groupBy('produk_id')
            ->selectRaw('SUM(qty) as total_qty')
            ->orderByDesc('total_qty')
            ->first()?->produk;

        $kategori_terlaris = $produk_terlaris ? $produk_terlaris->kategori : null;

        return [
            'transaksi' => $transaksi,
            'detail_transaksi' => $detail_transaksi,
            'total_pendapatan' => $total_pendapatan,
            'total_produk_terjual' => $total_produk_terjual,
            'total_transaksi' => $total_transaksi,
            'produk_terlaris' => $produk_terlaris,
            'kategori_terlaris' => $kategori_terlaris,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'bulan_pilihan' => $bulan_pilihan,
            'periode' => $start->format('d M Y') . ' - ' . $end->format('d M Y')
        ];
    }
}