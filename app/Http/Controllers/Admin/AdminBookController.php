<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookIndexRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Resources\Admin\BookStoreResource;
use App\Http\Resources\AuthorBookCountResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BookIndexRequest $request): JsonResponse
    {
        $query = Book::with(['author', 'genres']);

        if ($request->has('search')) {
            $query->where('book_title', 'like', "%{$request->get('search')}%");
        }

        if ($request->has('author_id')) {
            $query->where('author_id', $request->get('author_id'));
        }

        if ($request->has('genres')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->whereIn('id', $request->genres);
            });
        }

        $sortField = $request->sort_by ?? 'title';
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
    public function show(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorUpdateRequest $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
