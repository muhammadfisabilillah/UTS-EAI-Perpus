<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat 1.000 data user secara otomatis
        User::factory(1000)->create();

        // Menambahkan 1 data khusus untuk bahan demo UTS kamu
        User::create([
            'nama' => 'Rizky Ramadhan (Admin Test)',
            'email' => 'rizky@perpus.com',
            'status' => 'aktif',
            'password' => bcrypt('password123'),
        ]);
    }
}