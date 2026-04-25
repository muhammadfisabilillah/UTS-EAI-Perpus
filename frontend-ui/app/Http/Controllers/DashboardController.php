<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Cek apakah memori browser (session) sudah punya data buku?
        // Kalau belum ada, kita buat data awal dan simpan ke memory.
        if (!session()->has('mock_books')) {
            $initialBooks = [
                ['id' => 1, 'title' => 'Sistem Informasi Manajemen', 'author' => 'Budi Santoso', 'stock' => 5],
                ['id' => 2, 'title' => 'Belajar Laravel 11', 'author' => 'Eko Kurniawan', 'stock' => 2],
                ['id' => 3, 'title' => 'Desain UI/UX Praktis', 'author' => 'Sena', 'stock' => 0],
            ];
            session(['mock_books' => $initialBooks]);
        }

        // 2. Ambil data dari memory browser untuk ditampilkan
        $books = session('mock_books');

        return view('dashboard', ['books' => $books]);
    }

    public function store(Request $request, $id)
    {
        // 1. Tarik data buku dari memory browser
        $books = session('mock_books');

        // 2. Cari buku mana yang di-klik berdasarkan ID, lalu kurangi stoknya 1
        foreach ($books as $key => $book) {
            if ($book['id'] == $id && $book['stock'] > 0) {
                $books[$key]['stock'] -= 1; // Logika pengurangan stok
                break;
            }
        }

        // 3. Simpan kembali data yang stoknya sudah berkurang ke memory browser
        session(['mock_books' => $books]);

        // 4. Kembalikan user ke halaman depan dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Berhasil! Buku ID ' . $id . ' dipinjam. Stok berkurang 1 (Simulasi).');
    }
}