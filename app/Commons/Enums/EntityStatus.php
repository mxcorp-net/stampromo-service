<?php

namespace App\Commons\Enums;

enum EntityStatus: int
{
    case Archive = -1;
    case Disable = 0;
    case Enable = 1;
}
