<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\Borrow;

/*
|--------------------------------------------------------------------------
| API Routes - Borrow Service (Consumer)
|--------------------------------------------------------------------------
*/

// 1. Jalur untuk melihat semua data peminjaman (GET)
Route::get('/borrows/active', function () {
    $borrows = Borrow::all();
    return response()->json([
        'status' => 'success',
        'service' => 'BorrowService (Provider)',
        'data' => $borrows
    ], 200);
});

// 2. Jalur untuk menyimpan peminjaman baru (POST)
Route::post('/borrows', function (Request $request) {

    // Validasi input dari Postman
    $request->validate([
        'user_id' => 'required',
        'book_id' => 'required',
    ]);

    // INTEGRASI EAI: Cek keberadaan Buku di BookService (Port 8001)
    $bookResponse = Http::get("http://127.0.0.1:8001/api/books/{$request->book_id}");
    // INTEGRASI EAI: Cek keberadaan User di UserService (Port 8002)
    $userResponse = Http::get("http://127.0.0.1:8002/api/users/{$request->user_id}");

    // Logika Pengecekan: Jika kedua service memberikan respon sukses (200 OK)
    if ($userResponse->successful() && $bookResponse->successful()) {

        // Simpan ke database lokal borrow_service
        $borrow = Borrow::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(7), // Otomatis pinjam 7 hari
            'status' => '1' // Status 1 = Dipinjam
        ]);

        // Mengembalikan respon sukses agar muncul di Postman
        return response()->json([
            'status' => 'success',
            'message' => 'Integrasi Berhasil: User dan Buku tervalidasi!',
            'data' => $borrow
        ], 201);
    }

    // Jika salah satu service gagal (data tidak ditemukan)
    return response()->json([
        'status' => 'error',
        'message' => 'Integrasi Gagal: User ID atau Book ID tidak ditemukan di service tujuan.',
        'debug' => [
            'user_service_status' => $userResponse->status(),
            'book_service_status' => $bookResponse->status(),
        ]
    ], 400);
});