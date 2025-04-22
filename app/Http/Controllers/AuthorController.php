<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Resources\AuthorBookResource;
use App\Http\Resources\AuthorBookCountResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : AnonymousResourceCollection
    {
        $authors = Author::withCount('books')
            ->orderBy('id', 'desc')
            ->paginate(5);
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
    public function show(string $id)
    {
        $authors = Author::with('books')->findOrFail($id);
        return new AuthorBookResource($authors);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorUpdateRequest $request, string $id)
    {
        $author = Author::findOrFall($id);
        $author->update($request->validated());
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
