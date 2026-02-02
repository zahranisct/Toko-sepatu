<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    .sidebar {
        width: 270px;
        height: 100vh;
        background: #000000;
        padding: 40px 20px; 
        position: fixed;
        left: 0;
        top: 0;
        display: flex;
        flex-direction: column;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border-right: 1px solid #222;
        z-index: 1000;
        box-sizing: border-box;
    }

    .logo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-bottom: 30px;
        border-bottom: 1px solid #222;
        margin-bottom: 20px;
        flex-shrink: 0;
    }

    .logo-text {
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .logo-subtext {
        font-size: 10px;
        letter-spacing: 2px;
        margin-top: 5px;
        text-transform: uppercase;
    }

    .menu {
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 8px;
        overflow-y: auto; 
        padding-right: 5px;
    }

    .menu-label {
        font-size: 10px;
        font-weight: 700;
        color: #444;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 20px 0 10px 10px;
    }

    .menu a {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 18px;
        text-decoration: none;
        color: #888;
        border-radius: 4px;
        transition: all 0.2s ease;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .menu a:hover {
        background: #111;
        color: #fff;
    }

    .menu a.active {
        background: #fff; 
        color: #000 !important;
    }

    .sidebar-footer {
        margin-top: auto;
        padding-top: 20px;
    }

    .logout-btn {
        width: 100%;
        background: transparent;
        color: #fff;
        padding: 14px;
        border: 1px solid #444;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: #ff4d4d;
        border-color: #ff4d4d;
        color: #fff;
    }

    .menu::-webkit-scrollbar { width: 4px; }
    .menu::-webkit-scrollbar-thumb { background: #222; border-radius: 10px; }
</style>

<div class="sidebar">
    <div class="logo-container">
        <div class="logo-text">ADIDAS STEPS</div>
        @if(auth()->user()->role === 'admin')
            <div class="logo-subtext" style="color: #666;">ADMIN MANAGEMENT</div>
        @else
            <div class="logo-subtext" style="color: #aaa; font-weight: 700;">KASIR DASHBOARD</div>
        @endif
    </div>

    <div class="menu">
        <div class="menu-label">Navigation</div>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active':'' }}">
                <i data-lucide="grid"></i> Dashboard
            </a>
            <a href="{{ route('kategori.index') }}" class="{{ request()->is('kategori*') ? 'active':'' }}">
                <i data-lucide="tag"></i> Kategori
            </a>
            <a href="{{ route('produk.index') }}" class="{{ request()->is('produk*') ? 'active':'' }}">
                <i data-lucide="package"></i> Produk
            </a>
            <a href="{{ route('kasir.index') }}" class="{{ request()->is('kasir*') ? 'active':'' }}">
                <i data-lucide="users"></i> Kasir
            </a>
            <a href="{{ route('admin.laporan') }}" class="{{ request()->is('admin/laporan*') ? 'active':'' }}">
                <i data-lucide="bar-chart-3"></i> Laporan
            </a>
        @endif

        @if(auth()->user()->role === 'kasir')
            <a href="{{ route('kasir.dashboard') }}" class="{{ request()->routeIs('kasir.dashboard') ? 'active':'' }}">
                <i data-lucide="grid"></i> Dashboard
            </a>
            <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.index') ? 'active':'' }}">
                <i data-lucide="shopping-bag"></i> Transaksi
            </a>
            <a href="{{ route('riwayat.index') }}" class="{{ request()->routeIs('riwayat.index') ? 'active':'' }}">
                <i data-lucide="history"></i> Riwayat
            </a>
            <a href="{{ route('kasir.viewstok') }}" class="{{ request()->routeIs('kasir.viewstok') ? 'active':'' }}">
            <i data-lucide="box"></i> Stok
            </a>
        @endif
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i data-lucide="power"></i> Logout
            </button>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>