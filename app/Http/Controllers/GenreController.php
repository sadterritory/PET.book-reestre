<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreIndexRequest;
use App\Http\Resources\GenreBookResource;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GenreIndexRequest $request) : AnonymousResourceCollection
    {
        $perPage = $request->per_page ?? 15;
        $authors = Genre::withCount('books')
            ->paginate($perPage);
        return GenreBookResource::collection($authors);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
