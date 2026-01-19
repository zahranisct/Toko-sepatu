<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class DashboardKasirController extends Controller
{
    public function index()
    {
        $hariIni = date('Y-m-d');

        return view('kasir.dashboard', [
            'total_transaksi' => Transaksi::whereDate('tanggal_transaksi', $hariIni)->count(),

            'total_pendapatan_hari_ini' => Transaksi::whereDate('tanggal_transaksi', $hariIni)
                                                    ->sum('total_harga'),

            'total_produk_terjual' => DB::table('detail_transaksi')
                                        ->whereDate('created_at', $hariIni)
                                        ->sum('qty'),
        ]);
    }
}
