@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<div class="dashboard-container">
    <div class="header-section">
        <h1>Dashboard Admin</h1>
        <p>Halo, Selamat datang kembali, <b>{{ auth()->user()->username }}</b>. Semangat menjalankan tugas hari ini di <span>Adidas Steps</span>! 👋</p>
    </div>

    @if($stok_menipis->count() > 0)
        <div class="alert-stok">
            <div class="alert-icon">⚠️</div>
            <div>
                <b>Perhatian!</b> Ada {{ $stok_menipis->count() }} produk dengan stok hampir habis. Segera lakukan pengecekan.
            </div>
        </div>
    @endif

    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-info">
                <p>Total Transaksi Hari Ini</p>
                <h2>{{ $total_transaksi }}</h2>
            </div>
            <div class="stats-icon blue">📋</div>
        </div>
        <div class="stats-card">
            <div class="stats-info">
                <p>Pendapatan Hari Ini</p>
                <h2>Rp {{ number_format($total_pendapatan_hari_ini, 0, ',', '.') }}</h2>
            </div>
            <div class="stats-icon green">💰</div>
        </div>
        <div class="stats-card">
            <div class="stats-info">
                <p>Total Pendapatan</p>
                <h2>Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h2>
            </div>
            <div class="stats-icon gold">📈</div>
        </div>
        <div class="stats-card">
            <div class="stats-info">
                <p>Produk Terjual Hari Ini</p>
                <h2>{{ $produk_terjual }}</h2>
            </div>
            <div class="stats-icon orange">👟</div>
        </div>
        <div class="stats-card">
            <div class="stats-info">
                <p>Total Stok Produk</p>
                <h2>{{ $total_stok }}</h2>
            </div>
            <div class="stats-icon purple">📦</div>
        </div>
        <div class="stats-card">
            <div class="stats-info">
                <p>Total Kategori</p>
                <h2>{{ $total_kategori }}</h2>
            </div>
            <div class="stats-icon dark">🏷️</div>
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-box">
            <h3>Total Transaksi (7 Hari Terakhir)</h3>
            <canvas id="chartTransaksi"></canvas>
        </div>
        <div class="chart-box">
            <h3>Pendapatan (7 Hari Terakhir)</h3>
            <canvas id="chartPendapatan"></canvas>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #2563eb;
        --bg-body: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    .dashboard-container {
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        padding: 20px;
        background: var(--bg-body);
    }

    .header-section h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .header-section p {
        color: var(--text-muted);
        margin-bottom: 30px;
    }

    .header-section span {
        color: var(--primary);
        font-weight: bold;
    }

    .alert-stok {
        background: #fef2f2;
        border-left: 5px solid #ef4444;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        color: #b91c1c;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stats-card {
        background: var(--card-bg);
        padding: 20px;
        border-radius: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        transition: transform 0.2s;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-info p {
        font-size: 14px;
        color: var(--text-muted);
        margin: 0;
        font-weight: 600;
    }

    .stats-info h2 {
        font-size: 24px;
        margin: 5px 0 0 0;
        font-weight: 700;
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .blue { background: #e0e7ff; }
    .green { background: #dcfce7; }
    .gold { background: #fef9c3; }
    .orange { background: #ffedd5; }
    .purple { background: #f3e8ff; }
    .dark { background: #f1f5f9; }

    .charts-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .chart-box {
        background: white;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .chart-box h3 {
        font-size: 18px;
        margin-bottom: 20px;
        color: var(--text-main);
    }

    @media (max-width: 992px) {
        .charts-row { grid-template-columns: 1fr; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const harianLabels = @json($harian_labels);
    const harianValues = @json($harian_values);

    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';

    new Chart(document.getElementById('chartTransaksi'), {
        type: 'line',
        data: {
            labels: harianLabels,
            datasets: [{
                label: 'Transaksi',
                data: harianValues,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#2563eb'
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('chartPendapatan'), {
        type: 'bar',
        data: {
            labels: harianLabels,
            datasets: [{
                label: 'Pendapatan',
                data: harianValues,
                backgroundColor: '#10b981',
                borderRadius: 8,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

@endsection