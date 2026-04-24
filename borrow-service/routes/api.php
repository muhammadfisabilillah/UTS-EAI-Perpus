<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// 1. ENDPOINT PROVIDER (Menyediakan data transaksi aktif)
Route::get('/borrows/active', function () {
    // Data statis (hardcoded) sebagai pengganti database
    $data_peminjaman = [
        ['id_pinjam' => 'TRX-001', 'user_id' => 1, 'book_id' => 101, 'status' => 'dipinjam'],
        ['id_pinjam' => 'TRX-002', 'user_id' => 2, 'book_id' => 102, 'status' => 'dipinjam'],
    ];

    return response()->json([
        'status' => 'success',
        'data' => $data_peminjaman
    ], 200);
});

// 2. ENDPOINT CONSUMER (Menerima request peminjaman baru)
Route::post('/borrows', function (Request $request) {
    $user_id = $request->input('user_id');
    $book_id = $request->input('book_id');

    // Nanti logika untuk menembak API User Service dan Book Service menggunakan
    // \Illuminate\Support\Facades\Http diletakkan di sini.

    return response()->json([
        'message' => 'Endpoint consumer untuk meminjam buku sedang dibangun',
        'input' => [
            'user_id' => $user_id,
            'book_id' => $book_id
        ]
    ], 200);
});
