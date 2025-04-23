<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\Admin\AdminBookIndexRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookAuthorResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminBookIndexRequest $request): AnonymousResourceCollection
    {
        $perPage = $request->per_page ?? 15;
        $books = Book::with('author')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
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
    public function update(BookUpdateRequest $request) : BookAuthorResource
    {
        $bookId = $request->validated()['id'];
        $book = Book::findOrFail($bookId);
        $book->update($request->validated());
        return new BookAuthorResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $book = Book::findOrFail($id);

        if ($book->author->user_id != auth()->id() && auth()->user()->role !== UserRole::ADMIN) {
            abort(403, 'You do not have permission to delete this book.');
        }

        $book->genres()->detach();
        $book->delete();

        return new JsonResponse(null, 204);
    }
}
