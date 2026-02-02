<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class StrukController extends Controller
{
    public function cetak($id)
    {

        $transaksi = Transaksi::with('user')->findOrFail($id);

        $detail = DetailTransaksi::with('produk')
                    ->where('transaksi_id', $id)
                    ->get();

        return view('kasir.transaksi.struk', compact('transaksi', 'detail'));
    }
}
