<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Psy\Util\Json;

class AuthController extends Controller
{
    public function register(Request $request) : JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'role' => 'required|string|in:' . implode(',', UserRole::values()),
        ]);
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                #Так как имеется cast в модели - может использовать from, вместо поиска по индексу
                'role' => UserRole::tryFrom($data['role']),
            ]);

            if (!$user) {
                throw new \Exception('User creation failed');
            }
            #Подразумевается, что после регистрации сразу будет выдан токен
            $token = $user->createToken('auth_token', ['*'], now()->addHour())->plainTextToken;

            return response()->json(['token' => $token], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request) : JsonResponse
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

    public function logout(Request $request) : Response
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
