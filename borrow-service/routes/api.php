<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Borrow; // <--- WAJIB ADA BARIS INI ANJG BIAR GAK ERROR

// 1. PROVIDER (Poin Penilaian 25%)
Route::get('/borrows/active', function () {
    $data_peminjaman = Borrow::all();

    return response()->json([
        'status' => 'success',
        'service' => 'BorrowService (Provider)',
        'data' => $data_peminjaman
    ], 200);
});

// 2. CONSUMER (Poin Penilaian 30%)
Route::post('/borrows', function (Request $request) {
    // Komunikasi Service-to-Service [cite: 12, 14]
    $userCheck = Http::get("http://localhost:8000/api/users/{$request->user_id}");
    $bookCheck = Http::get("http://localhost:8001/api/books/{$request->book_id}");

    if ($userCheck->successful() && $bookCheck->successful()) {
        $data = Borrow::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => now(),
            'status' => 'dipinjam'
        ]);
        return response()->json(['message' => 'Berhasil!', 'data' => $data], 201);
    }

    return response()->json(['message' => 'Gagal: User atau Buku tidak valid'], 404);
});
