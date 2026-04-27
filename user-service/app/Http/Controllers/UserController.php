<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * [GET] Menampilkan semua user dengan pagination
     */
    public function index()
    {
        return response()->json(User::paginate(10));
    }

    /**
     * [POST] Mendaftarkan user/peminjam baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'status' => 'aktif', // Default anggota baru langsung aktif
            'password' => Hash::make('password123'), // Default password
        ]);

        return response()->json([
            'message' => 'User berhasil didaftarkan',
            'data' => $user
        ], 201);
    }

    /**
     * [GET] Menampilkan detail satu user
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }
        return response()->json($user);
    }

    /**
     * [PUT] Memperbarui data atau status user
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Mengizinkan update nama, email, atau status
        $user->update($request->only(['nama', 'email', 'status']));

        return response()->json([
            'message' => 'Data user berhasil diperbarui',
            'data' => $user
        ]);
    }

    /**
     * [DELETE] Menghapus user dari sistem
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }

    /**
     * [GET] Integrasi EAI: Menggabungkan data User dengan riwayat dari Borrow Service
     */
    public function showProfile($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        try {
            // Mengambil data dari service teman (Port 8002)
            $response = Http::timeout(2)->get("http://localhost:8002/api/borrow-history/{$id}");
            $history = $response->successful() ? $response->json() : ['message' => 'Riwayat tidak ditemukan'];
        } catch (\Exception $e) {
            $history = ['message' => 'Gagal terhubung ke Borrow Service (Offline)'];
        }

        return response()->json([
            'user_data' => $user,
            'borrow_history' => $history
        ]);
    }
}