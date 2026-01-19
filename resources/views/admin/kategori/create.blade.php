@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page_title', 'Tambah Kategori')

@section('content')

<style>
    /* Section Header */
    .header-container {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .header-container h2 {
        font-size: 28px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }

    /* Form Card */
    .form-card {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        max-width: 700px;
        border: 1px solid rgba(255,255,255,0.1);
        color: #333;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        color: #666;
    }

    .form-control {
        width: 100%;
        padding: 15px 18px;
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

    /* Button Actions */
    .action-wrapper {
        display: flex;
        gap: 15px;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 1px solid #eee;
    }

    .btn-save {
        padding: 15px 30px;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 14px;
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
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn-cancel {
        padding: 15px 30px;
        background: #f5f5f5;
        color: #666;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background: #eee;
        color: #000;
    }

    /* Error Message */
    .error-msg {
        color: #e53e3e;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
</style>

<div class="header-container">
    <div style="background: #000; color: #fff; width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
        <i data-lucide="tag" style="width: 24px; height: 24px;"></i>
    </div>
    <h2>Tambah Kategori</h2>
</div>

<div class="form-card">
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="kode_kategori">Kode Kategori</label>
            <input type="text" 
                   name="kode_kategori" 
                   id="kode_kategori" 
                   class="form-control @error('kode_kategori') is-invalid @enderror" 
                   placeholder="Contoh: SHO, ACC, CLO" 
                   value="{{ old('kode_kategori') }}"
                   required>
            @error('kode_kategori')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="nama_kategori">Nama Kategori</label>
            <input type="text" 
                   name="nama_kategori" 
                   id="nama_kategori" 
                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                   placeholder="Contoh: Sepatu Olahraga, Aksesoris..." 
                   value="{{ old('nama_kategori') }}"
                   required>
            @error('nama_kategori')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="action-wrapper">
            <button type="submit" class="btn-save">
                <i data-lucide="save" style="width: 18px;"></i> Simpan Kategori
            </button>
            <a href="{{ route('kategori.index') }}" class="btn-cancel">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    // Pastikan icon lucide aktif
    lucide.createIcons();
</script>

@endsection