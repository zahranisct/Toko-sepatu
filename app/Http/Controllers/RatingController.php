<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class RatingController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $daftarTransaksi = Transaksi::where('transaksi.user_id', $userId)
            ->leftJoin('ratings', 'transaksi.id', '=', 'ratings.transaksi_id')
            ->select('transaksi.*', 'ratings.skor as rating_skor')
            ->latest('transaksi.created_at')
            ->paginate(10);

        return view('kasir.rating.index', compact('daftarTransaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required',
            'skor'         => 'required|integer|min:1|max:3',
        ]);

        $userId = Auth::id();
        $exists = DB::table('ratings')
            ->where('transaksi_id', $request->transaksi_id)
            ->exists();
        
        if (!$exists) {
            DB::table('ratings')->insert([
                'transaksi_id' => $request->transaksi_id,
                'user_id'      => $userId,
                'skor'         => $request->skor,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
            
            return redirect()->back()->with('success', 'Rating berhasil disimpan!');
        }

        return redirect()->back()->with('error', 'Transaksi ini sudah diberi rating.');
    }

    public function laporan()
    {
        $rankingKasir = DB::table('ratings')
            ->join('user', 'ratings.user_id', '=', 'user.id')
            ->select(
                'user.nama', 
                DB::raw('COUNT(ratings.id) as total_rating'),
                DB::raw('AVG(skor) as rata_rata')
            )
            ->groupBy('user.id', 'user.nama')
            ->orderBy('rata_rata', 'desc')
            ->get();
        return view('admin.rating', compact('rankingKasir'));
    }
}