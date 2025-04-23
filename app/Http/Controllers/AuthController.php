<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\Author;
use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct(
        private RegisterService $registerService) {}

    public function register(AuthRegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->registerService->register($request->validated());
            return response()->json(['token' => $result['token']], 201);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Registration failed'], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw \Dotenv\Exception\ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        #Тут можно удалять все токены, оставляя один, чтобы только 1 пользователь мог быть аутентифицирован
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
