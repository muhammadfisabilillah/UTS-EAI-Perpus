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
        // Ambil data buku dari BookService (Teman B) - port 8001
        $bookResponse = Http::get("http://localhost:8001/api/books/{$request->book_id}");
        // Ambil data user dari UserService (Teman A) - port 8002
        $userResponse = Http::get("http://localhost:8002/api/users/{$request->user_id}");

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
