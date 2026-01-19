<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $hariIni = date('Y-m-d');

        // ============================
        //     DATA STATISTIK UTAMA
        // ============================
        $total_transaksi = Transaksi::whereDate('tanggal_transaksi', $hariIni)->count();
        $total_pendapatan_hari_ini = Transaksi::whereDate('tanggal_transaksi', $hariIni)->sum('total_harga');
        $total_pendapatan = Transaksi::sum('total_harga');
        $produk_terjual = DB::table('detail_transaksi')->whereDate('created_at', $hariIni)->sum('qty');
        $total_stok = Produk::sum('stok');
        $stok_menipis = Produk::where('stok', '<=', 5)->get();
        $total_kategori = DB::table('kategori_produk')->count();

        // ============================
        //     GRAFIK 7 HARI TERAKHIR
        // ============================
        $grafik_harian = Transaksi::select(
                DB::raw('DATE(tanggal_transaksi) as tanggal'),
                DB::raw('SUM(total_harga) as total')
            )
            ->where('tanggal_transaksi', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $harian_labels = $grafik_harian->pluck('tanggal');
        $harian_values = $grafik_harian->pluck('total');

        // ============================
        //   GRAFIK 12 BULAN TERAKHIR
        // ============================
        $grafik_bulanan = Transaksi::select(
                DB::raw("DATE_FORMAT(tanggal_transaksi, '%Y-%m') as bulan"),
                DB::raw("SUM(total_harga) as total")
            )
            ->where('tanggal_transaksi', '>=', now()->subMonths(12))
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->get();

        $bulanan_labels = $grafik_bulanan->pluck('bulan');
        $bulanan_values = $grafik_bulanan->pluck('total');

        // ============================
        //         RETURN VIEW
        // ============================
        return view('admin.dashboard', [
            'total_transaksi' => $total_transaksi,
            'total_pendapatan_hari_ini' => $total_pendapatan_hari_ini,
            'total_pendapatan' => $total_pendapatan,
            'produk_terjual' => $produk_terjual,
            'total_stok' => $total_stok,
            'stok_menipis' => $stok_menipis,
            'total_kategori' => $total_kategori,

            // Grafik
            'harian_labels' => $harian_labels,
            'harian_values' => $harian_values,
            'bulanan_labels' => $bulanan_labels,
            'bulanan_values' => $bulanan_values,

            // Judul navbar
            'page_title' => 'Dashboard Admin',
        ]);
    }
}
