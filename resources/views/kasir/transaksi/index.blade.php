@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page_title', 'Transaksi')

@section('content')

{{-- --- PENAMBAHAN NOTIFIKASI SUKSES DI SINI --- --}}
@if(session('success'))
    <div id="success-alert" style="background: #e6fffa; color: #2c7a7b; padding: 20px; border-radius: 12px; border-left: 6px solid #38b2ac; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(0,0,0,0.05); animation: slideDown 0.5s ease-out;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="background: #38b2ac; color: white; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="check" style="width: 20px;"></i>
            </div>
            <div>
                <strong style="display: block; font-size: 14px; text-transform: uppercase;">Berhasil!</strong>
                <span style="font-size: 13px; opacity: 0.8;">{{ session('success') }}</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            {{-- Tombol Cetak otomatis muncul jika ada last_id dari controller --}}
            @if(session('last_id'))
                <a href="{{ route('transaksi.struk', session('last_id')) }}" target="_blank" class="btn-solid" style="background: #2c7a7b; font-size: 11px; padding: 8px 15px;">
                    <i data-lucide="printer" style="width: 14px;"></i> Cetak Struk
                </a>
            @endif
            <button onclick="document.getElementById('success-alert').remove()" style="background: transparent; border: none; cursor: pointer; color: #2c7a7b;">
                <i data-lucide="x" style="width: 18px;"></i>
            </button>
        </div>
    </div>

    <style>
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        // Notifikasi hilang otomatis dalam 7 detik
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if(alert) {
                alert.style.transition = "0.5s";
                alert.style.opacity = "0";
                alert.style.transform = "translateY(-20px)";
                setTimeout(() => alert.remove(), 500);
            }
        }, 7000);
    </script>
@endif
{{-- --- AKHIR PENAMBAHAN NOTIFIKASI --- --}}

<style>
    /* Global Section Styling */
    .pos-container { display: flex; flex-direction: column; gap: 25px; }
    .section-card { background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); overflow: hidden; }
    .card-header { background: #000; color: white; padding: 15px 20px; display: flex; align-items: center; gap: 10px; }
    .card-header h3 { margin: 0; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; }

    /* Table Styling */
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background: #f8f8f8; padding: 12px 15px; text-align: left; font-size: 11px; text-transform: uppercase; color: #888; border-bottom: 2px solid #eee; }
    .custom-table td { padding: 12px 15px; border-bottom: 1px solid #f0f0f0; font-size: 14px; vertical-align: middle; }

    /* Stok Alert Styling */
    .row-error { background-color: #fff5f5 !important; }
    .alert-stok-spesifik { color: #e53e3e; font-size: 12px; font-weight: 800; margin-top: 8px; background: #fff5f5; padding: 8px; border-radius: 6px; border: 1px solid #feb2b2; display: flex; align-items: center; gap: 6px; }
    .badge-stok { font-size: 10px; padding: 2px 6px; border-radius: 4px; font-weight: 800; }
    .badge-aman { background: #e6fffa; color: #2c7a7b; }
    .badge-kritis { background: #fff5f5; color: #e53e3e; }

    /* Search Bar */
    .search-box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; gap: 10px; align-items: center; }
    .search-input { flex: 1; padding: 12px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.3s; }
    .search-input:focus { border-color: #000; }

    /* Buttons */
    .btn-solid { background: #000; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 700; text-transform: uppercase; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; text-decoration: none; }
    .btn-solid:hover { background: #333; transform: translateY(-2px); }
    .btn-disabled { background: #ccc !important; color: #666 !important; cursor: not-allowed !important; transform: none !important; }

    /* Quantity Controls */
    .qty-control { display: flex; align-items: center; background: #f5f5f5; padding: 3px; border-radius: 8px; width: fit-content; border: 1px solid #ddd; }
    .qty-input { width: 50px; text-align: center; border: none; background: transparent; font-weight: 800; font-size: 14px; outline: none; }
    .qty-input.input-error { color: #e53e3e; }
    .qty-btn { width: 30px; height: 30px; border: none; background: white; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }

    .cart-summary { background: #000; color: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; border-radius: 0 0 12px 12px; }
    .total-price { font-size: 24px; font-weight: 800; }

    #btnHapusMasal { background: #e53e3e; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer; display: none; align-items: center; gap: 5px; }
    .checkbox-custom { width: 18px; height: 18px; cursor: pointer; accent-color: #000; }
</style>

<div class="pos-container">
    
    <div style="display: flex; align-items: center; gap: 10px; color: white;">
        <i data-lucide="shopping-bag" style="width: 32px; height: 32px;"></i>
        <h2 style="font-size: 28px; font-weight: 800; text-transform: uppercase; margin: 0;">Transaksi Baru</h2>
    </div>

    @if(session('error'))
        <div style="padding:15px; background:#fff5f5; color:#e53e3e; border-left:5px solid #e53e3e; border-radius:8px; margin-bottom: 10px;">
            <i data-lucide="alert-circle" style="width: 18px; vertical-align: middle; margin-right: 8px;"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="search-box">
    <i data-lucide="search" style="color: #999;"></i>
    <form action="{{ route('transaksi.index') }}" method="GET" style="display:flex; flex:1; gap:10px; align-items: center;">
        <input type="text" name="keyword" class="search-input" placeholder="ketik nama atau kode produk..." value="{{ request('keyword') }}">
        
        <button type="submit" class="btn-solid">Cari Produk</button>

        @if(request('keyword'))
            <a href="{{ route('transaksi.index') }}" class="btn-solid" style="background: #f5f5f5; color: #666; border: 1px solid #ddd;">
                <i data-lucide="refresh-cw" style="width: 14px;"></i> Reset
            </a>
        @endif
    </form>
</div>

    <div class="section-card">
        <div class="card-header">
            <i data-lucide="box" style="width: 18px;"></i>
            <h3>Katalog Produk</h3>
        </div>
        <div style="max-height: 300px; overflow-y: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Info Produk</th>
                        <th>Stok Tersedia</th>
                        <th>Harga</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produk as $index => $p)
                    <tr>
                        <td style="text-align: center; color: #bbb;">{{ $index+1 }}</td>
                        <td>
                            <div style="font-weight: 700; text-transform: uppercase;">{{ $p->nama_produk }}</div>
                            <div style="font-size: 11px; color: #999;">{{ $p->kode_produk }}</div>
                        </td>
                        <td>
                            <span class="badge-stok {{ $p->stok > 0 ? 'badge-aman' : 'badge-kritis' }}">
                                {{ $p->stok }} UNIT
                            </span>
                        </td>
                        <td style="font-weight: 700;">Rp {{ number_format($p->harga,0,',','.') }}</td>
                        <td style="text-align: center;">
                            @if($p->stok > 0)
                                <form action="{{ route('keranjang.tambah', $p->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-solid" style="padding: 6px 12px; font-size: 10px;">
                                        <i data-lucide="plus" style="width: 14px;"></i> Tambah
                                    </button>
                                </form>
                            @else
                                <button disabled class="btn-solid btn-disabled" style="padding: 6px 12px; font-size: 10px;">Habis</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="section-card">
        <form id="formHapusMasal" action="{{ route('keranjang.hapusMasal') }}" method="POST">
            @csrf
            <div class="card-header" style="background: #111; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="shopping-cart" style="width: 18px;"></i>
                    <h3>Keranjang Belanja</h3>
                </div>
                <button type="button" id="btnHapusMasal" onclick="if(confirm('Hapus item terpilih?')) document.getElementById('formHapusMasal').submit()">
                    <i data-lucide="trash-2" style="width: 14px;"></i> Hapus Terpilih (<span id="countSelected">0</span>)
                </button>
            </div>
            
            @if(!empty($keranjang))
            @php $bolehBayar = true; @endphp
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">
                            <input type="checkbox" id="selectAll" class="checkbox-custom">
                        </th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th style="text-align: center;">Kuantitas</th>
                        <th>Subtotal</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($keranjang as $item)
                    @php
                        $produkDB = \App\Models\Produk::find($item['id']);
                        $stokTersedia = $produkDB ? $produkDB->stok : 0;
                        $stokKurang = $item['qty'] > $stokTersedia;
                        
                        if($stokKurang) { $bolehBayar = false; }
                        
                        $subtotal = $item['harga'] * $item['qty'];
                        $total += $subtotal;
                    @endphp
                    <tr class="{{ $stokKurang ? 'row-error' : '' }}">
                        <td style="text-align: center;">
                            <input type="checkbox" name="ids[]" value="{{ $item['id'] }}" class="checkbox-custom selectItem">
                        </td>
                        <td>
                            <div style="font-weight: 700; text-transform: uppercase;">{{ $item['nama'] }}</div>
                            @if($stokKurang)
                                <div class="alert-stok-spesifik">
                                    <i data-lucide="alert-circle" style="width: 14px;"></i>
                                    Stok <strong>{{ $item['nama'] }}</strong> tidak mencukupi! (Tersedia: {{ $stokTersedia }})
                                </div>
                            @endif
                        </td>
                        <td>Rp {{ number_format($item['harga'],0,',','.') }}</td>
                        <td style="text-align: center;">
                            <div style="display: flex; justify-content: center;">
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" onclick="updateQtyDirect('{{ $item['id'] }}', {{ $item['qty'] - 1 }})" {{ $item['qty'] <= 1 ? 'disabled' : '' }}>-</button>
                                    <input type="number" class="qty-input {{ $stokKurang ? 'input-error' : '' }}" value="{{ $item['qty'] }}" min="1" onchange="updateQtyDirect('{{ $item['id'] }}', this.value)">
                                    <button type="button" class="qty-btn" onclick="updateQtyDirect('{{ $item['id'] }}', {{ $item['qty'] + 1 }})">+</button>
                                </div>
                            </div>
                        </td>
                        <td style="font-weight: 700;">Rp {{ number_format($subtotal,0,',','.') }}</td>
                        <td style="text-align: center;">
                            <button type="button" class="qty-btn" style="color:red; margin:auto;" onclick="if(confirm('Hapus item ini?')) deleteSingle('{{ $item['id'] }}')">
                                <i data-lucide="trash-2" style="width: 14px;"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-summary">
                <div>
                    <p style="margin: 0; font-size: 11px; text-transform: uppercase; opacity: 0.6;">Total Pembayaran</p>
                    <div class="total-price">Rp {{ number_format($total,0,',','.') }}</div>
                </div>

                @if($bolehBayar)
                    <a href="{{ route('transaksi.pembayaran') }}" class="btn-solid" style="background: #fff; color: #000; padding: 15px 30px; font-size: 14px; text-decoration: none;">
                        Lanjutkan Pembayaran <i data-lucide="arrow-right" style="width: 18px;"></i>
                    </a>
                @else
                    <button type="button" class="btn-solid btn-disabled" style="padding: 15px 30px; font-size: 14px; cursor: not-allowed;" disabled>
                        Stok Tidak Mencukupi <i data-lucide="x-circle" style="width: 18px;"></i>
                    </button>
                @endif
            </div>
            @endif
        </form>
    </div>
</div>

<form id="hiddenUpdateForm" action="{{ route('transaksi.updateItem') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="id" id="h_id">
    <input type="hidden" name="qty" id="h_qty">
</form>

<form id="hiddenDeleteForm" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

<script>
    lucide.createIcons();

    function updateQtyDirect(id, qty) {
        if(qty < 1 || qty === "") return;
        document.getElementById('h_id').value = id;
        document.getElementById('h_qty').value = qty;
        document.getElementById('hiddenUpdateForm').submit();
    }

    function deleteSingle(id) {
        const form = document.getElementById('hiddenDeleteForm');
        form.action = "{{ url('/transaksi/hapus-item') }}/" + id;
        form.submit();
    }

    const selectAll = document.getElementById('selectAll');
    const selectItems = document.querySelectorAll('.selectItem');
    const btnHapusMasal = document.getElementById('btnHapusMasal');
    const countSelected = document.getElementById('countSelected');

    function toggleBulkButton() {
        const checkedCount = document.querySelectorAll('.selectItem:checked').length;
        if(countSelected) countSelected.innerText = checkedCount;
        if(btnHapusMasal) btnHapusMasal.style.display = checkedCount > 0 ? 'flex' : 'none';
    }

    if(selectAll) {
        selectAll.addEventListener('change', function() {
            selectItems.forEach(item => item.checked = this.checked);
            toggleBulkButton();
        });
    }
    selectItems.forEach(item => item.addEventListener('change', toggleBulkButton));
</script>

@endsection