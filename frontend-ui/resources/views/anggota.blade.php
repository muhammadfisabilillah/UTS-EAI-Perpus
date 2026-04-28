@extends('layouts.app')

@section('title', 'Data Anggota')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>👥 Daftar Anggota Perpustakaan</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Data ini ditarik langsung dari <b>User Service</b>.</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama Anggota</th>
                    <th>Role/Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        {{-- Menampilkan ID asli dari database --}}
                        <td>{{ $u['id'] }}</td>
                        
                        {{-- Menampilkan Nama (cek 'name' atau 'nama' dari JSON temanmu) --}}
                        <td><b>{{ $u['name'] ?? $u['nama'] ?? 'Tanpa Nama' }}</b></td>
                        
                        <td>
                            <span style="color: #059669; font-weight: bold;">
                                {{-- Menampilkan role, jika kosong default ke Mahasiswa Aktif --}}
                                {{ $u['role'] ?? 'Mahasiswa Aktif' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px;">
                            Gagal menarik data atau database User Service kosong.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection