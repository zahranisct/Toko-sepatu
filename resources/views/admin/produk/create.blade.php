@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page_title', 'Tambah Produk')

@section('content')

<style>
    .header-section {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .header-section h2 {
        font-size: 28px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #fff;
    }

    .solid-card {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        max-width: 850px;
        color: #333;
    }

    /* Grid System for Form */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        color: #666;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #eee;
        border-radius: 6px;
        font-size: 15px;
        font-family: inherit;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #000;
        outline: none;
        background: #fafafa;
    }

    /* Input Prefix for Price */
    .price-input-wrapper {
        position: relative;
    }

    .price-input-wrapper span {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 700;
        color: #999;
    }

    .price-input-wrapper input {
        padding-left: 45px;
    }

    /* Action Buttons */
    .action-wrapper {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #eee;
    }

    .btn-save {
        padding: 15px 30px;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-save:hover {
        background: #333;
        transform: translateY(-2px);
    }

    .btn-cancel {
        padding: 15px 30px;
        background: #f5f5f5;
        color: #666;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .btn-cancel:hover {
        background: #eee;
        color: #000;
    }
</style>

<div class="header-section">
    <div style="background: #fff; color: #000; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
        <i data-lucide="package-plus"></i>
    </div>
    <h2>Tambah Produk Baru</h2>
</div>

<div class="solid-card">
    <form action="{{ route('produk.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group full-width">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Contoh: Adidas Ultraboost Light" value="{{ old('nama_produk') }}" required>
            </div>

            <div class="form-group">
                <label for="kategori_id">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="model">Model / Artikel</label>
                <input type="text" name="model" id="model" class="form-control" placeholder="Contoh: Running / HQ6339" value="{{ old('model') }}" required>
            </div>

            <div class="form-group">
                <label for="warna">Warna</label>
                <input type="text" name="warna" id="warna" class="form-control" placeholder="Contoh: Core Black / Cloud White" value="{{ old('warna') }}" required>
            </div>

            <div class="form-group">
                <label for="stok">Jumlah Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok', 0) }}" min="0" required>
            </div>

            <div class="form-group full-width">
                <label for="harga">Harga Jual</label>
                <div class="price-input-wrapper">
                    <span>Rp</span>
                    <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga', 0) }}" min="0" required>
                </div>
            </div>
        </div>

        <div class="action-wrapper">
            <button type="submit" class="btn-save">
                <i data-lucide="save" style="width: 18px;"></i> Simpan Produk
            </button>
            <a href="{{ route('produk.index') }}" class="btn-cancel">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    lucide.createIcons();
</script>

@endsection