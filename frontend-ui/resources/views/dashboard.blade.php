@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Daftar Katalog Buku</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Data ini ditarik langsung dari <b>Book Service (Port 8001)</b>.</p>
        </div>

            <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Status</th> {{-- Kolom ke-4 --}}
                <th>Aksi Peminjaman</th> {{-- Kolom ke-5 --}}
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book['id'] }}</td> {{-- Kolom 1 --}}
                <td><b>{{ $book['title'] }}</b></td> {{-- Kolom 2 --}}
                <td>{{ $book['author'] }}</td> {{-- Kolom 3 --}}
                
                {{-- Kolom 4: Isi Status --}}
                <td>
                    @if($book['is_available'] > 0)
                        <span style="color: green; font-weight: bold;">Tersedia ({{ $book['is_available'] }})</span>
                    @else
                        <span style="color: red; font-weight: bold;">Kosong</span>
                    @endif
                </td>

                {{-- Kolom 5: Isi Aksi (Form Pinjam) --}}
                <td>
                    <form action="{{ route('book.borrow', $book['id']) }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                        @csrf
                        
                        @if(isset($users) && count($users) > 0)
                            <select name="user_id" required {{ $book['is_available'] <= 0 ? 'disabled' : '' }} style="padding: 6px; border-radius: 4px; border: 1px solid #cbd5e1;">
                                <option value="">-- Pilih Peminjam --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user['id'] }}">{{ $user['nama'] ?? $user['name'] }}</option>
                                @endforeach
                            </select>
                        @endif

                        <button type="submit" class="btn btn-success" {{ $book['is_available'] <= 0 ? 'disabled' : '' }}>
                            Pinjam
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

@endsection