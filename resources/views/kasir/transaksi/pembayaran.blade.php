@extends('layouts.app')

@section('title', 'Finalisasi Pembayaran')
@section('page_title', 'Checkout')

@section('content')

{{-- LOGIKA MENCARI ID KASIR BERDASARKAN USER LOGIN --}}
@php
    $total = 0;
    foreach($keranjang as $item){
        $total += $item['harga'] * $item['qty'];
    }
    // Cari record kasir berdasarkan user_id yang sedang login
    $dataKasir = \App\Models\Kasir::where('user_id', Auth::user()->id)->first();
@endphp

<style>
    .checkout-container { display: grid; grid-template-columns: 1fr 450px; gap: 30px; align-items: start; }
    .card-checkout { background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); overflow: hidden; }
    .card-header-pos { background: #000; color: white; padding: 15px 20px; display: flex; align-items: center; gap: 10px; font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; }
    .table-detail { width: 100%; border-collapse: collapse; }
    .table-detail th { text-align: left; padding: 15px; background: #f8f8f8; font-size: 11px; color: #888; text-transform: uppercase; border-bottom: 2px solid #eee; }
    .table-detail td { padding: 15px; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
    .payment-panel { padding: 25px; }
    .total-display { background: #fdfdfd; border: 2px dashed #eee; padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 25px; }
    .total-display p { margin: 0; font-size: 12px; text-transform: uppercase; color: #888; font-weight: 700; }
    .total-display h2 { margin: 5px 0 0 0; font-size: 32px; font-weight: 900; color: #000; }
    .form-group-pos { margin-bottom: 20px; }
    .form-group-pos label { display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; color: #555; margin-bottom: 8px; }
    .input-pos { width: 100%; padding: 12px 15px; border: 2px solid #eee; border-radius: 8px; font-size: 15px; font-weight: 600; transition: 0.3s; }
    .input-pos-readonly { background: #f5f5f5; color: #777; cursor: not-allowed; }
    .input-pos:focus { border-color: #000; outline: none; }
    .change-box { background: #000; color: #fff; padding: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }
    .btn-finish { width: 100%; padding: 18px; background: #000; color: #fff; border: none; border-radius: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; margin-top: 20px; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; }
    .btn-finish:hover { background: #333; transform: translateY(-2px); }
    #boxQRIS { text-align: center; background: #fff; padding: 20px; border: 2px solid #f0f0f0; border-radius: 12px; }
    .alert-error { background: #fff5f5; color: #c53030; padding: 15px; border-left: 5px solid #fc8181; border-radius: 8px; margin-bottom: 20px; }
</style>

<div class="container-fluid">
    @if ($errors->any() || session('error'))
        <div class="alert-error">
            <h4 style="margin-top:0; font-size: 14px;">Peringatan:</h4>
            {{ session('error') }}
            <ul style="margin-bottom: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="checkout-container">
        <div class="card-checkout">
            <div class="card-header-pos">
                <i data-lucide="shopping-cart"></i> Detail Pesanan
            </div>
            <table class="table-detail">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keranjang as $item)
                    <tr>
                        <td>
                            <div style="font-weight: 700; text-transform: uppercase;">{{ $item['nama'] }}</div>
                            <div style="font-size: 11px; color: #999;">Produk ID: #{{ $item['id'] }}</div>
                        </td>
                        <td style="text-align: center; font-weight: 700;">{{ $item['qty'] }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item['harga'],0,',','.') }}</td>
                        <td style="text-align: right; font-weight: 700;">Rp {{ number_format($item['harga'] * $item['qty'],0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 20px; text-align: right; background: #fafafa;">
                <a href="{{ route('transaksi.index') }}" style="color: #888; text-decoration: none; font-size: 13px; font-weight: 600;">
                    <i data-lucide="arrow-left" style="width: 14px; vertical-align: middle;"></i> Kembali Ubah Keranjang
                </a>
            </div>
        </div>

        <div class="card-checkout">
            <div class="card-header-pos" style="background: #111;">
                <i data-lucide="credit-card"></i> Panel Pembayaran
            </div>
            <div class="payment-panel">
                <div class="total-display">
                    <p>Total Tagihan</p>
                    <h2 id="displayTotal">Rp {{ number_format($total,0,',','.') }}</h2>
                </div>

                <form action="{{ route('transaksi.simpan') }}" method="POST">
                    @csrf
                    <div class="form-group-pos">
                        <label>Kasir Bertugas</label>
                        <input type="text" class="input-pos input-pos-readonly" value="{{ Auth::user()->nama }}" readonly>
                        {{-- MENGIRIM ID KASIR (PRIMARY KEY TABEL KASIR), BUKAN USER ID --}}
                        <input type="hidden" name="kasir_id" value="{{ $dataKasir ? $dataKasir->id : '' }}">
                    </div>

                    <div class="form-group-pos">
                        <label>Metode Pembayaran</label>
                        <select name="metode_bayar" id="metode_bayar" class="input-pos" required>
                            <option value="cash" {{ old('metode_bayar') == 'cash' ? 'selected' : '' }}>TUNAI (CASH)</option>
                            <option value="qris" {{ old('metode_bayar') == 'qris' ? 'selected' : '' }}>QRIS / DIGITAL</option>
                        </select>
                    </div>

                    <div id="inputUangTunai" style="{{ old('metode_bayar') == 'qris' ? 'display:none' : '' }}">
                        <div class="form-group-pos">
                            <label>Uang Tunai Diterima</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 15px; top: 12px; font-weight: 700;">Rp</span>
                                <input type="number" min="0" id="uang_tunai" name="uang_tunai" 
                                       class="input-pos" style="padding-left: 45px;" placeholder="0" value="{{ old('uang_tunai') }}">
                            </div>
                        </div>
                        <div class="change-box" id="boxKembalian">
                            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase;">Kembalian</span>
                            <span id="kembalianText" style="font-size: 18px; font-weight: 900;">Rp 0</span>
                        </div>
                    </div>

                    <div id="boxQRIS" style="{{ old('metode_bayar') == 'qris' ? 'display:block' : 'display:none' }}">
                        <p style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 15px;">Scan untuk bayar</p>
                        <img src="{{ asset('images/qris.png') }}" alt="QRIS" style="width: 200px; margin-bottom: 10px;">
                    </div>

                    <button type="submit" class="btn-finish">
                        <i data-lucide="check-circle-2"></i> Konfirmasi & Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let total = {{ $total }};
    const metode = document.getElementById("metode_bayar");
    const inputTunaiSection = document.getElementById("inputUangTunai");
    const uangInput = document.getElementById("uang_tunai");
    const boxQRIS = document.getElementById("boxQRIS");
    const kembalianText = document.getElementById("kembalianText");

    function hitungKembalian() {
        let bayar = parseInt(uangInput.value) || 0;
        let kembali = bayar - total;
        kembalianText.innerText = "Rp " + new Intl.NumberFormat("id-ID").format(kembali > 0 ? kembali : 0);
        kembalianText.style.color = (kembali >= 0 && bayar > 0) ? "#4ade80" : "#fff";
    }

    uangInput.addEventListener("input", hitungKembalian);
    hitungKembalian();

    metode.addEventListener("change", function() {
        if (this.value === "qris") {
            inputTunaiSection.style.display = "none";
            boxQRIS.style.display = "block";
            uangInput.required = false;
        } else {
            inputTunaiSection.style.display = "block";
            boxQRIS.style.display = "none";
            uangInput.required = true;
        }
    });

    lucide.createIcons();
</script>
@endsection