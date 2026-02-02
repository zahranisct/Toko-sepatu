<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Transaksi - {{ $periode }}</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.5; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .stats-container { display: flex; justify-content: space-between; margin-bottom: 30px; gap: 10px; }
        .stat-box { flex: 1; border: 1px solid #ccc; padding: 15px; text-align: center; border-radius: 5px; }
        .stat-box span { display: block; font-size: 12px; color: #666; text-transform: uppercase; }
        .stat-box strong { font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th { background: #f2f2f2; padding: 10px; border: 1px solid #ddd; font-size: 12px; text-align: left; }
        table td { padding: 10px; border: 1px solid #ddd; font-size: 12px; vertical-align: top; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2 style="margin:0;">LAPORAN TRANSAKSI</h2>
        <p style="margin:5px 0;">Periode: {{ $periode }}</p>
    </div>
    <div class="stats-container">
        <div class="stat-box">
            <span>Total Pendapatan</span>
            <strong>Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</strong>
        </div>
        <div class="stat-box">
            <span>Produk Terjual</span>
            <strong>{{ $total_produk_terjual }} Item</strong>
        </div>
        <div class="stat-box">
            <span>Total Transaksi</span>
            <strong>{{ $total_transaksi }} Transaksi</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tgl Transaksi</th>
                <th>Kasir</th>
                <th>Produk yang Dibeli</th>
                <th class="text-center">Metode</th>
                <th class="text-right">Total Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $trx)
            <tr>
                <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $trx->kasir->nama_kasir ?? 'N/A' }}</td>
                <td>
                    @foreach($trx->detail as $item)
                        • {{ $item->produk->nama_produk ?? 'Produk Dihapus' }} ({{ $item->qty }})<br>
                    @endforeach
                </td>
                <td class="text-center">{{ $trx->metode_bayar }}</td>
                <td class="text-right"><strong>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Data tidak ditemukan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; font-size: 12px;">
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px;">Cetak Sekarang</button>
        <a href="{{ route('admin.laporan') }}" style="padding: 10px 20px; text-decoration: none; background: #eee; color: #000; border: 1px solid #ccc;">Kembali</a>
    </div>

</body>
</html>