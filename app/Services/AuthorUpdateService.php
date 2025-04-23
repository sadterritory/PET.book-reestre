<?php

namespace App\Services;

use App\Interfaces\AuthorUpdateServiceInterface;
use App\Models\Author;
use App\Models\User;

class AuthorUpdateService implements AuthorUpdateServiceInterface
{
    public function updateAuthor(array $data, string $id) : Author
    {
        $author = Author::findOrFail($id);
        $author->update($data);

        if ($user = User::find($author->user_id)) {
            if (isset($data['email']) && $user->email !== $data['email']) {
                $user->update(['email' => $data['email']]);

                \Log::info('User email updated', [
                    'user_id' => $user->id,
                    'old_email' => $user->getOriginal('email'),
                    'new_email' => $data['email']
                ]);
            }
        }

        return $author;
    }
}
