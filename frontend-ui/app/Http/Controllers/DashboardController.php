<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Wajib ada untuk nembak API

class DashboardController extends Controller
{
    /**
     * Halaman Utama: Menampilkan Buku (dari Book Service) 
     * & Dropdown User (dari User Service)
     */
    public function index()
    {
        // Ambil data buku
        $responseBooks = Http::get('http://127.0.0.1:8001/api/books');
        $books = $responseBooks->json();

        // Ambil data user
        $responseUsers = Http::get('http://127.0.0.1:8002/api/users');
        
        // Pastikan kita ambil 'data'-nya saja jika API temanmu membungkusnya dalam folder 'data'
        $userData = $responseUsers->json();
        
        // TRICK: Kita pastikan $users adalah array yang benar
        $users = is_array($userData) && isset($userData['data']) ? $userData['data'] : $userData;

        return view('dashboard', compact('books', 'users'));
    }

    /**
     * Halaman Anggota: Menampilkan Data User (dari User Service)
     */
    public function anggota()
    {
        try {
            // Ambil data dari User Service (8002) lewat jalur GET /users
            $response = Http::get('http://127.0.0.1:8002/api/users');

            if ($response->successful()) {
                $userData = $response->json();
                
                // Cek: Jika data dibungkus dalam key 'data' (karena biasanya pakai pagination/resource)
                // Kalau isinya langsung list, dia akan ambil $userData langsung
                $users = isset($userData['data']) ? $userData['data'] : $userData;
            } else {
                $users = [];
            }
        } catch (\Exception $e) {
            $users = [];
        }

        return view('anggota', compact('users'));
    }

    // --- KODINGAN LAMA (HAPUS/GANTI BAGIAN INI) ---
    public function transaksi()
    {
        try {
            $response = Http::get('http://127.0.0.1:8003/api/borrows/active');

            if ($response->successful()) {
                $transactions = $response->json()['data'];
            } else {
                $transactions = [];
            }
        } catch (\Exception $e) {
            $transactions = [];
        }

        return view('transaksi', ['transactions' => $transactions]);
    }


    /**
     * Aksi Meminjam: UI mengirim perintah ke Borrow Service (Orkestrator)
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        try {
            // UI menyerahkan urusan peminjaman sepenuhnya ke Borrow Service (Port 8003)
            // Borrow Service-lah yang nanti akan mengecek User Service dan memotong stok di Book Service
            $response = Http::post('http://127.0.0.1:8003/api/borrows', [
                'user_id' => $request->user_id,
                'book_id' => $id
            ]);

            if ($response->successful()) {
                return redirect()->route('dashboard')->with('success', 'Peminjaman berhasil!');
            } else {
                // DON'T use $response->body() here if it might return a full HTML page
                // Just use a short message or the status code
                $errorMessage = "Server Error (Status: " . $response->status() . ")";
                return redirect()->route('dashboard')->with('error', 'Gagal meminjam: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Borrow Service sedang tidak aktif!');
        }
    }

    public function returnBook(Request $request, $id)
    {
        // 1. Update Borrow Service (Status & Tanggal Kembali)
        $borrowRes = Http::put("http://127.0.0.1:8003/api/borrows/{$id}", [
            'status' => 'returned',
            'return_date' => now()->toDateString() // Mengirim tanggal hari ini (YYYY-MM-DD)
        ]);

        // 2. Update Book Service (Available: 1)
        $bookRes = Http::put("http://127.0.0.1:8001/api/books/{$request->book_id}", [
            'is_available' => 1
        ]);

        if ($borrowRes->successful() && $bookRes->successful()) {
            return redirect()->back()->with('success', 'Buku dikembalikan & status returned!');
        }

        return redirect()->back()->with('error', 'Gagal update data.');
    }
}