<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Kasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $query = Produk::query();
        if ($keyword) {
            $query->where('kode_produk', 'like', "%{$keyword}%")
                  ->orWhere('nama_produk', 'like', "%{$keyword}%");
        }
        $produk = $query->get();
        $keranjang = Session::get('keranjang', []);
        return view('kasir.transaksi.index', compact('produk', 'keranjang'));
    }

    public function tambahKeranjang($id)
    {
        $produk = Produk::findOrFail($id);
        
        if ($produk->stok <= 0) {
            return redirect()->back()->with('error', 'Stok produk habis!');
        }

        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$id])) {
            if ($keranjang[$id]['qty'] + 1 > $produk->stok) {
                return redirect()->back()->with('error', "Gagal! Stok {$produk->nama_produk} hanya tersedia {$produk->stok}.");
            }
            $keranjang[$id]['qty']++;
        } else {
            $keranjang[$id] = [
                'id' => $produk->id,
                'nama' => $produk->nama_produk,
                'harga' => $produk->harga,
                'qty' => 1,
            ];
        }

        Session::put('keranjang', $keranjang);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function updateQty(Request $request)
    {
        $keranjang = Session::get('keranjang', []);
        $id = $request->id;
        $qty = (int) $request->qty;

        if (isset($keranjang[$id])) {
            $produk = Produk::find($id);

            if ($qty > $produk->stok) {
                return redirect()->back()->with('error', "Gagal! Stok {$produk->nama_produk} tidak mencukupi (Maks: {$produk->stok}).");
            }

            if ($qty <= 0) {
                unset($keranjang[$id]);
            } else {
                $keranjang[$id]['qty'] = $qty;
            }
            Session::put('keranjang', $keranjang);
        }
        return redirect()->back();
    }

    public function hapusItem($id)
    {
        $keranjang = Session::get('keranjang', []);
        if (array_key_exists($id, $keranjang)) {
            unset($keranjang[$id]);
        }
        Session::put('keranjang', $keranjang);
        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }

    public function pembayaran()
    {
        $keranjang = Session::get('keranjang', []);
        
        if (empty($keranjang)) {
            return redirect()->route('transaksi.index')->with('error', 'Keranjang kosong!');
        }

        foreach ($keranjang as $id => $item) {
            $produk = Produk::find($id);
            
            if (!$produk || $item['qty'] > $produk->stok) {
                $stokReal = $produk ? $produk->stok : 0;
                return redirect()->route('transaksi.index')
                    ->with('error', "Gagal Masuk Pembayaran! Stok {$item['nama']} tidak mencukupi (Tersedia: {$stokReal}). Mohon kurangi jumlah.");
            }
        }

        return view('kasir.transaksi.pembayaran', ['keranjang' => $keranjang]);
    }

    public function simpanTransaksi(Request $request)
    {
        $keranjang = Session::get('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('transaksi.index')->with('error', 'Keranjang kosong.');
        }

        $request->validate([
            'kasir_id' => 'required|exists:kasir,id',
            'metode_bayar' => 'required|in:cash,qris',
            'uang_tunai' => $request->metode_bayar == 'cash' ? 'required|numeric|min:0' : 'nullable',
        ]);

        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        if ($request->metode_bayar == 'cash' && $request->uang_tunai < $total) {
            return redirect()->back()->with('error', 'Uang tunai tidak cukup.')->withInput();
        }

        DB::beginTransaction();
        try {
            foreach ($keranjang as $item) {
                $produk = Produk::lockForUpdate()->find($item['id']);
                if ($item['qty'] > $produk->stok) {
                    throw new \Exception("Stok {$produk->nama_produk} tiba-tiba tidak mencukupi.");
                }
            }

            $transaksi = Transaksi::create([
                'user_id'           => Auth::id(),
                'kasir_id'          => $request->kasir_id,
                'kode_transaksi'    => 'TRX-' . strtoupper(bin2hex(random_bytes(3))) . '-' . time(),
                'total_harga'       => $total,
                'metode_bayar'      => $request->metode_bayar,
                'uang_tunai'        => $request->metode_bayar == 'cash' ? $request->uang_tunai : $total,
                'kembalian'         => $request->metode_bayar == 'cash' ? ($request->uang_tunai - $total) : 0,
                'tanggal_transaksi' => now(),
            ]);

            foreach ($keranjang as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $item['id'],
                    'qty'          => $item['qty'],
                    'harga'        => $item['harga'],
                    'subtotal'     => $item['harga'] * $item['qty'],
                ]);

                $produk = Produk::find($item['id']);
                $produk->decrement('stok', $item['qty']);
            }

            DB::commit();

            $last_id = $transaksi->id;
            
            Session::forget('keranjang');

            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi Berhasil Disimpan!')
                ->with('last_id', $last_id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('transaksi.index')->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function riwayat(Request $request)
    {
        $query = Transaksi::with(['user', 'kasir']);
        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('tgl_mulai')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->tgl_mulai);
        }
        if ($request->filled('tgl_selesai')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->tgl_selesai);
        }

        $transaksi = $query->orderBy('tanggal_transaksi', 'DESC')
                           ->paginate(10)
                           ->appends($request->all());

        return view('kasir.transaksi.riwayat', compact('transaksi'));
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with('detail.produk')->findOrFail($id);
        return view('kasir.transaksi.struk', compact('transaksi'));
    }

    public function hapusMasal(Request $request)
    {
        $ids = $request->input('ids'); 
        $keranjang = session()->get('keranjang', []);

        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                if (isset($keranjang[$id])) {
                    unset($keranjang[$id]);
                }
            }
            session()->put('keranjang', $keranjang);
            return redirect()->back()->with('success', 'Beberapa produk berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Pilih produk yang ingin dihapus terlebih dahulu.');
    }
}