<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminBookIndexRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\Admin\BookStoreResource;
use App\Http\Resources\BookAuthorResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class AdminBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminBookIndexRequest $request): JsonResponse
    {
        $query = Book::with(['author', 'genres']);

        if ($request->has('search')) {
            $query->where('book_title', 'like', "%{$request->get('search')}%");
        }

        if ($request->has('first_name') || $request->has('last_name')) {
            $query->whereHas('author', function($q) use ($request) {
                if ($request->has('first_name')) {
                    $q->where('first_name', '=', "{$request->first_name}");
                }
                if ($request->has('last_name')) {
                    $q->where('last_name', '=', "{$request->last_name}");
                }
            });
        }

        if ($request->has('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('edition', $request->genre);
            });
        }

        $sortField = $request->sort_by ?? 'book_title';
        $sortOrder = $request->sort_order ?? 'asc';

        $query->orderBy($sortField, $sortOrder);

        $perPage = $request->per_page ?? 15;
        $books = $query->paginate($perPage);

        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request): BookStoreResource
    {
        $book = Book::create($request->validated());
        return new BookStoreResource($book);
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
    public function update(BookUpdateRequest $request, string $id): BookAuthorResource
    {
        $book = Book::findOrFail($id);
        $book->update($request->validated());
        return new BookAuthorResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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
