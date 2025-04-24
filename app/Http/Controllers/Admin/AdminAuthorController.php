<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAuthorDeleteRequest;
use App\Http\Requests\Admin\AdminAuthorIndexRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Resources\AuthorBookCountResource;
use App\Http\Resources\AuthorBookResource;
use App\Models\Author;
use App\Services\AuthorUpdateService;
use App\Services\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminAuthorController extends Controller
{

    public function __construct(private AuthorUpdateService $authorService, private RegisterService $registerService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(AdminAuthorIndexRequest $request): AnonymousResourceCollection
    {
        $perPage = $request->perPage ?? 15;
        $authors = Author::withCount('books')
            ->paginate($perPage);
        return AuthorBookCountResource::collection($authors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthRegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->registerService->register($request->validated());
            return response()->json(['token' => $result['token']], 201);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Registration failed'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::findOrFail($id);
        return new AuthorBookResource($author);
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
    public function destroy(AdminAuthorDeleteRequest $request, string $id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return response()->noContent();
    }
}
