<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    // Tambahkan ini agar database mengizinkan input data
    protected $fillable = ['user_id', 'book_id', 'borrow_date', 'status'];
}
