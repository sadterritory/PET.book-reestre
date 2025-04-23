<?php
namespace App\Services;

use App\Enums\UserRole;
use App\Interfaces\RegisterServiceInterface;
use App\Models\User;
use App\Models\Author;
use Illuminate\Support\Facades\Hash;

class RegisterService implements RegisterServiceInterface
{
    public function register(array $data): array
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => UserRole::from($data['role']),
        ]);

        if ($user->role === UserRole::AUTHOR) {
            $this->createAuthor($user, $data);
        }

        $token = $user->createToken('auth_token', ['*'], null)->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    private function createAuthor(User $user, array $data): void
    {
        Author::create([
            'user_id' => $user->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ]);
    }
}