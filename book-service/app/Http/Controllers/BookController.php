<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    // Display all books
    public function index()
    {
        return response()->json(Book::all(), Response::HTTP_OK);
    }

    // Create a new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'isbn'         => 'required|string|unique:books,isbn',
            'is_available' => 'boolean'
        ]);

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Book created successfully',
            'data'    => $book
        ], Response::HTTP_CREATED);
    }

    // Display book by ID
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'error' => 'Resource Not Found',
                'message' => "Book with ID #{$id} does not exist in the library."
            ], 404);
        }

        return response()->json($book, 200);
    }

    // Update a book
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'        => 'sometimes|string|max:255',
            'author'       => 'sometimes|string|max:255',
            'isbn'         => 'sometimes|string|unique:books,isbn,' . $book->id,
            'is_available' => 'sometimes|boolean'
        ]);

        $book->update($validated);

        return response()->json([
            'message' => 'Book updated successfully',
            'data'    => $book
        ], Response::HTTP_OK);
    }

    // Delete a book
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }
}