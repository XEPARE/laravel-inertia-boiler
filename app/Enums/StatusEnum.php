<?php

namespace App\Enums;

use ArchTech\Enums\Values;
use ArchTech\Enums\Names;

enum StatusEnum: int
{
    use Values, Names;

    case ACTIVE = 1;
    case INACTIVE = 2;
    case SUSPENDED = 3;

}
