@extends('layouts.app')

@section('title', 'Data Produk')
@section('page_title', 'Manajemen Produk')

@section('content')

<style>
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


    .btn-add {
        padding: 12px 24px;
        background: #fff;
        color: #000;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(255,255,255,0.2);
    }

    .btn-add:hover {
        background: #000;
        color: #fff;
        transform: translateY(-2px);
    }

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

    .btn-action {
        padding: 6px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: 0.2s;
    }

    .btn-edit { background: #f0f0f0; color: #333; }
    .btn-delete { background: #fff1f1; color: #e53e3e; border: none; cursor: pointer; }

    .btn-action:hover { opacity: 0.8; }

    .alert-success {
        padding: 15px;
        background: #e6fffa;
        color: #2c7a7b;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 5px solid #38b2ac;
        font-weight: 600;
    }
</style>

<div class="header-section">
    <div>
        <h2>Data Produk</h2>
        <p style="color: #bbb; font-size: 14px; margin-top: 5px;">Manajemen inventaris dan stok barang Anda.</p>
    </div>
    <a href="{{ route('produk.create') }}" class="btn-add">
        <i data-lucide="plus"></i> Tambah Produk
    </a>
</div>

@if(session('success'))
    <div class="alert-success">
        <i data-lucide="check-circle" style="width: 18px; vertical-align: middle;"></i> 
        {{ session('success') }}
    </div>
@endif

<div class="filter-card">
    <form action="{{ route('produk.index') }}" method="GET" class="search-form">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari nama produk..." value="{{ request('keyword') }}">
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
            <a href="{{ route('produk.index') }}" style="color: #888; text-decoration: none; align-self: center; font-size: 13px;">Reset</a>
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
                    <th style="text-align: center;">Stok</th>
                    <th style="text-align: right;">Harga</th>
                    <th>Terakhir Update</th>
                    <th style="text-align: center;">Aksi</th>
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
                        <span class="badge-stok {{ $p->stok > 10 ? 'stok-aman' : 'stok-kritis' }}">
                            {{ $p->stok }}
                        </span>
                    </td>
                    <td style="text-align: right; font-weight: 700;">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </td>
                    <td style="color: #888; font-size: 12px;">
                        {{ $p->updated_at->format('d-m-y H:i') }}
                    </td>
                    <td style="text-align: center;">
                        <div style="display: flex; gap: 5px; justify-content: center;">
                            <a href="{{ route('produk.edit', $p->id) }}" class="btn-action btn-edit">
                                <i data-lucide="edit-3" style="width: 14px;"></i>
                            </a>
                            <form action="{{ route('produk.delete', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">
                                    <i data-lucide="trash-2" style="width: 14px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 50px; color: #999;">
                        <i data-lucide="package-search" style="width: 40px; height: 40px; margin-bottom: 10px; opacity: 0.3;"></i>
                        <br>Data produk tidak ditemukan.
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