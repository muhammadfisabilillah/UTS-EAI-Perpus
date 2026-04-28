@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>📝 Riwayat Peminjaman Buku</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Data ini ditarik secara real-time dari <b>Borrow Service</b>.</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>User ID</th>
                    <th>Book ID</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td>TRX-{{ str_pad($t['id'], 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $t['user_id'] }}</td>
                        <td>{{ $t['book_id'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($t['borrow_date'])->format('d M Y') }}</td>
                        <td>
                            {{-- Trik: Jika status ADA ISINYA (apapun itu), anggap sedang dipinjam --}}
                            @if(!empty($t['status']))
                                <span style="color: #d97706; font-weight: bold;">Sedang Dipinjam</span>
                            @else
                                <span style="color: #059669; font-weight: bold;">Sudah Dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">
                            Belum ada riwayat transaksi di database.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection