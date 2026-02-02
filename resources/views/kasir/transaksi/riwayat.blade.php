@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page_title', 'History')

@section('content')

<style>
    .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .header-flex h2 { font-size: 28px; font-weight: 800; text-transform: uppercase; color: #fff; margin: 0; }

    .search-container {
        background: white; padding: 25px; border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 25px; border: 1px solid #eee;
    }

    .filter-grid {
        display: grid; grid-template-columns: 2fr 1.5fr 1.5fr auto auto;
        gap: 15px; align-items: flex-end;
    }

    .search-wrapper { position: relative; }
    .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa; width: 18px; }
    .label-filter { display: block; font-size: 10px; font-weight: 800; text-transform: uppercase; color: #888; margin-bottom: 8px; }

    .input-search {
        width: 100%; padding: 12px 15px; border: 2px solid #f8f8f8; border-radius: 8px;
        font-size: 14px; transition: 0.3s; background: #fdfdfd; color: #333;
    }
    .input-search-with-icon { padding-left: 45px; }
    .input-search:focus { border-color: #000; outline: none; background: #fff; box-shadow: 0 0 0 4px rgba(0,0,0,0.05); }

    .btn-search {
        background: #000; color: #fff; border: none; height: 48px; padding: 0 25px;
        border-radius: 8px; font-weight: 700; text-transform: uppercase; font-size: 12px;
        cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 8px;
    }
    .btn-search:hover { background: #333; transform: translateY(-1px); }

    .btn-reset {
        display: flex; align-items: center; justify-content: center; height: 48px;
        padding: 0 15px; text-decoration: none; color: #ff4d4d; font-size: 12px; font-weight: 700;
    }

    .card-premium { background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid #eee; }
    .table-modern { width: 100%; border-collapse: collapse; }
    .table-modern thead tr { background: #000; color: white; position: sticky; top: 0; z-index: 10; }
    .table-modern th { padding: 18px 20px; font-size: 11px; text-transform: uppercase; text-align: left; }
    .table-modern td { padding: 18px 20px; font-size: 14px; border-bottom: 1px solid #f0f0f0; color: #333; }
    .table-modern tbody tr:hover { background: #fafafa; }

    .badge-modern { padding: 6px 12px; font-size: 10px; font-weight: 800; border-radius: 4px; text-transform: uppercase; }
    .badge-cash { background: #f0f0f0; color: #555; }
    .badge-qris { background: #000; color: #fff; }

    .btn-struk {
        background: transparent; color: #000; border: 2px solid #000; padding: 8px 15px;
        border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: 800;
        display: inline-flex; align-items: center; gap: 8px; transition: 0.3s;
    }
    .btn-struk:hover { background: #000; color: #fff; }

    /* --- LOADING STATE --- */
    #loading-state { text-align: center; padding: 20px; display: none; font-weight: bold; color: #888; }
</style>

<div class="header-flex">
    <h2><i data-lucide="history"></i> Riwayat Transaksi</h2>
    <div style="font-size: 13px; color: #fff; opacity: 0.8; background: rgba(0,0,0,0.2); padding: 5px 15px; border-radius: 20px;">
        Total: <strong>{{ $transaksi->total() }} Transaksi</strong>
    </div>
</div>

<div class="search-container">
    <form action="{{ route('riwayat.index') }}" method="GET" class="filter-grid">
        <div>
            <label class="label-filter">Kode Transaksi</label>
            <div class="search-wrapper">
                <i data-lucide="search" class="search-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari Kode..." class="input-search input-search-with-icon">
            </div>
        </div>
        
        <div>
            <label class="label-filter">Dari Tanggal</label>
            <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="input-search">
        </div>

        <div>
            <label class="label-filter">Sampai Tanggal</label>
            <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="input-search">
        </div>

        <button type="submit" class="btn-search">
            <i data-lucide="filter" style="width: 16px;"></i> Cari
        </button>

        @if(request('search') || request('tgl_mulai') || request('tgl_selesai'))
            <a href="{{ route('riwayat.index') }}" class="btn-reset">
                <i data-lucide="refresh-cw" style="width: 14px; margin-right: 5px;"></i> Reset
            </a>
        @endif
    </form>
</div>

<div class="card-premium">
    <div id="scroll-container" style="max-height: 600px; overflow-y: auto;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Waktu Transaksi</th>
                    <th>Total Bayar</th>
                    <th>Nama Kasir</th>
                    <th>Metode</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="transaksi-data">
                @forelse($transaksi as $t)
                @php
                    $namaTampil = $t->kasir->nama_kasir ?? $t->kasir->nama ?? $t->user->name ?? 'System';
                @endphp
                <tr>
                    <td style="font-family: 'Courier New', monospace; font-weight: 800; color: #555;">
                        #{{ $t->kode_transaksi }}
                    </td>
                    <td>
                        <div style="font-weight: 700;">{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y') }}</div>
                        <div style="font-size: 12px; color: #999;">{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('H:i') }} WIB</div>
                    </td>
                    <td style="font-weight: 800;">
                        Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800;">
                                {{ strtoupper(substr($namaTampil, 0, 1)) }}
                            </div>
                            <span style="font-weight: 600;">{{ $namaTampil }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge-modern {{ $t->metode_bayar == 'cash' ? 'badge-cash' : 'badge-qris' }}">
                            {{ strtoupper($t->metode_bayar) }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('transaksi.struk', $t->id) }}" target="_blank" class="btn-struk">
                            <i data-lucide="printer" style="width: 14px;"></i> Struk
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 60px; color: #bbb;">
                        <i data-lucide="search-x" style="width: 40px; height: 40px; margin-bottom: 10px; opacity: 0.5;"></i>
                        <p style="margin: 0; font-weight: 600;">Data transaksi tidak ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div id="loading-state">Memuat data lainnya...</div>
    </div>
</div>

<div id="pagination-links" style="display: none;">
    {{ $transaksi->links() }}
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    lucide.createIcons();

    $(document).ready(function() {
        let container = $('#scroll-container');
        let tbody = $('#transaksi-data');
        let loading = $('#loading-state');
        let nextUrl = $('#pagination-links a[rel="next"]').attr('href');

        container.on('scroll', function() {
            if (container.scrollTop() + container.innerHeight() >= container[0].scrollHeight - 50) {
                if (nextUrl) {
                    loadMoreData();
                }
            }
        });

        function loadMoreData() {
            let currentUrl = nextUrl;
            nextUrl = null;

            loading.show();

            $.ajax({
                url: currentUrl,
                type: 'get',
                beforeSend: function() {
                    loading.show();
                }
            })
            .done(function(data) {
                loading.hide();

                let newRows = $(data).find('#transaksi-data').html();
                tbody.append(newRows);

                nextUrl = $(data).find('#pagination-links a[rel="next"]').attr('href');

                lucide.createIcons();
            })
            .fail(function() {
                loading.hide();
            });
        }
    });
</script>

@endsection