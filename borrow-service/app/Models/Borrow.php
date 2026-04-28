<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Borrow extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    // Method untuk mengambil data book dari Book Service
    public function getBookData()
    {
        try {
            $response = Http::get("http://127.0.0.1:8001/api/books/{$this->book_id}");
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            return null;
        }
    }
    
    // Method untuk mengambil data user dari User Service
    public function getUserData()
    {
        try {
            $response = Http::get("http://127.0.0.1:8002/api/users/{$this->user_id}");
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
