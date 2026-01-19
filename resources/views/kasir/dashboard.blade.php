@extends('layouts.app')

@section('title', 'Dashboard Kasir')
@section('page_title', 'Dashboard')

@section('content')

<style>
    /* Greeting Section */
    .welcome-header {
        margin-bottom: 40px;
        color: #fff;
    }

    .welcome-header h1 {
        font-size: 32px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: -0.5px;
        margin: 0;
        line-height: 1.2;
    }

    .welcome-header p {
        font-size: 16px;
        opacity: 0.8;
        margin-top: 8px;
    }

    /* Grid Layout */
    .grid-kasir {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        max-width: 1000px;
    }

    /* Card Styling */
    .card-kasir {
        background: #fff;
        padding: 35px;
        border-radius: 4px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-left: 6px solid #000;
    }

    .card-kasir:hover {
        transform: translateY(-5px);
    }

    .card-kasir p {
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        color: #888;
        letter-spacing: 1.5px;
        margin-bottom: 10px;
    }

    .card-kasir h2 {
        font-size: 42px;
        font-weight: 900;
        margin: 0;
        color: #000;
        letter-spacing: -1px;
    }

    /* Icon Background Decal */
    .card-icon-decal {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 80px;
        opacity: 0.05;
        transform: rotate(-15deg);
        color: #000;
    }

    /* Featured Card */
    .featured-card {
        grid-column: span 2;
        background: #000;
        border-left: 6px solid #fff;
        color: #fff;
    }

    .featured-card p {
        color: #aaa;
    }

    .featured-card h2 {
        color: #fff;
        font-size: 48px;
    }

    .featured-card .card-icon-decal {
        color: #fff;
        opacity: 0.15;
    }

    /* Quick Action Button */
    .btn-pos {
        margin-top: 30px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        background: #fff;
        color: #000;
        text-decoration: none;
        font-weight: 800;
        text-transform: uppercase;
        border-radius: 4px;
        transition: 0.3s;
    }

    .btn-pos:hover {
        background: #eee;
        letter-spacing: 1px;
    }
</style>

<div class="welcome-header">
    {{-- Menampilkan Username di dalam tanda kutip --}}
    <h1>HALO, SELAMAT DATANG "{{ strtoupper(Auth::user()->username) }}"! 👋</h1>
    <p>Pantau performa penjualanmu hari ini.</p>
</div>

<div class="grid-kasir">

    <div class="card-kasir">
        <div class="card-icon-decal">
            <i data-lucide="shopping-cart"></i>
        </div>
        <p>Total Transaksi</p>
        <h2>{{ number_format($total_transaksi, 0, ',', '.') }}</h2>
    </div>

    <div class="card-kasir">
        <div class="card-icon-decal">
            <i data-lucide="package"></i>
        </div>
        <p>Produk Terjual</p>
        <h2>{{ number_format($total_produk_terjual, 0, ',', '.') }} <span style="font-size: 14px; font-weight: 400; color: #888;">Items</span></h2>
    </div>

    <div class="card-kasir featured-card">
        <div class="card-icon-decal">
            <i data-lucide="banknote"></i>
        </div>
        <p>Total Pendapatan Hari Ini</p>
        <h2>Rp {{ number_format($total_pendapatan_hari_ini, 0, ',', '.') }}</h2>
        
        <div style="margin-top: 20px;">
            <a href="{{ route('transaksi.index') }}" class="btn-pos">
                <i data-lucide="plus-circle"></i> Mulai Transaksi Baru
            </a>
        </div>
    </div>

</div>

<script>
    lucide.createIcons();
</script>

@endsection