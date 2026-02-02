@extends('layouts.app')

@section('title', 'Laporan Transaksi')
@section('page_title', 'Detail Laporan')

@section('content')

<style>
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .report-header h2 {
        font-size: 28px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #fff;
        margin: 0;
    }

    .filter-box {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        padding: 25px;
        border-radius: 16px;
        margin-bottom: 35px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    .filter-form {
        display: flex;
        gap: 20px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
        min-width: 180px;
    }

    .filter-group label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 1.2px;
        margin-left: 2px;
    }

    .filter-input {
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.9);
        font-size: 14px;
        font-weight: 600;
        color: #333;
        transition: all 0.3s ease;
        width: 100%;
    }

    .filter-input:focus {
        outline: none;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        border-color: #fff;
    }

    .btn-search {
        background: #fff;
        color: #000;
        padding: 0 28px;
        border-radius: 10px;
        border: none;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 45px;
    }

    .btn-search:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .btn-reset-link {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        padding-bottom: 15px;
        transition: 0.3s;
        display: flex;
        align-items: center;
    }

    .btn-reset-link:hover {
        color: #ff4d4d;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-info p {
        margin: 0;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 700;
        color: #888;
        letter-spacing: 0.5px;
    }

    .stat-info h3 {
        margin: 5px 0 0 0;
        font-size: 20px;
        font-weight: 800;
        color: #000;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .table-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin-bottom: 40px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th {
        text-align: left;
        padding: 15px;
        background: #f8f8f8;
        font-size: 11px;
        text-transform: uppercase;
        color: #999;
        border-bottom: 2px solid #eee;
    }

    .custom-table td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
        color: #333;
    }

    .method-badge {
        background: #000;
        color: #fff;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .btn-action {
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.3s;
    }
    .btn-view { background: #000; color: #fff; }
    .btn-print { background: #f0f0f0; color: #333; }
    .btn-action:hover { opacity: 0.8; transform: translateY(-2px); }

    .alert-success {
        padding: 15px;
        background: #e6fffa;
        color: #2c7a7b;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 5px solid #38b2ac;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .report-footer-summary {
        background: #000;
        color: #fff;
        padding: 30px;
        border-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .footer-label {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 0.8;
    }

    .footer-value {
        font-size: 32px;
        font-weight: 800;
        margin-top: 5px;
    }

    .btn-print-all {
        background: #fff;
        color: #000;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-print-all:hover {
        background: #f0f0f0;
        transform: scale(1.05);
    }

    @media print {
        nav, .sidebar, .navbar, .footer, aside, .btn-action, .filter-box, .alert-success, .btn-print-all, .no-print {
            display: none !important;
        }

        body, .main-content, .container, .wrapper {
            background: white !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            display: block !important;
        }

        .report-header h2, .section-title {
            color: #000 !important;
        }

        .table-card, .stat-card, .report-footer-summary {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .report-footer-summary {
            background: #eee !important;
            color: #000 !important;
        }
        
        .report-header div {
            background: #eee !important;
            color: #000 !important;
        }
    }
</style>

<div class="report-header">
    <h2>Laporan Transaksi</h2>
    <div style="background: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 8px; color: #fff; font-size: 13px;">
        <i data-lucide="calendar" style="width: 16px; vertical-align: middle; margin-right: 5px;"></i>
        @if($tgl_mulai && $tgl_selesai)
            {{ date('d-m-Y', strtotime($tgl_mulai)) }} - {{ date('d-m-Y', strtotime($tgl_selesai)) }}
        @else
            {{ date('F Y') }}
        @endif
    </div>
</div>

<div class="filter-box">
    <form action="{{ route('admin.laporan') }}" method="GET" class="filter-form">
        <div class="filter-group">
            <label><i data-lucide="layers" style="width: 12px; margin-right: 5px;"></i> Pilih Bulan</label>
            <select name="bulan" class="filter-input" onchange="this.form.submit()">
                <option value="">-- Pilih Bulan --</option>
                @for ($i = 0; $i < 12; $i++)
                    @php
                        $date = \Carbon\Carbon::now()->subMonths($i);
                        $val = $date->format('Y-m');
                        $label = $date->translatedFormat('F Y');
                    @endphp
                    <option value="{{ $val }}" {{ request('bulan') == $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="filter-group">
            <label><i data-lucide="calendar-days" style="width: 12px; margin-right: 5px;"></i> Dari Tanggal</label>
            <input type="date" name="tgl_mulai" class="filter-input" value="{{ $tgl_mulai }}">
        </div>
        
        <div class="filter-group">
            <label><i data-lucide="calendar-range" style="width: 12px; margin-right: 5px;"></i> Sampai Tanggal</label>
            <input type="date" name="tgl_selesai" class="filter-input" value="{{ $tgl_selesai }}">
        </div>

        <button type="submit" class="btn-search">
            <i data-lucide="filter" style="width: 16px;"></i>  Cari Data
        </button>

        @if($tgl_mulai || $tgl_selesai || request('bulan'))
            <a href="{{ route('admin.laporan') }}" class="btn-reset-link" title="Hapus Filter">
                <i data-lucide="refresh-cw" style="width: 14px; margin-right: 5px;"></i> Reset
            </a>
        @endif
    </form>
</div>

@if(session('success'))
    <div class="alert-success">
        <i data-lucide="check-circle" style="width: 20px;"></i>
        {{ session('success') }}
    </div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #e6fffa; color: #38b2ac;">
            <i data-lucide="trending-up"></i>
        </div>
        <div class="stat-info">
            <p>Total Pendapatan</p>
            <h3>Rp {{ number_format($total_pendapatan,0,',','.') }}</h3>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #fff5f5; color: #e53e3e;">
            <i data-lucide="package"></i>
        </div>
        <div class="stat-info">
            <p>Produk Terlaris</p>
            <h3>{{ $produk_terlaris->nama_produk ?? '-' }}</h3>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #ebf8ff; color: #3182ce;">
            <i data-lucide="tag"></i>
        </div>
        <div class="stat-info">
            <p>Kategori Terpopuler</p>
            <h3>{{ $kategori_terlaris->nama_kategori ?? '-' }}</h3>
        </div>
    </div>
</div>

<div class="section-title">
    <i data-lucide="list"></i> Ringkasan Transaksi
</div>
<div class="table-card">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal & Waktu</th>
                <th>Kasir</th>
                <th style="text-align: right;">Total Pembayaran</th>
                <th style="text-align: center;">Metode</th>
                <th style="text-align: center;" class="no-print">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $trx)
            <tr>
                <td style="font-weight: 700; color: #999;">#{{ $trx->id }}</td>
                <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                <td style="font-weight: 600; text-transform: uppercase;">{{ $trx->kasir->nama_kasir ?? '-' }}</td>
                <td style="text-align: right; font-weight: 800;">Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                <td style="text-align: center;">
                    <span class="method-badge">{{ $trx->metode_bayar }}</span>
                </td>
                <td style="text-align: center;" class="no-print">
                    <a href="{{ route('transaksi.struk', $trx->id) }}" target="_blank" class="btn-action btn-view">
                        <i data-lucide="eye" style="width: 14px;"></i> Struk
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="section-title">
    <i data-lucide="box"></i> Detail Per Item
</div>
<div class="table-card">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Harga Unit</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($detail_transaksi as $item)
            <tr>
                <td style="text-align: center; color: #999;">{{ $no++ }}</td>
                <td style="font-weight: 700; text-transform: uppercase;">{{ $item->produk->nama_produk }}</td>
                <td><span style="color: #888;">{{ $item->produk->kategori->nama_kategori ?? '-' }}</span></td>
                <td style="text-align: center; font-weight: 700;">{{ $item->qty }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->harga,0,',','.') }}</td>
                <td style="text-align: right; font-weight: 800; color: #000;">Rp {{ number_format($item->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="report-footer-summary">
    <div>
        <div class="footer-label">Total Akumulasi Pendapatan</div>
        <div class="footer-value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
    </div>
    
    <a href="{{ route('admin.laporan.cetak', ['tgl_mulai' => $tgl_mulai, 'tgl_selesai' => $tgl_selesai]) }}" 
   target="_blank" 
   class="btn-print-all">
    <i data-lucide="printer"></i>
    CETAK LAPORAN SEKARANG
</a>
</div>

<p style="text-align: center; color: #fff; margin-top: 20px; font-size: 12px; opacity: 0.6;" class="no-print">
    Laporan ini digenerate secara otomatis pada {{ date('d-m-Y H:i:s') }}
</p>

<script>
    lucide.createIcons();
</script>

@endsection