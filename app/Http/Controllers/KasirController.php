<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $kasir = Kasir::orderBy('nama_kasir');

        if ($request->filled('keyword')) {
            $kasir->where(function ($q) use ($request) {
                $q->where('nama_kasir', 'like', '%' . $request->keyword . '%')
                  ->orWhere('nomor_hp', 'like', '%' . $request->keyword . '%')
                  ->orWhere('alamat', 'like', '%' . $request->keyword . '%');
            });
        }

        return view('admin.kasir.index', ['kasir' => $kasir->get()]);
    }

    public function create()
    {
        return view('admin.kasir.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kasir' => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:user,username',
            'password'   => 'required|min:6',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'nama'     => $request->nama_kasir,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'role'     => 'kasir',
                ]);

                Kasir::create([
                    'user_id'    => $user->id,
                    'nama_kasir' => $request->nama_kasir,
                    'nomor_hp'   => $request->nomor_hp,
                    'alamat'     => $request->alamat,
                    'status'     => 'aktif',
                ]);
            });

            return redirect()->route('kasir.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kasir = Kasir::with('user')->findOrFail($id);
        return view('admin.kasir.edit', compact('kasir'));
    }

    public function update(Request $request, $id)
    {
        $kasir = Kasir::findOrFail($id);
        
        $request->validate([
            'nama_kasir' => 'required|string|max:255',
            'username'   => 'required|string|unique:user,username,' . $kasir->user_id,
            'status'     => 'required|in:aktif,nonaktif',
        ]);

        try {
            DB::transaction(function () use ($request, $kasir) {
                if ($kasir->user) {
                    $kasir->user->update([
                        'nama'     => $request->nama_kasir,
                        'username' => $request->username,
                    ]);

                    if ($request->filled('password')) {
                        $kasir->user->update(['password' => Hash::make($request->password)]);
                    }
                }

                $kasir->update([
                    'nama_kasir' => $request->nama_kasir,
                    'nomor_hp'   => $request->nomor_hp,
                    'alamat'     => $request->alamat,
                    'status'     => $request->status,
                ]);
            });

            return redirect()->route('kasir.index')->with('success', 'Data diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $kasir = Kasir::findOrFail($id);
        DB::transaction(function () use ($kasir) {
            User::where('id', $kasir->user_id)->delete();
            $kasir->delete();
        });
        return redirect()->route('kasir.index')->with('success', 'Data dihapus.');
    }
}