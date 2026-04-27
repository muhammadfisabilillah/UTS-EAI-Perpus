<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Menampilkan daftar user (Pagination)
Route::get('/users', [UserController::class, 'index']);

// Menambahkan user baru
Route::post('/users', [UserController::class, 'store']);

// Menampilkan detail satu user
Route::get('/users/{id}', [UserController::class, 'show']);

// Update data atau status user
Route::put('/users/{id}', [UserController::class, 'update']);

// Menghapus user
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Integrasi (Consumer Profile)
Route::get('/users/{id}/profile', [UserController::class, 'showProfile']);