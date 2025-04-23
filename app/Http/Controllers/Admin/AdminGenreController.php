<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminGenreDeleteRequest;
use App\Http\Requests\Admin\AdminGenreIndexRequest;
use App\Http\Requests\Admin\AdminGenreShowRequest;
use App\Http\Requests\Admin\AdminGenreStoreUpdateRequest;
use App\Http\Resources\Admin\GenreResource;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;

class AdminGenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminGenreIndexRequest $request): JsonResponse
    {
        $perPage = $request->per_page ?? 15;
        $genres = Genre::paginate($perPage);
        return response()->json($genres);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminGenreStoreUpdateRequest $request): GenreResource
    {
        $genre = Genre::create($request->validated());
        return new GenreResource($genre);
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminGenreShowRequest $request, string $id): JsonResponse
    {
        $genre = Genre::findOrFail($id);
        return response()->json($genre);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminGenreStoreUpdateRequest $request, string $id): JsonResponse
    {
        $genre = Genre::findOrFail($id);
        $genre->update($request->validated());
        return response()->json($genre);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminGenreDeleteRequest $request, string $id): JsonResponse
    {
        $genre = Genre::findOrFail($id);
        $genre->books()->detach();
        $genre->delete();
        return new JsonResponse(null, 204);
    }
}
