@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page_title', 'Edit Kategori')

@section('content')

<style>
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
        color: #fff;
    }

    .solid-card {
        background: #ffffff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        max-width: 700px;
        color: #333;
    }


    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 800;
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
        color: #000;
        font-family: inherit;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #000;
        background: #fcfcfc;
        outline: none;
    }

    .action-wrapper {
        display: flex;
        gap: 15px;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 1px solid #eee;
    }

    .btn-update {
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

    .btn-update:hover {
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
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background: #eee;
        color: #000;
    }

    .error-msg {
        color: #e53e3e;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
</style>

<div class="header-container">
    <div style="background: #fff; color: #000; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
        <i data-lucide="edit" style="width: 24px; height: 24px;"></i>
    </div>
    <h2>Edit Kategori</h2>
</div>

<div class="solid-card">
    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kode_kategori">Kode Kategori</label>
            <input type="text" 
                   name="kode_kategori" 
                   id="kode_kategori" 
                   class="form-control @error('kode_kategori') is-invalid @enderror" 
                   value="{{ old('kode_kategori', $kategori->kode_kategori) }}" 
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
                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                   required>
            @error('nama_kategori')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="action-wrapper">
            <button type="submit" class="btn-update">
                <i data-lucide="save" style="width: 18px;"></i> Simpan Perubahan
            </button>
            <a href="{{ route('kategori.index') }}" class="btn-cancel">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    lucide.createIcons();
</script>

@endsection