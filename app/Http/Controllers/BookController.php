<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\BookDestroyRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookAuthorResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $books = Book::with('author')
            ->orderBy('id', 'desc')
            ->paginate(5);
        return BookAuthorResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request): JsonResponse
    {
        return response()->json(Book::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): BookAuthorResource
    {
        $book = Book::with('author')->findOrFail($id);
        return new BookAuthorResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, string $id) : BookAuthorResource
    {
        $bookId = $request->validated()['id'];
        $book = Book::findOrFail($bookId);
        $book->delete();
        return new BookAuthorResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): BookAuthorResource|JsonResponse
    {
        $book = Book::find($id);
        if (!$book) {
            abort(404, 'Book not found');
        }
        if ((string)$book->author->user_id == (string)auth()->id() || auth()->user()->role === UserRole::ADMIN) {
            $book->genres()->detach();
            $book->delete();
            return new BookAuthorResource($book);
        } else {
            return response()->json(['message' => 'You do not have permission to delete this book.'], 403);
        }
    }
}
