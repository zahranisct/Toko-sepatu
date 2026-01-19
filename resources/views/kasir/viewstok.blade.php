@extends('layouts.app')

@section('title', 'Cek Stok Produk')
@section('page_title', 'Stok Barang')

@section('content')

<style>
    /* Header Section */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header-section h2 {
        font-size: 28px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
        color: #fff;
    }

    /* Filter & Search Card */
    .filter-card {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .search-form {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .input-group {
        flex: 1;
        min-width: 250px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #eee;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s;
        outline: none;
    }

    .form-control:focus {
        border-color: #000;
    }

    .btn-search {
        padding: 10px 25px;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-search:hover {
        background: #333;
    }

    /* Table Styling */
    .table-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        overflow: hidden;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        color: #333;
    }

    .custom-table th {
        text-align: left;
        padding: 15px;
        background: #f8f8f8;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #888;
        border-bottom: 2px solid #eee;
    }

    .custom-table td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }

    .badge-kode {
        background: #000;
        color: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 12px;
    }

    .badge-stok {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .stok-aman { background: #e6fffa; color: #2c7a7b; }
    .stok-kritis { background: #fff5f5; color: #c53030; }

</style>

<div class="header-section">
    <div>
        <h2>Informasi Stok</h2>
        <p style="color: #bbb; font-size: 14px; margin-top: 5px;">Pantau ketersediaan barang secara real-time.</p>
    </div>
</div>

<div class="filter-card">
    {{-- Pastikan route ini sesuai dengan route index kasir anda --}}
    <form action="{{ route('kasir.viewstok') }}" method="GET" class="search-form">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari nama atau kode produk..." value="{{ request('keyword') }}">
        </div>

        <div class="input-group">
            <select name="kategori_id" class="form-control">
                <option value="">-- Semua Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-search">
            <i data-lucide="search" style="width: 18px; vertical-align: middle;"></i> Cari
        </button>
        
        @if(request('keyword') || request('kategori_id'))
            <a href="{{ route('kasir.viewstok') }}" style="color: #888; text-decoration: none; align-self: center; font-size: 13px; margin-left: 10px;">Reset</a>
        @endif
    </form>
</div>

<div class="table-card">
    <div style="overflow-x: auto;">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th style="text-align: center;">Status Stok</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk as $index => $p)
                <tr>
                    <td style="text-align: center; color: #999; font-weight: 700;">{{ $index+1 }}</td>
                    <td><span class="badge-kode">{{ $p->kode_produk }}</span></td>
                    <td style="font-weight: 700; text-transform: uppercase;">{{ $p->nama_produk }}</td>
                    <td><span style="color: #666;">{{ $p->kategori->nama_kategori ?? '-' }}</span></td>
                    <td style="text-align: center;">
                        @if($p->stok > 10)
                            <span style="color: #38b2ac; font-size: 12px; font-weight: 600;">Tersedia</span>
                        @elseif($p->stok > 0)
                            <span style="color: #d69e2e; font-size: 12px; font-weight: 600;">Hampir Habis</span>
                        @else
                            <span style="color: #e53e3e; font-size: 12px; font-weight: 600;">Habis</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <span class="badge-stok {{ $p->stok > 10 ? 'stok-aman' : 'stok-kritis' }}">
                            {{ $p->stok }}
                        </span>
                    </td>
                    <td style="text-align: right; font-weight: 700;">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 50px; color: #999;">
                        <i data-lucide="package-search" style="width: 40px; height: 40px; margin-bottom: 10px; opacity: 0.3;"></i>
                        <br>Produk tidak ditemukan dalam inventaris.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

@endsection