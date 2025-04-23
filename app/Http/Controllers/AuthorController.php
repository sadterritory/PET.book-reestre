<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Resources\AuthorBookResource;
use App\Http\Resources\AuthorBookCountResource;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


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
    public function show(string $id) : AuthorBookResource
    {
        $authors = Author::with('books')->findOrFail($id);
        return new AuthorBookResource($authors);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorUpdateRequest $request, string $id) : AuthorBookResource
    {
        $author = Author::findOrFail($id);
        $author->update($request->validated());
        $user = User::findOrFail($author->user_id);

        if(isset($request->validated()['email']) && $author->user_id) {

            if($user->email !== $request->validated()['email']) {
                $user->email = $request->validated('email');
                $user->save();

                \Log::info('User email updated', [
                    'user_id' => $user->id,
                    'old_email' => $user->getOriginal('email'),
                    'new_email' => $request->validated()['email']
                ]);

            }
        }
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
