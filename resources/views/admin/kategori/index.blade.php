@extends('layouts.app')

@section('title', 'Data Kategori')
@section('page_title', 'Kategori Produk')

@section('content')

<style>
    /* Container Styling */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-heading h2 {
        font-size: 28px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }

    /* Modern Button */
    .btn-add {
        padding: 12px 24px;
        background: #fff;
        color: #000;
        text-decoration: none;
        border-radius: 4px; /* Adidas style sharper corners */
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

    /* Glass Card */
    .glass-card {
        background: rgba(255, 255, 255, 1); /* Putih bersih agar data terbaca */
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        color: #333;
    }

    /* Search Box */
    .search-wrapper {
        margin-bottom: 25px;
        display: flex;
        gap: 10px;
    }

    .search-input {
        flex: 1;
        max-width: 350px;
        padding: 12px 18px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: border 0.3s;
    }

    .search-input:focus {
        border-color: #000;
    }

    .btn-search {
        padding: 0 20px;
        background: #222;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-search:hover {
        background: #000;
    }

    /* Alert Styling */
    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success { background: #e6fffa; color: #2c7a7b; border-left: 5px solid #38b2ac; }
    .alert-info { background: #ebf8ff; color: #2c5282; border-left: 5px solid #4299e1; }
    .alert-danger { background: #fff5f5; color: #c53030; border-left: 5px solid #f56565; }

    /* Custom Table */
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px; /* Memberi jarak antar baris */
        margin-top: 10px;
    }

    .custom-table th {
        background: transparent;
        color: #888;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #f0f0f0;
    }

    .custom-table td {
        padding: 15px;
        background: #fff;
        font-size: 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f7f7f7;
    }

    /* Action Buttons */
    .action-link {
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-edit { background: #f0f0f0; color: #333; }
    .btn-edit:hover { background: #e0e0e0; }

    .btn-delete { background: #fff1f1; color: #e53e3e; border: none; cursor: pointer; }
    .btn-delete:hover { background: #fed7d7; }

    .badge-code {
        background: #000;
        color: #fff;
        padding: 4px 10px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 12px;
    }
</style>

<div class="header-section">
    <div class="page-heading">
        <h2>Kategori Produk</h2>
        <p style="color: #bbb; font-size: 14px; margin-top: 5px;">Kelola kelompok produk Anda di sini.</p>
    </div>
    <a href="{{ route('kategori.create') }}" class="btn-add">
        <i data-lucide="plus" style="width:18px;"></i> Tambah Kategori
    </a>
</div>

<div class="glass-card">
    @if(session('success'))
        <div class="alert alert-success">
            <i data-lucide="check-circle" style="width:18px;"></i>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('kategori.index') }}" method="GET" class="search-wrapper">
        <input type="text" name="keyword" value="{{ request('keyword') }}" 
               class="search-input" placeholder="Cari nama produk...">
        <button type="submit" class="btn-search">
            <i data-lucide="search" style="width:18px;"></i>
        </button>
    </form>

    @if(request('keyword'))
        <div class="alert alert-info">
            <i data-lucide="info" style="width:18px;"></i>
            Menampilkan hasil untuk: <strong>"{{ request('keyword') }}"</strong>
            <a href="{{ route('kategori.index') }}" style="margin-left: auto; color: inherit; font-size: 12px;">Reset</a>
        </div>
    @endif

    @if(request('keyword') && $kategori->isEmpty())
        <div class="alert alert-danger">
            <i data-lucide="alert-circle" style="width:18px;"></i>
            Data tidak ditemukan. Silakan gunakan kata kunci lain.
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th style="width: 150px;">Kode Kategori</th>
                    <th>Nama Kategori</th>
                    <th style="width: 200px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $index => $k)
                <tr>
                    <td style="text-align: center; font-weight: 600; color: #999;">{{ $index+1 }}</td>
                    <td><span class="badge-code">{{ $k->kode_kategori ?? '-' }}</span></td>
                    <td style="font-weight: 600;">{{ $k->nama_kategori }}</td>
                    <td style="text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('kategori.edit', $k->id) }}" class="action-link btn-edit">
                                <i data-lucide="edit-3" style="width:14px;"></i> Edit
                            </a>

                            <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-link btn-delete" onclick="return confirm('Hapus kategori ini?')">
                                    <i data-lucide="trash-2" style="width:14px;"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #999;">Belum ada data kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    // Memastikan icon ter-render di dalam content yang baru di-load
    lucide.createIcons();
</script>

@endsection