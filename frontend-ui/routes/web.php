<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Halaman utama SEKARANG SUDAH DIBERI NAMA 'dashboard'
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Aksi meminjam
Route::post('/pinjam/{id}', [DashboardController::class, 'store'])->name('book.borrow');