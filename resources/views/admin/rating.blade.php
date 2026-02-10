@extends('layouts.app')

@section('page_title', 'Rating Pelayanan')

@section('content')
<div style="padding: 40px; font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; min-height: 100vh; color: #000;">
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; border-bottom: 2px solid #000; padding-bottom: 20px;">
        <div>
            <h1 style="font-weight: 800; font-size: 28px; letter-spacing: -0.5px; margin: 0; text-transform: uppercase;">
                Leaderboard Performa Kasir
            </h1>
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #666; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">
                Analisis Kepuasan Pelanggan & Ranking Pelayanan Petugas
            </p>
        </div>
        <div style="text-align: right;">
            <p style="margin: 0; font-size: 10px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 1px;">Total Penilaian</p>
            <p style="margin: 0; font-size: 15px; font-weight: 700; color: #000; text-transform: uppercase;">{{ $rankingKasir->sum('total_rating') }} Feedback</p>
        </div>
    </div>

    <div style="background: #fff; border: 1px solid #e0e0e0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
        <div style="max-height: 600px; overflow-y: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="position: sticky; top: 0; background: #fafafa; z-index: 10; border-bottom: 1px solid #000;">
                    <tr style="text-transform: uppercase; font-size: 11px; letter-spacing: 1.5px; color: #000;">
                        <th style="padding: 20px 25px; width: 80px;">Rank</th>
                        <th style="padding: 20px 25px;">Nama Kasir</th>
                        <th style="padding: 20px 25px;">Total Feedback</th>
                        <th style="padding: 20px 25px;">Skor Rata-Rata</th>
                        <th style="padding: 20px 25px;">Indikator Performa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rankingKasir as $index => $r)
                    <tr class="table-row">
                        <td style="padding: 20px 25px;">
                            <span style="font-weight: 800; font-size: 18px; color: {{ $index == 0 ? '#000' : '#ccc' }}">
                                #{{ $index + 1 }}
                            </span>
                        </td>
                        <td style="padding: 20px 25px;">
                            <div style="font-weight: 700; font-size: 14px; text-transform: uppercase;">{{ $r->nama }}</div>
                        </td>
                        <td style="padding: 20px 25px; font-weight: 600; color: #666;">
                            {{ $r->total_rating }} Transaksi
                        </td>
                        <td style="padding: 20px 25px;">
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <span style="font-weight: 800; font-size: 16px;">{{ number_format($r->rata_rata, 1) }}</span>
                                <span style="font-size: 12px; color: #999;">/ 3.0</span>
                            </div>
                        </td>
                        <td style="padding: 20px 25px;">
                            @php
                                $percentage = ($r->rata_rata / 3) * 100;
                                $color = $r->rata_rata >= 2.5 ? '#00df82' : ($r->rata_rata >= 1.8 ? '#fbc02d' : '#ff4d4d');
                            @endphp
                            <div style="width: 100%; height: 6px; background: #f0f0f0; border-radius: 10px; overflow: hidden; max-width: 150px;">
                                <div style="width: {{ $percentage }}%; height: 100%; background: {{ $color }}; transition: width 0.5s ease;"></div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 80px; text-align: center; color: #bbb; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px;">
                            Belum ada data penilaian dari kasir.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <div style="border: 1px solid #000; padding: 20px; background: #fff;">
            <p style="margin: 0; font-size: 10px; font-weight: 800; color: #999; text-transform: uppercase; letter-spacing: 1px;">Kualitas Tertinggi</p>
            <p style="margin: 10px 0 0 0; font-size: 16px; font-weight: 800;">{{ $rankingKasir->first()->nama ?? '-' }}</p>
        </div>
        <div style="border: 1px solid #000; padding: 20px; background: #000; color: #fff;">
            <p style="margin: 0; font-size: 10px; font-weight: 800; color: #666; text-transform: uppercase; letter-spacing: 1px;">Update Terakhir</p>
            <p style="margin: 10px 0 0 0; font-size: 16px; font-weight: 800;">{{ now()->format('d M Y') }}</p>
        </div>
    </div>
</div>

<style>
    div::-webkit-scrollbar { width: 4px; }
    div::-webkit-scrollbar-track { background: #f1f1f1; }
    div::-webkit-scrollbar-thumb { background: #000; }

    .table-row { border-bottom: 1px solid #f0f0f0; transition: background 0.2s ease; }
    .table-row:hover { background: #f9f9f9; }
</style>
@endsection