@extends('layouts.app')

@section('title', 'Edit Kasir')
@section('page_title', 'Edit Kasir')

@section('content')

<style>
    .header-section { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .header-section h2 { font-size: 28px; font-weight: 800; text-transform: uppercase; color: #fff; }
    .solid-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); max-width: 850px; margin: 0 auto; color: #333; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
    .form-group { margin-bottom: 5px; }
    .form-group.full-width { grid-column: span 2; }
    .form-group label { display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 10px; color: #666; }
    .input-wrapper { position: relative; display: flex; align-items: center; }
    .input-wrapper i { position: absolute; left: 15px; color: #aaa; width: 18px; }
    .form-control { width: 100%; padding: 14px 16px 14px 45px; border: 2px solid #eee; border-radius: 8px; font-size: 15px; transition: all 0.3s ease; box-sizing: border-box; }
    .form-control:focus { border-color: #000; outline: none; background: #fcfcfc; }
    .action-wrapper { display: flex; gap: 15px; margin-top: 35px; padding-top: 25px; border-top: 1px solid #eee; }
    .btn-update { padding: 15px 30px; background: #000; color: #fff; border: none; border-radius: 4px; font-weight: 700; text-transform: uppercase; cursor: pointer; display: flex; align-items: center; gap: 10px; }
    .btn-cancel { padding: 15px 30px; background: #f5f5f5; color: #666; text-decoration: none; border-radius: 4px; font-weight: 700; text-transform: uppercase; }
    .text-helper { font-size: 11px; color: #999; margin-top: 5px; display: block; }
</style>

<div class="header-section">
    <div style="background: #fff; color: #000; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
        <i data-lucide="user-cog"></i>
    </div>
    <h2>Edit Data Kasir</h2>
</div>

<div class="solid-card">
    <form action="{{ route('kasir.update', $kasir->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="nama_kasir">Nama Lengkap</label>
                <div class="input-wrapper">
                    <i data-lucide="user"></i>
                    <input type="text" name="nama_kasir" id="nama_kasir" class="form-control" value="{{ old('nama_kasir', $kasir->nama_kasir) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="username">Username Login</label>
                <div class="input-wrapper">
                    <i data-lucide="at-sign"></i>
                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $kasir->user->username ?? '') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="nomor_hp">Nomor Handphone</label>
                <div class="input-wrapper">
                    <i data-lucide="smartphone"></i>
                    <input type="text" name="nomor_hp" id="nomor_hp" class="form-control" value="{{ old('nomor_hp', $kasir->nomor_hp) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Ganti Password</label>
                <div class="input-wrapper">
                    <i data-lucide="lock"></i>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Isi jika ingin ganti">
                </div>
                <small class="text-helper">isi Password</small>
            </div>

            <div class="form-group full-width">
                <label for="status">Status Kepegawaian</label>
                <div class="input-wrapper">
                    <i data-lucide="shield-check"></i>
                    <select name="status" id="status" class="form-control">
                        <option value="aktif" {{ $kasir->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $kasir->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="form-group full-width">
                <label for="alamat">Alamat Domisili</label>
                <textarea name="alamat" id="alamat" rows="3" class="form-control" style="padding-left: 16px;">{{ old('alamat', $kasir->alamat) }}</textarea>
            </div>
        </div>

        <div class="action-wrapper">
            <button type="submit" class="btn-update">
                <i data-lucide="refresh-cw"></i> Simpan Perubahan
            </button>
            <a href="{{ route('kasir.index') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>

<script>lucide.createIcons();</script>
@endsection