<?php

use ArchTech\Enums\Values;

enum Status: int
{
    use Values;

    case ACTIVE = 1;
    case INACTIVE = 2;
    case SUSPENDED = 3;
}
