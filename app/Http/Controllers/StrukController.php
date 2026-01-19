<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class StrukController extends Controller
{
    public function cetak($id)
    {
        // Ambil transaksi
        $transaksi = Transaksi::with('user')->findOrFail($id);

        // Ambil semua detail item dalam transaksi
        $detail = DetailTransaksi::with('produk')
                    ->where('transaksi_id', $id)
                    ->get();

        return view('transaksi.struk', compact('transaksi', 'detail'));
    }
}
