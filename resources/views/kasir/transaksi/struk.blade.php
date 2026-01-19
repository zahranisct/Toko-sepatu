<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - {{ $transaksi->kode_transaksi }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 280px; /* Standar thermal printer */
            margin: auto;
            font-size: 13px;
            color: #000;
            padding: 10px;
        }
        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
        
        img.logo {
            width: 70px;
            height: auto;
            margin-bottom: 5px;
            filter: grayscale(100%); /* Biar lebih tajam di printer hitam putih */
        }

        .item-row {
            margin-bottom: 10px;
            word-wrap: break-word;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
        }

        .btn-print {
            padding: 10px 20px;
            background: #fff;
            border: 2px solid #000;
            cursor: pointer;
            font-family: monospace;
            font-weight: bold;
            width: 100%;
            margin-bottom: 5px;
        }

        .btn-back {
            display: block;
            padding: 10px 20px;
            background: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        /* Sembunyikan tombol saat mencetak */
        @media print {
            .no-print {
                display: none;
            }
            body {
                width: 100%;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>

<div class="center">
    <img src="{{ asset('images/logo3.png') }}" class="logo" alt="Logo">
    <h3 style="margin:0; text-transform: uppercase;">ADIDAS STEPS</h3>
    <small>Jl. Sport Street No. 13 Jakarta Selatan</small><br>
    <small>Telp/WA: 0812 1613 0944</small>
</div>

<div class="line"></div>

<div class="flex-between">
    <span>Kode:</span>
    <b>{{ $transaksi->kode_transaksi }}</b>
</div>
<div class="flex-between">
    <span>Tanggal:</span>
    <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
</div>
<div class="flex-between">
    <span>Kasir:</span>
    <b>{{ $transaksi->user->name ?? $transaksi->kasir->nama_kasir ?? '-' }}</b>
</div>

<div class="line"></div>

@foreach($transaksi->detail as $d)
<div class="item-row">
    <div>{{ $d->produk->nama_produk }}</div>
    <div class="flex-between">
        <span>{{ $d->qty }} x {{ number_format($d->harga, 0, ',', '.') }}</span>
        <b>{{ number_format($d->subtotal, 0, ',', '.') }}</b>
    </div>
</div>
@endforeach

<div class="line"></div>

<div class="flex-between" style="font-size: 16px; font-weight: bold;">
    <span>TOTAL:</span>
    <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
</div>
<div class="flex-between">
    <span>Metode:</span>
    <b>{{ strtoupper($transaksi->metode_bayar) }}</b>
</div>

@if($transaksi->metode_bayar == 'cash')
<div class="flex-between">
    <span>Bayar:</span>
    <span>Rp {{ number_format($transaksi->uang_tunai, 0, ',', '.') }}</span>
</div>
<div class="flex-between">
    <span>Kembali:</span>
    <b>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</b>
</div>
@endif

<div class="line"></div>

<div class="center">
    <p style="margin:2px;">Terima kasih telah berbelanja!</p>
    <p style="margin:2px;">Barang yang sudah dibeli tidak</p>
    <p style="margin:2px;">dapat ditukar/kembalikan.</p>
</div>

<div class="line"></div>

<div class="center">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $transaksi->kode_transaksi }}"
         style="width:100px; height:100px;" alt="QR Code">
    <p style="margin:3px;"><small>Scan untuk validasi</small></p>
</div>

<div class="line"></div>

{{-- BAGIAN TOMBOL KENDALI --}}
<div class="center no-print" style="margin-top: 20px;">
    <button class="btn-print" onclick="window.print()">CETAK STRUK</button>
    
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.laporan') }}" class="btn-back">
            KEMBALI
        </a>
    @else
        <a href="{{ route('riwayat.index') }}" class="btn-back" style="background: #444;">
            KEMBALI
        </a>
    @endif
</div>

<br><br>

</body>
</html>