<?php

namespace App\Interfaces;

use App\Models\User;

interface RegisterServiceInterface
{
    public function register(array $data): array;

}
