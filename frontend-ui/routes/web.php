<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Halaman Katalog Buku (Utama)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Halaman Data Anggota
Route::get('/anggota', [DashboardController::class, 'anggota'])->name('anggota');

// Halaman Riwayat Transaksi
Route::get('/transaksi', [DashboardController::class, 'transaksi'])->name('transaksi');

// Aksi proses peminjaman (POST)
Route::post('/pinjam/{id}', [DashboardController::class, 'store'])->name('book.borrow');

// Jalur untuk aksi pengembalian buku
Route::put('/transaksi/{id}/return', [App\Http\Controllers\DashboardController::class, 'returnBook'])->name('transaksi.return');

