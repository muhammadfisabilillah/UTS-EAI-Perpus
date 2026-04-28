<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Borrow;

Route::get('/borrows/active', function () {
    $data_peminjaman = Borrow::all();

    return response()->json([
        'status' => 'success',
        'service' => 'BorrowService (Provider)',
        'data' => $data_peminjaman
    ], 200);
});

Route::post('/borrows', function (Request $request) {
    $bookCheck = Http::get("http://127.0.0.1:8001/api/books/{$request->book_id}");
    $userCheck = Http::get("http://127.0.0.1:8002/api/users/{$request->user_id}");

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
