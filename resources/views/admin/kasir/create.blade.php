@extends('layouts.app')

@section('title', 'Tambah Kasir')
@section('page_title', 'Tambah Kasir')

@section('content')

<style>
    /* Section Header */
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

    /* Solid Card Styling */
    .solid-card {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        max-width: 800px;
        color: #333;
        margin: 0 auto;
    }

    /* Form Layout */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .form-group {
        margin-bottom: 5px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-group label {
        display: block;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        color: #888;
    }

    /* Input Wrapper with Icons */
    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-wrapper i {
        position: absolute;
        left: 15px;
        color: #aaa;
        width: 18px;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px 14px 45px;
        border: 2px solid #eee;
        border-radius: 8px;
        font-size: 15px;
        font-family: inherit;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #000;
        outline: none;
        background: #fcfcfc;
    }

    textarea.form-control {
        padding-left: 16px;
    }

    /* Action Buttons */
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
        transition: 0.3s;
    }

    .btn-cancel:hover {
        background: #eee;
        color: #000;
    }

    /* Error Validation */
    .text-danger {
        color: #e53e3e;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
</style>

<div class="header-section">
    <div style="background: #fff; color: #000; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
        <i data-lucide="user-plus"></i>
    </div>
    <h2>Registrasi Kasir Baru</h2>
</div>

<div class="solid-card">
    <form action="{{ route('kasir.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="nama_kasir">Nama Lengkap</label>
                <div class="input-wrapper">
                    <i data-lucide="user"></i>
                    <input type="text" name="nama_kasir" id="nama_kasir" class="form-control" 
                           placeholder="Masukkan nama lengkap.." value="{{ old('nama_kasir') }}" required>
                </div>
                @error('nama_kasir') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="nomor_hp">Nomor Handphone</label>
                <div class="input-wrapper">
                    <i data-lucide="smartphone"></i>
                    <input type="text" name="nomor_hp" id="nomor_hp" class="form-control" 
                           placeholder="0812xxxx" value="{{ old('nomor_hp') }}">
                </div>
                @error('nomor_hp') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="username">Username Login</label>
                <div class="input-wrapper">
                    <i data-lucide="at-sign"></i>
                    <input type="text" name="username" id="username" class="form-control" 
                           placeholder="username_kasir" value="{{ old('username') }}" required>
                </div>
                @error('username') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password Akun</label>
                <div class="input-wrapper">
                    <i data-lucide="lock"></i>
                    <input type="password" name="password" id="password" class="form-control" 
                           placeholder="Minimal 6 karakter" required>
                </div>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="alamat">Alamat Domisili</label>
                <textarea name="alamat" id="alamat" rows="3" class="form-control" 
                          placeholder="Masukkan alamat lengkap kasir...">{{ old('alamat') }}</textarea>
                @error('alamat') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="action-wrapper">
            <button type="submit" class="btn-save">
                <i data-lucide="user-check" style="width: 18px;"></i> Buat Akun & Profil
            </button>
            <a href="{{ route('kasir.index') }}" class="btn-cancel">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    lucide.createIcons();
</script>

@endsection