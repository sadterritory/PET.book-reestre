<?php

namespace App\Enums;

enum PublicationType: string
{
    case GRAPHIC = 'graphic';
    case DIGITAL = 'digital';
    case PRINT = 'print';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
