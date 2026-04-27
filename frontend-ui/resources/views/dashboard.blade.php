<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard EAI Perpustakaan</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #f9f9f9; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .btn { padding: 5px 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:disabled { background-color: #ccc; cursor: not-allowed; }
    </style>
</head>
<body>

<div class="container">
    <h2>📚 Dashboard Admin Perpustakaan</h2>
    <p>Data di bawah ini nantinya akan ditarik dari <b>Book Service</b>.</p>

    @if(session('success'))
        <div style="padding: 15px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book['id'] }}</td>
                <td>{{ $book['title'] }}</td>
                <td>{{ $book['author'] }}</td>
                <td>
                    @if($book['stock'] > 0)
                        <span style="color: green; font-weight: bold;">Tersedia ({{ $book['stock'] }})</span>
                    @else
                        <span style="color: red; font-weight: bold;">Habis</span>
                    @endif
                </td>
                
                <td>
                    <form action="{{ route('book.borrow', $book['id']) }}" method="POST">
                        @csrf
                        <button class="btn" {{ $book['stock'] == 0 ? 'disabled' : '' }}>
                            Pinjam
                        </button>
                    </form>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>