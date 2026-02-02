@extends('layouts.app')

@section('title', 'Data Kasir')
@section('page_title', 'Manajemen Kasir')

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
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .search-wrapper {
        display: flex;
        gap: 10px;
        max-width: 450px;
    }

    .form-control {
        flex: 1;
        padding: 12px 15px;
        border: 2px solid #eee;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #000;
    }

    .btn-search {
        padding: 0 20px;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 700;
        text-transform: uppercase;
    }

    .table-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
        letter-spacing: 1px;
        color: #888;
        border-bottom: 2px solid #eee;
    }

    .custom-table td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
        color: #333;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-aktif { background: #e6fffa; color: #2c7a7b; }
    .status-nonaktif { background: #fff5f5; color: #c53030; }

    .btn-action {
        padding: 8px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: 0.2s;
    }
    .btn-edit { background: #f0f0f0; color: #333; }
    .btn-delete { background: #fff1f1; color: #e53e3e; border: none; cursor: pointer; }

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
        <h2>Data Kasir</h2>
        <p style="color: #bbb; font-size: 14px; margin-top: 5px;">Kelola akun petugas kasir toko Anda.</p>
    </div>
    <a href="{{ route('kasir.create') }}" class="btn-add">
        <i data-lucide="user-plus" style="width:18px;"></i> Tambah Kasir
    </a>
</div>

@if(session('success'))
    <div class="alert-success">
        <i data-lucide="check-circle" style="width: 18px; vertical-align: middle; margin-right: 8px;"></i> 
        {{ session('success') }}
    </div>
@endif

<div class="filter-card">
    <form action="{{ route('kasir.index') }}" method="GET" class="search-wrapper">
        <input type="text" name="keyword" class="form-control" placeholder="Cari nama kasir..." value="{{ request('keyword') }}">
        <button type="submit" class="btn-search">
            <i data-lucide="search" style="width:18px;"></i>
        </button>
        @if(request('keyword'))
            <a href="{{ route('kasir.index') }}" style="align-self: center; color: #888; text-decoration: none; font-size: 13px; margin-left: 5px;">Reset</a>
        @endif
    </form>
</div>

<div class="table-card">
    <div style="overflow-x: auto;">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>Nama Kasir</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th style="text-align: center;">Status</th>
                    <th>Bergabung</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kasir as $index => $k)
                <tr>
                    <td style="text-align: center; color: #999; font-weight: 700;">{{ $index + 1 }}</td>
                    <td>
                        <div style="font-weight: 700; text-transform: uppercase;">{{ $k->nama_kasir }}</div>
                        <div style="font-size: 11px; color: #999;">ID: #{{ str_pad($k->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <i data-lucide="phone" style="width: 12px; color: #bbb;"></i>
                            {{ $k->nomor_hp ?? '-' }}
                        </div>
                    </td>
                    <td style="color: #666; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $k->alamat ?? '-' }}
                    </td>
                    <td style="text-align: center;">
                        <span class="badge {{ $k->status == 'aktif' ? 'status-aktif' : 'status-nonaktif' }}">
                            {{ $k->status }}
                        </span>
                    </td>
                    <td style="color: #888; font-size: 12px;">
                        {{ $k->created_at->format('d M Y') }}
                    </td>
                    <td style="text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('kasir.edit', $k->id) }}" class="btn-action btn-edit" title="Edit Kasir">
                                <i data-lucide="edit-3" style="width: 16px;"></i>
                            </a>
                            <form action="{{ route('kasir.delete', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kasir ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus Kasir">
                                    <i data-lucide="trash-2" style="width: 16px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 50px; color: #bbb;">
                        <i data-lucide="users" style="width: 40px; height: 40px; margin-bottom: 10px; opacity: 0.3;"></i>
                        <br>Tidak ada data kasir yang ditemukan.
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