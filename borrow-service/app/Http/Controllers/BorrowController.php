<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Borrow;

class BorrowController extends Controller
{
    // Ini fungsi untuk mencatat peminjaman (Consumer side)
    public function store(Request $request)
    {
        $bookResponse = Http::get("http://127.0.0.1:8001/api/books/{$request->book_id}");
        $userResponse = Http::get("http://127.0.0.1:8002/api/users/{$request->user_id}");

        // Jika user dan buku ditemukan di service mereka
        if ($userResponse->successful() && $bookResponse->successful()) {
            $borrow = Borrow::create([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'borrow_date' => now(),
            ]);
            return response()->json(['message' => 'Peminjaman Berhasil!', 'data' => $borrow], 201);
        }

        return response()->json(['message' => 'Gagal: User atau Buku tidak valid'], 400);
    }

    // Ini fungsi untuk menyediakan data histori (Provider side)
    public function getHistory($user_id)
    {
        $history = Borrow::where('user_id', $user_id)->get();
        return response()->json($history);
    }
}
