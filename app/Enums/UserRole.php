<?php

namespace App\Enums;

enum UserRole : string
{
    case AUTHOR = 'author';

    case ADMIN = 'admin';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
