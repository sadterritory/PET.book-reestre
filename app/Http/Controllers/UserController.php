<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class UserController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

    }

    public function update(UserUpdateRequest $request) : UserResource
    {
        $userId = $request->validated()['id'];
        $user = User::findOrFail($userId);
        $user->update($request->validated());
        return new UserResource($user);
    }
}
