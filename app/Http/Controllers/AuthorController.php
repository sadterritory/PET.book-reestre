<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Resources\AuthorBookResource;
use App\Http\Resources\AuthorBookCountResource;
use App\Models\Author;
use App\Models\User;
use App\Services\AuthorUpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class AuthorController extends Controller
{

    public function __construct(private AuthorUpdateService $authorService)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index(AuthorIndexRequest $request): AnonymousResourceCollection
    {
        $perPage = $request->per_page ?? 15;
        $authors = Author::withCount('books')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        return AuthorBookCountResource::collection($authors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): AuthorBookResource
    {
        $authors = Author::with('books')->findOrFail($id);
        return new AuthorBookResource($authors);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorUpdateRequest $request, string $id)
    {
        $author = $this->authorService->updateAuthor($request->validated(), $id);
        return new AuthorBookResource($author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
