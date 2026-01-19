<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardKasirController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\ViewStokController;

Route::get('/', function () {
    return redirect('/login');
});

// =======================================================
// AUTHENTICATION (Login & Logout)
// =======================================================
// Saya beri nama 'login' DAN 'login.page' agar tidak ada error RouteNotFound
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::get('/login-page', [AuthController::class, 'loginView'])->name('login.page'); 

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================================================
// ADMIN AREA (Hanya bisa diakses Admin)
// =======================================================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    // KATEGORI
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // PRODUK
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/edit/{produk}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/update/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.delete');

    // KASIR (Kelola User Kasir)
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::get('/kasir/create', [KasirController::class, 'create'])->name('kasir.create');
    Route::post('/kasir/store', [KasirController::class, 'store'])->name('kasir.store');
    Route::get('/kasir/edit/{id}', [KasirController::class, 'edit'])->name('kasir.edit');
    Route::put('/kasir/update/{id}', [KasirController::class, 'update'])->name('kasir.update');
    Route::delete('/kasir/delete/{id}', [KasirController::class, 'destroy'])->name('kasir.delete');

    // LAPORAN
    Route::get('/admin/laporan', [LaporanTransaksiController::class, 'index'])->name('admin.laporan');
    Route::get('/admin/laporan/cetak', [LaporanTransaksiController::class, 'cetak'])->name('admin.laporan.cetak');
});

// =======================================================
// KASIR AREA (Hanya bisa diakses Kasir)
// =======================================================
Route::middleware(['auth', 'kasir'])->group(function () {
    Route::get('/kasir/dashboard', [DashboardKasirController::class, 'index'])->name('kasir.dashboard');

    // TRANSAKSI
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/tambah/{id}', [TransaksiController::class, 'tambahKeranjang'])->name('keranjang.tambah');
    Route::post('/transaksi/update-item', [TransaksiController::class, 'updateQty'])->name('transaksi.updateItem');
    Route::delete('/transaksi/hapus-item/{id}', [TransaksiController::class, 'hapusItem'])->name('keranjang.hapus');
    Route::post('/transaksi/hapus-masal', [TransaksiController::class, 'hapusMasal'])->name('keranjang.hapusMasal');
    
    Route::get('/transaksi/pembayaran', [TransaksiController::class, 'pembayaran'])->name('transaksi.pembayaran');
    Route::post('/transaksi/simpan', [TransaksiController::class, 'simpanTransaksi'])->name('transaksi.simpan');
    
    // RIWAYAT TRANSAKSI
    Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('riwayat.index');

    // VIEW STOK (Fitur Baru Kasir)
    Route::get('/kasir/stok', [ViewStokController::class, 'index'])->name('kasir.viewstok');
});

// =======================================================
// AREA BERSAMA (Admin & Kasir BISA AKSES)
// =======================================================
Route::middleware(['auth'])->group(function () {
    // Cetak Struk
    Route::get('/riwayat/{id}/struk', [TransaksiController::class, 'struk'])->name('transaksi.struk');
});