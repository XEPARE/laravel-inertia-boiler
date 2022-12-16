<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum StatusEnum: int
{
    use Values;

    case ACTIVE = 1;
    case INACTIVE = 2;
    case SUSPENDED = 3;

}
