<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Perpustakaan') - EAI UTS</title>
    <style>
        /* Reset & Global */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; min-height: 100vh; }
        
        /* Sidebar Samping */
        .sidebar { width: 250px; background-color: #1e293b; color: white; padding: 20px; display: flex; flex-direction: column; }
        .sidebar h2 { font-size: 1.2rem; margin-bottom: 30px; text-align: center; color: #38bdf8; letter-spacing: 1px; }
        .nav-item { display: block; padding: 12px 15px; margin-bottom: 10px; color: #cbd5e1; text-decoration: none; border-radius: 6px; transition: 0.3s; }
        .nav-item:hover, .nav-item.active { background-color: #334155; color: white; }
        
        /* Area Konten Utama */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        
        /* Kotak Putih (Card) */
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .card-header { border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .card-header h3 { color: #333; }
        
        /* Tabel & Tombol Global */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; padding: 12px; text-align: left; }
        th { background-color: #f8fafc; color: #475569; font-weight: 600; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: 0.2s; }
        .btn-primary { background-color: #0ea5e9; color: white; }
        .btn-primary:hover { background-color: #0284c7; }
        .btn-success { background-color: #10b981; color: white; }
        .btn-success:disabled { background-color: #9ca3af; cursor: not-allowed; }
        .alert-success { padding: 15px; background-color: #d1fae5; color: #065f46; border-radius: 6px; margin-bottom: 20px; }
        .alert-error { padding: 15px; background-color: #fee2e2; color: #991b1b; border-radius: 6px; margin-bottom: 20px; }
    </style>
</head>
<body>

   <div class="sidebar">
        <h2>📚 EAI-PERPUS</h2>
        
        <a href="{{ route('dashboard') }}" class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
            📦 Katalog Buku
        </a>
        <a href="{{ route('anggota') }}" class="nav-item {{ Route::is('anggota') ? 'active' : '' }}">
            👥 Data Anggota
        </a>
        <a href="{{ route('transaksi') }}" class="nav-item {{ Route::is('transaksi') ? 'active' : '' }}">
            📝 Riwayat Transaksi
        </a>
    </div>

    <div class="main-content">
        @yield('content') 
    </div>

</body>
</html>