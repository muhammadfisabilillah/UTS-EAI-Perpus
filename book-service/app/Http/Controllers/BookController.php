<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    private function bookNotFound($id)
    {
        return response()->json([
            'error' => 'Resource Not Found',
            'message' => "Book with ID #{$id} does not exist in the library."
        ], Response::HTTP_NOT_FOUND);
    }

    // Display all books
    public function index()
    {
        return response()->json(Book::all(), Response::HTTP_OK);
    }

    // Create a new book
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'isbn'         => 'required|string|unique:books,isbn',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'   => 'Validation Error',
                'message' => 'Some required fields are missing or invalid.',
                'details' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book = Book::create($validator->validated());

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
            return $this->bookNotFound($id);
        }

        return response()->json($book, Response::HTTP_OK);
    }

    // Update a book
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return $this->bookNotFound($id);
        }

        $validated = $request->validate([
            'title'        => 'sometimes|string|max:255',
            'author'       => 'sometimes|string|max:255',
            'isbn'         => 'sometimes|string|unique:books,isbn,' . $id,
            'is_available' => 'sometimes|boolean'
        ]);

        $book->update($validated);

        return response()->json([
            'message' => 'Book updated successfully',
            'data'    => $book
        ], Response::HTTP_OK);
    }

    // Delete a book
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return $this->bookNotFound($id);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ], Response::HTTP_OK);
    }
}