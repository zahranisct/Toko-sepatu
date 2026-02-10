@extends('layouts.app')

@section('page_title', 'Rating Pelayanan')

@section('content')
<div style="padding: 40px; font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; min-height: 100vh; color: #000;">
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; border-bottom: 2px solid #000; padding-bottom: 20px;">
        <div>
            <h1 style="font-weight: 800; font-size: 28px; letter-spacing: -0.5px; margin: 0; text-transform: uppercase;">
                Rating Pelayanan
            </h1>
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #666; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">
                Berikan rating yang sesuai dengan pelayanan yang diterima pelanggan
           </p>
        </div>
        <div style="text-align: right;">
            <p style="margin: 0; font-size: 10px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 1px;">Kasir Bertugas</p>
            <p style="margin: 0; font-size: 15px; font-weight: 700; color: #000; text-transform: uppercase;">{{ auth()->user()->nama }}</p>
        </div>
    </div>

    <div style="background: #fff; border: 1px solid #e0e0e0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
        <div style="max-height: 600px; overflow-y: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="position: sticky; top: 0; background: #fafafa; z-index: 10; border-bottom: 1px solid #000;">
                    <tr style="text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; color: #000;">
                        <th style="padding: 18px 25px; font-weight: 800;">ID Transaksi</th>
                        <th style="padding: 18px 25px; font-weight: 800;">Waktu</th>
                        <th style="padding: 18px 25px; font-weight: 800;">Total</th>
                        <th style="padding: 18px 25px; font-weight: 800;">Status</th>
                        <th style="padding: 18px 25px; font-weight: 800; text-align: center;">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarTransaksi as $t)
                    <tr class="table-row">
                        <td style="padding: 18px 25px; font-weight: 700; font-size: 13px;">{{ $t->kode_transaksi }}</td>
                        <td style="padding: 18px 25px; color: #666; font-size: 12px; font-weight: 500;">{{ $t->created_at->format('H:i') }} — {{ $t->created_at->format('d/m/y') }}</td>
                        <td style="padding: 18px 25px; font-weight: 600; font-size: 13px;">IDR {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td style="padding: 18px 25px;">
                            @if($t->rating_skor)
                                <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 10px; font-weight: 700; color: #000; background: #e8f5e9; padding: 4px 10px; border-radius: 2px;">
                                    <div style="width: 4px; height: 4px; background: #2e7d32; border-radius: 50%;"></div> SELESAI
                                </span>
                            @else
                                <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 10px; font-weight: 700; color: #000; background: #fff3e0; padding: 4px 10px; border-radius: 2px;">
                                    <div style="width: 4px; height: 4px; background: #ef6c00; border-radius: 50%;"></div> MENUNGGU
                                </span>
                            @endif
                        </td>
                        <td style="padding: 18px 25px; text-align: center;">
                            @if(!$t->rating_skor)
                                <button onclick="openRatingModal('{{ $t->id }}', '{{ $t->kode_transaksi }}')" class="btn-action">
                                    Beri Rating
                                </button>
                            @else
                                <span class="status-label">
                                    @if($t->rating_skor == 3) PUAS 
                                    @elseif($t->rating_skor == 2) BIASA SAJA
                                    @else TIDAK PUAS @endif
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 80px; text-align: center; color: #bbb; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px;">
                            Tidak ada data transaksi ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $daftarTransaksi->links() }}
    </div>
</div>

<div id="ratingModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 9999; justify-content: center; align-items: center; backdrop-filter: blur(4px);">
    <div style="background: #fff; padding: 50px; width: 90%; max-width: 500px; text-align: center; position: relative; border: 1px solid #000;">
        <button onclick="closeRatingModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; font-weight: 300;">&times;</button>
        
        <h2 id="modalTitle" style="font-weight: 800; text-transform: uppercase; margin: 0; font-size: 22px; letter-spacing: -0.5px;"></h2>
        <p style="font-size: 11px; color: #888; font-weight: 600; text-transform: uppercase; margin: 10px 0 40px; letter-spacing: 1px;">Apakah anda puas dengan pelayanan kami?</p>
        
        <form action="{{ route('rating.store') }}" method="POST">
            @csrf
            <input type="hidden" name="transaksi_id" id="modal_transaksi_id">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <button type="submit" name="skor" value="3" class="btn-rating-opt opt-puas">Puas</button>
                
                <button type="submit" name="skor" value="2" class="btn-rating-opt opt-biasa">Biasa Saja</button>
                
                <button type="submit" name="skor" value="1" class="btn-rating-opt opt-tidakpuas">Tidak Puas</button>
            </div>
        </form>
    </div>
</div>

<style>
    div::-webkit-scrollbar { width: 4px; }
    div::-webkit-scrollbar-track { background: #f1f1f1; }
    div::-webkit-scrollbar-thumb { background: #000; }

    .table-row { border-bottom: 1px solid #f0f0f0; transition: background 0.2s ease; }
    .table-row:hover { background: #f9f9f9; }

    .btn-action {
        background: #000; 
        color: #fff; 
        border: none; 
        padding: 8px 18px; 
        font-size: 11px; 
        font-weight: 700; 
        cursor: pointer; 
        text-transform: uppercase; 
        letter-spacing: 1px;
        transition: opacity 0.2s;
    }
    .btn-action:hover { opacity: 0.8; }

    .status-label {
        font-weight: 800; 
        font-size: 10px; 
        text-transform: uppercase; 
        color: #000; 
        border-bottom: 2px solid #000;
        padding-bottom: 2px;
    }

    .btn-rating-opt {
        width: 100%; 
        padding: 16px; 
        border: 1px solid #000; 
        background: #fff;
        font-weight: 700; 
        text-transform: uppercase; 
        cursor: pointer;
        font-size: 12px; 
        letter-spacing: 1.5px; 
        transition: all 0.2s ease;
        color: #000;
    }

    .opt-puas:hover {
        background: #2e7d32;
        border-color: #2e7d32;
        color: #fff;
    }

    .opt-biasa:hover {
        background: #fbc02d; 
        border-color: #fbc02d;
        color: #fff;
    }

    .opt-tidakpuas:hover {
        background: #c62828; 
        border-color: #c62828;
        color: #fff;
    }
</style>

<script>
    function openRatingModal(id, kode) {
        document.getElementById('modal_transaksi_id').value = id;
        document.getElementById('modalTitle').innerText = kode;
        document.getElementById('ratingModal').style.display = 'flex';
    }
    function closeRatingModal() {
        document.getElementById('ratingModal').style.display = 'none';
    }
</script>
@endsection