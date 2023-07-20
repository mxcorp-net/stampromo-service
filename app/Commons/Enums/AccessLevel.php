<?php

namespace App\Commons\Enums;

enum AccessLevel: int
{
    case NoAccess = 0;
    case ReadOnly = 1;
    case ReadUpdate = 2;
    case ReadCreateUpdate = 3;
    case FullAccess = 4;
}
