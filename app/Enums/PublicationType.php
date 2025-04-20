<?php

namespace App\Enums;

enum PublicationType: string
{
    case Graph = 'Graphic edition';
    case Digital = 'Digital edition';
    case Printing = 'Printing edition';
}
